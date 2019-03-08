<?php

function encode_em_utf8($obj) {
	foreach ($obj as $key=>&$value) {
		if(is_string($value))
			$value = utf8_encode($value);
	}
}

class Orcamento {

	var $id;
	var $nome;
	var $no;
	var $estado;
	var $etotaldeb;
	var $eiva;
	var $edesc;
	var $etotal;
	var $Itens = array();

}

class Orcamento_Item {

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
	
}

$orc = New Orcamento();
$orc->id = '1';
$orc->nome = 'Conceiзгo Antуnio Mбrio Papoila';
$orc->no = '1';
$orc->estado = 'Em Preparaзгo';
$orc->etotaldeb = '0';
$orc->eiva = '23';
$orc->edesc = '0';
$orc->etotal = '9.5';

$orc_it1 = New Orcamento_Item();
$orc_it1->id = '1';
$orc_it1->ref = '21';
$orc_it1->design = 'designaзгo1';
$orc_it1->qtt = '10';
$orc_it1->edebito = '5.5';
$orc_it1->desconto = '0';
$orc_it1->ettdeb = '0';
$orc_it1->iva = '23';
$orc_it1->ivaincl = '0';
$orc_it1->etotal = '5.5';
$orc_it1->tamanho = 'S';

$orc_it2 = New Orcamento_Item();
$orc_it2->id = '2';
$orc_it2->ref = '22';
$orc_it2->design = 'designaзгo2';
$orc_it2->qtt = '10';
$orc_it2->edebito = '4';
$orc_it2->desconto = '0';
$orc_it2->ettdeb = '0';
$orc_it2->iva = '23';
$orc_it2->ivaincl = '0';
$orc_it2->etotal = '4';
$orc_it2->tamanho = 'M';

encode_em_utf8($orc);
encode_em_utf8($orc_it1);
encode_em_utf8($orc_it2);
$orc->Itens[] = $orc_it1;
$orc->Itens[] = $orc_it2;

$result[] = $orc;

echo json_encode($result);


?>