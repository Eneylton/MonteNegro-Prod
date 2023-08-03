<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Cliente;
use App\Session\Login;

Login::requireLogin();

$res = "";

$condicoes = [
    strlen($cliente) ? "r.clientes_id =" . $cliente : null,
    strlen($setor) ? "s.id =" . $setor : null,
    strlen($mes) ? "MONTH(r.data) =" . $mes : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$listar = Cliente::getList(
    ' c.id AS id, c.nome AS nome, s.nome AS setor, sum(r.qtd ) as qtd',
    'clientes AS c
    INNER JOIN
setores AS s ON (c.setores_id = s.id)
    INNER JOIN
receber AS r ON (r.clientes_id = c.id)',
    $where,
    'c.nome',
    null,
    null
);

$porecentagem = 0;
$total_percet = 0;
$total = 0;
$qtd = 0;
$cor = "";
$bed = "";

$total_absoluto = Cliente::getTotal('sum(r.qtd) as total', 'clientes AS c
INNER JOIN
setores AS s ON (c.setores_id = s.id)
INNER JOIN
receber AS r ON (r.clientes_id = c.id)');

$resul_total = $total_absoluto->total;

foreach ($listar as $item) {

    $qtd = $item->qtd;

    $total += $item->qtd;

    $porecentagem = round(($qtd / $resul_total * 100), 1);

    $total_percet += $porecentagem;


    $res .= '
<tr>
<td style="width:530px"><span>' . $item->nome . '</span> &nbsp; / &nbsp; <span style="color:#787878; font-size:14px">' . $item->setor . '</span></td>
<td style="width:100px" class="centro">' . $item->qtd . '</td>
<td>' . $porecentagem . ' %</td>
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

    <title>Clientes</title>


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
                <td class="td2">Data: São luís 23/03/2021</td>
            </tr>
        </tbody>
    </table>



    <table>
        <tbody>
            <tr style="background-color: #000; color:#fff">
                <td>CLIENTE</td>
                <td>QTD</td>
                <td>PERCENTUAL</td>
            </tr>

            <?= $res ?>

            <tr style="background-color: #000; color:#fff">
                <td>TOTAL</td>
                <td><?= $total ?></td>
                <td><?= $total_percet ?> %</td>
            </tr>

        </tbody>
    </table>

</body>

</html>