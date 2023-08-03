<?php

require __DIR__ . '../../../vendor/autoload.php';

use \App\Entidy\Usuario;
use   \App\Session\Login;


Login::requireLogin();


$usuarios = Usuario::getUsuarioPdf();

$res = "";

foreach ($usuarios as $item) {

    $res .= '
<tr>
<td>' . $item->id . '</td>
<td>' . $item->nome . '</td>
<td>' . $item->email . '</td>
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
        @page{
            margin: 70px 0;
        }

        body{
            margin:0;
            padding: 0;
            font-family:"Open Sans", sans-serif;
        }
        
        .header{
            position: fixed;
            top:-70px;
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

        .footer{
            bottom: -27px;
            left: 0;
            width: 100%;
            padding: 5px 10px 10px 10px;
            text-align: center;
            background: #555555;
            color: #fff;
            }     
            
            .footer .page:after{
                content: counter(page);
            }

            table{
                width: 100%;
                border: 1px solid #555555;
                margin: 0;
                padding: 0;
            }

            .table2{

                width: 100%;
                margin: 0;
                padding: 0;
                background: #fff;

            }

            th{
                text-transform: uppercase;
            }

            .td2{

                border: 1px solid #ffffff;
                border-collapse:collapse;
                text-align: left;
                padding: 5px;

            }

            table, th, td {
                border: 1px solid #d1d1d1;
                border-collapse:collapse;
                text-align: left;
                padding: 5px;

            }

            tr:nth-child(2n+0){
                background: #eeeeee;
            }

            p{
                color:#888888;
                margin: 0;
                text-align: center;
            }

            h2{
                text-align: center;
            }

    </style>

    <title>Lista de Usuários</title>


</head>

<body>

    
<table class="table2">
        <tbody>
            <tr >
                <td class="td2">
    
                <img src="assets/01.png"  style="width: 60px; height:60px; margin-top:-30px;">
    
                </td>
                <td class="td2"><span>LOJÃO DO CARRO -</span> <br /> <span style="color: #555555;">lojao do carro@gmail.com - (98) 88990-0909</span></td>
                <td class="td2">Data: São luís 23/03/2021</td>
            </tr>
        </tbody>
    </table>



    <table>
        <tbody>
            <tr style="background-color: #000; color:#fff">
                <td>ID</td>
                <td>NOME</td>
                <td>EMAIL</td>
            </tr>

            <?= $res ?>

        </tbody>
    </table>

</body>

</html>