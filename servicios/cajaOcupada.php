<?php
     require("conexion.php");
     session_start();
     $conex = conexion($_SESSION["nombreUsuario"],$_SESSION["pass"]);
     $Caja = $_POST["caja"];
     $numero_caja = $_POST["nro"];
     $estado = $_POST["estado"];
     $monto = $_POST["monto"];
     if($estado == "Ocupado"){
          $sql = "SELECT idcajadetalle,monto_apertura, fecha_apertura FROM caja_detalle WHERE idcaja='$Caja' 
          AND fecha_apertura IN (SELECT MAX(fecha_apertura) FROM caja_detalle WHERE idcaja = '$Caja') ";
          $resul = pg_query($conex, $sql);
          $reg = pg_fetch_array($resul);
          $_SESSION['Id_caja_detalle'] = $reg['idcajadetalle'];
          $_SESSION["montoApertura"] = $reg['monto_apertura'];
          $_SESSION["fechaActual"] = $reg['fecha_apertura'];
          $_SESSION["caja"]=$numero_caja;
          $cajadet = $_SESSION['Id_caja_detalle'];
          $sql = "select (SELECT
          CASE WHEN SUM(monto) is null THEN 0
                 WHEN SUM(monto)>0 THEN SUM(monto)
          END
          FROM cajas_acciones WHERE idcajadetalle = '$cajadet' AND accion = 'Venta')-
          (SELECT
          CASE WHEN SUM(monto) is null THEN 0
                 WHEN SUM(monto)>0 THEN SUM(monto)
          END
          FROM cajas_acciones WHERE idcajadetalle = '$cajadet' AND accion = 'Compra') resta";
          $resul = pg_query($conex, $sql);
          $reg = pg_fetch_array($resul);
          $num = $reg["resta"];
          
          if($num > 0){
               $_SESSION["montoOperaciones"] = $_SESSION["montoApertura"] + $num;
          }else if($num < 0){
               $_SESSION["montoOperaciones"] = $_SESSION["montoApertura"] + $num;
          }else{
               $_SESSION["montoOperaciones"] =$_SESSION["montoApertura"];
          }
          echo $_SESSION["montoOperaciones"];
          //echo $_SESSION["montoOperaciones"];
     }else{
          $_SESSION["montoApertura"]=$monto;
          $_SESSION["montoOperaciones"]=$monto;
          date_default_timezone_set ('America/Asuncion');
          $fechaActual = date('Y-m-d H:i:s');
          $_SESSION["fechaActual"]=$fechaActual ;
          $idUsuario = $_SESSION["usuario"];
          //echo $cargo;
          $sql1 = "INSERT INTO caja_detalle(monto_apertura,fecha_apertura,idusuario,idcaja) VALUES('$monto','$fechaActual','$idUsuario','$Caja')";
          $resul1 = pg_query($conex, $sql1);
          $sql = "SELECT idcajadetalle FROM caja_detalle WHERE monto_apertura='$monto' AND fecha_apertura='$fechaActual' AND idusuario='$idUsuario' AND idcaja='$Caja'";
          $resul =pg_query($conex, $sql);
          $reg = pg_fetch_array($resul);
          $_SESSION['Id_caja_detalle'] = $reg['idcajadetalle'];
          $sql2 = "UPDATE cajas SET estado='Ocupado' WHERE idcaja='$Caja'";
          $resul2 = pg_query($conex, $sql2);
          if($estado == "ACTIVO"){
               $_SESSION["caja"]="";
          }else{
               $_SESSION["caja"]=$numero_caja;
          }
          echo 1;
     }
     
 ?>
