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

$result_servico2 = '';
$result_servico = '';
$result_setor = '';
$resultados = '';
$contador  = 0;

foreach ($setores as $item) {

    $result_setor .= '
   <div class="custom-control custom-radio custom-control-inline grande ">
   <input class="form-check-input" type="checkbox" value="' . $item->id . '" name="setores[]" id="[' . $item->id . ']">
   <label for="' . $item->id . '" >' . $item->nome . '</label>
   </div>
    
   ';
}

foreach ($servicos as $item) {

    $result_servico .= '
   <div class="custom-control custom-radio custom-control-inline grande">
   <input class="form-check-input" type="checkbox" value="' . $item->id . '" name="servicos[]" id="[' . $item->id . ']">
   <label for="' . $item->id . '" >' . $item->nome . '</label>
   </div>
    
   ';
}


foreach ($listar as $item) {

    $contador += 1;

    $resultados .= '<tr>
                   
                      <td style="text-transform:uppercase">' . $contador . '</td>
                      <td style="text-transform:uppercase">' . $item->apelido . '</td>
                      <td style="text-transform:uppercase">' . $item->telefone . '</td>
                      <td style="text-transform:uppercase">' . $item->banco . '</td>
                      <td>' . $item->conta . '</td>
                      <td>' . $item->agencia . '</td>
                      <td>' . $item->pix . '</td>
                      
                      <td style="text-align:center">  <button class="btn btn-outline-dark btn-sm" onclick="listarSetores(' . $item->id . ')">SETORES</button></td>
                      <td style="text-align:center">  <button class="btn btn-outline-secondary btn-sm" onclick="listarServicos(' . $item->id . ')">SERVIÇOS</button></td>
                      <td style="text-transform:uppercase"> <h5><span class="badge badge-pill badge-success">' . $item->veiculo . '</span></h5> </td>
                     
                      <td class="centro">
                      
                      <button class="btn btn-info btn-sm" onclick="Editar(' . $item->id . ')"> <i class="fas fa-pencil-alt"></i> &nbsp; Editar</button>
                     
                      &nbsp;
                       <a href="entregador-delete.php?id=' . $item->id . '">
                       <button type="button" class="btn btn-danger btn-sm"> <i class="far fa-trash-alt"></i> &nbsp; Excluir</button>
                       </a>
                   
                   
                      </td>
                      </tr>
                      ';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="10" class="text-center" > Nenhum entregador cadastrado !!!!! </td>
                                                     </tr>';



?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card back-black">
                    <div class="card-header">
                        <button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal-default">
                            <i class="fas fa-plus"></i> &nbsp; Novo</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example" class="table table-light table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th> Nª</th>
                                    <th> NOME DE GUERRA</th>
                                    <th> TELEFONE </th>
                                    <th> BANCO </th>
                                    <th> CONTA </th>
                                    <th> AGÊNCIA </th>
                                    <th> CHAVE PIX </th>
                                    <th style="text-align:center"> SETORES /SERVIÇOS </th>
                                    <th style="text-align:center"> SETORES /SERVIÇOS </th>
                                    <th> VEÍCULOS </th>

                                    <th style="text-align: center; width:200px"> AÇÃO </th>
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
    <div class="modal-dialog modal-xl">
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

                        <div class="col-4">
                            <div class="form-group">
                                <label>CPF</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="cpf"
                                    id="registro">
                            </div>
                        </div>

                        <div class="col-4">
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
                        <div class="col-3">
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
                        <div class="col-3">
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
                        <div class="col-3">
                            <div class="form-group">
                                <label>Regiões</label>
                                <select class="form-control select" style="width: 100%;" name="regioes" id="regioes">
                                    <option value=""> Selecione uma região </option>
                                    <?php

                                    foreach ($regioes as $item) {
                                        echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">

                                <label>Rota</label>
                                <select class="form-control" name="rotas[]" id="rota" multiple></select>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label>Setores</label><br>
                                <?= $result_setor ?>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="form-group">
                                <label>Serviços</label><br>
                                <?= $result_servico ?>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Valor boleto</label>
                                <input style="text-transform:uppercase" type="text" class="form-control "
                                    name="valor_boleto" id="valor1">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Valor Cartão</label>
                                <input style="text-transform:uppercase" type="text" class="form-control "
                                    name="valor_cartao" id="valor2">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Valor Entrega Pequeno</label>
                                <input style="text-transform:uppercase" type="text" class="form-control "
                                    name="valor_pequeno" id="valor3">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Valor entrega grande</label>
                                <input style="text-transform:uppercase" type="text" class="form-control "
                                    name="valor_grande" id="valor4">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Cnh</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="cnh">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Renavam</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="renavam">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label>Veiculos</label>
                                <select class="form-control select" style="width: 100%;" name="veiculos_id" required>
                                    <option value=""> Selecione um veículo </option>
                                    <?php

                                    foreach ($veiculos as $item) {
                                        echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
                                    }
                                    ?>

                                </select>
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
                                <label>Data admissão</label>
                                <input value="<?php
                                                date_default_timezone_set('America/Sao_Paulo');
                                                echo date('Y-m-d\TH:i:s', time()); ?>" type="datetime-local"
                                    class="form-control" name="admissao" id="admissao" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Data recisão</label>
                                <input value="<?php
                                                date_default_timezone_set('America/Sao_Paulo');
                                                echo date('Y-m-d\TH:i:s', time()); ?>" type="datetime-local"
                                    class="form-control" name="recisao" id="recisao" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">

                                <label>Status</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-control ">
                                            <input type="radio" name="status" value="1" checked> Ativo
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <label class="form-control">
                                            <input type="radio" name="status" value="0"> Inativo
                                        </label>
                                    </div>
                                </div>
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




<div class="modal fade" id="listarServicosModal">
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content bg-light">
            <div class="modal-header">
                <h4 class="modal-title">SERVIÇOS
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="">LISTA SERVIÇOS</label>

                <div class="col-12">
                    <span class="listar-modal2"></span>
                </div>


            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>

            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="listarSetorModal">
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content bg-light">
            <div class="modal-header">
                <h4 class="modal-title">SETORES
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="">LISTA DE SETORES</label>

                <div class="col-12">
                    <span class="listar-modal"></span>
                </div>


            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>

            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="modal-data">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <form action="./receber-gerar.php" method="GET" enctype="multipart/form-data">

                <div class="modal-header">
                    <h4 class="modal-title">Relatórios
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">



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
<form action="./entregador-edit.php" method="get">
    <div class="modal fade" id="editModal">
        <div class="modal-dialog modal-xl">

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