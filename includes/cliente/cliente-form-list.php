<?php



$resultados = '';

foreach ($listar as $item) {

   $resultados .= '<tr>
                      <td style="display:none">' .             $item->id . '</td>
                      <td style="text-transform:uppercase">' . $item->nome . '</td>
                      <td style="text-transform:uppercase">' . $item->setores . '</td>
                      <td style="display:none">' .             $item->setores_id . '</td>
                  

                      <td style="text-align: center;">
                        
                      <button type="submit" class="btn btn-success editbtn" > <i class="fas fa-paint-brush"></i> </button>
                      &nbsp;

                       <a href="cliente-delete.php?id=' . $item->id . '">
                       <button type="button" class="btn btn-danger"> <i class="fas fa-trash"></i></button>
                       </a>

                      </td>
                      </tr>

                      ';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="3" class="text-center" > Nenhum cliente cadastrado !!!!! </td>
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
                     <div class="row my-7">
                        <div class="col">

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
                           <td colspan="3">
                              <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#modal-default"> <i class="fas fa-plus"></i> &nbsp; Nova</button>
                              <a href="gerar-pdf.php" target="_blank">
                                 <button type="submit" class="btn btn-danger float-right"> <i class="fas fa-print"></i> &nbsp; &nbsp; IMPRIMIR RELATÓRIO</button>
                              </a>
                           </td>
                        </tr>
                        <tr>
                           <th> NOME </th>
                          
                           <th> SETOR </th>
                           <th style="text-align: center; width:200px"> AÇÃO </th>
                        </tr>
                     </thead>
                     <tbody>
                        <?= $resultados ?>
                     </tbody>

                  </table>

               </div>


            </div>

         </div>

      </div>

   </div>

</section>

<?= $paginacao ?>


<div class="modal fade" id="modal-default">
   <div class="modal-dialog ">
      <div class="modal-content bg-light">
         <form action="./cliente-insert.php" method="post">

            <div class="modal-header">
               <h4 class="modal-title">Novo Cliente
               </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">


               <div class="row">

                  <div class="col-12">
                     <div class="form-group">
                        <label>Nome</label>
                        <input style="text-transform:uppercase" type="text" class="form-control" name="nome" required>
                     </div>
                  </div>

                  <div class="col-12">
                     <div class="form-group">
                        <label>Setor</label>
                        <select class="form-control select" style="width: 100%;" name="setores_id">
                           <option value=""> Selecione um setor </option>
                           <?php

                           foreach ($setores as $item) {
                              echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
                           }
                           ?>

                        </select>
                     </div>

                  </div>
                


               </div>


            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
               <button type="submit" class="btn btn-primary">Salvar</button>
            </div>

         </form>

      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>

<!-- EDITAR -->

<div class="modal fade" id="editmodal">
   <div class="modal-dialog">
      <form action="./cliente-edit.php" method="get">
         <div class="modal-content bg-light">
            <div class="modal-header">
               <h4 class="modal-title">Editar Entregador
               </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <input type="hidden" name="id" id="id">

               <div class="row">

                  <div class="col-12">
                     <div class="form-group">
                        <label>Nome</label>
                        <input style="text-transform:uppercase" type="text" class="form-control" name="nome" id="nome" required>
                     </div>
                  </div>

                  <div class="col-12">
                     <div class="form-group">
                        <label>Setor</label>
                        <select class="form-control select" style="width: 100%;" name="setores_id" id="setores_id">
                           <option value=""> Selecione um setor </option>
                           <?php

                           foreach ($setores as $item) {
                              echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
                           }
                           ?>

                        </select>
                     </div>

                  </div>
                 


               </div>


            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
               <button type="submit" class="btn btn-primary">Salvar
               </button>
            </div>
         </div>
      </form>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>