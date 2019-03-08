<?php

function encode_em_utf8($obj) {
	foreach ($obj as $key=>&$value) {
		if(is_string($value))
			$value = utf8_encode($value);
	}
}

class Inscricao {

	var $id;
	var $nome;
	var $no;
	var $morada;
	var $codpost;
	var $local;
	var $email;
	var $telefone;
	var $ncont;
	var $evento;
	var $etotaldeb;
	var $edescc;
	var $etotal;
	var $cod_iva;
	
	var $Itens = array();

}

class Inscricao_Item {

	var $id;
	var $ref;
	var $design;
	var $qtt;
	var $edebito;
	var $desconto;
	var $ettdeb;
	var $iva;
	var $ivaincl;
	var $etotal;
	var $tamanho;
	var $cor;
	var $cod_projecto;
	var $desc_proj;
	
}

//para obter a key e verificar se estб certa
//$key = "3?9P2JP5Dw#8]da";
$headers = apache_request_headers();
//$headers["Authorization"];

$f = fopen("tiago.txt", "a");
fwrite($f, print_r($headers, true));
fclose($f);

if( isset( $_POST['task'] )) {
	$task = $_POST['task'];
	
	//para enviar todas as inscricoes que nao estejam marcadas como enviado
	if( $task == "getinsc" ) {
		$orc = New Inscricao();
		$orc->id = '1';
		$orc->nome = 'Conceiзгo Antуnio Mбrio Papoila';
		$orc->no = '2563'; //este nъmero de cliente й para consumidor final
		$orc->morada = 'Rua das Travessas';
		$orc->codpost = '4400-150';
		$orc->local = 'Guimarгes';
		$orc->telefone = '222222222';
		$orc->ncont = '123456789';
		$orc->evento = 'Sйrie Corrida Alucinante';
		$orc->etotaldeb = '25.01';
		$orc->edescc = '4.5';
		$orc->etotal = '30.01';
		$orc->cod_iva = '2';

		$orc_it1 = New Inscricao_Item();
		$orc_it1->id = '1';
		$orc_it1->ref = '21';
		$orc_it1->design = 'designaзгo1';
		$orc_it1->qtt = 10.0;
		$orc_it1->edebito = 5.5;
		$orc_it1->desconto = 0;
		if($orc_it1->desconto) 
			$orc_it1->ettdeb = $orc_it1->qtt * ($orc_it1->edebito*(1-($orc_it1->desconto/100)));
		else 
			$orc_it1->ettdeb = $orc_it1->qtt * $orc_it1->edebito;
		$orc_it1->iva = 23;
		$orc_it1->ivaincl = 0;
		$orc_it1->etotal = 5.5;
		$orc_it1->tamanho = 'S';
		$orc_it1->cor = 'Azul';
		$orc_it1->cod_projecto = '1';
		$orc_it1->desc_proj = 'Corrida Alucinante III';

		$orc_it2 = New Inscricao_Item();
		$orc_it2->id = '2';
		$orc_it2->ref = '22';
		$orc_it2->design = 'designaзгo2';
		$orc_it2->qtt = 1.0;
		$orc_it2->edebito = 5.0;
		$orc_it2->desconto = 10;
		if($orc_it2->desconto) 
			$orc_it2->ettdeb = $orc_it2->qtt * ($orc_it2->edebito*(1-($orc_it2->desconto/100)));
		else 
			$orc_it2->ettdeb = $orc_it2->qtt * $orc_it2->edebito;
		$orc_it2->iva = 23;
		$orc_it2->ivaincl = 0;
		$orc_it2->etotal = 4;
		$orc_it2->tamanho = 'M';
		$orc_it2->cor = 'Vermelho';
		$orc_it2->cod_projecto = '1';
		$orc_it2->desc_proj = 'Corrida Alucinante IV';

		encode_em_utf8($orc);
		encode_em_utf8($orc_it1);
		encode_em_utf8($orc_it2);
		$orc->Itens[] = $orc_it1;
		$orc->Itens[] = $orc_it2;

		$result[] = $orc;

		echo json_encode($result);
	}
	//para ir buscar o array com todos os ids das inscricoes gravadas com sucesso
	if( $task == "setinsc" ) {
		if( isset( $_POST['data'] )) {
			$data = json_decode( stripcslashes( $_POST['data'] ) );
		}
	}
}



?>