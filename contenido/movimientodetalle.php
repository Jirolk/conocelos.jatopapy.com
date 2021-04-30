<?php 
  require_once "vistas/parte_superior.php"; 
?>

  <?php 
    //require_once ".././lib/librerias_Superior.php"; 
    //require_once "../lib/librerias_inferior.php"; 
  ?>
<!-- INICIO DEL  CONTENIDO PRINCIPAL -->
<!-- 
<DIv class="container">
  <h1>Contenido Principal</h1>
</DIv> -->

<div class=" container-fluid ">
  <!-- <div class="d-sm-flex justify-content-between align-items-center mb-4"> -->
    <!-- <div class="aling-center">
      <h1 class="text-center">Tablero</h1>
    </div> -->
    <!-- <a class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="#"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Generate Report</a> -->
  <!-- </div> -->
  <?php
    require_once("../servicios/conexion.php");
    $conex = conexion();
    $id = $_GET["id"];
    $sql = "SELECT * FROM movimientos where codMov=".$id;
    $res = mysqli_query($conex, $sql);
    foreach ($res as $fila) {
      echo '
      <div class="aling-center">';
      echo' 
          <img style="width: 150px; height: 150px;" class="rounded mx-auto d-block" href="../index.php"  src="../imgmovimientos/';
      echo isset($fil['img']) ? $fil['img'] : '../imgmovimientos/defaultmovimiento.png'; 
          echo'" alt="logo">
          
        <BR>
      </div>
      ';

      echo '
        <div class="row">
        <div class="col">
                  <div class="card shadow mb-4 text-dark ">
                  <div class="card py-3 r3 align-items-center">
                    <h4 class="text-white text-center font-weight-bold ">
                      '. $fila["nombMov"] .' - '.$fila["siglas"].'
                        </h4>
                      </div>
                      </div>
                    </div>
                  
        </div>';
      $sq = "SELECT * FROM candidatos c
            join candidatura cc on c.codCand = cc.codCand
            where codMov= ".$fila['codMov'];
      $re = mysqli_query($conex, $sq);
      echo '<div class="row">';
      foreach($re as $fil){
        echo '
        
          <div class="col-md-6 col-xl-3 mb-4">
            <a  href="../index.php">
              <div class="card shadow border-left-dark cardGan py-2">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                        <div class="text-uppercase text-white font-weight-bold text-xs mb-1">
                                  <img class="img-fluid img-thumbnail" href="../index.php"  src="../imgcandidatos/';
                                  echo isset($fil['img']) ? $fil['img'] : '../imgcandidatos/defaultcandidato.png'; 
                                  echo'" alt="logo"></div>
                        </div>
                          <div class="col-sm-8 align-items-center">
                            <div class="row align-items-center">
                              <p class="text-white"> '.$fil['nomApe'].'</p>
                            </div>
                            <div class="row align-items-center">
                              <h6>'.$fil['descripcion'].' - Orden: '.$fil['orden'].'</h6>
                            </div>
                                        
                          </div>
                    </div>
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


<!-- <div class="row">

  <div class="col-md-6 col-xl-3 mb-4" href="index.php">
          <a id="link" href="index.php">
            <div class="card shadow border-left-dark cardGan py-2">
              <div class="card-body">
                
                <div class="row">
                  <div class="col-sm-3">
                    <div class="text-uppercase text-white font-weight-bold text-xs mb-1" href="index.php"><img class="img-fluid"  src="img/sicctema.jpeg" alt="logo"></div>
                  </div>
                  <div class="col mb-1">
          
                  </div>  -->
                    <!-- /.col-sm-6 -->
                  <!-- <div class="col-sm-8 align-items-center">
                    <div class="row align-items-center">
                      <span class=" font-weight-bold txto">'.$fil['nombMov'].'</span>     
                      <span class="text-justify">Movimiento infernal de pollos satanicos anti LGBT+XYZ999</span>     
                    </div>

                    <div class="row align-items-center">
                      <h3>Lista 69</h3>
                    </div>
                  </div> -->
                  <!-- /.col-sm-6 -->
                <!-- </div> -->
                <!-- /.row -->
<!-- 
              </div>
            </div>
          </a>
        </div>

</div> -->


<!-- FIN DEL CONTENIDO PRINCIPAL -->
<?php require_once "vistas/parte_inferior.php"; ?>
<script src="../js/demo/chart.min.js"></script>
<!-- </body> -->


</html>