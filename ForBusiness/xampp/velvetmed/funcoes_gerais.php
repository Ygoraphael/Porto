<?php
include("db.php");
include("db2.php");

if (isset($_POST['action']) && !empty($_POST['action'])) {

    $action = $_POST['action'];
    eval($action);
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
	LEFT JOIN CL (nolock) ON cc.no = cl.no and cc.estab = cl.estab 
	WHERE cc.no=$no
			And convert(char(8),cc.datalc,112)>='$datai' 
			And convert(char(8),cc.datalc,112)<='$dataf' 
			And cl.vendedor = " . $_SESSION["user"]["id"] . "
	ORDER BY datalc,cm,nrdoc";

    $data = mssql__select($str_sql);

    $str_sql = "
	select isnull(sum(edeb-ecred-erec), 0) saldo
	from
	( 
		select	
			cc.cmdesc, 
			cc.edeb, 
			cc.ecred, 
			isnull((select sum(erec) from rl inner join re on rl.restamp = re.restamp where procdata < '$datai' and rl.ccstamp=cc.ccstamp and re.process=1),0) erec
		from cc 
		inner join cl (nolock) on cc.no = cl.no and cc.estab = cl.estab
		where 
				cc.no = $no  and cc.estab = 0 
			and cc.datalc < '$datai' and cmdesc!='N/Recibo' And cl.vendedor = " . $_SESSION["user"]["id"] . "
	)x
	";

    $data2 = mssql__select($str_sql);

    $tmp = array();
    $tmp["data"] = $data;
    $tmp["data2"] = $data2;

    echo json_encode($tmp);
}

function cria_visita($dados) {
    $data = array();

    $dados = urldecode($dados);
    $dados = json_decode($dados);
    utf8_decode_deep($dados);

    $sql = "select no from cl where ncont = '" . $dados->nif . "' and estab = 0";
    $data_str = mssql__select($sql);

    if (sizeof($data_str) > 0) {
        $dados->no = $data_str[0]["no"];
    }

    if ($dados->no == 0 || $dados->no == "") {
        //criar cliente
        $super_query = "
		BEGIN TRANSACTION;
		
		DECLARE @stamp VARCHAR(25);
		DECLARE @numero INT;
			
		SET @stamp = CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)));
		SET @numero = isnull((select max(no) + 1 from cl where estab = 0), 1);
			
		INSERT INTO CL (clstamp, no, estab, nome, morada, ncont, local, codpost, email, telefone, tipo, vendedor, vendnm, zona, area)
		VALUES 
		(
			@stamp,
			@numero,
			0,
			'" . $dados->nome . "',
			'" . $dados->morada . "',
			'" . $dados->nif . "',
			'" . $dados->local . "',
			'" . $dados->codpost . "',
			'" . $dados->email . "',
			'" . $dados->telefone . "',
			'" . utf8_decode('Farmácia') . "',
			'" . utf8_decode($_SESSION["user"]["id"]) . "',
			'" . utf8_decode($_SESSION["user"]["nicename"]) . "',
			'EUROPA',
			'PORTUGAL'
		)
		
		COMMIT TRANSACTION;
		";

        mssql__execute($super_query);

        $sql = "select no from cl where ncont = '" . $dados->nif . "' and estab = 0";
        $data_str = mssql__select($sql);

        $dados->no = $data_str[0]["no"];
    }

    $super_query = "
		BEGIN TRANSACTION;
		
		DECLARE @stamp VARCHAR(25);
		DECLARE @numero INT;
			
		SET @stamp = CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)));
		SET @numero = isnull((select max(mxid) + 1 from mx), 1);
			
		INSERT INTO 
			mx (mxstamp, origem, data, u_email, u_email2, u_tel, u_tel2, u_datareal, hinicio, clnome, clno, clestab, inicio, fim, hfim, u_horareal, texto, u_objet, nkeyid, ckeyid, coddiv, div, morada, local, codpost, vendedor, vendnm, eorigem, ousrinis, ousrdata, ousrhora, usrinis, usrdata, usrhora)
		VALUES
		(
			@stamp,
			'CL',
			'" . $dados->data . " 00:00:00.000',
			'" . $dados->email . "',
			'" . $dados->email2 . "',
			'" . $dados->telefone . "',
			'" . $dados->telefone2 . "',
			'" . $dados->data . " 00:00:00.000',
			'" . $dados->hora . ":" . $dados->minuto . "',
			isnull((select nome from cl where no = " . $dados->no . " and estab = 0),''),
			'" . $dados->no . "',
			0,
			" . (($dados->hora * 60) + ($dados->minuto)) . ",
			" . (($dados->hora * 60) + ($dados->minuto)) . ",
			'" . $dados->hora . ":" . $dados->minuto . "',
			'" . $dados->hora . ":" . $dados->minuto . "',
			'" . str_replace("'", "", urldecode($dados->relatorio)) . "',
			'" . str_replace("'", "", urldecode($dados->objetivos)) . "',
			@numero,
			'ADM'+CONVERT(VARCHAR(10), @numero),
			1,
			'Visita',
			isnull((select morada from cl where no = " . $dados->no . " and estab = 0),''),
			isnull((select local from cl where no = " . $dados->no . " and estab = 0),''),
			isnull((select codpost from cl where no = " . $dados->no . " and estab = 0),''),
			'" . $dados->vendedor . "',
			(select top 1 cmdesc from cm3 where cm = " . $dados->vendedor . "),
			'Windows',
			UPPER(suser_sname()),
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
			CONVERT(VARCHAR(5), GETDATE(), 8),
			UPPER(suser_sname()),
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
			CONVERT(VARCHAR(5), GETDATE(), 8)
		)
	";

    $super_query .= " COMMIT TRANSACTION; ";


    mssql__execute($super_query);

    $data_final = array();
    $data_final["success"] = 1;
    echo json_encode($data_final);
}

function encodeURIComponent($str) {
    $revert = array('%21' => '!', '%2A' => '*', '%27' => "'", '%28' => '(', '%29' => ')');
    return strtr(rawurlencode($str), $revert);
}

function re_encomenda($stamp, $user) {
    $str_sql = "
		select 
			bo.nome,
			bo.no,
			bo.ncont,
			bo.morada,
			bo.morada,
			bo.codpost,
			bo.local,
			bo2.email,
			bo2.telefone,
			bo.tpstamp,
			bo.obs,
			bo2.u_obsint,
			bo2.u_entnm,
			bo2.u_entmor,
			bo2.u_entcodp,
			bo2.u_entlocal,
			bo2.u_entemail,
			bo2.u_enttelf
		from bo
			inner join bo2 on bo.bostamp = bo2.bo2stamp
		where
			bo.bostamp = '$stamp'
	";

    $data = mssql__select($str_sql);
    $encomenda = $data[0];

    $inputs = array();

    $inputs["nome"] = trim($encomenda["nome"]);
    $inputs["no"] = trim($encomenda["no"]);
    $inputs["ncont"] = trim($encomenda["ncont"]);
    $inputs["morada"] = trim($encomenda["morada"]);
    $inputs["codpost"] = trim($encomenda["codpost"]);
    $inputs["local"] = trim($encomenda["local"]);
    $inputs["email"] = trim($encomenda["email"]);
    $inputs["telefone"] = trim($encomenda["telefone"]);

    $inputs["nome_ent"] = trim($encomenda["u_entnm"]);
    $inputs["morada_ent"] = trim($encomenda["u_entmor"]);
    $inputs["codpost_ent"] = trim($encomenda["u_entcodp"]);
    $inputs["local_ent"] = trim($encomenda["u_entlocal"]);
    $inputs["email_ent"] = trim($encomenda["u_entemail"]);
    $inputs["telefone_ent"] = trim($encomenda["u_enttelf"]);

    $inputs = encodeURIComponent(json_encode($inputs));

    if (trim($encomenda["tpstamp"]) != '') {
        $sel = encodeURIComponent(json_encode(trim($encomenda["tpstamp"])));
    } else {
        $sel = "%5B%5D";
    }

    if (trim($encomenda["obs"]) != '') {
        $txta = encodeURIComponent(json_encode(trim($encomenda["obs"])));
    } else {
        $txta = "%5B%5D";
    }

    if (trim($encomenda["u_obsint"]) != '') {
        $txta2 = encodeURIComponent(json_encode(trim($encomenda["u_obsint"])));
    } else {
        $txta2 = "%5B%5D";
    }

    $str_sql = "
		select
			bi.ref,
			st.design,
			bi.qtt,
			bi.epu,
			taxasiva.taxa,
			bi.desconto,
			bi.ettdeb,
			bi.u_obs
		from bi
			inner join st on bi.ref = st.ref
			inner join taxasiva on st.tabiva = taxasiva.codigo
		where
			bi.bostamp = '$stamp' and
			st.inactivo = 0
	";
    $data = mssql__select($str_sql);

    $table_str = '<thead>
		<tr>
			<th>Referência</th>
			<th>Designação</th>
			<th>Qtd</th>
			<th>PVF</th>
			<th>IVA</th>
			<th>PVF Total</th>
			<th>Desc.</th>
			<th>PVF Liq. Total</th>
			<th>Pack</th>
			<th></th>
		</tr>
	</thead><tbody>';

    foreach ($data as $linha) {

        $attrs = explode("|||", trim($linha["u_obs"]));
        $attr_str = "";
        $pack = "";
        foreach ($attrs as $attr) {
            $attr_tmp = explode("=", $attr);
            $attr_str .= $attr_tmp[0] . '="' . $attr_tmp[1] . '" ';

            if ($attr_tmp[0] == "pack") {
                $pack = $attr_tmp[1];
            }
        }

        $table_str .= '<tr ' . $attr_str . '>
		<td>' . trim($linha["ref"]) . '</td>
		<td>' . trim($linha["design"]) . '</td>
		<td><input type="text" class="txtboxToFilter" onkeyup="mudapreco(jQuery(this));" value="' . trim($linha["qtt"]) . '"></td>
		<td>' . number_format(floatval(trim($linha["epu"])), 2, '.', '') . '</td>
		<td>' . number_format(floatval(trim($linha["taxa"])), 2, '.', '') . '</td>
		<td>' . number_format((floatval(trim($linha["qtt"])) * floatval(trim($linha["epu"]))), 2, '.', '') . '</td>
		<td>' . number_format(floatval(trim($linha["desconto"])), 2, '.', '') . '%</td>
		<td>' . number_format(floatval(trim($linha["ettdeb"])), 2, '.', '') . '</td>
		<td>' . $pack . '</td>
		<td><button onclick="remove_artigo(jQuery(this).parent().parent())" type="button" class="btn btn-primary"><i class="white halflings-icon minus-sign"></i></button></td>
		</tr>';
    }

    $table_str .= '</tbody>';

    if (sizeof($data) > 0) {
        $table = encodeURIComponent(json_encode($table_str));
    } else {
        $table = "%5B%5D";
    }

    if ($inputs == "undefined") {
        $inputs = "%5B%5D";
    }
    if ($table == "undefined") {
        $table = "%5B%5D";
    }
    if ($txta == "undefined") {
        $txta = "%5B%5D";
    }
    if ($txta2 == "undefined") {
        $txta2 = "%5B%5D";
    }
    if ($sel == "undefined") {
        $sel = "%5B%5D";
    }

    $sql = "insert into enc_tmp (input, tabela, textarea, sel, data, user, reenc, textarea2) values ('$inputs', '$table', '$txta', '$sel', NOW(), " . $user . ", " . $user . ", '$txta2')";
    mysql__execute($sql);

    $tmp = array();
    $tmp["success"] = 1;

    echo json_encode($tmp);
}

function altera_visita($dados) {
    $data = array();

    $dados = urldecode($dados);
    $dados = json_decode($dados);

    $super_query = "
	UPDATE mx set 
		u_objet='" . str_replace("'", "", urldecode($dados->objetivos)) . "' ,texto='" . str_replace("'", "", urldecode($dados->relatorio)) . "' ,
		u_estado='1',
		hinicio = '" . $dados->hora1 . ":" . $dados->hora2 . "',
		hfim = '" . $dados->hora1 . ":" . $dados->hora2 . "',
		inicio = " . (($dados->hora1 * 60) + ($dados->hora2)) . ",
		fim = " . (($dados->hora1 * 60) + ($dados->hora2)) . ",
		data = '" . str_replace("-", "", $dados->data) . " 00:00:00.000'
	where mxstamp='" . $dados->stamp . "'";

    $super_query .= " COMMIT TRANSACTION; ";

    //WriteLog($super_query);
    mssql__execute($super_query);

    $data_final = array();
    $data_final["success"] = 1;
    echo json_encode($data_final);
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function utf8_encode_deep(&$input) {
    if (is_string($input)) {
        $input = utf8_encode($input);
    } else if (is_array($input)) {
        foreach ($input as &$value) {
            utf8_encode_deep($value);
        }

        unset($value);
    } else if (is_object($input)) {
        $vars = array_keys(get_object_vars($input));

        foreach ($vars as $var) {
            utf8_encode_deep($input->$var);
        }
    }
}

function utf8_decode_deep(&$input) {
    if (is_string($input)) {
        $input = utf8_decode($input);
    } else if (is_array($input)) {
        foreach ($input as &$value) {
            utf8_decode_deep($value);
        }
        //unset($value);
    } else if (is_object($input)) {
        $vars = array_keys(get_object_vars($input));

        foreach ($vars as $var) {
            utf8_decode_deep($input->$var);
        }
    }
}

function cria_encomenda($dados) {
    $data = array();

    $dados = urldecode($dados);
    $dados = json_decode($dados);
    utf8_decode_deep($dados);

    $sql = "select no from cl where ncont = '" . $dados->nif . "' and estab = 0";
    $data_str = mssql__select($sql);

    if (sizeof($data_str) > 0) {
        $dados->no = $data_str[0]["no"];
    }

    if ($dados->no == 0 || $dados->no == "") {
        //criar cliente
        $super_query = "
		BEGIN TRANSACTION;
		
		DECLARE @stamp VARCHAR(25);
		DECLARE @numero INT;
			
		SET @stamp = CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)));
		SET @numero = isnull((select max(no) + 1 from cl where estab = 0), 1);
			
		INSERT INTO CL (clstamp, no, estab, nome, morada, ncont, local, codpost, email, telefone, tipo, vendedor, vendnm, zona, area)
		VALUES 
		(
			@stamp,
			@numero,
			0,
			'" . $dados->nome . "',
			'" . $dados->morada . "',
			'" . $dados->nif . "',
			'" . $dados->local . "',
			'" . $dados->codpost . "',
			'" . $dados->email . "',
			'" . $dados->telefone . "',
			'" . utf8_decode('Farmácia') . "',
			'" . utf8_decode($_SESSION["user"]["id"]) . "',
			'" . utf8_decode($_SESSION["user"]["nicename"]) . "',
			'EUROPA',
			'PORTUGAL'
		)
		
		COMMIT TRANSACTION;
		";

        mssql__execute($super_query);

        $sql = "select no from cl where ncont = '" . $dados->nif . "' and estab = 0";
        $data_str = mssql__select($sql);

        $dados->no = $data_str[0]["no"];
    }

    $ndos = 1;
    $nmdos = "Encomenda de Cliente";

    $super_query = "
		BEGIN TRANSACTION;
		
		DECLARE @stamp VARCHAR(25);
		DECLARE @numero INT;
			
		SET @stamp = CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)));
		SET @numero = isnull((select max(obrano) + 1 from bo where ndos = " . $ndos . " and boano = YEAR(GETDATE())), 1);
			
		INSERT INTO 
			bo (bostamp, nmdos, ndos, no, estab, obrano, boano, dataobra, nome, morada, local, codpost, ncont, tpstamp, ousrinis, ousrdata, ousrhora, usrinis, usrdata, usrhora, memissao, moeda, origem, etotal, etotaldeb, u_descfin)
		VALUES
		(
			@stamp,
			'" . $nmdos . "',
			" . $ndos . ",
			" . $dados->no . ",
			0,
			@numero,
			YEAR(GETDATE()),
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
			'" . $dados->nome . "',
			isnull((select morada from cl where no = " . $dados->no . " and estab = 0),''),
			isnull((select local from cl where no = " . $dados->no . " and estab = 0),''),
			isnull((select codpost from cl where no = " . $dados->no . " and estab = 0),''),
			isnull((select ncont from cl where no = " . $dados->no . " and estab = 0),''),
			'" . $dados->tpstamp . "',
			UPPER(suser_sname()),
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
			CONVERT(VARCHAR(5), GETDATE(), 8),
			UPPER(suser_sname()),
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
			CONVERT(VARCHAR(5), GETDATE(), 8),
			'EURO',
			'EURO',
			'APPVENDEDOR',
			" . $dados->totalpvf . ",
			" . $dados->totalpvf . ",
			" . $dados->desconto_fin . "
		)
			
		INSERT INTO
			bo2 (bo2stamp, idserie, tiposaft, email, u_assinat, u_entnm, u_entmor, u_entcodp, u_entlocal, u_entemail, u_enttelf, u_obsenc, u_obsint)
		VALUES
		(
			@stamp,
			'BO',
			(select tiposaft from ts where ndos = " . $ndos . "),
			isnull((select email from cl where no = " . $dados->no . " and estab = 0),''),
			'" . $dados->assinatura . "',
			'" . $dados->nome_ent . "', 
			'" . $dados->morada_ent . "',
			'" . $dados->codpost_ent . "', 
			'" . $dados->local_ent . "', 
			'" . $dados->email_ent . "', 
			'" . $dados->telefone_ent . "',
			'" . $dados->obs . "',
			'" . $dados->obsint . "'
		)
	";

    $ordem = 10000;

    foreach ($dados->linhas as $linha) {
        $super_query .= "
		INSERT INTO
			bi (bistamp, bostamp, nmdos, ndos, no, obrano, rdata, ref, design, qtt, desconto, armazem, lordem, unidade, epcusto, epu, edebito, ettdeb, tabiva, iva, ousrinis, ousrdata, ousrhora, usrinis, usrdata, usrhora, stipo, rescli, resfor, resrec, resusr, u_obs)
		values
		(
			CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
			@stamp,
			'" . $nmdos . "',
			" . $ndos . ",
			" . $dados->no . ",
			@numero,
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
			'" . $linha->ref . "',
			'" . $linha->design . "',
			" . $linha->qtt . ",
			" . $linha->desc . ",
			1,
			" . $ordem . ",
			isnull((select unidade from st where ref = '" . $linha->ref . "'),''),
			isnull((select epcult from st where ref = '" . $linha->ref . "'),0),
			" . $linha->epv2 . ",
			" . $linha->epv2 . ",
			" . $linha->ettdeb . ",
			isnull((select tabiva from st where ref = '" . $linha->ref . "'), 0),
			isnull((select taxa from taxasiva where codigo = (select tabiva from st where ref = '" . $linha->ref . "')), 0),
			UPPER(suser_sname()),
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
			CONVERT(VARCHAR(5), GETDATE(), 8),
			UPPER(suser_sname()),
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
			CONVERT(VARCHAR(5), GETDATE(), 8),
			1,
			isnull((select rescli from ts where ndos =" . $ndos . "),0),
			isnull((select resfor from ts where ndos =" . $ndos . "),0),
			isnull((select resrec from ts where ndos =" . $ndos . "),0),
			isnull((select resusr from ts where ndos =" . $ndos . "),0),
			'" . $linha->attr . "'
		)
	";

        $ordem += 10000;
    }

    $super_query .= " COMMIT TRANSACTION; ";

    //WriteLog($super_query);
    mssql__execute($super_query);

    $super_query = "select top 1 bostamp, obrano from bo where ndos = " . $ndos . " and no = " . $dados->no . " order by dataobra desc, obrano desc";
    $data_str = mssql__select($super_query);
    $current_bostamp = $data_str[0]["bostamp"];
    $current_obrano = $data_str[0]["obrano"];

    require('phpmailer51/class.phpmailer.php');
    require('pdfcreator/fpdf.php');

    $w = array(18, 69, 15, 15, 15, 15, 15, 15, 15, 8);
    $al = array('L', 'L', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R');

    $filePath = './img/' . generateRandomString(15) . '.png';

    // Delete previously uploaded image
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    // Write $imgData into the image file
    $file = fopen($filePath, 'w');
    $imgData = base64_decode($dados->assinatura_file);
    fwrite($file, $imgData);
    fclose($file);

    class PDF extends FPDF {

        public $dados;
        public $current_obrano;
        public $current_bostamp;
        public $filePath;

        function Header() {
            $header = array(utf8_decode('Código'), utf8_decode('Designação'), 'Qtd', utf8_decode('PVF'), utf8_decode('Desc.'), utf8_decode('P. Unit.'), 'IVA', 'Total', 'PVP Rec.');
            $w = array(18, 69, 15, 15, 15, 15, 15, 15, 15, 8);
            $al = array('L', 'L', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R');

            $this->SetFont('Arial', 'B', 14);
            $this->Ln(10);
            $this->Cell(80, 10, utf8_decode('Encomenda de Cliente    Nº ') . $this->current_obrano, 0, 0, 'C');
            $this->Line(10, 28, 90, 28);
            $this->Ln(8);
            $this->SetFont('Arial', '', 7);
            $this->Cell(100, 10, 'ORIGINAL', 0, 0, 'C');
            $this->Image('./img/logo.png', 135, 6, 50);
            $this->Ln(8);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(80, 10, 'VELVET MED - HEALTHCARE SOLUTIONS, S.A.', 0, 0, 'C');
            $this->Ln(8);
            $this->SetFont('Arial', '', 6);
            $this->Cell(3);
            $this->Cell(80, 10, 'NIB: 0010 0000 49665130001 59', 0, 0, 'L');
            $this->Ln(5);
            $this->Cell(3);
            $this->Cell(80, 10, 'IBAN: PT50 0010 0000 4966 5130 0015 9', 0, 0, 'L');
            $this->Ln(5);
            $this->Cell(3);
            $this->Cell(80, 10, 'SWIFT / BIC: BBPIPTPL', 0, 0, 'l');

            $this->SetFont('Arial', 'B', 9);
            $this->Cell(20);
            $this->Cell(80, 10, $this->dados->nome, 0, 0, 'l');
            $this->SetFont('Arial', '', 7);
            $this->Ln(5);
            $this->Cell(3);
            $this->Cell(100, 10, utf8_decode('No descritivo da transferência, coloque sempre,'));
            $this->SetFont('Arial', '', 9);
            $this->Cell(80, 10, $this->dados->morada, 0, 0, 'l');
            $this->Ln(5);
            $this->Cell(3);
            $this->SetFont('Arial', '', 7);
            $this->Cell(100, 10, utf8_decode('por favor, o número desta Nota de Encomenda'));
            $this->SetFont('Arial', '', 9);
            $this->Cell(80, 10, $this->dados->codpost, 0, 0, 'l');
            $this->Ln(5);
            $this->Cell(103);
            $this->Cell(80, 10, $this->dados->local, 0, 0, 'l');

            $this->Ln(10);
            $this->Line(10, 85, 199, 85);
            $this->SetFont('Arial', '', 8);
            $this->Ln(5);
            $this->Cell(5);
            $this->Cell(40, 10, 'Data: ' . date("d-m-Y"), 0, 0, 'l');
            $this->Cell(15);
            $this->Cell(100, 10, utf8_decode('Condições Pagamento: ') . $this->dados->tpdesc, 0, 0, 'l');
            $this->Cell(80, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'l');

            $this->Ln(8);

            // Column widths
            $this->SetFont('Arial', 'B', 6);
            // Header
            for ($i = 0; $i < count($header); $i++)
                $this->Cell($w[$i], 7, $header[$i], 0, 0, $al[$i]);
            $this->Ln();
        }

        function Footer() {
            $this->SetY(-80);
            $this->SetFont('Arial', '', 7);
            $this->MultiCell(130, 5, utf8_decode('Observações: ' . trim($this->dados->obsint)), 0, 'L');
            $this->Cell(65, 60, $this->Image($this->filePath, $this->GetX(), $this->GetY(), 60, 30), 0, 0, 'L');
            $this->SetFont('Arial', '', 10);
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetXY($x + 70, $y);
            $this->SetFont('Arial', '', 10);
            $this->Cell(60, 10, 'PVF Total: ' . number_format($this->dados->totalpvf, 2) . ' Euros', 0, 0, 'R');
            $this->SetXY($x + 70, $y + 5);
            $this->Cell(60, 10, 'Desconto: ' . number_format($this->dados->desconto, 2) . ' Euros', 0, 0, 'R');
            $this->SetXY($x + 70, $y + 10);
            $this->Cell(60, 10, 'Total Liquido: ' . number_format($this->dados->totalliq, 2) . ' Euros', 0, 0, 'R');
            $this->SetXY($x + 70, $y + 15);
            $this->Cell(60, 10, 'IVA: ' . number_format($this->dados->iva, 2) . ' Euros', 0, 0, 'R');
            $this->SetXY($x + 70, $y + 20);
            $this->Cell(60, 10, 'Desconto Fin.: ' . number_format((($this->dados->totalliq + $this->dados->iva) - (($this->dados->totalliq + $this->dados->iva) * (1 - $this->dados->desconto_fin / 100))), 2) . ' Euros', 0, 0, 'R');
            $this->SetXY($x + 70, $y + 30);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(60, 10, 'Total Documento: ' . number_format($this->dados->totaldoc, 2) . ' Euros', 0, 0, 'R');
            $this->Ln(1);
            $this->Line($this->GetX(), $this->GetY(), $this->GetX() + 60, $this->GetY());
            $this->Cell(10, 5, '', 0, 0, 'L');
            $this->Cell(0, 5, 'Assinatura cliente', 0, 0, 'L');
            $this->Ln(10);
            $this->SetFont('Arial', '', 7);
            $this->Cell(0, 10, 'VELVET MED - HEALTHCARE | NIPC:510686516 | Capital Social:100.000,00 Euros | Conserv.Reg.Com: Benavente | CAE:46460', 0, 0, 'C');
            $this->Ln(5);
            $this->Cell(0, 10, 'Estrada Nacional 118, Km 38,8 | 2130-073 Benavente, Portugal | Tel.: (+351) 23981143 | www.velvet-med.pt | geral@velvet-med.pt', 0, 0, 'C');
            $this->Ln(5);
        }

    }

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->dados = $dados;
    $pdf->current_bostamp = $current_bostamp;
    $pdf->current_obrano = $current_obrano;
    $pdf->filePath = $filePath;
    $pdf->SetTitle('Encomenda Velvet Med');
    $pdf->SetCompression(false);
    $pdf->AddPage();
    $pdf->SetAutoPageBreak(true, '50');

    $pdf->SetFont('Arial', '', 6);
    $num_rows = 0;
    foreach ($dados->linhas as $linha) {
        $pdf->Cell($w[0], 6, $linha->ref, 0);
        $pdf->Cell($w[1], 6, $linha->design, 0);
        $pdf->Cell($w[2], 6, number_format($linha->qtt, 2), 0, 0, 'R');
        $pdf->Cell($w[3], 6, number_format($linha->epv2, 2), 0, 0, 'R');
        $pdf->Cell($w[4], 6, number_format($linha->desc, 2), 0, 0, 'R');
        $pdf->Cell($w[4], 6, number_format($linha->epv2 * (1 - ($linha->desc / 100)), 2), 0, 0, 'R');

        $sql = "select taxa from taxasiva inner join st on taxasiva.codigo = st.tabiva where st.ref = '" . trim($linha->ref) . "'";
        $taxa = mssql__select($sql);

        if (sizeof($taxa) > 0) {
            $taxa = $taxa[0]["taxa"];
        } else {
            $taxa = 0;
        }

        $pdf->Cell($w[4], 6, number_format($taxa, 2), 0, 0, 'R');


        $pdf->Cell($w[6], 6, number_format($linha->ettdeb, 2), 0, 0, 'R');

        $sql = "select epv1 from st where ref = '" . trim($linha->ref) . "'";
        $pvprec = mssql__select($sql);

        if (sizeof($pvprec) > 0) {
            $pvprec = $pvprec[0]["epv1"];
        } else {
            $pvprec = 0;
        }

        $pdf->Cell($w[5], 6, number_format($pvprec, 2), 0, 0, 'R');

        $super_query = "select stock from st where ref = '" . $linha->ref . "'";
        $stock_atual = mssql__select($super_query);
        $stock_atual = $stock_atual[0]["stock"];

        //stock
        if (intval($stock_atual) <= 0) {
            $pdf->Cell($w[5], 6, $pdf->Image('./img/icon_red.png', $pdf->GetX(), $pdf->GetY() + 1.6, 2, 2), 0, 0, 'R');
        } else if (intval($stock_atual) < 50) {
            $pdf->Cell($w[5], 6, $pdf->Image('./img/icon_orange.png', $pdf->GetX(), $pdf->GetY() + 1.6, 2, 2), 0, 0, 'R');
        } else {
            $pdf->Cell($w[5], 6, $pdf->Image('./img/icon_green.png', $pdf->GetX(), $pdf->GetY() + 1.6, 2, 2), 0, 0, 'R');
        }

        $pdf->Ln();

        $num_rows++;
        $page_height = 279.4;
        $bottom_margin = 5;
        $space_left = $page_height - $pdf->GetY();
        $space_left -= $bottom_margin;
        $height_of_cell = ceil($num_rows * 4);
        if ($height_of_cell >= $space_left) {
            $num_rows = 0;
            $pdf->AddPage(); // page break.
            // $pdf->Cell(100,5,'','B',2); // this creates a blank row for formatting reasons
        }
    }

    $pdf->Cell(80);
    // $pdf->Ln(20);

    $cur_ano = date('y');

    $pdf->Output('F', 'pdf/encomenda_' . $cur_ano . '_' . $current_obrano . '.pdf');

    unlink($filePath);

    $credenciais_email_username = 'encomendas@velvet-med.pt';
    $credenciais_email_password = 'vm2013!+';
    $credenciais_email_host = 'mail.velvet-med.pt';
    $credenciais_from = 'encomendas@velvet-med.pt';

    //enviar email Velvet
    $mail = new PHPMailer;
    $mail->isSMTP();                                          // Set mailer to use SMTP
    $mail->Host = $credenciais_email_host;            // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                                   // Enable SMTP authentication
    $mail->Username = $credenciais_email_username;
    $mail->Password = $credenciais_email_password;
    $mail->CharSet = 'UTF-8';
    $mail->setFrom($credenciais_from, 'Velvet Med');
    $mail->AddBCC('encomendas@velvet-med.pt', '');

    $mail->addAttachment('./pdf/encomenda_' . $cur_ano . '_' . $current_obrano . '.pdf', 'encomenda_' . $cur_ano . '_' . $current_obrano . '.pdf');
    $mail->isHTML(true);                                      // Set email format to HTML
    $mail->Subject = 'VELVET MED - Encomenda Nº ' . $current_obrano;
    $mail->Body = '
	<html>
		<body>
			<p>Nova encomenda realizada através da aplicação de vendedores. Encomenda registada com o nº ' . $current_obrano . '.</p>
			<p>A encomenda segue em anexo.</p><br><br>
			<p>Velvet Med</p>
		</body>
	</html>
	';
    $mail->send();

    //enviar email Cliente
    $mail = new PHPMailer;
    $mail->isSMTP();                                          // Set mailer to use SMTP
    $mail->Host = $credenciais_email_host;            // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                                   // Enable SMTP authentication
    $mail->Username = $credenciais_email_username;
    $mail->Password = $credenciais_email_password;
    $mail->CharSet = 'UTF-8';
    $mail->setFrom($credenciais_from, 'Velvet Med');
    $envia_cliente = 0;

    if (trim($dados->email) != '' && filter_var(trim($dados->email), FILTER_VALIDATE_EMAIL)) {
        $envia_cliente = 1;
        $mail->AddCC(trim($dados->email), '');
    }
    if (trim($dados->email_ent) != '' && filter_var(trim($dados->email_ent), FILTER_VALIDATE_EMAIL)) {
        $envia_cliente = 1;
        $mail->AddCC(trim($dados->email_ent), '');
    }

    $envia_cliente = 1;
    $mail->AddBCC('tiago.loureiro@novoscanais.com', '');

    $mail->addAttachment('./pdf/encomenda_' . $cur_ano . '_' . $current_obrano . '.pdf', 'encomenda_' . $cur_ano . '_' . $current_obrano . '.pdf');
    $mail->isHTML(true);                                      // Set email format to HTML
    $mail->Subject = 'VELVET MED - Encomenda Nº ' . $current_obrano;
    $mail->Body = '
	<html>
		<body>
			<p>Exmo(a). Sr(a). Dr(a).,</p>
			<p>Desde já agradecemos a confiança nos nossos produtos. </p>
			<p>Enviamos em anexo a nota de encomenda feita à nossa colega ' . $_SESSION["user"]['nicename'] . '.</p><br/>
			<p>Melhores cumprimentos,</p>
			<p><b>VELVET MED - HEALTHCARE SOLUTIONS, S.A.</b></p>
		</body>
	</html>
	';
    if ($envia_cliente) {
        $mail->send();
    }

    //enviar email vendedor
    $mail = new PHPMailer;
    $mail->isSMTP();                                          // Set mailer to use SMTP
    $mail->Host = $credenciais_email_host;            // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                                   // Enable SMTP authentication
    $mail->Username = $credenciais_email_username;
    $mail->Password = $credenciais_email_password;
    $mail->CharSet = 'UTF-8';
    $mail->setFrom($credenciais_from, 'Velvet Med');
    $envia_vendedor = 0;

    if (trim($_SESSION["user"]['email']) != '' && filter_var(trim($_SESSION["user"]['email']), FILTER_VALIDATE_EMAIL)) {
        $envia_vendedor = 1;
        $mail->AddCC(trim($_SESSION["user"]['email']));
    }
    $envia_vendedor = 1;
    $mail->AddBCC('tiago.loureiro@novoscanais.com', '');

    $mail->addAttachment('./pdf/encomenda_' . $cur_ano . '_' . $current_obrano . '.pdf', 'encomenda_' . $cur_ano . '_' . $current_obrano . '.pdf');
    $mail->isHTML(true);                                      // Set email format to HTML
    $mail->Subject = 'VELVET MED - Encomenda Nº ' . $current_obrano;
    $mail->Body = '
	<html>
		<body>
			<p>Nova encomenda registada com o nº ' . $current_obrano . '.</p>
			<p>A encomenda segue em anexo.</p><br><br>
			<p>Velvet Med</p>
		</body>
	</html>
	';
    if ($envia_vendedor) {
        $mail->send();
    }

    //apagar ficheiro
    unlink('./pdf/encomenda_' . $cur_ano . '_' . $current_obrano . '.pdf');

    $data_final = array();
    $data_final["success"] = 1;
    echo json_encode($data_final);
}

function get_relatorio_inter($mhstamp) {
    $sql = "select top 1 relatorio from mh where mhstamp = '$mhstamp'";
    // WriteLog($sql);
    $data = mssql__select($sql);
    echo json_encode($data);
}

function apaga_visita($stamp) {

    $stamp = urldecode($stamp);
    utf8_decode_deep($stamp);

    $sql = "delete from mx where mxstamp = '$stamp'";
    mssql__execute($sql);

    $tmp = array();
    $tmp["success"] = 1;

    echo json_encode($tmp);
}

function apaga_encomenda_tmp() {
    $sql = "delete from enc_tmp";
    mysql__execute($sql);

    $tmp = array();
    $tmp["success"] = 1;

    echo json_encode($tmp);
}

function grava_encomenda_tmp($input, $table, $txta, $sel, $id, $txta2) {
    // $sql = "delete from enc_tmp";
    // mysql__execute($sql);

    if ($input == "undefined") {
        $input = "%5B%5D";
    }
    if ($table == "undefined") {
        $table = "%5B%5D";
    }
    if ($txta == "undefined") {
        $txta = "%5B%5D";
    }
    if ($txta2 == "undefined") {
        $txta2 = "%5B%5D";
    }
    if ($sel == "undefined") {
        $sel = "%5B%5D";
    }

    $sql = "insert into enc_tmp (input, tabela, textarea, sel, data, user, textarea2) values ('$input', '$table', '$txta', '$sel', NOW(), $id, '$txta2')";
    mysql__execute($sql);

    $tmp = array();
    $tmp["success"] = 1;

    echo json_encode($tmp);
}

function get_encomenda_tmp($id) {
    $sql = "select * from enc_tmp where id = $id";
    $data = mysql__select($sql);
    $sql = "delete from enc_tmp where id = $id";
    mysql__execute($sql);
    echo json_encode($data);
}

function get_reencomenda_tmp($id) {
    $sql = "select * from enc_tmp where reenc = $id";
    $data = mysql__select($sql);
    $sql = "delete from enc_tmp where reenc = $id";
    mysql__execute($sql);
    echo json_encode($data);
}

function get_encomendas_gravadas($id) {
    $sql = "select * from enc_tmp where user = '" . $id . "'";
    $data = mysql__select($sql);
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

function get_cliente($no) {

    $filtro_user = "and vendedor = " . $_SESSION["user"]["id"];
    if ($_SESSION["user"]["id"] == 2) {
        $filtro_user = "";
    }

    $str_sql = "
		select 
			*,
			isnull((select top 1 u_objet from mx where clno = cl.no and clestab = 0 order by u_datareal desc, u_horareal desc), '') obj
		from cl
		where
			no = $no and estab = 0 " . $filtro_user . " 
		";

    $data = mssql__select($str_sql);
    echo json_encode($data);
}

function get_visita($stamp) {
    $stamp = trim($stamp);
    $str_sql = "
		select 
			*,ncont
		from mx(nolock)
			left join cl (nolock) on mx.clno = cl.no
		where
			mxstamp = '$stamp' and mx.vendedor = " . $_SESSION["user"]["id"] . " 
		";

    $data = mssql__select($str_sql);
    echo json_encode($data);
}

function get_artigo($ref) {
    $str_sql = "
		select 
			ref, design, epv2, taxasiva.taxa taxa
		from st inner join taxasiva on st.tabiva = taxasiva.codigo
		where
			ref = '$ref'
		";

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

function tabela_encomendas($cliente, $datai, $dataf, $num_encomenda, $estado) {
    $str_sql = "
		SELECT
			*
		FROM 
			bo (nolock)
			inner join cl on bo.no = cl.no
		WHERE
			ndos = 1 and cl.estab = 0 and cl.tipo = 'Farmácia' and cl.vendedor = " . $_SESSION["user"]["id"] . " 
		";

    $where_ar = array();

    if ($cliente != "") {
        $where_ar[] = " (nome like '%$cliente%' or CONVERT(VARCHAR(50), no) like '%$cliente%') ";
    }

    if ($num_encomenda != '') {
        $where_ar[] = " obrano = '$num_encomenda' ";
    }

    if ($datai != '') {
        $where_ar[] = " dataobra >= '$datai' ";
    }

    if ($dataf != '') {
        $where_ar[] = " dataobra <= '$dataf' ";
    }

    if ($estado != '') {
        $where_ar[] = " fechada = '$estado' ";
    }

    $and_separated = implode("and", $where_ar);

    if (sizeof($where_ar) > 0) {
        $str_sql .= " AND " . $and_separated;
    }

    // echo $str_sql;

    $data = mssql__select($str_sql);
    echo json_encode($data);
}

function tabela_visitas($cliente, $datai, $dataf, $utilizador) {
    $str_sql = "
		SELECT
			*
		FROM 
			mx (nolock)
			inner join cl on mx.clno = cl.no
		WHERE 
		";

    $where_ar = array();

    $where_ar[] = " cl.estab = 0 ";
    $where_ar[] = " cl.tipo = 'Farmácia' ";
    $where_ar[] = " mx.vendedor = " . $_SESSION["user"]["id"] . " ";

    if ($cliente != "") {
        $where_ar[] = " mx.clnome like '%$cliente%' ";
    }

    if ($datai != '') {
        $where_ar[] = " mx.data >= '$datai' ";
    }

    if ($dataf != '') {
        $where_ar[] = " mx.data <= '$dataf' ";
    }

    $and_separated = implode("and", $where_ar);

    if (sizeof($where_ar) > 0) {
        $str_sql .= " " . $and_separated;
    }

    // echo $str_sql;
    // WriteLog($str_sql);

    $data = mssql__select($str_sql);
    echo json_encode($data);
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
				WHEN cc.moeda='EURO' OR cc.moeda=space(11) THEN abs((cc.edeb-cc.edebf)-(cc.ecred-cc.ecredf)) 
				ELSE abs((cc.debm-cc.debfm)-(cc.credm-cc.credfm)) END) > (CASE WHEN cc.moeda='EURO' OR cc.moeda=space(11) THEN 0.010000 ELSE 0 END)
	ORDER BY 
		cc.datalc,
		cc.cm,
		cc.nrdoc";

    $data = mssql__select($sql);

    echo json_encode($data);
}

function get_familia_produtos() {

    $sql = "
		select distinct rtrim(ltrim(u_famsite)) familia
		from st
		where U_PRODVM = 1 and rtrim(ltrim(u_famsite)) <> '' and inactivo = 0
	";

    $data = mssql__select($sql);

    echo json_encode($data);
}

function tabela_clientes($num, $nome, $order = 'no') {
    $str_sql = "";

    $filtro_user = "and vendedor = " . $_SESSION["user"]["id"];
    if ($_SESSION["user"]["id"] == 2) {
        $filtro_user = "";
    }

    if ($num == "" and $nome == "")
        $str_sql = "
			SELECT 
				*
			FROM 
				cl
			WHERE 
				estab = 0 and tipo = 'Farmácia' " . $filtro_user . " 
			order by
				" . $order;
    else {
        $str_sql = "
			SELECT 
				*
			FROM 
				cl  
			WHERE 
				estab = 0 and tipo = 'Farmácia' AND no LIKE '%" . $num . "%' and nome LIKE '%" . $nome . "%' " . $filtro_user . " 
			ORDER BY 
				" . $order;
    }

    $data = mssql__select($str_sql);
    echo json_encode($data);
}

function tabela_clientes_2($num, $order = 'no') {
    $str_sql = "";

    $filtro_user = "and vendedor = " . $_SESSION["user"]["id"];
    if ($_SESSION["user"]["id"] == 2) {
        $filtro_user = "";
    }

    if ($num == "")
        $str_sql = "
			SELECT 
				*
			FROM 
				cl
			WHERE 
				estab = 0 and tipo = 'Farmácia' " . $filtro_user . " 
			order by
				" . $order;
    else {
        $num = explode(" ", $num);

        $str_sql = "
			SELECT 
				*
			FROM 
				cl  
			WHERE 
				estab = 0 and tipo = 'Farmácia' " . $filtro_user . " 
			";

        foreach ($num as $value) {
            $str_sql .= "AND (no LIKE '%" . $value . "%' or nome LIKE '%" . $value . "%' or ncont LIKE '%" . $value . "%' or local LIKE '%" . $value . "%' or codpost LIKE '%" . $value . "%') ";
        }

        $str_sql .= "
			ORDER BY 
				" . $order;
    }

    $data = mssql__select($str_sql);
    echo json_encode($data);
}

function tabela_artigos_velvet() {
    $str_sql = "
		select
			u_packstamp ,
			pack,
			minun
		from u_pack where inactivo = 0
		order by ordem
	";

    $data = mssql__select($str_sql);

    $str_sql = "
		select
			a.u_packstamp,
			a.ref,
			b.design,
			b.epv2 pvf,
			a.desconto,
			a.minun,
			round((b.epv2 * (1-(a.desconto/100))),2) custoun,
			b.epv1 pvprec,
			round((b.epv1/(1+(c.taxa/100))-(b.epv2 * (1-(a.desconto/100)))),2) rentunit,
			round(((b.epv1/(1+(c.taxa/100))-(b.epv2 * (1-(a.desconto/100)))) / 
				case 
					when (b.epv2 * (1-(a.desconto/100))) = 0 then (case when (b.epv1/(1+(c.taxa/100))-(b.epv2 * (1-(a.desconto/100)))) = 0 then 1 else (b.epv1/(1+(c.taxa/100))-(b.epv2 * (1-(a.desconto/100)))) end)
					else (b.epv2 * (1-(a.desconto/100))) 
				end),2) rentunit_percent,
			b.stock
		from u_packref a
			inner join st b on a.ref = b.ref
			inner join taxasiva c on b.tabiva = c.codigo
		where
			b.inactivo = 0
		order by
			b.design
	";

    $data2 = mssql__select($str_sql);

    $tmp = array();
    $tmp["pack"] = $data;
    $tmp["artigos"] = $data2;

    echo json_encode($tmp);
}

function save_client($no, $data) {
    $data = json_decode($data);

    $str_sql = "
	update cl
	set
		nome = '" . utf8_decode($data[0]) . "',
		morada = '" . utf8_decode($data[1]) . "',
		codpost = '" . utf8_decode($data[2]) . "',
		local = '" . utf8_decode($data[3]) . "',
		telefone = '" . utf8_decode($data[4]) . "',
		tlmvl = '" . utf8_decode($data[5]) . "',
		email = '" . utf8_decode($data[7]) . "',
		fax = '" . utf8_decode($data[6]) . "',
		obs = '" . utf8_decode($data[8]) . "'
	where
		no = $no and estab = 0
	";

    mssql__execute($str_sql);

    $str_sql = "
	update cl2
	set
		u_mercdest = '" . utf8_decode($data[9]) . "',
		u_brickmun = '" . utf8_decode($data[10]) . "'
	from cl2
	inner join cl on cl.clstamp = cl2.cl2stamp and cl.no = $no and cl.estab = 0
	";

    mssql__execute($str_sql);
}

function tabela_artigos_2($num, $order = 'ref') {
    $str_sql = "";

    if ($num == "")
        $str_sql = "
			SELECT 
				ref, design, epv2, stock, u_famsite
			FROM 
				st
			WHERE 
				U_REPRESEN = 1 and inactivo = 0 
			order by
				" . $order;
    else {
        $str_sql = "
			SELECT 
				ref, design, epv2, stock, u_famsite
			FROM 
				st
			WHERE 
				U_REPRESEN = 1 and inactivo = 0 AND (ref LIKE '%" . $num . "%' or design LIKE '%" . $num . "%') 
			ORDER BY 
				" . $order;
    }

    $data = mssql__select($str_sql);
    echo json_encode($data);
}

//******************************** CALENDARIO ***********************************

if (isset($_POST['func']) && !empty($_POST['func'])) {
    switch ($_POST['func']) {
        case 'getCalender':
            getCalender1($_POST['year'], $_POST['month']);
            break;
        case 'getEvents':
            getEvents($_POST['date']);
            break;
        default:
            break;
    }
}

function getCalender1($ano, $mes) {
    getCalender($ano, $mes);
}

function getCalender($year = '', $month = '') {

    $dateYear = ($year != '') ? $year : date("Y");
    $dateMonth = ($month != '') ? $month : date("m");
    $date = $dateYear . '-' . $dateMonth . '-01';
    $currentMonthFirstDay = date("N", strtotime($date));
    $totalDaysOfMonth = cal_days_in_month(CAL_GREGORIAN, $dateMonth, $dateYear);
    $totalDaysOfMonthDisplay = ($currentMonthFirstDay == 7) ? ($totalDaysOfMonth) : ($totalDaysOfMonth + $currentMonthFirstDay);
    $boxDisplay = ($totalDaysOfMonthDisplay <= 35) ? 35 : 42;
    ?>
    <div id="calender_section">
        <h2>
            <a href="javascript:void(0);" onclick="getCalendar('calendar_div', '<?php echo date("Y", strtotime($date . ' - 1 Month')); ?>', '<?php echo date("m", strtotime($date . ' - 1 Month')); ?>');">&lt;&lt;</a>
            <select name="month_dropdown" class="month_dropdown dropdown"><?php echo getAllMonths($dateMonth); ?></select>
            <select name="year_dropdown" class="year_dropdown dropdown"><?php echo getYearList($dateYear); ?></select>
            <a href="javascript:void(0);" onclick="getCalendar('calendar_div', '<?php echo date("Y", strtotime($date . ' + 1 Month')); ?>', '<?php echo date("m", strtotime($date . ' + 1 Month')); ?>');">&gt;&gt;</a>
        </h2>
        <div id="event_list" class="none"></div>
        <table style="width: 100%;" >
            <tr  style="margin: 0 0 0px 0px;">
                <td id="calender_section_top">Domingo</td>
                <td id="calender_section_top">Segunda</td>
                <td id="calender_section_top">Terça</td>
                <td id="calender_section_top">Quarta</td>
                <td id="calender_section_top">Quinta</td>
                <td id="calender_section_top">Sexta</td>
                <td id="calender_section_top">Sábado</td>
            </tr>

            <?php
            $countdias = 0;
            $dayCount = 1;
            for ($cb = 1; $cb <= $boxDisplay; $cb++) {
                if ($countdias == 0)
                    echo '<tr >';

                if (($cb >= $currentMonthFirstDay + 1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)) {
                    //Current date

                    $currentDate = $dateYear . '-' . $dateMonth . '-' . $dayCount;
                    $eventNum = 0;
                    $query = "select * from mx where data = '" . $currentDate . "' and vendedor=" . $_SESSION["user"]["id"];
                    $query2 = "select * from mx where data = '" . $currentDate . "' and u_estado='0' and vendedor=" . $_SESSION["user"]["id"];
                    //Get number of events based on the current date
                    //$result = $db->query("SELECT title FROM events WHERE date = '".$currentDate."' AND status = 1");
                    //$eventNum = $result->num_rows;

                    $result = mssql__select($query);
                    $result2 = mssql__select($query2);
                    $eventNum = sizeof($result);
                    $eventNum2 = sizeof($result2);

                    //Define date cell color
                    if (strtotime($currentDate) == strtotime(date("Y-m-d"))) {
                        echo '<td valign="top" id="calender_section_bot" date="' . $currentDate . '" class="grey date_cell">';
                    } elseif ($eventNum > 0 && $eventNum2 > 0) {
                        echo '<td valign="top" style="background: rgba(244, 67, 54, 0.51);" id="calender_section_bot" date="' . $currentDate . '" class="light_sky date_cell">';
                    } elseif ($eventNum > 0 && $eventNum2 == 0) {
                        echo '<td valign="top" style="background: rgba(0, 128, 0, 0.45)" id="calender_section_bot" date="' . $currentDate . '" class="light_sky date_cell">';
                    } else {
                        echo '<td valign="top" id="calender_section_bot" date="' . $currentDate . '" class="date_cell">';
                    }
                    //Date cell
                    echo '<span><b>';
                    echo $dayCount;
                    echo '</span></b><br>';

                    foreach ($result as &$value) {
                        $teste = $value["mxstamp"];
                        $estado = $value["u_estado"];
                        echo "<br><a onclick='modal(\"$teste\",\"$estado\")' style='font-size:10px; float: left; margin-left:2px;'>" . substr($value['clnome'], 0, 16) . "...</a>
					<a onclick='modal(\"$teste\",\"$estado\")'><b style='margin-right:2px; font-size:10px; float: right;'>" . $value['hinicio'] . "</b></a>";
                    }

                    //Hover event popup
                    //echo '<div id="date_popup_'.$currentDate.'" class="date_popup_wrap none">';
                    //echo '<div class="date_window">';
                    //echo '<div class="popup_event">Events ('.$eventNum.')</div>';
                    //echo ($eventNum > 0)?'<a href="javascript:;" onclick="getEvents(\''.$currentDate.'\');">view events</a>':'';
                    //echo '</div></div>';

                    echo '</td>';


                    $dayCount++;
                    ?>
                <?php } else { ?>
                    <td><span>&nbsp;</span></td>
                    <?php
                }
                if ($countdias != 6) {
                    $countdias++;
                } else if ($countdias == 6) {
                    $countdias = 0;
                } else if ($countdias == 0) {
                    echo '</tr>';
                }
            }
            ?>	

        </table>

        <script type="text/javascript">
            $(document).ready(function () {
                /*$('.date_cell').mouseenter(function(){
                 date = $(this).attr('date');
                 $(".date_popup_wrap").fadeOut();
                 $("#date_popup_"+date).fadeIn();	
                 });
                 $('.date_cell').mouseleave(function(){
                 $(".date_popup_wrap").fadeOut();		
                 });*/
                $('.month_dropdown').on('change', function () {
                    getCalendar('calendar_div', $('.year_dropdown').val(), $('.month_dropdown').val());
                });
                $('.year_dropdown').on('change', function () {
                    getCalendar('calendar_div', $('.year_dropdown').val(), $('.month_dropdown').val());
                });
                $(document).click(function () {
                    $('#event_list').slideUp('slow');
                });
            });
        </script>


        <?php
    }

    /*
     * Get calendar full HTML
     */

    /*
     * Get months options list. */

    function getAllMonths($selected = '') {
        $options = '';
        for ($i = 1; $i <= 12; $i++) {
            setlocale(LC_ALL, 'Portuguese_Portugal.1252');
            date_default_timezone_set('europe/lisbon');
            $value = ($i < 10) ? '0' . $i : $i;
            $selectedOpt = ($value == $selected) ? 'selected' : '';
            $options .= '<option value="' . $value . '" ' . $selectedOpt . ' >' . utf8_encode(strftime("%B", mktime(0, 0, 0, $i + 1, 0, 0))) . '</option>';
        }
        return $options;
    }

    /*
     * Get years options list.
     */

    function getYearList($selected = '') {
        $options = '';
        for ($i = 2015; $i <= 2025; $i++) {
            $selectedOpt = ($i == $selected) ? 'selected' : '';
            $options .= '<option value="' . $i . '" ' . $selectedOpt . ' >' . $i . '</option>';
        }
        return $options;
    }
    ?>