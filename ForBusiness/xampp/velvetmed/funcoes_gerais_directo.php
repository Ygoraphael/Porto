<?php

function getvndperiodo($data, $periodo, $vendedor) {
    $sql = "
        select SUM(fi.etiliquido)-SUM(fi.u_desccred * fi.qtt) evalor
        from ft
        inner join cl on ft.no = cl.no and ft.estab = cl.estab
        inner join fi on ft.ftstamp = fi.ftstamp
        inner join td on ft.ndoc = td.ndoc
        where
            ft.fdata between '" . $data . "' and DATEADD(month, " . $periodo . ", '" . $data . "') and
            td.tipodoc not in (4,5) and
            ft.anulado = 0 and
            cl.vendedor = " . $vendedor;
    $data = mssql__select($sql);

    return $data;
}

function getobjperiodo($data, $periodo, $vendedor) {
    $sql = "
        select SUM(evalor) evalor
        from ov
        where
            CONCAT(ano,RIGHT(CONVERT(VARCHAR(3), 100+mes),2),'01') between '" . $data . "' and DATEADD(month, " . $periodo . ", '" . $data . "') and
            vendedor = " . $vendedor;
    $data = mssql__select($sql);

    return $data;
}

function getvendasano($ano, $vendedor) {
    $sql = "
        select SUM(fi.etiliquido)-SUM(fi.u_desccred * fi.qtt) evalor
        from ft
        inner join cl on ft.no = cl.no and ft.estab = cl.estab
        inner join fi on ft.ftstamp = fi.ftstamp
        inner join td on ft.ndoc = td.ndoc
        where
            YEAR(ft.fdata) = " . $ano . " and
            td.tipodoc not in (4,5) and
            ft.anulado = 0 and
            cl.vendedor = " . $vendedor;
    
    $data = mssql__select($sql);

    return $data;
}

function getobjvendas($ano, $vendedor) {
    $sql = "
        select SUM(evalor) evalor
        from ov
        where
            ano = " . $ano . " and
            vendedor = " . $vendedor;
    $data = mssql__select($sql);

    return $data;
}

function getanosvendasobjetivos() {
    $sql = "
        select distinct ano from
        (
        select distinct year(fdata) ano from ft
        union all
        select distinct ano from ov
        union all
        select year(getdate()) ano
        ) x
        order by ano
    ";
    $data = mssql__select($sql);

    return $data;
}

function get_tpdesc() {
    $sql = "select tpstamp, descricao, u_desconto from tp where tipo = 1 order by descricao";
    $data = mssql__select($sql);

    return $data;
}

function get_familia_produtos() {
    $sql = "
		select distinct rtrim(ltrim(u_famsite)) familia
		from st
		where U_PRODVM = 1 and rtrim(ltrim(u_famsite)) <> '' and inactivo = 0
	";
    $data = mssql__select($sql);

    return $data;
}

function get_produto($ref) {
    $sql = "
		select *
		from st inner join stobs on st.ref = stobs.ref
		where st.U_PRODVM = 1 and rtrim(ltrim(st.u_famsite)) <> '' and st.inactivo = 0 and st.ref = '$ref'
	";
    $data = mssql__select($sql);

    return $data[0];
}

function get_familia_produtos_familia($familia) {
    $sql = "
		select *
		from st
		where U_PRODVM = 1 and u_famsite = '$familia' and inactivo = 0
	";
    $data = mssql__select($sql);

    return $data;
}

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

    return array_merge($data1, $data2);
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

    if ($no <> "") {
        $sql .= " AND no = " . $no;
    }

    if ($csupstamp <> "") {
        $sql .= " AND csupstamp = '" . $csupstamp . "'";
    }

    $data = mssql__select($sql);

    return $data;
}

function get_dados_tarefa($id) {
    if (intval($id)) {
        $query = "SELECT * FROM tmp_mov where id = $id";
        $dados = mysql__select($query);
        return $dados;
    }
}

function get_clientes() {
    $sql = "select no, nome from cl where estab = 0 and vendedor=" . $_SESSION["user"]["id"] . " order by nome";
    $dados = mssql__select($sql);
    return $dados;
}

function get_tarefas_suporte() {
    $sql = "select dytablestamp, campo from dytable where entityname = 'a_mhtipo' order by campo";
    $dados = mssql__select($sql);
    return $dados;
}

function sec2hms($sec, $secc = 0, $padHours = false) {
    if ($sec < 0) {
        $sec = abs($sec) + $secc;
    } else {
        $sec = $secc - $sec;
    }
    return $sec;
}

function get_main_dic() {
    $query = "SELECT * FROM dic_parent";
    $dados = mysql__select($query);
    return $dados;
}

function get_code_data($id) {
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

    $filtro_user = " and vendedor = " . $_SESSION["user"]["id"];
    if ($_SESSION["user"]["id"] == 2) {
        $filtro_user = "";
    }

    $sql = "SELECT * from cl (nolock) inner join cl2 on cl.clstamp = cl2.cl2stamp where tipo = 'Farmácia' and estab = 0 and no = " . $id . $filtro_user;
    $data = mssql__select($sql);

    if (sizeof($data) > 0) {
        return $data[0];
    } else {
        return array();
    }
}

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}

function get_vendedor_mercdest() {
    $sql = "
	select distinct rtrim(ltrim(isnull(db.campo, dy.campo))) campo
	from dytable dy 
	left join u_Destino_e_Brick db on dy.entityname = db.entityname and dy.campo = db.campo
	inner join cm3 (nolock) on db.cmstamp = cm3.cm3stamp and cm3.cm = " . $_SESSION["user"]["id"] . "
	where dy.entityname = 'a_paisdest' and marcado = 1
	order by campo desc
	";

    $data = mssql__select($sql);
    if (sizeof($data) > 0) {
        return $data;
    } else {
        return array();
    }
}

function get_vendedor_brickmun() {
    $sql = "
	select distinct rtrim(ltrim(isnull(db.campo, dy.campo))) campo
	from dytable dy 
	left join u_Destino_e_Brick db on dy.entityname = db.entityname and dy.campo = db.campo
	inner join cm3 (nolock) on db.cmstamp = cm3.cm3stamp and cm3.cm = " . $_SESSION["user"]["id"] . "
	where dy.entityname = 'a_Brick' and marcado = 1
	order by campo desc
	";

    $data = mssql__select($sql);
    if (sizeof($data) > 0) {
        return $data;
    } else {
        return array();
    }
}

function get_doc_data($stamp, $tabela = 'ft') {
    $sql = "SELECT * from $tabela where " . $tabela . "stamp = '" . $stamp . "'";
    $data = mssql__select($sql);

    return $data[0];
}

function get_doc_data_l($stamp, $tabelaf = 'fi', $tabelap = 'ft') {
    $sql = "SELECT * from $tabelaf where " . $tabelap . "stamp = '" . $stamp . "' order by lordem";
    $data = mssql__select($sql);

    return $data;
}

function get_mensagens($destinatario, $tipo) {

    if ($tipo == 0) {
        //todas as mensagens
        $where = " and estado = estado";
    } else if ($tipo == 1) {
        //mensagens por ler
        $where = " and estado = 1";
    } else if ($tipo == 2) {
        //mensagens lidas
        $where = " and estado = 0";
    } else {
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
    $query = "insert into mensagem(assunto, corpo, remetente, destinatario, estado, datahora) VALUES ('" . $assunto . "', '" . base64_encode($corpo) . "', '" . $remetente . "', (select tecnico from users where username = '" . $detinatario . "' limit 1 ), '1', '" . time() . "')";
    $mensagemGravada = mysql__execute($query);
    return $mensagemGravada;
}

?>