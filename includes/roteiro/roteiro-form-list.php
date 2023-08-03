<?php

use App\Entidy\EntreRotas;

$list = '';


$resultados = '';

foreach ($listar as $item) {

   $resultados .= '
<tr data-widget="expandable-table" aria-expanded="true">
<td style="font-weight: 600;text-transform:uppercase;"">' . $item->entregador . '</td>
<td>' . $item->id . '</td>

</tr>

<tr class="expandable-body">
<td>
';
   $listar2 = EntreRotas::getEntregadorID('er.id as id,
r.nome as roteiro', 'entregador_rota AS er
INNER JOIN
rotas AS r ON (r.id = er.rotas_id)', $item->id_entregador, null, null, null);

   foreach ($listar2 as $item2) {

      $resultados .= ' <p style="text-align:left;text-transform:uppercase;">
' . $item2->roteiro . '
</p>';
   }

   $resultados .= '</td>
</tr>';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="2" class="text-center" > Nenhum Roteiro Encontrada !!!!! </td>
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

                                    <th style="text-align:center;font-size:18px; color:#0f7043"> ENTREGADORES E ROTEIROS
                                    </th>
                                    <th style="text-align:left; width:10px;">CÓDIGO</th>

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


<div class=" modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content bg-light">
            <form action="./regiao-insert.php" method="post">

                <div class="modal-header">
                    <h4 class="modal-title">Novo região
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Região</label>
                        <input type="text" class="form-control" name="nome" required>
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
    <div class="modal-dialog">
        <form action="./regiao-edit.php" method="get">
            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h4 class="modal-title">Editar
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" class="form-control" name="nome" id="nome" required>
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