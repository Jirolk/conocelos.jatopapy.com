<?php
  session_start();
     require("conexion.php");
      $conex = conexion($_SESSION["nombreUsuario"], $_SESSION["pass"]);
   
    //  $suc = $_SESSION["Cod_sucursal"];
    
     $opc = $_POST["accion"];
     if ($opc == "N" ){
        		//Capturar los datos enviados por ajax
        		$pro = strtoupper($_POST["pro"]);
                $tel = $_POST["tel"];
                $dir = strtoupper($_POST["dir"]);
                $con = $_POST["con"];
        		$ruc = strtoupper($_POST["ruc"]);
                $ciu = $_POST["ciu"];
            }
        		if ($opc == "M"){
                    // Datos sin modificar
                    $proSM = strtoupper($_POST["proSM"]);//se tiene que controlar que no haya ingresado el mismo proveedor
                    $telSM = $_POST["telSM"];
                    $dirSM = strtoupper($_POST["dirSM"]);
                    $conSM = $_POST["conSM"];
                    $rucSM = strtoupper($_POST["rucSM"]);
                    $ciuSM = $_POST["ciuSM"];
                    // Datps modificados
                    $proM = strtoupper($_POST["proM"]);//se tiene que controlar que no haya ingresado el mismo proveedor
                    $telM = $_POST["telM"];
                    $dirM = strtoupper($_POST["dirM"]);
                    $conM = $_POST["conM"];
                    $rucM = strtoupper($_POST["rucM"]);
                    $ciuM = $_POST["ciuM"];
        		}
	     

        if ($opc == "N"){	//NUEVO
              $grabar = true;
              $sql = "SELECT ruc FROM proveedores WHERE  ruc= '$ruc'";
              $resul = pg_query($conex, $sql);
              $num_reg = pg_num_rows($resul);
              if ($num_reg > 0){
                $grabar = false;
                echo 1;
              }
              if($grabar == true){
                $sql = "INSERT INTO proveedores (razon_social, telefono, direccion, contacto, ruc, idciudad) VALUES ('$pro', '$tel', '$dir', '$con', '$ruc', '$ciu')";
                $res = pg_query($conex, $sql);
                echo 2;
              }
        }else if ($opc == "M"){	//MODIFICAR
          $grabar = true;
          
          if ($proM == $proSM) {
            if ($telM == $telSM) {
              if ($dirM == $dirSM) {
                if ($conM == $conSM) {
                  if ($rucM == $rucSM) {
                    if ($ciuM == $ciuSM){
                        $grabar = false;
                        echo 7;
                    }
                  }
                }
             }
           }
          }
            if($rucSM != $rucM){
                $sql = "SELECT * FROM proveedores WHERE ruc = '$rucM'";
                $resul = pg_query($conex, $sql);
                $num_reg = pg_num_rows($resul);
                if ($num_reg > 0){
                  $grabar = false;
                  echo 3;
                }
            }
  
          if ($grabar == true){

            $sql = "UPDATE proveedores SET razon_social='$proM', telefono='$telM', direccion='$dirM', ruc='$rucM', idciudad='$ciuM' WHERE ruc='$rucSM'";
            $resul = pg_query($conex, $sql);
            if (!$resul) {
            echo 8;
          }else{
            echo 4;

          }
          }
    }else if ($opc == "E"){	//ELIMINAR
        $ruc = $_POST["ruc"];
        $sql = "DELETE FROM proveedores WHERE ruc='$ruc'";
        $res = pg_query($conex, $sql);
        if (!$res) {
            echo 6;
        }else{
          echo 5;

        }
    }
?>
