<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Entrega;
use App\Entidy\Entregador;
use \App\Session\Login;

$usuariologado = Login::getUsuarioLogado();

$usuarios_nome = $usuariologado['nome'];
$usuarios_email = $usuariologado['email'];

Login::requireLogin();

$res = "";
$entregador = "";
$contador = 0;
$valor = 0;

$dataInicio;
$dataFim;

$consulta = "e.data between '" . $dataInicio . "' AND '" . $dataFim . "'";

if (isset($_GET['id_caixa']) or is_numeric($_GET['id_caixa'])) {

    $valor = 0;
    $sub_total = 0;
    $sub = 0;
    $calc = 0;
    $bruto = 0;
    $saldo = 0;
    $entrega_total = 0;
    $entregadores = "";

    $id_caixa = $_GET['id_caixa'];

    $entregas = Entrega::getList('    e.id AS id,
e.data AS data,
e.qtd AS qtd,
et.id AS entregadores_id,
et.valor_boleto AS valor_boleto,
et.valor_cartao AS valor_cartao,
et.valor_pequeno AS valor_pequeno,
et.valor_grande AS valor_grande,
et.apelido AS apelido,
st.nome AS setores,
sv.id AS servico_id,
sv.nome AS servicos,
et.valor_boleto AS boleto,
et.valor_cartao AS cartao,
et.valor_pequeno AS pequeno,
et.valor_grande AS grande,
cl.nome AS cliente,
rt.nome as rotas', ' entrega AS e
INNER JOIN
producao AS p ON (e.producao_id = p.id)
INNER JOIN
rotas AS rt ON (p.rotas_id = rt.id)
INNER JOIN
receber AS r ON (p.receber_id = r.id)
INNER JOIN
clientes AS cl ON (r.clientes_id = cl.id)
INNER JOIN
setores AS st ON (p.setores_id = st.id)
INNER JOIN
servicos AS sv ON (p.servicos_id = sv.id)
INNER JOIN
entregadores AS et ON (e.entregadores_id = et.id)
', $consulta . 'AND e.entregadores_id  = ' . $id_caixa);

    foreach ($entregas as $item) {

        $contador += 1;

        switch ($item->servico_id) {
            case '1':
                $valor = $item->pequeno;
                break;
            case '3':
                $valor = $item->boleto;
                break;
            case '4':
                $valor = $item->cartao;
                break;

            default:
                $valor = $item->grande;
                break;
        }

        $entregadores = $item->apelido;

        if ($item->qtd != null) {

            $sub_total = $item->qtd;
        } else {

            $item->qtd = "nenhuma";
        }

        $sub =  $sub_total *  $valor;

        $calc += $sub;

        $bruto += $sub_total;

        $saldo = $valor;



        $res .= '   <tr>

    <td style="text-align:left">' . $contador . '</td>
    <td style="text-align:left;width:40px">' . date('d/m/Y', strtotime($item->data)) . '</td>
    <td style="text-align:left;width:100px; text-transform: uppercase">' . $item->cliente . '</td>
    <td style="text-align:left;width:100px; text-transform: uppercase">' . $item->rotas . '</td>
    <td style="text-align:left;width:80px; text-transform: uppercase">' . $item->setores . '</td>
    <td style="text-align:left;width:80px; text-transform: uppercase">' . $item->servicos . '</td>
    <td style="text-align:left;width:60px; text-transform: uppercase">R$ ' . number_format($valor, "2", ",", ".") . '</td>
    <td style="text-align:center">' . $item->qtd . '</td>
    <td style="text-align:left; width:50px">R$ ' . number_format($sub, "2", ",", ".") . '</td>
    
</tr>
';
    }
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
                    <span style="margin-left:126px; margin-top: -50px; font-size:small">Montenegro express </span><br>
                    <span style="margin-left:126px; margin-top: -30px; font-size:xx-small ">Email:&nbsp;
                        <?= $usuarios_email  ?> </span><br>
                    <span style="margin-left:126px; margin-top: -30px; font-size:xx-small">Atendente:&nbsp;
                        <?= $usuarios_nome  ?> </span><br>
                    <img style="width:120px; height:50px; float:left;margin-top:-50px; padding:10px; margin-left:-12px;"
                        src="../../02.jpeg">
                    <br />
                    <br />

                </td>
                <td style="text-align:center; font-weight:600; font-size:16px; border:1px solid #fff;">• LISTA DE
                    PRODUÇÃO •</td>
                <td style="text-align:right; border:1px solid #fff;margin-left:-10">
                    <?php echo "Data: " . date('d/m/Y', strtotime($dataInicio));
                    echo " á " . date('d/m/Y', strtotime($dataFim))  ?><br></td>

            </tr>
        </tbody>
    </table>

    <table>
        <tbody>
            <tr style="background-color:#fff; color:#000">
                <td style="text-align: left; width:260px; border:1px solid #fff; ">
                    <span style="font-size: medium;text-transform:uppercase"> Entregador: <?= $entregadores ?></span>
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody>
            <tr style="background-color:#08aa13; color:#fff">
                <td style="text-align: center; text-transform:uppercase" colspan="9">PRODUÇÃO</td>
            </tr>

            <tr style="background-color: #000; color:#fff">

                <td style="text-align:left; width:20px">Nº</td>
                <td style="text-align:center;width:100px">DATA</td>
                <td style="text-align:center;">CLIENTES</td>
                <td style="text-align:center;">ROTAS</td>
                <td style="text-align:center;">SETORES</td>
                <td style="text-align:center;">SERVIÇOS</td>
                <td style="text-align:center;">VALOR ENTREGA</td>
                <td style="text-align:center;width:50px">TOTAL ENTREGUE</td>
                <td style="text-align:left;width:80px;">SUCESSO</td>


            </tr>

            <?= $res ?>

            <tr style="background-color: #555555; color:#fff">
                <td colspan="7" style="text-align: right;font-size:18px;">
                    TOTAL
                </td>
                <td style="text-align:center;font-size:18px;color:#6effc9;">
                    <?= $bruto ?>
                </td>
                <td style="text-align:left;font-size:18px">
                    R$ <?= number_format($calc, "2", ",", ".") ?>
                </td>

            </tr>


        </tbody>
    </table>

</body>

</html>