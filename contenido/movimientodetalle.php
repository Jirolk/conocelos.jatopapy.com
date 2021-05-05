<?php 
  require_once "vistas/parte_superior.php"; 
?>


<div class=" container-fluid ">
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
          <img style="width: 130px; height: 130px;" class="rounded mx-auto d-block"  src="../imgmovimientos/';
          
          echo isset($fila['img']) ? $fila['img'] : 'defaultmovimiento.png'; 
          echo'" alt="logo">
          
        
      </div>
      ';

      echo '
          <h2 class=" text-center font-weight-bold ">
            '. $fila["nombMov"] .' - '.$fila["siglas"].' - LISTA '.$fila["codMov"].'
          </h2>
          
        ';
        echo '
        <div class="row">
          <div class="col">
                    <div class="card shadow mb-4  ">
                      <div class="card py-3 r3 align-items-center">
                            <h5 class=" text-center font-weight-bold ">
                              CANDIDATO A INTENDENTE
                            </h5>
                      </div>
                    </div>
            </div>
                  
        </div>';
      $sq = "SELECT * FROM candidatos c
            join candidatura cc on c.codCand = cc.codCand
            where codMov= ".$fila['codMov']." AND c.codCand=1" ;
      $re = mysqli_query($conex, $sq);
      if(!empty($re)) {
        echo '
              <h5 class="text-center font-weight-bold ">
                ESTA LISTA NO PRESENTA CANDIDATO A INTENDENCIA
              </h5>
        <br>
       ';
      }else {
        echo '<div class="row">';
         foreach($re as $fil){
        
          echo '
          
            <div class="col-md-6 col-xl-3 mb-4">
              <a  href="../contenido/perfilcandidato.php?id='.$fil['ci'].'">
                <div class="card shadow border-left-dark cardGan py-2">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-4">
                          <div class="text-uppercase font-weight-bold text-xs mb-1">
                                    <img class="img-fluid rounded mx-auto d-block" href="../index.php"  src="../imgcandidatos/';
                                    echo isset($fil['img']) ? $fil['img'] : '../imgcandidatos/defaultcandidato.png'; 
                                    echo'" alt="logo"></div>
                          </div>
                            <div class="col-sm-8 align-items-center">
                              <div class="row align-items-center">
                                <p class=" text-left font-weight-bold"> '.$fil['nomApe'].'</p>
                              </div>
                              <div class="row align-items-center">
                                <h6 class="text-left font-weight-bold">'.$fil['descripcion'].' </h6>
                              </div>
                              <div class="row align-items-center">
                                <h6 class=" text-left font-weight-bold">Orden: '.$fil['orden'].'</h6>
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
      echo '
      <div class="row">
        <div class="col">
                  <div class="card shadow mb-4 ">
                    <div class="card py-3 r3 align-items-center">
                          <h5 class=" text-center font-weight-bold ">
                            CANDIDATOS A JUNTA MUNICIPAL
                          </h5>
                    </div>
                  </div>
          </div>
                
      </div>';
      $sq = "SELECT * FROM candidatos c
        join candidatura cc on c.codCand = cc.codCand
        where codMov= ".$fila['codMov']." AND c.codCand=2" ;
      $re = mysqli_query($conex, $sq);
      echo '<div class="row">';
      foreach($re as $fil){
        echo '
        
          <div class="col-md-6 col-xl-3 mb-4">
          <div class="card shadow border-left-dark cardGan py-2">
          <a  href="../contenido/perfilcandidato.php?id='.$fil['ci'].'">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-4">
                        <div class="text-uppercase  font-weight-bold text-xs mb-1">
                                  <img class="img-fluid rounded mx-auto d-block" href="../index.php"  src="../imgcandidatos/';
                                  echo isset($fil['img']) ? $fil['img'] : '../imgcandidatos/defaultcandidato.png'; 
                                  echo'" alt="logo"></div>
                        </div>
                          <div class="col-sm-8 align-items-center">
                            <div class="row align-items-center">
                              <p class=" text-left font-weight-bold"> '.$fil['nomApe'].'</p>
                            </div>
                            <div class="row align-items-center">
                              <h6 class=" text-left font-weight-bold">'.$fil['descripcion'].' </h6>
                            </div>
                            <div class="row align-items-center">
                              <h6 class=" text-left font-weight-bold">Orden: '.$fil['orden'].'</h6>
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