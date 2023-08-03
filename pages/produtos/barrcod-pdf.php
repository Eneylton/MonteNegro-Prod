<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Produto;
use \App\Session\Login;

$usuariologado = Login::getUsuarioLogado();

$usuarios_nome = $usuariologado['nome'];
$usuarios_email = $usuariologado['email'];

$qtd = 0;
$compra = 0;
$venda = 0;
$contador = 0;

Login::requireLogin();

$dataInicio;
$dataFim;


if ($categorias_id == "") {

    $var1 = "";
} else {

    $var1 =  "AND p.categorias_id =" . $categorias_id . "";
}

if ($nome == "") {

    $var2 = "";
} else {

    $var2 =  "AND p.nome like '%" . $nome . "%'";
}

if ($barra == "") {

    $var3 = "";
} else {

    $var3 =  "AND p.barra ='" . $barra . "'";
}

$consulta = "p.data between ' " . $dataInicio . " ' AND ' " . $dataFim . " ' " . $var1 . " " . $var2 . " " . $var3 . "";

$res = "";

$listar = Produto::getList(
    'p.id as id,
                            p.data as data,
                            p.codigo as codigo,
                            p.barra as barra,
                            p.nome as nome,
                            p.foto as foto,
                            p.qtd as  qtd,
                            p.estoque as estoque,
                            p.aplicacao as aplicacao,
                            p.valor_compra as valor_compra,
                            p.valor_venda as valor_venda,
                            p.categorias_id as categorias_id,
                            c.nome as categoria',
    'produtos AS p
                            INNER JOIN
                            categorias AS c ON (p.categorias_id = c.id)',
    $consulta,
    'p.nome ASC',
    null
);

foreach ($listar as $item) {

    $contador += 1;

    if (empty($item->foto)) {
        $foto = '../../imgs/sem.jpg';
    } else {
        $foto = $item->foto;
    }

    $compra += $item->valor_compra;
    $venda += $item->valor_venda;
    $qtd += $item->estoque;

    $res .= '   <tr>
                
                      
                        <td style="text-align:left;width:40px">' . $contador . '</td>
                        <td style="text-align:left;width:80px"><span class="eneylton" >' . $item->barra . '</span></td>
                        <td style="width:150px; text-align:left">' . date('d/m/Y à\s H:i:s', strtotime($item->data)) . '</td>
                        <td style="font-size:30px;text-transform: uppercase; width:250px; text-align:left" >' . $item->categoria . '</td>
                        <td style="text-transform: uppercase; width:250px; text-align:left"><span >' . $item->nome . '</span></td>
                        <td style="text-transform: uppercase;width:65px">' . $item->estoque . '</td>
                        <td style="text-transform: uppercase; width:100px; text-align:left"> R$ ' . number_format($item->valor_compra, "2", ",", ".") . '</td>
                        <td style="text-transform: uppercase; width:100px; text-align:left">R$ ' . number_format($item->valor_venda, "2", ",", ".") . '</td>
    
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

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+39+Extended&family=Neonderthaw&display=swap" rel="stylesheet">
   


    <style>
        @page {
            margin: 70px 0;
        }

        @font-face {
            font-family: 'BabyTwice';           
            src: url('BabyTwice.ttf');
            font: normal 12px/20px BabyTwice;
       

        }  

        .barra {
            font-family: 'Libre Barcode 39 Extended', cursive !important;
        }

        .eneylton {

            font-family: 'Libre Barcode 39 Extended', cursive !important;
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

    <title>Etiquetas</title>
</head>

<body>

    <table style="margin-top: -40px;">
        <tbody>
            <tr style="background-color: #fff; color:#000">

                <td style="text-align: left; width:260px; border:1px solid #fff; ">
                    <span style="margin-left:126px; margin-top: -50px; font-size:small">Lovingirl </span><br>
                    <span style="margin-left:126px; margin-top: -30px; font-size:xx-small ">Email:&nbsp; <?= $usuarios_email  ?> </span><br>
                    <span style="margin-left:126px; margin-top: -30px; font-size:xx-small">Atendente:&nbsp; <?= $usuarios_nome  ?> </span><br>
                    <img style="width:120px; height:50px; float:left;margin-top:-50px; padding:10px; margin-left:-12px;" src="../../01.png">
                    <br />
                    <br />

                </td>
                <td class="codbarra" style="text-align:center; font-weight:600; font-size:16px; border:1px solid #fff;">• LISTA DE PRODUTOS •</td>
                <td style="text-align:right; border:1px solid #fff;">Data de Emissão: <?php echo date("d/m/Y") ?><br></td>

            </tr>
        </tbody>
    </table>


    <table>
        <tbody>
            <tr style="background-color:#ff0000; color:#fff">
                <td style="text-align: center; text-transform:uppercase" colspan="9">Lista de Produtos</td>
            </tr>

            <tr style="background-color: #000; color:#fff">

                <td>Nª</td>
                <td style="text-align:left;"> BARRA </td>
                <td> DATA CADASTRO </td>
                <td style="text-align:left"> CATEGORIA </td>
                <td style="text-align:left"> NOME </td>
                <td> QTD </td>
                <td> COMPRA </td>
                <td> VENDA </td>

            </tr>

            <?= $res ?>

            <tr style="background-color:#d1d1d1; color:#000">
                <td style="text-align: right; text-transform:uppercase" colspan="5">TOTAL</td>
                <td><?= $qtd ?></td>
                <td style="text-align:left">R$ <?= number_format($compra, "2", ",", ".") ?></td>
                <td style="text-align:left">R$ <?= number_format($venda, "2", ",", ".") ?></td>
            </tr>


        </tbody>
    </table>

</body>

</html>