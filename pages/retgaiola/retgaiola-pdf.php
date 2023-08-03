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


if($clientes_id == ""){

    $var1 = "";

}else{

    $var1 =  "AND r.clientes_id =". $clientes_id."";
}


$consulta = "r.data between ' ".$dataInicio." ' AND ' ".$dataFim." ' ".$var1."";

$res = "";

$listar = Receber::getList('r.id AS id,
r.data AS data,
r.qtd AS qtd,
r.clientes_id AS clientes_id,
r.disponivel AS disponivel,
cli.nome AS cliente,
s.nome AS servicos,
st.nome AS setores',
                            'receber AS r
                            INNER JOIN
                            clientes AS cli ON (r.clientes_id = cli.id)
                            INNER JOIN
                            servicos AS s ON (cli.servicos_id = s.id)
                            INNER JOIN
                            setores AS st ON (cli.setores_id = st.id)',$consulta ,'r.data ASC', null);

foreach ($listar as $item) {

    $total = ($item->qtd - $item->disponivel);
    $total_disp += $total;
    $total_qtd += $item->qtd;

    switch ($item->qtd) {
        case '10':
           $cor2 = "badge-danger";
           $qtd = "10";
           $msn = " ITENS PEDENTES";
           $disabled = "";
           break;
  
        case '9':
           $cor2 = "badge-danger";
           $qtd = "9";
           $msn = "Pendentes";
           $disabled = "";
           break;
  
        case '8':
           $cor2 = "badge-danger";
           $qtd = "8";
           $msn = "Pendentes";
           $disabled = "";
           break;
  
  
        case '7':
           $cor2 = "badge-danger";
           $qtd = "7";
           $msn = "Pendentes";
           $disabled = "";
           break;
  
  
        case '6':
           $cor2 = "badge-danger";
           $qtd = "6";
  
           $msn = "Pendentes";
           $disabled = "";
           break;
  
  
        case '5':
           $cor2 = "badge-danger";
           $qtd = "5";
           $msn = "Pendentes";
           $disabled = "";
           break;
        case '4':
           $cor2 = "badge-danger";
           $qtd = "4";
           $msn = "Pendentes";
           $disabled = "";
           break;
  
        case '3':
           $cor2 = "badge-danger";
           $qtd = "3";
           $msn = " Pendentes";
           $disabled = "";
           break;
  
        case '2':
           $cor2 = "badge-danger";
           $qtd = "2";
           $msn = "Pendentes";
           $disabled = "";
           break;
  
        case '1':
           $cor2 = "badge-danger";
           $qtd = "1";
           $msn = "Pendente";
           $disabled = "";
           break;
  
        case '0':
           $cor2 = "badge-success";
           $qtd = "";
           $msn = "Todos os itens foram distribuidos";
           $disabled = "disabled";
           break;
  
        default:
           $cor2 = "badge-light";
           $qtd = $item->qtd;
           $msn = " DISPONIVEIS PARA ENTREGA";
           $disabled = "";
           break;
     }
  
    $total_sub += $item->qtd;

    $res .= '   <tr>
                        <td style="text-align:left;width:150px">'.date('d/m/Y  Á\S  H:i:s', strtotime($item->data)).'</td>
                        <td style="text-align:left;width:180px">' . $item->cliente . '</td>
                        <td >' . $item->qtd. '</td>
                        <td style="text-align:left;text-transform: uppercase; width:250px">' . $item->disponivel. ' - '. $msn. '</td>
                        <td style="text-align:center;text-transform: uppercase; width:100px">' .$total. '</td>
                    
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
                    <span style="margin-left:110px; margin-top: -30px; font-size:xx-small ">Email:&nbsp; <?= $usuarios_email  ?> </span><br>
                    <span style="margin-left:110px; margin-top: -30px; font-size:xx-small">Atendente:&nbsp; <?= $usuarios_nome  ?> </span><br>
                    <img style="width:108px; height:40px; float:left;margin-top:-50px; padding:10px; margin-left:-12px;" src="../../02.jpeg">
                    <br />
                    <br />

                </td>
                <td style="text-align:center; font-weight:600; font-size:16px; border:1px solid #fff;">• LISTA DE ITENS RECEBIDOS •</td>
                <td style="text-align:right; border:1px solid #fff;margin-left:-10">
                <?php echo "Data: ".date('d/m/Y', strtotime($dataInicio)) ; echo " á ".date('d/m/Y', strtotime($dataFim))  ?><br></td>

            </tr>
        </tbody>
    </table>


    <table>
        <tbody>
            <tr style="background-color:#3ae210; color:#fff">
                <td style="text-align: center; text-transform:uppercase" colspan="5">Lista de itens recebidos</td>
            </tr>

            <tr style="background-color: #000; color:#fff">

                           <td style="text-align:left"> DATA DO RECEBIMENTO </td>
                           <td> CLIENTES </td>
                           <td> RECEBIDO </td>
                           <td> QUANTIDADE </td>
                           <td style="text-align:center"> TOTAL PARCIAL</td>

            </tr>

            <?= $res ?>


            <tr>
                <td colspan="2"  style="text-align: right;">
                    <span>TOTAL RECEBIDO</span>
                </td>
                <td>
                <span><?php echo $total_sub; ?></span>
                </td>
                <td>
                <span style="color:ff0000;"><?php echo $total_disp ." DISPONIVÉIS" ?></span>
                </td>
                <td>
                <span><?php echo $total_disp; ?></span>
                </td>
            </tr>


        </tbody>
    </table>

</body>

</html>