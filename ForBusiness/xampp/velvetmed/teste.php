<?php
include("db.php");
include("db2.php");

require('phpmailer51/class.phpmailer.php');
require('pdfcreator/fpdf.php');

	class PDF extends FPDF
	{
		public $dados;
		public $current_obrano;
		public $current_bostamp;
		public $filePath;
		
		function Header()
		{
			$header = array(utf8_decode('Código'), utf8_decode('Designação'), 'Qtd', utf8_decode('PVF'), utf8_decode('Desc.'), utf8_decode('P. Unit.'), 'IVA', 'Total', 'PVP Rec.' );
			$w = array(18, 69, 15, 15, 15, 15, 15, 15, 15, 8);
			$al = array('L', 'L', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R');

			$this->SetFont('Arial','B',14);
			$this->Ln(10);
			$this->Cell(80,10,utf8_decode('Encomenda de Cliente    Nº ') . 1,0,0,'C');
			$this->Line(10, 28, 90, 28);
			$this->Ln(8);
			$this->SetFont('Arial','',7);
			$this->Cell(100,10,'ORIGINAL',0,0,'C');
			$this->Image('./img/logo.png',135,6,50);
			$this->Ln(8);
			$this->SetFont('Arial','B',9);
			$this->Cell(80,10,'VELVET MED - HEALTHCARE SOLUTIONS, S.A.',0,0,'C');
			$this->Ln(8);
			$this->SetFont('Arial','',6);
			$this->Cell(3);
			$this->Cell(80,10,'NIB: 0010 0000 49665130001 59',0,0,'L');
			$this->Ln(5);
			$this->Cell(3);
			$this->Cell(80,10,'IBAN: PT50 0010 0000 4966 5130 0015 9',0,0,'L');
			$this->Ln(5);
			$this->Cell(3);
			$this->Cell(80,10,'SWIFT / BIC: BBPIPTPL',0,0,'l');

			$this->SetFont('Arial','B',9);
			$this->Cell(20);
			$this->Cell(80,10,"aaa",0,0,'l');
			$this->SetFont('Arial','',7);
			$this->Ln(5);
			$this->Cell(3);
			$this->Cell(100,10,utf8_decode('No descritivo da transferência, coloque sempre,'));
			$this->SetFont('Arial','',9);
			$this->Cell(80,10,"aaa",0,0,'l');
			$this->Ln(5);
			$this->Cell(3);
			$this->SetFont('Arial','',7);
			$this->Cell(100,10,utf8_decode('por favor, o número desta Nota de Encomenda'));
			$this->SetFont('Arial','',9);
			$this->Cell(80,10,"aaa",0,0,'l');
			$this->Ln(5);
			$this->Cell(103);
			$this->Cell(80,10,"aaa",0,0,'l');

			$this->Ln(10);
			$this->Line(10, 85, 199, 85);
			$this->SetFont('Arial','',8);
			$this->Ln(5);
			$this->Cell(5);
			$this->Cell(40,10,'Data: ' . date("d-m-Y"),0,0,'l');
			$this->Cell(15);
			$this->Cell(100,10,utf8_decode('Condições Pagamento: ') . "aaa",0,0,'l');
			$this->Cell(80,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'l');

			$this->Ln(8);
			
			// Column widths
			$this->SetFont('Arial','B',6);
			// Header
			for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],7,$header[$i],0,0,$al[$i]);
			$this->Ln();
		}
		
		function Footer()
		{
			$this->SetY(-80);
			$this->SetFont('Arial','',7);
			$this->MultiCell(130,5,utf8_decode('Observações: ' . trim("22222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222")),0,'L');
			$this->Cell(65,60,"",0,0,'L');
			$this->SetFont('Arial','',10);
			$x=$this->GetX();
			$y=$this->GetY();
			$this->SetXY($x+70,$y);
			$this->SetFont('Arial','',10);
			$this->Cell(60,10,'PVF Total: ' . number_format("222",2) . ' Euros',0,0,'R');
			$this->SetXY($x+70,$y+5);
			$this->Cell(60,10,'Desconto: ' . number_format("222",2) . ' Euros',0,0,'R');
			$this->SetXY($x+70,$y+10);
			$this->Cell(60,10,'Total Liquido: ' . number_format("222",2) . ' Euros',0,0,'R');
			$this->SetXY($x+70,$y+15);
			$this->Cell(60,10,'IVA: ' . number_format("222",2) . ' Euros',0,0,'R');
			$this->SetXY($x+70,$y+25);
			$this->SetFont('Arial','B',10);
			$this->Cell(60,10,'Total Documento: ' . number_format("222",2) . ' Euros',0,0,'R');
			$this->Ln(1);
			$this->Line($this->GetX(), $this->GetY(), $this->GetX()+60, $this->GetY());
			$this->Cell(10,5,'',0,0,'L');
			$this->Cell(0,5,'Assinatura cliente',0,0,'L');
			$this->Ln(10);
			$this->SetFont('Arial','',7);
			$this->Cell(0,10,'VELVET MED - HEALTHCARE | NIPC:510686516 | Capital Social:100.000,00 Euros | Conserv.Reg.Com: Benavente | CAE:46460',0,0,'C');
			$this->Ln(5);
			$this->Cell(0,10,'Estrada Nacional 118, Km 38,8 | 2130-073 Benavente, Portugal | Tel.: (+351) 23981143 | www.velvet-med.pt | geral@velvet-med.pt',0,0,'C');
			$this->Ln(5);
		}
	}

	$pdf = new PDF();
	$pdf->AliasNbPages();

	$pdf->SetTitle('Encomenda Velvet Med');
	$pdf->SetCompression(false);
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(true, '50');
	
	$pdf->SetFont('Arial','',6);
	$num_rows = 0;
	for( $w = 0; $w <= 30; $w++ ) {
		$pdf->Cell(18,6,"Ref11111111",0);
		$pdf->Cell(69,6,"Medicamento 11111111",0);
		$pdf->Cell(15,6,number_format(2, 2),0,0,'R');
		$pdf->Cell(15,6,number_format(20, 2),0,0,'R');
		$pdf->Cell(15,6,number_format(0, 2),0,0,'R');
		$pdf->Cell(15,6,number_format(20 * (1 - (0/100)), 2),0,0,'R');
		$pdf->Cell(15,6,number_format(23, 2),0,0,'R');
		$pdf->Cell(15,6,number_format(240, 2),0,0,'R');
		$pdf->Cell(15,6,number_format("10", 2),0,0,'R');
		$pdf->Cell(8,6,$pdf->Image('./img/icon_red.png',$pdf->GetX(),$pdf->GetY()+1.6, 2, 2),0,0,'R');
		$pdf->Ln();
		
		$num_rows++;
		$page_height = 279.4;
		$bottom_margin = 5;
		$space_left = $page_height - $pdf->GetY();
		$space_left -= $bottom_margin;
		$height_of_cell = ceil( $num_rows * 4 ); 
		if ( $height_of_cell >= $space_left) {
			$num_rows = 0;
			$pdf->AddPage(); // page break.
			// $pdf->Cell(100,5,'','B',2); // this creates a blank row for formatting reasons
		}
	}

	

	// $pdf->Cell(80);
	// $pdf->Ln(20);

	$cur_ano = date('y');
	
	$pdf->Output();



?>