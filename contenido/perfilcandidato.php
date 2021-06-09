<?php
require_once "vistas/parte_superior.php";
?>


<div class=" container-fluid ">

  <?php
  require_once("../servicios/conexion.php");
  $conex = conexion();
  $id = $_GET["id"];
  /*$sql = "SELECT c.*,cc.descripcion,cd.*,cm.codMov,cm.nombMov,cm.siglas AS sgl,cm.codMov,pp.descrPart,pp.siglas FROM candidatos c
                INNER JOIN movimientos cm ON c.codMov = cm.codMov
                INNER JOIN partidopolitico pp ON cm.codPartido= pp.codPartido
                INNER JOIN candidatura cc ON c.codCand = cc.codCand
                INNER JOIN candidatodetalle cd ON c.ci = cd.ci
            WHERE c.ci=".$id;*/
  $sql = "SELECT c.*,cc.descripcion,cm.codMov,cm.nombMov,cm.siglas AS sgl,cm.codMov,pp.descrPart,pp.siglas FROM candidatos c
              INNER JOIN movimientos cm ON c.codMov = cm.codMov
              INNER JOIN partidopolitico pp ON cm.codPartido= pp.codPartido
              INNER JOIN candidatura cc ON c.codCand = cc.codCand
            
            WHERE c.ci=" . $id;
  $res = mysqli_query($conex, $sql);
  $Qry = "SELECT * FROM candidatodetalle WHERE ci=" . $id;
  $r = mysqli_query($conex, $Qry);
  //    $row_cnt = $r->num_rows;

  foreach ($res as $fila) {
    echo '
      <div class="aling-center">';
    echo ' 
      <img style="width: 130px; height: 130px;" class="rounded mx-auto d-block"  src="../imgcandidatos/';
    echo isset($fila['img']) ? $fila['img'] : 'defaultcandidato.png';
    echo '" alt="logo">
      </div>';
      
      echo '
      <h2 class="py-2 text-center text-uppercase font-weight-bold ">
      ';
      echo isset($fila['alias']) ? $fila['alias'] :  $fila["nomApe"]; 
       echo'
      </h2>
      
      ';




    $row_cnt = $r->num_rows;
    if ($row_cnt == 0) {
      /*if(empty($r)==0) {*/
      echo '
          <script>
          $(document).ready(function () {
            document.getElementById("filtro").hidden = true;
          });
          </script>
          <hr class="divider">
            <h5 class="text-center text-black font-weight-bold " >
            A la fecha todavía no se ha recepcionado los datos de este candidato
            </h5>
            <br>
            <a href="../index.php" class="btn btn-secondary btn-lg btn-block" role="button" aria-disabled="true">REGRESAR</a>
            <br onload="block();">
            ';
    } else {
      echo '<div class=" container text-center ">
          <label for="detalle" class="py-1 font-weight-bold">Filtro de datos</label>
          <select id="filtro"  class="form-control text-uppercase text-center col col-md-12" onchange="habilitar(value);">';
      echo '<option selected value="0">TODOS LOS DATOS</option>';
      echo '<option value="1" >';
      echo 'DATOS PERSONALES';
      echo "</option>";
      echo '<option value="2" >';
      echo 'CUESTIONARIO';
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

      list($año, $mes, $dia) = explode("-", date($fila['fechaNac']));
      if ($mes == 01) {
        $Mes = 'enero';
      } elseif ($mes == 02) {
        $Mes = 'febrero';
      } elseif ($mes == 03) {
        $Mes = 'marzo';
      } elseif ($mes == 04) {
        $Mes = 'abril';
      } elseif ($mes == 05) {
        $Mes = 'mayo';
      } elseif ($mes == 06) {
        $Mes = 'junio';
      } elseif ($mes == 07) {
        $Mes = 'julio';
      } elseif ($mes == '08') {
        $Mes = 'agosto';
      } elseif ($mes == '09') {
        $Mes = 'septiembre';
      } elseif ($mes == 10) {
        $Mes = 'octubre';
      } elseif ($mes == 11) {
        $Mes = 'noviembre';
      } else {
        $Mes = 'diciembre';
      }
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
                      <p class="text-uppercase text-dark p-1 text-center font-weight">' . $fila['lugarNac'] . ', ' . $dia . ' de ' . $Mes . ' de ' . $año . '.</p>
                    </li>
                    <li>
                      <div class="">
                        <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Correo electrónico: </h6>
                        
                      </div>
                    </li>
                    <li>
                      <p class=" text-dark p-1 text-center font-weight">' . $fila['email'] . '</p>
                    </li>';
      foreach ($r as $f) {


        echo '<li class="d-flex justify-content-center">
                      <div class="">
                        <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Formación Académica: </h6>
                        
                        </div>
                        </li>
                    <li>';
        $array = explode("\r\n", $f['formacAca']);
        echo '      <p class="text-uppercase text-dark p-1 text-center font-weight">';

        foreach ($array as  $indice => $item) {
          $asd = end($array);
          if (strcasecmp($item, $asd) == 0) {
            # code...
            echo $item;
          } else {

            echo $item . '<br>';
          }
        }
        echo '</p>
                    </li>
                    <li class="d-flex justify-content-center">
                      <div class="">
                        <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Formación Profesional: </h6>
                        
                        </div>
                        </li>
                    <li>';
        $array = explode("\r\n", $f['formacProf']);
        echo '      <p class="text-uppercase text-dark p-1 text-center font-weight">';

        foreach ($array as  $indice => $item) {
          $asd = end($array);
          if (strcasecmp($item, $asd) == 0) {
            # code...
            echo $item;
          } else {

            echo $item . '<br>';
          }
        }
        echo '</p>
                    </li>
                    <li class="d-flex justify-content-center">
                      <div class="">
                        <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Experiencia Laboral o Profesional: </h6>
                      </div>
                    </li>
                    <li>';
        $array = explode("\r\n", $f['experLab']);
        echo '      <p class="text-uppercase text-dark p-1 text-center font-weight">';

        foreach ($array as  $indice => $item) {
          $asd = end($array);
          if (strcasecmp($item, $asd) == 0) {
            # code...
            echo $item;
          } else {

            echo $item . '<br>';
          }
        }

        echo '</p>
                    </li>
                    <li>
                      <div class="">
                        <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Profesión u Ocupación Actual: </h6>
                        
                      </div>
                    </li>
                    <li>';
        $array = explode("\r\n", $f['profeOcupActual']);
        echo '      <p class="text-uppercase text-dark p-1 text-center font-weight">';

        foreach ($array as  $indice => $item) {
          $asd = end($array);
          if (strcasecmp($item, $asd) == 0) {
            # code...
            echo $item;
          } else {

            echo $item . '<br>';
          }
        }

        echo  '</p>
                    </li>
                    <li>
                      <div class="">
                        <h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">Número de Contacto para la ciudadanía: </h6>
                        
                      </div>
                    </li>
                    <li>';
        $cons = "SELECT * FROM contacto WHERE codDetalle =" . $f['codDetalle'];
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
                          <p class="text-uppercase text-dark p-1 text-center font-weight">' . $fila['descripcion'];
                          if ($fila['codCand'] == 2) {
                           
                           
                            echo " - Orden N° - " . $fila['orden'] ;
                           
                          }
                          echo '</p>
                        </li>';
        $cons = "SELECT * FROM redessociales WHERE codDetalle =" . $f['codDetalle'];
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
                              <a  href="' . $fi['url'] . '">
                              <i class="h3 fab fa-facebook-square " style="color: black;"></i>
                                </a>';
            }
            if (strcasecmp($fi['redSocial'], "INSTAGRAM") == 0) {
              echo '
                              
                              <a  href="' . $fi['url'] . '">
                              
                                  <i class="h3 fab fa-instagram " style="color: black;"></i>
                                  </a>
                              ';
            }
            if (strcasecmp($fi['redSocial'], "TWITTER") == 0) {
              echo '
                              
                              <a  href="' . $fi['url'] . '">
                              <i class="h3 fab fa-twitter-square " style="color: black;"></i>
                              </a>
                              ';
            }
            if (strcasecmp($fi['redSocial'], "YOUTUBE") == 0) {
              echo '
                              
                              <a  href="' . $fi['url'] . '">
                              <i class="h3 fab fa-youtube-square " style="color: black;"></i>
                              </a>
                              ';
            }
            if (strcasecmp($fi['redSocial'], "LINKEDIN") == 0) {
              echo '
                                
                                <a  href="' . $fi['url'] . '" target="_blank">
                                <i class="h3 fab fa-linkedin-square " style="color: black;"></i>
                                </a>
                                ';
            }
          }
        }
        echo '</P>';
        echo '</li>';
      }
      echo '            </ul>
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
        $array = explode("\r\n", $row['detResp']);


        echo '
                        <div  class="row">
                          <div class="col">
                              <div class="card shadow mb-2  ">
                                  <div class="card py-2 r2 ">
                                    <ul>';
        echo ' <li class="d-flex justify-content-center">
                                              <div class=" col-md-8  justify-content-center">';
        if ($fila['codCand'] == 1 && $row['idPreg'] == 2) {
          echo '<h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">' . $row['idPreg'] . ' - ¿Cuáles son sus propuestas como pre candidato a Intendente?</h6>
                                                  <p class="text-uppercase text-dark p-1 text-justify font-weight">';
          foreach ($array as  $indice => $item) {
            echo $item . "<br />";
          }
          echo '</p>';
        } elseif ($fila['codCand'] == 1 && $row['idPreg'] == 1) {
          echo '<h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">' . $row['idPreg'] . ' - ¿Cuál fue su trabajo o actividad anterior a ser pre candidato a Intendente??</h6>
                                                  <p class="text-uppercase text-dark p-1 text-justify font-weight">';
          foreach ($array as  $indice => $item) {
            echo $item . "<br />";
          }
          echo '</p>';
        } else {
          echo '<h6 class="text-uppercase text-dark p-2 text-center font-weight-bold">' . $row['idPreg'] . ' - ' . $row['detPreg'] . '</h6>
                                                  <p class="text-uppercase text-dark p-1 text-justify font-weight">';
          foreach ($array as  $indice => $item) {
            echo $item . "<br />";
          }
          echo '</p>';
        }


        echo '          </div>
                                            </li>';
        echo '</ul>
                          </div>
                      </div>
                  </div>';
        echo '</div>';
      }
      echo '</div>';
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
  $(document).ready(function() {
    document.getElementById('filtro').getElementsByTagName('option')[0].selected = 'selected'
  });

  function habilitar(value) {
    var sele = document.getElementById("filtro");
    if (sele.options[sele.selectedIndex].value == 0) {
      document.getElementById('datPers').hidden = false;
      document.getElementById('cuest').hidden = false;
      document.getElementById('datPersDet').hidden = false;
      document.getElementById('cuestDetalle').hidden = false;
    } else if (sele.options[sele.selectedIndex].value == 1) {
      document.getElementById('cuest').hidden = true;
      document.getElementById('datPers').hidden = false;
      document.getElementById('datPersDet').hidden = false;
      document.getElementById('cuestDetalle').hidden = true;
    } else if (sele.options[sele.selectedIndex].value == 2) {
      document.getElementById('cuest').hidden = false;
      document.getElementById('datPers').hidden = true;
      document.getElementById('datPersDet').hidden = true;
      document.getElementById('cuestDetalle').hidden = false;
    }
  };

  function block() {
    document.getElementById("filtro").disabled = true;
  }
</script>


</html>