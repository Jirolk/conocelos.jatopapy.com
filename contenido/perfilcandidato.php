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
                    <select id="filtro" class="form-control text-uppercase text-center col col-md-12" onchange="habilitar(value);">';
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
        <div id="datPers" class="row">
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
         <div id="datPersDet" class="row">
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
                      <p class=" text-dark p-1 text-center font-weight">'.$fila['email'].'</p>
                    </li>
                    
                    <li class="d-flex justify-content-center">
                      <div class=" col-md-4  ">
                        <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Formación Académica: </h6>
                        <p class="text-uppercase text-dark p-1 text-center font-weight">'.$fila['formacAca'].'</p>
                        
                      </div>
                    </li>

                    <li class="d-flex justify-content-center">
                      <div class=" col-md-4  ">
                        <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Formación Profesional: </h6>
                        
                        <p class=" text-uppercase text-dark p-1 text-center font-weight">'.$fila['formacProf'].'</p>
                      </div>
                    </li>
                    <li class="d-flex justify-content-center">
                      <div class=" col-md-4  ">
                        <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Experiencia Laboral o Profesional: </h6>
                        <p class="text-uppercase text-dark p-1 text-center font-weight">'.$fila['experLab'].'</p>
                      </div>
                    </li>
                    <li>
                      <div class="">
                        <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Profesión u Ocupación Actual: </h6>
                        
                      </div>
                    </li>
                    <li>
                      <p class="text-uppercase text-dark p-1 text-center font-weight">'.$fila['profeOcupActual'].'</p>
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
                          echo '  <p class="text-uppercase text-dark  text-center font-weight">0'.$fi['numCntacto'].'</p>';
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
                        </li>';
                        $cons = "SELECT * FROM redessociales WHERE codDetalle =".$fila['codDetalle'];
                        $resp = mysqli_query($conex, $cons);
                        if(empty($resp)) {

                        }else {
                          echo '<li>
                          <div class="">
                          <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Perfiles en Redes Sociales: </h6>
                          
                          </div>
                          </li>
                          <li>';
                          echo '<p class="text-uppercase text-dark p-1 text-center font-weight">';
                          foreach($resp as $fi){
                            if (strcasecmp($fi['redSocial'],"FACEBOOK") == 0) {
                              echo '
                              <a  href="'.$fi['url'].'">
                              <i class="h3 fab fa-facebook-square " style="color: black;"></i>
                                </a>';
                              }
                              if (strcasecmp($fi['redSocial'],"INSTAGRAM") == 0) {
                              echo '
                              
                              <a  href="'.$fi['url'].'">
                              
                                  <i class="h3 fab fa-instagram " style="color: black;"></i>
                                  </a>
                              ';
                            }
                            if (strcasecmp($fi['redSocial'],"TWITTER") == 0) {
                              echo '
                              
                              <a  href="'.$fi['url'].'">
                              <i class="h3 fab fa-twitter-square " style="color: black;"></i>
                              </a>
                              ';
                            }
                            if (strcasecmp($fi['redSocial'],"YOUTUBE") == 0) {
                              echo '
                              
                              <a  href="'.$fi['url'].'">
                              <i class="h3 fab fa-youtube-square " style="color: black;"></i>
                              </a>
                              ';
                            }
                          }
                        }
                            echo'</P>';
                        echo '</li>
                      </ul>
                    </div>
                </div>
            </div>
            
         </div>
         <div class="row">';
        echo '</div>';
      echo '
      <div class="row">
        <div class="col">
                  <div class="card shadow mb-2 ">
                    <div class="card py-3 r3 align-items-center">
                          <h5 class=" text-center font-weight-bold ">
                            CUESTIONARIO
                          </h5>
                    </div>
                  </div>
          </div>
                
      </div>';
      $sq = "SELECT * FROM respuestas r
              INNER JOIN preguntas p ON r.idPreg = p.idPreg
              WHERE ci =".$id;
      $result = mysqli_query($conex, $sq);
      foreach($result as $row){
                        echo '
                           <div class="row">
                              <div class="col">
                                  <div class="card shadow mb-2  ">
                                      <div class="card py-2 r2 ">
                                        <ul>';
                                          
                        echo ' <li class="d-flex justify-content-center">
                                <div class=" col-md-8  justify-content-center">
                                  <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">'.$row['idPreg'].' - '.$row['detPreg'].'</h6>
                                  <p class="text-uppercase text-dark p-1 text-justify font-weight">'.$row['detResp'].'</p>
                                  </div>
                              </li>';
                              echo '</ul>
                          </div>
                      </div>
                  </div>
                  
               </div>';
                        }
                      
    }
    cerrarBD($conex);
  ?>
</div>

<!-- FIN DEL CONTENIDO PRINCIPAL -->
<?php require_once "vistas/parte_inferior.php"; ?>
<script src="../js/demo/chart.min.js"></script>
<!-- </body> -->
<script>
  function habilitar(value) {
      var sele = document.getElementById("filtro");
      if (sele.options[sele.selectedIndex].value == 1) {
          document.getElementById("CampoBusqueda").innerHTML = "<input id='nroCaja'class='form-control' placeholder='000'> "
          $("#nroCaja").focus();

      } else if (sele.options[sele.selectedIndex].value == 2) {
          document.getElementById("CampoBusqueda").innerHTML = "<label for='fec1'class=''>Desde:</label><input  id='fec1' type='date' class='form-control'><label for='fec2' class=''>Hasta:</label><input  id='fec2' type='date' class='form-control mb-4'>"
          $("#fec1").focus();
      } else if (sele.options[sele.selectedIndex].value == 3) {
          document.getElementById("CampoBusqueda").innerHTML = "<label for='fec3'class=''>Desde:</label><input  id='fec3' type='date' class='form-control'><label for='fec4' class=''>Hasta:</label><input  id='fec4' type='date' class='form-control mb-4'>"
          $("#fec3").focus();
      } else if (sele.options[sele.selectedIndex].value == 4) {
          document.getElementById("CampoBusqueda").innerHTML = "<input  id='razon' class='form-control' placeholder='Nombre...'> "
          $("#razon").focus();
      } else if (sele.options[sele.selectedIndex].value == 5) {
          document.getElementById("CampoBusqueda").innerHTML = `<select name="" id="estado" class="form-control mb-4">
          <option value="0">Generar por:</option>
          <option value="1">Activo</option>
          <option value="2">Ocupado</option>
        </select>`;

          $("#estado").focus();
      } else if (sele.options[sele.selectedIndex].value == 6) {
          document.getElementById("CampoBusqueda").innerHTML = `<select name="" id="condicion" class="form-control mb-4">
          <option value="0">Generar por:</option>
          <option value="1">Contado</option>
          <option value="2">Crédito</option>        
        </select>`;
          $("#condicion").focus();
      }
  }
</script>


</html>