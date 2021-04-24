<?php
  session_start();
     require("conexion.php");
      $conex = conexion($_SESSION["nombreUsuario"], $_SESSION["pass"]);

     $opc = $_POST["accion"];
     if ($opc == "N" ){
        		//Capturar los datos enviados por ajax
               $des = strtoupper($_POST["des"]);
        		   $uni = $_POST["uni"];
               $cat = $_POST["cat"];
               $col = $_POST["col"];
               $conv = $_POST["conv"];
               $sto = $_POST["sto"];
               $pre = $_POST["pre"];
	     }
        		if ($opc == "M"){

              
                $desSM = strtoupper($_POST["desSM"]);
                $uniSM = $_POST["uniSM"];
                $catSM = $_POST["catSM"];
                $colSM = $_POST["colSM"];
                $convSM = $_POST["convSM"];
                // $stockSM = $_POST["stockSM"];
                $precSM = $_POST["precSM"];
                $id = $_POST["id"];

                $desM = strtoupper($_POST["desM"]);
                $uniM = $_POST["uniM"];
                $catM = $_POST["catM"];
                $colM = $_POST["colM"];
                $convM = $_POST["convM"];
                // $stockM = $_POST["stockM"];
                $precM = $_POST["precM"];
        		}

        if ($opc == "N"){	//NUEVO
              $grabar = true;
              $sql = "SELECT descripcion FROM insumos WHERE descripcion ILIKE '$des'";
              $resul = pg_query($conex, $sql);
              $num_reg = pg_num_rows($resul);
              if ($num_reg > 0){
                $grabar = false;
                echo 1;
              }
              if($grabar == true){
                $sql = "INSERT INTO insumos (descripcion, unidad_med, idcategoria, idcolor, conversion, stock, precompra) VALUES ('$des', '$uni', '$cat', '$col', '$conv', '$sto', '$pre')";
                $res = pg_query($conex, $sql);
                echo 2;
              }
        }else if ($opc == "M"){	//MODIFICAR
          
          $grabar = true;
          
          if ($desM   == $desSM) {
            if ($uniM == $uniSM) { 
              if ($catM == $catSM) {
                if ($colM == $colSM) {
                  if ($convM == $convSM){
                    if ($preM == $precSM){
                       $grabar = false;
                       echo 7;
                    }
                  }
                }
              }
            }
          }

            if($desSM != $desM){
                $sql = "SELECT descripcion FROM insumos WHERE descripcion ILIKE '$desM'";
                $resul = pg_query($conex, $sql);
                $num_reg = pg_num_rows($resul);
                if ($num_reg > 0){
                  $grabar = false;
                  echo 3;
                }
            }
  
          if ($grabar == true){
            $sql = "UPDATE insumos SET descripcion='$desM', unidad_med='$uniM',idcategoria='$catM',idcolor='$colM',conversion='$convM',precompra='$precM' WHERE idinsumo='$id'";
            $resul = pg_query($conex, $sql);
            if (!$resul) {
            echo 8;
          }else{
            echo 4;

          }
          }
    }else if ($opc == "E"){	//ELIMINAR
        $id = $_POST["id"];
        $sql = "DELETE FROM insumos WHERE idinsumo='$id'";
        $res = pg_query($conex, $sql);
        if (!$res) {
            echo 6;
        }else{
          echo 5;

        }
    }
?>
