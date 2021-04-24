<?php
session_start();
require_once("conexion.php");
$conex = conexion($_SESSION["nombreUsuario"], $_SESSION["pass"]);
$valor = $_POST["id"];
//  $suc= $_POST["suc"];
$sql = "SELECT * FROM usuario WHERE idusuario = '$valor'";
$res = pg_query($conex, $sql);
$reg = pg_fetch_array($res);
$datos = $reg['idusuario'] . ',' . $reg['contraseña'] . ',' . $reg['estado'] . ',' . $reg['rol'] . ',' . $reg['ci_funcionario']; //concateno
echo $datos;
?>
