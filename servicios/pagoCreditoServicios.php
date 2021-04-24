<?php
     require("conexion.php");
     session_start();
     $conex = conexion($_SESSION["nombreUsuario"], $_SESSION["pass"]);
     $total = $_POST["total"];//te quedaste aca tenes qe pensar como hacer pagos CONTADOS
     $fec = $_POST["fecha"];
     $rec = $_POST["recibo"];
     $detalleContado = $_POST["detalleContado"];
     $efe = $_POST["efectivo"];
     $che = $_POST["cheque"];
     $tarj = $_POST["tarjeta"];
     $vue = $_POST["vuelto"];
      $array = explode(",", $_POST['detalle']);   //Convertir el String a Array. El String contiene el Detalle
     $canti = count($array); //Cantidad de elementos del array
     $artic = $canti / 2;
     $pos=0;
     if($efe > $_SESSION["montoOperaciones"]){//falta depositar en cajas acciones cobrodetalle y lluego el resto
          echo 2;
     }else{
          /*if($condi=="CREDITO"){*/
               //$mon = $efe/$artic;
               for($i=1; $i<=$artic; $i++){
                     $det = $array[$pos];
                     $pos = $pos +1 ;
                     $idcompra = $array[$pos];
                     $pos = $pos +1 ;
                    $sql = "UPDATE pago_detalle SET num_recibo = '$rec', fecha_pago='$fec', pagado='Si' WHERE idpagodet = ".$det;
                    pg_query($conex, $sql);

                    //verifico si ya se pago todos los creditos
                    $sql = "SELECT idpago FROM pago_detalle WHERE idpagodet = '$det'";
                    $resul = pg_query($conex, $sql);
                    $reg = pg_fetch_array($resul);
                    $idpago = $reg['idpago'];
                   $sql="SELECT COUNT(idpago) con FROM pago_detalle WHERE pagado='No' AND idpago = '$idpago'";
                   $resul = pg_query($conex, $sql);
                    $reg = pg_fetch_array($resul);
                       if ($reg["con"] == 0){
                           /* $sql = "SELECT Id_cabecera FROM pago_credito WHERE Id_credito='$cre'";
                           $res = mysqli_query($conex, $sql);
                           $reg = mysqli_fetch_array($res);
                           $cab = $reg["Id_cabecera"];*/
                            $sql = "UPDATE compra_cab SET estado = 'Pagado' WHERE idcompra = '$idcompra'";
                           $res= pg_query($conex, $sql);
                           $sql = "UPDATE pago_credito SET pagado = 'Si' WHERE idpago = '$idpago'";
                           $res= pg_query($conex, $sql);
                       }

                }
                $_SESSION["montoOperaciones"]-=$efe;
                $_SESSION["montoOperaciones"]+=$vue;
                $idCD = $_SESSION['Id_caja_detalle'];
               $sql = "INSERT INTO cajas_acciones(monto, accion, idcajadetalle, idcompra,idventa) VALUES ('$efe', 'Compra', '$idCD', '$idcompra', null)";
               $res =  pg_query($conex, $sql);
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
                echo 1;
          }/*else{
               for($i=1; $i<=$artic; $i++){
                    $id = $array[$pos];
                    $pos = $pos +1 ;
                    $rec = $array[$pos];
                    $pos = $pos +1 ;
                    $fec = $array[$pos];
                    $pos = $pos +1 ;
                    $sql = "UPDATE compra_cabecera SET Pagado = 'S' WHERE Id_cabecera = '$id'";
                    $res= mysqli_query($conex, $sql);
                    $sql="SELECT MAX(Id_credito) maxi FROM pago_credito";
                    $resul = mysqli_query($conex, $sql);
                    $reg = mysqli_fetch_array($resul);
                    $max=$reg['maxi'];
                    if($max == null){
                         $mx = 1;
                    }else{
                         $mx = $max+1;
                    }
                     $sql = "INSERT INTO pago_credito (Id_credito, Id_cabecera,Cantidad_cuotas) VALUES ('$mx', '$id', '0')";
                    $res = mysqli_query($conex, $sql);
                     $sql = "INSERT INTO pago_detalle (Fecha_pago, Num_cuota,Id_credito,Num_recibo,Pagado) VALUES ('$fec', '0', '$mx','$rec','S')";
                    $res = mysqli_query($conex, $sql);
                    $_SESSION["montoOperaciones"]-=$total;
                   $idCaDetalle = $_SESSION["idDetalle"];//capturo para mi caja acciones
                   $sql = "INSERT INTO caja_acciones (Monto, accion,Id_caja_detalle) VALUES ('$total', 'COMPRA', '$idCaDetalle')";
                  $res = mysqli_query($conex, $sql);
               }
               echo 1;
          }*/

     //}

 ?>
