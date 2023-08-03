<?php

use App\Session\Login;

require __DIR__ . '../../../vendor/autoload.php';

define('TITLE', 'Adicionar Novos Registros');
define('BRAND', 'Adicionar Arquivos');


Login::requireLogin();



include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/lote/lote-form-boleto.php';
include __DIR__ . '../../../includes/layout/footer.php';