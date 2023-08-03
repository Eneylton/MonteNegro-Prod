<?php

$qtd_total = 0;
$entrega_total = 0;
$devolucao_total = 0;

foreach ($quantidades as $value) {
   
   $qtd_total += $value->total;

}

foreach ($entregas as $item)
 {
   $entrega_total += $item->total;
}
foreach ($devolucao as $item)
 {
   $devolucao_total += $item->total;
}

?>

<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-6">
            <div class="card">
               <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                     <h1 class="card-title grande" style="font-size:20px">CLIENTE: <?= $cliente_nome ?></h1>
                     <a style="font-size:18px" href="#">TOTAL RECEBIDO --  [ <?=  $qtd_total ?> ]</a>
                  </div>
               </div>
               <div class="card-body">
                 

                  <div class="card-body">

                     <canvas id="myChart" width="400" height="100"></canvas>
                  </div>

                  <div class="d-flex flex-row justify-content-end">
                     <span class="mr-2">
                        <i class="fas fa-square text-warning"></i> Recebidos: 
                     </span>

                    
                  </div>

                 
               </div>
            </div>



         </div>

         <div class="col-lg-6">
            <div class="card">
               <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                     <h3 class="card-title">
                        <P>ENTREGAS / DEVOLUÇÕES</P>
                     </h3>
                     <a href="javascript:void(0);">RELATÓRIO DETALHADO</a>
                  </div>
               </div>
               <div class="card-body">
                  <div class="d-flex">
                     
                     
                  </div>
                  <!-- /.d-flex -->

                  <div class="card-body">

                     <canvas id="myChart2" width="400" height="100"></canvas>

                  </div>

                  <div class="d-flex flex-row justify-content-end">
                     <span class="mr-2">
                        <i class="fas fa-square text-success"></i> Entrga: <?=  $entrega_total ?>
                     </span>

                     <span>
                        <i class="fas fa-square text-danger"></i> Devolução: <?= $devolucao_total ?>
                     </span>
                  </div>
               </div>
            </div>



         </div>


         <div class="col-lg-4">
            <div class="card">
               <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                     <h3 class="card-title">
                        <P>OCORRÊNCIAS</P>
                     </h3>
                     <a href="javascript:void(0);">RELATÓRIO DETALHADO</a>
                  </div>
               </div>
               <div class="card-body">
                  <div class="d-flex">
                     
                     
                  </div>
                  <!-- /.d-flex -->

                  <div class="card-body">

                     <canvas id="myChart3" ></canvas>

                  </div>

                 
               </div>
            </div>



         </div>

         <div class="col-lg-4">
            <div class="card">
               <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                     <h3 class="card-title">
                        <P>TOTAL DE ENTREGA POR ENTREGADORES</P>
                     </h3>
                     <a href="javascript:void(0);">RELATÓRIO DETALHADO</a>
                  </div>
               </div>
               <div class="card-body">
                  <div class="d-flex">
                     
                     
                  </div>
                  <!-- /.d-flex -->

                  <div class="card-body">

                     <canvas id="myChart4" ></canvas>

                  </div>

                
               </div>
            </div>



         </div>
         <div class="col-lg-4">
            <div class="card">
               <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                     <h3 class="card-title">
                        <P>TOTAL DE SERVIÇOS</P>
                     </h3>
                     <a href="javascript:void(0);">RELATÓRIO DETALHADO</a>
                  </div>
               </div>
               <div class="card-body">
                  <div class="d-flex">
                     
                     
                  </div>
                  <!-- /.d-flex -->

                  <div class="card-body">

                     <canvas id="myChart5" ></canvas>

                  </div>

                
               </div>
            </div>



         </div>
         
</section>