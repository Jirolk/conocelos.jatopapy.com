<?php
     session_start();
    require("conexion.php");
     $conex = conexion($_SESSION["nombreUsuario"], $_SESSION["pass"]);
    
     $opc = $_POST["accion"];
     if ($opc == "N" or $opc == "M"){
		$color = strtoupper($_POST["color"]);
		if ($opc == "M"){
			$colorSM = $_POST["colorsiM"];//se tiene que controlar que no haya ingresado la misma ciudad
      $id = $_POST["id"];
		}
	}

     if ($opc == "N"){	//NUEVO
          $grabar = true;
          $sql = "SELECT color FROM colores WHERE color ILIKE '$color' ";
          $resul = pg_query($conex, $sql);
          $num_reg = pg_num_rows($resul);
          if ($num_reg > 0){
               $grabar = false;
               cerrarBD($conex);
               echo 1;
          }
          if($grabar == true){
               $sql = "INSERT INTO colores (color) VALUES ('$color')";
     		$res = pg_query($conex, $sql);
               cerrarBD($conex);
     		echo 2;
          }
	}else if ($opc == "M"){	//MODIFICAR
          $grabar = true;
      		if ($color != $colorSM){ //Se modifico el color
      			//VERIFICAR QUE el color NO EXISTA
      			$sql = "SELECT color FROM colores WHERE color ILIKE'$color'";
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
      			$sql = "UPDATE colores SET color='$color' WHERE idciudad='$id'";
      			$resul = pg_query($conex, $sql);
                    cerrarBD($conex);
      			echo 5;
      		}
	}else if ($opc == "E"){	//ELIMINAR
            $id = $_POST["id"];
            $sql = "DELETE FROM colores WHERE idcolor='$id'";
            $res = pg_query($conex, $sql);
            if (!$res) {
                    cerrarBD($conex);
                echo 7;
            }else{
                    cerrarBD($conex);
                echo 6;
            }
}
