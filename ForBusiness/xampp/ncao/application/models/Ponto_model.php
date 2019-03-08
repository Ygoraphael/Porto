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
        $update_values = array();

        $query = "	
            select st.ststamp,st.ref, st.design, st.familia, st.u_ativonci, st.imagem, stfami.stfamistamp
            from st (nolock)
                inner join stfami (nolock) on st.familia = stfami.ref
            where 
               st.u_ativonci = 1 and
               stfami.stfamistamp = '" . $stamp . "'
        ";
        $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);

        return $sql_status;
    }

    //Procura familias ativas
    public function get_familias() {
        $update_values = array();

        $query = "	
            select stfamistamp,ref, nome, imgqlook, u_ativonci
            from stfami 
            where
                u_ativonci = 1
            order by 
                nome DESC
        ";
        $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);

        return $sql_status;
    }

    //Procura campo no Dytable
    public function get_dytable() {
        $update_values = array();

        $query = " 
            select dytablestamp, campo, entityname
            from dytable
            where	
                entityname = 'a_stdtipo'
            order by
                campo			
        ";
        $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);

        return $sql_status;
    }

    //procura produtos tarefas - tabela
    public function get_produtos_tabela() {
        $update_values = array();
        $this->load->model('dossier_model', 'dossier');
        $this->load->model('nci_model', 'nci');

        $u_ncidefParams = array();
        $u_ncidef = $this->nci->getU_ncidef($u_ncidefParams);
        $data = array();
        $data["u_ncidef"] = $u_ncidef[0];

        //BUG STAMP
        $query = " 
            select produtostamp, design, imagem
            from " . $data["u_ncidef"]['tarefastabela'] . "
            where	
                status = '1'
            order by
                design			
        ";
        $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);

        return $sql_status;
    }

    public function get_produtos_dossier($filter) {

        if (empty($filter)) {
            $filters = '';
        } else {
            $filters = 'and i.obrano = ' . "'" . $filter . "'";
        }
        $update_values = array();
        $this->load->model('dossier_model', 'dossier');
        $this->load->model('nci_model', 'nci');

        $u_ncidefParams = array();
        $u_ncidef = $this->nci->getU_ncidef($u_ncidefParams);
        $data = array();
        $data["u_ncidef"] = $u_ncidef[0];

        $query = "
            select 
            i.design, i.bistamp, i.obrano
            from bi as i
                inner join bo as o on o.bostamp = i.bostamp
            where 
                i.design <> 'Tarefa' and
                o.tipo = '' and	
                i.ndos = '" . $data["u_ncidef"]['ndostarefas'] . "'
                " . $filters . "
        ";
        $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);
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

    public function add_product_cart2($ststamp, $qtt) {
        $temp = $_SESSION['token_temp'];

        $sql = "SELECT * FROM ncindustry_tmp_tarefa where ststamp = '" . $ststamp . "' and token_temp = '" . $temp . "'";
        $query = $this->db->query($sql);
        $data = $query->result_array();

        if (sizeof($data)) {
            $sql = "update ncindustry_tmp_tarefa set qtt = " . $qtt . " where ststamp = '" . $ststamp . "' and token_temp = '" . $temp . "'";
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
        $temp = $_SESSION['token_temp'];
        $sql = "SELECT * FROM `ncindustry_tmp_tarefa` where `token_temp` = '" . $temp . "'";
        $query = $this->db->query($sql);
        $datas = $query->result_array();
        $cart_data = array();
        $this->load->model('dossier_model', 'dossier');
        $this->load->model('nci_model', 'nci');

        $u_ncidefParams = array();
        $u_ncidef = $this->nci->getU_ncidef($u_ncidefParams);
        $data = array();
        $data["u_ncidef"] = $u_ncidef[0];
        if ($data["u_ncidef"]['iniciar_tarefas'] == 1) {
            if ($data["u_ncidef"]['tarefastipo'] == 3) {
                foreach ($datas as $linha) {
                    $update_values = array();
                    $query = "	
                        select top 1 ref, design
                        from st
                        where
                            ststamp = '" . $linha["ststamp"] . "'
                    ";
                    $data2 = $this->mssql->mssql__prepare_sel($query, $update_values);

                    foreach ($data2 as $linha2) {
                        $tmp = array();
                        $tmp["ststamp"] = $linha["ststamp"];
                        $tmp["ref"] = $linha2["ref"];
                        $tmp["design"] = $linha2["design"];
                        $tmp["qtt"] = $linha["qtt"];
                        $cart_data[] = $tmp;
                    }
                }

                return $cart_data;
            }
        } else {
            foreach ($datas as $linha) {
                $update_values = array();
                $query = "	
                    select top 1 ref, design
                    from st
                    where
                        ststamp = '" . $linha["ststamp"] . "'
                ";
                $data2 = $this->mssql->mssql__prepare_sel($query, $update_values);

                foreach ($data2 as $linha2) {
                    $tmp = array();
                    $tmp["ststamp"] = $linha["ststamp"];
                    $tmp["ref"] = $linha2["ref"];
                    $tmp["design"] = $linha2["design"];
                    $tmp["qtt"] = $linha["qtt"];
                    $cart_data[] = $tmp;
                }
            }

            return $cart_data;
        }
    }

    //Procura se há entrada de Trabalhador com Código do Cartón
    public function search_in($cod_trabalhador) {
        $u_ncidefParams = array();
        $u_ncidef = $this->nci->getU_ncidef($u_ncidefParams);
        $data = array();
        $data["u_ncidef"] = $u_ncidef[0];
        if ($data["u_ncidef"]['pontotipo'] == 1) {
            $tabela = $data["u_ncidef"]['pontotabela'];
            $update_values = array();

            $query = "	
                select top(1)*
                from " . $tabela . "
                where
                    codcart = '" . $cod_trabalhador . "' and
                    usrdata = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000'	
                order by 
                    ousrhora DESC
            ";
            $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);
            if (sizeof($sql_status)) {
                if ($sql_status[0]['ativo'] == '1') {
                    return $sql_status;
                }
            }
            return false;
        } else {
            $ndos = $data["u_ncidef"]['ndosponto'];
            $update_values = array();
            $query = "	
                select top 1 *
                from bo
                where
                    u_codcart = '" . $cod_trabalhador . "' and
                    ndos = '" . $ndos . "' and
                    dataobra = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000'	
                order by 
                    obrano DESC
            ";
            $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);
            if (sizeof($sql_status)) {
                if ($sql_status[0]['tipo'] == '1') {
                    return $sql_status;
                }
            }
            return false;
        }
    }

    //Procura se há tarefa aberta de Trabalhador com Código do Cartón
    public function search_tarefa($cod_trabalhador) {
        $this->load->model('dossier_model', 'dossier');
        $this->load->model('nci_model', 'nci');

        $u_ncidefParams = array();
        $u_ncidef = $this->nci->getU_ncidef($u_ncidefParams);
        $data = array();
        $data["u_ncidef"] = $u_ncidef[0];
        if ($data["u_ncidef"]['iniciar_tarefas'] == 1) {
            if ($data["u_ncidef"]['tarefa_registo_stipo'] == 0) {
                $update_values = array();

                $query = "	
                    select top 1 *
                    from bo
                    where
                        u_codcart = '" . $cod_trabalhador . "' and
                        ndos = '" . $data["u_ncidef"]['ndostarefas'] . "' and 
                        tipo = '1' and
                        usrdata = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000' and
                        usrhora = ''
                    order by 
                        ousrhora DESC
                ";
                $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);
                if (sizeof($sql_status)) {
                    if ($sql_status[0]['tipo'] == '1') {
                        return $sql_status;
                    }
                }
                return false;
            } else {
                $update_values = array();

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
                $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);
                if (sizeof($sql_status)) {
                    if ($sql_status[0]['ativo'] == '1') {
                        return $sql_status;
                    }
                }
                return false;
            }
        } else {

            $update_values = array();

            $query = "	
                select top 1 *
                from u_acesso_tarefa
                where
                    codcart = '" . $cod_trabalhador . "' and
                    usrdata = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000' and
                    horafechado = ''
                order by 
                    ousrhora DESC
            ";
            $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);
            if (sizeof($sql_status)) {
                if ($sql_status[0]['ativo'] == '1') {
                    return $sql_status;
                }
            }
            return false;
        }
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
                $update_values = array();

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
                $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);
                if (sizeof($sql_status)) {
                    if ($sql_status[0]['tipo'] == '1') {
                        return $sql_status;
                    }
                }
                return false;
            } else {
                $update_values = array();

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
                $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);
                if (sizeof($sql_status)) {
                    if ($data["u_ncidef"]['tarefastipo'] == 0) {
                        $query = " 
                            select dytablestamp, campo, entityname
                            from dytable
                            where	
                                entityname = 'a_stdtipo' and
                                dytablestamp = '{$sql_status[0]['dytablestamp']}'			
                        ";
                        $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);
                        return $sql_status;
                    } elseif ($data["u_ncidef"]['tarefastipo'] == 1) {
                        $query = " 
							select produtostamp, design, imagem
							from u_produtos
							where	
								produtostamp = '{$sql_status[0]['dytablestamp']}'			
						";
                        $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);
                        return $sql_status;
                    } elseif ($data["u_ncidef"]['tarefastipo'] == 2) {
                        $query = " select 
							i.design, i.bistamp, i.obrano
						from bi as i
							inner join bo as o on  o.bostamp = i.bostamp
						where 
							i.design <> 'Tarefa' and
							o.tipo = '' and	
							i.bistamp = '{$sql_status[0]['dytablestamp']}'
						";

                        $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);
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
                        $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);
                        return $sql_status;
                    }
                    return false;
                }
            }
        }
    }

    //Procura se há entrada para pode fazer saída de Trabalhador com Código do Cartón
    public function search_out($cod_trabalhador) {
        $u_ncidefParams = array();
        $u_ncidef = $this->nci->getU_ncidef($u_ncidefParams);
        $data = array();
        $data["u_ncidef"] = $u_ncidef[0];
        if ($data["u_ncidef"]['pontotipo'] == 1) {
            $update_values = array();

            $query = "	
				select top(1)*
				from " . $data["u_ncidef"]['pontotabela'] . "
				where
					codcart = '" . $cod_trabalhador . "' and
					usrdata = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000'	
				order by 
					ousrhora DESC
			";

            $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);
            if (sizeof($sql_status)) {
                if ($sql_status[0]['ativo'] == '2') {
                    $sql_status = '';
                } else {
                    return $sql_status;
                }
            }return false;
        } else {
            $ndos = $data["u_ncidef"]['ndosponto'];
            $update_values = array();
            $query = "	
				select top(1)*
				from bo
				where
					u_codcart = '" . $cod_trabalhador . "' and
					ndos = '" . $ndos . "' and
					dataobra = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000'	
				order by 
					obrano DESC
			";
            $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);
            if (sizeof($sql_status)) {
                if ($sql_status[0]['tipo'] == '2') {
                    $sql_status = '';
                } else {
                    return $sql_status;
                }
            }return false;
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

                $update_values = array();

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
                $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);
                if (sizeof($sql_status)) {
                    if ($sql_status[0]['tipo'] == '1') {
                        return $sql_status;
                    }
                } else {
                    return false;
                }
            } else {
                $update_values = array();

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
                $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);
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
            $update_values = array();
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
            $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);
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
        $update_values = array();

        $query = "	
            select *
            from us
            where
                U_CODCART = '" . $cod_trabalhador . "'
        ";

        $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);
        if (sizeof($sql_status)) {
            return $sql_status;
        }
        return false;
    }

    public function stamp() {
        $query = "select CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))) stamp";
        $query = $this->mssql->mssql__select($query);
        return $query[0]["stamp"];
    }

    //Salvar Dados de Entrada do Trabalhador
    public function save_in($data) {

        foreach ($data as $resp) {
            $nome = $resp[0]["username"];
            $usstamp = $resp[0]["usstamp"];
            $codcart = $resp[0]["u_codcart"];
        }

        $u_ncidefParams = array();
        $u_ncidef = $this->nci->getU_ncidef($u_ncidefParams);
        $data = array();
        $data["u_ncidef"] = $u_ncidef[0];
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
					usrinis
				)
				values(
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
        } else {
            $ndos = $data["u_ncidef"]['ndosponto'];
            $bostamp2 = $this->stamp();
            $update_values = array();
            $update_values[] = $nome;
            $query = "
			BEGIN TRANSACTION [Tran1];
			BEGIN TRY ";

            $query .= "

			DECLARE @stamp VARCHAR(25);
			DECLARE @nmdos VARCHAR(25);
			DECLARE @numero INT;
			DECLARE @ndos INT;
			DECLARE @usstamp VARCHAR(25);
			DECLARE @desing VARCHAR(25);
			DECLARE @codcart VARCHAR(25);
			
			
			SET @usstamp = '" . $usstamp . "';
			SET @codcart = '" . $codcart . "';
			SET @ndos = '" . $ndos . "';
			SET @desing = 'Entrada-Ponto';
			SET @stamp = '" . $bostamp2 . "' ;
			SET @nmdos = (select nmdos from ts where ndos = '" . $ndos . "');
			SET @numero = isnull((select max(obrano) + 1 from bo where ndos = @ndos and boano = YEAR(GETDATE())), 1);
			";

            $query .= "
			INSERT INTO 
				bi (
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
				@desing,
				UPPER(suser_sname()),
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8), 
				UPPER(suser_sname()),
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8),				 
				'1'
			);
			";

            $query .= "
			INSERT INTO 
				bo (
				bostamp, 
				nmdos, 
				ndos,
				nome, 
				obrano, 
				u_codcart,
				boano, 
				dataobra, 
				ousrinis, 
				ousrdata,
				ousrhora, 
				usrinis, 
				usrdata, 
				usrhora, 
				tipo)
			VALUES
			(
				@stamp, 
				@nmdos , 
				@ndos , 
				?, 
				@numero,
				@codcart,
				YEAR(GETDATE()), 
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
				UPPER(suser_sname()),
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
				CONVERT(VARCHAR(5), GETDATE(), 8),
				UPPER(suser_sname()),
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
				CONVERT(VARCHAR(5), GETDATE(), 8),
				'1'
			);

			";

            $query .= "

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

    //Salvar Dados de Saída do Trabalhador
    public function save_out($data) {

        foreach ($data as $resp) {
            $nome = $resp[0]["username"];
            $usstamp = $resp[0]["usstamp"];
            $codcart = $resp[0]["u_codcart"];
        }

        $u_ncidefParams = array();
        $u_ncidef = $this->nci->getU_ncidef($u_ncidefParams);
        $data = array();
        $data["u_ncidef"] = $u_ncidef[0];
        if ($data["u_ncidef"]['pontotipo'] == 1) {
            $tabela = $data["u_ncidef"]['pontotabela'];
            $update_values = array();
            $update_values[] = $usstamp;
            $update_values[] = $codcart;
            $update_values[] = $nome;
            $update_values[] = 2;

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
        } else {
            $ndos = $data["u_ncidef"]['ndosponto'];
            $bostamp2 = $this->stamp();
            $update_values = array();
            $update_values[] = $nome;
            $query = "
			BEGIN TRANSACTION [Tran1];
			BEGIN TRY ";

            $query .= "

			DECLARE @stamp VARCHAR(25);
			DECLARE @nmdos VARCHAR(25);
			DECLARE @numero INT;
			DECLARE @ndos INT;
			DECLARE @usstamp VARCHAR(25);
			DECLARE @desing VARCHAR(25);
			DECLARE @codcart VARCHAR(25);
			
			
			SET @usstamp = '" . $usstamp . "';
			SET @codcart = '" . $codcart . "';
			SET @ndos = '" . $ndos . "';
			SET @desing = 'Salida-Ponto';
			SET @stamp = '" . $bostamp2 . "' ;
			SET @nmdos = (select nmdos from ts where ndos = '" . $ndos . "');
			SET @numero = isnull((select max(obrano) + 1 from bo where ndos = @ndos and boano = YEAR(GETDATE())), 1);
			";

            $query .= "
			INSERT INTO 
				bi (
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
				@desing,
				UPPER(suser_sname()),
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8), 
				UPPER(suser_sname()),
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8),				 
				'2'
			);
			";

            $query .= "
			INSERT INTO 
				bo (
				bostamp, 
				nmdos, 
				ndos,
				nome, 
				obrano, 
				u_codcart,
				boano, 
				dataobra, 
				ousrinis, 
				ousrdata,
				ousrhora, 
				usrinis, 
				usrdata, 
				usrhora, 
				tipo)
			VALUES
			(
				@stamp, 
				@nmdos , 
				@ndos , 
				?, 
				@numero,
				@codcart,
				YEAR(GETDATE()), 
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
				UPPER(suser_sname()),
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
				CONVERT(VARCHAR(5), GETDATE(), 8),
				UPPER(suser_sname()),
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
				CONVERT(VARCHAR(5), GETDATE(), 8),
				'2'
			);

			";

            $query .= "

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

    //Salvar Dados de Entrada do Trabalhador
    public function save_in_tarefa($data) {

        foreach ($data as $resp) {
            $codcart = $resp[0]["u_codcart"];
        }

        $update_values = array();
        $update_values[] = $codcart;
        $update_values[] = 1;

        $query = "	
            insert into u_acesso_tarefa 
            (
                u_acesso_tarefastamp,
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
                )values(
                (select suser_sname()+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)),
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

    // save fecheado de tarefa
    public function update_tmp_produtos($data, $data2) {

        foreach ($data as $ace) {
            $codcart = $ace["codcart"];
            $tarefastamp = $ace["u_acesso_tarefastamp"];
        }

        $update_values = array();
        $query = "	
			update 
			u_acesso_tarefa
			set 
				horafechado = CONVERT(VARCHAR(8), GETDATE(), 8) ,
				ativo = 2
			where
				codcart = '" . $codcart . "' and
				usrdata = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000'
		";
        $dat = $this->mssql->mssql__prepare_sel($query, $update_values);

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
            $update_values = array();

            $query = "	
            select username
            from us
            where
                U_CODCART = '" . $codcart . "'
        ";
            $dat2 = $this->mssql->mssql__prepare_sel($query, $update_values);
        }
        return $dat2;
    }

    public function fechar_tarefa_artigos_todas($data2, $data3) {
        $u_ncidefParams = array();
        $u_ncidef = $this->nci->getU_ncidef($u_ncidefParams);
        $data = array();
        $data["u_ncidef"] = $u_ncidef[0];
        $update_values = array();

        if ($data["u_ncidef"]['tarefa_registo_stipo'] == 0) {

            foreach ($data2 as $ace) {
                $codcart = $ace["u_codcart"];
                $bostamp = $ace["bostamp"];
            }
            $query = "
				update 
					bo 
				set
					tipo = '2',
					usrhora = CONVERT(VARCHAR(5), GETDATE(), 8)
				where 
					u_codcart = '" . $codcart . "' and
					bostamp = '" . $bostamp . "'
			";
            $dat = $this->mssql->mssql__prepare_sel($query, $update_values);

            foreach ($data3 as $ace2):
                $ststamp = $ace2["ststamp"];
                $qtt = $ace2["qtt"];
                $update_values = array();
                $query = "
					update 
						bi
					set
						qtt = '" . $qtt . "',
						ref = '2'
					where 
					obistamp = '" . $ststamp . "' and
					bostamp = '" . $bostamp . "' 				
				";

                $sql_status = $this->mssql->mssql__prepare_exec($query, $update_values);
            endforeach;

            if ($dat) {
                $update_values = array();

                $query = "	
				select username
				from us
				where
					u_codcart = '" . $codcart . "'
			";
                $dat2 = $this->mssql->mssql__prepare_sel($query, $update_values);
            }
            return $dat2;
        } else {
            $update_values = array();
            foreach ($data2 as $ace) {
                $codcart = $ace["codcart"];
                $tarefastamp = $ace["u_acesso_tarefastamp"];
            }

            $query = "	
				update 
				" . $data["u_ncidef"]['registotarefas'] . " 
				set 
					horafechado = CONVERT(VARCHAR(8), GETDATE(), 8) ,
					ativo = 2
				where
					codcart = '" . $codcart . "' and
					u_acesso_tarefastamp = '" . $tarefastamp . "' and
					usrdata = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000'
			";
            $dat = $this->mssql->mssql__prepare_sel($query, $update_values);

            foreach ($data3 as $ace2):
                $ststamp = $ace2["ststamp"];
                $qtt = $ace2["qtt"];

                $query = "
					update 
					u_produtos_tarefa
					set
						qtt = '" . $qtt . "',
						ativo = '1'
					where 
					ststamp = '" . $ststamp . "' and
					tarefastamp = '" . $tarefastamp . "' 			
				";

                $sql_status = $this->mssql->mssql__prepare_exec($query, $update_values);
            endforeach;

            if ($dat) {
                $update_values = array();

                $query = "	
				select username
				from us
				where
					U_CODCART = '" . $codcart . "'
			";
                $dat2 = $this->mssql->mssql__prepare_sel($query, $update_values);
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
					update 
						bi
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
        }else {
            $update_values = array();
            foreach ($data2 as $ace) {
                $codcart = $ace["codcart"];
                $tarefastamp = $ace["u_acesso_tarefastamp"];
            }

            foreach ($data3 as $ace2):
                $ststamp = $ace2["ststamp"];
                $qtt = $ace2["qtt"];

                $query = "
					update 
					u_produtos_tarefa
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

    public function update_tarefa_dossier($result2, $data2) {
        $u_ncidefParams = array();
        $u_ncidef = $this->nci->getU_ncidef($u_ncidefParams);
        $data = array();
        $data["u_ncidef"] = $u_ncidef[0];
        $ndos = $data["u_ncidef"]['ndostarefas'];

        //dado utilizador
        foreach ($result2 as $res):
            $nome = $res['username'];
            $cod_trabalhador = $res['u_codcart'];
        endforeach;

        $bostamp2 = $this->stamp();
        $update_values = array();

        $query = "
			BEGIN TRANSACTION [Tran1];
			BEGIN TRY ";

        $query .= "

			DECLARE @stamp VARCHAR(25);
			DECLARE @nmdos VARCHAR(25);
			DECLARE @numero INT;
			DECLARE @ndos INT;
			DECLARE @usstamp VARCHAR(25);
			DECLARE @codcart VARCHAR(25);
			
			SET @codcart = '" . $cod_trabalhador . "';
			SET @ndos = '" . $ndos . "';
			SET @stamp = '" . $bostamp2 . "' ;
			SET @nmdos = (select nmdos from ts where ndos = '" . $ndos . "');
			SET @numero = isnull((select max(obrano) + 1 from bo where ndos = @ndos ), 1);
			";

        foreach ($data2 as $ace2):
            $ststamp = $ace2["ststamp"];
            $design = $ace2["design"];
            $qtt = $ace2["qtt"];

            $update_values[] = $design;
            $query .= "
			INSERT INTO 
				bi (
					bistamp, 
					bostamp, 
					nmdos, 
					ndos, 
					obrano,
					design, 
					qtt,
					obistamp,
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
				?,
				'" . $qtt . "',
				'" . $ststamp . "',				
				UPPER(suser_sname()),
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8), 
				UPPER(suser_sname()),
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8),				 
				'1'
			);
			";
        endforeach;

        $update_values[] = $nome;
        $query .= "
			INSERT INTO 
				bo (
				bostamp, 
				nmdos, 
				ndos,
				nome, 
				obrano, 
				u_codcart,
				boano, 
				dataobra, 
				ousrinis, 
				ousrdata,
				ousrhora, 
				usrinis, 
				usrdata, 
				usrhora, 
				tipo)
			VALUES
			(
				@stamp, 
				@nmdos , 
				@ndos , 
				?, 
				@numero,
				@codcart,
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

			";

        $query .= "

			COMMIT TRANSACTION [Tran1] 
			END TRY 
			BEGIN CATCH 
			ROLLBACK TRANSACTION [Tran1] 
			PRINT ERROR_MESSAGE() 
			END CATCH
			";
        $sql_status = $this->mssql->mssql__prepare_exec($query, $update_values);
    }

    public function update_tarefa_tabela($cod_trabalhador, $data2) {
        $u_ncidefParams = array();
        $u_ncidef = $this->nci->getU_ncidef($u_ncidefParams);
        $data = array();
        $data["u_ncidef"] = $u_ncidef[0];

        $stamp = $this->stamp();

        $update_values = array();
        $update_values[] = $stamp;
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
                )values(
                ?,
                '',
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
        $dat = $this->mssql->mssql__prepare_exec($query, $update_values);

        foreach ($data2 as $ace2):
            $ststamp = $ace2["ststamp"];
            $ref = $ace2["ref"];
            $design = $ace2["design"];
            $qtt = $ace2["qtt"];

            $update_values = array();
            $update_values[] = $stamp;
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
            $update_values = array();

            $query = "	
            select username
            from us
            where
                U_CODCART = '" . $cod_trabalhador . "'
        ";
            $dat2 = $this->mssql->mssql__prepare_sel($query, $update_values);
        }
        return $dat2;
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
			BEGIN TRY ";

            $query .= "

			DECLARE @stamp VARCHAR(25);
			DECLARE @nmdos VARCHAR(25);
			DECLARE @numero INT;
			DECLARE @ndos INT;
			DECLARE @usstamp VARCHAR(25);
			DECLARE @desing VARCHAR(25);
			DECLARE @codcart VARCHAR(25);
			DECLARE @dytablestamp VARCHAR(25);
			
			SET @codcart = '" . $cod_trabalhador . "';
			SET @dytablestamp = '" . $stamp_producto . "';
			SET @ndos = '" . $ndos . "';
			SET @desing = 'Tarefa';
			SET @stamp = '" . $bostamp2 . "' ;
			SET @nmdos = (select nmdos from ts where ndos = '" . $ndos . "');
			SET @numero = isnull((select max(obrano) + 1 from bo where ndos = @ndos ), 1);
			";

            $query .= "
			INSERT INTO 
				bi (
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
				@desing,
				
				UPPER(suser_sname()),
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8), 
				UPPER(suser_sname()),
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8),				 
				'1'
			);
			";

            $query .= "
			INSERT INTO 
				bo (
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
				tipo)
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

			";

            $query .= "

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
                )values(
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
				update 
					bo
				set 
				usrhora = CONVERT(VARCHAR(8), GETDATE(), 8) ,
				tipo = 2
			where
				u_codcart = '" . $u_codcart . "' and
				tpstamp = '" . $stamp . "' and
				usrdata = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000'	
		";
            $result = $this->mssql->mssql__prepare_sel($query, $update_values);
            return $result;
        } else {
            $query = "
				update 
					" . $data["u_ncidef"]['registotarefas'] . "
				set 
					horafechado = CONVERT(VARCHAR(8), GETDATE(), 8),
					ativo = 2
				where
					codcart = '" . $u_codcart . "' and
					dytablestamp = '" . $stamp . "' and
					usrdata = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000'
					
			";
            $result = $this->mssql->mssql__prepare_sel($query, $update_values);
            return $result;
        }
    }

    //Apagar dados temporales das tarefas ao fechar chanela
    public function delete_tmp_tarefa($tmp) {

        $this->db->from('ncindustry_tmp_tarefa');
        $this->db->where('token_temp', $tmp);
        $this->db->delete();
    }

    //Apagar dados temporales das tarefas segun ref
    public function delete_tmp_tarefa2($ref) {

        $this->db->from('ncindustry_tmp_tarefa');
        $this->db->where('ststamp', $ref);
        $this->db->delete();
        $result = $this->db->affected_rows();
        if ($result > 0) {
            return $result;
        } else {
            
        }
    }

}
