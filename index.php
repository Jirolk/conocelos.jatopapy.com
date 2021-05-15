<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- <meta name="theme-color" content="black"> -->
    <link rel="icon" type="image/png" href="img/logoFinal.png" />

    <title>CONOCELOS</title>

    <?php require_once "lib/librerias_Superior.php"; ?>
    <?php require_once "lib/librerias_inferior.php"; ?>
    

</head>
<?php require_once "vistas/parte_superior.php"; ?>
<!-- INICIO DEL  CONTENIDO PRINCIPAL -->
<!-- 
<DIv class="container">
  <h1>Contenido Principal</h1>
</DIv> -->

<div class="container-fluid ">
  <div id="datPersDet" class="row">
      <div class="col">
            <div class="align-items-center ">
              <h1 class="text-dark text-center font-weight-bold ">CONÓCELOS</h1>
            </div>
          <div class=" mb-2  ">
            <div class="  align-items-center" >
              <ul>
                <li>
                  <p class="text-uppercase text-dark p-1 text-justify font-weight">"CONÓCELOS" es un proyecto de transparencia electoral, que tiene como objetivo brindar  información a la ciudadanía sobre los candidatos a las elecciones internas 2021 de la ciudad de Concepción.
                    A través de esta iniciativa buscamos mantener informado a los ciudadanos sobre los diferentes candidatos a los cargos de Intendencia y Concejalía, para así incrementar el acceso a la información pública por parte de la ciudadanía, promover la participación ciudadana y fortalecer el proceso democrático en la ciudad de Concepción.</p>
                </li>
              </ul> 
            </div>
          </div>
      </div>
      </div>
      <div id="cajacookies">
<p>
Éste sitio web usa cookies, si permanece aquí acepta su uso.
Puede leer más sobre el uso de cookies en nuestra <a href="privacidad.php">política de privacidad</a><br>
<button onclick="aceptarCookies()" ><i class="fa fa-times"></i> Aceptar</button>
</div>
</p>
  <?php
    require_once("./servicios/conexion.php");
    $conex = conexion();
    /*$sql = "SELECT * FROM candidatos AS r1 
              JOIN (SELECT CEIL(RAND() * (SELECT MAX(ci) FROM candidatos)) AS id) AS r2
            WHERE r1.ci >= r2.id
            ORDER BY r1.ci ASC
            LIMIT 7";*/
    $sql = "SELECT * FROM `candidatos`
            ORDER BY RAND()
            LIMIT 6";
    $res = mysqli_query($conex, $sql);
    
    echo '
    <div class="container-1">
		
		<ul id="autoWidth" class="cs-hidden">
    
    ';

    foreach ($res as $fila) {
      echo '
      <li class="item-a">
        <div class="box">
          <div class="img-content">
            <div  class="img" style="
                    width: 100%;
                    height: 100%;
                    top: 0;
                    left: 0;
                    background-size: cover;
                    transition: .2s;">
            <img src="imgcandidatos/';
                  echo $fila['img'];
                  echo '" alt="" style="
                            width: 100%;
                            height: 100%;
                            top: 0;
                            left: 0;
                            
                            background-size: cover;
                            transition: .2s;">
                <div class="info">
                  <h6>'.$fila['nomApe'].'</h6>
                  <p style="color: #929292;">';
                  if ($fila['codCand']==1) {
                    echo 'INTENDENTE MUNICIPAL';
                  }else {
                    echo 'CONCEJAL MUNICIPAL';
                  }
                  echo '</p>
                  </div>
                  <div class="social">
                    <ul>';
                    //$cons = "SELECT * FROM redessociales WHERE codDetalle =".$fila['codDetalle'];
                    $cons = "SELECT * FROM redessociales rs
                                INNER JOIN candidatodetalle dt ON rs.codDetalle=dt.codDetalle
                                INNER JOIN candidatos c ON dt.ci=c.ci
                            WHERE c.ci=".$fila['ci'];

                    $resp = mysqli_query($conex, $cons);
                    if(empty($resp)) {

                    }else {
                      foreach($resp as $fi){
                        echo '<li>';
                        if (strcasecmp($fi['redSocial'],"FACEBOOK") == 0) {
                          echo '
                          <a href="'.$fi['url'].'" target="_blank">
                          <i class="h3 fab fa-facebook-f " style="color: black;"></i>
                            </a>';
                          }
                          if (strcasecmp($fi['redSocial'],"INSTAGRAM") == 0) {
                          echo '
                          
                          <a  href="'.$fi['url'].'" target="_blank">
                              
                              <i class="h3 fab fa-instagram " style="color: black;"></i>
                          </a>
                          ';
                        }
                        if (strcasecmp($fi['redSocial'],"TWITTER") == 0) {
                          echo '
                          
                          <a  href="'.$fi['url'].'" target="_blank">
                            <i class="h3 fab fa-twitter" style="color: black;"></i>
                          </a>
                          ';
                        }
                        if (strcasecmp($fi['redSocial'],"YOUTUBE") == 0) {
                          echo '
                          
                          <a  href="'.$fi['url'].'" target="_blank">
                            <i class="h3 fab fa-youtube " style="color: black;"></i>
                          </a>
                          ';
                        }
                        echo '</li>';
                      }
                    }
                    cerrarBD($cons);
        echo' </ul>
        </div>
      </div>
    </div>';

    }
    cerrarBD($conex);
  
  
  ?>
   
</div>

</div>

</div>

<!-- FIN DEL CONTENIDO PRINCIPAL -->

</script>
<?php require_once "vistas/parte_inferior.php"; ?>
<!-- <script src="/js/demo/chart.min.js"></script> -->
<!-- <script src="/internas/js/demo/chart-pie-demo.js"></script>  -->
<!-- </body> -->
