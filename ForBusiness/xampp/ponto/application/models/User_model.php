<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class User_model extends CI_Model {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function get_user_access( $no, $estab, $acesso, $accessstamp ) {
		
		$data_access_op = array();
		$data_access_op[] = 'agent_new';
		$data_access_op[] = 'agents';
		$data_access_op[] = 'products';
		$data_access_op[] = 'white_label';
		$data_access_op[] = 'product';
		$data_access_op[] = 'product_price';
		$data_access_op[] = 'logout';
		$data_access_op[] = 'upload';
		$data_access_op[] = 'upload_image_voucher';
		$data_access_op[] = 'deletefile';
		$data_access_op[] = 'deletefile_voucher';
		$data_access_op[] = 'generateRandomString';
		$data_access_op[] = 'agent';
		$data_access_op[] = 'ajax';
		$data_access_op[] = 'denied';
		$data_access_op[] = 'rep_orders';
		$data_access_op[] = 'rep_fees';
		$data_access_op[] = 'calendar';
		$data_access_op[] = 'customers';
		$data_access_op[] = 'extras';
		$data_access_op[] = 'customer';
		$data_access_op[] = 'saft';
		$data_access_op[] = 'get_saft';
		$data_access_op[] = 'orders';
		$data_access_op[] = 'settings_profile';
		$data_access_op[] = 'settings_regional';
		$data_access_op[] = 'extras_usage';
		$data_access_op[] = 'vouchers';
		$data_access_op[] = 'voucher';
		$data_access_op[] = 'voucher_new';
		$data_access_op[] = 'settings_users';
		$data_access_op[] = 'user';
		$data_access_op[] = 'dashboard';
		$data_access_op[] = 'pickups';
		$data_access_op[] = 'pickup';
		$data_access_op[] = 'locations';
		$data_access_op[] = 'location';
		$data_access_op[] = 'settings_taxes';
		$data_access_op[] = 'tax';
		$data_access_op[] = 'lastminute';
		$data_access_op[] = 'rep_treasury';
		$data_access_op[] = 'rep_reimbursement';
		$data_access_op[] = '';

		$data_access_ag = array();
		$data_access_ag[] = 'logout';
		$data_access_ag[] = 'upload';
		$data_access_ag[] = 'upload_image_voucher';
		$data_access_ag[] = 'deletefile';
		$data_access_ag[] = 'deletefile_voucher';
		$data_access_ag[] = 'generateRandomString';
		$data_access_ag[] = 'ajax';
		$data_access_ag[] = 'denied';
		$data_access_ag[] = 'orders';
		$data_access_ag[] = 'rep_agent_orders';
		$data_access_ag[] = 'rep_agent_fees';
		$data_access_ag[] = 'agent_reimbursement';
		$data_access_ag[] = 'agent_manual_reimbursement';
		$data_access_ag[] = 'agent_mb_reimbursement';
		$data_access_ag[] = 'fee_receipts';
		$data_access_ag[] = 'add_fee_receipts';
		$data_access_ag[] = 'settings_profile';
		$data_access_ag[] = 'settings_regional';
		$data_access_ag[] = 'dashboard';
		$data_access_ag[] = 'rep_agent_treasury';
		$data_access_ag[] = '';
		
		$this->db->select('u_operador, u_agente');
		$this->db->from('fl');
		$this->db->where('no', $no);
		$this->db->where('estab', $estab);
		$result = $this->db->get();
		$result = $result->result_array();
		
		if( sizeof($result) > 0 ) {
			$operador = $result[0]["u_operador"];
			$agente = $result[0]["u_agente"];
		}
		else {
			$operador = "Não";
			$agente = "Não";
		}
		
		//variavel para acesso
		$tem_acesso_pagina = 0;
		$tem_acesso_funcao = 0;
		
		//verificar se acesso agente
		if( in_array($acesso, $data_access_op) && $operador == "Sim" ) {
			$tem_acesso_pagina = 1;
		}
		//verificar se acesso operador
		if( in_array($acesso, $data_access_ag) && $agente == "Sim" ) {
			$tem_acesso_pagina = 1;
		}
		
		//verificar se acesso funcao	
		$this->db->select('access');
		$this->db->from('u_access');
		$this->db->where('op', $no);
		$this->db->where('estab', $estab);
		$this->db->where('u_accessliststamp', $accessstamp);
		$result = $this->db->get();
		$result = $result->result_array();

		if( sizeof($result) > 0 )
			$tem_acesso_funcao = $result[0]["access"];
		else
			$tem_acesso_funcao = 0;
		
		//agregar os acessos
		if( trim($acesso) != "" && trim($accessstamp) == "" ) {
			return $tem_acesso_pagina;
		}
		if( trim($acesso) != "" && trim($accessstamp) != "" ) {
			if( $estab == 0 ) {
				return 1;
			}
			else {
				if( $tem_acesso_pagina && $tem_acesso_funcao )
					return 1;
				else
					return 0;
			}
		}
		if( trim($acesso) == "" && trim($accessstamp) != "" ) {
			if( $estab == 0 ) {
				return 1;
			}
			else {
				return $tem_acesso_funcao;
			}
		}
	}
	
	public function get_operator_users( $op ) {
		$this->db->select('*');
		$this->db->from('fl');
		$this->db->where('no', $op);
		$this->db->where('estab <>', 0);
		$result = $this->db->get();
		$result = $result->result_array();
		
		return $result;
	}
	
	public function get_operator_users_mssql( $op ) {
		$query = "select * from fl where no = " . $op . " and estab <> 0 order by nome";
		$result = $this->mssql->mssql__select( $query );
		
		return $result;
	}
	
	public function get_taxes_mssql( $op ) {
		$query = "
			select * 
			from u_tax 
			where no = " . $op . " order by tax";
		$result = $this->mssql->mssql__select( $query );
		
		return $result;
	}
	
	public function update_backoffice_user( $data ) {
		$data['input'] = json_decode($data['input']);
		$data['access'] = json_decode($data['access']);

		$this->mssql->utf8_decode_deep( $data );
		
		$update_query = "";
		$update_where = "";

		//atualizacao dados fornecedor
		if( isset($data['input']->fl) ) {
			foreach( $data['input']->fl as $key=>$value ) {
				$update_query .= $key . " = '" . $value . "', ";
			}
		}

		$update_query = substr($update_query, 0, strlen($update_query) - 2);
		$update_where .= "no = " . $data['no'] . " and estab = " . $data['estab'];

		if( $update_query != "" ) {
			$query = "update fl set " . $update_query . " where " . $update_where;
			$sql_status = $this->mssql->mssql__execute( $query );
		}

		//atualizacao acessos fornecedor
		if( sizeof($data['access']) > 0 ) {
			foreach( $data['access'] as $acesso ) {
				$query = "update u_access set access = " . $acesso[1] . " where u_accessstamp = '" . $acesso[0] . "'";
				$sql_status = $this->mssql->mssql__execute( $query );
			}
		}
		
		$result = array();
		$result["success"] = 1;
		
		echo json_encode( $result );
	}
	
	public function access_maintenance( $op ) {
		
		$query = "select * from u_accesslist";
		$acessos = $this->mssql->mssql__select( $query );
		
		$query = "select distinct estab from fl where no = " . $op . " and estab <> 0";
		$estabs = $this->mssql->mssql__select( $query );
		
		foreach( $acessos as $acesso ) {
			foreach( $estabs as $estab ) {
				$query = "select * from u_access where op = " . $op . " and estab = " . $estab["estab"] . " and u_accessliststamp = '" . $acesso["u_accessliststamp"] . "'";
				$result = $this->mssql->mssql__select( $query );
				// nao existe permission. deve ser criado
				if( sizeof($result) == 0 ) {
					$update_values = array();
					$update_values[] = $op;
					$update_values[] = $estab["estab"];
					$update_values[] = $acesso["group"];
					$update_values[] = $acesso["permission"];
					$update_values[] = 1;
					$update_values[] = $acesso["u_accessliststamp"];

					$query = "
						DECLARE @stamp VARCHAR(25);

						SET @stamp = CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)));
						
						insert into u_access (
							u_accessstamp,
							op,
							estab,
							[group],
							permission,
							access,
							u_accessliststamp,
							ousrdata,
							ousrhora,
							ousrinis,
							usrdata,
							usrhora,
							usrinis
						)
						values(
							@stamp,
							?,
							?,
							?,
							?,
							?,
							?,
							convert(date, getdate()), 
							left(convert(time, getdate()),8),
							isnull((select iniciais from us (nolock) where username= suser_sname()), ''),
							convert(date, getdate()), 
							left(convert(time, getdate()),8),
							isnull((select iniciais from us (nolock) where username= suser_sname()), '')
						)
					";
					
					$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				}
			}
		}
		
		$result = array();
		$result["success"] = 1;
		
		echo json_encode( $result );
	}
	
	public function get_user_access_mssql( $op, $estab ) {
		$query = "select * from u_access where op = ".$op." and estab = ".$estab." order by [group] asc, permission asc";
		$sql_status = $this->mssql->mssql__select( $query );
		return $sql_status;
	}
	
	public function create_op_user( $data ) {
		//name
		//op
		$flstamp = $this->mssql->stamp();
		
		$update_values = array();
		$update_values[] = $data["op"];
		$update_values[] = $data["op"];
		$update_values[] = $flstamp;
		$update_values[] = $data["name"];
		$update_values[] = $data["op"];
		$update_values[] = 'Sim';
		$update_values[] = 1;
		$update_values[] = utf8_decode('Não');
		$update_values[] = $this->phc_model->generateRandomString();
		
		$query = "
			DECLARE @numero INT;
			DECLARE @nif VARCHAR(20);

			SET @numero = isnull((select max(estab) + 1 from fl where no = ?), 1);
			SET @nif = isnull((select top 1 ncont from fl where no = ? and estab = 0), '');
			
			insert into fl (
				flstamp,
				nome,
				no,
				estab,
				moeda,
				ncont,
				u_operador,
				u_autoriz,
				u_agente,
				u_pass,
				ousrdata,
				ousrhora,
				ousrinis,
				usrdata,
				usrhora,
				usrinis
			)
			values(
				?,
				?,
				?,
				@numero,
				'EURO',
				@nif,
				?,
				?,
				?,
				?,
				convert(date, getdate()), 
				left(convert(time, getdate()),8),
				isnull((select iniciais from us (nolock) where username= suser_sname()), ''),
				convert(date, getdate()), 
				left(convert(time, getdate()),8),
				isnull((select iniciais from us (nolock) where username= suser_sname()), '')
			)
		";
		
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		
		$query = "
			select top 1 estab
			from fl
			where flstamp = '" . $flstamp . "'
		";
		$result = $this->mssql->mssql__select( $query );
		
		if( sizeof($result) > 0 ) {
			$estab = $result[0]["estab"];
			
			$query = "select * from u_accesslist";
			$acessos = $this->mssql->mssql__select( $query );
			
			foreach( $acessos as $acesso ) {
				$update_values = array();
				$update_values[] = $data["op"];
				$update_values[] = $estab;
				$update_values[] = $acesso["group"];
				$update_values[] = $acesso["permission"];
				$update_values[] = 1;
				$update_values[] = $acesso["u_accessliststamp"];

				$query = "
					DECLARE @stamp VARCHAR(25);

					SET @stamp = CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)));
					
					insert into u_access (
						u_accessstamp,
						op,
						estab,
						[group],
						permission,
						access,
						u_accessliststamp,
						ousrdata,
						ousrhora,
						ousrinis,
						usrdata,
						usrhora,
						usrinis
					)
					values(
						@stamp,
						?,
						?,
						?,
						?,
						?,
						?,
						convert(date, getdate()), 
                        left(convert(time, getdate()),8),
						isnull((select iniciais from us (nolock) where username= suser_sname()), ''),
						convert(date, getdate()), 
                        left(convert(time, getdate()),8),
						isnull((select iniciais from us (nolock) where username= suser_sname()), '')
					)
				";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			}
		}
		else {
			$estab = 0;
		}
		
		$result = array();
		$result["estab"] = $estab;
		$result["success"] = 1;
		
		echo json_encode( $result );
	}
	
	/**
	 * create_user function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $email
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function create_user($email, $password, $facebook_login, $params = array()) {
		
		$data = array(
			'email'      => $email,
			'password'   => $this->hash_password($password),
			'facebook_login'   => $facebook_login,
			'created_at' => date('Y-m-j H:i:s'),
			'updated_at' => date('Y-m-j H:i:s'),
			'gender' => 'male'
		);
		
		if( sizeof($params) > 0 ) {
			$data["first_name"] = $params["first_name"];
			$data["last_name"] = $params["last_name"];
			if( trim($params["gender"]) != '' ) {
				$data["gender"] = $params["gender"];
			}
		}
		
		return $this->db->insert('users', $data);
		
	}
	
	/**
	 * resolve_user_login function.
	 * 
	 * @access public
	 * @param mixed $email
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function resolve_user_login($email, $password) {
		$this->db->select('password');
		$this->db->from('users');
		$this->db->where('email', $email);
		$this->db->where('facebook_login', 0);
		$hash = $this->db->get()->row('password');
		
		return $this->verify_password_hash($password, $hash);
	}
	
	public function resolve_user_login_agent($agent_id, $password) {
		
		$this->db->select('u_pass');
		$this->db->from('fl');
		$this->db->where('no', $agent_id);
		$this->db->where('u_pass', $password);
		$result = $this->db->get();
		$result = $result->result_array();
		
		return sizeof($result);
	}

	public function resolve_backoffice_user_login($no, $estab, $password) {
		
		$this->db->select('u_pass');
		$this->db->from('fl');
		$this->db->where('no', $no);
		$this->db->where('estab', $estab);
		$hash = $this->db->get()->row('u_pass');
		
		return ($password == $hash);
	}
	
	/**
	 * resolve_user_login_facebook function.
	 * 
	 * @access public
	 * @param mixed $email
	 * @return bool true on success, false on failure
	 */
	public function resolve_user_login_facebook($email) {
		
		$this->db->select('password');
		$this->db->from('users');
		$this->db->where('email', $email);
		$this->db->where('facebook_login', 1);
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	/**
	 * get_user_id_from_email function.
	 * 
	 * @access public
	 * @param mixed $email
	 * @return int the user id
	 */
	public function get_user_id_from_email($email) {
		
		$this->db->select('id');
		$this->db->from('users');
		$this->db->where('email', $email);

		return $this->db->get()->row('id');
		
	}
	
	/**
	 * get_user function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user($user_id) {
		
		$this->db->from('users');
		$this->db->where('id', $user_id);
		return $this->db->get()->row_array();
		
	}
	
	public function get_agent($agent_id) {
		
		$this->db->from('fl');
		$this->db->where('no', $agent_id);
		return $this->db->get()->row_array();
		
	}
	
	public function get_backoffice_user($user_id, $estab) {
		$this->db->from('fl');
		$this->db->where('no', $user_id);
		$this->db->where('estab', $estab);
		return $this->db->get()->row_array();
	}
	
	public function get_backoffice_user_mssql($user_id, $estab) {
		$query = "select * from fl where no = " . $user_id . " and estab = " . $estab;
		$result = $this->mssql->mssql__select( $query );
		
		if( sizeof($result) > 0 )
			return $result[0];
		else
			return array();
	}
	
	/**
	 * hash_password function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @return string|bool could be a string on success, or bool false on failure
	 */
	private function hash_password($password) {
		
		return password_hash($password, PASSWORD_BCRYPT);
		
	}
	
	/**
	 * verify_password_hash function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @param mixed $hash
	 * @return bool
	 */
	private function verify_password_hash($password, $hash) {
		
		return password_verify($password, $hash);
		
	}
	
	/**
	 * check_email_exist function.
	 * 
	 * @access public
	 * @param mixed $email
	 * @return number of users
	 */
	public function check_email_exist($email) {
		
		$this->db->from('users');
		$this->db->where('email', $email);
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	/**
	 * update_user function.
	 * 
	 * @access public
	 * @param mixed $id
	 * @param mixed $post data
	 * @return bool true on success, false on failure
	 */
	public function update_user($user_id, $params) {
		
		$data = array(
			'first_name'   => $params["First_Name"],
			'last_name'   => $params["Last_Name"],
			'tax_number' => $params["Tax_identification_number"],
			'date_birth' => $params["Date_Of_Birth"],
			'gender' => $params["Gender"],
			'invoice_address_street' => $params["Street"],
			'invoice_address_addinfo' => $params["Aditional_Info"],
			'invoice_address_resnumber' => $params["Residence_Number"],
			'invoice_address_postcode' => $params["Postcode"],
			'invoice_address_country' => $params["Country"],
			'phone_no' => $params["phoneno"]
		);
		
		$this->db->where('id', $user_id);
		return $this->db->update('users', $data);
	}
	
}