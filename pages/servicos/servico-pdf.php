<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Entregador;
use \App\Session\Login;

$usuariologado = Login::getUsuarioLogado();

$usuarios_nome = $usuariologado['nome'];
$usuarios_email = $usuariologado['email'];

Login::requireLogin();

$res = "";

$listar = Entregador::getListEntregador();

foreach ($listar as $item) {

    $res .= '
                <tr>
                
                    <td style="text-align:left;text-transform: capitalize">'  . $item->nome . '</td>
                    <td style="text-align:left;text-transform: uppercase;">'  . $item->telefone . '</td>
                    <td style="text-align:left;text-transform: lowercase;">'  . $item->email . '</td>
                    <td style="text-align:left;text-transform: capitalize;">' . $item->banco . '</td>
                    <td style="text-align:left;text-transform: uppercase;">'  . $item->agencia . '</td>
                    <td style="text-align:left;text-transform: uppercase;">'  . $item->conta . '</td>
                    <td style="text-align:left;text-transform: capitalize;">' . $item->rota . '</td>
                    <td style="text-align:left;text-transform: capitalize;">' . $item->regiao . '</td>
                    <td style="text-align:left;text-transform: capitalize;">' . $item->veiculo . '</td>
                   
    
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

    <title>Lista de Entregadores</title>
</head>

<body>

    <table style="margin-top: -40px;">
        <tbody>
            <tr style="background-color: #fff; color:#000">

                <td style="text-align: left; width:260px; border:1px solid #fff; ">
                    <span style="margin-left:126px; margin-top: -50px; font-size:small">Monte negro </span><br>
                    <span style="margin-left:126px; margin-top: -30px; font-size:xx-small ">Email:&nbsp; <?= $usuarios_email  ?> </span><br>
                    <span style="margin-left:126px; margin-top: -30px; font-size:xx-small">Atendente:&nbsp; <?= $usuarios_nome  ?> </span><br>
                    <img style="width:120px; height:50px; float:left;margin-top:-50px; padding:10px; margin-left:-12px;" src="../../02.jpeg">
                    <br />
                    <br />

                </td>
                <td style="text-align:center; font-weight:600; font-size:16px; border:1px solid #fff;">• LISTA DE ENTREGADORES •</td>
                <td style="text-align:right; border:1px solid #fff;">Data de Emissão: <?php echo date("d/m/Y") ?><br></td>

            </tr>
        </tbody>
    </table>


    <table>
        <tbody>
            <tr style="background-color:#1e9421; color:#fff" >
            <td style="text-align: center; text-transform:uppercase" colspan="9">Lista de entregadores</td>
            </tr>

            <tr style="background-color: #000; color:#fff">

                <td style="text-align: left;text-transform:uppercase">Entregadores</td>
                <td style="text-align: left;text-transform:uppercase">Telefone</td>
                <td style="text-align: left;text-transform:uppercase">Email</td>
                <td style="text-align: left;text-transform:uppercase">Banco</td>
                <td style="text-align: left;text-transform:uppercase">Conta</td>
                <td style="text-align: left;text-transform:uppercase">Agência</td>
                <td style="text-align: left;text-transform:uppercase">Rotas</td>
                <td style="text-align: left;text-transform:uppercase">Regiões</td>
                <td style="text-align: left;text-transform:uppercase">Veículos</td>

            </tr>

            <?= $res ?>


        </tbody>
    </table>

</body>

</html>