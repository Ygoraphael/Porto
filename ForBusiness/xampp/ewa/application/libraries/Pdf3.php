<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    // Incluimos el archivo fpdf
    require("./fpd/fpdf.php");
 
    //Extendemos la clase Pdf de la clase fpdf para que herede todas sus variables y funciones
    class Pdf3 extends FPDF {
		protected $bit;
		protected $CI;
		
        public function __construct() {
			$this->CI =& get_instance();
			$this->CI->load->database();
			$this->CI->load->model('product_model');
            parent::__construct('P', 'mm', array(80,100), true, 'UTF-8', false, false);
        }
		
		public function setbostamp($bi){
			$this->bit= $bi;
		}			 

        // El encabezado del PDF
        public function Header(){
		//$response = $this->CI->product_model->get_order_bi_bystamp($this->bistamp);
		// datos ticket 
			
		$bost2 = $this->bit;
		$query = "
			select 
				enc.nome as agt,
				enc4.tam,
				enc4.serie,
				enc4.cor,
				enc4.edebito,
				op.nome,
				op.email,
				op.telefone,
				op.TLMVL,
				prod.u_name,
				prod3.U_ADDRESS,    
				prod3.U_CITY,        
				prod3.U_STATEREG,       
				prod3.U_POSTCODE,
				prod3.U_COUNTRY, 
				prod3.U_LATITUDE,      
				prod3.U_LONGITUD,     
				enc3.U_SESSDATE, 
				u_psess.ihour, 
				prod3.U_ADDINFO,
				prod3.U_IMGVOUCH, 
				prod.u_uniqcode, 
				op.u_imgop, 
				op.email 
			from bo prod 
			   inner join bo enc on prod.bostamp=enc.origem 
			   inner join bo3 enc3 on enc.bostamp=enc3.bo3stamp
			   inner join bi enc4 on enc.bostamp=enc4.bostamp
			   inner join u_psess on u_psess.u_psessstamp = enc3.u_psessstp
			   inner join bo3 prod3 on prod.bostamp=prod3.bo3stamp
			   inner join fl op on op.no = prod.no and op.estab = 0
			where enc4.bistamp='".$bost2."'";
			
		$product2 = $this->CI->mssql->mssql__select( $query );

		$this->SetY($this->GetY()+20);
		$this->SetFont('Arial','',8	);
		$x=$this->GetX();
		$y=$this->GetY();

		$date = $product2[0]['U_SESSDATE'];
		$orderdate = substr($date, 0, 10);
		
		$this->SetFont('Arial','B',8);
		$this->SetXY($x-8,$y+2);
		$this->Cell(60,10,'Date:'.$orderdate.' / Hour: '.$product2[0]['ihour'],0,0,'L');

		$this->SetXY($x-8,$y-22);
		$this->Cell(30,3,'Ticket Nє '.$product2[0]['serie'],0,0,'L');

		//$this->Image(base_url() . 'image_product/' . $product2[0]["u_imgop"],$x+35,$y-24,20,5,'PNG');
		$orderdate = substr($product2[0]['u_name'], 0, 10);
		
		$this->SetXY($x-8,$y-18);
		$this->SetFont('Arial','B',10);
		$this->MultiCell(60,3, $product2[0]['u_name'] ,0);

		if( trim($product2[0]['u_uniqcode']) != '' ) {
			$this->SetFont('Arial','',8	);
			$this->SetXY($x-8,$y-14);
			$this->Cell(10,10, 'Tour Code: ' . $product2[0]['u_uniqcode'],0,0,'L');
		}

		$this->SetFont('Arial','B',8);
		$this->SetXY($x-8,$y-10);
		$this->Cell(60,10,'Operator by:',0,0,'L');
	
		$this->SetFont('Arial','',8	);
		$this->SetXY($x-8,$y-2);
		$this->MultiCell(60,3,$product2[0]['nome'].': '.$product2[0]['U_CITY'].' '.$product2[0]['U_COUNTRY'].' '.$product2[0]['U_ADDRESS'].'/ '.$product2[0]['U_CITY'],0);

		$this->SetFont('Arial','B',10);
		$this->SetXY($x-8,$y+4);
		$this->Cell(65,20,'Name: '.$product2[0]['agt'] ,0,0,'L');
	
		if(trim($product2[0]['cor']) !="ND" && trim($product2[0]['cor']) !="" ){
			$this->SetFont('Arial','B',10);
			$this->SetXY($x-4,$y+22);
			$this->Cell(60,10,'Seat: '.$product2[0]['cor'],0,0,'L');
		}

		$this->SetFont('Arial','B',10);
		$this->SetXY($x-8,$y+18);
		$this->Cell(60,10,'Type: '.$product2[0]['tam'],0,0,'L'); 
		
		$pr=$product2[0]['edebito'];
		$pr2 = number_format($pr, 2, '.', '');
		
		$this->SetFont('Arial','',10);
		$this->SetXY($x+25,$y+18);
		$this->Cell(60,10,'Price:'. $pr2.' Ђ',0,0,'L');

		$this->SetTextColor(120,121,121);
		$this->SetFont('Arial','',4);
		$this->SetXY($x,$y+30);
		$this->Rotate(-90);
		$this->MultiCell(20,2,'This code allows entry into the event. Please make sure it prints well!!',0,'C');
		$this->Rotate(0);
		$qr = $product2[0]['serie'];
		$this->Image('https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='.$qr.'&choe=UTF-8',$x+1,$y+30,18,18,'PNG');

		$this->SetTextColor(120,121,121);
		$this->SetFont('Arial','',8);
		$this->SetXY($x+18,$y+30);
		$this->Cell(60,10,'Name / Emergency Contact',0,0,'L');
		
		$this->SetTextColor(0,0,0);
		$this->SetFont('Arial','',8);
		$this->SetXY($x+18,$y+34);
		$this->Cell(60,10,$product2[0]['nome'],0,0,'L');
		
		$this->SetTextColor(0,0,0);
		$this->SetFont('Arial','',8);
		$this->SetXY($x+18,$y+38);
		$this->Cell(60,10,$product2[0]['email'],0,0,'L');
	
		$this->SetTextColor(0,0,0);
		$this->SetFont('Arial','',8);
		$this->SetXY($x+18,$y+40);
		$this->Cell(60,10,$product2[0]['TLMVL'],0,0,'L');
		//$this->Image('logo_ewa.png',$x,$y+170,25);
		
		$this->SetTextColor(120,121,121);
		$this->SetFont('Arial','',4);
		$this->SetXY($x-10,$y+52);
		$this->MultiCell(80,3,'NOTA: Trate este bilhete com cuidado. A duplicaзгo, alteraзгo, ou venda deste bilhete pode comprometer a sua entrada no evento. Apresente este bilhete na entrada para ser validado. O cуdigo de barras e outros sistemas de proteзгo irгo garantir a detecзгo de duplicaзгo de bilhetes. Pode alterar o nome do seu bilhete acedendo а sua conta pessoal, apуs login em www.europeanworld.eu',0);
       }
	   
	// El pie del pdf
	public function Footer(){
	}

	var $angle=0;
	function Rotate($angle,$x=-1,$y=-1)
	{
		if($x==-1)
			$x=$this->x;
		if($y==-1)
			$y=$this->y;
		if($this->angle!=0)
			$this->_out('Q');
		$this->angle=$angle;
		
		if($angle!=0)
		{
			$angle*=M_PI/180;
			$c=cos($angle);
			$s=sin($angle);
			$cx=$x*$this->k;
			$cy=($this->h-$y)*$this->k;
			$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
		}
	}
}
?>