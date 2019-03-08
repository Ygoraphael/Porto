<?php

include("db.php");
include("db2.php");

if (isset($_POST['action']) && !empty($_POST['action'])) {

    $action = $_POST['action'];
    eval($action);
}

function estado_ponto() {
    $sql = "select * from us where usercode = '" . trim($_SESSION['user']['username']) . "'";
    $data = mssql__select($sql);
    $utilizador = $data[0];
    
    $result = array();
    
    $sql = "
        select * 
        from u_ponto 
        where 
            ref = '" . trim($utilizador["u_ref"]) . "'
        order by
            data desc, hora desc
    ";
    $data = mssql__select($sql);
    
    if( sizeof($data) ) {
        $ultponto = $data[0];
        
        $result['msg'] = '';
        $result['val'] = $ultponto['tipo'];

        echo json_encode($result);
        return ;
    }
    else {
        $result['msg'] = '';
        $result['val'] = 'SAIDA';

        echo json_encode($result);
        return ;
    }
}

function estado_ponto_directo() {
    $sql = "select * from us where usercode = '" . trim($_SESSION['user']['username']) . "'";
    $data = mssql__select($sql);
    $utilizador = $data[0];
    
    $result = array();
    
    $sql = "
        select * 
        from u_ponto 
        where 
            ref = '" . trim($utilizador["u_ref"]) . "'
        order by
            data desc, hora desc
    ";
    $data = mssql__select($sql);
    
    if( sizeof($data) ) {
        $ultponto = $data[0];
        
        $result['msg'] = '';
        $result['val'] = $ultponto['tipo'];

        return $result;
    }
    else {
        $result['msg'] = '';
        $result['val'] = 'SAIDA';

        return $result;
    }
}

function getClienteCC($no, $datai, $dataf) {

    $datai = str_replace('-', '', $datai);
    $dataf = str_replace('-', '', $dataf);

    $str_sql = "
	Select cc.obs,cc.ccstamp,cc.datalc as datalc
		,cc.dataven,cc.edeb,cc.ecred
		,cc.cmdesc,cc.nrdoc as nrdoc,cc.ultdoc, cc.ftstamp
	FROM cc (nolock) 	
	LEFT JOIN RE (nolock) ON cc.restamp = re.restamp 	
	WHERE cc.no=$no
			And convert(char(8),cc.datalc,112)>='$datai' 
			And convert(char(8),cc.datalc,112)<='$dataf' 
	ORDER BY datalc,cm,nrdoc";

    $data = mssql__select($str_sql);

    $str_sql = "
	select isnull(sum(edeb-ecred-erec), 0) saldo
	from
	( 
		select	
			cmdesc, 
			edeb, 
			ecred, 
			isnull((select sum(erec) from rl inner join re on rl.restamp = re.restamp where procdata < '$datai' and rl.ccstamp=cc.ccstamp and re.process=1),0) erec
		from cc 
		where 
				cc.no = $no  and cc.estab = 0 
			and cc.datalc < '$datai' and cmdesc!='N/Recibo'
	)x
	";

    $data2 = mssql__select($str_sql);

    $tmp = array();
    $tmp["data"] = $data;
    $tmp["data2"] = $data2;

    echo json_encode($tmp);
}

function get_relatorio_inter($mhstamp) {
    $sql = "select top 1 relatorio from mh where mhstamp = '$mhstamp'";
    // WriteLog($sql);
    $data = mssql__select($sql);
    echo json_encode($data);
}

function ClearLog() {
    $sql = "delete from log ";
    mysql__execute($sql);
}

function ReadLog($id) {
    $sql = "select id, msg, datetime from log where id > $id order by id";

    $data = mysql__select($sql);
    echo json_encode($data);
}

function WriteLog($msg) {
    $sql = "insert into log (msg, datetime) values (";
    $sql .= "'" . base64_encode($msg) . "', ";
    $sql .= "'" . time() . "')";

    mysql__execute($sql);
}

function tabela_intervencoes($selectAdicional, $dtIni, $dtFim, $facturar, $okft, $u_cat, $fref, $tecnico, $cliente) {
    $str_sql = "SELECT ";
    if ($selectAdicional <> '')
        $str_sql .= $selectAdicional . ",";
    $str_sql .= "
		*
	FROM 
		mh (nolock)
	";

    $where_ar = array();

    if ($dtIni <> '') {
        $where_ar[] = " data >= '$dtIni' ";
    }

    if ($dtFim <> '') {
        $where_ar[] = " data <= '$dtFim' ";
    }

    if ($facturar == 1) {
        $where_ar[] = " facturar = '$facturar' ";
    }

    if ($okft == 1) {
        $where_ar[] = " okft = '$okft' ";
    }

    if ($u_cat == 1) {
        $where_ar[] = " u_cat = '$u_cat' ";
    }

    if ($fref == 1) {
        $where_ar[] = " fref <> '' ";
    }

    if ($tecnico <> '') {
        $where_ar[] = " tecnico = $tecnico ";
    }

    if ($cliente <> '') {
        $where_ar[] = " no = $cliente ";
    }

    $and_separated = implode("and", $where_ar);

    if (sizeof($where_ar) > 0) {
        $str_sql .= " WHERE " . $and_separated;
    }

    $str_sql .= "
		order by 
			u_movid desc";

    $data = mssql__select($str_sql);
    echo json_encode($data);
}

function get_docs_cabecalho($tabela, $campos, $where) {
    $str_sql = "
		select 
			$campos
		from $tabela (nolock)
		where
		" . base64_decode($where);

    $data = mssql__select($str_sql);
    echo json_encode($data);
}

function tabela_faturacao_contrato($csupstamp) {
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

function tabela_contratos($no) {
    $str_sql = "
		SELECT 
			*, 
			(select dbo.UltDataRenovacaoContrato(csup.no)) data_inicial, 
			(select dbo.ProxDataRenovacaoContrato(csup.no)) data_final 
		FROM 
			csup (nolock)
		";

    if ($no > 0) {
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

    if (intval($cliente)) {

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
        if ($ttempo == "true") {
            $date_inicio = strtotime($dinicio . " " . $hinicio . ":" . $minicio);
            $date_fim = strtotime($dfim . " " . $hfim . ":" . $mfim);

            $moh = $date_fim - $date_inicio;
            $moh = intval(gmdate("H", $moh)) + round(intval(gmdate("i", $moh)) / 60, 2);
        }
        //manual
        else {
            $moh = intval($hmanual) + round(intval($mmanual) / 60, 2);
        }

        $data_pedido = $data_i;
        $horapat = $hora_i;

        $sql = "select max(u_movid)+1 u_movid from mh";
        $data = mssql__select($sql);
        $movimento_id = trim($data[0]["u_movid"]);

        if ($tinter == "ass") {
            $u_cat = 0;
            $u_fat = 1;
        } else if ($tinter == "pro") {
            $u_cat = 0;
            $u_fat = 0;
        } else if ($tinter == "con") {
            $u_cat = 1;
            $u_fat = 0;
        } else if ($tinter == "nft") {
            $u_cat = 0;
            $u_fat = 0;
        } else {
            $u_cat = 0;
            $u_fat = 1;
        }

        if ($projeto == "null") {
            $projeto = "";
        }

        $sql = "INSERT INTO mh (mhstamp, nome, data, tecnico, tecnnm, no, relatorio, ";
        $sql .= "hora, horaf, mhtipo, moh, deh, facturar, ";
        $sql .= "ousrdata, ousrhora, usrdata, usrhora, tdh, u_cat, u_movid, datapat, pquem, fref, horapat) VALUES(";
        $sql .= "'" . $stamp . "', '" . $nome . "', '" . $data_i . "', " . $dados_tarefa[0]["tecnico"] . ", '" . $utilizador . "', " . $cliente . ", '" . utf8_decode($rel) . "',";
        $sql .= "'" . $hora_i . "', '" . $hora_f . "', '" . $tipointer . "', " . $moh . ", 0, " . $u_fat . ", ";
        $sql .= "'" . $usrdata . "', '" . $usrhora . "', '" . $usrdata . "', '" . $usrhora . "', 0, " . $u_cat . ", " . $movimento_id . ", '" . $data_pedido . "', '" . $qpediu . "', '" . $projeto . "', '" . $horapat . "')";

        mssql__execute($sql);
    }
}

function termina_intervencao($id, $relatorio, $assinatura, $projeto) {
    date_default_timezone_set('Europe/Lisbon');
    $date = new DateTime(null, new DateTimeZone('Europe/Lisbon'));

    if (intval($id)) {

        //terminar intervencao
        $sql = "
            SELECT 
                *
            FROM 
                tmp_mov 
            WHERE tmp_mov.id = " . $id;
        $dados_tarefa_antes = mysql__select($sql);

        if ($dados_tarefa_antes[0]["activo"] == "1") {
            $total = intval($dados_tarefa_antes[0]["contador"]) + time() - intval($dados_tarefa_antes[0]["data"]);
            $inter_sql = "UPDATE tmp_mov SET contador = '" . $total . "', data = " . $date->getTimestamp() . ", activo = 0 WHERE id = '" . $dados_tarefa_antes[0]["id"] . "'";
            mysql__execute($inter_sql);
        }

        $dados_tarefa = mysql__select($sql);

        $sql = "select suser_sname()+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5) stamp";
        $data = mssql__select($sql);
        $stamp = trim($data[0]["stamp"]);

        $sql = "select * FROM cl WHERE estab = 0 and no = " . $dados_tarefa[0]["cliente"];
        $data = mssql__select($sql);
        $cliente = $data[0];
        
        $sql = "select * from us where usercode = '" . $dados_tarefa[0]["username"] . "'";
        $data = mssql__select($sql);
        $utilizador = $data[0];

        $sql = "select tarefa from u_tar where u_tarstamp = '" . $dados_tarefa[0]["tarefa"] . "'";
        $data = mssql__select($sql);
        $tipointer = utf8_decode(trim($data[0]["tarefa"]));

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

        $sql = "select * from bo where ndos = 27 and origem = 'APP' and fref = '" . $projeto . "'";
        $documento_aberto = mssql__select($sql);
        
        if( sizeof($documento_aberto) ) {
            $sql = "
                INSERT into bi (
                    bistamp,
                    nmdos,
                    ndos,
                    obrano,
                    iva,
                    tabiva,
                    rdata,
                    dataopen,
                    dataobra,
                    lordem,
                    local,
                    morada,
                    codpost,
                    nome,
                    unidade,
                    familia,
                    epu,
                    ettdeb,
                    bostamp,
                    u_assina,
                    ref,
                    design,
                    u_tarefa,
                    qtt,
                    edebito,
                    ousrdata,
                    ousrhora,
                    ousrinis,
                    usrdata,
                    usrhora,
                    usrinis,
                    u_rel,
                    litem,
                    litem2,
                    bofref,
                    bifref
                ) VALUES (
                    (select suser_sname()+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)),
                    '" . utf8_decode('Obra - Registo Diário') . "',
                    '27',
                    '" . $documento_aberto[0]['obrano'] . "',
                    '23',
                    '2',
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                    isnull((select max(lordem) + 10000 from bi where bostamp = '" . $documento_aberto[0]['bostamp'] . "'), 10000),
                    '" . $documento_aberto[0]['local'] . "',
                    '" . $documento_aberto[0]['morada'] . "',
                    '" . $documento_aberto[0]['codpost'] . "',
                    '" . $documento_aberto[0]['nome'] . "',
                    isnull((select unidade from st where ref = '" . $utilizador['u_ref'] . "'), ''),
                    isnull((select familia from st where ref = '" . $utilizador['u_ref'] . "'), ''),
                    1,
                    " . $moh . " * (isnull((select epcusto from st where ref = '" . $utilizador['u_ref'] . "'), 0)),
                    '" . $documento_aberto[0]['bostamp'] . "',
                    '" . $assinatura . "',
                    '" . strtoupper($utilizador['u_ref']) . "',
                    isnull((select design from st where ref = '" . $utilizador['u_ref'] . "'), ''),
                    '" . $tipointer . "',
                    " . $moh . ",
                    " . $moh . " * (isnull((select epcusto from st where ref = '" . $utilizador['u_ref'] . "'), 0)),
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
                    CONVERT(VARCHAR(5), GETDATE(), 8), 
                    UPPER(suser_sname()), 
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
                    CONVERT(VARCHAR(5), GETDATE(), 8),
                    UPPER(suser_sname()),
                    '" . $relatorio . "',
                    '" . $hora_i . "',
                    '" . $hora_f . "',
                    '" . $projeto . "',
                    '" . $projeto . "'
                )
            ";

            mssql__execute($sql);
        }
        else {
            $sql = "
                INSERT INTO bo (
                    bostamp, 
                    nmdos, 
                    ndos, 
                    no, 
                    estab, 
                    obrano, 
                    boano, 
                    dataobra, 
                    nome, 
                    morada, 
                    local, 
                    codpost, 
                    ncont,  
                    ousrdata, 
                    ousrhora, 
                    ousrinis,
                    usrdata, 
                    usrhora, 
                    usrinis, 
                    origem,
                    fref
                ) values (
                    '" . $stamp . "',
                    '" . utf8_decode('Obra - Registo Diário') . "',
                    '27',
                    '" . $cliente["no"] . "',
                    '" . $cliente["estab"] . "',
                    isnull((select max(obrano) + 1 from bo where ndos = 27 and year(dataobra) = " . date('Y') . "), 1),
                    '" . date('Y') . "',
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                    '" . $cliente["nome"] . "',
                    '" . $cliente["morada"] . "',
                    '" . $cliente["local"] . "',
                    '" . $cliente["codpost"] . "',
                    '" . $cliente["ncont"] . "',
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                    CONVERT(VARCHAR(5), GETDATE(), 8),
                    UPPER(suser_sname()),
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                    CONVERT(VARCHAR(5), GETDATE(), 8),
                    UPPER(suser_sname()),
                    'APP',
                    '" . $projeto . "'
                )
            ";

            mssql__execute($sql);
            
            $sql = "select * from bo where bostamp = '" . $stamp . "'";
            $data = mssql__select($sql);
            $documento_aberto = $data;
            
            $sql = "
                INSERT into bi (
                    bistamp,
                    nmdos,
                    ndos,
                    obrano,
                    iva,
                    tabiva,
                    rdata,
                    dataopen,
                    dataobra,
                    lordem,
                    local,
                    morada,
                    codpost,
                    nome,
                    unidade,
                    familia,
                    epu,
                    ettdeb,
                    bostamp,
                    u_assina,
                    ref,
                    design,
                    u_tarefa,
                    qtt,
                    edebito,
                    ousrdata,
                    ousrhora,
                    ousrinis,
                    usrdata,
                    usrhora,
                    usrinis,
                    u_rel,
                    litem,
                    litem2,
                    bofref,
                    bifref
                ) VALUES (
                    (select suser_sname()+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)),
                    '" . utf8_decode('Obra - Registo Diário') . "',
                    27,
                    '" . $documento_aberto[0]['obrano'] . "',
                    23,
                    2,
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                    isnull((select max(lordem) + 10000 from bi where bostamp = '" . $documento_aberto[0]['bostamp'] . "'), 10000),
                    '" . $documento_aberto[0]['local'] . "',
                    '" . $documento_aberto[0]['morada'] . "',
                    '" . $documento_aberto[0]['codpost'] . "',
                    '" . $documento_aberto[0]['nome'] . "',
                    isnull((select unidade from st where ref = '" . $utilizador['u_ref'] . "'), ''),
                    isnull((select familia from st where ref = '" . $utilizador['u_ref'] . "'), ''),
                    1,
                    " . $moh . " * (isnull((select epcusto from st where ref = '" . $utilizador['u_ref'] . "'), 0)),
                    '" . $documento_aberto[0]['bostamp'] . "',
                    '" . $assinatura . "',
                    '" . strtoupper($utilizador['u_ref']) . "',
                    isnull((select design from st where ref = '" . $utilizador['u_ref'] . "'), ''),
                    '" . $tipointer . "',
                    " . $moh . ",
                    " . $moh . " * (isnull((select epcusto from st where ref = '" . $utilizador['u_ref'] . "'), 0)),
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
                    CONVERT(VARCHAR(5), GETDATE(), 8), 
                    UPPER(suser_sname()), 
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
                    CONVERT(VARCHAR(5), GETDATE(), 8),
                    UPPER(suser_sname()),
                    '" . $relatorio . "',
                    '" . $hora_i . "',
                    '" . $hora_f . "',
                    '" . $projeto . "',
                    '" . $projeto . "'
                )
            ";
            
            mssql__execute($sql);
        }

        $sql = "delete from tmp_mov where id = " . $id;
        mysql__execute($sql);
    }
}

function registo_ponto( $tipo ) {
    $sql = "select * from us where usercode = '" . trim($_SESSION['user']['username']) . "'";
    $data = mssql__select($sql);
    $utilizador = $data[0];

    $sql = "select * from st where ref = '" . trim($utilizador['u_ref']) . "'";
    $data = mssql__select($sql);
    $artigo = $data[0];

    $sql = "select * from e1 where estab = 0";
    $data = mssql__select($sql);
    $empresa = $data[0];

    $sql = "
        INSERT into u_ponto (
            u_pontostamp,
            ref,
            design,
            tipo,
            data,
            hora,
            ousrdata,
            ousrhora,
            ousrinis,
            usrdata,
            usrhora,
            usrinis
        ) VALUES (
            (select suser_sname()+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)),
            '" . $artigo["ref"] . "',
            '" . $artigo["design"] . "',
            '" . $tipo . "',
            CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
            CONVERT(VARCHAR(8), GETDATE(), 8), 
            CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
            CONVERT(VARCHAR(5), GETDATE(), 8), 
            UPPER(suser_sname()), 
            CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
            CONVERT(VARCHAR(5), GETDATE(), 8),
            UPPER(suser_sname())
        )
    ";

    $result = mssql__execute($sql);
    
    return $result;
}

function entrar_ponto() {
    
    $sql = "select * from us where usercode = '" . trim($_SESSION['user']['username']) . "'";
    $data = mssql__select($sql);
    $utilizador = $data[0];
    
    $result = array();
    
    $sql = "
        select * 
        from u_ponto 
        where 
            ref = '" . trim($utilizador["u_ref"]) . "'
        order by
            data desc, hora desc
    ";
    $data = mssql__select($sql);
    
    if( sizeof($data) ) {
        $ultponto = $data[0];
        
        if( $ultponto["tipo"] == 'ENTRADA' ) {
            $result['msg'] = 'JÁ EXISTE UMA ENTRADA AO SERVIÇO EM ABERTO';
            $result['val'] = 0;
            
            echo json_encode($result);
            return;
        }
        else {
            $estado = registo_ponto('ENTRADA');
            
            if( $estado ) {
                $result['msg'] = 'ENTRADA EFETUADA COM SUCESSO';
                $result['val'] = 1;

                echo json_encode($result);
                return;
            }
            else {
                $result['msg'] = 'NÃO FOI POSSIVEL EFETUAR A ENTRADA AO SERVIÇO. TENTE NOVAMENTE MAIS TARDE OU CONTACTE O ADMINISTRADOR DO SISTEMA';
                $result['val'] = 0;

                echo json_encode($result);
                return;
            }
        }
    }
    else {
        $estado = registo_ponto('ENTRADA');
        if( $estado ) {
            $result['msg'] = 'ENTRADA EFETUADA COM SUCESSO';
            $result['val'] = 1;

            echo json_encode($result);
            return;
        }
        else {
            $result['msg'] = 'NÃO FOI POSSIVEL EFETUAR A ENTRADA AO SERVIÇO. TENTE NOVAMENTE MAIS TARDE OU CONTACTE O ADMINISTRADOR DO SISTEMA';
            $result['val'] = 0;

            echo json_encode($result);
            return;
        }
    }
}

function sair_ponto() {
    
    $sql = "select * from us where usercode = '" . trim($_SESSION['user']['username']) . "'";
    $data = mssql__select($sql);
    $utilizador = $data[0];
    
    $result = array();
    
    $sql = "
        select * 
        from u_ponto 
        where 
            ref = '" . trim($utilizador["u_ref"]) . "'
        order by
            data desc, hora desc
    ";
    $data = mssql__select($sql);
    
    if( sizeof($data) ) {
        $ultponto = $data[0];
        
        if( $ultponto["tipo"] == 'SAIDA' ) {
            $result['msg'] = 'NÃO EXISTE NENHUMA ENTRADA EM ABERTO';
            $result['val'] = 0;
            
            echo json_encode($result);
            return;
        }
        else {
            $estado = registo_ponto('SAIDA');
            
            if( $estado ) {
                $result['msg'] = 'SAIDA EFETUADA COM SUCESSO';
                $result['val'] = 1;

                echo json_encode($result);
                return;
            }
            else {
                $result['msg'] = 'NÃO FOI POSSIVEL EFETUAR A SAIDA DO SERVIÇO. TENTE NOVAMENTE MAIS TARDE OU CONTACTE O ADMINISTRADOR DO SISTEMA';
                $result['val'] = 0;

                echo json_encode($result);
                return;
            }
        }
    }
    else {
        $result['msg'] = 'NÃO EXISTE NENHUMA ENTRADA EM ABERTO';
        $result['val'] = 0;

        echo json_encode($result);
        return;
    }
}

function tarefas_aberto() {
    $result = array();
    
    $sql = "
        SELECT 
            *
        FROM 
            tmp_mov 
        WHERE username = '" . trim($_SESSION['user']['username']) . "'";
    
    $tarefas = mysql__select($sql);

    $result['msg'] = '';
    $result['val'] = sizeof($tarefas);
    
    echo json_encode($result);
    
    return $result;
}

function cria_intervencao($cliente, $tarefa, $projeto, $utilizador, $quem_pediu) {
    $estado_ponto = estado_ponto_directo();

    if( $estado_ponto['val'] == "ENTRADA" ) {
        date_default_timezone_set('Europe/Lisbon');
        $date = new DateTime(null, new DateTimeZone('Europe/Lisbon'));

        $strSql = "INSERT INTO tmp_mov (id, username, cliente, tarefa, data_i, data, contador, activo, id_projecto, data_pedido, quem_pediu)";
        $strSql .= "VALUES (NULL, '" . $utilizador . "', '" . $cliente . "', '" . $tarefa . "', " . $date->getTimestamp() . ", " . $date->getTimestamp() . ", 0, 1, '" . $projeto . "', " . $date->getTimestamp() . ", '" . $quem_pediu . "')";

        mysql__execute($strSql);
    }
}

function set_inter_play($id) {
    if (intval($id)) {
        $query = "update tmp_mov set activo = 1, data = UNIX_TIMESTAMP(now()) where id = " . $id;
        mysql__execute($query);
        $str_sql = "
		SELECT data, contador from tmp_mov WHERE id = " . $id;

        $data = mysql__select($str_sql);
        echo $data[0]["data"] . ";" . $data[0]["contador"];
        return;
    }
    echo -1;
    return;
}

function inter_remove($id) {
    if (intval($id)) {
        $query = "delete from tmp_mov where id = " . $id;
        mysql__execute($query);
        echo 1;
        return;
    }
    echo -1;
    return;
}

function set_inter_pause($id) {
    if (intval($id)) {
        $cur_tsk = mysql__select("SELECT id, contador, data FROM tmp_mov WHERE id = " . $id);

        $total = intval($cur_tsk[0]["contador"]) + time() - intval($cur_tsk[0]["data"]);
        $query = "update tmp_mov set contador = '" . $total . "', data = UNIX_TIMESTAMP(now()), activo = 0 where id = " . $id;
        mysql__execute($query);

        echo 1;
        return;
    }
    echo -1;
    return;
}

function update_code($id, $code, $syntax) {
    mysql__execute("update dic_node set text = '" . base64_encode($code) . "', syntax='" . $syntax . "' where id = " . $id);
}

function get_message($id) {
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
		cc.no=" . $id . " AND 
		(
			CASE 
				WHEN cc.moeda='PTE ou EURO' OR cc.moeda=space(11) THEN abs((cc.edeb-cc.edebf)-(cc.ecred-cc.ecredf)) 
				ELSE abs((cc.debm-cc.debfm)-(cc.credm-cc.credfm)) END) > (CASE WHEN cc.moeda='PTE ou EURO' OR cc.moeda=space(11) THEN 0.010000 ELSE 0 END)
	ORDER BY 
		cc.datalc,
		cc.cm,
		cc.nrdoc";

    $data = mssql__select($sql);

    echo json_encode($data);
}

function tabela_projetos($no, $order = 'fref', $fechado = -1) {
    $str_sql = "
        SELECT *
        FROM fref
        WHERE fref != '' ";
    if ($fechado > -1) {
        $str_sql .= " AND inactivo = $fechado ";
    }

    if (intval($no) > 0) {
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

function tabela_clientes($num, $nome, $order = 'no') {
    $str_sql = "";

    if ($num == "" and $nome == "")
        $str_sql = "
			SELECT 
				A.no, 
				A.nome
			FROM 
				cl A
			WHERE 
				A.estab = 0 
			order by
				A." . $order;
    else {
        $str_sql = "
			SELECT 
				A.no, 
				A.nome
			FROM 
				cl A  
			WHERE 
				A.estab = 0 AND A.no LIKE '%" . $num . "%' and A.nome LIKE '%" . $nome . "%' 
			ORDER BY 
				A." . $order;
    }

    $data = mssql__select($str_sql);
    echo json_encode($data);
}

function tabela_enciclopedia($num) {
    $str_sql = "SELECT * FROM dic_node where id_parent = " . $num;

    $data = mysql__select($str_sql);
    echo json_encode($data);
}

?>