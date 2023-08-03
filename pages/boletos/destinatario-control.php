<?php

use App\Entidy\EntregadorDetalhe;
use App\Session\Login;

require __DIR__ . '../../../vendor/autoload.php';

Login::requireLogin();

$usuariologado = Login::getUsuarioLogado();

$usuario = $usuariologado['id'];

$acesso = $usuariologado['acessos_id'];

$foto = "";

date_default_timezone_set('America/Sao_Paulo');

$data = date('Y-m-d\TH:i:s', time());

$dados = "";

$resultados  = "";

$icon = "";
$status = "";

$timeline = '';

$param = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

$detalhe = EntregadorDetalhe::getIDDetalheList('ed.id AS id,
ed.data AS data,
ed.status AS status,
ed.obs AS obs,
ed.ocorrencias_id AS ocorrencias_id,
ed.entregadores_id AS entregadores_id,
ed.boletos_id AS boletos_id,
e.id AS id_entregadores,
e.apelido AS apelido,
o.id as ocorrencia_id,
o.nome as ocorrencias', 'entregador_detalhe AS ed
INNER JOIN
entregadores AS e ON (ed.entregadores_id = e.id)
INNER JOIN
ocorrencias AS o ON (ed.ocorrencias_id = o.id)', $param, null, null, null);

foreach ($detalhe as $item) {

    switch ($item->status) {
        case '1':
            $icon = '<i class="fa fa-tags bg-success"></i>';
            $status = 'Arquivo Importado';
            break;
        case '2':

            $icon = '<i class="fa fa-arrow-right bg-info"></i>';
            $status = '<span style="color:#203abd"><strong>Em Rota</strong></span>';
            break;
        case '3':
            $icon = '<i class="fas fa-check bg-blue"></i>';
            $status = '<span style="color:#0f8706"><strong>Entrega Realizada com Sucesso !</strong></span>';
            break;

        case '4':
            $icon = '<i class="fa fa-times bg-danger"></i>';
            $status = '<span style="color:#ff0000">Entrega não Realizada !</span>';
            break;

        default:
            $icon = '<i class="fa fa-times bg-danger"></i>';
            $status = '<span style="color:#ff0000"><strong>Entrega não Realizada !</stong></span>';
            break;
    }

    $timeline .= '
   
    <div class="row">
    <div class="col-md-12">
  
    <div class="timeline">
  
    <div class="time-label">
    <span class="bg-info" style="padding:10px">' . date('d/m/Y -- H:i:s', strtotime($item->data)) . '</span>
    </div>
  
    <div>
    ' . $icon . '
    <div class="timeline-item">
    <span class="time" style="font-size:18px;color:#000;"><i class="fas fa-check"></i>&nbsp; ' . $status . '</span>
    <h3 class="timeline-header"><a href="#">Entregador:<span style="color:#000; text-transform: capitalize;">' . $item->apelido . '</span></h3>

    <div class="timeline-body">
     <span style="color:#000;padding:10px"> ' . $item->obs . '</span>
    </div>
    <div class="timeline-footer">
    <a ></a>
    <a></a>
    </div>
    </div>
    </div>
</div>
    
    ';
}

$dados .= '
<div class="card-body table-responsive p-0" style="height: 600px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>TIMELINE</th>
					  </tr>
				     </thead>
					   <tbody>
                    <tr>
                      <td>' . $timeline . '</td>
                  
                     </tr>
                  </tbody>
                </table>

';

$retorna = ['erro' => false, 'dados' => $dados];

echo json_encode($retorna);
