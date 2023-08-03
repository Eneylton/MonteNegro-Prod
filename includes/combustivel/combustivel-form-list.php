<?php

$list = '';
$total = 0;

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

    $total += $item->valor;

    $resultados .= '<tr>
                      <td>' . $item->id . '</td>
                      <td>' .  date('d/m/Y', strtotime($item->data))  . '</td>
                      <td>' . $item->veiculo . '</td>
                      <td>' . $item->placa . '</td>
                      <td style="text-transform:uppercase">' . $item->entregador . '</td>
                      <td>R$ ' . number_format($item->valor, "2", ",", ".") . '</td>
                    
                      <td style="text-align: center;">
                      <button class="btn btn-info btn-sm" onclick="Editar(' . $item->id . ')"> <i class="fas fa-pencil-alt"></i> &nbsp; Editar</button>
                      &nbsp;

                       <a href="combustivel-delete.php?id=' . $item->id . '">
                       <button type="button" class="btn btn-danger"> <i class="fas fa-trash"></i></button>
                       </a>


                      </td>
                      </tr>

                      ';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="7" class="text-center" > Nenhuma registro encontrado !!!!! </td>
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


                        </form>

                    </div>
                    <div class="row">

                        <div class="col-12">
                            <button accesskey="r" title="ALT+R" style="margin-left: 10px;" type="submit"
                                class="btn btn-danger float-right" data-toggle="modal" data-target="#modal-data">
                                <i class="fas fa-print"></i> &nbsp; IMPRIMIR RELATÓRIOS
                            </button>
                        </div>

                    </div>

                </div>

                <div class="table-responsive">

                    <table class="table table-bordered table-light table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <td colspan="4">
                                    <button accesskey="q" type="submit" class="btn btn-info" data-toggle="modal"
                                        data-target="#modal-default"> <i class="fas fa-plus"></i> &nbsp;
                                        Novo</button>
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: left; width:80px"> CÓDIGO </th>
                                <th> DATA</th>
                                <th> VEÍCULO</th>
                                <th> PLACA</th>
                                <th> ENTREGADOR</th>
                                <th> VALOR </th>

                                <th style="text-align: center; width:200px"> AÇÃO </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?= $resultados ?>
                        </tbody>

                        <tr>

                            <td colspan="5" style="text-align:right; font-weight:bold">TOTAL GERAL</td>
                            <td colspan="2" style="font-size:25px; font-weight:bold"> R$
                                <?= number_format($total, "2", ",", ".") ?></td>
                        </tr>

                    </table>

                </div>


            </div>

        </div>

    </div>

    </div>

</section>

<?= $paginacao ?>

<div class="modal fade" id="modal-data23">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <form id="form-04" action="./receber-gerar.php" method="GET" enctype="multipart/form-data">

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
                                <input class="form-control" type="date" value="<?php echo date('Y-m-d') ?>"
                                    name="dataInicio">
                            </div>


                            <div class="col-lg-4 col-4">
                                <input class="form-control" type="date" value="<?php echo date('Y-m-d') ?>"
                                    name="dataFim">
                            </div>


                            <div class="col-lg-4 col-4">

                                <select class="form-control select" name="clientes_id">
                                    <option value=""> Clientes </option>
                                    <?php

                                    foreach ($clientes as $item) {
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


<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-light">
            <form action="./combustivel-insert.php" method="post">

                <div class="modal-header">
                    <h4 class="modal-title">Combustível
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Início da entrega</label>
                                <input value="<?php
                                                date_default_timezone_set('America/Sao_Paulo');
                                                echo date('Y-m-d\TH:i:s', time()); ?>" type="datetime-local"
                                    class="form-control" name="data" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>Entregador</label>
                                <select class="form-control select2" style="width: 100%;" name="entregadores_id"
                                    required>
                                    <option value=""> Selecione um entregador </option>
                                    <?php

                                    foreach ($entregadores as $item) {
                                        echo '<option value="' . $item->id . '">' . $item->apelido . '</option>';
                                    }
                                    ?>

                                </select>
                            </div>

                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label>Veículo</label>
                                <select class="form-control select" style="width: 100%;" name="veiculos_id" required>
                                    <option value=""> Selecione</option>
                                    <?php

                                    foreach ($veiculos as $item) {
                                        echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Placa</label>
                                <input type="text" class="form-control" name="placa" id=required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Valor</label>
                                <input type="text" class="form-control" name="valor" id="dinheiro" required>
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

<form action="./combustivel-edit.php" method="GET">
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

<div class="modal fade" id="modal-data">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <form id="form-04" action="./combustivel-gerar.php" method="GET" enctype="multipart/form-data">

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
                                <input class="form-control" type="date" value="<?php echo date('Y-m-d') ?>"
                                    name="dataInicio">
                            </div>


                            <div class="col-lg-4 col-4">
                                <input class="form-control" type="date" value="<?php echo date('Y-m-d') ?>"
                                    name="dataFim">
                            </div>

                            <div class="col-lg-4 col-4">

                                <div class="form-group">

                                    <select class="form-control select2" style="width: 100%;" name="entregadores_id">
                                        <option value=""> Selecione um entregador </option>
                                        <?php
                                        foreach ($entregadores as $item) {
                                            echo '<option value="' . $item->id . '">' . $item->apelido . '</option>';
                                        }
                                        ?>

                                    </select>
                                </div>

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