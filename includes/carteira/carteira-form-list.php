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
$contador  = 0;

foreach ($listar as $item) {
    $contador += 1;

    $resultados .= '<tr>
   
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
   <button type="submit" class="btn btn-dark btn-block" > <i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp; CARTEIRA</button>
   <a>

   </td>
   </tr>
   ';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                  <td colspan="11" class="text-center" > Nenhum entregador cadastrado !!!!! </td>
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
            <form action="./gaiola-insert.php" method="post">

                <div class="modal-header">
                    <h4 class="modal-title">Nova Baia
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>Nome da Baia</label>
                        <input style="text-transform:uppercase" type="text" class="form-control" name="nome" required>
                    </div>


                    <div class="row">

                        <div class="col-6">

                            <div class="form-group">
                                <label>qtd</label>
                                <input style="text-transform:uppercase" type="text" class="form-control" name="qtd"
                                    required>
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


<form action="./gaiola-edit.php" method="get">
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