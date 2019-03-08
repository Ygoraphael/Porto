<?php

function get_tecnicos() {
	$sql = "
		SELECT *
		FROM cm4 (nolock) 
		where inactivo = 0
		order by cmdesc";
	$data = mssql__select($sql);
	
	return $data;	
}

function get_intervencao($mhstamp) {
	$sql = "
		SELECT *,
		(select top 1 nmfref from fref (nolock) where fref = mh.fref) nmfref
		FROM mh (nolock) WHERE mhstamp = '" . $mhstamp . "'";
	$data = mssql__select($sql);
	
	return $data;	
}

function get_campos_tabela($tabela) {
	$str_sql = "
		select distinct rtrim(ltrim(titulo)) titulo, convert(varchar(254), nomecampo) nomecampo
		from dic
		where tabela = '$tabela'
		order by rtrim(ltrim(titulo))
	";

	$data1 = mssql__select($str_sql);
	
	$str_sql = "
		select ltrim(rtrim(titulo)) titulo, 'u_' + nomecampo 
		from campos
		where tabela = '$tabela'
		order by ltrim(rtrim(titulo))
	";

	$data2 = mssql__select($str_sql);
	
	return array_merge($data1,$data2);
}

function get_tempo_inter_ano_contrato($no) {
	$str_sql = "
		select
			convert(varchar(4), year(data)) + right(convert(varchar(4), month(data)+100), 2) datap,
			moh
		from 
			mh
		where
			no = $no and u_cat = 1 and data >= DATEADD(YEAR, -1, getdate())
		order by data
	";

	$data = mssql__select($str_sql);
	return $data;
}

function get_num_inter_ano_contrato($no) {
	$str_sql = "
		select
			convert(varchar(4), year(data)) + right(convert(varchar(4), month(data)+100), 2) data,
			count(convert(varchar(4), year(data)) + right(convert(varchar(4), month(data)+100), 2)) num_inter
		from 
			mh
		where
			no = $no and u_cat = 1 and data >= DATEADD(YEAR, -1, getdate())
		group by
			convert(varchar(4), year(data)) + right(convert(varchar(4), month(data)+100), 2)
	";

	$data = mssql__select($str_sql);
	return $data;
}

function get_custo_total_funcionarios_projeto($frefstamp) {
	$str_sql = "
		select 
			sum(moh*ecusto) custo_total,
			sum(moh) custo_horas
		from mh
			inner join fref on mh.fref = fref.fref
			inner join cm4 on cm4.cm = mh.tecnico
		where fref.frefstamp = '$frefstamp'
	";

	$data = mssql__select($str_sql);
	return $data;
}

function get_projeto($frefstamp) {
	$sql = "SELECT * FROM fref (nolock) WHERE frefstamp = '" . $frefstamp . "'";
	$data = mssql__select($sql);
	
	return $data;	
}

function get_contrato($no, $csupstamp) {
	$sql = "SELECT *, (select dbo.UltDataRenovacaoContrato(csup.no)) data_inicial, (select dbo.ProxDataRenovacaoContrato(csup.no)) data_final FROM csup (nolock) WHERE csupstamp <> '' ";
	
	if($no <> "") {
		$sql .= " AND no = " . $no;
	}
	
	if($csupstamp <> "") {
		$sql .= " AND csupstamp = '" . $csupstamp . "'";
	}
	
	$data = mssql__select($sql);
	
	return $data;
}

function get_dados_tarefa($id) {
	if(intval($id)) {
		$query = "SELECT * FROM tmp_mov where id = $id";
		$dados = mysql__select($query);
		return $dados;
	}
}

function get_clientes() {
	$sql = "select no, nome from cl where estab = 0 order by nome";
	$dados = mssql__select($sql);
	return $dados;
}

function get_tarefas_suporte() {
	$sql = "select dytablestamp, campo from dytable where entityname = 'a_mhtipo' order by campo";
	$dados = mssql__select($sql);
	return $dados;
}

function sec2hms ($sec, $secc = 0, $padHours = false) 
{
	if($sec < 0) {
		$sec = abs($sec) + $secc;
	}
	else {
		$sec = $secc - $sec;
	}
	return $sec;
}

function get_main_dic() {
	$query = "SELECT * FROM dic_parent";
	$dados = mysql__select($query);
	return $dados;
}

function get_code_data($id) 
{
	$sql = "SELECT text, syntax FROM dic_node WHERE id = " . $id;
	$data = mysql__select($sql);
	return $data[0];
}

function get_second_dic($id) {
	$query = "SELECT * FROM dic_subparent where id_parent = " . $id;
	$dados = mysql__select($query);
	return $dados;
}

function get_cliente_data($id) {
	$sql = "SELECT * from cl where estab = 0 and no = " . $id;
	$data = mssql__select($sql);
	
	return $data[0];
}

function get_doc_data($stamp, $tabela = 'ft') {
	$sql = "SELECT * from $tabela where ".$tabela."stamp = '" . $stamp . "'";
	$data = mssql__select($sql);
	
	return $data[0];
}

function get_doc_data_l($stamp, $tabelaf = 'fi', $tabelap = 'ft') {
	$sql = "SELECT * from $tabelaf where ".$tabelap."stamp = '" . $stamp . "' order by lordem";
	$data = mssql__select($sql);
	
	return $data;
}

function get_mensagens($destinatario, $tipo) {
	
	if( $tipo == 0 ) {
		//todas as mensagens
		$where = " and estado = estado";
	}
	else if( $tipo == 1 ) {
		//mensagens por ler
		$where = " and estado = 1";
	}
	else if( $tipo == 2 ) {
		//mensagens lidas
		$where = " and estado = 0";
	}
	else {
		$where = "";
	}
	
	$query = "
			select B.completeName, A.assunto, A.corpo, A.datahora, A.estado, A.id
			from mensagem A 
				inner join users B on A.remetente = B.tecnico
			where A.destinatario = " . $_SESSION['user']['tecnico'] . $where;
	$dados = mysql__select($query);
	return $dados;
}

function set_mensagem($remetente, $assunto, $corpo, $detinatario) {
	$query = "insert into mensagem(assunto, corpo, remetente, destinatario, estado, datahora) VALUES ('".$assunto."', '".base64_encode($corpo)."', '".$remetente."', (select tecnico from users where username = '".$detinatario."' limit 1 ), '1', '".time()."')";
	$mensagemGravada = mysql__execute($query);
	return $mensagemGravada;
}

?>