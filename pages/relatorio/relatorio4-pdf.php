<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Producao;
use App\Session\Login;

Login::requireLogin();

$res = "";
$inicio = "";
$fim = "";
$data = "";
$setor = "";
$entregador = "";
$status = 1;
$total_entrega = 0;
$total_devolucao = 0;
$qtd = 0;
$cor = "";
$bed = "";
$jan = 0;
$fer = 0;
$mar = 0;
$abr = 0;
$mai = 0;
$jun = 0;
$jul = 0;
$ago = 0;
$ste = 0;
$otb = 0;
$nov = 0;
$dez = 0;
$total = 0;

if (isset($_POST['dataInicio'])) {
    $inicio = $_POST['dataInicio'];
} else {
    $inicio = null;
}

if (isset($_POST['dataFim'])) {
    $fim = $_POST['dataFim'];
} else {
    $fim = null;
}

if (isset($_POST['setor_id'])) {
    $setor = $_POST['setor_id'];
} else {
    $setor = null;
}

if (isset($_POST['entregador_id'])) {
    $entregador = $_POST['entregador_id'];
} else {
    $entregador = null;
}


$condicoes = [
    strlen($inicio) ? "date(p.data) between date('$inicio') AND date('$fim')"   : null,
    strlen($setor) ? "p.setores_id =" . $setor : null,
    strlen($entregador) ? "p.entregadores_id =" . $entregador : null
];


$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$listar = Producao::getList(
    ' DISTINCT et.apelido as entregador,s.nome as setor,
    SUM(CASE
        WHEN MONTH(e.data) = 1 THEN e.qtd
        ELSE NULL
    END) AS jan,
    SUM(CASE
        WHEN MONTH(e.data) = 2 THEN e.qtd
        ELSE NULL
    END) AS fer,
    SUM(CASE
        WHEN MONTH(e.data) = 3 THEN e.qtd
        ELSE NULL
    END) AS mar,
    SUM(CASE
        WHEN MONTH(e.data) = 4 THEN e.qtd
        ELSE NULL
    END) AS abr,
    SUM(CASE
        WHEN MONTH(e.data) = 5 THEN e.qtd
        ELSE NULL
    END) AS mai,
    SUM(CASE
        WHEN MONTH(e.data) = 6 THEN e.qtd
        ELSE NULL
    END) AS jun,
    SUM(CASE
        WHEN MONTH(e.data) = 7 THEN e.qtd
        ELSE NULL
    END) AS jul,
    SUM(CASE
        WHEN MONTH(e.data) = 8 THEN e.qtd
        ELSE NULL
    END) AS ago,
    SUM(CASE
        WHEN MONTH(e.data) = 9 THEN e.qtd
        ELSE NULL
    END) AS ste,
    SUM(CASE
        WHEN MONTH(e.data) = 10 THEN e.qtd
        ELSE NULL
    END) AS otb,
    SUM(CASE
        WHEN MONTH(e.data) = 11 THEN e.qtd
        ELSE NULL
    END) AS nov,
    SUM(CASE
        WHEN MONTH(e.data) = 12 THEN e.qtd
        ELSE NULL
    END) AS dez, sum(e.qtd) as total',
    '  entrega AS e
    INNER JOIN
producao AS p ON (p.id = e.producao_id)
    INNER JOIN
setores AS s ON (p.setores_id = s.id)
    INNER JOIN
entregadores AS et ON (e.entregadores_id = et.id)',
    $where,
    'et.apelido, s.nome',
    'et.apelido ASC',
    null
);

foreach ($listar as $item) {

    $jan += $item->jan;
    $fer += $item->fer;
    $mar += $item->mar;
    $abr += $item->abr;
    $mai += $item->mai;
    $jun += $item->jun;
    $jul += $item->jul;
    $ago += $item->ago;
    $ste += $item->ste;
    $otb += $item->otb;
    $nov += $item->nov;
    $dez += $item->dez;
    $total += $item->total;

    $res .= '
<tr>

<td style="font-size:12px; text-transform:uppercase; text-align:left">' . $item->entregador . '</td>
<td style="font-size:12px; text-transform:uppercase; text-align:left">' . $item->setor . '</td>
<td style="text-transform:uppercase; text-align:center">' . $item->jan . '</td>
<td style="text-transform:uppercase; text-align:center">' . $item->fer . '</td>
<td style="text-transform:uppercase; text-align:center">' . $item->mar . '</td>
<td style="text-transform:uppercase; text-align:center">' . $item->abr . '</td>
<td style="text-transform:uppercase; text-align:center">' . $item->mai . '</td>
<td style="text-transform:uppercase; text-align:center">' . $item->jun . '</td>
<td style="text-transform:uppercase; text-align:center">' . $item->jul . '</td>
<td style="text-transform:uppercase; text-align:center">' . $item->ago . '</td>
<td style="text-transform:uppercase; text-align:center">' . $item->ste . '</td>
<td style="text-transform:uppercase; text-align:center">' . $item->otb . '</td>
<td style="text-transform:uppercase; text-align:center">' . $item->nov . '</td>
<td style="text-transform:uppercase; text-align:center">' . $item->dez . '</td>
<td style="text-transform:uppercase; text-align:center">' . $item->total . '</td>
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

    <title>Crosstab Producao geral</title>


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

                <th style="font-size:12px">ENTREGADOR</th>
                <th style="font-size:12px">SETORES</th>
                <th style="font-size:12px;text-align:center">JAN</th>
                <th style="font-size:12px;text-align:center">FEV</th>
                <th style="font-size:12px;text-align:center">MAR</th>
                <th style="font-size:12px;text-align:center">ABR</th>
                <th style="font-size:12px;text-align:center">MAI</th>
                <th style="font-size:12px;text-align:center">JUN</th>
                <th style="font-size:12px;text-align:center">JUL</th>
                <th style="font-size:12px;text-align:center">AGO</th>
                <th style="font-size:12px;text-align:center">SET</th>
                <th style="font-size:12px;text-align:center">OUT</th>
                <th style="font-size:12px;text-align:center">NOV</th>
                <th style="font-size:12px;text-align:center">DEZ</th>
                <th style="font-size:12px;text-align:center">TOTAL</th>
            </tr>


            <?= $res ?>

            <tr>
                <th colspan="2" style="text-align: center;">TOTAL</th>

                <th style="text-align: center;"><?= $jan ?></th>
                <th style="text-align: center;"><?= $fer ?></th>
                <th style="text-align: center;"><?= $mar ?></th>
                <th style="text-align: center;"><?= $abr ?></th>
                <th style="text-align: center;"><?= $mai ?></th>
                <th style="text-align: center;"><?= $jun ?></th>
                <th style="text-align: center;"><?= $jul ?></th>
                <th style="text-align: center;"><?= $ago ?></th>
                <th style="text-align: center;"><?= $ste ?></th>
                <th style="text-align: center;"><?= $otb ?></th>
                <th style="text-align: center;"><?= $nov ?></th>
                <th style="text-align: center;"><?= $dez ?></th>
                <th class="centro" style="color:green;font-size:20px;text-align: center;"><?= $total ?></th>

            </tr>

        </tbody>
    </table>

</body>

</html>3