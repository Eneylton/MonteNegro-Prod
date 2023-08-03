<?php

use App\Entidy\ControlEnvio;
use App\Entidy\Entregador;
use App\Entidy\EntregadorDetalhe;

require __DIR__ . '../../../vendor/autoload.php';

date_default_timezone_set('America/Sao_Paulo');
$data = date('Y-m-d\TH:i:s', time());

$dados = "";

$icon = "";

$timeline = '';

$param = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

$detalhe = EntregadorDetalhe::getIDDetalheList('*', 'entregador_detalhe', $param, null, null, null);

$controle = ControlEnvio::getID('*', 'controlenvio', $param, null, null, null);

$id = $controle->entregadores_id;

$entregador = Entregador::getID('*', 'entregadores', $id, null, null, null);

$apelido = $entregador->apelido;

foreach ($detalhe as $item) {

    switch ($item->status) {
        case '1':
            $icon = '<i class="fa fa-tags bg-success"></i>';
            break;
        case '2':

            $icon = '<i class="fa fa-arrow-right bg-info"></i>';
            break;
        case '3':
            $icon = '<i class="fas fa-check bg-blue"></i>';
            break;

        default:
            $icon = '<i class="fa fa-times bg-danger"></i>';
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
        <span class="time" style="font-size:14px"><i class="fas fa-clock"></i>&nbsp; ' . date('H:i:s', strtotime($item->data)) . '</span>
        <h3 class="timeline-header"><a href="#">Entregador:<span style="color:#000; text-transform: capitalize;">' . $apelido . '</span></h3>

        <div class="timeline-body">
         <span style="color:#000;padding:10px"> ' . $item->obs . '</span>
        </div>
        <div class="timeline-footer">
        <a class="btn btn-primary btn-sm">Atualizar</a>
        <a class="btn btn-danger btn-sm">Excluir</a>
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
