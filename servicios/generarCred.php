<?php
     require("conexion.php");
     session_start();
     $conex = conexion($_SESSION["nombreUsuario"], $_SESSION["pass"]);
    	$idFact = $_POST["idFact"];
    	$can = $_POST["cantidad"];
    	$ent = $_POST["entrega"];
     $fec = $_POST["fecha"];
     $fecha = $_POST["fec"];
    	$mon = $_POST["monto"];
    	$mons = $_POST["mons"];
     $monf = $_POST["monf"];
     $user = $_SESSION["usuario"];
     $idCD = $_SESSION['Id_caja_detalle'];
     $sql = "SELECT idcompra FROM compra_cab WHERE nro_factura = '$idFact' AND fecha= '$fecha'";
     $resul = pg_query($conex, $sql);
     $reg = pg_fetch_array($resul);
     $idcompra = $reg['idcompra'];
     $sql = "INSERT INTO cajas_acciones(monto, accion, idcajadetalle, idcompra,idventa) VALUES ('$ent', 'Compra', '$idCD', '$idcompra', null)";
     $res =  pg_query($conex, $sql);
     $sql = "INSERT INTO pago_credito (fe_vencimiento, idcompra,can_cuotas, entrega, pagado) VALUES ('$fec', '$idcompra','$can', '$ent','No')";
     $res = pg_query($conex, $sql);
     $sql ="SELECT idpago FROM pago_credito WHERE idcompra='$idcompra'";
     $res = pg_query($conex, $sql);
     $reg = pg_fetch_array($res);
     $idCre = $reg["idpago"];
     $año =substr($fec,0,4);
     $mes = substr($fec,5,2);
     $dia = substr($fec,8,2);
     $fecV=$fec;
     $_SESSION["montoOperaciones"] -= $ent;
     for($i=1;$i<=$can;$i++){
          $dia = substr($fec,8,2);
          if($i==$can){
               if($mons==0){
                    if($monf>0){
                         $mon +=$monf;
                    }
               }else{
                    $mon -=$mons;
               }
               $sql = "INSERT INTO pago_detalle (num_cuota,idpago,monto_cuota, fecha_vencimiento,idusuario, pagado) VALUES ('$i','$idCre','$mon','$fecV', '$user','No')";
               $res = pg_query($conex, $sql);
          }else{
               $sql = "INSERT INTO pago_detalle (num_cuota,idpago,monto_cuota, fecha_vencimiento,idusuario, pagado) VALUES ('$i','$idCre','$mon','$fecV', '$user', 'No')";
               $res = pg_query($conex, $sql);
          }
          $mes=$mes+1;

          if($mes==13){
               $mes=1;
               $año+=1;
          }
          switch ($mes) {
              case 1:
              case 3:
              case 5:
              case 7:
              case 8:
              case 10:
              case 12:
                  $d = 31;
                  if($dia<=$d){
                       $dia=$dia;
                  }
                  break;
              case 4:
              case 6:
              case 9:
              case 11:
                  $d = 30;
                  if($dia>$d){
                       $dia=30;
                  }
                  break;
              case 2:
                  if (($año %4 == 0 && $año %100 !=0) || $año%400 ==0){
                   $d=29;
                   if($dia>$d){
                       $dia=29;
                  }
                 } else {
                   $d=28;
                   if($dia>$d){
                       $dia=28;
                  }
                 }
                  break;
          }
          $fecV= $año."-".$mes."-".$dia;

     }
     echo 1;
?>
