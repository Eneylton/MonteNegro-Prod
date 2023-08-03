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
                      <td style="display:none">' . $item->id . '</td>
                      <td style="display:none">' . $item->entregador . '</td>
                      <td style="display:none">' . $item->telefone  . '</td>
                      <td style="display:none">' . $item->email . '</td>
                      <td style="display:none">' . $item->banco . '</td>
                      <td style="display:none">' . $item->conta . '</td>
                      <td style="display:none">' . $item->agencia . '</td>
                      <td style="display:none">' . $item->veiculos_id . '</td>
                      <td style="display:none">' . $item->veiculo . '</td>
                      <td style="display:none">' . $item->cpf . '</td>
                      <td style="display:none">' . $item->pix . '</td>
                      <td style="display:none">' . $item->cnh . '</td>
                      <td style="display:none">' . $item->renavam . '</td>
                      <td style="display:none">' . $item->apelido . '</td>
                      <td style="display:none">' . $item->tipo . '</td>
                      <td style="display:none">' . $item->forma_pagamento_id . '</td>
                    
                      <td style="text-transform:uppercase">' . $item->apelido . '</td>
                      <td style="text-transform:uppercase">' . $item->telefone . '</td>
                      <td>' . $item->email . '</td>
                      <td style="text-transform:uppercase">' . $item->banco . '</td>
                      <td>' . $item->conta . '</td>
                      <td>' . $item->pix . '</td>
                      <td>' . $item->agencia . '</td>
                      <td style="text-transform:uppercase"> <h5><span class="badge badge-pill badge-primary">' . $item->veiculo . '</span></h5> </td>
                     
                      <td style="text-align: center; width:300px">
                      <a href="detalhe-edit.php?id=' . $item->id . '">
                      <button type="submit" class="btn btn-default" > <i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp; DETALHE</button>
                      <a>
                      <a href="carteira-edit.php?id=' . $item->id . '">
                      <button type="submit" class="btn btn-danger" > <i class="fa fa-th-list" aria-hidden="true"></i>&nbsp; CARTEIRA</button>
                      <a>
                      </td>
                      </tr>
                      ';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="11" class="text-center" > Nenhum entregador cadastrado !!!!! </td>
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
                                    <td colspan="11">
                                        <button type="submit" class="btn btn-info" data-toggle="modal"
                                            data-target="#modal-default"> <i class="fas fa-plus"></i> &nbsp;
                                            Nova</button>
                                        <a href="gerar-pdf.php" target="_blank">
                                            <button type="submit" class="btn btn-light float-right"> <i
                                                    class="fas fa-print"></i> &nbsp; &nbsp; IMPRIMIR RELATÓRIO</button>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th> NOME DE GUERRA</th>
                                    <th> TELEFONE </th>
                                    <th> EMAIL </th>
                                    <th> BANCO </th>
                                    <th> AGÊNCIA </th>
                                    <th> CONTA </th>
                                    <th> CHAVE PIX </th>
                                    <th> VEÍCULOS </th>

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
            <form action="./entregador-insert.php" method="post">

                <div class="modal-header">
                    <h4 class="modal-title">Novo Entregador
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <div class="row">

                        <div class="col-6">
                            <div class="form-group">
                                <label>Nome</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="nome">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Nome de guerra</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="apelido">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>CPF</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="cpf"
                                    id="registro">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Telefone</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="telefone"
                                    id="cel">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input style="text-transform:uppercase" type="text" class="form-control " name="email">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Tipo Contratação</label>
                                <select class="form-control" name="tipo" required>
                                    <option value="">Selecione</option>
                                    <option value="CLT">CLT</option>
                                    <option value="PJ">PJ</option>
                                    <option value="ESTÁGIO">ESTÁGIO</option>
                                    <option value="CONTRATAÇÃO TEMPORÁRIA">CONTRATAÇÃO TEMPORÁRIA</option>
                                    <option value="JOVEM APRENDIZ">JOVEM APRENDIZ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Forma de Pagamento</label>
                                <select class="form-control select" style="width: 100%;" name="forma_pagamento_id"
                                    required>
                                    <option value=""> Selecione um pagamento </option>
                                    <?php

                           foreach ($pagamentos as $item) {
                              echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
                           }
                           ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Cnh</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="cnh">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Renavam</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="renavam">
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label>Banco</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="banco">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Agência</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="agencia">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Conta</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="conta">
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label>Chave pix</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="pix">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label>Regiao</label>
                                <select class="form-control select" style="width: 100%;" name="regioes" id="regioes"
                                    required>
                                    <option value=""> Selecione uma região </option>
                                    <?php

                           foreach ($regioes as $item) {
                              echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
                           }
                           ?>

                                </select>
                            </div>

                        </div>
                        <div class="col-4">
                            <div class="form-group">

                                <label>Rota</label>
                                <select class="form-control" name="rota" id="rota" required></select>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label>Veiculos</label>
                                <select class="form-control select" style="width: 100%;" name="veiculos_id" require>
                                    <option value=""> Selecione um veículo </option>
                                    <?php

                           foreach ($veiculos as $item) {
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
    <div class="modal-dialog modal-lg">
        <form action="./entregador-edit.php" method="get">
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

                        <div class="col-6">
                            <div class="form-group">
                                <label>Nome</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="nome"
                                    id="entregador">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Nome de guerra</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="apelido"
                                    id="apelido">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>CPF</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="cpf"
                                    id="cpf">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Telefone</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="telefone"
                                    id="telefone">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="email"
                                    id="email">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label>Tipo Contratação</label>
                                <select class="form-control" name="tipo" id="tipo" required>
                                    <option value="">Selecione</option>
                                    <option value="CLT">CLT</option>
                                    <option value="PJ">PJ</option>
                                    <option value="ESTÁGIO">ESTÁGIO</option>
                                    <option value="CONTRATAÇÃO TEMPORÁRIA">CONTRATAÇÃO TEMPORÁRIA</option>
                                    <option value="JOVEM APRENDIZ">JOVEM APRENDIZ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Forma de Pagamento</label>
                                <select class="form-control select" style="width: 100%;" name="forma_pagamento_id"
                                    id="forma_pagamento_id" required>
                                    <option value=""> Selecione um pagamento </option>
                                    <?php

                           foreach ($pagamentos as $item) {
                              echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
                           }
                           ?>

                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Cnh</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="cnh"
                                    id="cnh">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Renavam</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="renavam"
                                    id="renavam">
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label>Banco</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="banco"
                                    id="banco">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Agência</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="agencia"
                                    id="agencia">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Conta</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="conta"
                                    id="conta">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label>Chave pix</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="pix"
                                    id="pix">
                            </div>
                        </div>


                        <div class="col-4">
                            <div class="form-group">
                                <label>Veículos</label>
                                <select class="form-control select" style="width: 100%;" name="veiculos_id"
                                    id="veiculos_id" required>

                                    <?php

                           foreach ($veiculos as $item) {
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
                    <button type="submit" class="btn btn-primary">Salvar
                    </button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>