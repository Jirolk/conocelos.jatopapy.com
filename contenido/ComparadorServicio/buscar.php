<?php
require("../../servicios/conexion.php");
$conex = conexion();

if(isset($_POST['op2'])){
    $sql = "SELECT * FROM candidatos c
    INNER JOIN candidatodetalle cd ON cd.ci=c.ci
    WHERE c.ci='".$_POST['candi1']."'";
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

}else{
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


}





