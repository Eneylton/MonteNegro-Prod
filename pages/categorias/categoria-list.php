<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Db\Pagination;
use App\Entidy\Categoria;
use App\Session\Login;

define('TITLE','Lista de Categorias');
define('BRAND','Cargos');

Login::requireLogin();

$foto2 ='';
$foto3 ='';

$listar = Categoria::getList('*','categorias',null, 'id desc',null);

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/categoria/categoria-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';

?>

<script>

async function Editar(id){
    const dadosResp = await fetch('categoria-modal.php?id=' + id);
    const result = await dadosResp.json();
  
    const editModal = new bootstrap.Modal(document.getElementById("editModal"));
    editModal.show();
    document.querySelector(".edit-modal").innerHTML = result['dados'];
 
}

</script>

<script type="text/javascript">

    function carregarImg() {

        var target = document.getElementById('target');
        var file = document.querySelector("input[type=file]").files[0];
        var reader = new FileReader();

        reader.onloadend = function () {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);


        } else {
            target.src = "";
        }
    }

</script>

<script type="text/javascript">

    function carregarImgEdit() {

        var target = document.getElementById('target');
        var file = document.querySelector("input[type=file]").files[0];
        var reader = new FileReader();

        reader.onloadend = function () {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);


        } else {
            target.src = "";
        }
    }

</script>