<?php

$list = '';

if (isset($_GET['status'])) {

   switch ($_GET['status']) {
      case 'success':
         $icon  = 'success';
         $title = 'Parabéns';
         $text = 'Item distribuido ao entregador!!!';
         break;

      case 'producao':
         $icon  = 'error';
         $title = 'Quantidade';
         $text = 'Maior que o esperado !!!';
         break;

      case 'edit':
         $icon  = 'warning';
         $title = 'Parabéns';
         $text = 'Cadastro atualizado com sucesso !!!';
         break;


      default:
         $icon  = 'error';
         $title = 'Opss !!!';
         $text = 'Algo deu errado entre em contato com admin !!!';
         break;
   }

   function alerta($icon, $title, $text)
   {
      echo "<script type='text/javascript'>
      Swal.fire({
        type:'type',  
        icon: '$icon',
        title: '$title',
        text: '$text'
       
      }) 
      </script>";
   }

   alerta($icon, $title, $text);
}

$resultados = '';

$soma = 0;

foreach ($listar as $item) {

   $soma += $item->qtd;

   $resultados .= '<tr>
    
                      <td style="display:none">' . $item->id . '</td>
                      <td style="display:none">' . $item->gaiolas_id . '</td>
                      <td style="display:none">' . $item->rotas_id . '</td>
                      <td style="display:none">' . $item->clientes_id . '</td>
                      <td style="display:none">' . $item->entregadores_id . '</td>
                      <td style="display:none">' . $item->data . '</td>
                      <td style="display:none">' . $item->qtd . '</td>
                      <td style="display:none">' . $item->gaiolas . '</td>
                      <td style="display:none">' . $item->rotas . '</td>

                      <td style="text-transform:uppercase">' . $item->id . '</td>
                      <td style="text-transform:uppercase">' . date('d/m/Y  Á\S  H:i:s', strtotime($item->data)) . '</td>
                      <td style="text-transform:uppercase">' . $item->rotas . '</td>
                      <td style="text-transform:uppercase"> <h5><span class="badge badge-pill badge-secondary"><i class="fa fa-inbox" aria-hidden="true"></i> &nbsp;' . $item->gaiolas . '</span></h5> </td>
                      <td style="text-transform:uppercase"> <h5><span class="badge badge-pill badge-info"><i class="fa fa-cubes" aria-hidden="true"></i> &nbsp;' . $item->clientes . '</span></h5> </td>
                      <td style="text-transform:uppercase; text-align:center"> <h5><span class="badge badge-pill badge-danger"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp;' . $item->qtd . '</span></h5> </td>
                    
                      <td style="text-align: center; width:300px">
                      <button type="submit" class="btn btn-default editbtn2" > <i class="fa fa-plus" aria-hidden="true"></i>&nbsp; Add entregador</button>
                    
                      </td>
                      </tr>

                      ';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="8" class="text-center" > Nenhum item disponível !!!!! </td>
                                                   </tr>';


unset($_GET['status']);
unset($_GET['pagina']);
$gets = http_build_query($_GET);

//PAGINAÇÂO

$paginacao = '';
$paginas = $pagination->getPages();

foreach ($paginas as $key => $pagina) {
   $class = $pagina['atual'] ? 'btn-primary' : 'btn-secondary';
   $paginacao .= '<a href="?pagina=' . $pagina['pagina'] . '&' . $gets . '">

                  <button type="button" class="btn ' . $class . '">' . $pagina['pagina'] . '</button>
                  </a>';
}

?>

<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="card card-purple">
               <div class="card-header">

                  <form method="get">
                     <div class="row ">
                        <div class="col-4">

                           <label>Buscar por Nome</label>
                           <input type="text" class="form-control" name="buscar" value="<?= $buscar ?>">

                        </div>


                        <div class="col d-flex align-items-end">
                           <button type="submit" class="btn btn-warning" name="">
                              <i class="fas fa-search"></i>

                              Pesquisar

                           </button>

                        </div>


                     </div>

                  </form>
               </div>

               <div class="table-responsive">

                  <table class="table table-bordered table-dark table-bordered table-hover table-striped">
                     <thead>

                        <tr>
                           <th style="text-align: left; width:80px"> CÓDIGO </th>
                           <th> DATA </th>
                           <th> ROTAS </th>
                           <th> GAIOLAS </th>
                           <th> CLIENTES </th>
                           <th style="text-align: center;"> QTD </th>

                           <th style="text-align: center; width:200px"> AÇÃO </th>
                        </tr>
                     </thead>
                     <tbody>
                        <?= $resultados ?>
                     </tbody>
                     <tr>
                        <td colspan="5" style="text-align: right;">
                           <span>TOTAL</span>
                        </td>
                        <td colspan="1" style="text-align: center;">
                           <span><?= $soma ?></span>
                        </td>
                        <td colspan="2" style="text-align: center;">

                        </td>
                     </tr>

                  </table>

               </div>


            </div>

         </div>

      </div>

   </div>

</section>

<?= $paginacao ?>


<!-- EDITAR -->

<div class="modal fade" id="editmodal2">
   <div class="modal-dialog modal-lg">
      <form action="../producao/producao-insert.php" method="post">
         <div class="modal-content bg-light">
            <div class="modal-header">
               <h4 class="modal-title">Prazo de entrega</h4>
               <input type="hidden" name="divgaiolas_id" id="id">
                  
                  <input type="hidden" name="rotas_id" id="rotas_id">
                  <input type="hidden" name="clientes_id" id="clientes_id">
                  <input type="hidden" name="gaiolas_id" id="gaiolas_id">
                  <input type="hidden" name="entregadores_id" id="entregadores_id">

               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">

                  <div class="col-6">

                     <div class="form-group">
                        <label>Início da entrega</label>
                        <input value="<?php
                                       date_default_timezone_set('America/Sao_Paulo');
                                       echo date('Y-m-d\TH:i:s', time()); ?>" type="datetime-local" class="form-control" name="data_inicio" required>
                     </div>
                  </div>
                  <div class="col-6">

                     <div class="form-group">
                        <label>Fim</label>
                        <input value="<?php
                                       date_default_timezone_set('America/Sao_Paulo');
                                       echo date('Y-m-d\TH:i:s', time()); ?>" type="datetime-local" class="form-control" name="data_fim" required>
                     </div>
                  </div>

                  <div class="col-6">
                     <label>Entregador</label>
                     <select class="form-control select" style="width: 100%;" name="entregadores_id" required>
                        <option value=""> Selecione uma entregador </option>
                        <?php

                        foreach ($entregadores as $item) {
                           echo '<option style="text-transform: uppercase;" value="' . $item->id . '">' . $item->apelido . '</option>';
                        }
                        ?>

                     </select>

                  </div>

                  <div class="col-6">

                  <div class="form-group">
                        <label>Quandidade para entrega</label>
                        <input style="text-transform: uppercase;" type="text" class="form-control" name="qtd" required >
                     </div>

                  </div>

               </div>
            </div>

          
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
               <button type="submit" class="btn btn-primary">Salvar
               </button>
            </div>
         </div>
      </form>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>

