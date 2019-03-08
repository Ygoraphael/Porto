<?php
include("db.php");
include("db2.php");

if(isset($_POST['action']) && !empty($_POST['action'])) {

    $action = $_POST['action'];
	eval($action);
}

function get_docs_cabecalho($tabela, $campos, $where) 
{
	$str_sql = "
		select 
			$campos
		from $tabela (nolock)
		where
		" . base64_decode($where);

	$data = mssql__select($str_sql);
	echo json_encode($data);
}

function tabela_faturacao_contrato($csupstamp) 
{
	$str_sql = "
		select 
			ft.ftstamp, ft.nmdoc, ft.fno, ft.fdata, ft.pdata, ft.etotal, SUM(isnull(rl.erec,0)) erec
		from cc (nolock)
			left join rl (nolock) on cc.ccstamp = rl.ccstamp
			inner join ft (nolock) on ft.ftstamp = cc.ftstamp
			inner join ft2 (nolock) on ft.ftstamp = ft2.ft2stamp
		where
			ft2.csupstamp = '$csupstamp'
		group by
			ft.ftstamp, ft.nmdoc, ft.fno, ft.fdata, ft.pdata, ft.etotal
		order by
			ft.fdata
		";

	$data = mssql__select($str_sql);
	echo json_encode($data);
}

function tabela_contratos($no) 
{
	$str_sql = "
		SELECT 
			*, 
			(select dbo.UltDataRenovacaoContrato(csup.no)) data_inicial, 
			(select dbo.ProxDataRenovacaoContrato(csup.no)) data_final 
		FROM 
			csup (nolock)
		";
		
	if( $no > 0) {
		$str_sql .= " WHERE no = $no ";
	}

	$data = mssql__select($str_sql);
	echo json_encode($data);
}

function tabela_custo_projeto_funcionarios($frefstamp) {
	$str_sql = "
		select 
			cmdesc utilizador,
			sum(moh) horas,
			ecusto valor_hora,
			sum(moh)*ecusto custo_utilizador
		from mh
			inner join fref on mh.fref = fref.fref
			inner join cm4 on cm4.cm = mh.tecnico
		where fref.frefstamp = '$frefstamp'
		group by
			cmdesc, ecusto
	";

	$data = mssql__select($str_sql);
	echo json_encode($data);
}

function cria_intervencao_manual($cliente, $tarefa, $projeto, $utilizador, $qpediu, $dinicio, $hinicio, $minicio, $dfim, $hfim, $mfim, $hmanual, $mmanual, $ttempo, $rel, $tinter) {
	date_default_timezone_set('Europe/Lisbon');
	$date = new DateTime(null, new DateTimeZone('Europe/Lisbon'));
	
	if( intval($cliente) ) {
		
		$sql = "
			SELECT 
				tecnico
			FROM 
				users
			WHERE username = '" . $utilizador . "'";
		$dados_tarefa = mysql__select($sql);
		
		$sql = "select suser_sname()+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5) stamp";
		$data = mssql__select($sql);
		$stamp = trim($data[0]["stamp"]);
		
		$sql = "select nome FROM cl WHERE estab = 0 and no = " . $cliente;
		$data = mssql__select($sql);
		$nome = utf8_decode(trim($data[0]["nome"]));
		
		$sql = "select cmdesc from cm4 where cm = " . $dados_tarefa[0]["tecnico"];
		$data = mssql__select($sql);
		$utilizador = trim($data[0]["cmdesc"]);
		
		$sql = "select campo from dytable where dytablestamp = '" . $tarefa . "'";
		$data = mssql__select($sql);
		$tipointer = utf8_decode(trim($data[0]["campo"]));
		
		$date_f_2 = new DateTime(null, new DateTimeZone('Europe/Lisbon'));
		$date_now_2 = new DateTime(null, new DateTimeZone('Europe/Lisbon'));

		$data_i = str_replace("-", "", $dinicio);
		$hora_i = $hinicio . ":" . $minicio;
		
		$data_f = str_replace("-", "", $dfim);
		$hora_f = $hfim . ":" . $mfim;

		$usrdata = $date_now_2->format("Ymd");
		$usrhora = $date_now_2->format("H:i");
		
		//automatico
		if( $ttempo == "true") {
			$date_inicio = strtotime($dinicio . " " . $hinicio . ":" . $minicio);		
			$date_fim = strtotime($dfim . " " . $hfim . ":" . $mfim);
			
			$moh = $date_fim - $date_inicio;
			$moh = intval(gmdate("H", $moh)) + round(intval(gmdate("i", $moh))/60, 2);
		}
		//manual
		else {
			$moh = intval($hmanual) + round(intval($mmanual)/60, 2);
		}

		$data_pedido = $data_i;
		$horapat = $hora_i;
		
		$sql = "select max(u_movid)+1 u_movid from mh";
		$data = mssql__select($sql);
		$movimento_id = trim($data[0]["u_movid"]);
		
		if($tinter == "ass")
		{
			$u_cat = 0;
			$u_fat = 1;
		}
		else if ($tinter == "pro")
		{
			$u_cat = 0;
			$u_fat = 0;
		}
		else if ($tinter == "con")
		{
			$u_cat = 1;
			$u_fat = 0;
		}
		else if ($tinter == "nft")
		{
			$u_cat = 0;
			$u_fat = 0;
		}
		else
		{
			$u_cat = 0;
			$u_fat = 1;
		}

		if($projeto=="null") {
			$projeto = "";
		}
		
		$sql = "INSERT INTO mh (mhstamp, nome, data, tecnico, tecnnm, no, relatorio, ";
		$sql .= "hora, horaf, mhtipo, moh, deh, facturar, ";
		$sql .= "ousrdata, ousrhora, usrdata, usrhora, tdh, u_cat, u_movid, datapat, pquem, fref, horapat) VALUES(";
		$sql .= "'".$stamp."', '".$nome."', '".$data_i."', ".$dados_tarefa[0]["tecnico"].", '".$utilizador."', ".$cliente.", '".utf8_decode($rel)."',";
		$sql .= "'".$hora_i."', '".$hora_f."', '".$tipointer."', ".$moh.", 0, ".$u_fat.", ";
		$sql .= "'".$usrdata."', '".$usrhora."', '".$usrdata."', '".$usrhora."', 0, ".$u_cat.", ".$movimento_id.", '".$data_pedido."', '".$qpediu."', '".$projeto."', '".$horapat."')";
		
		mssql__execute($sql);
	}
}

function termina_intervencao($id, $relatorio, $tipo_intervencao, $projeto) {
	date_default_timezone_set('Europe/Lisbon');
	$date = new DateTime(null, new DateTimeZone('Europe/Lisbon'));
	
	if( intval($id) ) {
		
		//terminar intervencao
		$sql = "
			SELECT 
				tmp_mov.*,
				users.tecnico
			FROM 
				tmp_mov 
				inner join users on tmp_mov.username = users.username
			WHERE tmp_mov.id = " . $id;
		$dados_tarefa_antes = mysql__select($sql);
		
		if($dados_tarefa_antes[0]["activo"] == "1") {
			$total = intval($dados_tarefa_antes[0]["contador"]) + time() - intval($dados_tarefa_antes[0]["data"]);
			$inter_sql = "UPDATE tmp_mov SET contador = '".$total."', data = ".$date->getTimestamp().", activo = 0 WHERE id = '".$dados_tarefa_antes[0]["id"]."'";
			mysql__execute($inter_sql);
		}
		
		$dados_tarefa = mysql__select($sql);
		
		$sql = "select suser_sname()+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5) stamp";
		$data = mssql__select($sql);
		$stamp = trim($data[0]["stamp"]);
		
		$sql = "select nome FROM cl WHERE estab = 0 and no = " . $dados_tarefa[0]["cliente"];
		$data = mssql__select($sql);
		$nome = utf8_decode(trim($data[0]["nome"]));
		
		$sql = "select cmdesc from cm4 where cm = " . $dados_tarefa[0]["tecnico"];
		$data = mssql__select($sql);
		$utilizador = trim($data[0]["cmdesc"]);
		
		$sql = "select campo from dytable where dytablestamp = '" . $dados_tarefa[0]["tarefa"] . "'";
		$data = mssql__select($sql);
		$tipointer = utf8_decode(trim($data[0]["campo"]));
		
		$date_i_2 = new DateTime(null, new DateTimeZone('Europe/Lisbon'));
		$date_f_2 = new DateTime(null, new DateTimeZone('Europe/Lisbon'));
		$date_now_2 = new DateTime(null, new DateTimeZone('Europe/Lisbon'));
		$date_p_2 = new DateTime(null, new DateTimeZone('Europe/Lisbon'));
		
		$date_i_2->setTimestamp($dados_tarefa[0]["data_i"]);
		$data_i = $date_i_2->format("Ymd");
		$hora_i = $date_i_2->format("H:i");
		
		$date_f_2->setTimestamp($dados_tarefa[0]["data"]);
		$data_f = $date_f_2->format("Ymd");
		$hora_f = $date_f_2->format("H:i");
		
		$usrdata = $date_now_2->format("Ymd");
		$usrhora = $date_now_2->format("H:i");
		
		$date_p_2->setTimestamp($dados_tarefa[0]["data_pedido"]);
		$data_p = $date_p_2->format("Ymd");
		$hora_p = $date_p_2->format("H:i");
		
		$moh = round($dados_tarefa[0]["contador"] / 3600, 2);

		$data_pedido = $data_p;
		$horapat = $hora_p;
		
		$sql = "select max(u_movid)+1 u_movid from mh";
		$data = mssql__select($sql);
		$movimento_id = trim($data[0]["u_movid"]);
		
		if($tipo_intervencao == "ass")
		{
			$u_cat = 0;
			$u_fat = 1;
		}
		else if ($tipo_intervencao == "pro")
		{
			$u_cat = 0;
			$u_fat = 0;
		}
		else if ($tipo_intervencao == "con")
		{
			$u_cat = 1;
			$u_fat = 0;
		}
		else if ($tipo_intervencao == "nft")
		{
			$u_cat = 0;
			$u_fat = 0;
		}
		else
		{
			$u_cat = 0;
			$u_fat = 1;
		}

		$sql = "INSERT INTO mh (mhstamp, nome, data, tecnico, tecnnm, no, relatorio, ";
		$sql .= "hora, horaf, mhtipo, moh, deh, facturar, ";
		$sql .= "ousrdata, ousrhora, usrdata, usrhora, tdh, u_cat, u_movid, datapat, pquem, fref, horapat) VALUES(";
		$sql .= "'".$stamp."', '".$nome."', '".$data_i."', ".$dados_tarefa[0]["tecnico"].", '".$utilizador."', ".$dados_tarefa[0]["cliente"].", '".utf8_decode($relatorio)."',";
		$sql .= "'".$hora_i."', '".$hora_f."', '".$tipointer."', ".$moh.", 0, ".$u_fat.", ";
		$sql .= "'".$usrdata."', '".$usrhora."', '".$usrdata."', '".$usrhora."', 0, ".$u_cat.", ".$movimento_id.", '".$data_pedido."', '".$dados_tarefa[0]["quem_pediu"]."', '".$projeto."', '".$horapat."')";

		mssql__execute($sql);
		
		$sql = "delete from tmp_mov where id = " . $id;
		mysql__execute($sql);
	}
}

function cria_intervencao($cliente, $tarefa, $projeto, $utilizador, $quem_pediu) {
	date_default_timezone_set('Europe/Lisbon');
	$date = new DateTime(null, new DateTimeZone('Europe/Lisbon'));
	
	$strSql = "INSERT INTO tmp_mov (id, username, cliente, tarefa, data_i, data, contador, activo, id_projecto, data_pedido, quem_pediu)";
	$strSql .= "VALUES (NULL, '".$utilizador."', '".$cliente."', '".$tarefa."', ".$date->getTimestamp().", ".$date->getTimestamp().", 0, 1, '".$projeto."', ".$date->getTimestamp().", '".$quem_pediu."')";

	mysql__execute($strSql);
}

function set_inter_play($id) {
	if( intval($id) ) {
		$query = "update tmp_mov set activo = 1, data = UNIX_TIMESTAMP(now()) where id = " . $id;
		mysql__execute($query);
		$str_sql = "
		SELECT data, contador from tmp_mov WHERE id = " . $id;

		$data = mysql__select($str_sql);
		echo $data[0]["data"].";".$data[0]["contador"];
		return;
	}
	echo -1;
	return;
}

function inter_remove($id) {
	if( intval($id) ) {
		$query = "delete from tmp_mov where id = " . $id;
		mysql__execute($query);
		echo 1;
		return;
	}
	echo -1;
	return;
}

function set_inter_pause($id) {
	if( intval($id) ) {
		$cur_tsk = mysql__select("SELECT id, contador, data FROM tmp_mov WHERE id = " . $id );

		$total = intval($cur_tsk[0]["contador"]) + time() - intval($cur_tsk[0]["data"]);
		$query = "update tmp_mov set contador = '".$total."', data = UNIX_TIMESTAMP(now()), activo = 0 where id = " . $id;
		mysql__execute($query);

		echo 1;
		return;
	}
	echo -1;
	return;
}

function update_code($id, $code, $syntax)
{
	mysql__execute("update dic_node set text = '".base64_encode($code)."', syntax='".$syntax."' where id = " . $id);
}

function get_message($id) 
{
	$str_sql = "
		SELECT assunto, corpo, (select nicename from users where tecnico = remetente) remetente, 
		(select email from users where tecnico = remetente) remetenteEmail, datahora 
		FROM mensagem WHERE id = " . $id;

	$data = mysql__select($str_sql);
	
	mysql__execute("update mensagem set estado = 0 where id = " . $id);

	echo json_encode($data);
}

function get_cliente_faturacao_atraso($id) {

	$sql = "
	SELECT 
	   cc.datalc,
	   cc.dataven,
	   cc.edeb,
	   cc.ecred,
	   cc.cmdesc,
	   cc.nrdoc,
	   cc.ftstamp
	FROM 
		cc (nolock) LEFT JOIN RE (nolock) ON cc.restamp = re.restamp
	WHERE 
		cc.no=".$id." AND 
		(
			CASE 
				WHEN cc.moeda='PTE ou EURO' OR cc.moeda=space(11) THEN abs((cc.edeb-cc.edebf)-(cc.ecred-cc.ecredf)) 
				ELSE abs((cc.debm-cc.debfm)-(cc.credm-cc.credfm)) END) > (CASE WHEN cc.moeda='PTE ou EURO' OR cc.moeda=space(11) THEN 0.010000 ELSE 0 END)
	ORDER BY 
		cc.datalc,
		cc.cm,
		cc.nrdoc";
	
	$data = mssql__select($sql);
	
	echo json_encode(utf8ize($data)); 
}

function tabela_projetos($no, $order='fref', $fechado=-1) 
{
	$str_sql = "
		SELECT DISTINCT fref, nmfref, u_no, u_dataini, u_nhoraso, u_datafim, u_fechado, u_nhorasr, u_nome, u_tipo, frefstamp
			FROM fref
			WHERE fref != '' ";
	if( $fechado > -1) {
		$str_sql .= " AND u_fechado = $fechado ";
	}
	
	if( intval($no) > 0 ) {
		$str_sql .= "and u_no = " . intval($no) . " ";
	}
	
	$str_sql .= " order by $order";

	$data = mssql__select($str_sql);
	echo json_encode($data);
}

function get_contrato($no) {
	$sql = "SELECT *, (select dbo.UltDataRenovacaoContrato(csup.no)) data_inicial, (select dbo.ProxDataRenovacaoContrato(csup.no)) data_final FROM csup (nolock) WHERE no = '" . $no . "'";
	$data = mssql__select($sql);
	
	echo json_encode($data);
}

function tabela_clientes($num, $nome, $order='no') 
{
	$str_sql = "";

	if($num == "" and $nome == "")
		$str_sql = "
			SELECT 
				A.no, 
				A.nome, 
				A.esaldo, 
				(select no from csup B where B.no = A.no AND B.datap >= getdate()) contrato,
				(select u_horasres from csup B where B.no = A.no AND B.datap >= getdate()) contrato_hrestantes
			FROM 
				cl A
			WHERE 
				A.estab = 0 
			order by
				A." . $order;
	else
	{
		$str_sql = "
			SELECT 
				A.no, 
				A.nome, 
				A.esaldo, 
				(select no from csup B where B.no = A.no AND B.datap >= getdate()) contrato,
				(select u_horasres from csup B where B.no = A.no AND B.datap >= getdate()) contrato_hrestantes
			FROM 
				cl A  
			WHERE 
				A.estab = 0 AND A.no LIKE '%".$num."%' and A.nome LIKE '%".$nome."%' 
			ORDER BY 
				A." . $order;
	}

	$data = mssql__select($str_sql);
	echo json_encode($data);
}

function tabela_enciclopedia($num) 
{
	$str_sql = "SELECT * FROM dic_node where id_parent = " . $num;

	$data = mysql__select($str_sql);
	echo json_encode($data);
}

?>