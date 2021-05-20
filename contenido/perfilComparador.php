<?php
require_once "vistas/parte_superior.php";
?>


<div class=" container-fluid ">

  <?php
  require_once("../servicios/conexion.php");
  $conex = conexion();
  $id = $_GET["id"];
  $id2 = $_GET["id2"];
  ?>
   
  <div class="row">
   
    <div class="col col-sm-6">


      <?php

      $sql = "SELECT c.*,cc.descripcion,cd.*,cm.codMov,cm.nombMov,cm.siglas AS sgl,cm.codMov,pp.descrPart,pp.siglas FROM candidatos c
                  INNER JOIN movimientos cm ON c.codMov = cm.codMov
                  INNER JOIN partidopolitico pp ON cm.codPartido= pp.codPartido
                  INNER JOIN candidatura cc ON c.codCand = cc.codCand
                  INNER JOIN candidatodetalle cd ON c.ci = cd.ci
              WHERE c.ci=" . $id;

      $res = mysqli_query($conex, $sql);
      $num_reg = mysqli_num_rows($res);
      if ($num_reg > 0) {

        foreach ($res as $fila) {
          setlocale(LC_TIME, "es_es.UTF-8");
          list($año, $mes, $dia) = explode("-", date($fila['fechaNac']));
          $Fecha = gmmktime(12, 0, 0, $mes, $dia, $año);
          echo '
              <div class="aling-center">';
          echo ' 
                  <img style="width: 130px; height: 130px;" class="rounded mx-auto d-block"  src="../imgcandidatos/';
          echo isset($fila['img']) ? $fila['img'] : 'defaultcandidato.png';
          echo '" alt="logo">
              </div>';

          echo '
                  <h2 class="py-2 text-center font-weight-bold ">
                    ' . $fila["nomApe"] . '
                  </h2>
                  
                ';

          echo '<div class=" container text-center ">
                            <label for="detalle" class="py-1 font-weight-bold">Filtro de datos</label>
                            <select id="filtro"  class="form-control text-uppercase text-center col col-md-12" onchange="habilitar(value);">';
          echo '<option selected value="0">Todos los datos</option>';
          echo '<option value="1" >';
          echo 'Datos personales';
          echo "</option>";
          echo '<option value="2" >';
          echo 'Cuestionario';
          echo "</option>";
          echo '       </select>
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
                                <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Lugar y Fecha de Nacimiento: </h6>
                                
                              </div>
                            </li>
                            <li>
                              <p class="text-uppercase text-dark p-1 text-center font-weight">' . $fila['lugarNac'] . ', ' . strftime(" %d de %B de %Y", $Fecha) . '.</p>
                            </li>
                            <li>
                              <div class="">
                                <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Correo electrónico: </h6>
                                
                              </div>
                            </li>
                            <li>
                              <p class=" text-dark p-1 text-center font-weight">' . $fila['email'] . '</p>
                            </li>
                            
                            <li class="d-flex justify-content-center">
                              <div class=" col-md-4  ">
                                <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Formación Académica: </h6>
                                <p class="text-uppercase text-dark p-1 text-center font-weight">' . $fila['formacAca'] . '</p>
                                
                              </div>
                            </li>

                            <li class="d-flex justify-content-center">
                              <div class=" col-md-4  ">
                                <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Formación Profesional: </h6>
                                
                                <p class=" text-uppercase text-dark p-1 text-center font-weight">' . $fila['formacProf'] . '</p>
                              </div>
                            </li>
                            <li class="d-flex justify-content-center">
                              <div class=" col-md-4  ">
                                <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Experiencia Laboral o Profesional: </h6>
                                <p class="text-uppercase text-dark p-1 text-center font-weight">' . $fila['experLab'] . '</p>
                              </div>
                            </li>
                            <li>
                              <div class="">
                                <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Profesión u Ocupación Actual: </h6>
                                
                              </div>
                            </li>
                            <li>
                              <p class="text-uppercase text-dark p-1 text-center font-weight">' . $fila['profeOcupActual'] . '</p>
                            </li>
                            <li>
                              <div class="">
                                <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Número de Contacto para la ciudadanía: </h6>
                                
                              </div>
                            </li>
                            <li>';
          $cons = "SELECT * FROM contacto WHERE codDetalle =" . $fila['codDetalle'];
          $resp = mysqli_query($conex, $cons);
          foreach ($resp as $fi) {
            echo '  <p class="text-uppercase text-dark  text-center font-weight">0' . $fi['numCntacto'] . '</p>';
          }
          echo '</li>
                                <li>
                                  <div class="">
                                    <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Partido Politico: </h6>
                                  </div>
                                </li>
                                <li>
                                    <p class="text-uppercase text-dark p-1 text-center font-weight">' . $fila['descrPart'] . " - " . $fila['siglas'] . '</p>
                                </li>
                                <li>
                                  <div class="">
                                    <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Movimiento: </h6>
                                    </div>
                                </li>
                                <li>
                                    <p class="text-uppercase text-dark p-1 text-center font-weight">' . $fila['nombMov'] . " - " . $fila['sgl'] . " - LISTA " . $fila['codMov'] . '</p>
                                </li>
                                <li>
                                  <div class="">
                                    <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Candidatura: </h6>
                                  </div>
                                </li>
                                <li>
                                  <p class="text-uppercase text-dark p-1 text-center font-weight">' . $fila['descripcion'] . " - Orden N° - " . $fila['orden'] . '</p>
                                </li>';
          $cons = "SELECT * FROM redessociales WHERE codDetalle =" . $fila['codDetalle'];
          $resp = mysqli_query($conex, $cons);
          if (empty($resp)) {
          } else {
            echo '<li>
                                  <div class="">
                                  <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Perfiles en Redes Sociales: </h6>
                                  
                                  </div>
                                  </li>
                                  <li>';
            echo '<p class="text-uppercase text-dark p-1 text-center font-weight">';
            foreach ($resp as $fi) {
              if (strcasecmp($fi['redSocial'], "FACEBOOK") == 0) {
                echo '
                                      <a  href="' . $fi['url'] . '" TARGET="_blank">
                                      <i class="h3 fab fa-facebook-square " style="color: black;"></i>
                                        </a>';
              }
              if (strcasecmp($fi['redSocial'], "INSTAGRAM") == 0) {
                echo '
                                      
                                      <a  href="' . $fi['url'] . '" TARGET="_blank">
                                      
                                          <i class="h3 fab fa-instagram " style="color: black;"></i>
                                          </a>
                                      ';
              }
              if (strcasecmp($fi['redSocial'], "TWITTER") == 0) {
                echo '
                                      
                                      <a  href="' . $fi['url'] . '" TARGET="_blank">
                                      <i class="h3 fab fa-twitter-square " style="color: black;"></i>
                                      </a>
                                      ';
              }
              if (strcasecmp($fi['redSocial'], "YOUTUBE") == 0) {
                echo '
                                      
                                      <a  href="' . $fi['url'] . '" TARGET="_blank">
                                      <i class="h3 fab fa-youtube-square " style="color: black;"></i>
                                      </a>
                                      ';
              }
            }
          }
          echo '</P>';
          echo '</li>
                              </ul>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="row">';
          echo '</div>';
          echo '
              <div id="cuest" class="row">
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
                  WHERE ci =" . $id;
          $result = mysqli_query($conex, $sq);
          echo '<div id="cuestDetalle" class="mb-2 ">';
          foreach ($result as $row) {
            echo '
                            <div  class="row">
                              <div class="col">
                                  <div class="card shadow mb-2  ">
                                      <div class="card py-2 r2 ">
                                        <ul>';
            echo ' <li class="d-flex justify-content-center">
                                                  <div class=" col-md-8  justify-content-center">
                                                    <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">' . $row['idPreg'] . ' - ' . $row['detPreg'] . '</h6>
                                                    <p class="text-uppercase text-dark p-1 text-justify font-weight">' . $row['detResp'] . '</p>
                                                    </div>
                                                </li>';
            echo '</ul>
                              </div>
                          </div>
                      </div>
                      
                  </div>';
          }
        }
        echo "</div>";
      } else {
        echo "<h1 class='text-danger'>No hay Registros</h1>";
      }
      ?>


    </div>

    <div class="col col-sm-6">

      <?php
      $sql1 = "SELECT c.*,cc.descripcion,cd.*,cm.codMov,cm.nombMov,cm.siglas AS sgl,cm.codMov,pp.descrPart,pp.siglas FROM candidatos c
                INNER JOIN movimientos cm ON c.codMov = cm.codMov
                INNER JOIN partidopolitico pp ON cm.codPartido= pp.codPartido
                INNER JOIN candidatura cc ON c.codCand = cc.codCand
                INNER JOIN candidatodetalle cd ON c.ci = cd.ci
            WHERE c.ci=" . $id2;
      $res = mysqli_query($conex, $sql1);
      $num_reg = mysqli_num_rows($res);
      if ($num_reg > 0) {

        foreach ($res as $fila) {
          setlocale(LC_TIME, "es_es.UTF-8");
          list($año, $mes, $dia) = explode("-", date($fila['fechaNac']));
          $Fecha = gmmktime(12, 0, 0, $mes, $dia, $año);
          echo '
          <div class="aling-center">';
          echo ' 
              <img style="width: 130px; height: 130px;" class="rounded mx-auto d-block"  src="../imgcandidatos/';
          echo isset($fila['img']) ? $fila['img'] : 'defaultcandidato.png';
          echo '" alt="logo">
          </div>';

          echo '
              <h2 class="py-2 text-center font-weight-bold ">
                ' . $fila["nomApe"] . '
              </h2>
              
            ';

          echo '<div class=" container text-center ">
                        <label for="detalle" class="py-1 font-weight-bold">Filtro de datos</label>
                        <select id="filtro2"  class="form-control text-uppercase text-center col col-md-12" onchange="habilitar(value);">';
          echo '<option selected value="0">Todos los datos</option>';
          echo '<option value="1" >';
          echo 'Datos personales';
          echo "</option>";
          echo '<option value="2" >';
          echo 'Cuestionario';
          echo "</option>";
          echo '       </select>
                    <div class="" id="CampoBusqueda"></div>
                    <div id="BusAvan"></div>
                </div> 
                <hr class="divider">';

          echo '
            <div id="datPers1" class="row">
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
            <div id="datPersDet1" class="row">
                <div class="col">
                    <div class="card shadow mb-2  ">
                        <div class="card py-2 r2 align-items-center">
                          <ul>
                          
                        <li>
                          <div class="">
                            <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Lugar y Fecha de Nacimiento: </h6>
                            
                          </div>
                        </li>
                        <li>
                          <p class="text-uppercase text-dark p-1 text-center font-weight">' . $fila['lugarNac'] . ', ' . strftime(" %d de %B de %Y", $Fecha) . '.</p>
                        </li>
                        <li>
                          <div class="">
                            <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Correo electrónico: </h6>
                            
                          </div>
                        </li>
                        <li>
                          <p class=" text-dark p-1 text-center font-weight">' . $fila['email'] . '</p>
                        </li>
                        
                        <li class="d-flex justify-content-center">
                          <div class=" col-md-4  ">
                            <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Formación Académica: </h6>
                            <p class="text-uppercase text-dark p-1 text-center font-weight">' . $fila['formacAca'] . '</p>
                            
                          </div>
                        </li>

                        <li class="d-flex justify-content-center">
                          <div class=" col-md-4  ">
                            <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Formación Profesional: </h6>
                            
                            <p class=" text-uppercase text-dark p-1 text-center font-weight">' . $fila['formacProf'] . '</p>
                          </div>
                        </li>
                        <li class="d-flex justify-content-center">
                          <div class=" col-md-4  ">
                            <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Experiencia Laboral o Profesional: </h6>
                            <p class="text-uppercase text-dark p-1 text-center font-weight">' . $fila['experLab'] . '</p>
                          </div>
                        </li>
                        <li>
                          <div class="">
                            <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Profesión u Ocupación Actual: </h6>
                            
                          </div>
                        </li>
                        <li>
                          <p class="text-uppercase text-dark p-1 text-center font-weight">' . $fila['profeOcupActual'] . '</p>
                        </li>
                        <li>
                          <div class="">
                            <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Número de Contacto para la ciudadanía: </h6>
                            
                          </div>
                        </li>
                        <li>';
          $cons = "SELECT * FROM contacto WHERE codDetalle =" . $fila['codDetalle'];
          $resp = mysqli_query($conex, $cons);
          foreach ($resp as $fi) {
            echo '  <p class="text-uppercase text-dark  text-center font-weight">0' . $fi['numCntacto'] . '</p>';
          }
          echo '</li>
                            <li>
                              <div class="">
                                <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Partido Politico: </h6>
                              </div>
                            </li>
                            <li>
                                <p class="text-uppercase text-dark p-1 text-center font-weight">' . $fila['descrPart'] . " - " . $fila['siglas'] . '</p>
                            </li>
                            <li>
                              <div class="">
                                <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Movimiento: </h6>
                                </div>
                            </li>
                            <li>
                                <p class="text-uppercase text-dark p-1 text-center font-weight">' . $fila['nombMov'] . " - " . $fila['sgl'] . " - LISTA " . $fila['codMov'] . '</p>
                            </li>
                            <li>
                              <div class="">
                                <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Candidatura: </h6>
                              </div>
                            </li>
                            <li>
                              <p class="text-uppercase text-dark p-1 text-center font-weight">' . $fila['descripcion'] . " - Orden N° - " . $fila['orden'] . '</p>
                            </li>';
          $cons = "SELECT * FROM redessociales WHERE codDetalle =" . $fila['codDetalle'];
          $resp = mysqli_query($conex, $cons);
          if (empty($resp)) {
          } else {
            echo '<li>
                              <div class="">
                              <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Perfiles en Redes Sociales: </h6>
                              
                              </div>
                              </li>
                              <li>';
            echo '<p class="text-uppercase text-dark p-1 text-center font-weight">';
            foreach ($resp as $fi) {
              if (strcasecmp($fi['redSocial'], "FACEBOOK") == 0) {
                echo '
                                  <a  href="' . $fi['url'] . '" TARGET="_blank">
                                  <i class="h3 fab fa-facebook-square " style="color: black;"></i>
                                    </a>';
              }
              if (strcasecmp($fi['redSocial'], "INSTAGRAM") == 0) {
                echo '
                                  
                                  <a  href="' . $fi['url'] . '" TARGET="_blank">
                                  
                                      <i class="h3 fab fa-instagram " style="color: black;"></i>
                                      </a>
                                  ';
              }
              if (strcasecmp($fi['redSocial'], "TWITTER") == 0) {
                echo '
                                  
                                  <a  href="' . $fi['url'] . '" TARGET="_blank">
                                  <i class="h3 fab fa-twitter-square " style="color: black;"></i>
                                  </a>
                                  ';
              }
              if (strcasecmp($fi['redSocial'], "YOUTUBE") == 0) {
                echo '
                                  
                                  <a  href="' . $fi['url'] . '" TARGET="_blank">
                                  <i class="h3 fab fa-youtube-square " style="color: black;"></i>
                                  </a>
                                  ';
              }
            }
          }
          echo '</P>';
          echo '</li>
                          </ul>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="row">';
          echo '</div>';
          echo '
          <div id="cuest1" class="row">
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
                  WHERE ci =" . $id2;
          $result = mysqli_query($conex, $sq);
          echo '<div id="cuestDetalle1" class="mb-2 ">';
          foreach ($result as $row) {
            echo '
                            <div  class="row">
                              <div class="col">
                                  <div class="card shadow mb-2  ">
                                      <div class="card py-2 r2 ">
                                        <ul>';
            echo ' <li class="d-flex justify-content-center">
                                                  <div class=" col-md-8  justify-content-center">
                                                    <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">' . $row['idPreg'] . ' - ' . $row['detPreg'] . '</h6>
                                                    <p class="text-uppercase text-dark p-1 text-justify font-weight">' . $row['detResp'] . '</p>
                                                    </div>
                                                </li>';
            echo '</ul>
                              </div>
                          </div>
                      </div>
                      
                  </div>';
          }
        }
      } else {
        echo "<h1 class='text-danger'>No hay Registros</h1>";
      }
      cerrarBD($conex);
      ?>

    </div>
  </div>


  <button class="btn btn-block mt-3" onclick="volver();">volver</button>

</div>

<!-- FIN DEL CONTENIDO PRINCIPAL -->
<?php require_once "vistas/parte_inferior.php"; ?>

<!-- </body> -->
<script>
  $(document).ready(function() {
    document.getElementById('filtro').getElementsByTagName('option')[2].selected = 'selected'
    document.getElementById('filtro2').getElementsByTagName('option')[2].selected = 'selected'
    habilitar();
    });


  function volver() {
    location.href = "./comparador.php";
  }

  function habilitar(value) {
    var sele = document.getElementById("filtro");
    var sele2 = document.getElementById("filtro2");
    if (sele.options[sele.selectedIndex].value == 0) {
      document.getElementById('datPers').hidden = false;
      document.getElementById('datPersDet').hidden = false;
    } else if (sele.options[sele.selectedIndex].value == 1) {
      document.getElementById('datPers').hidden = false;
      document.getElementById('datPersDet').hidden = false;
      document.getElementById('cuest').hidden = true;
      document.getElementById('cuestDetalle').hidden = true;
    } else if (sele.options[sele.selectedIndex].value == 2) {
      document.getElementById('datPers').hidden = true;
      document.getElementById('datPersDet').hidden = true;
      document.getElementById('cuest').hidden = false;
      document.getElementById('cuestDetalle').hidden = false;
    }
    if (sele2.options[sele2.selectedIndex].value == 0) {
      document.getElementById('datPers1').hidden = false;
      document.getElementById('datPersDet1').hidden = false;
    } else if (sele2.options[sele2.selectedIndex].value == 1) {
      document.getElementById('datPers1').hidden = false;
      document.getElementById('datPersDet1').hidden = false;
      document.getElementById('cuest1').hidden = true;
      document.getElementById('cuestDetalle1').hidden = true;
    } else if (sele2.options[sele2.selectedIndex].value == 2) {
      document.getElementById('datPers1').hidden = true;
      document.getElementById('datPersDet1').hidden = true;
      document.getElementById('cuest1').hidden = false;
      document.getElementById('cuestDetalle1').hidden = false;
    }
  };
</script>


</html>