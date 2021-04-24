<?php
session_start();
require("conexion.php");
$conex = conexion($_SESSION["nombreUsuario"], $_SESSION["pass"]);
//  session_start();
//  $suc = $_SESSION["Cod_sucursal"];
$opc = $_POST["accion"];
if ($opc == "N" or $opc == "M") {
  //Capturar los datos enviados por ajax
  //$ruc = $_POST["ruc"];
  $func = $_POST["func"];
  $pass = $_POST["pass"];
  // $dir = strtoupper($_POST["dir"]);
  $est = $_POST["est"];
  $fu = $_POST["fu"];
  //$nac = $_POST["nac"];
  if ($opc == "M") {
    $id = $_POST["id"];
    $fsm = $_POST["fsm"]; //se tiene que controlar que no haya ingresado el mismo usuario
    $psm = $_POST["psm"];
    $esm = $_POST["esm"];
    $fusm = $_POST["fusm"];
    //$nsm = $_POST["nsm"];
    // $suc = $_POST["suc"];
    //$dsm = strtoupper($_POST["dsm"]);
  }
}
if ($opc == "N") {  //NUEVO
  $grabar = true;
  $consutla = "";
  $sql = "SELECT ci_funcionario FROM usuario WHERE  ci_funcionario= '$func'";
  $resul = pg_query($conex, $sql);
  $num_reg = pg_num_rows($resul);
  if ($num_reg > 0) {
    $grabar = false;
    echo 1;
  }
  if ($grabar == true) {
    // $pass= md5($pass); //encriptado de contraseña
    $sql = "SELECT razon_social FROM funcionarios WHERE  ci_funcionario= '$func'"; //consulta para el nombre del usuario
    $res = pg_query($conex, $sql);
    while ($fila = pg_fetch_array($res)) {
      $nombre = $fila['razon_social']; // obtenemos el nombre
    }
    $userBD = strtolower(str_replace(' ', '', $nombre));

    // $sql="CREATE ROLE $nombre LOGIN ENCRYPTED PASSWORD '$pass' NOSUPERUSER INHERIT CREATEROLE"; //crear un usUario para la base de datos
    // $sql="CREATE ROLE $nombre LOGIN PASSWORD '$pass' SUPERUSER INHERIT CREATEROLE"; //crear un 
    // =================================================================
    if ($fu == 'Administrador' || $fu == 'Produccion' || $fu == 'Venta') {
      $sql = "CREATE ROLE $userBD LOGIN PASSWORD '$pass' SUPERUSER INHERIT CREATEROLE";
      // $sql = "CREATE USER $userBD WITH PASSWORD '$pass'";
      $res = pg_query($conex, $sql); //ejecución del rol
      $sql = "GRANT SELECT, INSERT, UPDATE, DELETE ON ALL TABLES IN SCHEMA public TO $userBD;"; //PRIVILEGIO COMPLETO 
      // $slq= "grant all privileges on all tables in schema public to $userBD";
      $res = pg_query($conex, $sql); //ejecución de privilegios
      // $slq= "GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO $userBD";
      // $res =   pg_query($conex, $sql); //ejecución de LA SECUENCIAS

    } else if ($fu == 'Producon' || $fu == 'Ven') { // cambie los datos para que no entre en esta iteración
      $sql = "CREATE USER $userBD WITH PASSWORD '$pass'";
      $res = pg_query($conex, $sql); //ejecución del rol
      // $sql = "GRANT SELECT, INSERT, UPDATE, DELETE ON ALL TABLES IN SCHEMA public TO $userBD;"; //PRIVILEGIO COMPLETO 
      $slq= "grant all privileges on all tables in schema public to $userBD";
      $res = pg_query($conex, $sql); //ejecución de privilegios
      $slq= "GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO $userBD";
      $res =   pg_query($conex, $sql); //ejecución de LA SECUENCIAS
      // $sql = "CREATE USER $userBD PASSWORD '$pass'"; //crear un 
      // $res =   pg_query($conex, $sql); //ejecución del rol
      // $sql = "GRANT CONNECT ON DATABASE deobd TO $userBD;"; //Privilegio de Coneccion 
      // $res =   pg_query($conex, $sql); //
      // $sql = "GRANT SELECT, INSERT, UPDATE, DELETE ON ALL TABLES IN SCHEMA public TO $userBD;"; //PRIVILEGIO COMPLETO 
      // $res =   pg_query($conex, $sql); //ejecución del rol


    } else if ($fu == 'Delivery') {
      $sql = "CREATE USER $userBD PASSWORD '$pass'"; //crear un 
      $res =   pg_query($conex, $sql); //ejecución del rol
      $sql = "GRANT CONNECT ON DATABASE deobd TO $userBD;"; //Privilegio de Coneccion 
      $res =   pg_query($conex, $sql); //ejecución del rol
      $sql = "GRANT SELECT, INSERT ON ALL TABLES IN SCHEMA public TO $userBD;"; //crear un 
      $res =   pg_query($conex, $sql); //ejecución del rol
    }

    $sql = "INSERT INTO usuario (contraseña, estado, rol, ci_funcionario) VALUES ('$pass','$est', '$fu','$func')";
    $res = pg_query($conex, $sql);
    echo 2;
  }
} else if ($opc == "M") {  //MODIFICAR
  $grabar = true;
  // if ($fsm != $func || $psm != $pass || $est != $esm || $fu != $fusm) { //Se modifico
    if ($fsm != $func || $est != $esm || $fu != $fusm) { //Se modifico
    if ($fsm != $func) {
      $sql = "SELECT * FROM usuario WHERE idusuario = '$id'";
      $resul = pg_query($conex, $sql);
      $num_reg = pg_num_rows($resul);
      if ($num_reg > 0) {
        $grabar = false;
        echo 3;
      }
    }
  } else {
    $grabar = false;
    echo 7;
  }
  if ($grabar == true) {
    // $pass = md5($pass); //encriptado de contraseña
    // $sql = "UPDATE usuario SET contraseña='$pass', estado='$est',rol='$fu',ci_funcionario='$func' WHERE idusuario='$id'";
    $sql = "UPDATE usuario SET estado='$est',rol='$fu',ci_funcionario='$func' WHERE idusuario='$id'";
    $resul = pg_query($conex, $sql);
  //  ===============OBTENER EL NOMBRE DEL USUARIO DE LA BD================
    $sql = "SELECT razon_social FROM funcionarios WHERE  ci_funcionario= '$func'"; //consulta para el nombre del usuario
    $res = pg_query($conex, $sql);
    while ($fila = pg_fetch_array($res)) {
      $nombre = $fila['razon_social']; // obtenemos el nombre
    }
    $userBD = strtolower(str_replace(' ', '', $nombre));

    if ($fu == 'Administrador') {
      // $sql = "ALTER ROLE $userBD LOGIN PASSWORD '$pass' NOSUPERUSER INHERIT CREATEROLE";
      $sql = "ALTER ROLE $userBD LOGIN PASSWORD '$pass' SUPERUSER INHERIT CREATEROLE";
      $res =   pg_query($conex, $sql); //ejecución del rol
      // $sql = "GRANT SELECT, INSERT, UPDATE, DELETE ON ALL TABLES IN SCHEMA public TO $userBD;"; //PRIVILEGIO COMPLETO 
      // $res =   pg_query($conex, $sql); //ejecución de privilegios
    } else if ($fu == 'Produccion' || $fu == 'Venta') { //
      $sql = "ALTER ROLE $userBD PASSWORD '$pass'"; //crear un 
      $res =   pg_query($conex, $sql); //ejecución del rol
      $sql = "GRANT CONNECT ON DATABASE deobd TO $userBD;"; //Privilegio de Coneccion 
      $res =   pg_query($conex, $sql); //
      $sql = "GRANT SELECT, INSERT, UPDATE, DELETE ON ALL TABLES IN SCHEMA public TO $userBD;"; //PRIVILEGIO COMPLETO 
      $res =   pg_query($conex, $sql); //ejecución del rol
    } else if ($fu == 'Delivery') {
      $sql = "ALTER ROLE $userBD PASSWORD '$pass'"; //crear un 
      $res =   pg_query($conex, $sql); //ejecución del rol
      $sql = "GRANT CONNECT ON DATABASE deobd TO $userBD;"; //Privilegio de Coneccion 
      $res =   pg_query($conex, $sql); //ejecución del rol
      $sql = "GRANT SELECT, INSERT ON ALL TABLES IN SCHEMA public TO $userBD;"; //crear un 
      $res =   pg_query($conex, $sql); //ejecución del rol
    }
    // $sql = "SELECT razon_social FROM funcionarios WHERE  ci_funcionario= '$func'"; //consulta para el nombre del usuario
    // $res = pg_query($conex, $sql);
    // while ($fila = pg_fetch_array($res)) {
    //   $nombre = $fila['razon_social']; // obtenemos el nombre
    // }
    // $userBD = strtolower(str_replace(' ', '', $nombre));
    // $sql="ALTER ROLE $nombre PASSWORD '$pass'";
    // $res = pg_query($conex, $sql);
    
    if (!$resul) {
      echo 8;
    } else {
      echo 4;
    }
  }
} else if ($opc == "E") {  //ELIMINAR
  $id = $_POST["id"];
  // $suc = $_POST["suc"];
  $sql = "SELECT  razon_social
  FROM usuario INNER JOIN funcionarios ON funcionarios.ci_funcionario = usuario.ci_funcionario
  WHERE   usuario.idusuario = '$id'"; //consulta para el nombre del usuario
  $res = pg_query($conex, $sql);
  while ($fila = pg_fetch_array($res)) {
    $nombre = $fila['razon_social']; // obtenemos el nombre
  }
  $userBD = strtolower(str_replace(' ', '', $nombre));
  $sql = "DROP OWNED by $userBD"; //SACA TODOS LOS PRIVILEGIOS PARA BORRAR
  $res = pg_query($conex, $sql);
  $sql = "DROP ROLE $userBD"; //ELIMINA EL USE DE LA BD
  $res = pg_query($conex, $sql);

  $sql = "DELETE FROM usuario WHERE idusuario='$id'";
  $res = pg_query($conex, $sql);

  if (!$res) {
    echo 6;
  } else {
    echo 5;
  }
}
?>