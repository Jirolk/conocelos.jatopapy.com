<?php
require_once("../servicios/conexion.php");
$conex = conexion();
// $sql = "SELECT c.ci, c.nomApe FROM candidatos c
//      INNER JOIN candidatura can ON c.tipoCand=can.codCand";
$sql = "SELECT * FROM candidatos ORDER BY nomApe ASC" ;
    $res = mysqli_query($conex, $sql);
    $num_reg = mysqli_num_rows($res);

    if ($num_reg > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $elementos[] = array(
                'cod' => $row['ci'],
                'nom' => $row['nomApe'],
                'lis' => $row['codMov']
            );
        }
        cerrarBD($conex);
        echo json_encode($elementos);
    } else{
        echo 1;
    }


?>