<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Categoria;
use App\Entidy\Produto;


$foto2 = "";
$contador = 0;
$dados = "";
$select1 = "";
$selected = "";
$imagens = "";

$param = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

$value = Produto::getModalID('p.id as id,
p.nome as produto,
p.barra as barra,
p.qtd as qtd,
p.valor_compra as compra,
p.valor_venda as venda,
p.foto as foto,
p.categorias_id as categorias_id, 
c.nome as categoria, 
p.descricao AS descricao', ' produtos AS p
INNER JOIN
categorias AS c ON (p.categorias_id = c.id)','p.id='.$param, null, null);


$id               = $value->id;
$nome             = $value->produto;
$barra            = $value->barra;
$qtd              = $value->qtd;
$valor_compra     = $value->compra;
$valor_venda      = $value->venda;
$foto             = $value->foto;
$categorias_id    = $value->categorias_id;
$categoria        = $value->categoria;
$descricao        = $value->descricao;

$categorias = Categoria :: getList('*','categorias',null, 'nome ASC',null);

if ($foto != "") {

   $imagens .='<img src="../.'.$foto.'" width=50%" id="target">';

} else {

   $imagens .=' <img src="../../imgs/sem-foto.jpg" width="50%" id="target">';
  
}

foreach ($categorias as $item) {
   if($item->id == $categorias_id  ){

      $selected = "selected";
   }else{
      $selected = "";

   }

   $select1 .= '<option value="' . $item->id .'"  '.$selected.'>' . $item->nome . '</option>';
}


$dados .= '    <div class="row">
                  <input type="hidden" name="id" value="' . $id . '">
                  <div class="col-lg-3 col-3">
                     <div id="divImgConta">
                        '.$imagens.'
                     </div>
                  </div>
                  <div class="col-lg-8 col-12 custom-file">
                     <input type="file" name="arquivo" class="form-control" id="imagem" name="arquivo" onChange="carregarImg();">
                     <br>
                     <br>
                     <br>

                  </div>

               </div>

               <div class="row">
                  <div class="col-6">
                     <div class="form-group">
                        <label>Código de Barras</label>
                        <input type="text" class="form-control" name="barra" value="'.$barra.'">
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label>Categorias</label>
                        <select class="form-control select" style="width: 100%;" name="categorias_id">
                           
                           '.$select1.'

                        </select>
                     
                     </div>

                  </div>

               </div>

               <div class="row">
                  <div class="col-6">
                     <div class="form-group">
                        <label>Produto</label>
                        <input type="text" class="form-control texto-grande" name="nome" value="'.$nome.'">
                     </div>

                  </div>

                  <div class="col-3">
                     <div class="form-group">
                        <label>Compra</label>
                        <input  type="text" class="form-control"  name="valor_compra" id="porcentagem" value="'.$valor_compra.'" onchange="Calculo()">
                     </div>

                  </div>

                  <div class="col-3">
                     <div class="form-group">
                        <label>Venda</label>
                        <input type="text" class="form-control" name="valor_venda"  id="resultado" required>
                     </div>

                  </div>


               </div>

               <div class="row">
                  <div class="col-4">
                     <div class="form-group">
                        <label>Quantidade</label>
                        <input type="text" class="form-control" name="qtd" value="'.$qtd .'">
                     </div>

                  </div>

                  <div class="col-8">
                     <div class="form-group">
                        <label>Descrição</label>
                        <textarea class="form-control texto-grande " name="descricao" cols="60" rows="5">'.$descricao .'</textarea>
                     </div>

                  </div>

               </div>

            


';

$retorna = ['erro' => false, 'dados' => $dados];

echo json_encode($retorna);
