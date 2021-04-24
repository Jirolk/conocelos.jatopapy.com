<?php
session_start();
require_once("conexion.php");
$conex = conexion($_SESSION["nombreUsuario"], $_SESSION["pass"]);
$accion = $_POST["accion"];
// $sql = "SELECT * FROM usuario WHERE idusuario = '$valor'";

if($accion=='T'){
    $consulta = $_POST["user"];
    $sql = "SELECT * FROM auditoria where nombretabla = '$consulta' order by idauditoria DESC";
    $res = pg_query($conex, $sql);
    $num_reg1 = pg_num_rows($res);
    if($num_reg1>0){
        while ($row = pg_fetch_assoc($res)) {
            $elementos[] = array('id'=> $row['idauditoria'],
            'tabla' => $row['nombretabla'],
            'operacion'=>$row['operacion'],
            'viejo'=>$row['valorviejo'],
            'nuevo'=>$row['valornuevo'],
            'fecha'=>$row['fecha'],
            'user'=>$row['usuario'], 
            'ip' => $row['ip']);
            // $elementos[] = $row;
        }
        echo json_encode($elementos);
    }else{
        echo 1;
    }
}else if ($accion == 'U') {
    $consulta = $_POST["user"];
        $sql = "SELECT * FROM auditoria where usuario = '$consulta' order by idauditoria DESC";
        $res = pg_query($conex, $sql);
        $num_reg1 = pg_num_rows($res);
        if($num_reg1>0){
            while ($row = pg_fetch_assoc($res)) {
                $elementos[] = array('id'=> $row['idauditoria'],
                'tabla' => $row['nombretabla'],
                'operacion'=>$row['operacion'],
                'viejo'=>$row['valorviejo'],
                'nuevo'=>$row['valornuevo'],
                'fecha'=>$row['fecha'],
                'user'=>$row['usuario'], 
                'ip' => $row['ip']);
                // $elementos[] = $row;
            }
            echo json_encode($elementos);
        }else{
            echo 4;
        }
        
}else if($accion == 'O'){
    $consulta = $_POST["user"];
    $sql = "SELECT * FROM auditoria where operacion = '$consulta' order by idauditoria DESC";
        $res = pg_query($conex, $sql);
        $num_reg1 = pg_num_rows($res);
        if($num_reg1>0){
            while ($row = pg_fetch_assoc($res)) {
                $elementos[] = array('id'=> $row['idauditoria'],
                'tabla' => $row['nombretabla'],
                'operacion'=>$row['operacion'],
                'viejo'=>$row['valorviejo'],
                'nuevo'=>$row['valornuevo'],
                'fecha'=>$row['fecha'],
                'user'=>$row['usuario'], 
                'ip' => $row['ip']);
                // $elementos[] = $row;
            }
            echo json_encode($elementos);
        }else{
            echo 2;
        }
}else if($accion=='F'){
    $fec1= $_POST["fec1"];
    $fec2= $_POST["fec2"];
    $sql = "SELECT * FROM auditoria where fecha between '$fec1' and '$fec2' order by idauditoria DESC;";
        $res = pg_query($conex, $sql);
        $num_reg1 = pg_num_rows($res);
        if($num_reg1>0){
            while ($row = pg_fetch_assoc($res)) {
                $elementos[] = array('id'=> $row['idauditoria'],
                'tabla' => $row['nombretabla'],
                'operacion'=>$row['operacion'],
                'viejo'=>$row['valorviejo'],
                'nuevo'=>$row['valornuevo'],
                'fecha'=>$row['fecha'],
                'user'=>$row['usuario'], 
                'ip' => $row['ip']);
                // $elementos[] = $row;
            }
            echo json_encode($elementos);
        }else{
            echo 3;
        }
}

