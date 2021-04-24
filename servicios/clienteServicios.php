<?php
  session_start();
     require("conexion.php");
      $conex = conexion($_SESSION["nombreUsuario"], $_SESSION["pass"]);
   
    //  $suc = $_SESSION["Cod_sucursal"];
    
     $opc = $_POST["accion"];
     if ($opc == "N" or $opc == "M"){
        		//Capturar los datos enviados por ajax
        		$ruc = strtoupper($_POST["ruc"]);
        		$cli = strtoupper($_POST["cli"]);
        		$dir = strtoupper($_POST["dir"]);
               $tel = $_POST["tel"];
               $ciu = $_POST["ciu"];
        		if ($opc == "M"){
              $rucSM = strtoupper($_POST["rucSM"]);
              $cliSM = strtoupper($_POST["cliSM"]);//se tiene que controlar que no haya ingresado el mismo cliente
              $dirSM = strtoupper($_POST["dirSM"]);
                $telSM = $_POST["telSM"];
                $ciuSM = $_POST["ciuSM"];
        		}
	     }

        if ($opc == "N"){	//NUEVO
              $grabar = true;
              $sql = "SELECT ruc FROM clientes WHERE  ruc= '$ruc'";
              $resul = pg_query($conex, $sql);
              $num_reg = pg_num_rows($resul);
              if ($num_reg > 0){
                $grabar = false;
                echo 1;
              }
              if($grabar == true){
                $sql = "INSERT INTO clientes (ruc, razon_social, direccion, telefono, idciudad) VALUES ('$ruc', '$cli', '$dir', '$tel', '$ciu')";
                $res = pg_query($conex, $sql);
                echo 2;
              }
        }else if ($opc == "M"){	//MODIFICAR
          $grabar = true;
          
          if ($ruc == $rucSM) {
            if ($cli == $cliSM) {
              if ($dir == $dirSM) {
                if ($tel == $telSM) {
                  if ($ciu == $ciuSM) {
                    $grabar = false;
                    echo 7;
                  }
              }
             }
           }
          }
            if($rucSM != $ruc){
                $sql = "SELECT * FROM clientes WHERE ruc = '$ruc'";
                $resul = pg_query($conex, $sql);
                $num_reg = pg_num_rows($resul);
                if ($num_reg > 0){
                  $grabar = false;
                  echo 3;
                }
            }
  
          if ($grabar == true){

            $sql = "UPDATE clientes SET ruc='$ruc', razon_social='$cli',direccion='$dir',telefono='$tel',idciudad='$ciu' WHERE ruc='$rucSM'";
            $resul = pg_query($conex, $sql);
            if (!$resul) {
            echo 8;
          }else{
            echo 4;

          }
          }
    }else if ($opc == "E"){	//ELIMINAR
        $ruc = $_POST["ruc"];
        $sql = "DELETE FROM clientes WHERE ruc='$ruc'";
        $res = pg_query($conex, $sql);
        if (!$res) {
            echo 6;
        }else{
          echo 5;

        }
    }
?>
