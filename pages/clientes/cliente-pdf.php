<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Cliente;
use \App\Session\Login;

$usuariologado = Login::getUsuarioLogado();

$usuarios_nome = $usuariologado['nome'];
$usuarios_email = $usuariologado['email'];

Login::requireLogin();

$res = "";

$listar = Cliente::getList(' cli.id AS id,
                             cli.nome AS nome,
                             s.nome AS servicos,
                             st.nome AS setores,
                             cli.servicos_id as servicos_id,
                             cli.setores_id as setores_id', 'clientes AS cli
                             INNER JOIN
                             servicos AS s ON (cli.servicos_id = s.id)
                             INNER JOIN
                             setores AS st ON (cli.setores_id = st.id)',null, 'cli.id desc',null);


foreach ($listar as $item) {

    $res .= '
                <tr>
                
                    <td style="text-align:left;text-transform: capitalize;width:100%">'  . $item->nome . '</td>
                    <td style="text-align:left;text-transform: uppercase;width:100%">'  . $item->servicos . '</td>
                    <td style="text-align:left;text-transform: uppercase; width:100%">'  . $item->setores . '</td>
                   
                   
                   
    
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

    <title>Clientes</title>
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
                <td style="text-align:center; font-weight:600; font-size:16px; border:1px solid #fff;">• LISTA DE CLIENTES •</td>
                <td style="text-align:right; border:1px solid #fff;">Data de Emissão: <?php echo date("d/m/Y") ?><br></td>

            </tr>
        </tbody>
    </table>


    <table>
        <tbody>
            <tr style="background-color:#1e9421; color:#fff" >
            <td style="text-align: center; text-transform:uppercase" colspan="4">Lista de clientes</td>
            </tr>

            <tr style="background-color: #000; color:#fff">

                <td style="text-align: left;text-transform:uppercase">Nome</td>
                <td style="text-align: left;text-transform:uppercase">Serviços</td>
                <td style="text-align: left;text-transform:uppercase">Setores</td>
              
                

            </tr>

            <?= $res ?>


        </tbody>
    </table>

</body>

</html>