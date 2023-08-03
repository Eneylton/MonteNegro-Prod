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

foreach ($listar as $item) {

   if (empty($item->foto)) {
      $foto = './imgs/sem-foto.jpg';
   } else {
      $foto = $item->foto;
   }

$resultados .= '<tr>
                     <td><img style="width:200px; heigth:200px" src="../.' . $foto . '" class="img-thumbnail"></td>   

                     <td style="text-transform:Uppercase;" >' . $item->nome . '</td>

                     <td class="centro">
                      
                     <button class="btn btn-light btn-sm" onclick="Editar(' . $item->id . ')"> <i class="fas fa-pencil-alt"></i> &nbsp; Editar</button>
                    
                     &nbsp;
                      <a href="categoria-delete.php?id=' . $item->id . '">
                      <button type="button" class="btn btn-light btn-sm"> <i class="far fa-trash-alt"></i> &nbsp; Excluir</button>
                      </a>


                     </td>
                  </tr>';
}


?>

<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">

            <div class="card back-black">
               <div class="card-header">
                  <button title="ALT+Q" accesskey="q" type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal-default"> <i class="fas fa-plus"></i> &nbsp; Novo</button>
               </div>
               <!-- /.card-header -->
               <div class="card-body">
                  <table id="example" class="table table-dark table-hover table-bordered table-striped">
                     <thead>
                        <tr>
                           <th style="width: 30px;">ID</th>
                           <th>NOME</th>
                           <th style="text-align: center; width: 200px;">AÇÕES</th>

                        </tr>
                     </thead>
                     <tbody>
                        <?= $resultados ?>

                  </table>
               </div>

            </div>

         </div>

      </div>

   </div>

</section>

<div class="modal fade" id="modal-default">
   <div class="modal-dialog">
   <div class="modal-content bg-light">
         <form action="./categoria-insert.php" method="post" enctype="multipart/form-data">

            <div class="modal-header">
               <h4 class="modal-title">Nova categoria
               </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="card-body">

               <div class="form-group">

                  <div class="row">
                     <div class="col-lg-3 col-3">
                        <div >
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

                     <div class="col-lg-12 col-12">
                        <label>Nome</label>
                        <input type="text" class="form-control caixa-alta" name="nome" required autofocus>
                     </div>
                  </div>
               </div>

            </div>
            <div class="modal-footer justify-content-between">
               <button accesskey="w" title="ALT-W" type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
               <button accesskey="s" title="ALT+S" type="submit" class="btn btn-primary">Salvar</button>
            </div>

         </form>

      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>


<form action="./categoria-edit.php" method="POST" enctype="multipart/form-data">
   <div class="modal fade" id="editModal">
      <div class="modal-dialog">

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