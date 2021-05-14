<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- <meta name="theme-color" content="black"> -->
    <link rel="icon" type="image/png" href="img/logo.png" />

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
  
  <?php
    require_once("./servicios/conexion.php");
    $conex = conexion();
    $sql = "SELECT ci,nomApe,codCand FROM `candidatos` AS r1 
              JOIN (SELECT CEIL(RAND() * (SELECT MAX(ci) FROM candidatos)) AS id) AS r2
            WHERE r1.ci >= r2.id
            ORDER BY r1.ci ASC
            LIMIT 5";
    $res = mysqli_query($conex, $sql);

    foreach ($res as $fila) {


    }
  
  
  
  ?>

<div id="carouselExampleControls" class="carousel slide " data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active ">
      <div class="container-1">
        <div class="img-content">
          <div class="img">
            <div class="info">
              <h2>
                nombre candidato
            </h2>
            <h4>
              candidatura
            </h4>
          </div>
          <div class="social">
            <ul>
              <li>
                <a href="#">
                  <i class="h3 fab fa-facebook-f"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      </div>
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="..." alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="..." alt="Third slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
 
  



</div>

<!-- FIN DEL CONTENIDO PRINCIPAL -->
<?php require_once "vistas/parte_inferior.php"; ?>
<!-- <script src="/js/demo/chart.min.js"></script> -->
<!-- <script src="/internas/js/demo/chart-pie-demo.js"></script>  -->
<!-- </body> -->
