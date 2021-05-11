<?php
function conexion(){
    $host = "www.jatopapy.com";
    $dbnam = "jattugco_candidatos";
    // $port = "3306";
    $usuario="jattugco_candidatos";
    $password="lista.candidatos@123";
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

