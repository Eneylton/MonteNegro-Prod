<?php

use App\Entidy\Categoria;

require __DIR__ . '../../../vendor/autoload.php';

$dados = "";
$foto3 = "";
$imagens = "";
$contador = 0;

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

$value = Categoria::getID('*','categorias',$id ,null,null);

$id_prod = $value->id;
$nome    = $value->nome;
$foto3   = $value->foto;

if ($foto3 != "") {

   $imagens .='<img src="../.'.$foto3.'" width=50%" id="target">';

} else {

   $imagens .=' <img src="../../imgs/sem-foto.jpg" width="50%" id="target">';
  
}

$dados .= '<div class="row">

            <div class="col-4" id="divImgConta">
               
               <input type="hidden" name="id" value="'.$id.'">

               '.$imagens.'
   
            </div>

            <div class="col-lg-8 col-12 custom-file">
                        <input type="file" name="arquivo" class="form-control" value="'.$foto3.'" name="arquivo" onChange="carregarImgEdit();">
                        <br>
                     </div>

                     <div class="col-lg-12 col-12">
                        <label >Nome</label>
                        <input type="text" class="form-control" name="nome" id="nome" value="'.$nome.'" required>
                     </div>

          </div>';

                $retorna = ['erro' => false, 'dados' => $dados];

                echo json_encode($retorna);



?>
