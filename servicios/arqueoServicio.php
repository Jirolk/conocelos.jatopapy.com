<?php
     require("conexion.php");
     session_start();
     $conex = conexion($_SESSION["nombreUsuario"],$_SESSION["pass"]);
     $id = $_POST["id"];
     date_default_timezone_set ('America/Asuncion');
     $feci = date('Y-m-d H:i:s');
     $arq = $_POST["arq"];
     $rec = $_POST["rec"];
     $dif = $_POST["dif"];
     $ge = $_POST["ge"];
     $caja = $_SESSION['caja'];
     $sql = "SELECT idcajadetalle FROM caja_detalle WHERE  idcajadetalle= '$id'";
     if (pg_query($conex, $sql)) {
          // cuamdo se ejecuta
          $sql = "UPDATE caja_detalle SET fecha_cierre='$feci',monto_cierre='$arq', recuento='$rec',diferencia='$dif' WHERE idcajadetalle='$id'";
          // $sql4 = "UPDATE cajas SET Estado="ACTIVO" WHERE Id_caja_detalle='$id'";
          $resul = pg_query($conex, $sql);
          $sql4 = "UPDATE cajas SET estado='Activo' WHERE idcaja='$caja'";
          $resul = pg_query($conex, $sql4);
          unset($_SESSION['Id_caja_detalle']);
          unset($_SESSION['montoApertura']);
          unset($_SESSION['fechaActual']);
          unset($_SESSION['caja']);
          
          if($ge == "out"){
               echo 3;
          }else{
               echo 1;
          } 
     }else {
          echo 2;
     }

 ?>
