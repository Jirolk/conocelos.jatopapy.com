<?php
function conexion(){
    //$host = "www.jatopapy.com";
    $host = "localhost";
    $dbnam = "jattugco_candidatos";
    // $port = "3306";
    //$usuario="jattugco_candidatos";
    $usuario="root";
    //$password="lista.candidatos@123";
    $password="";
    $conexion = null;
    $conexion = mysqli_connect($host, $usuario, $password, $dbnam, $port);
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

