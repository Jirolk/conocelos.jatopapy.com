<?php
     require("conexion.php");
     session_start();
     $conex = conexion($_SESSION["nombreUsuario"],$_SESSION["pass"]);
     $opc = $_POST["accion"];
     if ($opc == "N" or $opc == "M"){
        		//Capturar los datos enviados por ajax
        $ruc = $_POST["ruc"];
        $prov = strtoupper($_POST["prov"]);
        $dir = strtoupper($_POST["dir"]);
        $tel1 = $_POST["tel1"];
        $tel2 = $_POST["tel2"];
        $ciu = $_POST["ciu"];
        if ($opc == "M"){
            $msm = strtoupper($_POST["msm"]);//se tiene que controlar que no haya ingresado el mismo proveedor
            $rsm = strtoupper($_POST["rsm"]);
            $t1sm = $_POST["t1sm"];
            $t2sm = $_POST["t2sm"];
            $suc= $_POST["suc"];
            $dsm = strtoupper($_POST["dsm"]);
        }
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
          $sql = "INSERT INTO proveedores (razon_social, telefono, direccion, contacto, ruc, idciudad) VALUES ('$prov', '$tel1', '$dir', '$tel2', '$ruc', '$ciu')";
          $res = pg_query($conex, $sql);
          echo 2;
        }
	}else if ($opc == "M"){	//MODIFICAR
        $grabar = true;
    		if ($rsm != $ruc || $prov != $msm || $tel1 != $t1sm || $tel2 != $t2sm || $dir != $dsm){ //Se modifico
            if($rsm != $ruc){
              $sql = "SELECT * FROM proveedores WHERE Ruc = '$ruc' AND Cod_sucursal =".$suc;
              $resul = mysqli_query($conex, $sql);
              $num_reg = mysqli_num_rows($resul);
              if ($num_reg > 0){
                $grabar = false;
                echo 3;
              }
            }
    		}else{
          $grabar = false;
          echo 7;
        }
    		if ($grabar == true){
    			$sql = "UPDATE proveedores SET Ruc='$ruc', Razon_social='$prov',Tel1='$tel1',Tel2='$tel2',Dir='$dir' WHERE Ruc='$rsm' AND Cod_sucursal=".$suc;
    			$resul = mysqli_query($conex, $sql);
          if (!$resul) {
              echo 8;
          }else{
            echo 4;

          }
    		}
	}else if ($opc == "E"){	//ELIMINAR
          $ruc = $_POST["ruc"];
          $suc = $_POST["suc"];
          $sql = "DELETE FROM Proveedores WHERE Ruc='$ruc' AND Cod_sucursal=".$suc;
		$res = mysqli_query($conex, $sql);
          if (!$res) {
              echo 6;
          }else{
            echo 5;

          }
     }
?>
