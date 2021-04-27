<?php 
  require_once "vistas/parte_superior.php"; 
?>

<?php require_once "lib/librerias_Superior.php"; ?>
    <?php require_once "lib/librerias_inferior.php"; ?>
<!-- INICIO DEL  CONTENIDO PRINCIPAL -->
<!-- 
<DIv class="container">
  <h1>Contenido Principal</h1>
</DIv> -->

<div class=" container-fluid ">
  <div class="d-sm-flex justify-content-between align-items-center mb-4">
    <h1 class="text-white mb-0">Tablero</h1>
    <!-- <a class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="#"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Generate Report</a> -->
  </div>
  <?php
    require_once("servicios/conexion.php");
    $conex = conexion();
    $sql = "SELECT * FROM partidopolitico order by  codPartido desc";
    $res = mysqli_query($conex, $sql);
    foreach ($res as $fila) {
      echo '
        <div class="row">
        <div class="col">
                  <div class="card shadow mb-4 text-dark ">
                  <div class="card py-3 r3 align-items-center">
                    <h4 class="text-white text-center font-weight-bold ">
                      '. $fila["descrPart"] .' - '.$fila["siglas"].'
                        </h4>
                      </div>
                      </div>
                    </div>
                  
        </div>';
      $sq = "SELECT * FROM movimientos where codPartido= ".$fila['codPartido'];
      $re = mysqli_query($conex, $sq);
      echo '<div class="row">';
      foreach($re as $fil){
        echo '
        
            <div class="col-md-6 col-xl-3 mb-4" href="index.php"
              <a id="link" href="index.php">
                <div class="card shadow border-left-dark cardGan py-2">
                  <div class="card-body">
                    
                    <div class="row">
                      <div class="col-sm-3">
                        <div class="text-uppercase text-white font-weight-bold text-xs mb-1" href="index.php"><img class="img-fluid"  src="img/sicctema.jpeg" alt="logo"></div>
                      </div>
                      <div class="col mb-1">
              
                      </div> 
                        <!-- /.col-sm-6 -->
                      <div class="col-sm-8 align-items-center">
                        <div class="row align-items-center">
                        
                          <span class="text-justify">'.$fil['nombMov'].'</span>     
                        </div>

                        <div class="row align-items-center">
                          <h3>Lista '.$fil['codMov'].'</h3>
                        </div>
                      </div>
                      <!-- /.col-sm-6 -->
                    </div>
                    <!-- /.row -->

                  </div>
                </div>
              </a>
            </div>
        
        
        ';
      }
      echo '</div>';
    }
    cerrarBD($conex);
  ?>
</div>

<!-- FIN DEL CONTENIDO PRINCIPAL -->
<?php require_once "vistas/parte_inferior.php"; ?>
<script src="/internas/js/demo/chart.min.js"></script>
<!-- </body> -->


</html>