
<?php
require_once("conexion.php");
require("../fpdf/fpdf.php");
session_start();
class PDF extends FPDF{
     function Header(){
          //Funcion para la cabecera de pagina, es automaticamente invocado por AddPage() y Close()
          //datos de la empresa
          $margenIzquierdo = 20;
          $this->SetFont('Arial','B', 15);
          $this->SetXY($margenIzquierdo,10);
          $this->Cell(100, 6, utf8_decode('DEOCREACIONES'),'TLR',2,'C');
          $this->SetFont('Arial','B', 8);
          $this->SetXY($margenIzquierdo,15);
          $this->Cell(100, 4, utf8_decode('de María Deolinda Delgado de Recalde'),'LR',2,'C');
          $this->SetXY($margenIzquierdo,18);
          $this->Cell(100, 4, utf8_decode('PINTURA ACRÍLICA - AL OLEO - VITRAL - ACUALERA'),'LR',2,'C');
          $this->SetXY($margenIzquierdo,21);
          $this->Cell(100, 4, utf8_decode('SOBRE TELA - MADERA - VIDRIO - CUERINA'),'LR',2,'C');
          $this->SetXY($margenIzquierdo,24);
          $this->Cell(100, 4, utf8_decode('Tte. Cabrera c/ Don Bosco y Sarmiento'),'LR',2,'C');
          $this->SetXY($margenIzquierdo,27);
          $this->Cell(100, 4, utf8_decode('Tel.: (0331) 240 667 / (0972) 893 180'),'LR',2,'C');
          $this->SetXY($margenIzquierdo,30);
          $this->Cell(100, 4, utf8_decode('Concepción - Paraguay'),'LRB',2,'C');
          $this->SetX($margenIzquierdo);
          $this->SetFont('Arial','B', 18);
          $this->Cell(170, 7,'FACTURA - COMPRA','B',2,'C');
          //$this->Image('../img/logoDeo2.png' , 15 ,10, 35 , 25,'PNG', '');
          // $pdf->Image('../img/logo2.png' , 25 ,0, 35 , 25,'PNG', '');
          // $pdf->Image('../img/logo2.png' , 225 ,0, 35 , 25,'PNG', '');
          

          //TIMBRADO
          $this->SetFont('Arial','B', 11);
          $this->SetXY(122,10);
          $this->Cell(68, 6, utf8_decode('TIMBRADO N° 11574943'),'TLR',2,'C');

          $con = conexion($_SESSION["nombreUsuario"], $_SESSION["pass"]);
          $id = $_GET["fac"];
          $sql = "SELECT c.*, r.Razon_social, u.rol, f.razon_social Empleado FROM compra_cab c
          INNER JOIN proveedores r ON c.Ruc=r.Ruc
          LEFT JOIN usuario u ON u.idusuario=c.idusuario
          LEFT JOIN funcionarios f ON f.ci_funcionario=u.ci_funcionario
          WHERE c.nro_factura =  '$id'";
         $result = pg_query($con, $sql);
         $row = pg_fetch_array($result);
          ////var
          $raz = utf8_decode($row['razon_social']);
          $cond = utf8_decode($row['condicion']);
          $fec = date_create(utf8_decode($row['fecha']));
          $com = date_format($fec,"d/m/Y");
          $ruc = $row['ruc'];
          $tot = $row['total'];
          $ttiva5 = $row['t_iva5'];
          $ttiva10 = $row['t_iva10'];
          if($ttiva5 == "" && $ttiva10 ==""){
            $ttiva=0;
          }
          $sql=" SELECT total_efectivo, total_cheque, total_tarjeta FROM cobro_efectivo ce
    inner join compra_cab c on c.idcompra=ce.idcompra
WHERE nro_factura='$id'";
          $result = pg_query($con, $sql);
          $row = pg_fetch_array($result);
          $efe = $row['total_efectivo'];
          $che = $row['total_cheque'];
          $tar = $row['total_tarjeta'];//te quedaste aca tenes qe armar la factura
          if($che== ""){
            $che=0;
          }
          if($tar== ""){
            $tar=0;
          }
          $vuel=($efe+$che+$tar)-$tot;
          $entrega=$efe+$che+$tar;
          $this->SetFont('Arial','B', 10);
          $this->SetX($margenIzquierdo);
          $this->Cell(25, 20,  utf8_decode("Ruc:"),0,0,'D');
          $this->Cell(145, 20, $ruc,0,1,'R');

          $this->SetFont('Arial','B', 10);
          $this->SetX($margenIzquierdo);
          $this->Cell(25, 0, utf8_decode("Razón Social:"),0,0,'D');
          $this->Cell(145, 0, $raz,0,0,'R');

          $this->SetFont('Arial','B', 10);
          $this->SetX($margenIzquierdo);
          $this->Cell(25,20, utf8_decode("Condición:"),0,0,'D');
          $this->Cell(145, 20, $cond,0,1,'R');

          // $this->SetFont('Arial','B', 10);
          // $this->SetX($margenIzquierdo);
          // $this->Cell(25, 0,  utf8_decode("Habitación N°:"),0,0,'D');
          // $this->Cell(5, 0,$row['Num_habit'],0,0,'R');

          $this->SetFont('Arial','B', 10);
          $this->SetX($margenIzquierdo);
          $this->Cell(25,0, utf8_decode("Fecha de Compra:"),0,0,'D');
          $this->Cell(145, 0, $com,0,0,'R');

          $this->SetFont('Arial','B', 10);
          $this->SetX($margenIzquierdo);
          $this->Cell(25, 20, utf8_decode("Total:"),0,0,'D');
          $this->Cell(145, 20,$tot,0,1,'R');

          $this->SetFont('Arial','B', 10);
          $this->SetX($margenIzquierdo);
          $this->Cell(25,0, utf8_decode("Total Iva 5%:"),0,0,'D');
          $this->Cell(145, 0, $ttiva5,0,0,'R');

          $this->SetFont('Arial','B', 10);
          $this->SetX($margenIzquierdo);
          $this->Cell(25,20, utf8_decode("Total Iva 10%:"),0,0,'D');
          $this->Cell(145, 20, $ttiva10,0,1,'R');

          // $this->SetFont('Arial','B', 10);
          // $this->SetX($margenIzquierdo);
          // $this->Cell(25, 20, utf8_decode("Entrega:"),0,0,'D');
          // $this->Cell(145, 0,$entrega,0,1,'R');

          $this->SetFont('Arial','B', 10);
          $this->SetX($margenIzquierdo);
          $this->Cell(25, 0, utf8_decode("Vuelto:"),0,0,'D');
          $this->Cell(145, 0,$vuel,0,0,'R');

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
$margenSuperior = 125;

//Establece alto de fila
$altoFila = 7;

cabecera();

$margenSuperior = $margenSuperior + $altoFila;
//Contador de registros (filas)
$i = 0;
$r = 0;	//Para obtener el total de registros

//Cantidad de registros por pagina
$max = 20;		//39 es la cantidad de filas q cabe en la hoja A4

date_default_timezone_set('America/Asuncion');
$fecha = (date("d/m/Y H:i:s"));
$con = conexion($_SESSION["nombreUsuario"], $_SESSION["pass"]);  
$id = $_GET["fac"];
$sql = "SELECT d.*,i.descripcion,i.Iva FROM compra_det d
INNER JOIN insumos i ON i.idinsumo=d.idinsumo
inner join compra_cab c on c.idcompra=d.idcompra
WHERE nro_factura = '$id'";
$result= pg_query($con,$sql);
while($row = pg_fetch_array($result)){
     $r = $r+1;
    //Agregar pagina si llegamos al limite de registros por pagina
    if ($i == $max){
        $pdf->AddPage();		//Agrega nueva pagina
        $margenSuperior = 35;	//Estable margen superior de la nueva pagina

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
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetY($margenSuperior);	//Margen superior
    $pdf->SetX(20);					//Margen izquierdo
    //Imprimir los campos
    $pdf->Cell(95, $altoFila, $des, 1, 0, 'L', 1);
    $pdf->Cell(25, $altoFila, $can, 1, 0, 'R', 1);
    $pdf->Cell(25, $altoFila, $pre, 1, 0, 'R', 1);
    $pdf->Cell(25, $altoFila, $tot, 1, 0, 'R', 1);

    //Avanzar a la siguiente fila
    $margenSuperior = $margenSuperior + $altoFila;
    $i = $i + 1;
}
if ($i >= 20){
     $pdf->AddPage();
      $margenSuperior = 35;
    $pdf->SetFillColor(255, 255, 255);	//Color de las celdas
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetY($margenSuperior);	//Margen superior
    $pdf->SetX(20);
     // $pdf->Cell(150, $altoFila, utf8_decode('TOTALES:'), 'B', 0, 'L', 1);
     // $pdf->Cell(65, $altoFila, $Tiva, 'B', 0, 'R', 1);
     // $pdf->Cell(35, $altoFila,$TT, 'B', 0, 'R', 1);
    $pdf->SetFillColor(255, 255, 255);	//Color de las celdas
    $pdf->SetFont('Arial', 'B', 10);
    $margenSuperior = $margenSuperior + $altoFila;
    $pdf->SetY($margenSuperior+1);	//Margen superior
    $pdf->SetX(20);					//Margen izquierdo
     $pdf->Cell(85, $altoFila, utf8_decode('TOTAL DE REGISTROS: ').$i, 'B', 0, 'L', 1);
     $margenSuperior = $margenSuperior + $altoFila;
    $pdf->SetY($margenSuperior);	//Margen superior
    $pdf->SetX(20);					//Margen izquierdo
     $pdf->Cell(85,6, utf8_decode('ARCHIVO GENERADO: ').$fecha, 'B', 0, 'L', 1);
}else{
     if ($i<= 17){
          $margenSuperior = $margenSuperior + $altoFila;
         $pdf->SetFillColor(255, 255, 255);	//Color de las celdas
         $pdf->SetFont('Arial', 'B', 10);
         $pdf->SetY($margenSuperior - 5);	//Margen superior
         $pdf->SetX(20);					//Margen izquierdo
          // $pdf->Cell(150, $altoFila, utf8_decode('TOTALES:'), 'B', 0, 'L', 1);
          // $pdf->Cell(65, $altoFila, $Tiva, 'B', 0, 'R', 1);
          // $pdf->Cell(35, $altoFila,$TT, 'B', 0, 'R', 1);
          $margenSuperior = $margenSuperior + $altoFila;
         $pdf->SetFillColor(255, 255, 255);	//Color de las celdas
         $pdf->SetFont('Arial', 'B', 10);
         $pdf->SetY($margenSuperior - 5);	//Margen superior
         $pdf->SetX(20);					//Margen izquierdo
          $pdf->Cell(85, $altoFila, utf8_decode('TOTAL DE REGISTROS: ').$r, 'B', 0, 'L', 1);
          $margenSuperior = $margenSuperior + $altoFila;
         $pdf->SetY($margenSuperior - 4);	//Margen superior
         $pdf->SetX(20);					//Margen izquierdo
          $pdf->Cell(85,6, utf8_decode('ARCHIVO GENERADO: ').$fecha, 'B', 0, 'L', 1);
     }else{
          $margenSuperior = $margenSuperior + $altoFila;
         $pdf->SetFillColor(255, 255, 255);	//Color de las celdas
         $pdf->SetFont('Arial', 'B', 10);
         $pdf->SetY($margenSuperior - 5);	//Margen superior
         // $pdf->SetX(20);
         //  $pdf->Cell(150, $altoFila, utf8_decode('TOTALES:'), 'B', 0, 'L', 1);
         //  $pdf->Cell(65, $altoFila, $Tiva, 'B', 0, 'R', 1);
         //  $pdf->Cell(35, $altoFila,$TT, 'B', 0, 'R', 1);
          //$margenSuperior = $margenSuperior + $altoFila;
          $margenSuperior = 35;
          $pdf->AddPage();
         $pdf->SetFillColor(255, 255, 255);	//Color de las celdas
         $pdf->SetFont('Arial', 'B', 10);
         $pdf->SetY($margenSuperior);	//Margen superior
         $pdf->SetX(20);					//Margen izquierdo
          $pdf->Cell(85, $altoFila, utf8_decode('TOTAL DE REGISTROS: ').$r, 'B', 0, 'L', 1);

         $pdf->SetY($margenSuperior+5);	//Margen superior
         $pdf->SetX(20);					//Margen izquierdo
          $pdf->Cell(85,6, utf8_decode('ARCHIVO GENERADO: ').$fecha, 'B', 0, 'L', 1);
      }
}
pg_close($con);

$nombreArchivo = "Factura Estadia(".date('d/m/Y').").pdf";
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
     $margenIzquierdo = 20;
     //Imprimir cabecera
     $pdf->SetFillColor(215, 215, 215);
     $pdf->SetFont('Arial', 'B', 10);
     $pdf->SetY($margenSuperior);
     $pdf->SetX($margenIzquierdo);				//Establece el margen izquierdo en milimetros
     $pdf->Cell(95, $altoFila, utf8_decode('DESCRIPCIÓN'), 1, 0, 'L', 1);
     $pdf->Cell(25, $altoFila, utf8_decode('CANTIDAD'), 1, 0, 'L', 1);
     $pdf->Cell(25, $altoFila, utf8_decode('PRECIO'), 1, 0, 'L', 1);
     $pdf->Cell(25, $altoFila, utf8_decode('TOTAL'), 1, 0, 'L', 1);
}




 ?>
