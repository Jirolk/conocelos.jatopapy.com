<?php
function conexion(){
    $host = "localhost";
    $dbnam = "bdelecciones";
    // $port = "3306";
    $usuario="root";
    $password="123456";
    $conexion = null;
    $conexion = mysqli_connect($host, $usuario, $password, $dbnam);
    //("host=$host port=$port dbname=$dbnam user=$user password=$pass");

 
    if (!$conexion){
        echo "Error: No se pudo conectar a MySQL.".PHP_EOL;
        echo "Error de depuración: ".mysqli_connect_errno().PHP_EOL;
        echo "Error de depuración: ".mysqli_connect_error().PHP_EOL;
        exit;
    }else{
        $sql = "SET NAMES 'utf8'";
        $resultado = mysqli_query($conexion, $sql);
    }
    return $conexion;
}

function cerrarBD($conexion){
    $conexion = null;
}

?>