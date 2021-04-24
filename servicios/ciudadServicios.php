<?php
     session_start();
    require("conexion.php");
     $conex = conexion($_SESSION["nombreUsuario"], $_SESSION["pass"]);
    
     $opc = $_POST["accion"];
     if ($opc == "N" or $opc == "M"){
		$ciudad = strtoupper($_POST["ciudad"]);
		if ($opc == "M"){
			$ciudadSM = $_POST["ciudadSM"];//se tiene que controlar que no haya ingresado la misma ciudad
      $id = $_POST["id"];
		}
	}

     if ($opc == "N"){	//NUEVO
          $grabar = true;
          $sql = "SELECT ciudad FROM ciudades WHERE ciudad ILIKE '$ciudad' ";
          $resul = pg_query($conex, $sql);
          $num_reg = pg_num_rows($resul);
          if ($num_reg > 0){
               $grabar = false;
               cerrarBD($conex);
               echo 1;
          }
          if($grabar == true){
               $sql = "INSERT INTO ciudades (ciudad) VALUES ('$ciudad')";
     		$res = pg_query($conex, $sql);
               cerrarBD($conex);
     		echo 2;
          }
	}else if ($opc == "M"){	//MODIFICAR
          $grabar = true;
      		if ($ciudad != $ciudadSM){ //Se modifico la ciudad
      			//VERIFICAR QUE LA CIUDAD NO EXISTA
      			$sql = "SELECT ciudad FROM ciudades WHERE ciudad ILIKE'$ciudad'";
      			$resul = pg_query($conex, $sql);
      			$num_reg = pg_num_rows($resul);
      			if ($num_reg > 0){
        				$grabar = false;
                         cerrarBD($conex);
        				echo 3;
      	     }
      		}else {
                $grabar = false;
                    cerrarBD($conex);
                     echo 4;
                }
      		if ($grabar == true){
      			$sql = "UPDATE ciudades SET ciudad='$ciudad' WHERE idciudad='$id'";
      			$resul = pg_query($conex, $sql);
                    cerrarBD($conex);
      			echo 5;
      		}
	}else if ($opc == "E"){	//ELIMINAR
            $id = $_POST["id"];
            $sql = "DELETE FROM ciudades WHERE idciudad='$id'";
            $res = pg_query($conex, $sql);
            if (!$res) {
                    cerrarBD($conex);
                echo 7;
            }else{
                    cerrarBD($conex);
                echo 6;
            }
}
