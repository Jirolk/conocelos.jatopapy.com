<?php
	session_start(); 	//Iniciamos o Continuamos la sesion
	require_once("conexion.php");
	/* if(isset($_SESSION['montoOperaciones'])){
		header("Location:forms/arqueoAcciones_lista.php");
	}else{ */
		$conexion = conexion($_SESSION["nombreUsuario"],$_SESSION["pass"]);
		// $conexion = conexion();
		$sql = "UPDATE usuario SET estado='Activo' WHERE idusuario=".$_SESSION["usuario"];
		$resul = pg_query($conexion, $sql);
		// $sql = "UPDATE cajas SET Estado='ACTIVO' WHERE Caja=".$_SESSION["caja"];
		// $resul = mysqli_query($conexion, $sql);
		session_unset();	//Elimina informaciones de todas las sesiones
		session_destroy();	//Cierra la sesion
		header("Location:../index.php");
		cerrarBD($conexion);
	//}

?>
