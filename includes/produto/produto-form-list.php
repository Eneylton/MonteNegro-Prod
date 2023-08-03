<?php

$list = '';
$resultados = '';
$contador = 0;

foreach ($listar as $item) {

   $contador += 1;

   if (empty($item->foto)) {
      $foto = './imgs/sem-foto.jpg';
   } else {
      $foto = $item->foto;
   }

   $resultados .= '<tr>
   <td>' . $contador . '</td>
   <td><img style="width:50px; heigth:50px" src="../.' . $foto . '" class="img-thumbnail"></td>   
   <td style="text-align:left;text-transform: uppercase; font-size:20px"><span style="font-size:20px" class="barra">' . $item->barra . '</span></td>
   <td style="text-transform: uppercase; font-size:20px" class="texto-grande">' . $item->categoria . '</td>
   <td style="text-transform: uppercase; font-size:20px"  class="texto-grande">' . $item->nome . '</td>
   <td style="text-align:center">
     
     <span style="font-size:30px" class="' . ($item->qtd <= 3 ? 'badge badge-danger' : 'badge badge-primary') . '">' . $item->qtd . '</span>
     
   </td>
   <td style="text-align:center"> <button style="font-weight:600; font-size:20px" type="button" class="btn btn-warning"> R$ ' . number_format($item->valor_compra, "2", ",", ".") . '</button></td>
   
   <td style="text-align:center"> <button style="font-weight:600; font-size:20px" type="button" class="btn btn-info"> R$ ' . number_format($item->valor_venda, "2", ",", ".") . '</button></td>
 

   <td class="centro">
   
   <button class="btn btn-light btn-sm" onclick="Editar(' . $item->id . ')"> <i class="fas fa-pencil-alt"></i> &nbsp; Editar</button>
  
   &nbsp;
    <a href="produto-delete.php?id=' . $item->id . '">
    <button type="button" class="btn btn-light btn-sm"> <i class="far fa-trash-alt"></i> &nbsp; Excluir</button>
    </a>
   </td>
  </tr>

   ';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                  <td colspan="9" class="text-center" > Nenhum produto encontrado !!!!! </td>
                                  </tr>';

?>

<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">

            <div class="card back-black">
               <div class="card-header">
                  <button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal-default"> <i class="fas fa-plus"></i> &nbsp; Novo</button>
               </div>
               <!-- /.card-header -->
               <div class="card-body">
                  <table id="example" class="table table-dark table-hover table-bordered table-striped">
                     <thead>
                        <tr>

                           <th> Nº</th>
                           <th> FOTO</th>
                           <th> COD BARRAS </th>
                           <th> CATEGORIAS </th>
                           <th> NOME DO PRODUTO </th>
                           <th style="text-align:center"> ESTOQUE </th>
                           <th style="text-align:center"> COMPRA </th>
                           <th style="text-align:center"> VENDA </th>
                           <th style="text-align: center;"> AÇÃO </th>
                        </tr>
                     </thead>
                     <tbody>
                        <?= $resultados ?>
                     </tbody>
                     <tfoot>
                        <tr>
                           <th colspan="5" class="direita"> EM ESTOQUE </th>
                        
                           <th>10</th>
                           <th>20</th>
                           <th>20</th>
                           <th></th>
                           
                        </tr>
                     </tfoot>
                  </table>
               </div>

            </div>

         </div>

      </div>

   </div>

</section>


<div class="modal fade" id="modal-default">
   <div class="modal-dialog modal-lg">
      <div class="modal-content bg-light">
         <form action="./produto-insert.php" method="post" enctype="multipart/form-data">

            <div class="modal-header">
               <h4 class="modal-title">Novo produto
               </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-lg-3 col-3">
                     <div id="divImgConta">
                        <?php if ($foto2 != "") { ?>
                           <img src="../../imgs/<?php echo $foto2 ?>" width=50%" id="target">
                        <?php  } else { ?>
                           <img src="../../imgs/sem-foto.jpg" width="50%" id="target">
                        <?php } ?>
                     </div>
                  </div>
                  <div class="col-lg-8 col-12 custom-file">
                     <input type="file" name="arquivo" class="form-control" value="<?php echo $foto2 ?>" id="imagem" name="arquivo" onChange="carregarImg();">
                     <br>
                  </div>

               </div>
               <br>

               <div class="row">
                  <div class="col-6">
                     <div class="form-group">
                        <label>Código de Barras</label>
                        <input type="text" class="form-control" name="barra">
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label>Categorias</label>
                        <select class="form-control select2" style="width: 100%;" name="categorias_id">
                           <option value=""> Selecione uma categoria </option>
                           <?php

                           foreach ($categorias as $item) {
                              echo '<option style="text-transform:uppercase;" value="' . $item->id . '">' . $item->nome . '</option>';
                           }
                           ?>

                        </select>
                     </div>

                  </div>

               </div>

               <div class="row">
                  <div class="col-6">
                     <div class="form-group">
                        <label>Nome do produto</label>
                        <input type="text" class="form-control" name="nome" style="text-transform: uppercase;">
                     </div>

                  </div>

                  <div class="col-3">
                     <div class="form-group">
                        <label>Compra</label>
                        <input placeholder="R$ 0,00" type="text" class="form-control" name="valor_compra" id="compra1"  required>
                     </div>

                  </div>

                  <div class="col-3">
                     <div class="form-group">
                        <label>Venda</label>
                        <input placeholder="R$ 0,00" type="text" class="form-control" name="valor_venda" id="venda1" required>
                     </div>

                  </div>


               </div>

               <div class="row">
                  <div class="col-4">
                     <div class="form-group">
                        <label>Quantidade</label>
                        <input type="text" class="form-control" name="qtd">
                     </div>

                  </div>

                  <div class="col-8">
                     <div class="form-group">
                        <label>Descrição</label>
                        <textarea class="form-control" name="aplicacao" cols="60" rows="5" style="text-transform: uppercase;"></textarea>
                     </div>

                  </div>

               </div>

            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
               <button type="submit" class="btn btn-primary">Salvar</button>
            </div>

         </form>

      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>


<form action="./produto-edit.php" method="POST" enctype="multipart/form-data">
   <div class="modal fade" id="editModal">
      <div class="modal-dialog modal-lg">

         <div class="modal-content bg-light">
            <div class="modal-header">
               <h4 class="modal-title">Editar
               </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">


               <span class="edit-modal"></span>

            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
               <button type="submit" class="btn btn-primary">Salvar
               </button>
            </div>
         </div>

         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
</form>