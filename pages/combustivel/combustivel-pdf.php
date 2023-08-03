<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Combustivel;
use App\Entidy\Receber;
use \App\Session\Login;

$usuariologado = Login::getUsuarioLogado();

$usuarios_nome = $usuariologado['nome'];
$usuarios_email = $usuariologado['email'];

$cli = "";
$total = 0;
$total_sub = 0;
$total_qtd = 0;
$total_disp = 0;
$disp = 0;

Login::requireLogin();

$dataInicio;
$dataFim;
$contador = 0;
$entregadores_id;


if ($entregadores_id == "") {

    $var1 = "";
} else {

    $var1 =  "AND c.entregadores_id =" . $entregadores_id . "";
}


$consulta = "c.data between ' " . $dataInicio . " ' AND ' " . $dataFim . " ' " . $var1 . "";

$res = "";

$listar = Combustivel::getList(
    'c.id AS id,c.data as data,
      c.placa as placa,
      v.nome as veiculo,
      et.apelido as entregador,
      c.valor as valor',
    'combustivel AS c
      INNER JOIN
      veiculos AS v ON (v.id = c.veiculos_id) 
      INNER JOIN
      entregadores AS et ON (et.id = c.entregadores_id)',
    $consulta,
    null,
    'c.data ASC',
    null
);

foreach ($listar as $item) {

    $total_disp += $item->valor;

    $res .= '   <tr>
    <td style="text-align:left">' . $item->id . '</td>
    <td style="text-align:left">' .  date('d/m/Y', strtotime($item->data))  . '</td>
    <td style="text-align:left">' . $item->veiculo . '</td>
    <td style="text-align:left">' . $item->placa . '</td>
    <td style="text-transform:uppercase;text-align:left">' . $item->entregador . '</td>
    <td style="text-transform:uppercase;text-align:left">R$ ' . number_format($item->valor, "2", ",", ".") . '</td>
  
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

    <title>Receber itens</title>
</head>

<body>

    <table style="margin-top: -40px;">
        <tbody>
            <tr style="background-color: #fff; color:#000">

                <td style="text-align: left; width:260px; border:1px solid #fff; ">
                    <span style="margin-left:110px; margin-top: -50px; font-size:small">Montenegro express </span><br>
                    <span style="margin-left:110px; margin-top: -30px; font-size:xx-small ">Email:&nbsp;
                        <?= $usuarios_email  ?> </span><br>
                    <span style="margin-left:110px; margin-top: -30px; font-size:xx-small">Atendente:&nbsp;
                        <?= $usuarios_nome  ?> </span><br>
                    <img style="width:108px; height:40px; float:left;margin-top:-50px; padding:10px; margin-left:-12px;"
                        src="../../02.jpeg">
                    <br />
                    <br />

                </td>
                <td style="text-align:center; font-weight:600; font-size:16px; border:1px solid #fff;">• RELATÓRIO TOTAL
                    DE COMBUSTIVEL •</td>
                <td style="text-align:right; border:1px solid #fff;margin-left:-10">
                    <?php echo "Data: " . date('d/m/Y', strtotime($dataInicio));
                    echo " á " . date('d/m/Y', strtotime($dataFim))  ?><br></td>

            </tr>
        </tbody>
    </table>


    <table style="margin-top:-10px;">
        <tbody>

            <tr style="background-color:#fff; color:#000;border-color:1px solid #fff; ">

                <td style="text-align: lefet; text-transform:uppercase; font-size:15px;border-color:1px solid #fff;"
                    colspan="5"><?= $cli ?></td>
            </tr>
            <tr style="background-color:#d10d0d; color:#fff;border-color:1px solid #fff;">
                <td style="text-align: center; text-transform:uppercase; border-color:1px solid #fff;" colspan="6">TOTAL
                    DE COMBUSTIVEIS</td>
            </tr>

            <tr>
                <td style="text-align: left; width:80px"> CÓDIGO </td>
                <td style="text-align:left"> DATA</td>
                <td style="text-align:left"> VEÍCULO</td>
                <td style="text-align:left"> PLACA</td>
                <td style="text-align:left"> ENTREGADOR</td>
                <td style="text-align:left"> VALOR </td>

            </tr>

            <?= $res ?>


            <tr>
                <td colspan="5" style="text-align: right;">
                    <span style="font-size: 15px;">TOTAL RECEBIDO</span>
                </td>

                <td style="text-align:left; font-size: 15px; color:crimson">
                    <span>R$ <?= number_format($total_disp, "2", ",", ".") ?></span>
                </td>
            </tr>


        </tbody>
    </table>

</body>

</html>