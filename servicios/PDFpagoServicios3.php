
<?php
require_once("conexion.php");
require("../fpdf/rotation.php");
session_start();
class PDF extends PDF_rotate{
     function Header(){
          //Funcion para la cabecera de pagina, es automaticamente invocado por AddPage() y Close()
          //CONSULTA
          $con = conexion($_SESSION["nombreUsuario"], $_SESSION["pass"]);
          $id = $_GET["fac"];
          $fecha = $_GET["fec"];
          $sql = "SELECT c.*, r.Razon_social,r.direccion, r.telefono, r.contacto, u.rol, f.razon_social Empleado FROM compra_cab c
          INNER JOIN proveedores r ON c.Ruc=r.Ruc
          LEFT JOIN usuario u ON u.idusuario=c.idusuario
          LEFT JOIN funcionarios f ON f.ci_funcionario=u.ci_funcionario
          WHERE c.nro_factura =  '$id' And c.fecha = '$fecha'";
          $result = pg_query($con, $sql);
          $row = pg_fetch_array($result);
          //DATOS DEL PROVEEDOR
          $margenIzquierdo = 10;
          $this->SetFont('Arial','B', 15);
          $this->SetXY($margenIzquierdo,10);
          $this->Cell(100, 6, utf8_decode($row['razon_social']),'TLR',2,'C');
          $this->SetFont('Arial','B', 10);
          if($row['direccion'] == null){
               $this->SetXY($margenIzquierdo,16);
               $this->Cell(100, 4, utf8_decode('Tel.: '.$row['telefono'].' '. $row['contacto']),'LR',2,'C');
               $this->SetXY($margenIzquierdo,20);
               $this->Cell(100, 4, utf8_decode(''),'LR',2,'C');
          }else{
               $this->SetXY($margenIzquierdo,16);
               $this->Cell(100, 4, utf8_decode($row['direccion']),'LR',2,'C');
               $this->SetXY($margenIzquierdo,20);
               $this->Cell(100, 4, utf8_decode('Tel.: '.$row['telefono'].' '. $row['contacto']),'LR',2,'C');
          }
          $this->SetXY($margenIzquierdo,24);
          $this->Cell(100, 4, utf8_decode('Concepción - Paraguay'),'LRB',2,'C');
          //$this->Image('../img/logoDeo2.png' , 15 ,10, 35 , 25,'PNG', '');
          // $pdf->Image('../img/logo2.png' , 25 ,0, 35 , 25,'PNG', '');
          // $pdf->Image('../img/logo2.png' , 225 ,0, 35 , 25,'PNG', '');
          

          //TIMBRADO
          $this->SetFont('Arial','B', 11);
          $this->SetXY(115,10);
          $this->Cell(80, 6, utf8_decode('TIMBRADO N° 00000000'),'TLR',2,'C');
          $this->SetFont('Arial','B', 8);
          $this->SetXY(115,15);
          $this->Cell(80, 6, utf8_decode('R.U.C.: '.$row['ruc']),'LR',2,'C');
          $this->SetXY(115,18);
          $this->Cell(80, 6, utf8_decode('BOLETA DE COMPRA'),'LR',2,'C');
          $this->SetFont('Arial','B', 10);
          $this->SetXY(115,22);
          $this->Cell(80, 6, utf8_decode('N° '. $row['nro_factura']),'LRB',2,'C');

          //Datossss
          $this->SetFont('Arial','' ,10);
          $this->SetXY($margenIzquierdo,30);
          $fec = date_create(utf8_decode($row['fecha']));
          $com = date_format($fec,"d/m/Y");
          $this->Cell(185, 7,'Fecha: '. $com,'TLR',2,'L');
          $this->SetXY($margenIzquierdo,34);
          $this->Cell(185, 7,utf8_decode('R.U.C. o Cédula de Identidad: 935861-7'),'LR',2,'L');
          $this->SetXY($margenIzquierdo,38);
          $this->Cell(185, 7,utf8_decode('Nombre o Razón Social: María Deolinda Delgado de Recalde'),'LRB',2,'L');
          $this->SetXY(122,34);
          $this->Cell(80, 6, utf8_decode('Condición: '.$row['condicion']),'',2,'C');
          ////var
          $est = $row['estado'];
          $this->SetFont('Arial','B',50);
          $this->SetTextColor(255,192,203);
          $this->RotatedText(80,100,$est,35);

     }
     function RotatedText($x, $y, $txt, $angle){
          //Text rotated around its origin
          $this->Rotate($angle,$x,$y);
          $this->Text($x,$y,$txt);
          $this->Rotate(0);
     }
     function Footer(){
          //Funcion para el pie de pagina, es automaticamente invocado por AddPage() y Close()
        $this->SetY(-15);	//Margen Inferior
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0,6, utf8_decode('Pág. ').$this->PageNo().'/{nb}',0,0,'C');
     }
}

//Crea un nuevo archivo PDF
//ORIENTACION: P o Portrait (vertical) por defecto, L o Landscape (horizontal)
//UNIDADES: pt: punto, mm: milimetro por defecto, cm: centimetro, in: pulgada
//TAMAÑOS DE PAPEL: A3, A4, A5, Letter, Legal
$pdf = new PDF('P', 'mm', 'A4');

$pdf->AliasNbPages();	//Obligatorio para obtener el numero total de paginas

//Agrega una pagina
$pdf->AddPage();

//Distancia desde el margen superior en milimetros
//$margenSuperior = 54;
$margenSuperior = 47;
//Establece alto de fila
$altoFila = 7;

cabecera();

$margenSuperior = $margenSuperior + $altoFila;
//Contador de registros (filas)
$i = 0;
$r = 0;	//Para obtener el total de registros

//Cantidad de registros por pagina
$max = 27;		//39 es la cantidad de filas q cabe en la hoja A4

date_default_timezone_set('America/Asuncion');
$fecha = (date("d/m/Y H:i:s"));
$con = conexion($_SESSION["nombreUsuario"], $_SESSION["pass"]);  
$id = $_GET["fac"];
$sql = "SELECT d.*,i.descripcion,i.Iva,c.t_iva5,c.t_iva10 FROM compra_det d
INNER JOIN insumos i ON i.idinsumo=d.idinsumo
inner join compra_cab c on c.idcompra=d.idcompra
WHERE nro_factura = '$id'";
$result= pg_query($con,$sql);
$ttiva5 = 0;
$ttiva10 = 0;
$totiva =0;
$TT=0;
while($row = pg_fetch_array($result)){
     $r = $r+1;
    //Agregar pagina si llegamos al limite de registros por pagina
    if ($i == $max){
        $pdf->AddPage();		//Agrega nueva pagina
        $margenSuperior = 50;	//Estable margen superior de la nueva pagina

        cabecera();
        	//Imprime la cabecera
        //Realiza un salto de linea
        $margenSuperior = $margenSuperior + $altoFila;
        //Inicializa la variable que controla la cantidad de registros (filas)
        $i = 0;
    }
    $des=$row['descripcion'];
    $can=$row['cantidad'];
    $pre=$row['precompra'];
    $tot=$row['total'];
    $pdf->SetFillColor(255, 255, 255);	//Color de las celdas
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetY($margenSuperior);	//Margen superior
    $pdf->SetX(10);					//Margen izquierdo
    //$string = fullname($des);
    //$cellWidth = $pdf->GetStringWidth($string);
    //Imprimir los campos
    $pdf->Cell(20, $altoFila, $can, 1, 0, 'R', false);
    //$pdf->Cell($cellWidth + 5, $altoFila, $string, 1, 0, 'L', 1);
    $pdf->Cell(125, $altoFila, $des, 1, 0, 'L', false);
    $pdf->Cell(20, $altoFila, $pre, 1, 0, 'R', false);
    $pdf->Cell(20, $altoFila, $tot, 1, 0, 'R', false);
     if($row['iva']==5){
          $ttiva5=$ttiva5+ $row['t_iva5'];
     }elseif($row['iva']==10){
          $ttiva10 = $ttiva10 + $row['t_iva10'];
     }
      
    $TT=$TT+$tot;


    //Avanzar a la siguiente fila
    $margenSuperior = $margenSuperior + $altoFila;
    $i = $i + 1;
}
$totiva= $ttiva10+$ttiva5;

if ($i >= 30){
     $pdf->AddPage();
     $margenSuperior = 35;
     $pdf->SetFillColor(255, 255, 255);	//Color de las celdas
     $pdf->SetFont('Arial', 'B', 10);
     $pdf->SetY($margenSuperior);	//Margen superior
     $pdf->SetX(20);
     // $pdf->Cell(150, $altoFila, utf8_decode('TOTALES:'), 'B', 0, 'L', 1);
     // $pdf->Cell(65, $altoFila, $Tiva, 'B', 0, 'R', 1);
     // $pdf->Cell(35, $altoFila,$TT, 'B', 0, 'R', 1);

     $margenSuperior = $margenSuperior + $altoFila;
     $pdf->SetFillColor(255, 255, 255);     //Color de las celdas
     $pdf->SetFont('Arial', 'B', 10);
     $pdf->SetY($margenSuperior - 5);     //Margen superior
     $pdf->SetX(10);                         //Margen izquierdo
     $pdf->Cell(150, $altoFila, utf8_decode('TOTAL A PAGAR: '), 'LBT', 0, 'L', false);
     $pdf->Cell(35, $altoFila, $TT, 'BTR', 1, 'R');

     $margenSuperior = $margenSuperior + $altoFila;
     $pdf->SetFillColor(255, 255, 255);     //Color de las celdas
     $pdf->SetFont('Arial', 'B', 10);
     $pdf->SetY($margenSuperior - 5);     //Margen superior
     $pdf->SetX(10);                         //Margen izquierdo
     $pdf->Cell(50, $altoFila, utf8_decode('IMPORTE DEL I.V.A.:'), 'LB', 'L', false);
     $pdf->Cell(45, $altoFila, utf8_decode('(5%): ') . $ttiva5,   'B', 'C', false);
     $pdf->Cell(45, $altoFila, utf8_decode('(10%): ') . $ttiva10, 'B', 'C', false);
     $pdf->Cell(35, $altoFila, utf8_decode('Total I.V.A.: '), 'B', 'R', false);
     $pdf->Cell(10, $altoFila, $totiva, 'BR', 1, 'R');




    $pdf->SetFillColor(255, 255, 255);	//Color de las celdas
    $pdf->SetFont('Arial', 'B', 10);
    $margenSuperior = $margenSuperior + $altoFila;
    
    $pdf->SetY($margenSuperior+1);	//Margen superior
    $pdf->SetX(20);					//Margen izquierdo
     $pdf->Cell(85, $altoFila, utf8_decode('TOTAL DE REGISTROS: ').$i, 'B', 0, 'L', false);
     $margenSuperior = $margenSuperior + $altoFila;
    $pdf->SetY($margenSuperior);	//Margen superior
    $pdf->SetX(20);					//Margen izquierdo
     $pdf->Cell(85,6, utf8_decode('ARCHIVO GENERADO: ').$fecha, 'B', 0, 'L', false);
}else{
     if ($i<= 27){
          
          $margenSuperior = $margenSuperior + $altoFila;
          $pdf->SetFillColor(255, 255, 255);	//Color de las celdas
          $pdf->SetFont('Arial', 'B', 10);
          $pdf->SetY($margenSuperior - 5);	//Margen superior
          $pdf->SetX(10);					//Margen izquierdo
          $pdf->Cell(150, $altoFila, utf8_decode('TOTAL A PAGAR: '), 'LBT', 0, 'L', false);
          $pdf->Cell(35, $altoFila,$TT,'BTR',1,'R');

          $margenSuperior = $margenSuperior + $altoFila;
         $pdf->SetFillColor(255, 255, 255);	//Color de las celdas
         $pdf->SetFont('Arial', 'B', 10);
         $pdf->SetY($margenSuperior - 5);	//Margen superior
         $pdf->SetX(10);					//Margen izquierdo
          $pdf->Cell(50, $altoFila, utf8_decode('IMPORTE DEL I.V.A.:'), 'LB', 'L', false);
          $pdf->Cell(45, $altoFila, utf8_decode('(5%): ').$ttiva5,   'B', 'C', false);
          $pdf->Cell(45, $altoFila, utf8_decode('(10%): ').$ttiva10,'B', 'C', false);
          $pdf->Cell(35, $altoFila, utf8_decode('Total I.V.A.: '), 'B', 'R', false);
          $pdf->Cell(10, $altoFila, $totiva, 'BR', 1, 'R');
          
          $margenSuperior = $margenSuperior + $altoFila;
         $pdf->SetFillColor(255, 255, 255);	//Color de las celdas
         $pdf->SetFont('Arial', 'B', 10);
         $pdf->SetY($margenSuperior - 4);	//Margen superior
         $pdf->SetX(20);					//Margen izquierdo
          $pdf->Cell(85, $altoFila, utf8_decode('TOTAL DE REGISTROS: ').$r, 'B', 0, 'L', false);
          $margenSuperior = $margenSuperior + $altoFila;
         $pdf->SetY($margenSuperior - 3);	//Margen superior
         $pdf->SetX(20);					//Margen izquierdo
          $pdf->Cell(85,6, utf8_decode('ARCHIVO GENERADO: ').$fecha, 'B', 0, 'L', false);
     }else{
     //      $margenSuperior = $margenSuperior + $altoFila;
     //     $pdf->SetFillColor(255, 255, 255);	//Color de las celdas
     //     $pdf->SetFont('Arial', 'B', 10);
     //     $pdf->SetY($margenSuperior - 5);	//Margen superior
         // $pdf->SetX(20);
         //  $pdf->Cell(150, $altoFila, utf8_decode('TOTALES:'), 'B', 0, 'L', 1);
         //  $pdf->Cell(65, $altoFila, $Tiva, 'B', 0, 'R', 1);
         //  $pdf->Cell(35, $altoFila,$TT, 'B', 0, 'R', 1);
          //$margenSuperior = $margenSuperior + $altoFila;
         
          $margenSuperior = 35;
          $pdf->AddPage();
          $pdf->SetFillColor(255, 255, 255);	//Color de las celdas
          $pdf->SetFont('Arial', 'B', 10);

          $margenSuperior = $margenSuperior + $altoFila;
          $pdf->SetFillColor(255, 255, 255);     //Color de las celdas
          $pdf->SetFont('Arial', 'B', 10);
          $pdf->SetY($margenSuperior +5);     //Margen superior
          $pdf->SetX(10);                         //Margen izquierdo
          $pdf->Cell(150, $altoFila, utf8_decode('TOTAL A PAGAR: '), 'LBT', 0, 'L', false);
          $pdf->Cell(35, $altoFila, $TT, 'BTR', 1, 'R');

          // $margenSuperior = $margenSuperior + 5;
          $pdf->SetFillColor(255, 255, 255);     //Color de las celdas
          $pdf->SetFont('Arial', 'B', 10);
          $pdf->SetY($margenSuperior + 12);     //Margen superior
          $pdf->SetX(10);                         //Margen izquierdo
          $pdf->Cell(50, $altoFila, utf8_decode('IMPORTE DEL I.V.A.:'), 'LB', 'L', false);
          $pdf->Cell(45, $altoFila, utf8_decode('(5%): ') . $ttiva5,   'B', 'C', false);
          $pdf->Cell(45, $altoFila, utf8_decode('(10%): ') . $ttiva10, 'B', 'C', false);
          $pdf->Cell(35, $altoFila, utf8_decode('Total I.V.A.: '), 'B', 'R', false);
          $pdf->Cell(10, $altoFila, $totiva, 'BR', 1, 'R');


          $pdf->SetY($margenSuperior+20);	//Margen superior
          $pdf->SetX(20);					//Margen izquierdo
          $pdf->Cell(85, $altoFila, utf8_decode('TOTAL DE REGISTROS: ').$r, 'B', 0, 'L', false);

          $pdf->SetY($margenSuperior+25);	//Margen superior
          $pdf->SetX(20);					//Margen izquierdo
          $pdf->Cell(85,6, utf8_decode('ARCHIVO GENERADO: ').$fecha, 'B', 0, 'L', false);
      }
    
}

pg_close($con);

$nombreArchivo = "Factura Compra(".date('d/m/Y').").pdf";
//Crear el archivo. I: envía el fichero al navegador. La descarga sale con el nombre especificado
//================================================================================

// $pdf->Image('../img/logo.png' , 25 ,0, 35 , 25,'PNG', '');
// $pdf->Image('../img/logo.png' , 225 ,0, 35 , 25,'PNG', '');

//================================================================================
$pdf->Output('I', $nombreArchivo);
//================================================================================
//================================================================================
function cabecera(){
     //Convertir variables a GLOBAL para tener acceso a las mismas
     global $pdf, $margenSuperior, $altoFila;
     $margenIzquierdo = 10;
     //Imprimir cabecera
     $pdf->SetFillColor(215, 215, 215);
     $pdf->SetFont('Arial', 'B', 9);
     //$pdf->SetXY(150,47);
     //$pdf->Cell(25, $altoFila, utf8_decode('Valor de venta'), 1, 0, 'C', 1);
     $pdf->SetY($margenSuperior);
     $pdf->SetX($margenIzquierdo);				//Establece el margen izquierdo en milimetros
     $pdf->Cell(20, $altoFila, utf8_decode('Cantidad'), 1, 0, 'L', 1);
     $pdf->Cell(125, $altoFila, utf8_decode('Descripción'), 1, 0, 'C', 1);
     $pdf->Cell(20, $altoFila, utf8_decode('P.U.'), 1, 0, 'C', 1);
     $pdf->Cell(20, $altoFila, utf8_decode('Total'), 1, 0, 'L', 1);

}




 ?>
