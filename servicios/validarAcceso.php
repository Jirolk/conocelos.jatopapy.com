<?php
// include_once("servicios/conexion.php");
require_once("conexion.php");
session_start();                    //Iniciamos o Continuamos la sesion
unset($_SESSION["nivelUsuario"]);   //Destruye la variable nivelUsuario
session_destroy();                  //Destruye la informacion de la session actual
session_start();

//recibo los datos
$user = $_POST['loginname'];
$contrasena = $_POST['password'];
$encontro = 0;
// $user=1;
if ($user == null || $user == "") {
    echo "No está autorizado para acceder al sistema!!...";
} else {
    //se inicia con un usuario por defecto para hacer las validación por la BD
        $user = "postgres"; 
        $contrasena = "1234"; // contraseña de la base de Datos
        $conexion = conexion($user, $contrasena);
        //cambio los datos recibidos en otras variables
        $usuario = $_POST['loginname'];
        $password = $_POST['password'];
        $sql = "SELECT usuario.idusuario,usuario.ci_funcionario,usuario.estado,usuario.contraseña, razon_social, usuario.Estado, rol FROM usuario INNER JOIN funcionarios ON funcionarios.ci_funcionario = usuario.ci_funcionario WHERE usuario.ci_funcionario = '".$usuario."' AND contraseña = '".$password. "'"; //sentencia para devolver registro de usuario
        $resultado = pg_query($conexion, $sql);
        $totRegistros = pg_num_rows($resultado);
        if ($totRegistros < 1) {
            $_SESSION["usuarioValido"] = "no"; //Usuario o contraseña no valido
        } else {
            //si el usuario esta en la tabla de usuarios
            while ($fila = pg_fetch_assoc($resultado)) {
                $Funcion = $fila['rol'];
                $nombre   = $fila['razon_social'];
                $estado = $fila['estado'];
                // $sucursal = $row['Cod_sucursal'];
                $user = $fila['idusuario'];
            }
            if ($estado == "Ocupado" || $estado == "Desactivado") {
                $_SESSION["usuarioValido"] = "noo";
            } else {
                //Se crea variables de sesion
                $_SESSION["usuarioValido"] = "si"; //Usuario y contraseña valido
                $_SESSION["nombreUsuario"] = strtolower(str_replace(' ','',$nombre));//se sacan los espacios
                //en caso que tenga y los combierte en minuscula
                $_SESSION["pass"]  = $password; //contraseña para la base de datos
                $_SESSION["nivelUsuario"]  = $Funcion;
                $_SESSION["usuario"] = $user;
                $sql = "UPDATE usuario SET estado='Ocupado' WHERE idusuario='" . $user . "'";
                $resul = pg_query($conexion, $sql);
                cerrarBD($conexion); // cerramos la conección del usuario consulta
                $conexion = conexion($_SESSION["nombreUsuario"],$_SESSION["pass"] ); //volvemos a conectarnos con el usuario de la BD
            }
        }
 


    // $conexion = conexion($user, $contrasena);
    // if (!$conexion) {
    //     $_SESSION["usuarioValido"] = "no";
    // } else {
    //     while ($fila = pg_fetch_assoc($resultado)) {
    //         $Funcion = $fila['rol'];
    //         $nombre   = $fila['razon_social'];
    //         $estado = $fila['estado'];
    //         // $sucursal = $row['Cod_sucursal'];
    //         $user = $fila['idusuario'];
    //     }

    //     if ($estado == "Ocupado" || $estado == "Desactivado") {
    //         $_SESSION["usuarioValido"] = "noo";
    //     } else {
    //         //Se crea variables de sesion
    //         $_SESSION["usuarioValido"] = "si"; //Usuario y contraseña valido
    //         $_SESSION["nombreUsuario"] = $nombre;
    //         $_SESSION["nivelUsuario"]  = $Funcion;
    //         // $_SESSION["Cod_sucursal"]  = $sucursal;
    //         $_SESSION["usuario"] = $user;
    //         $sql = "UPDATE usuario SET estado='Ocupado' WHERE idusuario='" . $user . "'";
    //         $resul = pg_query($conexion, $sql);
    //     }
    // }



    // // $contrasena=md5($contrasena); //encriptado de contraseña
    // $sql = "SELECT usuario.idusuario,usuario.ci_funcionario,usuario.estado,usuario.contraseña, razon_social, usuario.Estado, rol FROM usuario
    // INNER JOIN funcionarios ON funcionarios.ci_funcionario = usuario.ci_funcionario
    // WHERE   usuario.ci_funcionario = '".$user."' AND contraseña = '".$contrasena."'" ;//falta funcion pra saber si es admin o recepcionista
    // $resultado = pg_query($conexion, $sql);
    // $totRegistros = pg_num_rows($resultado);
    // if ($totRegistros < 1){
    //     $_SESSION["usuarioValido"] = "no"; //Usuario o contraseña no valido
    // }else{
    //     while ($fila = pg_fetch_assoc($resultado)) {
    //         $Funcion = $fila['rol'];
    //         $nombre   = $fila['razon_social'];
    //         $estado = $fila['estado'];
    //         // $sucursal = $row['Cod_sucursal'];
    //         $user = $fila['idusuario'];
    //     }

    //     if($estado == "Ocupado" || $estado == "Desactivado"){
    //         $_SESSION["usuarioValido"] = "noo";
    //     }else{
    //         //Se crea variables de sesion
    //         $_SESSION["usuarioValido"] = "si"; //Usuario y contraseña valido
    //         $_SESSION["nombreUsuario"] = $nombre;
    //         $_SESSION["nivelUsuario"]  = $Funcion;
    //         // $_SESSION["Cod_sucursal"]  = $sucursal;
    //         $_SESSION["usuario"] = $user;
    //         $sql = "UPDATE usuario SET estado='Ocupado' WHERE idusuario='".$user."'";
    //         $resul = pg_query($conexion, $sql);
    //     }
    // }

    header("Location:../index.php");
}
