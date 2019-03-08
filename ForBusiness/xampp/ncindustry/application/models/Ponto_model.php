<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Ponto_model extends CI_Model {

    /**
     * __construct function.
     * 
     * @access public
     * @return void
     */
    public function __construct() {
        $this->load->model('user_model', 'user');
        $this->load->model('dossier_model', 'dossier');
        $this->load->model('nci_model', 'nci');
        parent::__construct();
        $this->load->database();
    }

    //Procura produtos ativos con stfamistamp
    public function get_familia_produtos($stamp) {
        $query = "	
            select st.ststamp, st.ref, st.design, st.familia, st.u_ativonci, st.imagem, stfami.stfamistamp
            from st (nolock)
                inner join stfami (nolock) on st.familia = stfami.ref
            where 
               st.u_ativonci = 1 and
               stfami.stfamistamp = '" . $stamp . "'
        ";
        $sql_status = $this->mssql->mssql__select($query);

        return $sql_status;
    }

    //Procura familias ativas
    public function get_familias() {
        $query = "	
            select stfamistamp,ref, nome, imgqlook, u_ativonci
            from stfami 
            where
                u_ativonci = 1
            order by 
                nome DESC
        ";
        $sql_status = $this->mssql->mssql__select($query);

        return $sql_status;
    }

    //Procura campo no Dytable
    public function get_dytable() {
        $query = " 
            select dytablestamp, campo, entityname
            from dytable
            where	
                entityname = 'a_stdtipo'
            order by
                campo			
        ";
        $sql_status = $this->mssql->mssql__select($query);

        return $sql_status;
    }

    //procura produtos tarefas - tabela
    public function get_produtos_tabela() {
        $this->load->model('nci_model', 'nci');
        $data = array();
        $data["u_ncidef"] = $this->nci->getU_ncidef(array())[0];

        $query = " 
            select *
            from " . $data["u_ncidef"]['tarefastabela'] . "
            where inactivo = 0
            order by design
        ";

        return $this->mssql->mssql__select($query);
    }

    //vai buscar produtos ao dossier selecionado
    public function get_produtos_dossier() {
        $this->load->model('dossier_model', 'dossier');
        $this->load->model('nci_model', 'nci');

        $data = array();
        $data["u_ncidef"] = $this->nci->getU_ncidef(array())[0];

        $query = "
            select bi.bistamp, bi.ref, bi.design
            from bi
            inner join bo on bo.bostamp = bi.bostamp
            where bo.ndos = '" . $data["u_ncidef"]['ndostarefas'] . "'
        ";
        $sql_status = $this->mssql->mssql__select($query);
        return $sql_status;
    }

    //Procura se há tmp_produtos para uma $_SESSION['token_temp'] = RANDOM
    public function search_tmp_produtos($ststamp) {
        $temp = $_SESSION['token_temp'];
        $sql = "SELECT * FROM `ncindustry_tmp_tarefa` WHERE `token_temp` = '" . $temp . "' and `ststamp`='" . $ststamp . "' ";

        $query = $this->db->query($sql);
        $data = $query->result_array();

        return $data;
    }

    //Função que adiciona os produtos numa tabela temporária,
    //antes da confirmação da tarefa
    public function add_product_cart($ststamp, $qtt) {
        $temp = $_SESSION['token_temp'];

        $sql = "SELECT * FROM ncindustry_tmp_tarefa where ststamp = '" . $ststamp . "' and token_temp = '" . $temp . "'";
        $query = $this->db->query($sql);
        $data = $query->result_array();

        if (sizeof($data)) {
            $sql = "update ncindustry_tmp_tarefa set qtt = qtt + " . $qtt . " where ststamp = '" . $ststamp . "' and token_temp = '" . $temp . "'";
            $query = $this->db->query($sql);
        } else {
            $data = array(
                'token_temp' => $temp,
                'ststamp' => $ststamp,
                'ativo' => '1',
                'qtt' => $qtt
            );
            $this->db->insert('ncindustry_tmp_tarefa', $data);
        }
    }

    public function get_cart() {
        $this->load->model('dossier_model', 'dossier');
        $this->load->model('nci_model', 'nci');
        $token = $_SESSION['token_temp'];
        $sql = "SELECT * FROM `ncindustry_tmp_tarefa` where `token_temp` = '" . $token . "'";
        $query = $this->db->query($sql);

        $cart = $query->result_array();
        $cart_output = array();
        $data = array();
        $data["u_ncidef"] = $this->nci->getU_ncidef(array())[0];

        switch ($data["u_ncidef"]['tarefastipo']) {
            //listagem dytable
            case 0:
                foreach ($cart as $row) {
                    $query = "	
                        select top 1 campo
                        from dytable
                        where entityname = 'a_stdtipo' and dytablestamp = '{$row['ststamp']}'
                    ";
                    $items = $this->mssql->mssql__select($query);

                    foreach ($items as $item) {
                        $tmp = array();
                        $tmp["ststamp"] = $row["ststamp"];
                        $tmp["ref"] = $item["campo"];
                        $tmp["design"] = $item["campo"];
                        $tmp["qtt"] = $row["qtt"];

                        $cart_output[] = $tmp;
                    }
                }
                break;
            //listagem tabela
            case 1:
                foreach ($cart as $row) {
                    $query = "	
                        select top 1 ref, design
                        from {$data["u_ncidef"]['tarefastabela']}
                        where {$data["u_ncidef"]['tarefastabela']}stamp = '{$row['ststamp']}'
                    ";
                    $items = $this->mssql->mssql__select($query);

                    foreach ($items as $item) {
                        $tmp = array();
                        $tmp["ststamp"] = $row["ststamp"];
                        $tmp["ref"] = $item["ref"];
                        $tmp["design"] = $item["design"];
                        $tmp["qtt"] = $row["qtt"];

                        $cart_output[] = $tmp;
                    }
                }
                break;
            //listagem dossier
            case 2:
                foreach ($cart as $row) {
                    $query = "	
                        select top 1 ref, design
                        from bo
                        inner join bi on bo.bostamp = bi.bostamp
                        where bo.ndos = '" . $data["u_ncidef"]['ndostarefas'] . "' and bistamp = '{$row['ststamp']}'
                    ";
                    $items = $this->mssql->mssql__select($query);

                    foreach ($items as $item) {
                        $tmp = array();
                        $tmp["ststamp"] = $row["ststamp"];
                        $tmp["ref"] = $item["ref"];
                        $tmp["design"] = $item["design"];
                        $tmp["qtt"] = $row["qtt"];

                        $cart_output[] = $tmp;
                    }
                }
                break;
            //listagem artigos
            case 3:
                foreach ($cart as $row) {
                    $query = "	
                        select top 1 ref, design
                        from st
                        where ststamp = '" . $row["ststamp"] . "'
                    ";
                    $items = $this->mssql->mssql__select($query);

                    foreach ($items as $item) {
                        $tmp = array();
                        $tmp["ststamp"] = $row["ststamp"];
                        $tmp["ref"] = $item["ref"];
                        $tmp["design"] = $item["design"];
                        $tmp["qtt"] = $row["qtt"];

                        $cart_output[] = $tmp;
                    }
                }
                break;
        }

        return $cart_output;
    }

    //procura se ha entrada de trabalhador com codigo de cartao
    public function search_in($cod_trabalhador) {
        $data = array();
        $data["u_ncidef"] = $this->nci->getU_ncidef(array())[0];

        if ($data["u_ncidef"]['pontotipo'] == 1) {
            $tabela = $data["u_ncidef"]['pontotabela'];

            $query = "	
                select top(1)*
                from " . $tabela . "
                where
                    codcart = '" . $cod_trabalhador . "' and
                    usrdata = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000'	
                order by 
                    ousrhora DESC
            ";
            $sql_status = $this->mssql->mssql__select($query);
            if (sizeof($sql_status)) {
                if ($sql_status[0]['ativo'] == '1') {
                    return $sql_status;
                }
            }
            return false;
        }
        //procurar em dossier
        else {
            $ndos = $data["u_ncidef"]['ndosponto'];

            $query = "	
                select top 1 *
                from bo (nolock) inner join bi (nolock) on bo.bostamp = bi.bostamp
                where
                    bi.lobs = '" . $cod_trabalhador . "' and
                    bo.ndos = '" . $ndos . "' and
                    bo.dataobra = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000'
                order by bo.obrano DESC, bi.litem2 DESC
            ";

            return $this->mssql->mssql__select($query);
        }
    }

    //Procura se ha tarefa aberta de trabalhador com codigo de cartao
    public function search_tarefa($cod_trabalhador) {
        $data = array();
        $data["u_ncidef"] = $this->nci->getU_ncidef(array())[0];
        $sql_status = array();

        //registo em dossier
        if ($data["u_ncidef"]['tarefa_registo_stipo'] == 0) {
            $query = "	
                    select top 1 *
                    from bo
                    where
                        trab1 = '" . $cod_trabalhador . "' and
                        ndos = '" . $data["u_ncidef"]['ndostarefasreg'] . "' and 
                        logi1 = 1 and
                        usrdata = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000' and
                        trab4 = ''
                    order by ousrhora DESC
                ";
            $sql_status = $this->mssql->mssql__select($query);
        }
        //registo em tabela
        else {
            $query = "	
                    select top 1 *
                    from " . $data["u_ncidef"]['registotarefas'] . "
                    where
                        codcart = '" . $cod_trabalhador . "' and
                        usrdata = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000' and
                        horafechado = ''
                    order by ousrhora DESC
                ";
            $sql_status = $this->mssql->mssql__select($query);
        }

        return $sql_status;
    }

    public function get_tarefas($cod_trabalhador) {
        $this->load->model('dossier_model', 'dossier');
        $this->load->model('nci_model', 'nci');

        $u_ncidefParams = array();
        $u_ncidef = $this->nci->getU_ncidef($u_ncidefParams);
        $data = array();
        $data["u_ncidef"] = $u_ncidef[0];
        if ($data["u_ncidef"]['iniciar_tarefas'] == 1) {
            if ($data["u_ncidef"]['tarefa_registo_stipo'] == 0) {
                $query = "	
                    select o.tipo, i.bostamp as tarefastamp, i.design, i.obistamp as ststamp, i.qtt, s.imagem  
                    from bo as o
                    inner join bi as i on i.bostamp = o.bostamp
                    inner join st as s on i.obistamp = s.ststamp
                    where
                        o.u_codcart = '" . $cod_trabalhador . "' and
                        o.ndos = '" . $data["u_ncidef"]['ndostarefas'] . "' and 
                        o.tipo = '1' and
                        i.ref = '1' and
                        o.usrdata = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000' and
                        o.usrhora = ''
                    order by 
                        i.design DESC
                ";
                $sql_status = $this->mssql->mssql__select($query);
                if (sizeof($sql_status)) {
                    if ($sql_status[0]['tipo'] == '1') {
                        return $sql_status;
                    }
                }
                return false;
            } else {
                $query = "	
                    select top 1 *
                    from " . $data["u_ncidef"]['registotarefas'] . "
                    where
                        codcart = '" . $cod_trabalhador . "' and
                        usrdata = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000' and
                        horafechado = ''
                    order by 
                        ousrhora DESC
                ";
                $sql_status = $this->mssql->mssql__select($query);
                if (sizeof($sql_status)) {
                    if ($data["u_ncidef"]['tarefastipo'] == 0) {
                        $query = " 
                            select dytablestamp, campo, entityname
                            from dytable
                            where	
                                entityname = 'a_stdtipo' and
                                dytablestamp = '{$sql_status[0]['dytablestamp']}'		
                        ";
                        $sql_status = $this->mssql->mssql__select($query);
                        return $sql_status;
                    } elseif ($data["u_ncidef"]['tarefastipo'] == 1) {
                        $query = " 
                            select produtostamp, design, imagem
                            from u_produtos
                            where	
                                produtostamp = '{$sql_status[0]['dytablestamp']}'			
                        ";
                        $sql_status = $this->mssql->mssql__select($query);
                        return $sql_status;
                    } elseif ($data["u_ncidef"]['tarefastipo'] == 2) {
                        $query = " 
                            select 
                                i.design, i.bistamp, i.obrano
                            from bi as i
                                inner join bo as o on  o.bostamp = i.bostamp
                            where 
                                i.design <> 'Tarefa' and
                                o.tipo = '' and	
                                i.bistamp = '{$sql_status[0]['dytablestamp']}'
                        ";

                        $sql_status = $this->mssql->mssql__select($query);
                        return $sql_status;
                    } else {
                        $query = "
                            select 
                                upt.u_produtos_tarefastamp, upt.tarefastamp, upt.ststamp, upt.qtt, s.design, s.imagem
                            from u_produtos_tarefa as upt
                                inner join st as s on upt.ststamp = s.ststamp
                            where 
                                upt.tarefastamp ='{$sql_status[0]['u_acesso_tarefastamp']}' AND
                                upt.ativo = 0
                                order by s.design
                        ";
                        $sql_status = $this->mssql->mssql__select($query);
                        return $sql_status;
                    }
                    return false;
                }
            }
        }
    }

    public function tarefa_out($cod_trabalhador) {
        $this->load->model('dossier_model', 'dossier');
        $this->load->model('nci_model', 'nci');

        $u_ncidefParams = array();
        $u_ncidef = $this->nci->getU_ncidef($u_ncidefParams);
        $data = array();
        $data["u_ncidef"] = $u_ncidef[0];
        if ($data["u_ncidef"]['iniciar_tarefas'] == 1) {
            if ($data["u_ncidef"]['tarefa_registo_stipo'] == 0) {
                $query = "	
                    select 
                        o.tipo, i.bostamp as tarefastamp, i.design, i.obistamp as ststamp, i.qtt, s.imagem  
                    from bo as o
                    inner join bi as i on i.bostamp = o.bostamp
                    inner join st as s on i.obistamp = s.ststamp
                    where
                        o.u_codcart = '" . $cod_trabalhador . "' and
                        o.ndos = '" . $data["u_ncidef"]['ndostarefas'] . "' and 
                        o.tipo = '1' and
                        i.ref = '1' and
                        o.usrdata = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000' and
                        o.usrhora = ''
                    order by 
                        i.design DESC
                ";
                $sql_status = $this->mssql->mssql__select($query);
                if (sizeof($sql_status)) {
                    if ($sql_status[0]['tipo'] == '1') {
                        return $sql_status;
                    }
                } else {
                    return false;
                }
            } else {
                $query = "	
                    select top(1)*
                    from " . $data["u_ncidef"]['registotarefas'] . "
                    where
                        codcart = '" . $cod_trabalhador . "' and
                        usrdata = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000' and
                        horafechado = ''
                    order by 
                        ousrhora DESC
                ";
                $sql_status = $this->mssql->mssql__select($query);
                if (sizeof($sql_status)) {
                    if ($sql_status[0]['ativo'] == '1') {
                        return $sql_status;
                    } else {
                        $sql_status = '';
                    }
                } else {
                    return false;
                }
            }
        } else {
            $query = " 
                select top(1)*
                from u_acesso_tarefa
                where
                    codcart = '" . $cod_trabalhador . "' and
                    usrdata = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000'	and
                    ativo = '1'
                order by 
                    ousrhora DESC
            ";
            $sql_status = $this->mssql->mssql__select($query);
            if (sizeof($sql_status)) {
                if ($sql_status[0]['ativo'] == '1') {
                    return $sql_status;
                } else {
                    $sql_status = '';
                }
            } else {
                return false;
            }
        }
    }

    //Dados de Trabalhador
    public function dados_tl($cod_trabalhador) {

        $query = "	
            select *
            from us
            where u_codcart = '" . $cod_trabalhador . "'
        ";

        $sql_status = $this->mssql->mssql__select($query);
        return $sql_status;
    }

    public function stamp() {
        $query = "select CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))) stamp";
        $query = $this->mssql->mssql__select($query);
        return $query[0]["stamp"];
    }

    public function get_today_dossier($params) {
        $values = array();
        $query = "select bostamp from bo (nolock) where dataobra = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000' ";

        foreach ($params as $key => $value) {
            $query .= "and {$key} = ? ";
            $values[] = $value;
        }

        return $this->mssql->mssql__prepare_sel($query, $values);
    }

    //registar entrada de funcionario ao servico
    public function save_ponto($tipo, $inp) {
        $data = array();
        $nome = $inp["trabalhador"][0]["username"];
        $userno = $inp["trabalhador"][0]["userno"];
        $codcart = $inp["trabalhador"][0]["u_codcart"];
        $usstamp = $inp["trabalhador"][0]["usstamp"];
        
        $data["u_ncidef"] = $this->nci->getU_ncidef(array())[0];

        //inserir em tabela
        if ($data["u_ncidef"]['pontotipo'] == 1) {
            $tabela = $data["u_ncidef"]['pontotabela'];
            $update_values = array();
            $update_values[] = $usstamp;
            $update_values[] = $codcart;
            $update_values[] = $nome;
            $update_values[] = 1;
            $query = "	
                insert into " . $tabela . "
                (
                    acessostamp,
                    usstamp,
                    codcart,
                    nome,
                    ativo,
                    ousrdata,
                    ousrhora,
                    ousrinis,
                    usrdata,
                    usrhora,
                    usrinis,
                    litem
                )
                values
                (
                    (select suser_sname()+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)),
                    ?,
                    ?,
                    ?,
                    ?,
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                    CONVERT(VARCHAR(8), GETDATE(), 8),
                    UPPER(suser_sname()),
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                    CONVERT(VARCHAR(8), GETDATE(), 8),
                    UPPER(suser_sname()),
                    UPPER('".$tipo."')
                )
            ";

            $sql_status = $this->mssql->mssql__prepare_exec($query, $update_values);
        }
        //inserir em dossier
        else {
            $ndos = $data["u_ncidef"]['ndosponto'];
            $dossier_ponto = $this->get_today_dossier(array("ndos" => $ndos));

            //ja existe o ponto para o dia de hoje
            if (count($dossier_ponto)) {
                $bostamp = $dossier_ponto[0]["bostamp"];
            }
            //nao existe o ponto para o dia de hoje portanto devemos criar
            else {
                $params = array();
                $params["ndos"] = $ndos;
                $params["values"] = array();

                $result = $this->create_bo($params);
                $dossier_ponto = $this->get_today_dossier(array("ndos" => $ndos));
                $bostamp = $dossier_ponto[0]["bostamp"];
            }

            $update_values = array();
            $update_values[] = $bostamp;
            $update_values[] = $ndos;
            $update_values[] = $userno;
            $update_values[] = $codcart;
            $update_values[] = ucfirst(strtolower($tipo)) . " " . $nome;
            $update_values[] = $tipo;

            $query = "
                BEGIN TRANSACTION [Tran1];
                BEGIN TRY 

                DECLARE @stamp VARCHAR(25);
                DECLARE @ndos INT;
                DECLARE @nmdos VARCHAR(25);
                DECLARE @numero INT;
                
                DECLARE @userno INT;
                DECLARE @codcart VARCHAR(50);
                DECLARE @design VARCHAR(60);
                DECLARE @tipo VARCHAR(25);
                
                SET @stamp = ?;
                SET @ndos = ?;
                SET @nmdos = (select nmdos from ts where ndos = @ndos);
                SET @numero = (select obrano from bo where bostamp = @stamp);

                SET @userno = ?;
                SET @codcart = ?;
                SET @design = ?;
                SET @tipo = ?;

                INSERT INTO bi 
                (
                    bistamp,
                    bostamp,
                    nmdos,
                    ndos,
                    obrano,
                    
                    design,
                    litem,
                    litem2,
                    binum1,
                    lobs,
                    
                    ousrinis,
                    ousrdata,
                    ousrhora,
                    usrinis,
                    usrdata,
                    usrhora
                ) 
                VALUES 
                ( 
                    CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
                    @stamp,
                    @nmdos,
                    @ndos,
                    @numero,
                    
                    @design,
                    @tipo,
                    CONVERT(VARCHAR(8), GETDATE(), 8),
                    @userno,
                    @codcart,
                    
                    UPPER(suser_sname()),
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                    CONVERT(VARCHAR(5), GETDATE(), 8),
                    UPPER(suser_sname()),
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                    CONVERT(VARCHAR(5), GETDATE(), 8)		 
                );

                COMMIT TRANSACTION [Tran1] 
                END TRY 
                BEGIN CATCH 
                ROLLBACK TRANSACTION [Tran1] 
                PRINT ERROR_MESSAGE() 
                END CATCH
            ";

            $sql_status = $this->mssql->mssql__prepare_exec($query, $update_values);
        }
    }

    //criar registo de nova tarefa
    public function save_in_tarefa($inp) {
        $data = array();

        $codcart = $inp["trabalhador"][0]["u_codcart"];
        $data["u_ncidef"] = $this->nci->getU_ncidef(array())[0];
        $result = "";

        switch ($data["u_ncidef"]['tarefa_registo_stipo']) {
            //registo em dossier
            case 0:
                $params = array();
                $params["ndos"] = $data["u_ncidef"]['ndostarefasreg'];

                $values = array();
                $values["trab1"] = $codcart;
                $values["trab2"] = $inp["trabalhador"][0]["usercode"];
                $values["logi1"] = 1;
                $values["trab3"] = date('H:i:s');
                $values["trab4"] = "";
                $params["values"] = $values;

                $result = $this->create_bo($params);
                break;
            //registo em tabela
            case 1:
                $update_values = array();
                $update_values[] = $codcart;
                $update_values[] = $inp["trabalhador"][0]["usercode"];
                $update_values[] = 1;

                $query = "	
                    insert into {$data["u_ncidef"]["registotarefas"]}
                    (
                        {$data["u_ncidef"]["registotarefas"]}stamp,
                        codcart,
                        usercode,
                        ativo,
                        ousrdata,
                        ousrhora,
                        ousrinis,
                        usrdata,
                        usrhora,
                        usrinis,
                        horaini,
                        horafechado
                    )
                    values
                    (
                        (select suser_sname()+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)),
                        ?,
                        ?,
                        ?,
                        CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
                        CONVERT(VARCHAR(8), GETDATE(), 8), 
                        UPPER(suser_sname()), 
                        CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
                        CONVERT(VARCHAR(8), GETDATE(), 8),
                        UPPER(suser_sname()),
                        CONVERT(VARCHAR(8), GETDATE(), 8),
                        ''	
                    )
                ";
                $result = $this->mssql->mssql__prepare_exec($query, $update_values);
                break;
        }
        return $result;
    }

    //criar cabecalho de dossier
    public function create_bo($params) {
        $data = array();
        $data["u_ncidef"] = $this->nci->getU_ncidef(array())[0];
        $ndos = $params["ndos"];

        $bostamp = $this->stamp();
        $update_values = array();

        $query = "
            BEGIN TRANSACTION [Tran1];
            BEGIN TRY

            DECLARE @ndos INT;
            DECLARE @stamp VARCHAR(25);
            DECLARE @nmdos VARCHAR(25);
            DECLARE @numero INT;

            SET @ndos = '" . $ndos . "';
            SET @stamp = '" . $bostamp . "' ;
            SET @nmdos = (select nmdos from ts where ndos = @ndos);
            SET @numero = isnull((select max(obrano) + 1 from bo where ndos = @ndos ), 1);

            INSERT INTO bo 
            (
                bostamp, 
                nmdos, 
                ndos,
                obrano, 
                boano, 
                dataobra,
                ousrinis,
                ousrdata,
                ousrhora,
                usrinis,
                usrdata,
                usrhora
        ";

        if (count($params["values"])) {
            foreach ($params["values"] as $key => $value) {
                $query .= ", {$key}";
                $update_values[] = $value;
            }
        }

        $query .= "
            )
            VALUES
            (
                @stamp, 
                @nmdos, 
                @ndos, 
                @numero,
                YEAR(GETDATE()), 
                CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                UPPER(suser_sname()),
                CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                CONVERT(VARCHAR(5), GETDATE(), 8),
                UPPER(suser_sname()),
                CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                CONVERT(VARCHAR(5), GETDATE(), 8)
        ";

        foreach ($params["values"] as $key => $value) {
            $query .= ", ?";
        }

        $query .= " 
                );
                COMMIT TRANSACTION [Tran1] 
                END TRY 
                BEGIN CATCH 
                ROLLBACK TRANSACTION [Tran1] 
                PRINT ERROR_MESSAGE() 
                END CATCH
	";

        $sql_status = $this->mssql->mssql__prepare_exec($query, $update_values);
        return $sql_status;
    }

    // save fecheado de tarefa
    public function update_tmp_produtos($data, $data2) {

        foreach ($data as $ace) {
            $codcart = $ace["codcart"];
            $tarefastamp = $ace["u_acesso_tarefastamp"];
        }

        $query = "	
            update u_acesso_tarefa
            set 
                horafechado = CONVERT(VARCHAR(8), GETDATE(), 8) ,
                ativo = 2
            where
                codcart = '" . $codcart . "' and
                usrdata = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000'
        ";
        $dat = $this->mssql->mssql__execute($query);

        foreach ($data2 as $ace2):
            $ststamp = $ace2["ststamp"];
            $ref = $ace2["ref"];
            $design = $ace2["design"];
            $qtt = $ace2["qtt"];

            $update_values = array();
            $update_values[] = $tarefastamp;
            $update_values[] = $ststamp;
            $update_values[] = $ref;
            $update_values[] = $qtt;

            $query = "	
                insert into u_produtos_tarefa 
                (
                    u_produtos_tarefastamp,
                    tarefastamp,
                    ststamp,
                    ref,
                    qtt,
                    ousrdata,
                    ousrhora,
                    ousrinis,
                    usrdata,
                    usrhora,
                    usrinis
                    )values(
                    (select suser_sname()+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)),
                    ?,
                    ?,
                    ?,
                    ?,
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
                    CONVERT(VARCHAR(8), GETDATE(), 8), 
                    UPPER(suser_sname()), 
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
                    CONVERT(VARCHAR(8), GETDATE(), 8),
                    UPPER(suser_sname())
                )
            ";
            $sql_status = $this->mssql->mssql__prepare_exec($query, $update_values);

        endforeach;

        if ($dat) {
            $query = "	
                select username
                from us
                where
                    U_CODCART = '" . $codcart . "'
            ";
            $dat2 = $this->mssql->mssql__select($query);
        }
        return $dat2;
    }

    public function fechar_tarefa_artigos_todas($data2, $data3) {
        $u_ncidefParams = array();
        $u_ncidef = $this->nci->getU_ncidef($u_ncidefParams);
        $data = array();
        $data["u_ncidef"] = $u_ncidef[0];

        if ($data["u_ncidef"]['tarefa_registo_stipo'] == 0) {

            foreach ($data2 as $ace) {
                $codcart = $ace["u_codcart"];
                $bostamp = $ace["bostamp"];
            }
            $query = "
                update bo 
                set
                    tipo = '2',
                    usrhora = CONVERT(VARCHAR(5), GETDATE(), 8)
                where 
                    u_codcart = '" . $codcart . "' and
                    bostamp = '" . $bostamp . "'
            ";
            $dat = $this->mssql->mssql__execute($query);

            foreach ($data3 as $ace2):
                $ststamp = $ace2["ststamp"];
                $qtt = $ace2["qtt"];

                $query = "
                    update bi
                    set
                        qtt = '" . $qtt . "',
                        ref = '2'
                    where 
                        obistamp = '" . $ststamp . "' and
                        bostamp = '" . $bostamp . "' 				
                ";

                $sql_status = $this->mssql->mssql__execute($query);
            endforeach;

            if ($dat) {
                $query = "	
                    select username
                    from us
                    where
                        u_codcart = '" . $codcart . "'
                ";
                $dat2 = $this->mssql->mssql__select($query);
            }
            return $dat2;
        } else {
            foreach ($data2 as $ace) {
                $codcart = $ace["codcart"];
                $tarefastamp = $ace["u_acesso_tarefastamp"];
            }

            $query = "	
                update " . $data["u_ncidef"]['registotarefas'] . " 
                set 
                    horafechado = CONVERT(VARCHAR(8), GETDATE(), 8) ,
                    ativo = 2
                where
                    codcart = '" . $codcart . "' and
                    u_acesso_tarefastamp = '" . $tarefastamp . "' and
                    usrdata = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000'
            ";
            $dat = $this->mssql->mssql__execute($query);

            foreach ($data3 as $ace2):
                $ststamp = $ace2["ststamp"];
                $qtt = $ace2["qtt"];

                $query = "
                    update u_produtos_tarefa
                    set
                        qtt = '" . $qtt . "',
                        ativo = '1'
                    where 
                        ststamp = '" . $ststamp . "' and
                        tarefastamp = '" . $tarefastamp . "' 			
                ";

                $sql_status = $this->mssql->mssql__execute($query);
            endforeach;

            if ($dat) {
                $query = "	
                    select username
                    from us
                    where U_CODCART = '" . $codcart . "'
                ";
                $dat2 = $this->mssql->mssql__select($query);
            }
            return $dat2;
        }
    }

    public function fechar_tarefa_artigos_parte($data2, $data3) {
        $u_ncidefParams = array();
        $u_ncidef = $this->nci->getU_ncidef($u_ncidefParams);
        $data = array();
        $data["u_ncidef"] = $u_ncidef[0];
        if ($data["u_ncidef"]['tarefa_registo_stipo'] == 0) {

            foreach ($data2 as $ace) {
                $codcart = $ace["u_codcart"];
                $bostamp = $ace["bostamp"];
            }

            foreach ($data3 as $ace2):
                $ststamp = $ace2["ststamp"];
                $qtt = $ace2["qtt"];
                $update_values = array();
                $query = "
                    update bi
                    set
                        qtt = '" . $qtt . "',
                        ref = '2'
                    where 
                        obistamp = '" . $ststamp . "' and
                        bostamp = '" . $bostamp . "' 				
                ";

                $sql_status = $this->mssql->mssql__prepare_exec($query, $update_values);
            endforeach;

            $update_values = array();
            $query = "	
                select username
                from us
                where
                    U_CODCART = '" . $codcart . "'
            ";
            $dat2 = $this->mssql->mssql__prepare_sel($query, $update_values);
            return $dat2;
        }
        else {
            $update_values = array();
            foreach ($data2 as $ace) {
                $codcart = $ace["codcart"];
                $tarefastamp = $ace["u_acesso_tarefastamp"];
            }

            foreach ($data3 as $ace2):
                $ststamp = $ace2["ststamp"];
                $qtt = $ace2["qtt"];

                $query = "
                    update u_produtos_tarefa
                    set
                        qtt = '" . $qtt . "' ,
                        ativo = '1'
                    where 
                        ststamp = '" . $ststamp . "' and
                        tarefastamp = '" . $tarefastamp . "' 				
                ";

                $sql_status = $this->mssql->mssql__prepare_exec($query, $update_values);
            endforeach;

            $update_values = array();

            $query = "	
                select username
                from us
                where
                    U_CODCART = '" . $codcart . "'
            ";
            $dat2 = $this->mssql->mssql__prepare_sel($query, $update_values);
            return $dat2;
        }
    }

    public function update_tarefa_dossier($cod_trabalhador, $cart) {
        $data = array();
        $data["u_ncidef"] = $this->nci->getU_ncidef(array())[0];
        $ndos = $data["u_ncidef"]['ndostarefasreg'];
        $data["trabalhador"] = $this->dados_tl($cod_trabalhador);
        $data["tarefa"] = $this->search_tarefa($cod_trabalhador);
        $update_values = array();
        
        $query = "
            BEGIN TRANSACTION [Tran1];
            BEGIN TRY
        ";

        if (count($data["tarefa"])) {
            //atualizar cabecalho
            $query .= "
                update bo set
                logi1 = 0,
                trab4 = CONVERT(VARCHAR(8), GETDATE(), 8)
                where bostamp = '" . $data["tarefa"][0]["bostamp"] . "'
            ";
            $stamp = $data["tarefa"][0]["bostamp"];
            $nmdos = $data["tarefa"][0]["nmdos"];
            $ndos = $data["tarefa"][0]["ndos"];
            $obrano = $data["tarefa"][0]["obrano"];
        }
        else {
            $this->save_in_tarefa($data);
            $tarefaAberta = $this->search_tarefa($cod_trabalhador);
            $stamp = $tarefaAberta[0]["bostamp"];
            $nmdos = $tarefaAberta[0]["nmdos"];
            $ndos = $tarefaAberta[0]["ndos"];
            $obrano = $tarefaAberta[0]["obrano"];
        }
        
        foreach ($cart as $row) {
            $update_values[] = $stamp;
            $update_values[] = $nmdos;
            $update_values[] = $ndos;
            $update_values[] = $obrano;

            $update_values[] = $row["ref"];
            $update_values[] = $row["design"];
            $update_values[] = $row["qtt"];

            $query .= "
                INSERT INTO BI 
                (
                    bistamp,
                    bostamp,
                    nmdos,
                    ndos,
                    obrano,
                    ref,
                    design,
                    qtt,
                    ousrinis,
                    ousrdata,
                    ousrhora,
                    usrinis,
                    usrdata,
                    usrhora
                ) 
                VALUES 
                ( 
                    CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    UPPER(suser_sname()),
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                    CONVERT(VARCHAR(5), GETDATE(), 8),
                    UPPER(suser_sname()),
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                    CONVERT(VARCHAR(5), GETDATE(), 8)
                );
            ";
        }
        
        $query .= "
            COMMIT TRANSACTION [Tran1] 
            END TRY 
            BEGIN CATCH 
            ROLLBACK TRANSACTION [Tran1] 
            PRINT ERROR_MESSAGE() 
            END CATCH
        ";

        $sql_status = $this->mssql->mssql__prepare_exec($query, $update_values);

        return $data["trabalhador"][0]["username"];
    }

    public function update_tarefa_tabela($cod_trabalhador, $cart = array()) {
        $data = array();
        $data["u_ncidef"] = $this->nci->getU_ncidef(array())[0];
        $data["trabalhador"] = $this->dados_tl($cod_trabalhador);
        $update_values = array();
        $query = "
            BEGIN TRANSACTION [Tran1];
            BEGIN TRY
        ";

        //fechar tarefa
        //procurar tarefa em aberto
        $tarefaAberta = $this->search_tarefa($cod_trabalhador);
        if (count($tarefaAberta)) {
            $stamp = $tarefaAberta[0][$data["u_ncidef"]['registotarefas'] . "stamp"];

            $update_values[] = $stamp;

            $query .= "
                update " . $data["u_ncidef"]['registotarefas'] . " 
                set
                    ativo = 0,
                    horafechado = CONVERT(VARCHAR(8), GETDATE(), 8)
                where " . $data["u_ncidef"]['registotarefas'] . "stamp = ?
            ";
        } else {
            //nao existem tarefas portanto e para adicionar
            $this->save_in_tarefa($data);
            $tarefaAberta = $this->search_tarefa($cod_trabalhador);
            $stamp = $tarefaAberta[0][$data["u_ncidef"]['registotarefas'] . "stamp"];
        }

        foreach ($cart as $row) {
            $ststamp = $row["ststamp"];
            $ref = $row["ref"];
            $design = $row["design"];
            $qtt = $row["qtt"];

            $update_values[] = $stamp;
            $update_values[] = $ststamp;
            $update_values[] = $ref;
            $update_values[] = $qtt;

            $query .= "
                    insert into u_produtos_tarefa 
                    (
                        u_produtos_tarefastamp,
                        tarefastamp,
                        ststamp,
                        ref,
                        qtt,
                        ousrdata,
                        ousrhora,
                        ousrinis,
                        usrdata,
                        usrhora,
                        usrinis
                    )
                    values
                    (
                        (select suser_sname()+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)),
                        ?,
                        ?,
                        ?,
                        ?,
                        CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
                        CONVERT(VARCHAR(8), GETDATE(), 8), 
                        UPPER(suser_sname()), 
                        CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
                        CONVERT(VARCHAR(8), GETDATE(), 8),
                        UPPER(suser_sname())
                    )
                ";
        }

        $query .= "
            COMMIT TRANSACTION [Tran1] 
            END TRY 
            BEGIN CATCH 
            ROLLBACK TRANSACTION [Tran1] 
            PRINT ERROR_MESSAGE() 
            END CATCH
        ";
        $sql_status = $this->mssql->mssql__prepare_exec($query, $update_values);

        return $data["trabalhador"][0]["username"];
    }

    public function registo_tarefas($nome, $stamp_producto, $cod_trabalhador) {
        $u_ncidefParams = array();
        $u_ncidef = $this->nci->getU_ncidef($u_ncidefParams);
        $data = array();
        $data["u_ncidef"] = $u_ncidef[0];
        if ($data["u_ncidef"]['tarefa_registo_stipo'] == 0) {
            $ndos = $data["u_ncidef"]['ndostarefas'];
            $bostamp2 = $this->stamp();
            $update_values = array();
            $update_values[] = $nome;
            $query = "
                BEGIN TRANSACTION [Tran1];
                BEGIN TRY

                DECLARE @stamp VARCHAR(25);
                DECLARE @nmdos VARCHAR(25);
                DECLARE @numero INT;
                DECLARE @ndos INT;
                DECLARE @usstamp VARCHAR(25);
                DECLARE @design VARCHAR(25);
                DECLARE @codcart VARCHAR(25);
                DECLARE @dytablestamp VARCHAR(25);

                SET @codcart = '" . $cod_trabalhador . "';
                SET @dytablestamp = '" . $stamp_producto . "';
                SET @ndos = '" . $ndos . "';
                SET @design = 'Tarefa';
                SET @stamp = '" . $bostamp2 . "' ;
                SET @nmdos = (select nmdos from ts where ndos = '" . $ndos . "');
                SET @numero = isnull((select max(obrano) + 1 from bo where ndos = @ndos ), 1);

                INSERT INTO bi 
                (
                    bistamp, 
                    bostamp, 
                    nmdos, 
                    ndos, 
                    obrano,
                    design, 
                    ousrinis,
                    ousrdata, 
                    ousrhora, 
                    usrinis,
                    usrdata,
                    usrhora,
                    ref
                ) 
                values 
                ( 
                    CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))), 
                    @stamp, 
                    @nmdos, 
                    @ndos, 
                    @numero, 
                    @design,
                    UPPER(suser_sname()),
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
                    CONVERT(VARCHAR(5), GETDATE(), 8), 
                    UPPER(suser_sname()),
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
                    CONVERT(VARCHAR(5), GETDATE(), 8),				 
                    '1'
                );

                INSERT INTO bo 
                (
                    bostamp, 
                    nmdos, 
                    ndos,
                    nome, 
                    obrano, 
                    u_codcart,
                    tpstamp,
                    boano, 
                    dataobra, 
                    ousrinis, 
                    ousrdata,
                    ousrhora, 
                    usrinis, 
                    usrdata, 
                    usrhora, 
                    tipo
                )
                VALUES
                (
                    @stamp, 
                    @nmdos , 
                    @ndos , 
                    ?, 
                    @numero,
                    @codcart,
                    @dytablestamp,
                    YEAR(GETDATE()), 
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                    UPPER(suser_sname()),
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                    CONVERT(VARCHAR(5), GETDATE(), 8),
                    UPPER(suser_sname()),
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                    '',
                    '1'
                );
                
                COMMIT TRANSACTION [Tran1] 
                END TRY 
                BEGIN CATCH 
                ROLLBACK TRANSACTION [Tran1] 
                PRINT ERROR_MESSAGE() 
                END CATCH
            ";
            $sql_status = $this->mssql->mssql__prepare_exec($query, $update_values);
        } else {

            $update_values = array();
            $update_values[] = $stamp_producto;
            $update_values[] = $cod_trabalhador;
            $update_values[] = 1;

            $query = "	
                insert into " . $data["u_ncidef"]['registotarefas'] . " 
                (
                    u_acesso_tarefastamp,
                    dytablestamp,
                    codcart,
                    ativo,
                    ousrdata,
                    ousrhora,
                    ousrinis,
                    usrdata,
                    usrhora,
                    usrinis,
                    horaini,
                    horafechado
                )
                values(
                    (select suser_sname()+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)),
                    ?,
                    ?,
                    ?,
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
                    CONVERT(VARCHAR(8), GETDATE(), 8), 
                    UPPER(suser_sname()), 
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
                    CONVERT(VARCHAR(8), GETDATE(), 8),
                    UPPER(suser_sname()),
                    CONVERT(VARCHAR(8), GETDATE(), 8),
                    ''
                )
            ";
            $sql_status = $this->mssql->mssql__prepare_exec($query, $update_values);
        }
    }

    public function update_product($u_codcart, $stamp) {
        $u_ncidefParams = array();
        $u_ncidef = $this->nci->getU_ncidef($u_ncidefParams);
        $data = array();
        $data["u_ncidef"] = $u_ncidef[0];
        $update_values = array();
        if ($data["u_ncidef"]['tarefa_registo_stipo'] == 0) {
            $query = "
                update bo
                set 
                    usrhora = CONVERT(VARCHAR(8), GETDATE(), 8) ,
                    tipo = 2
                where
                    u_codcart = '" . $u_codcart . "' and
                    tpstamp = '" . $stamp . "' and
                    usrdata = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000'	
            ";

            $result = $this->mssql->mssql__prepare_exec($query, $update_values);
            return $result;
        } else {
            $query = "
                update " . $data["u_ncidef"]['registotarefas'] . "
                set 
                    horafechado = CONVERT(VARCHAR(8), GETDATE(), 8),
                    ativo = 2
                where
                    codcart = '" . $u_codcart . "' and
                    dytablestamp = '" . $stamp . "' and
                    usrdata = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000'
            ";
            $result = $this->mssql->mssql__prepare_exec($query, $update_values);
            return $result;
        }
    }

    //apagar dados de cart
    public function delete_tmp_tarefa($tmp) {
        $this->db->from('ncindustry_tmp_tarefa');
        $this->db->where('token_temp', $tmp);
        $this->db->delete();
    }

    //apagar dados de cart com filtro de referencia
    public function delete_tmp_tarefa_stamp($stamp) {
        $this->db->from('ncindustry_tmp_tarefa');
        $this->db->where('ststamp', $stamp);
        $this->db->delete();
        return $this->db->affected_rows();
    }

}
