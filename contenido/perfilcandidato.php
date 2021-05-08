<?php 
  require_once "vistas/parte_superior.php"; 
?>


<div class=" container-fluid ">

  <?php
    require_once("../servicios/conexion.php");
    $conex = conexion();
    $id = $_GET["id"];
    $sql = "SELECT c.*,cc.descripcion,cd.*,cm.codMov,cm.nombMov,cm.siglas AS sgl,cm.codMov,pp.descrPart,pp.siglas FROM candidatos c
                INNER JOIN movimientos cm ON c.codMov = cm.codMov
                INNER JOIN partidopolitico pp ON cm.codPartido= pp.codPartido
                INNER JOIN candidatura cc ON c.codCand = cc.codCand
                INNER JOIN candidatodetalle cd ON c.ci = cd.ci
            WHERE c.ci=".$id;
    $res = mysqli_query($conex, $sql);
    foreach ($res as $fila) {
      setlocale(LC_TIME,"es_es.UTF-8");
      list($año,$mes,$dia) = explode("-",date($fila['fechaNac']));
      $Fecha= gmmktime(12,0,0,$mes,$dia,$año);      
      echo '
      <div class="aling-center">';
      echo' 
          <img style="width: 130px; height: 130px;" class="rounded mx-auto d-block"  src="../imgcandidatos/';
          echo isset($fila['img']) ? $fila['img'] : 'defaultcandidato.png'; 
          echo'" alt="logo">
      </div>';

      echo '
          <h2 class="py-2 text-center font-weight-bold ">
            '. $fila["nomApe"] .'
          </h2>
          
        ';

        echo'<div class=" container text-center ">
                    <label for="detalle" class="py-1 font-weight-bold">Filtro de datos</label>
                    <select class="form-control text-uppercase text-center col col-md-12" name="detalle" id="detalle"  onchange="habilitar(value);">';
                        echo "<option value='0'>Todos los datos</option>";
                        echo '<option value="1" >';
                        echo 'Datos peronales';
                        echo "</option>";
                        echo '<option value="2" >';
                        echo 'Cuestionario';
                        echo "</option>";
        echo'       </select>
                <div class="" id="CampoBusqueda"></div>
                <div id="BusAvan"></div>
            </div> 
            <hr class="divider">';

        echo '
        <div class="row">
          <div class="col">
                    <div class="card shadow mb-2  ">
                      <div class="card py-3 r3 align-items-center">
                            <h5 class=" text-center font-weight-bold ">
                              DATOS PERSONALES
                            </h5>
                      </div>
                    </div>
            </div>
        </div>';
         echo '
         <div class="row">
            <div class="col">
                <div class="card shadow mb-2  ">
                    <div class="card py-2 r2 align-items-center">
                      <ul>
                      <li>
                      <div class="">
                        <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Cédula de Identidad Nº: </h6>
                        
                      </div>
                    </li>
                    <li>
                      <p class="text-uppercase text-dark p-1 text-center font-weight">'.$fila['ci'].'</p>
                    </li>
                    <li>
                      <div class="">
                        <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Lugar y Fecha de Nacimiento: </h6>
                        
                      </div>
                    </li>
                    <li>
                      <p class="text-uppercase text-dark p-1 text-center font-weight">'.$fila['lugarNac'].', '.strftime(" %d de %B de %Y", $Fecha).'.</p>
                    </li>
                    <li>
                      <div class="">
                        <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Correo electrónico: </h6>
                        
                      </div>
                    </li>
                    <li>
                      <p class="text-uppercase text-dark p-1 text-center font-weight">'.$fila['nomApe'].'</p>
                    </li>
                    <li>
                      <div class="">
                        <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Número de Contacto para la ciudadanía: </h6>
                        
                      </div>
                    </li>
                    <li>';
                    $cons = "SELECT * FROM contacto WHERE codDetalle =".$fila['codDetalle'];
                          $resp = mysqli_query($conex, $cons);
                          foreach($resp as $fi){
                          echo '  <p class="text-uppercase text-dark p-1 text-center font-weight">0'.$fi['numCntacto'].'</p>';
                          }
                    echo '</li>
                        <li>
                          <div class="">
                            <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Partido Politico: </h6>
                          </div>
                        </li>
                        <li>
                            <p class="text-uppercase text-dark p-1 text-center font-weight">'.$fila['descrPart']." - ".$fila['siglas'].'</p>
                        </li>
                        <li>
                          <div class="">
                            <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Movimiento: </h6>
                            </div>
                        </li>
                        <li>
                            <p class="text-uppercase text-dark p-1 text-center font-weight">'.$fila['nombMov']." - ".$fila['sgl']." - LISTA ".$fila['codMov'].'</p>
                        </li>
                        <li>
                          <div class="">
                            <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Candidatura: </h6>
                          </div>
                        </li>
                        <li>
                          <p class="text-uppercase text-dark p-1 text-center font-weight">'.$fila['descripcion']." - Orden N° - ".$fila['orden'].'</p>
                        </li>

                        <li>
                          <div class="">
                            <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Perfiles en Redes Sociales: </h6>
                            
                          </div>
                        </li>
                        <li>';
                          $cons = "SELECT * FROM redessociales WHERE codDetalle =".$fila['codDetalle'];
                          $resp = mysqli_query($conex, $cons);
                          foreach($resp as $fi){
                            if (strcasecmp($fi['redSocial'],"FACEBOOK") == 0) {
                              echo '
                              <p class="text-uppercase text-dark p-1 text-center font-weight">
                                <a  href="'.$fi['url'].'">
                                  <i class="fab fa-facebook-square " style="color: black;"></i>
                                </a>
                              </P>';
                            }
                            if (strcasecmp($fi['redSocial'],"INSTAGRAM") == 0) {
                              echo '
                              <p class="text-uppercase text-dark p-1 text-center font-weight">
                                <a  href="'.$fi['url'].'">
                                  <i class="fab fa-instagram-square " style="color: black;"></i>
                                </a>
                              </P>';
                            }
                            if (strcasecmp($fi['redSocial'],"TWITTER") == 0) {
                              echo '
                              <p class="text-uppercase text-dark p-1 text-center font-weight">
                                <a  href="'.$fi['url'].'">
                                  <i class="fab fa-twitter-square " style="color: black;"></i>
                                </a>
                              </P>';
                            }
                            if (strcasecmp($fi['redSocial'],"YOUTUBE") == 0) {
                              echo '
                              <p class="text-uppercase text-dark p-1 text-center font-weight">
                                <a  href="'.$fi['url'].'">
                                  <i class="fab fa-youtube-square " style="color: black;"></i>
                                </a>
                              </P>';
                            }
                          }
                        echo '</li>
                      </ul>
                    </div>
                </div>
            </div>
            
         </div>
         <div class="row">';
         //foreach($re as $fil){
        
        /*  echo '
          

            <div class="col-md-6 col-xl-3 mb-4">
              
                <div class="card shadow border-left-dark cardGan py-2">
                  <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="text-uppercase font-weight-bold text-xs mb-1">
                                <img class="img-fluid rounded mx-auto d-block" href="../index.php"  src="../imgcandidatos/';
                                echo isset($fila['img']) ? $fila['img'] : '../imgcandidatos/defaultcandidato.png'; 
                                echo'" alt="logo"></div>
                            </div>
                                <div class="col-sm-8 align-items-center">
                                    <div class="row align-items-center">
                                        <p class=" text-left font-weight-bold"> '.$fila['nomApe'].'</p>
                                    </div>
                                    <div class="row align-items-center">
                                        <h6 class="text-left font-weight-bold">'.$fila['descripcion'].' </h6>
                                    </div>
                                    <div class="row align-items-center">
                                        <h6 class=" text-left font-weight-bold">Orden: '.$fila['orden'].'</h6>
                                    </div>
                                            
                                </div>
                        </div>
                    </div>
                  </div>
              
            </div>
          ';*/
        //}
        echo '</div>';
      //}
      echo '
      <div class="row">
        <div class="col">
                  <div class="card shadow mb-4 ">
                    <div class="card py-3 r3 align-items-center">
                          <h5 class=" text-center font-weight-bold ">
                            CUESTIONARIO
                          </h5>
                    </div>
                  </div>
          </div>
                
      </div>';
      /*$sq = "SELECT * FROM candidatos c
        join candidatura cc on c.codCand = cc.codCand
        where codMov= ".$fila['codMov']." AND c.codCand=2" ;*/
      $sq = "SELECT * FROM respuestas WHERE idResp =17";
      $re = mysqli_query($conex, $sq);
      echo '<div class="row">';
      foreach($re as $fil){
        echo '
        
          <div class="col-md-6 col-xl-3 mb-4">
            
              <div class="card shadow border-left-dark cardGan py-2">
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
                              <p class=" text-left font-weight-bold"> '.$fil['detResp'].'</p>
                            </div>
                            <div class="row align-items-center">
                              <h6 class=" text-left font-weight-bold">'.$fil['idPreg'].' </h6>
                            </div>
                            <div class="row align-items-center">
                              <h6 class=" text-left font-weight-bold">Orden: '.$fil['ci'].'</h6>
                            </div>
                                        
                          </div>
                    </div>
                  </div>
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