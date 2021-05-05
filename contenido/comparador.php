<?php
require_once "vistas/parte_superior.php";
?>


<!-- INICIO DEL  CONTENIDO PRINCIPAL -->

<DIv class="container text-center ">
  <h1 class="text-info">Comparador de Perfiles</h1>
  <h6 class="mt-2">Elija dos candidatos para comparar perfiles, puede buscar por nombres o en busqueda avanzada podrá hacer una busqueda por partido, movimiento y nombre.</h6>
</DIv>
<div class=" container text-center ">
  <label for="tipoCand" class="mt-3 font-weight-bold">Tipo de Candidatura</label>
  <select class="form-control text-uppercase text-center col col-md-12" name="tipoCand" id="tipoCand" autofocus onchange="habilitar(value);">
    <?php

    require_once("../servicios/conexion.php");
    $conex = conexion();
    $sql = "SELECT * FROM candidatura ";
    $rs = mysqli_query($conex, $sql);
    echo "<option value='0'>Eliga una Opción</option>";
    foreach ($rs as $fila) {
      echo "<option value='" . $fila['codCand'] . "'>";
      echo $fila['descripcion'];
      echo "</option>";
    }
    cerrarBD($conex);
    ?>
  </select>
  <div class="" id="CampoBusqueda"></div>
  <div id="BusAvan"></div>
</div>



<script src="../contenido/jsComparador/main.js?v2"></script>
<!-- FIN DEL CONTENIDO PRINCIPAL -->
<?php require_once "vistas/parte_inferior.php"; ?>