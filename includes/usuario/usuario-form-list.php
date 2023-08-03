<?php


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

   $resultados .= '<tr>
                      <td>' . $item->id . '</td>
                      <td>' . $item->nome . '</td>
                      <td>' . $item->email . '</td>
                      <td style="text-align: center;">
                        
                      
                      <button type="submit" class="btn btn-success editbtn" > <i class="fas fa-paint-brush"></i> </button>
                      &nbsp;

                       <a href="usuario-delete.php?id=' . $item->id . '">
                       <button type="button" class="btn btn-danger"> <i class="fas fa-trash"></i></button>
                       </a>


                      </td>
                      </tr>

                      ';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="6" class="text-center" > Nenhuma Vaga Encontrada !!!!! </td>
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

                  <table class="table table-bordered table-light table-bordered table-hover table-striped">
                     <thead>
                        <tr>
                           <td colspan="4">
                              <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#modal-default"> <i class="fas fa-plus"></i> &nbsp; Nova</button>
                           </td>
                        </tr>
                        <tr>
                           <th style="text-align: left; width:80px"> CÓDIGO </th>
                           <th> NOME </th>
                           <th> EMAIL </th>
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
   <div class="modal-dialog modal-lg">
      <div class="modal-content bg-light">
         <form action="./usuario-insert.php" method="post">

            <div class="modal-header">
               <h4 class="modal-title">Novo usuário
               </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>Nome</label>
                  <input type="text" class="form-control" name="nome" required>
               </div>

               <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" name="email" required>
               </div>

               <div class="row">
                <div class="col-6">
                <div class="form-group">
                        <label>Cargos</label>
                        <select class="form-control select" style="width: 100%;" name="cargos_id">
                           <option value=""> Selecione um cargo </option>
                           <?php

                           foreach ($cargos as $item) {
                              echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
                           }
                           ?>

                        </select>
                     </div>

              
                </div>
               
                <div class="col-6">

                <div class="form-group">
                        <label>Nível de acesso</label>
                        <select class="form-control select" style="width: 100%;" name="acessos_id" >
                           <option value=""> Selecione um nivel </option>
                           <?php

                           foreach ($acessos as $item) {
                              echo '<option value="' . $item->id . '">' . $item->nivel . '</option>';
                           }
                           ?>

                        </select>
                     </div>
                
                </div>
               
               </div>

               <div class="form-group">
                  <label>Senha</label>
                  <input type="password" placeholder="Senha" id="password" class="form-control" name="senha" required>
               </div>

               <div class="form-group">
                  <label>Confirma Senha</label>
                  <input type="password" placeholder="Confirme Senha" id="confirm_password" class="form-control" required>
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
      <form action="./usuario-edit.php" method="get">
         <div class="modal-content bg-light">
            <div class="modal-header">
               <h4 class="modal-title">Editar Categoria Despesas
               </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <input type="hidden" name="id" id="id">
               <div class="form-group">
                  <label>Nome</label>
                  <input type="text" class="form-control" name="nome" id="nome" required disabled>
               </div>
               <div class="form-group">
                  <label>Email</label>
                  <input type="text" class="form-control" name="email" id="email" required>
               </div>
               <div class="form-group">
                        <label>Cargos</label>
                        <select class="form-control select" style="width: 100%;" name="cargos_id" id="cargos_id">
                           <option value=""> Selecione um cargo </option>
                           <?php

                           foreach ($cargos as $item) {
                              echo '<option value="' . $item->id . '">' . $item->descricao . '</option>';
                           }
                           ?>

                        </select>
                     </div>

                     <div class="form-group">
                        <label>Nível de acesso</label>
                        <select class="form-control select" style="width: 100%;" name="acessos_id" id="acessos_id">
                           <option value=""> Selecione um nivel </option>
                           <?php

                           foreach ($acessos as $item) {
                              echo '<option value="' . $item->id . '">' . $item->nivel . '</option>';
                           }
                           ?>

                        </select>
                     </div>

               <div class="form-group">
                  <label>Senha</label>
                  <input type="password" placeholder="Senha" id="password" class="form-control" name="senha" required disabled>
               </div>

               <div class="form-group">
                  <label>Confirma Senha</label>
                  <input type="password" placeholder="Confirme Senha" id="confirm_password" class="form-control" required disabled>
               </div>
            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary">Salvar
               </button>
            </div>
         </div>
      </form>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>