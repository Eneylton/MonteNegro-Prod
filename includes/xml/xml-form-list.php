<?php

use App\Entidy\NotaFiscal;

$chave            = "";
$chave            = "";
$cUF              = "";
$cNF              = "";
$natOp            = "";
$indPag           = "";
$mod              = "";
$serie            = "";
$nNF              = "";
$tpNF =            "";
$cMunFG =          "";
$tpImp =           "";
$tpEmis =          "";
$cDV =             "";
$tpAmb =           "";
$emit_CPF =        "";
$emit_CNPJ =       "";
$emit_xNome =      "";
$emit_xFant =      "";
$emit_xLgr =       "";
$emit_nro =        "";
$emit_xBairro =    "";
$emit_cMun =       "";
$emit_xMun =       "";
$emit_UF =         "";
$emit_CEP =        "";
$emit_cPais =      "";
$emit_xPais =      "";
$emit_fone =       "";
$emit_IE =         "";
$emit_IM =         "";
$emit_CNAE =       "";
$dest_cnpj =       "";
$dest_xNome =      "";
$dest_xLgr =       "";
$dest_nro =        "";
$dest_xBairro =    "";
$dest_cMun =       "";
$dest_xMun =       "";
$dest_UF =         "";
$dest_CEP =        "";
$dest_cPais =      "";
$dest_xPais =      "";
$dest_IE =         "";
$vBC =             "";
$vBC =             "";
$vICMS =           "";
$vICMS =           "";
$vBCST =           "";
$vBCST =           "";
$vST =             "";
$vST =             "";
$vProd =           "";
$vProd =           "";
$vNF =             "";
$vNF =             "";
$vFrete =          "";
$vSeg =            "";
$vDesc =           "";
$vIPI =            "";
$nProt =           "";
$un     =          "";
$resultados = '';
$contador  = 0;

$listar = NotaFiscal::getList('*', 'notafiscal', 'day(data) = DAY(CURRENT_DATE())');

foreach ($listar as $item) {

    $contador += 1;

    $resultados .= '<tr>
        <td>' . $contador . '</td>
        <td>' . date('d/m/Y  Á\S  H:i:s', strtotime($item->data)) . '</td>
        <td>' . $item->notafiscal . ' - ' . $item->serie . '</td>
        <td>' . $item->razaosocial . '</td>
        <td>' . $item->chave . '</td>
        <td><i style="color:#21f33c" class="fas fa-check"></i></td>
      
        <td style="text-align: center;">
          
         <a href="cargo-delete.php?id=' . $item->id . '">
         <button type="button" class="btn btn-danger"> <i class="fas fa-trash"></i></button>
         </a>
        </td>
        </tr>

        ';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                       <td colspan="7
                                       " class="text-center" > Nenhum registro cadastrado !!!!</td>
                                       </tr>';


?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card bg-dark">
                        <div class="modal-body">
                            <form id="form1" action="xml-list.php" method="post" enctype="multipart/form-data">
                                <div class="row">

                                    <div class="col-6">

                                        <input type="file" name="arquivo[]" class="form-control" value="" id="imagem"
                                            name="arquivo" multiple>


                                    </div>

                                    <div class=" col-6">

                                        <button type="submit" class="btn btn-primary">CARREGAR XML</button>

                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">

                        <table id="example" class="table table-bordered table-bordered table-hover table-striped">
                            <thead>

                                <tr>
                                    <th style="text-align: left; width:80px"> Nº</th>
                                    <th> DATA </th>
                                    <th> Nº DA NOTA FISCAL</th>
                                    <th> RAZÃO SOCIAL</th>
                                    <th> CHAVE</th>
                                    <th> STATUS</th>

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