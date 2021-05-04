<?php
require("../../servicios/conexion.php");
$conex = conexion();
// $sql = "SELECT c.ci, c.nomApe FROM candidatos c
//      INNER JOIN candidatura can ON c.tipoCand=can.codCand";
$sql = "SELECT c.ci, c.nomApe FROM candidatos c
    INNER JOIN candidatura can ON c.codCand=can.codCand 
    WHERE can.codCand ='".$_POST['candi']."';" ;
    $res = mysqli_query($conex, $sql);
    $num_reg = mysqli_num_rows($res);

    if ($num_reg > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $elementos[] = array(
                'ide' => $row['ci'],
                'nom' => $row['nomApe']
            );
        }
        cerrarBD($conex);
        echo json_encode($elementos);
    } else{
        echo 1;
    }



