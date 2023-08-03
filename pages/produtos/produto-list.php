<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Categoria;
use App\Entidy\Produto;
use App\Session\Login;

define('TITLE','Lista de Produtos');
define('BRAND','Produtos');

Login::requireLogin();

$foto2 = "";

$listar = Produto::getList('p.id as id,
                            p.codigo as codigo,
                            p.barra as barra,
                            p.nome as nome,
                            p.foto as foto,
                            p.qtd as  qtd,
                            p.descricao as descricao,
                            p.valor_compra as valor_compra,
                            p.valor_venda as valor_venda,
                            p.categorias_id as categorias_id,
                            c.nome as categoria',
                            'produtos AS p
                             INNER JOIN
                             categorias AS c ON (p.categorias_id = c.id)',null, 'p.id DESC',null);

$categorias = Categoria :: getList('*','categorias');

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/produto/produto-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';

?>

<script>

async function Editar(id){
    const dadosResp = await fetch('produto-modal.php?id=' + id);
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

<script>

$("#compra1").on("change", function(){

    var idCompra = $("#compra1").val();
    $.ajax({
        url:'produto-list.php',
        type:'POST',
        data:{
            id:idCompra
        },
        success: function(data){
            $('#venda1').val(Number((idCompra) / 0.40).toFixed(2));
        }

    })

});

</script> 


<script>
async function Calculo(valor) {
    var id = $("#porcentagem").val();
    $.ajax({

        data:{
            id:id
        },
        success: function(data){
            var resposta =  $('#resultado').val(Number((id) / 0.40).toFixed(2));
        }

    });
}
</script> 

