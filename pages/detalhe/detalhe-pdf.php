<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Producao;
use \App\Session\Login;

$usuariologado = Login::getUsuarioLogado();

$usuarios_nome = $usuariologado['nome'];
$usuarios_email = $usuariologado['email'];

Login::requireLogin();

$res = "";

if (isset($_GET['id']) or is_numeric($_GET['id'])) {

    $id = $_GET['id'];
}

$entregadores = Producao::getList('  p.id AS id,
                                     e.apelido AS entregador,
                                     et.data AS data_entrega,
                                     dev.data AS data_devolucao,
                                     et.qtd AS entrega,
                                     dev.qtd AS devolucao','producao AS p
                                     INNER JOIN
                                     entrega AS et ON (p.id = et.producao_id)
                                     LEFT JOIN
                                     devolucao AS dev ON (p.id = dev.producao_id)
                                     INNER JOIN
                                     entregadores AS e ON (p.entregadores_id = e.id)','p.entregadores_id='.$_GET['id']);

$sub_total = 0;
$sub = 0;
$bruto = 0;
$calc = 0;

foreach ($entregadores as $item) {

    $sub_total = $item->entrega;
    $sub =   $sub_total * 2;
    $calc += $sub;
    $bruto += $sub_total;

    $res .= '   <tr>
                
                        <td style="text-align:left">' . $item->codigo . '</td>
                        <td style="text-align:left;width:231px">' . date('d/m/Y', strtotime($item->data_entrega)) . '</td>
                        <td style="text-align:left;width:231px">' . date('d/m/Y', strtotime($item->data_devolucao)) . '</td>
                        <td style="text-align:left">' . $item->entrega . '</td>
                        <td style="text-align:left">' . $item->devolucao . '</td>
                        <td style="text-align:left">' . $sub_total . '</td>
                        <td style="text-align:left; width:50px">R$ ' . number_format($sub, "2", ",", ".") . '</td>
                        
                        
    
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

        th {
            text-transform: uppercase;
        }

        table,
        th,
        td {
            font-size: xx-small;
            border: 1px solid #555555;
            border-collapse: collapse;
            text-align: center;
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

    <title>Producao</title>
</head>

<body>

    <table style="margin-top: -40px;">
        <tbody>
            <tr style="background-color: #fff; color:#000">

                <td style="text-align: left; width:260px; border:1px solid #fff; ">
                    <span style="margin-left:126px; margin-top: -50px; font-size:small">Monte negro express </span><br>
                    <span style="margin-left:126px; margin-top: -30px; font-size:xx-small ">Email:&nbsp; <?= $usuarios_email  ?> </span><br>
                    <span style="margin-left:126px; margin-top: -30px; font-size:xx-small">Atendente:&nbsp; <?= $usuarios_nome  ?> </span><br>
                    <img style="width:120px; height:50px; float:left;margin-top:-50px; padding:10px; margin-left:-12px;" src="../../02.jpeg">
                    <br />
                    <br />

                </td>
                <td style="text-align:center; font-weight:600; font-size:16px; border:1px solid #fff;">• LISTA DE PRODUÇÃO •</td>
                <td style="text-align:right; border:1px solid #fff;">Data de Emissão: <?php echo date("d/m/Y") ?><br></td>

            </tr>
        </tbody>
    </table>


    <table>
        <tbody>
            <tr style="background-color:#08aa13; color:#fff">
                <td style="text-align: center; text-transform:uppercase" colspan="9">PRODUÇÃO</td>
            </tr>

            <tr style="background-color: #000; color:#fff">

                <td style="text-align:left;">CÓDIGO</td>
                <td style="text-align:left;">ENTREGADOR</td>
                <td style="text-align:left;">DATA</td>
                <td style="text-align:left;">ENTREGA</td>
                <td style="text-align:left;">DEVOLUÇÃO</td>
                <td style="text-align:left;">SUCESSO</td>
                <td style="text-align:left;">SALDO</td>

            </tr>

            <?= $res ?>

            <tr style="background-color: #555555; color:#fff">
                <td colspan="5" style="text-align: right;">
                    TOTAL
                </td>
                <td style="text-align: left;">
                    <?= $bruto ?>
                </td>
                <td style="text-align: left;">
                    R$ <?= number_format($calc, "2", ",", ".") ?>
                </td>
            </tr>


        </tbody>
    </table>

</body>

</html>