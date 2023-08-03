<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Producao;
use App\Entidy\Receber;
use App\Session\Login;

Login::requireLogin();

$res = "";

$condicoes = [
    strlen($inicio) ? "date(e.data) between date('$inicio') AND date('$fim')"   : null,
    strlen($rota) ? "r.id =" . $rota : null,
    strlen($entregador) ? "et.id =" . $entregador : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$listar = Producao::getList(
    'e.data as data,
    et.apelido AS entregador,
    c.nome as cliente,
    r.nome as rota,
    rg.nome as regiao,
    sum(rc.qtd) as total',
    ' producao AS p
    INNER JOIN
    entregadores AS et ON (p.entregadores_id = et.id)
    INNER JOIN
    rotas AS r ON (p.rotas_id = r.id) 
    INNER JOIN
    regioes AS rg ON (p.regioes_id = rg.id) 
    INNER JOIN
    receber AS rc ON (p.receber_id = rc.id) 
    INNER JOIN
    entrega AS e ON (e.producao_id = p.id) 
    INNER JOIN
    clientes AS c ON (c.id = rc.clientes_id)',
    $where,
    'r.nome',
    'total DESC',
    null
);

$porecentagem = 0;
$total_percet = 0;
$total = 0;
$qtd = 0;
$cor = "";
$bed = "";

$total_absoluto = Receber::getTotal('e.data as data,
et.apelido AS entregador,
c.nome as cliente,
r.nome as rota,
rg.nome as regiao,
sum(rc.qtd) as total ', 'producao AS p
INNER JOIN
entregadores AS et ON (p.entregadores_id = et.id)
INNER JOIN
rotas AS r ON (p.rotas_id = r.id) 
INNER JOIN
regioes AS rg ON (p.regioes_id = rg.id) 
INNER JOIN
receber AS rc ON (p.receber_id = rc.id) 
INNER JOIN
entrega AS e ON (e.producao_id = p.id) 
INNER JOIN
clientes AS c ON (c.id = rc.clientes_id)', $where, null, null, null);

$resul_total = $total_absoluto->total;

foreach ($listar as $item) {

    $qtd = $item->total;

    $total += $item->total;

    $porecentagem = round(($qtd / $resul_total * 100), 1);

    $total_percet += $porecentagem;

    $res .= '
<tr>

<td style="text-transform: uppercase;font-size:10px"><span>' . $item->rota . '</span></td>
<td style="text-transform: uppercase;font-size:10px">' . $item->entregador . '</td>
<td style="text-transform: uppercase;font-size:10px">' . $item->cliente . '</td>
<td style="font-size:10px">' . $item->total . '</td>
<td style="font-size:10px">' . $porecentagem . ' %</td>
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

    <title>Rotas</title>


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

                <th style="width: 280px; font-size:10px">ROTAS</th>
                <th style="font-size:10px">ENTREGADORES</th>
                <th style="font-size:10px">CLIENTES</th>
                <th style="font-size:10px">QTD</th>
                <th style="width: 40px;font-size:10px">PERCENTUAL</th>
            </tr>


            <?= $res ?>

            <tr style="background-color: #000; color:#fff">
                <td colspan="3">TOTAL</td>
                <td><?= $total ?></td>
                <td><?= $total_percet ?> %</td>
            </tr>

        </tbody>
    </table>

</body>

</html>3