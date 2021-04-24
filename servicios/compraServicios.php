<?php
require("conexion.php");
session_start();
$conex = conexion($_SESSION["nombreUsuario"], $_SESSION["pass"]);
$user = $_SESSION["usuario"];
$caja = $_SESSION["caja"];
//$idCaDetalle = $_SESSION["idDetalle"];//capturo para mi caja acciones
$opc = $_POST["accion"];
if ($opc == "N") {
     //Capturar los datos enviados por ajax
     //	$id = $_POST["id"];//id cabecera
     $fec = $_POST["fecha"];
     $con = $_POST["condicion"];
     $fac = $_POST["factura"];
     $ruc = $_POST["ruc"];
     $total = $_POST["total"];
     $totIva5 = $_POST["totIva5"];
     $totIva10 = $_POST["totIva10"];
     $detalleContado = $_POST["detalleContado"];
     $efe = $_POST["efectivo"];
     $che = $_POST["cheque"];
     $tarj = $_POST["tarjeta"];
     $vue = $_POST["vuelto"];
}
if ($opc == "A") {
     $id = $_POST["id"];
     $con = $_POST["condicion"];
     $obs = $_POST["observacion"];
}
if ($opc == "N") {     //NUEVO
     $grabar = true;
     $sql = "SELECT idcompra FROM compra_cab WHERE nro_factura = '$fac' AND fecha ='$fec' ";
     $resul = pg_query($conex, $sql);
     $num_reg = pg_num_rows($resul);
     if ($num_reg > 0) {
          $grabar = false;
          echo 1;
     }
     if ($grabar == true) {
          //EN COMPRA CABECERA
          if ($efe > $_SESSION["montoOperaciones"] && $con == 'Contado') {
               echo 4;
          } else {
               $user = $_SESSION["usuario"];
               if ($con == 'Contado') { //cabecera
                    $sql = "INSERT INTO compra_cab(nro_factura, fecha, ruc, total, t_iva5, t_iva10, condicion, estado,idusuario) VALUES ('$fac', '$fec','$ruc', '$total','$totIva5','$totIva10', '$con','Pagado', '$user')";
                    $res = pg_query($conex, $sql);
                    $sql = "SELECT idcompra FROM compra_cab WHERE nro_factura = '$fac' AND fecha ='$fec' ";
                    $resul = pg_query($conex, $sql);
                    $reg = pg_fetch_array($resul);
                    $idcompra = $reg['idcompra'];
                    $idCD = $_SESSION['Id_caja_detalle'];
                    $sql = "INSERT INTO cajas_acciones(monto, accion, idcajadetalle, idcompra,idventa) VALUES ('$efe', 'Compra', '$idCD', '$idcompra', null)";
                    $res =  pg_query($conex, $sql);
                    $_SESSION["montoOperaciones"] -= $efe;
                    $_SESSION["montoOperaciones"] += $vue;
                    //pago
                    $sql = "INSERT INTO cobro_efectivo (idcompra,total_efectivo, total_cheque, total_tarjeta, idventa)
                             VALUES ('$idcompra', '$efe', '$che', '$tarj', null)";
                    pg_query($conex, $sql);
                    //recupeo id cobro
                    $sql = "SELECT idcobro FROM cobro_efectivo WHERE idcompra = '$idcompra' ";
                    $resul = pg_query($conex, $sql);
                    $reg = pg_fetch_array($resul);
                    $idcobro = $reg['idcobro'];
                    $array = explode(",", $_POST['detalleContado']);   //Convertir el String a Array. El String contiene el Detalle
                    $canti = count($array); //Cantidad de elementos del array
                    $artic = $canti / 4;    //Cantidad de filas que contiene el Array. Se divide entre 7, porque se recibe 4 campos por cada detalle
                    $pos = 0;
                    for ($i = 1; $i <= $artic; $i++) {
                         //OBTENER EL DETALLE DE CADA ARTICULO
                         $tipo = $array[$pos];
                         $pos = $pos + 1;
                         $iden = $array[$pos];
                         $pos = $pos + 1;
                         $ban = strtoupper($array[$pos]);
                         $pos = $pos + 1;
                         $mon = $array[$pos];
                         $pos = $pos + 1;
                         //GUARDAR EL REGISTRO EN COMPRADETALLE
                         $sql = "INSERT INTO cobro_detalle (metodo, identificador,banco, monto, idcobro)
                                 VALUES ('$tipo', '$iden', '$ban', '$mon', '$idcobro')";
                         pg_query($conex, $sql);
                    }
               } else if ($con == 'Crédito') { //falta mi generacion de cutas
                    $sql = "INSERT INTO compra_cab(nro_factura, fecha, ruc, total,t_iva5, t_iva10, condicion,estado,idusuario) VALUES ('$fac', '$fec','$ruc', '$total','$totIva5','$totIva10', '$con','Pendiente', '$user')";
                    $res = pg_query($conex, $sql);
                    $sql = "SELECT idcompra FROM compra_cab WHERE nro_factura = '$fac' AND fecha ='$fec' ";
                    $resul = pg_query($conex, $sql);
                    $reg = pg_fetch_array($resul);
                    $idcompra = $reg['idcompra'];
                   /* $sql = "SELECT entrega FROM pago_credito WHERE idcompra ='$id'";
                    $res = pg_query($conex, $sql);
                    $reg = pg_fetch_array($res);
                    $ent = $reg['entrega'];
                    $idCD = $_SESSION['Id_caja_detalle'];
                    $sql = "INSERT INTO cajas_acciones(monto, accion, idcajadetalle, idcompra,idventa) VALUES ('$ent    ', 'Compra', '$idCD', '$idcompra', null)";
                    $res =  pg_query($conex, $sql);*/
               }
               $array = explode(",", $_POST['detalle']);   //Convertir el String a Array. El String contiene el Detalle
               $canti = count($array); //Cantidad de elementos del array
               $artic = $canti / 7;    //Cantidad de filas que contiene el Array. Se divide entre 7, porque se recibe 4 campos por cada detalle
               $pos = 0;
               for ($i = 1; $i <= $artic; $i++) {
                    //OBTENER EL DETALLE DE CADA ARTICULO
                    $acc = $array[$pos];
                    $pos = $pos + 1;
                    $idart = $array[$pos];
                    $pos = $pos + 1;
                    $art = strtoupper($array[$pos]);
                    $pos = $pos + 1;
                    $canti = $array[$pos];
                    $pos = $pos + 1;
                    $pre = $array[$pos];
                    $pos = $pos + 1;
                    $iva = $array[$pos];
                    $pos = $pos + 1;
                    $subtot = $array[$pos];
                    $pos = $pos + 1;
                    //ACTUALIZA O INSERTA EL STOCK DE CADA ARTICULO
                    $q = "select conversion from insumos where idinsumo='$idart'";
                    $r = pg_query($conex, $q);
                    $re = pg_fetch_array($r);
                    $conv = $re['conversion'];
                    $calculo = $conv * $canti;
                    if ($acc == "M") {
                         $sql = "UPDATE insumos SET stock = stock + '$calculo', precompra='$pre' WHERE idinsumo = " . $idart;
                         pg_query($conex, $sql);
                    }
                    //GUARDAR EL REGISTRO EN COMPRADETALLE
                    //FALTA ARREGLAR DETALLE LUEGO PROBAR Y LUEGO PAGO-----------------
                    $sql = "INSERT INTO compra_det (precompra, cantidad,total, idcompra,idinsumo,idproducto)
                               VALUES ('$pre', '$canti', '$subtot', '$idcompra', '$idart',null)";
                    pg_query($conex, $sql);
               }
               echo 2;
          }
     }
} else if ($opc == "A") {     //anular
     $sql = "SELECT cd.idinsumo, cd.total, cd.cantidad FROM compra_det cd
          WHERE idcompra = '$id'";
     $rs = pg_query($conex, $sql);//FALTA CAPTURAR EL EFECTIVO ENTREGADO TANTO EN CONTADO O CREDITO Y SUMAR EN MONTOOPERACIONES
     $suma = 0;
     if ($con == "Contado") {
         $sql = "SELECT total_efectivo FROM cobro_efectivo WHERE idcompra ='$id'";
          $res = pg_query($conex, $sql);
          $reg = pg_fetch_array($res);
          //if ($reg["Estado"] == "Activo") {
               //recorro mi articulos disminuyendo el stock de lo comprado
               while ($fila = pg_fetch_assoc($rs)) {
                    $ida = $fila["idinsumo"];
                    $suma += $fila["total"];
                    $canti = $fila["cantidad"];
                    $q = "select conversion from insumos where idinsumo='$ida'";
                    $r = pg_query($conex, $q);
                    $re = pg_fetch_array($r);
                    $conv = $re['conversion'];
                    $calculo = $conv * $canti;
                    $sql = "UPDATE insumos SET stock=stock-'$calculo' WHERE idinsumo='$ida'";
                    $resul = pg_query($conex, $sql);
               }
               date_default_timezone_set('America/Asuncion');
               $fecha = date('Y-m-d H:i:s');
               $user = $_SESSION['usuario'];
               //$tot = $suma;
               $tot = $reg['total_efectivo'];
               $id_caja_d = $_SESSION['Id_caja_detalle'];
               $_SESSION["montoOperaciones"] += $tot;
               $monto = $tot * (-1);
               $sql = "INSERT INTO cajas_acciones (monto, accion, idcajadetalle, idcompra,idventa) VALUES ('$monto', 'Compra', '$id_caja_d', '$id', null)";
               pg_query($conex, $sql);

               $sql = "UPDATE compra_cab SET estado='Anulado', idusuanula='$user',fecha_anulacion='$fecha', desc_anu='$obs' WHERE idcompra='$id'";
               $resul = pg_query($conex, $sql);
               echo 3;
          /*} else {
               echo 4;
          }*/
     } else {
          $sql = "SELECT p.pagado FROM pago_detalle p
          INNER JOIN pago_credito pc ON pc.idpago=p.idpago
          INNER JOIN compra_cab c ON c.idcompra=pc.idcompra WHERE c.idcompra ='$id' AND p.pagado='Si'";
          $resul =pg_query($conex, $sql);
          $num_reg = pg_num_rows($resul);
          if ($num_reg > 0) {
               echo 4;
          } else {
               $sql = "SELECT entrega FROM pago_credito WHERE idcompra ='$id'";
                $res = pg_query($conex, $sql);
                $reg = pg_fetch_array($res);
               while ($fila = pg_fetch_assoc($rs)) { 
                    $ida = $fila["idinsumo"];
                    $suma += $fila["total"];
                    $canti = $fila["cantidad"];
                    $q = "select conversion from insumos where idinsumo='$ida'";
                    $r = pg_query($conex, $q);
                    $re = pg_fetch_array($r);
                    $conv = $re['conversion'];
                    $calculo = $conv * $canti;
                    $sql = "UPDATE insumos SET stock=stock-'$calculo' WHERE idinsumo='$ida'";
                    $resul = pg_query($conex, $sql);
               }
               date_default_timezone_set('America/Asuncion');
               $fecha = date('Y-m-d H:i:s');
               $user = $_SESSION['usuario'];
               //$tot = $suma;
               $tot = $reg['entrega'];
               $id_caja_d = $_SESSION['Id_caja_detalle'];
               $_SESSION["montoOperaciones"] += $tot;
               $monto = $tot * (-1);
               $sql = "INSERT INTO cajas_acciones (monto, accion, idcajadetalle, idcompra,idventa) VALUES ('$monto', 'Compra', '$id_caja_d', '$id', null)";
               pg_query($conex, $sql);

               $sql = "UPDATE compra_cab SET estado='Anulado', idusuanula='$user',fecha_anulacion='$fecha', desc_anu='$obs' WHERE idcompra='$id'";
               $resul = pg_query($conex, $sql);
               echo 3;
          }
     }
}
