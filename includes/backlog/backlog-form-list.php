<?php

$list = '';

if (isset($_GET['status'])) {

   switch ($_GET['status']) {
      case 'success':
         $icon  = 'success';
         $title = 'Parabéns';
         $text = 'Cadastro realizado com Sucesso !!!';
         break;

      case 'del':
         $icon  = 'error';
         $title = 'Parabéns';
         $text = 'Esse usuário foi excluido !!!';
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

   switch ($item->tipo_id) {
      case '2':
         $cor = "badge-danger";
         $cor2 = "btn btn-danger";
         $posion ="-right";
         $icon = "fas fa-arrow-right";
         $disabled = "disabled";
         break;

      default:
         $cor = "badge-warning";
         $cor2 = "btn btn-warning";
         $posion ="-left";
         $icon = "fas fa-arrow-left";
         $disabled = "";
         break;
   }

   $resultados .= '<tr>
                      <td style="display:none">' . $item->id . '</td>
                      <td style="display:none">' . $item->tipo_id. '</td>
                      <td style="display:none">' . $item->rota_id. '</td>
                      <td style="display:none">' . $item->gaiolas_id. '</td>
                      <td style="display:none">' . $item->data . '</td>
                      <td style="display:none">' . $item->qtd . '</td>
                      <td style="display:none">' . $item->apelido . '</td>
                      <td style="display:none">' . $item->ocorrencia . '</td>
                      <td style="display:none">' . $item->tipo . '</td>
                      <td style="display:none">' . $item->gaiolas . '</td>
                      <td style="display:none">' . $item->ocorrencias_id . '</td>
                      <td style="display:none">' . $item->entregadores_id . '</td>

                      <td>' . $item->id . '</td>
                      <td style="text-transform:uppercase">' . date('d/m/Y  Á\S  H:i:s', strtotime($item->data)) . '</td>
                      <td style="text-transform:uppercase"> <h5><span class="badge badge-pill badge-light"> <i class="fa fa-motorcycle" aria-hidden="true"></i> &nbsp;' . $item->apelido . '</span></h5> </td>
                      <td>' . $item->ocorrencia . '</td>
                      <td style="text-transform:uppercase"> <h5><span class="badge badge-pill ' . $cor . '"><i class="fas fa-chevron-circle'.$posion.'"></i> &nbsp;' . $item->tipo . '</span></h5> </td>
                      <td style="text-transform:uppercase"> <h5><span class="badge badge-pill badge-secondary"><i class="fa fa-inbox" aria-hidden="true"></i> &nbsp;' . $item->gaiolas . '</span></h5> </td>
                      <td style="text-transform:uppercase; text-align:center"> <h5><span class="badge badge-pill badge-light"><i class="fa fa-plus-circle" aria-hidden="true"></i> &nbsp;' . $item->qtd . '</span></h5> </td>
                      
                      <td style="text-align: center;">
                        
                      
                      

                       <a href="retorno-edit.php?id=' . $item->rota_id.
                                               '&retorno_id='.$item->id.
                                               '&data='.$item->data.
                                               '&gaiola_id='.$item->gaiolas_id.
                                               '&entregadores_id='.$item->entregadores_id.
                                               '&tipo_id='.$item->tipo_id.
                                               '&rota_id='.$item->rota_id.
                                               '&ocorrencia='.$item->ocorrencias_id.
                                               '&qtd='.$item->qtd.'">
                       <button type="button" class="' . $cor2 . '"><i class="' . $icon . '" aria-hidden="true" ></i> Enviar</button>
                       </a>


                      </td>
                      </tr>

                      ';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="8" class="text-center" > Nenhuma devolução até o momento !!!!! </td>
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
                           <td colspan="8">
                              <button type="submit" class="btn btn-default float-right" data-toggle="modal" data-target="#modal-data"> <i class="fas fa-print"></i> &nbsp; IMPRIMIR RELATÓRIOS</button>
                           </td>
                        </tr>

                        <tr>
                           <th style="text-align: left; width:80px"> CÓDIGO </th>
                           <th> DATA </th>
                           <th> ENTREGADORES </th>
                           <th> OCORRÊNCIAS </th>
                           <th> TIPO </th>
                           <th> GAIOLAS </th>
                           <th style="text-align:center"> QTD </th>
                           <th style="text-align: center; width:200px"> AÇÃO </th>
                        </tr>
                     </thead>
                     <tbody>
                        <?= $resultados ?>
                     </tbody>

                     <tr>
                        <td colspan="6" style="text-align: right;"> QUANTIDADE TOTAL </td>

                        <td colspan="1" style="text-transform:uppercase; text-align:center; ">
                           <h5><span class="badge badge-pill badge-primary" style="font-size: 18px;"><i class="fa fa-check" aria-hidden="true"></i> &nbsp; <?= $soma ?></span></h5>
                        </td>
                        <td></td>
                     </tr>

                  </table>

               </div>


            </div>

         </div>

      </div>

   </div>

</section>

<?= $paginacao ?>



<div class="modal fade" id="modal-data">
   <div class="modal-dialog modal-lg">
      <div class="modal-content ">
         <form action="./retorno-gerar.php" method="GET" enctype="multipart/form-data">

            <div class="modal-header">
               <h4 class="modal-title">Relatórios
               </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="card-body">


               <div class="form-group">

                  <div class="row">
                     <div class="col-lg-4 col-4">
                        <input class="form-control" type="date" value="<?php echo date('Y-m-d') ?>" name="dataInicio">
                     </div>


                     <div class="col-lg-4 col-4">
                        <input class="form-control" type="date" value="<?php echo date('Y-m-d') ?>" name="dataFim">
                     </div>


                     <div class="col-lg-4 col-4">

                        <select class="form-control select2" name="entregadores_id">
                           <option value=""> Entregadores </option>
                           <?php

                           foreach ($entregadores as $item) {
                              echo '<option value="' . $item->id . '">' . $item->apelido . '</option>';
                           }
                           ?>

                        </select>

                     </div>
                  </div>
                  <p></p>

                  <div class="row">

                     <div class="col-lg-4 col-4">

                        <select class="form-control select2" name="ocorrencias_id">
                           <option value=""> Ocorrências </option>
                           <?php

                           foreach ($ocorrencias as $item) {
                              echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
                           }
                           ?>

                        </select>

                     </div>
                     <div class="col-lg-4 col-4">

                        <select class="form-control select2" name="tipo_id">
                           <option value=""> Tipo </option>
                           <?php

                           foreach ($tipos as $item) {
                              echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
                           }
                           ?>

                        </select>

                     </div>
                     <div class="col-lg-4 col-4">

                        <select class="form-control select2" name="gaiolas_id">
                           <option value=""> Gaiolas </option>
                           <?php

                           foreach ($gaiolas as $item) {
                              echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
                           }
                           ?>

                        </select>

                     </div>

                  </div>


               </div>

            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
               <button type="submit" class="btn btn-primary">Gerar relatório</button>
            </div>

         </form>

      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>