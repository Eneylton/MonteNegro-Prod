<?php
require __DIR__ . '../../../vendor/autoload.php';

use   App\Db\Pagination;
use   App\Entidy\Carteira;
use   App\Session\Login;

define('TITLE', 'Carteiras');
define('BRAND', 'Carteiras');


Login::requireLogin();

$listar = Carteira::getList(
    ' e.id AS id, e.tipo AS tipo, e.forma_pagamento_id AS forma_pagamento_id, e.apelido AS apelido,
                              e.cnh AS cnh,e.renavam AS renavam,e.apelido AS entregador,e.cpf AS cpf,e.telefone AS telefone,
                              e.email AS email,e.banco AS banco,e.veiculos_id AS veiculos_id,
                              e.agencia AS agencia,e.conta AS conta,e.pix AS pix,v.nome AS veiculo',
    'entregadores AS e INNER JOIN veiculos AS v ON (e.veiculos_id = v.id)',
    'e.status = 1 ',
    null,
    'e.apelido ASC',
    null
);



include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/carteira/carteira-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';

?>

<script>
    $(document).ready(function() {
        $('.editbtn').on('click', function() {
            $('#editmodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            $('#id').val(data[0]);
            $('#entregador').val(data[1]);
            $('#telefone').val(data[2]);
            $('#email').val(data[3]);
            $('#banco').val(data[4]);
            $('#conta').val(data[5]);
            $('#agencia').val(data[6]);
            $('#rotas_id').val(data[7]);
            $('#regioes_id').val(data[8]);
            $('#veiculos_id').val(data[9]);
            $('#rota').val(data[10]);
            $('#regiao').val(data[11]);
            $('#veiculo').val(data[12]);
            $('#cpf').val(data[13]);
            $('#pix').val(data[14]);
            $('#cnh').val(data[15]);
            $('#renavam').val(data[16]);
            $('#apelido').val(data[17]);
            $('#tipo').val(data[18]);
            $('#forma_pagamento_id').val(data[19]);

        });
    });
</script>