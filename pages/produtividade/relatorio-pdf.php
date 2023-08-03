<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Registro;
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

$listar = Registro::getList(
    'u.nome as funcionarios,
    sum(r.qtd) as total,
    RANK() OVER (
        ORDER BY total desc
    ) ranque',
    'registros AS r
    INNER JOIN
    usuarios AS u ON (r.usuarios_id = u.id)',
    $where,
    'u.nome',
    'total desc',
    null
);

$porecentagem = 0;
$total_percet = 0;
$total = 0;
$qtd = 0;
$cor = "";
$bed = "";

$total_absoluto = Registro::getTotal('sum(r.qtd) as total ', 'registros as r');

$resul_total = $total_absoluto->total;

foreach ($listar as $item) {

    $qtd = $item->total;

    $total += $item->total;

    $porecentagem = round(($qtd / $resul_total * 100), 1);

    $total_percet += $porecentagem;

    if ($qtd >= 5 && $qtd <= 9) {

        $star = '
        <img src="../../imgs/estrela.png" style="width:20px; 20px">
        <img src="../../imgs/estrela1.png" style="width:20px; 20px">
        <img src="../../imgs/estrela1.png" style="width:20px; 20px">
        <img src="../../imgs/estrela1.png" style="width:20px; 20px">
        <img src="../../imgs/estrela1.png" style="width:20px; 20px">
        ';
    } else if ($qtd  >= 10 && $qtd <= 14) {

        $star = '
        <img src="../../imgs/estrela.png" style="width:20px; 20px">
        <img src="../../imgs/estrela.png" style="width:20px; 20px">
        <img src="../../imgs/estrela1.png" style="width:20px; 20px">
        <img src="../../imgs/estrela1.png" style="width:20px; 20px">
        <img src="../../imgs/estrela1.png" style="width:20px; 20px">
            
            ';
    } else if ($qtd >= 15 && $qtd <= 19) {

        $star = '
        <img src="../../imgs/estrela.png" style="width:20px; 20px">
        <img src="../../imgs/estrela.png" style="width:20px; 20px">
        <img src="../../imgs/estrela.png" style="width:20px; 20px">
        <img src="../../imgs/estrela1.png" style="width:20px; 20px">
        <img src="../../imgs/estrela1.png" style="width:20px; 20px">
            
            ';
    } else if ($qtd >= 20 && $qtd <= 24) {

        $star = '
        <img src="../../imgs/estrela.png" style="width:20px; 20px">
        <img src="../../imgs/estrela.png" style="width:20px; 20px">
        <img src="../../imgs/estrela.png" style="width:20px; 20px">
        <img src="../../imgs/estrela.png" style="width:20px; 20px">
        <img src="../../imgs/estrela1.png" style="width:20px; 20px">
            
            ';
    } else if ($qtd >= 25) {

        $star = '
        <img src="../../imgs/estrela.png" style="width:20px; 20px">
        <img src="../../imgs/estrela.png" style="width:20px; 20px">
        <img src="../../imgs/estrela.png" style="width:20px; 20px">
        <img src="../../imgs/estrela.png" style="width:20px; 20px">
        <img src="../../imgs/estrela.png" style="width:20px; 20px">
            
            ';
    } else {

        $star = '
        <img src="../../imgs/estrela1.png" style="width:20px; 20px">
        <img src="../../imgs/estrela1.png" style="width:20px; 20px">
        <img src="../../imgs/estrela1.png" style="width:20px; 20px">
        <img src="../../imgs/estrela1.png" style="width:20px; 20px">
        <img src="../../imgs/estrela1.png" style="width:20px; 20px">
            
            ';
    }

    switch ($item->ranque) {
        case '1':
            $foto = "01.jpg";
            break;

        case '2':
            $foto = "02.jpg";
            break;

        case '3':
            $foto = "03.jpg";
            break;

        default:
            $foto = "04.jpg";
            break;
    }




    $res .= '
<tr>
<td ><img src="../../imgs/' . $foto . '" style="width:50px; 50px"></td>
<td style="text-transform:uppercase;"><span>' . $item->funcionarios  . '</span></span></td>
<td style="text-align:center">' . $item->total . '</td>
<td style="text-align:center"><span style="font-size:14px" class="badge ' . $bed . '">' . $porecentagem . ' %</span></td>
<td>
    <div >
        ' . $star . '
    </div>
</td>
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

    <title>Produtividade</title>


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
                <th style="width: 10px">RANK</th>
                <th style="width: 320px">FUNCIONÁRIOS</th>
                <th class="centro">QTD</th>
                <th>PERCENTUAL</th>
                <th class="centro">PROGRESSO</th>
            </tr>

            <?= $res ?>

            <tr style="background-color: #000; color:#fff">
                <th colspan="2" style="text-align:center">TOTAL</th>
                <th style="text-align:center"><?= $total ?></th>
                <th style="text-align:center"><span>
                        <?= $total_percet ?> %</span>
                </th>
                <th class="centro">PROGRESSO</th>
            </tr>

        </tbody>
    </table>

</body>

</html>