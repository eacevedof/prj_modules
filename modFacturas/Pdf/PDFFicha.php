<?php include ($_SERVER['DOCUMENT_ROOT'].'/proyMODULOS/config.php'); ?>
<?php
    require_once $_RUTARAIZ.'modConexion/Clases/class.CBaseDatos.php';
    require_once $_RUTARAIZ.'modUsuarios/Clases/class.CUsuario.php';
    require_once $_RUTARAIZ.'modUtilidades/Clases/class.CUtils.php';
    require_once $_RUTARAIZ.'modClientes/Clases/class.CCliente.php';
    require_once $_RUTARAIZ.'modFacturas/Clases/class.CFactura.php';
    require_once $_RUTARAIZ.'modFacturas/Clases/class.CDetalleFactura.php';
    require_once $_RUTARAIZ.'modPDF/Clases/fpdf.php';//http://www.fpdf.org/
?>
<?php
    session_start();

    $oUsuSesion=$_SESSION['oUsuSesion'];
    if($oUsuSesion==null||!$oUsuSesion->getSesion())
    {
       $_SESSION['sWarning']="Debe iniciar sesión.";
       header('Location: ../../index.php');
       exit;
    }
    else
    {
        //Los clientes para el slect
        $oBD = new CBaseDatos();
        $bEstado=$oBD->fBoolConectar();
        //La factura, el Cliente y sus Detalles
        mysql_query("SET NAMES utf8");
        $oFactura = $_SESSION['oFactura'];
        $oFactura->pAtributosDesdeIDN($oBD);
        
        $oCliente=new CCliente($oFactura->getIdCliente(), null, null, null, null, null, null, null, null, null, null, null, null);
        $oCliente->pAtributosDesdeIDN($oBD);

        $arDetalles=CDetalleFactura::fArTabla($oFactura->getIdFactura(), $oBD);
    
        $sWarning=$_SESSION['sWarning'];
    }

    class PDF extends FPDF
    {
        //http://www.fpdf.org/
        //Cabecera de página, Titulo y Logo
        function Header()
        {
            //Arial bold 15
            $this->SetFont('Arial','B',15);
            //Logo
            $this->Image('../Images/LogoHoja.jpg',137,1,74);
            //Movernos a la derecha
            $this->Cell(1);
            //Título
            $this->Cell(10,10,'Factura nº: ',0,0,'L');
        }

        //Pie de página
        function Footer()
        {
            //Posición: a 1,5 cm del final
            $this->SetY(-15);
            //Arial italic 8
            $this->SetFont('Arial','B',8);
            //Número de página
            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        }

        function NFactura(CFactura $oFactura)
        {
            //Arial bold 15
            $this->SetFont('Arial','B',15);
            $this->Cell(20);
            //Título
            $this->Cell(10,10,$oFactura->getIdFactura(),0,0,'L');
            //Salto de línea
            $this->Ln(20);
        }

        function DatosBurban(CFactura $oFactura)
        {
            $dFechaLarga=CUtils::fFechaLarga($oFactura->getFecha());
            $sEmpresa="Burban Publicidad, S.L.";
            $sNIF="B85516573";
            $x=115;
            //Arial bold 15
            $this->SetFont('Arial','B',12);
            $this->Cell($x);
            $this->Cell(1,7,'FECHA:',20,0,'L');
            $this->Ln();
            $this->SetFont('Arial','',12);
            $this->Cell($x);
            $this->Cell(1,7,$dFechaLarga,20,0,'L');
            $this->Ln();
            $this->Cell($x);
            $this->Cell(1,6,$sEmpresa,20,0,'L');
            $this->Ln();
            $this->Cell($x);
            $this->Cell(1,6,$sNIF,20,0,'L');
            $this->Ln(20);
        }

        function Cliente(CCliente $oCliente)
        {
            $this->SetFont('Arial','BU',12);
            $this->Cell(0,7,'FACTURAR A:',0,0,'L');
            $this->Ln();
            $this->SetFont('Arial','B',12);
            $this->Cell(0,7,$oCliente->getEmpresa(),0,0,'L');
            $this->Ln();
            $this->SetFont('Arial','',12);
            $this->Cell(0,7,$oCliente->getCifnif(),0,0,'L');
            $this->Ln();
            $this->Cell(0,7,$oCliente->getDireccion(),0,0,'L');
            $this->Ln();
            $this->Cell(0,7,$oCliente->getCodigoPostal().' - '.$oCliente->getCiudad(),0,0,'L');
            $this->Ln(20);
        }
        
        function Detalles($arDetalles)
        {
            $header=array('Concepto','Cantidad');
            $this->SetFont('Arial','B',12);
            //Anchuras de las columnas
            $w=array(150,35);
            //Cabeceras
            for($i=0;$i<count($header);$i++)
            {
                $this->Cell($w[$i],7,$header[$i],1,0,'C');
            }
            $this->Ln();

            $this->SetFont('Arial','',12);
            //Datos
            foreach($arDetalles as $row)
            {
                $this->Cell($w[0],6,$row[CONCEPTO],'LR');
                $this->Cell($w[1],6,number_format($row[CANTIDAD],2,',','').' '.chr(128),'LR',0,'R');
                $this->Ln();
            }
                            
            //Línea de cierre
            $this->Cell(array_sum($w),0,'','T');
            $this->Ln();
        }

        function Totales(CFactura $oFactura)
        {
            $this->SetFont('Arial','B',12);

            $arTitulos[0]='Subtotal: ';
            $arTitulos[1]='Iva: ';
            $arTitulos[2]='Total: ';

            //Anchuras de las columnas
            $w=array(150,35);

            //Subtotal
            $this->Cell($w[0],6,$arTitulos[0],'LR',0,'R');
            $this->Cell($w[1],6,number_format($oFactura->getSubtotal(),2,',','').' '.chr(128),'LR',0,'R');
            $this->Ln();
            //Iva
            $this->Cell($w[0],6,$arTitulos[1],'LR',0,'R');
            $this->Cell($w[1],6,number_format($oFactura->getIva(),2,',','').' '.chr(128),'LR',0,'R');
            $this->Ln();
            //Total
            $this->Cell($w[0],6,$arTitulos[2],'LR',0,'R');
            $this->Cell($w[1],6,number_format($oFactura->getTotal(),2,',','').' '.chr(128),'LR',0,'R');
            $this->Ln();

            //Línea de cierre
            $this->Cell(array_sum($w),0,'','T');
        }

    }

    //Creación del objeto de la clase heredada
    $pdf=new PDF();
    $pdf->Header($oFactura);

    //Muestra numero de paginas en el pie
    $pdf->AliasNbPages();
    //Creo pagina sobre la que diburjare
    $pdf->AddPage();

    $pdf->NFactura($oFactura);
    //Creo los datos de burban
    $pdf->DatosBurban($oFactura);
    $pdf->Ln(10);
    //Creo el cliente
    $pdf->Cliente($oCliente);
    //Creo los detalles
    $pdf->Detalles($arDetalles);
    //Creo los totales
    $pdf->Totales($oFactura);

    $pdf->Output();
?>