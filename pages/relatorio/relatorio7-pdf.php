<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Producao;
use App\Session\Login;

Login::requireLogin();

$res = "";

$id =  $id_param;

$condicoes = [
    strlen($inicio) ? "date(p.data) between date('$inicio') AND date('$fim')"   : null,
    strlen($cliente) ? "r.clientes_id =" . $cliente : null,
    strlen($entregador) ? "p.entregadores_id =" . $entregador : null,
    strlen($id) ? "r.id =" . $id  : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$listar = Producao::getList(
    'p.id AS id,
	p.data AS data,
    r.id AS codigo,
    c.nome AS nome,
    st.nome AS setores,
    et.apelido AS entregadores,
    SUM(ed.entrega) AS entrega,
    SUM(ed.devolucao) AS devolucao',
    ' producao AS p
    INNER JOIN
entrega_devolucao AS ed ON (p.id = ed.producao_id)
    INNER JOIN
receber AS r ON (p.receber_id = r.id)
    INNER JOIN
clientes AS c ON (r.clientes_id = c.id)
    INNER JOIN
entregadores AS et ON (p.entregadores_id = et.id)
  INNER JOIN
setores AS st ON (p.setores_id = st.id)',
    $where,
    'et.apelido',
    'et.apelido ASC',
    null
);

$soma = 0;
$total_entrega = 0;
$total_devolucao = 0;
$total = 0;
$qtd = 0;
$calculo = 0;
$cor = "";
$bed = "";
$texto = "";
$texto2 = "";

foreach ($listar as $item) {

    $total_entrega += $item->entrega;
    $total_devolucao += $item->devolucao;

    $calculo = $item->entrega + $item->devolucao;

    if ($item->devolucao == null) {

        $texto = "<span style='color:#ff0000'> 0</span>";
    } else {
        $texto = $item->devolucao;
    }


    if ($item->entrega == null) {

        $texto2 = "<span style='color:#178f0f'> 0</span>";
    } else {
        $texto2 = $item->entrega;
    }

    $res .= '
<tr>

<td style="text-transform:uppercase">' . $item->nome . '</td>
<td style="text-transform:uppercase">' . $item->setores . '</td>
<td style="text-transform:uppercase">' . $item->entregadores . '</td>
<td style="text-align:center">' . $texto2 . '</td>
<td style="text-align:center">' . $texto . '</td>
<td style="text-align:center">' . $calculo . '</td>
</tr>
';
}

$soma  = $total_entrega + $total_devolucao;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
    @page {
        margin: 70px 0;
    }

    body {
        margin: 0;
        padding: 0;
        font-family: "Open Sans", sans-serif;
    }

    .header {
        position: fixed;
        top: -70px;
        left: 0;
        right: 0;
        width: 100%;
        text-align: center;
        background-color: #555555;
        padding: 10px;
    }

    .header img {
        width: 160px;
    }

    .footer {
        bottom: -27px;
        left: 0;
        width: 100%;
        padding: 5px 10px 10px 10px;
        text-align: center;
        background: #555555;
        color: #fff;
    }

    .footer .page:after {
        content: counter(page);
    }

    table {
        width: 100%;
        border: 1px solid #555555;
        margin: 0;
        padding: 0;
    }

    .table2 {

        width: 100%;
        margin: 0;
        padding: 0;
        background: #fff;

    }

    th {
        text-transform: uppercase;
    }

    .td2 {

        border: 1px solid #ffffff;
        border-collapse: collapse;
        text-align: left;
        padding: 5px;

    }

    table,
    th,
    td {
        border: 1px solid #d1d1d1;
        border-collapse: collapse;
        text-align: left;
        padding: 5px;

    }

    tr:nth-child(2n+0) {
        background: #eeeeee;
    }

    p {
        color: #888888;
        margin: 0;
        text-align: center;
    }

    h2 {
        text-align: center;
    }
    </style>

    <title>Entregas / Devolucoes</title>


</head>

<body>


    <table class="table2">
        <tbody>
            <tr>
                <td class="td2">

                    <img src="../../02.jpeg" style="width: 140px; height:60px; margin-top:-30px;">

                </td>
                <td class="td2"><span>MONTENEGRO EXPRESS </span> <br /> <span
                        style="color: #555555;">montnegro@gmail.com - (xx) xxxx-xxxx</span></td>
                <td class="td2">Emissão:<?php echo date('d/m/Y') ?></td>
            </tr>
        </tbody>
    </table>



    <table>
        <tbody>
            <tr style="background-color: #000; color:#fff">

                <th style="width: 10px">CLIENTES</th>
                <th>SETORES</th>
                <th class="">ENTREGADORES</th>
                <th class="centro">ENTREGA</th>
                <th class="centro">DEVOLUÇÃO</th>
                <th class="centro">TOTAL</th>
            </tr>


            <?= $res ?>

            <tr style="background-color: #000; color:#fff">
                <td colspan="3">TOTAL</td>
                <td style="text-align:center; background-color:green"><?= $total_entrega
                                                                        ?></td>
                <td style="text-align:center; background-color:red "><?= $total_devolucao ?> </td>
                <td style="text-align:center; background-color:#3778b1 "><?= $soma ?> </td>
            </tr>

        </tbody>
    </table>

</body>

</html>3