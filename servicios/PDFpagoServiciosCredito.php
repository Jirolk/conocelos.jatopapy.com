
<?php
require_once("conexion.php");
//require("../fpdf/fpdf.php");
require("../fpdf/rotation.php");
session_start();
class PDF extends PDF_Rotate{
     function Header(){
          //Funcion para la cabecera de pagina, es automaticamente invocado por AddPage() y Close()
          //CONSULTA
          $con = conexion($_SESSION["nombreUsuario"], $_SESSION["pass"]);
          $id = $_GET["fac"];
          $rec = $_GET["rec"];
          $stot = $_GET["stot"];
          $inter = $_GET["int"];
          $tot = $stot+$inter;
          $array = explode(",", $_GET['detalle']);   //Convertir el String a Array. El String contiene el Detalle
          $canti = count($array); //Cantidad de elementos del array
          $artic = $canti / 5;
          $pos =0;
          //global $des;
          for($i=1; $i<=$artic; $i++){
               $det = $array[$pos];
               $pos = $pos +1 ;
               $idcompra = $array[$pos];
               $pos = $pos +1 ;
               $num = $array[$pos];
               $pos = $pos +1 ;
               $fecha = $array[$pos];
               $pos = $pos +1 ;
               $pos = $pos +1 ;
               $sql="select num_cuota from pago_detalle where idpagodet='$det'";
               $resul = pg_query($con, $sql);
               $reg = pg_fetch_array($resul);
               $nro = $reg['num_cuota'];
               //$des = "En concepto de pago de Factura Nro. ".$id." - Cuota Nro. - ".$num;
          }
          $sql = "SELECT idpago FROM pago_detalle WHERE idpagodet = '$det'";
          $resul = pg_query($con, $sql);
          $reg = pg_fetch_array($resul);
          $idpago = $reg['idpago'];
         $sql="select max(num_cuota) num from pago_detalle where idpago='$idpago'";
         $resul = pg_query($con, $sql);
          $reg = pg_fetch_array($resul);
           $max = $reg['num'];
           ///
           
          /////
          $sql = "SELECT c.*, r.Razon_social,r.direccion, r.telefono, r.contacto, u.rol, f.razon_social Empleado FROM compra_cab c
          INNER JOIN proveedores r ON c.Ruc=r.Ruc
          LEFT JOIN usuario u ON u.idusuario=c.idusuario
          LEFT JOIN funcionarios f ON f.ci_funcionario=u.ci_funcionario
          WHERE c.idcompra =  '$idcompra'";
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
          $this->Cell(80, 6, utf8_decode(''),'TLR',2,'C');
          $this->SetFont('Arial','B', 12);
          $this->SetXY(115,12);
          $this->Cell(80, 6, utf8_decode('R.U.C.: '.$row['ruc']),'LR',2,'C');
          $this->SetXY(115,17);
          $this->Cell(80, 6, utf8_decode('RECIBO DE DINERO'),'LR',2,'C');
          $this->SetFont('Arial','B', 10);
          $this->SetXY(115,22);
          $this->Cell(80, 6, utf8_decode('N° '. $rec),'LRB',2,'C');

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
          $this->SetFont('Arial','' ,8);
          $this->SetXY($margenIzquierdo,47);
          $this->Cell(185, 7,utf8_decode('Recibimos de : María Deolinda Delgado de Recalde'),'',2,'L');
          $this->SetXY(80,47);
          $this->Cell(185, 7,utf8_decode('la cantidad de: Gs. '.$tot),'',2,'L');

          $this->SetFont('Arial','B',50);
          $this->SetTextColor(255,192,203);
          $this->RotatedText(80,105,'Pagado',35);
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
$margenSuperior = 54;
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
/*$sql = "SELECT d.*,i.descripcion,i.Iva,c.t_iva5,c.t_iva10 FROM compra_det d
INNER JOIN insumos i ON i.idinsumo=d.idinsumo
inner join compra_cab c on c.idcompra=d.idcompra
WHERE nro_factura = '$id'";
$result= pg_query($con,$sql);
$ttiva5 = 0;
$ttiva10 = 0;
$totiva =0;*/
$TT=0;
$des = "";
$tot = 0;
//while($row = pg_fetch_array($result)){
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
    $pdf->SetFillColor(255, 255, 255);	//Color de las celdas
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetY($margenSuperior);	//Margen superior
    $pdf->SetX(10);					//Margen izquierdo
    //global $des;
    
    $stot = $_GET["stot"];
    $inter = $_GET["int"];
    $TT = $stot+$inter;
    $array = explode(",", $_GET['detalle']);   //Convertir el String a Array. El String contiene el Detalle
     $canti = count($array); //Cantidad de elementos del array
     $artic = $canti / 5;
     $pos =0;
     for($i=1; $i<=$artic; $i++){
          $det = $array[$pos];
          $pos = $pos +1 ;
          $idcompra = $array[$pos];
          $pos = $pos +1 ;
          $num = $array[$pos];
          $pos = $pos +1 ;
          $fecha = $array[$pos];
          $pos = $pos +1 ;
          $monto = $array[$pos];
          $pos = $pos +1 ;
          $sql="select num_cuota from pago_detalle where idpagodet='$det'";
          $resul = pg_query($con, $sql);
          $reg = pg_fetch_array($resul);
          $nro = $reg['num_cuota'];
          $des = "En concepto de pago de Factura Nro. ".$id." - Cuota Nro. - ".$num;
          $pdf->SetY($margenSuperior);	//Margen superior
          $pdf->SetX(10);
          $pdf->Cell(135, $altoFila, $des, 1, 0, 'L', false);
          $pdf->Cell(25, $altoFila, $fecha, 1, 0, 'R', false);
          $pdf->Cell(25, $altoFila, $monto, 1, 0, 'R', false);
          $margenSuperior = $margenSuperior + $altoFila;
          
     }
    
//}
     $margenSuperior = $margenSuperior + $altoFila;
     $pdf->SetFillColor(255, 255, 255);	//Color de las celdas
     $pdf->SetFont('Arial', 'B', 10);
     $pdf->SetY($margenSuperior - 5);	//Margen superior
     $pdf->SetX(10);	
     $pdf->Cell(150, $altoFila, utf8_decode('SUBTOTAL: '), 'LBT', 0, 'L', false);
     $pdf->Cell(35, $altoFila,$stot,'BTR',1,'R');
     $pdf->SetX(10);	
     $pdf->Cell(150, $altoFila, utf8_decode('INTERÉS: '), 'LBT', 0, 'L', false);
     $pdf->Cell(35, $altoFila,$inter,'BTR',1,'R');
     $pdf->SetX(10);					//Margen izquierdo
     $pdf->Cell(150, $altoFila, utf8_decode('TOTAL A PAGAR: '), 'LBT', 0, 'L', false);
     $pdf->Cell(35, $altoFila,$TT,'BTR',1,'R');
     $i--;
     $margenSuperior = $margenSuperior + $altoFila;
     $pdf->SetFillColor(255, 255, 255);	//Color de las celdas
     $pdf->SetFont('Arial', 'B', 10);
     $pdf->SetY($margenSuperior +10);	//Margen superior
     $pdf->SetX(10);					//Margen izquierdo
     $pdf->Cell(85, $altoFila, utf8_decode('TOTAL DE REGISTROS: ').$i, 'B', 0, 'L', false);
     $margenSuperior = $margenSuperior + $altoFila;
     $pdf->SetY($margenSuperior +12);	//Margen superior
     $pdf->SetX(10);					//Margen izquierdo
     $pdf->Cell(85,6, utf8_decode('ARCHIVO GENERADO: ').$fecha, 'B', 0, 'L', false);


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
     //$pdf->Cell(20, $altoFila, utf8_decode('Cantidad'), 1, 0, 'L', 1);
     $pdf->Cell(135, $altoFila, utf8_decode('Concepto'), 1, 0, 'C', 1);
     //$pdf->Cell(20, $altoFila, utf8_decode('P.U.'), 1, 0, 'C', 1);
     $pdf->Cell(25, $altoFila, utf8_decode('Fecha de Venc.'), 1, 0, 'C', 1);
     $pdf->Cell(25, $altoFila, utf8_decode('Importe'), 1, 0, 'C', 1);

}




 ?>
