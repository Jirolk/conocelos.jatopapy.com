<?php 
  require_once "vistas/parte_superior.php"; 
?>

<?php require_once "lib/librerias_Superior.php"; ?>
    <?php require_once "lib/librerias_inferior.php"; ?>
<!-- INICIO DEL  CONTENIDO PRINCIPAL -->
<!-- 
<DIv class="container">
  <h1>Contenido Principal</h1>
</DIv> -->

<div class=" container-fluid ">
  <div class="d-sm-flex justify-content-between align-items-center mb-4">
    <h1 class="text-white mb-0">Tablero</h1>
    <!-- <a class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="#"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Generate Report</a> -->
  </div>
  <?php
        require_once("servicios/conexion.php");
        $conex = conexion();
        $sql = "SELECT * FROM partidopolitico order by  codPartido desc";
        $res = mysqli_query($conex, $sql);
        foreach ($res as $fila) {
         //   echo '  <option value="' . $row["ruc"] . '">' . $row["razon_social"] . '</option>';
         echo '

  <div class="row">

 <div class="col">
            <div class="card shadow mb-4 text-dark ">
            <div class="card py-3 r3 align-items-center">
              <h4 class="text-white text-center font-weight-bold ">
                '. $fila["descrPart"] .' - '.$fila["siglas"].'
                  </h4>
                </div>
                </div>
              </div>
             
  </div>

  ';
}
cerrarBD($conex);
?>



  <div class="row ">

    <div class="col-md-6 col-xl-3 mb-4">
      <div class="card shadow border-left-dark cardGan py-2">
        <div class="card-body">
          <div class="row align-items-center no-gutters">
            <div class="col mb-1">
              <!-- <img class="logo" src="img/sicctema.jpeg"/> -->
              <!-- <img class="img-fluid" height="500%" src="img/sicctema.jpeg" alt="img"> -->
              <div class="text-uppercase text-white font-weight-bold text-xs mb-1"><img class="" width="40%" height="40%" src="img/sicctema.jpeg" alt="logo"></div>
              <!-- <div class="col-auto mr-2" class="font-weight-bold "><h3>Lista 69</h3></div> -->
              <!-- <div class=""><img class="img-fluid"  src="img/logoDeo.png" alt="img"></div> -->
              
              
            </div>
            
            <div class="text-uppercase text-white font-weight-bold text-xs mb-1"><h4>Ganancias (Anual)</h4><h3>Lista 69</h3></div>
              <div class="text-success font-weight-bold h5 mb-0"></div>
              
          </div>
            <div class="row align-items-center no-gutters">
              
            </div>
        </div>
      </div>
    </div>
    

    <div class="col-md-6 col-xl-3 mb-4">
      <div class="card shadow border-left-dark cardGan py-2">
        <div class="card-body">
          <div class="row align-items-center no-gutters">
            <div class="col mb-1">
              
              <div class="text-uppercase text-white font-weight-bold text-xs mb-1"><img class="" width="40%" height="40%" src="img/sicctema.jpeg" alt="logo"></div>
                          
              
            </div>
              <div class="text-uppercase text-white font-weight-bold text-xs mb-1">
                <h4>Ganancias (Anual)</h4>
                <div class="text-success font-weight-bold h5 mb-0">
                  <h3>Lista 69</h3>
                </div>
              </div>
              
          </div>
          <div class="row align-items-center no-gutters">
          
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-4">
      <div class="card shadow border-left-dark cardGan py-2">
        <div class="card-body">
          <div class="row align-items-center no-gutters">
            <div class="col mb-1">
              
              <div class="text-uppercase text-white font-weight-bold text-xs mb-1"><img class="" width="40%" height="40%" src="img/sicctema.jpeg" alt="logo"></div>
                          
              
            </div>
              <div class="text-uppercase text-white font-weight-bold text-xs mb-1">
                <h4>Ganancias (Anual)</h4>
                <div class="text-success font-weight-bold h5 mb-0">
                  <h3>Lista 69</h3>
                </div>
              </div>
              
          </div>
          <div class="row align-items-center no-gutters">
          
          </div>
        </div>
      </div>
    </div><div class="col-md-6 col-xl-3 mb-4" >
      <div class="card shadow border-left-dark cardGan py-2">
        <div class="card-body">
          <div class="row align-items-center no-gutters">
            <div class="col mb-1">
              
              <div class="text-uppercase text-white font-weight-bold text-xs mb-1"><img  class="" width="40%" height="40%" src="img/sicctema.jpeg" alt="logo"></div>
                          
              
            </div>
              <div class="text-uppercase text-white font-weight-bold text-xs mb-1">
                <h4 >Ganancias (Anual)</h4>
                <div class="text-success font-weight-bold h5 mb-0">
                  <h3>Lista 69</h3>
                </div>
              </div>
              
          </div>
          <div class="row align-items-center no-gutters">
          
          </div>
        </div>
      </div>
    </div>
    

    
      <div class="col-md-6 col-xl-3 mb-4" href="index.php">
      <a id="link" href="index.php">
        <div class="card shadow border-left-dark cardGan py-2">
          <div class="card-body">
            
            <div class="row">
              <div class="col-sm-3">
                <div class="text-uppercase text-white font-weight-bold text-xs mb-1" href="index.php"><img class="img-fluid"  src="img/sicctema.jpeg" alt="logo"></div>
              </div>
              <div class="col mb-1">
      
              </div> 
                <!-- /.col-sm-6 -->
              <div class="col-sm-8 align-items-center">
                <div class="row align-items-center">
                
                  <span class="text-justify">Movimiento infernal de pollos satanicos anti LGBT+XYZ999</span>     
                </div>

                <div class="row align-items-center">
                  <h3>Lista 69</h3>
                </div>
              </div>
              <!-- /.col-sm-6 -->
            </div>
            <!-- /.row -->

          </div>
        </div>
      </a>
      </div>
   



    </div>


</div>

<!-- FIN DEL CONTENIDO PRINCIPAL -->
<?php require_once "vistas/parte_inferior.php"; ?>
<script src="/internas/js/demo/chart.min.js"></script>
<!-- <script src="/internas/js/demo/chart-pie-demo.js"></script>  -->
<!-- </body> -->


</html>