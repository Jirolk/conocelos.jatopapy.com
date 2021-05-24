<?php 
  require_once "vistas/parte_superior.php"; 
?>


<div class=" container-fluid ">
  <div class="row">
    <div class="col">
      <div class="align-items-center ">
        <h1 class="text-dark text-center font-weight-bold ">Partidos Politicos</h1>
      </div>
    </div>
  </div>
  <?php
    require_once("../servicios/conexion.php");
    $conex = conexion();
    $sql = "SELECT * FROM partidopolitico order by  codPartido desc";
    $res = mysqli_query($conex, $sql);
    foreach ($res as $fila) {
      echo '
        <div class="row">
        <div class="col">
                  <div class="card shadow mb-4 text-dark ">
                  <div class="card py-3 r3 align-items-center">
                    <h6 class="text-white text-center ">
                      '. $fila["descrPart"] .' - '.$fila["siglas"].'
                        </h6>
                      </div>
                      </div>
                    </div>
                  
        </div>';
      $sq = "SELECT * FROM movimientos where codPartido= ".$fila['codPartido'];
      $re = mysqli_query($conex, $sq);
      echo '<div class="row">';
      foreach($re as $fil){
        echo '
        
          <div class="col-md-6 col-xl-3 mb-4">
          <div class="card shadow border-left-dark cardGan py-2">
          <a  href="../contenido/movimientodetalle.php?id='.$fil['codMov'].'">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-4">
                        <div class="text-uppercase font-weight-bold text-xs mb-1" >
                        <img class="img-fluid rounded mx-auto d-block"  style="width: 100px; height: 100px;"  src="../imgmovimientos/';
                        echo isset($fil['img']) ? $fil['img'] : 'defaultmovimiento.png'; 
                        echo'" alt="../imgmovimientos/defaultmovimiento.png"></div>
                        </div>
                          <div class="col-sm-8 align-items-center">
                            <div class="row align-items-center">
                              <p class="font-weight-bold" > '.$fil['nombMov'].'</p>
                            </div>
                            <div class="row align-items-center">
                              <h6 >Lista '.$fil['codMov'].'</h6>
                            </div>
                                        
                          </div>
                    </div>
                  </div>
                  </a>
                </div>
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
<script src="../js/demo/chart.min.js"></script>
<!-- </body> -->


</html>