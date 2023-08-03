<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Producao;
use App\Session\Login;

Login::requireLogin();

$res = "";

$inicio;
$fim;
$entregador;

$total_entrega = 0;
$total_devolucao = 0;
$qtd = 0;
$qtd1 = 0;
$qtd2 = 0;
$soma1 = 0;
$soma2 = 0;
$qtd2 = 0;
$total = 0;
$valor1 = 0;
$valor2 = 0;
$result = 0;
$entrega = 0;
$devolucao = 0;

$condicoes = [
    strlen($inicio) ? "date(ed.data) between date('$inicio') AND date('$fim')"   : null,
    strlen($entregador) ? "p.entregadores_id =" . $entregador : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$listar = Producao::getList(
    '    ed.id AS id, p.servicos_id AS servicos_id,
    UPPER(et.apelido) AS apelido,
    UPPER(st.nome) AS setores,
    (CASE
    WHEN p.servicos_id = 1 THEN "PEQUENO VOLUME"
    WHEN p.servicos_id = 5 THEN "GRANDE VOLUNE"
    ELSE "MÉDIO"
END) volume,
   ed.entrega AS entrega,
   ed.devolucao AS devolucao,
   et.valor_pequeno as pequeno,
   et.valor_grande as grande',
    ' entrega_devolucao AS ed
    INNER JOIN
entregadores AS et ON (ed.entregadores_id = et.id)
    INNER JOIN
producao AS p ON (ed.producao_id = p.id)
    INNER JOIN
setores AS st ON (p.setores_id = st.id)
    INNER JOIN
servicos AS sv ON (p.servicos_id = sv.id)',
    $where,
    null,
    'ed.data ASC',
    null
);


foreach ($listar as $item) {

    if ($item->entrega == null) {

        $item->entrega = 0;
    }
    if ($item->devolucao == null) {

        $item->devolucao = 0;
    }

    if ($item->servicos_id == 1) {

        $pequeno = $item->pequeno;
        if ($item->entrega != null) {

            $qtd1  = $item->entrega * $pequeno;
            $result = $qtd1;
        } else {

            $qtd2  = $item->devolucao * $pequeno;
            $result = $qtd2;
        }

        $total_entrega += $item->entrega;
        $total_devolucao += $item->devolucao;
    } else {


        $grande = $item->grande;

        if ($item->entrega != null) {

            $qtd1  = $item->entrega * $grande;
            $result = $qtd1;
        } else {

            $qtd2  = $item->devolucao * $grande;
            $result = $qtd2;
        }

        $total_entrega += $item->entrega;
        $total_devolucao += $item->devolucao;
    }

    $total += ($qtd1 - $qtd2);



    $res .= '
<tr>

<td style="text-transform:uppercase;font-size:12px">' . $item->apelido . '</td>
<td style="text-transform:uppercase;font-size:12px">' . $item->setores . '</td>
<td style="text-transform:uppercase;font-size:12px">' . $item->volume . '</td>
<td style="text-align:center;font-size:12px">' . $item->entrega . '</td>
<td style="text-align:center;font-size:12px">' . $item->devolucao . '</td>
<td style="text-align:center;font-size:12px">R$ ' . number_format($result, "2", ",", ".")  . '</td>
</tr>
';
}


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
                <td style="font-size:12px">Vencimento:<?= date('d/m/Y', strtotime($inicio)) ?> à
                    <?= date('d/m/Y', strtotime($fim)) ?></td>
            </tr>
        </tbody>
    </table>



    <table>
        <tbody>
            <tr style="background-color: #000; color:#fff">

                <th style="width: 10px; font-size:12px">ENTREGADORES</th>
                <th style="font-size:12px;text-align:center">SETORES</th>
                <th style="font-size:12px;text-align:center">VOLUME</th>
                <th style="font-size:12px;text-align:center">ENTREGA</th>
                <th style="font-size:12px;text-align:center">DEVOLUÇÃO</th>
                <th style="font-size:12px;text-align:center">TOTAL</th>
            </tr>


            <?= $res ?>

            <tr style="background-color: #000; color:#fff">
                <td colspan="3" style="font-size:12px">TOTAL</td>
                <td style="text-align:center; background-color:green;font-size:12px">
                    <?= $total_entrega ?></td>
                <td style="text-align:center; background-color:red;font-size:12px "><?= $total_devolucao ?> </td>
                <td style="text-align:center; background-color:#3778b1;font-size:12px">
                    R$ <?= number_format($total, "2", ",", ".") ?> </td>
            </tr>

        </tbody>
    </table>

</body>

</html>