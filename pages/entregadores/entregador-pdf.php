<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Entregador;
use \App\Session\Login;

$usuariologado = Login::getUsuarioLogado();

$usuarios_nome = $usuariologado['nome'];
$usuarios_email = $usuariologado['email'];

Login::requireLogin();

$res = "";

$listar = Entregador::getList('e.id as id,e.tipo as tipo,e.forma_pagamento_id as forma_pagamento_id,e.apelido as apelido,e.cnh as cnh, e.renavam as renavam,e.nome as entregador,e.cpf as cpf,e.telefone as telefone,e.email as email,e.banco as banco,e.veiculos_id as veiculos_id,
                               e.agencia as agencia,e.conta as conta,e.pix as pix,v.nome as veiculo', 
                               'entregadores AS e
                                INNER JOIN
                                veiculos AS v ON (e.veiculos_id = v.id)',null, 'e.id desc', null);

foreach ($listar as $item) {

    $res .= '
                <tr>
                
                    <td style="text-align:left;text-transform: capitalize;width:100px">'  . $item->entregador . '</td>
                    <td style="text-align:left;text-transform: uppercase;width:100px">'  . $item->telefone . '</td>
                    <td style="text-align:left;text-transform: uppercase;width:100px">'  . $item->cnh . '</td>
                    <td style="text-align:left;text-transform: uppercase;width:100px">'  . $item->renavam . '</td>
                    <td style="text-align:left;text-transform: capitalize;width:100px">' . $item->banco . '</td>
                    <td style="text-align:left;text-transform: uppercase;width:50px">'  . $item->agencia . '</td>
                    <td style="text-align:left;text-transform: uppercase;width:100px">'  . $item->conta . '</td>
                    <td style="text-align:left;text-transform: uppercase;">'  . $item->pix . '</td>
                    <td style="text-align:left;text-transform: capitalize; width:180px">' . $item->veiculo . '</td>
                   
    
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
            <td style="text-align: center; text-transform:uppercase" colspan="11">Lista de entregadores</td>
            </tr>

            <tr style="background-color: #000; color:#fff">

                <td style="text-align: left;text-transform:uppercase">Nome de guerra</td>
                <td style="text-align: left;text-transform:uppercase">Telefone</td>
                <td style="text-align: left;text-transform:uppercase">CNH</td>
                <td style="text-align: left;text-transform:uppercase">RENAVAN</td>
                <td style="text-align: left;text-transform:uppercase">Banco</td>
                <td style="text-align: left;text-transform:uppercase">Agência</td>
                <td style="text-align: left;text-transform:uppercase">Conta</td>
                <td style="text-align: left;text-transform:uppercase">Pix</td>
                <td style="text-align: left;text-transform:uppercase">Veículos</td>

            </tr>

            <?= $res ?>


        </tbody>
    </table>

</body>

</html>