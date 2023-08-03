<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Receber;
use \App\Session\Login;

$usuariologado = Login::getUsuarioLogado();

$usuarios_nome = $usuariologado['nome'];
$usuarios_email = $usuariologado['email'];

$total = 0;
$total_sub = 0;
$total_qtd = 0;
$total_disp = 0;

Login::requireLogin();

$dataInicio;
$dataFim;


if ($entregadores_id == "") {

    $var1 = "";
} else {

    $var1 =  "AND r.entregadores_id =" . $entregadores_id . "";
}

if ($ocorrencias_id == "") {

    $var2 = "";
} else {

    $var2 =  "AND r.ocorrencias_id =" . $ocorrencias_id . "";
}

if ($tipo_id == "") {

    $var3 = "";
} else {

    $var3 =  "AND r.tipo_id =" . $tipo_id . "";
}

if ($gaiolas_id == "") {

    $var4 = "";
} else {

    $var4 =  "AND r.gaiolas_id =" . $gaiolas_id . "";
}


$consulta = "r.data between ' " . $dataInicio . " ' AND ' " . $dataFim . " ' " . $var1 . " " . $var2 . " " . $var3 . " " . $var4;

$res = "";

$listar = Receber::getList(
    'r.id AS id, r.producao_id AS producao_id, r.entregadores_id AS entregadores_id,
r.ocorrencias_id AS ocorrencias_id, r.tipo_id AS tipo_id, r.gaiolas_id AS gaiolas_id,
r.data AS data, r.qtd AS qtd, e.apelido AS entregadores,o.nome AS ocorrencias,
t.nome AS tipo,g.nome AS gaiolas,dv.receber_id AS receber_id',
    'retorno AS r INNER JOIN producao AS p ON (r.producao_id = p.id)
                            INNER JOIN entregadores AS e ON (r.entregadores_id = e.id)
                            INNER JOIN ocorrencias AS o ON (r.ocorrencias_id = o.id)
                            INNER JOIN tipo AS t ON (r.tipo_id = t.id)
                            INNER JOIN gaiolas AS g ON (r.gaiolas_id = g.id)
                            INNER JOIN divgaiolas AS dv ON (r.gaiolas_id = dv.gaiolas_id)',
    $consulta,
    'r.data ASC',
    null
);

foreach ($listar as $item) {

   
    $total_sub += $item->qtd;

    $res .= '   <tr>
                    <td style="text-transform:uppercase">' . date('d/m/Y  Á\S  H:i:s', strtotime($item->data)) . '</td>
                    <td style="text-align:left">' . $item->ocorrencias . '</td>
                    <td style="text-transform:uppercase;text-align:left"> <h5><span class="badge badge-pill badge-light"> <i class="fa fa-motorcycle" aria-hidden="true"></i> &nbsp;' . $item->entregadores . '</span></h5> </td>
                    <td style="text-align:left">' . $item->tipo . '</td>
                    <td>' . $item->gaiolas . '</td>
                    <td>' . $item->qtd . '</td>
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

    <title>Devolucao</title>
</head>

<body>

    <table style="margin-top: -40px;">
        <tbody>
            <tr style="background-color: #fff; color:#000">

                <td style="text-align: left; width:260px; border:1px solid #fff; ">
                    <span style="margin-left:110px; margin-top: -50px; font-size:small">Montenegro express </span><br>
                    <span style="margin-left:110px; margin-top: -30px; font-size:xx-small ">Email:&nbsp; <?= $usuarios_email  ?> </span><br>
                    <span style="margin-left:110px; margin-top: -30px; font-size:xx-small">Atendente:&nbsp; <?= $usuarios_nome  ?> </span><br>
                    <img style="width:108px; height:40px; float:left;margin-top:-50px; padding:10px; margin-left:-12px;" src="../../02.jpg">
                    <br />
                    <br />

                </td>
                <td style="text-align:center; font-weight:600; font-size:16px; border:1px solid #fff;">• LISTA DE DEVOLUÇÕES •</td>
                <td style="text-align:right; border:1px solid #fff;margin-left:-10">
                    <?php echo "Data: " . date('d/m/Y', strtotime($dataInicio));
                    echo " á " . date('d/m/Y', strtotime($dataFim))  ?><br></td>

            </tr>
        </tbody>
    </table>


    <table>
        <tbody>
            <tr style="background-color:#3ae210; color:#fff">
                <td style="text-align: center; text-transform:uppercase" colspan="6">Lista de itens devolvidos</td>
            </tr>

            <tr style="background-color: #000; color:#fff">

                <td> DATA </td>
                <td style="text-align:left"> OCORRÊNCIAS </td>
                <td style="text-align:left"> ENTREGADORES </td>
                <td style="text-align:left"> TIPO </td>
                <td> GAIOLAS </td>
                <td> QUANTIDADE </td>
              
            
            </tr>

            <?= $res ?>

             <tr>

             <td colspan="5" style="text-align:right;">
                <span style="text-transform: uppercase;"> Quantidade total</span>
             </td>
             <td>
                 <?= $total_sub ?>
             </td>
             </tr>
           


        </tbody>
    </table>

</body>

</html>