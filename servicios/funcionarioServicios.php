<?php
     session_start();
     require("../servicios/conexion.php");
     // echo $_SESSION["nombreUsuario"].$_SESSION["pass"];
     $conex = conexion($_SESSION["nombreUsuario"],$_SESSION["pass"]);
     // session_start();
     // $suc = $_SESSION["Cod_sucursal"];
     $opc = $_POST["accion"];
     if ($opc == "N" or $opc == "M"){
        		//Capturar los datos enviados por ajax
               $ci = $_POST["id"];
                  $fun = strtoupper($_POST["fun"]);
               //    $fun = $_POST["fun"];
               // $sex = $_POST["sex"];
        		$nac = $_POST["dire"];
               $tel = $_POST["tel"];
               if ($opc == "M"){
                    $csm = $_POST["id"];//sinmodificar
                    $ci = $_POST["ci"];
                    $nac = $_POST["dire"];
                    // $fsm = strtoupper($_POST["fsm"]); //nombre funcionario sin moif
                    $fsm = $_POST["fsm"]; //nombre funcinario sin moif
             		// $sexSM = $_POST["ssm"];//costo sin moif
                    $nacSM= $_POST["direm"];//dirección sin moif
                    $telSM = $_POST["tsm"];//telefono sin moif
        		}
	     }
     if ($opc == "N"){	//NUEVO
          $grabar = true;
          $sql = "SELECT ci_funcionario FROM funcionarios WHERE ci_funcionario='$ci'";
          $resul = pg_query($conex, $sql);
          $num_reg = pg_num_rows($resul);
          if ($num_reg > 0){
               $grabar = false;
               echo 1;
          }
          if($grabar == true){
               $sql = "INSERT INTO funcionarios (ci_funcionario, razon_social, telefono,direccion)VALUES ('$ci','$fun', '$tel','$nac')";
             		$res = pg_query($conex, $sql);
             		echo 2;
          }
     }else if ($opc == "M"){	//MODIFICAR
          // echo "CI in modificar:". $csm."CI: ".$ci."nombre:".$fun."nombre sin modificar".$fsm."Direcion: ".$nac."dirección sin modificar: ".$nacSM."Telefono: ".$tel."Telefono sin modficar: ".$telSM;
        $grabar = true;
    		if ($ci != $csm ||$fun != $fsm || $nac != $nacSM || $tel != $telSM){ //Se modifico
             if($csm != $ci){
              $sql = "SELECT * FROM funcionarios WHERE ci_funcionario = '$ci' ";
              $resul = pg_query($conex, $sql);
              $num_reg = pg_num_rows($resul);
              if ($num_reg > 0){
                $grabar = false;
                echo 3;
              }
               }
          }else{
               $grabar = false;
               echo 4;
        }
    		if ($grabar == true){
    			$sql = "UPDATE funcionarios SET ci_funcionario='$ci',razon_social='$fun', telefono='$tel', direccion='$nac' WHERE ci_funcionario='$csm'";
    			$resul = pg_query($conex, $sql);
          if (!$resul) {
              echo 6;
          }else{
            echo 5;

       }}
     }

	else if ($opc == "E"){	//ELIMINAR
          $id = $_POST["id"];
          // $suc = $_POST["suc"];
          $sql = "DELETE FROM funcionarios WHERE ci_funcionario='$id'";
		$res = pg_query($conex, $sql);
          if (!$res) {
              echo 7;
          }else{
            echo 8;

          }
     }
