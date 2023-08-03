<?php

require __DIR__ . '../../../vendor/autoload.php';

$alertaCadastro = '';

define('TITLE', 'Gráficos');
define('BRAND', 'Baias');

use App\Entidy\Backlog;
use App\Entidy\Entrega;
use App\Entidy\Gaiola;
use App\Entidy\Retgaiola;
use App\Session\Login;

$total = 0;
$nome = "";

Login::requireLogin();



$gaiolas = Gaiola :: getList('g.id AS id,
g.nome AS gaiola,
g.data AS data,
sum(g.qtd) as total','gaiolas AS g group by g.nome');

$retorno = Retgaiola :: getList('rg.id as id,
e.apelido as apelido,
sum(rg.qtd) as total','retorno_gaiola AS rg
INNER JOIN
entregadores AS e ON (rg.entregadores_id = e.id) group by e.apelido');

$backlog = Backlog :: getList('bk.id as id,
e.apelido as apelido,
sum(bk.qtd) as total',' backlog AS bk
INNER JOIN
entregadores AS e ON (bk.entregadores_id = e.id) group by e.apelido');

$ocorrencias = Backlog :: getList(' bk.id as id,
o.nome as ocorrencia,
sum(bk.qtd) as total',' backlog AS bk
INNER JOIN
ocorrencias AS o ON (bk.ocorrencias_id = o.id) group by o.nome');



include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/gaiola/gaiola-grafico-list.php';
include __DIR__ . '../../../includes/layout/footer.php';

?>

<script type="text/javascript">
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [

            <?php
           
            foreach ($gaiolas as $item) {
           
                echo "'".$item->gaiola."',";
            }
             
            ?>
        ]
        ,
        datasets: [{
            label: '• PRODUÇÃO MENSAL •',
            data: [
                <?php
            foreach ($gaiolas as $item) {
                echo "'".$item->total."',";
            }
             
            ?>
            ],
            backgroundColor: [
                '#ffc107cc',
                '#9d64a480',
                '#ee901d8f',
                '#d12f61',
                '#3d606c',
                '#F0379A',
                '#763dd986',
                '#d0ff0093',
                '#3794F0',
                '#ff00ff',
                '#ff0000',
                '#121212'
            ],
            borderColor: [
                '#ffc107cc',
                '#9d64a480',
                '#ee901d8f',
                '#d12f61',
                '#3d606c',
                '#F0379A',
                '#763dd986',
                '#d0ff0093',
                '#3794F0',
                '#ff00ff',
                '#ff0000',
                '#121212'
             
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>

<script type="text/javascript">
var ctx = document.getElementById('myChart2').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [

            <?php
           
            foreach ($retorno as $item) {
           
                echo "'".$item->apelido."',";
            }
             
            ?>
        ]
        ,
        datasets: [{
            label: '• RETORNO A BAIAS •',
            data: [
                <?php
            foreach ($retorno as $item) {
                echo "'".$item->total."',";
            }
             
            ?>
            ],
            backgroundColor: [
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
             
            ],
            borderColor: [
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc',
                '#ffc107cc'
             
            ],
            borderWidth: 1
        },
        
        {
            label: '• BACKLOG •',
            data: [
                <?php
            foreach ($backlog as $item) {
                echo "'".$item->total."',";
            }
             
            ?>
            ],
            backgroundColor: [
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000'
            ],
            borderColor: [
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000',
                '#ff0000'
             
            ],
            borderWidth: 1
        }
        
        ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>
<script type="text/javascript">
var ctx = document.getElementById('myChart3').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'polarArea',
    data: {
        labels: [

            <?php
           
            foreach ($ocorrencias as $item) {
           
                echo "'".$item->ocorrencia."',";
            }
             
            ?>
        ]
        ,
        datasets: [{
            label: '• OCORRÊNCIAS •',
            data: [
                <?php
            foreach ($ocorrencias as $item) {
                echo "'".$item->total."',";
            }
             
            ?>
            ],
            backgroundColor: [
                '#6fe633a8',
                '#9d64a480',
                '#ee901d8f',
                '#d12f61',
                '#3d606c',
                '#F0379A',
                '#763dd986',
                '#d0ff0093',
                '#3794F0',
                '#ff00ff',
                '#ff0000',
                '#121212'
            ],
            borderColor: [
                '#6fe633a8',
                '#9d64a480',
                '#ee901d8f',
                '#d12f61',
                '#3d606c',
                '#F0379A',
                '#763dd986',
                '#d0ff0093',
                '#3794F0',
                '#ff00ff',
                '#ff0000',
                '#121212'
             
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>



<script type="text/javascript">
var ctx = document.getElementById('myChart4').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: [

            <?php
           
            foreach ($ocorrencias as $item) {
           
                echo "'".$item->ocorrencia."',";
            }
             
            ?>
        ]
        ,
        datasets: [{
            label: '• OCORRÊNCIAS •',
            data: [
                <?php
            foreach ($ocorrencias as $item) {
                echo "'".$item->total."',";
            }
             
            ?>
            ],
            backgroundColor: [
                '#6fe633a8',
                '#9d64a480',
                '#ee901d8f',
                '#d12f61',
                '#3d606c',
                '#F0379A',
                '#763dd986',
                '#d0ff0093',
                '#3794F0',
                '#ff00ff',
                '#ff0000',
                '#121212'
            ],
            borderColor: [
                '#6fe633a8',
                '#9d64a480',
                '#ee901d8f',
                '#d12f61',
                '#3d606c',
                '#F0379A',
                '#763dd986',
                '#d0ff0093',
                '#3794F0',
                '#ff00ff',
                '#ff0000',
                '#121212'
             
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>

