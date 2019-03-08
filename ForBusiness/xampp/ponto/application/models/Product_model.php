<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Product_model extends CI_Model {

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
	
	public function get_iva_mssql() {
		$query = "
			select *
			from taxasiva
			where taxa <> 0
			order by codigo
		";

		$result = $this->mssql->mssql__select( $query );
		return $result;
	}
	
	public function get_iva() {
		$this->db->select('*');
		$this->db->from('taxasiva');
		$this->db->order_by('codigo');
		$query = $this->db->get();
		$query = $query->result_array();
		
		return $query;
	}
	
	public function create_lastminute( $data ) {
		
		$this->mssql->utf8_decode_deep( $data );
		
		$query = "delete from u_lastminute where no = " . $data["no"];
		$sql_status = $this->mssql->mssql__execute( $query );
		
		foreach( $data["lastmin"] as $lastmin ) {
			
			$query = "
				select *
				from u_tax
				where u_taxstamp = '" . $lastmin["u_taxstamp"] . "'
			";
			$result = $this->mssql->mssql__select( $query );
			
			if( sizeof($result)>0 ) {
				$formula = $result[0]["formula"];
			}
			else {
				$formula = "";
			}
			
			if( (strlen($formula) > 0 && substr($formula,0,1) == "-") || strlen($formula) == 0 ) {
				$update_values = array();
				$update_values[] = $lastmin["bostamp"];
				$update_values[] = $lastmin["u_taxstamp"];
				$update_values[] = $lastmin["lorder"];
				$update_values[] = $data["no"];
				
				$query = "insert into u_lastminute (
					u_lastminutestamp,
					bostamp,
					u_taxstamp,
					lorder,
					no,
					ousrdata,
					ousrhora,
					ousrinis,
					usrdata,
					usrhora,
					usrinis
				) values (
					CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
					?,
					?,
					?,
					?,
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8), 
					UPPER(suser_sname()), 
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8),
					UPPER(suser_sname())
				) 
				";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			}
		}
		
		return 1;
	}
	
	public function update_agent( $data ) {
		$query = "
			update fl set 
				gsecstamp = '" . $data["u_locationstamp"] . "', u_local = isnull((select top 1 name from u_location where u_locationstamp = '" . $data["u_locationstamp"] . "'), '') 
			where
				no = '" . $data["agent"] . "' and estab = 0
		";
		
		$sql_status = $this->mssql->mssql__execute( $query );
		return $sql_status;
	}
	
	public function get_lastminute_taxes( $bostamp ) {
		$this->db->select("
		u_tax.*
		");
		$this->db->from('u_lastminute');
		$this->db->join('u_tax', 'u_lastminute.u_taxstamp = u_tax.u_taxstamp');
		$this->db->where('u_lastminute.bostamp', $bostamp);
		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function update_tax( $data ) {
		$this->mssql->utf8_decode_deep( $data );
		
		$update_query = "";
		$update_values = array();
		$update_where = "";
		
		if( isset($data['input']->u_tax) ) {
			foreach( $data['input']->u_tax as $key=>$value ) {
				$update_query .= $key . " = ?, ";
				$update_values[] = $value;
				
				if( $key == "formula" )
					$formula = $value;
			}
		}

		$update_query = substr($update_query, 0, strlen($update_query) - 2);
		$update_where .= "u_taxstamp = '" . $data['u_taxstamp'] . "' and no = " . $data['no'];
		
		if( $update_query != "" ) {
			$query = "update u_tax set " . $update_query . " where " . $update_where;
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			
			if( strlen($formula)>0 && substr($formula,0,1) == "-" ) {
				$query = "delete from u_ptax where u_taxstamp = '" . $data["u_taxstamp"] . "'";
				$sql_status = $this->mssql->mssql__execute( $query );
			}
			
			if( strlen($formula)>0 && substr($formula,0,1) == "+" ) {
				$query = "delete from u_lastminute where u_taxstamp = '" . $data["u_taxstamp"] . "'";
				$sql_status = $this->mssql->mssql__execute( $query );
			}
			
			return $sql_status;
		}
		else {
			return 0;
		}
	}
	
	public function update_pickup( $data ) {
		
		$this->mssql->utf8_decode_deep( $data );
		
		$update_query = "";
		$update_values = array();
		$update_where = "";
		
		if( isset($data['input']->u_pickup) ) {
			foreach( $data['input']->u_pickup as $key=>$value ) {
				$update_query .= $key . " = ?, ";
				$update_values[] = $value;
			}
		}

		$update_query = substr($update_query, 0, strlen($update_query) - 2);
		$update_where .= "u_pickupstamp = '" . $data['u_pickupstamp'] . "' and no = " . $data['no'];
		
		if( $update_query != "" ) {
			$query = "update u_pickup set " . $update_query . " where " . $update_where;
			
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			
			return $sql_status;
		}
		else {
			return 0;
		}
	}
	
	public function delete_tax( $data ) {
		
		$query = "
			delete from u_tax where u_taxstamp = '" . $data["stamp"] . "' and no = '" . $data["no"] . "'
		";
		
		$sql_status = $this->mssql->mssql__execute( $query );
		
		if( $sql_status ) {
			$query = "
				delete from u_ptax where u_taxstamp = '" . $data["stamp"] . "'
			";
			$sql_status = $this->mssql->mssql__execute( $query );
			
			return $sql_status;
		}
		
		return $sql_status;
	}
	
	public function delete_pickup( $data ) {
		
		$query = "
			delete from u_pickup where u_pickupstamp = '" . $data["stamp"] . "' and no = '" . $data["no"] . "'
		";
		
		$sql_status = $this->mssql->mssql__execute( $query );
		
		if( $sql_status ) {
			$query = "
				delete from u_ppickup where u_pickupstamp = '" . $data["stamp"] . "'
			";
			$sql_status = $this->mssql->mssql__execute( $query );
			
			return $sql_status;
		}
		
		return $sql_status;
	}
	
	public function update_location( $data ) {
		
		$this->mssql->utf8_decode_deep( $data );
		
		$update_query = "";
		$update_values = array();
		$update_where = "";
		
		if( isset($data['input']->u_location) ) {
			foreach( $data['input']->u_location as $key=>$value ) {
				$update_query .= $key . " = ?, ";
				$update_values[] = $value;
			}
		}

		$update_query = substr($update_query, 0, strlen($update_query) - 2);
		$update_where .= "u_locationstamp = '" . $data['u_locationstamp'] . "' and no = " . $data['no'];
		
		if( $update_query != "" ) {
			$query = "update u_location set " . $update_query . " where " . $update_where;
			
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			
			return $sql_status;
		}
		else {
			return 0;
		}
	}
	
	public function delete_location( $data ) {
		
		$query = "
			delete from u_location where u_locationstamp = '" . $data["stamp"] . "' and no = '" . $data["no"] . "'
		";
		
		$sql_status = $this->mssql->mssql__execute( $query );
		
		if( $sql_status ) {
			$query = "
				update fl set gsecstamp = '', u_local = '' where gsecstamp = '" . $data["stamp"] . "'
			";
			$sql_status = $this->mssql->mssql__execute( $query );
			
			return $sql_status;
		}
		
		return $sql_status;
	}
	
	public function create_location( $data ) {
		$this->mssql->utf8_decode_deep( $data );
		
		$query = "
			select *
			from u_location (nolock)
			where 
				no = " . $data["no"] . " and
				rtrim(ltrim(name)) = rtrim(ltrim('" . $data["name"] . "'))
		";

		$query = $this->mssql->mssql__select( $query );
		
		if( sizeof($query) == 0 ) {
			$update_values = array();
			$update_values[] = $data["name"];
			$update_values[] = $data["no"];
			
			$query = "insert into u_location (
				u_locationstamp,
				name,
				no,
				address,
				postcode,
				city,
				country,
				latitude,
				longitude,
				ousrdata,
				ousrhora,
				ousrinis,
				usrdata,
				usrhora,
				usrinis
			) values (
				CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
				?,
				?,
				'',
				'',
				'',
				'',
				'',
				'',
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8), 
				UPPER(suser_sname()), 
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8),
				UPPER(suser_sname())
			) 
			";
			
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			
			$query = "
				select *
				from u_location (nolock)
				where 
					no = " . $data["no"] . " and
					name = '" . $data["name"] . "'
				order by name
			";

			$query = $this->mssql->mssql__select( $query );

			$result_ar = array();
			if( sizeof($query) > 0 ) {
				$result_ar["u_locationstamp"] = $query[0]["u_locationstamp"];
				$result_ar["success"] = 1;
			}
			else {
				$result_ar["u_locationstamp"] = "";
				$result_ar["success"] = 0;
			}
		}
		else {
			$result_ar["u_locationstamp"] = "";
			$result_ar["success"] = -1;
		}
		
		return $result_ar;
	}
	
	public function create_tax( $data ) {
		$this->mssql->utf8_decode_deep( $data );
		
		$query = "
			select *
			from u_tax (nolock)
			where 
				no = " . $data["no"] . " and
				rtrim(ltrim(tax)) = rtrim(ltrim('" . $data["name"] . "'))
		";

		$query = $this->mssql->mssql__select( $query );
		
		if( sizeof($query) == 0 ) {
			$update_values = array();
			$update_values[] = $data["name"];
			$update_values[] = $data["no"];
			$update_values[] = $data["no"];
			
			$query = "insert into u_tax (
				u_taxstamp,
				tax,
				value,
				no,
				formula,
				ousrdata,
				ousrhora,
				ousrinis,
				usrdata,
				usrhora,
				usrinis
			) values (
				CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
				?,
				0,
				?,
				'',
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8), 
				UPPER(suser_sname()), 
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8),
				UPPER(suser_sname())
			) 
			";
			
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			
			$query = "
				select *
				from u_tax (nolock)
				where 
					no = " . $data["no"] . " and
					tax = '" . $data["name"] . "'
				order by tax
			";

			$query = $this->mssql->mssql__select( $query );

			$result_ar = array();
			if( sizeof($query) > 0 ) {
				$result_ar["u_taxstamp"] = $query[0]["u_taxstamp"];
				$result_ar["success"] = 1;
			}
			else {
				$result_ar["u_taxstamp"] = "";
				$result_ar["success"] = 0;
			}
		}
		else {
			$result_ar["u_taxstamp"] = "";
			$result_ar["success"] = -1;
		}
		
		return $result_ar;
	}
	
	public function create_pickup( $data ) {
		$this->mssql->utf8_decode_deep( $data );
		
		$query = "
			select *
			from u_pickup (nolock)
			where 
				no = " . $data["no"] . " and
				rtrim(ltrim(name)) = rtrim(ltrim('" . $data["name"] . "'))
		";

		$query = $this->mssql->mssql__select( $query );
		
		if( sizeof($query) == 0 ) {
			$update_values = array();
			$update_values[] = $data["name"];
			$update_values[] = $data["no"];
			
			$query = "insert into u_pickup (
				u_pickupstamp,
				name,
				no,
				address,
				postcode,
				city,
				country,
				latitude,
				longitude,
				ousrdata,
				ousrhora,
				ousrinis,
				usrdata,
				usrhora,
				usrinis
			) values (
				CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
				?,
				?,
				'',
				'',
				'',
				'',
				'',
				'',
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8), 
				UPPER(suser_sname()), 
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8),
				UPPER(suser_sname())
			) 
			";
			
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			
			$query = "
				select *
				from u_pickup (nolock)
				where 
					no = " . $data["no"] . " and
					name = '" . $data["name"] . "'
				order by name
			";

			$query = $this->mssql->mssql__select( $query );

			$result_ar = array();
			if( sizeof($query) > 0 ) {
				$result_ar["u_pickupstamp"] = $query[0]["u_pickupstamp"];
				$result_ar["success"] = 1;
			}
			else {
				$result_ar["u_pickupstamp"] = "";
				$result_ar["success"] = 0;
			}
		}
		else {
			$result_ar["u_pickupstamp"] = "";
			$result_ar["success"] = -1;
		}
		
		return $result_ar;
	}
	
	public function get_locations_mssql( $no ) {
		$query = "
			select *
			from u_location (nolock)
			where 
				no = " . $no . " 
			order by name
		";
		$query = $this->mssql->mssql__select( $query );
		return $query;
	}
	
	public function get_pickups_mssql( $no ) {
		$query = "
			select *
			from u_pickup (nolock)
			where 
				no = " . $no . " 
			order by name
		";
		$query = $this->mssql->mssql__select( $query );
		return $query;
	}
	
	public function get_ppickups_mssql( $no ) {
		$query = "
			select *
			from u_ppickup (nolock)
			inner join bo on u_ppickup.bostamp = bo.bostamp
			inner join u_pickup on u_ppickup.u_pickupstamp = u_pickup.u_pickupstamp
			where 
				bo.no = " . $no . " 
			order by u_pickup.name
		";
		$query = $this->mssql->mssql__select( $query );
		return $query;
	}
	

	
	public function get_lastminute_mssql( $no ) {
		$query = "
			select *
			from u_lastminute (nolock)
			inner join bo on u_lastminute.bostamp = bo.bostamp
			left join u_tax on u_lastminute.u_taxstamp = u_tax.u_taxstamp
			where 
				u_lastminute.no = " . $no . " 
			order by u_lastminute.lorder
		";
		$query = $this->mssql->mssql__select( $query );
		return $query;
	}
	
	public function get_tax_mssql( $u_taxstamp, $no ) {
		$query = "
			select *
			from u_tax (nolock)
			where 
				no = " . $no . " and
				u_taxstamp = '" . $u_taxstamp . "'
			order by tax
		";
		$query = $this->mssql->mssql__select( $query );
		
		if( sizeof($query) > 0 )
			return $query[0];
		
		return $query;
	}
	
	public function get_pickup_mssql( $u_pickupstamp, $no ) {
		$query = "
			select *
			from u_pickup (nolock)
			where 
				no = " . $no . " and
				u_pickupstamp = '" . $u_pickupstamp . "'
			order by name
		";
		$query = $this->mssql->mssql__select( $query );
		
		if( sizeof($query) > 0 )
			return $query[0];
		
		return $query;
	}
	
	public function get_product_taxes_mssql( $bostamp ) {
		$query = "
			select *
			from u_ptax (nolock)
			where 
				bostamp = '" . $bostamp . "'
			order by tax
		";
		$query = $this->mssql->mssql__select( $query );
		
		return $query;
	}
	
	public function get_location_mssql( $locationstamp, $no ) {
		$query = "
			select *
			from u_location (nolock)
			where 
				no = " . $no . " and u_locationstamp = '" . $locationstamp . "'
		";
		$query = $this->mssql->mssql__select( $query );
		
		if( sizeof($query) > 0 )
			return $query[0];
		
		return $query;
	}
	
	public function cria_relproduct( $bostamp, $relprodbostamp ) {
		
		$query = "
			select *
			from u_relprod (nolock)
			where 
				bostamp = '" . $bostamp . "' and
				relprodbostamp = '" . $relprodbostamp . "'
		";
		$query = $this->mssql->mssql__select( $query );
		if( sizeof($query) == 0 ) {
			$update_values = array();
			$update_values[] = $bostamp;
			$update_values[] = $relprodbostamp;
			
			$query = "insert into u_relprod (
				u_relprodstamp,
				bostamp,
				relprodbostamp,
				ousrdata,
				ousrhora,
				ousrinis,
				usrdata,
				usrhora,
				usrinis
			) values (
				CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
				?,
				?,
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8), 
				UPPER(suser_sname()), 
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8),
				UPPER(suser_sname())
			) 
			";
			
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			return $sql_status;
		}
		else {
			return 1;
		}
	}
	
	public function cria_pickupproduct( $bostamp, $u_pickupstamp ) {
		
		$query = "
			select *
			from u_ppickup (nolock)
			where 
				bostamp = '" . $bostamp . "' and
				u_pickupstamp = '" . $u_pickupstamp . "'
		";
		$query = $this->mssql->mssql__select( $query );
		if( sizeof($query) == 0 ) {
			$update_values = array();
			$update_values[] = $bostamp;
			$update_values[] = $u_pickupstamp;
			
			$query = "insert into u_ppickup (
				u_ppickupstamp,
				bostamp,
				u_pickupstamp,
				ousrdata,
				ousrhora,
				ousrinis,
				usrdata,
				usrhora,
				usrinis
			) values (
				CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
				?,
				?,
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8), 
				UPPER(suser_sname()), 
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8),
				UPPER(suser_sname())
			) 
			";
			
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			return $sql_status;
		}
		else {
			return 1;
		}
	}
	
	public function apaga_pickupproduct( $bostamp, $u_pickupstamp ) {
		$update_values = array();
		$update_values[] = $bostamp;
		$update_values[] = $u_pickupstamp;
		
		$query = "delete from u_ppickup where bostamp = ? and u_pickupstamp = ?";
		
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		return $sql_status;
	}
	
	public function cria_taxproduct( $bostamp, $u_taxstamp ) {
		$query = "
			select *
			from u_tax (nolock)
			where 
				u_taxstamp = '" . $u_taxstamp . "'
		";
		$query = $this->mssql->mssql__select( $query );
		
		if( sizeof($query) > 0 ) {
			$tax = $query[0];
			
			if( $tax["formula"] == "-v" || $tax["formula"] == "-%" ) {
				$update_values = array();
				$update_values[] = $bostamp;
				$update_values[] = $u_taxstamp;
				
				$query = "delete from u_ptax where bostamp = ? and u_taxstamp = ?";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				return $sql_status;
			}
			else {
				$query = "
					select *
					from u_ptax (nolock)
					where 
						bostamp = '" . $bostamp . "' and
						u_taxstamp = '" . $u_taxstamp . "'
				";
				$query = $this->mssql->mssql__select( $query );
				
				if( sizeof($query) == 0 ) {
					$update_values = array();
					$update_values[] = $bostamp;
					$update_values[] = $u_taxstamp;
					$update_values[] = $u_taxstamp;
					
					$query = "insert into u_ptax (
						u_ptaxstamp,
						bostamp,
						u_taxstamp,
						tax,
						ousrdata,
						ousrhora,
						ousrinis,
						usrdata,
						usrhora,
						usrinis
					) values (
						CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
						?,
						?,
						(select top 1 tax from u_tax where u_taxstamp = ?),
						CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
						CONVERT(VARCHAR(5), GETDATE(), 8), 
						UPPER(suser_sname()), 
						CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
						CONVERT(VARCHAR(5), GETDATE(), 8),
						UPPER(suser_sname())
					) 
					";
					
					$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
					return $sql_status;
				}
				else {
					return 1;
				}
			}
		}
		else {
			return 1;
		}
	}
	
	public function apaga_taxproduct( $bostamp, $u_taxstamp ) {
		$update_values = array();
		$update_values[] = $bostamp;
		$update_values[] = $u_taxstamp;
		
		$query = "delete from u_ptax where bostamp = ? and u_taxstamp = ?";
		
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		return $sql_status;
	}
	
	public function apaga_relproduct( $bostamp, $relprodbostamp ) {
		$update_values = array();
		$update_values[] = $bostamp;
		$update_values[] = $relprodbostamp;
		
		$query = "delete from u_relprod where bostamp = ? and relprodbostamp = ?";
		
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		return $sql_status;
	}
	
	public function get_customers_by_id( $operator,$customer_id ) {
		$this->db->select("
		*
		");
		$this->db->distinct();
		$this->db->from('users');
		$this->db->where('op', $operator);
		$this->db->where('id', $customer_id);

		return $this->db->get()->row_array();
	}

	public function get_customers( $operator ) {
		$this->db->select("
		*
		");
		$this->db->distinct();
		$this->db->from('users');
		$this->db->where('op', $operator);

		$query = $this->db->get();
		$query = $query->result_array();
		return $query;
	}

	public function get_filters($parametros) {
		$dates = array();
		$categories = array();
		$destinations = array();
		$cities = array();
		$languages = array();
		$duration = array();
		$search_str = array();

		if( sizeof($parametros) > 0 ) {
			foreach($parametros as $key=>$value) {
				switch ($key) {
					case 'da':
						$dates = explode('|', trim($value));
						break;
					case 'c':
						$categories = explode('|', trim($value));
						break;
					case 'd':
						$destinations = explode('|', trim($value));
						break;
					case 'dc':
						$cities = explode('|', trim($value));
						break;
					case 'l':
						$languages = explode('|', trim($value));
						break;
					case 'du':
						$duration = explode('|', trim($value));
						break;
					case 's':
						$search_str = trim($value);
						$search_str = explode(' ', $search_str);
						break;
				}
			}
		}

		$filters = array();
		
		//destinations
		$this->db->select('bo3.u_country');
		$this->db->distinct();
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->where('u_country !=', '');
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.estab = 0');
		$this->db->order_by('u_country', 'ASC');
		$query = $this->db->get();
		$tmp = array();
		foreach( $query->result_array() as $row ) {
			$tmp[] = $row["u_country"];
		}
		$filters["destinations"] = $tmp;
		$filters["destinations_filtered"] = $destinations;
		
		//cities
		$this->db->select('bo3.u_city');
		$this->db->distinct();
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->where('u_city !=', '');
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.estab = 0');
		$this->db->order_by('u_city', 'ASC');
		$query = $this->db->get();
		$tmp = array();
		foreach( $query->result_array() as $row ) {
			$tmp[] = $row["u_city"];
		}
		$filters["cities"] = $tmp;
		$filters["cities_filtered"] = $cities;
		
		//categories
		$this->db->select('u_pcateg.category');
		$this->db->distinct();
		$this->db->from('u_pcateg');
		$this->db->order_by('category', 'ASC');
		$query = $this->db->get();
		$tmp = array();
		foreach( $query->result_array() as $row ) {
			$tmp[] = $row["category"];
		}
		$filters["categories"] = $tmp;
		$filters["categories_filtered"] = $categories;
		
		//languages
		$this->db->select('u_plang.language');
		$this->db->distinct();
		$this->db->from('u_plang');
		$this->db->order_by('language', 'ASC');
		$query = $this->db->get();
		$tmp = array();
		foreach( $query->result_array() as $row ) {
			$tmp[] = $row["language"];
		}
		$filters["languages"] = $tmp;
		$filters["languages_filtered"] = $languages;
		
		//duration
		$tmp = array('1', '2', '3', '4', '5');
		$filters["duration"] = $tmp;
		$filters["duration_filtered"] = $duration;
		
		//search_string
		$filters["search_str"] = $search_str;
		
		return $filters;
	}
	
	public function get_products($filters, $limit = "", $start = "", $ewapage = 0) {
		
		$this->db->limit($limit, $start);
		
		$this->db->select("
		bo.*,
		bo2.*,
		bo3.*,
		IFNULL((select img from u_pimg where u_pimg.bostamp = bo.bostamp LIMIT 1),'') img
		");
		$this->db->distinct();
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->join('fl', 'bo.no = fl.no and fl.estab = 0');
		$this->db->join('u_pcateg', 'bo.bostamp = u_pcateg.bostamp', 'left');
		$this->db->join('u_plang', 'bo.bostamp = u_plang.bostamp', 'left');
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.estab = 0');
		if( $ewapage ) {
			$this->db->where('bo3.u_ewadisab = 0');
			$this->db->where('fl.u_ewadisab = 0');
		}
		
		//destinations
		if( sizeof($filters["destinations_filtered"])>0 ) {
			$tmp_string = "(";
			foreach( $filters["destinations_filtered"] as $destination ) {
				$tmp_string .= 'bo3.u_country =' . $this->db->escape($destination) . ' OR ';
			}
			$tmp_string = substr($tmp_string, 0, strlen($tmp_string)-3) . ')';
			$this->db->where($tmp_string);
		}
		
		//cities
		if( sizeof($filters["cities_filtered"])>0 ) {
			$tmp_string = "(";
			foreach( $filters["cities_filtered"] as $city ) {
				$tmp_string .= 'bo3.u_city =' . $this->db->escape($city) . ' OR ';
			}
			$tmp_string = substr($tmp_string, 0, strlen($tmp_string)-3) . ')';
			$this->db->where($tmp_string);
		}
		
		//categories
		if( sizeof($filters["categories_filtered"])>0 ) {
			$tmp_string = "(";
			foreach( $filters["categories_filtered"] as $category ) {
				$tmp_string .= 'u_pcateg.category =' . $this->db->escape($category) . ' OR ';
			}
			$tmp_string = substr($tmp_string, 0, strlen($tmp_string)-3) . ')';
			$this->db->where($tmp_string);
		}
		
		//languages
		if( sizeof($filters["languages_filtered"])>0 ) {
			$tmp_string = "(";
			foreach( $filters["languages_filtered"] as $language ) {
				$tmp_string .= 'u_plang.language =' . $this->db->escape($language) . ' OR ';
			}
			$tmp_string = substr($tmp_string, 0, strlen($tmp_string)-3) . ')';
			$this->db->where($tmp_string);
		}
		
		//duration
		if( sizeof($filters["duration_filtered"])>0 ) {
			$tmp_string = "(";
			foreach( $filters["duration_filtered"] as $duration ) {
				switch($duration) {
					case '1':
						$tmp_string .= 'case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end >= 0 AND case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end <= 3 OR ';
						break;
					case '2':
						$tmp_string .= 'case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end >= 3 AND case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end <= 5 OR ';
						break;
					case '3':
						$tmp_string .= 'case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end >= 5 AND case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end <= 7 OR ';
						break;
					case '4':
						$tmp_string .= 'case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end >= 7 AND case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end <= 24 OR ';
						break;
					case '5':
						$tmp_string .= 'case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end >= 24 OR';
						break;
				}
			}
			$tmp_string = substr($tmp_string, 0, strlen($tmp_string)-3) . ')';
			$this->db->where($tmp_string);
		}
		
		//search_string
		foreach( $filters["search_str"] as $search_val ) {
			$this->db->where( " (bo3.u_country like '%" . $search_val . "%' or bo3.u_city like '%" . $search_val . "%' or bo.u_name like '%" . $search_val . "%' or u_pcateg.category like '%" . $search_val . "%' ) " );
		}
		
		$query = $this->db->get();
		return $query;
	}
	
	public function operator_get_products( $operator ) {
		$this->db->select("
		bo.*,
		bo2.*,
		bo3.*
		");
		$this->db->distinct();
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.no', $operator);
		$this->db->where('bo.estab = 0');
		$this->db->order_by('bo.u_name');
		
		$query = $this->db->get();
		$query = $query->result_array();
		return $query;
	}
	
	public function operator_get_products_mssql( $operator ) {
		$query = "
			select bo.*, bo2.*, bo3.*
			from bo (nolock)
				inner join bo2 (nolock) on bo.bostamp = bo2.bo2stamp
				inner join bo3 (nolock) on bo.bostamp = bo3.bo3stamp
			where 
				bo.ndos = 1 and
				bo.no = ".$operator." and
				bo.estab = 0
			order by
				rtrim(ltrim(bo.u_name))
			";
		$query = $this->mssql->mssql__select( $query );
		return $query;
	}
	
	public function get_related_products_mssql( $bostamp ) {
		$query = "
			select u_relprod.*
			from u_relprod (nolock)
				inner join bo (nolock) on u_relprod.bostamp = bo.bostamp
			where 
				u_relprod.bostamp = '".$bostamp."'
			order by
				rtrim(ltrim(bo.u_name))
			";
		$query = $this->mssql->mssql__select( $query );
		return $query;
	}
	
	public function operator_get_product_mssql( $operator, $sefurl ) {
		$query = "
			select bo.*, bo2.*, bo3.*
			from bo 
				inner join bo2 on bo.bostamp = bo2.bo2stamp
				inner join bo3 on bo.bostamp = bo3.bo3stamp
			where 
				bo3.u_sefurl = '".$sefurl."' and 
				bo.ndos = 1 and
				bo.no = ".$operator." and
				bo.estab = 0
			";
		$query = $this->mssql->mssql__select( $query );
		return $query;
	}
	
	public function operator_get_agents_mssql( $operator ) {
		$query = "
			select B.*
			from u_agop
			inner join fl A on u_agop.opstamp = A.flstamp
			inner join fl B on u_agop.agstamp = B.flstamp
			where 
				A.no = ".$operator." and
				A.estab = 0
			";
		$query = $this->mssql->mssql__select( $query );
		return $query;
	}
	
	public function operator_get_session_mssql( $operator, $sefurl ) {
		$query = "
			select u_psess.*
			from u_psess 
				inner join bo on u_psess.bostamp = bo.bostamp
				inner join bo3 on bo.bostamp = bo3.bo3stamp
			where 
				bo3.u_sefurl = '".$sefurl."' and 
				bo.ndos = 1 and
				bo.no = ".$operator." and
				bo.estab = 0
			";
		$query = $this->mssql->mssql__select( $query );
		return $query;
	}
	
	public function operator_get_exclusi_mssql( $operator, $sefurl ) {
		$query = "
			select u_pexcl.*
			from u_pexcl 
				inner join bo on u_pexcl.bostamp = bo.bostamp
				inner join bo3 on bo.bostamp = bo3.bo3stamp
			where 
				bo3.u_sefurl = '".$sefurl."' and 
				bo.ndos = 1 and
				bo.no = ".$operator." and
				bo.estab = 0
			";
		$query = $this->mssql->mssql__select( $query );
		return $query;
	}	
	
	public function operator_get_languag_mssql( $operator, $sefurl ) {
		$query = "
			select u_plang.*
			from u_plang 
				inner join bo on u_plang.bostamp = bo.bostamp
				inner join bo3 on bo.bostamp = bo3.bo3stamp
			where 
				bo3.u_sefurl = '".$sefurl."' and 
				bo.ndos = 1 and
				bo.no = ".$operator." and
				bo.estab = 0
			";
		$query = $this->mssql->mssql__select( $query );
		return $query;
	}
	
	public function operator_get_lang_mssql() {
		$query = "
			select * from u_lang (nolock)
			";
		$query = $this->mssql->mssql__select( $query );
		return $query;
	}
	
	public function operator_get_product( $operator, $sefurl ) {
		$this->db->select("
		bo.*,
		bo2.*,
		bo3.*
		");
		$this->db->distinct();
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.no', $operator);
		$this->db->where('bo.estab = 0');
		$this->db->where('bo3.u_sefurl', $sefurl);
		
		$query = $this->db->get();
		$query = $query->result_array();
		return $query;
	}
	
	public function operator_get_session( $operator, $sefurl ) {
		$this->db->select("
		u_psess.*
		");
		$this->db->distinct();
		$this->db->from('u_psess');
		$this->db->join('bo', 'u_psess.bostamp = bo.bostamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.no', $operator);
		$this->db->where('bo.estab = 0');
		$this->db->where('bo3.u_sefurl', $sefurl);
		
		$query = $this->db->get();
		$query = $query->result_array();
		return $query;
	}
	
	public function get_product_data( $sefurl, $ewapage = 0 ) {
		$this->db->select('
		bo.*,
		bo2.*,
		bo3.*
		');
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->join('fl', 'bo.no = fl.no and fl.estab = 0');
		$this->db->where('bo3.u_sefurl', $sefurl);
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.estab = 0');
		if( $ewapage ) {
			$this->db->where('bo3.u_ewadisab = 0');
			$this->db->where('fl.u_ewadisab = 0');
		}
		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_product_data_stamp( $bostamp ) {
		$this->db->select('
		bo.*,
		bo2.*,
		bo3.*
		');
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->where('bo.bostamp', $bostamp);
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.estab = 0');
		$query = $this->db->get();
		return $query;
	}
	
	public function get_tickets() {
		$this->db->select('
		u_tick.*
		');
		$this->db->from('u_tick');
		$this->db->order_by('ticket', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_tickets_mssql() {
		$query = "
			select u_tick.* 
			from u_tick
			order by
				ticket ASC
			";
		$query = $this->mssql->mssql__select( $query );
		return $query;
	}
	
	public function get_product_tickets( $sefurl ) {
		$this->db->select('
		u_ptick.*
		');
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->join('u_ptick', 'bo.bostamp = u_ptick.bostamp');
		$this->db->where('bo3.u_sefurl', $sefurl);
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.estab = 0');
		$this->db->order_by('ticket', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_product_tickets_mssql( $sefurl ) {
		$query = "
			select u_ptick.* 
			from bo 
				inner join bo2 on bo.bostamp = bo2.bo2stamp
				inner join bo3 on bo.bostamp = bo3.bo3stamp
				inner join u_ptick on bo.bostamp = u_ptick.bostamp
			where 
				bo3.u_sefurl = '".$sefurl."' and 
				bo.ndos = 1 and
				bo.estab = 0
			order by
				ticket ASC
			";
		$query = $this->mssql->mssql__select( $query );
		return $query;
	}
	
	public function get_product_tickets_numbers_mssql( $sefurl ) {
		$query = "
			select u_pntick.* 
			from bo 
				inner join bo2 on bo.bostamp = bo2.bo2stamp
				inner join bo3 on bo.bostamp = bo3.bo3stamp
				inner join u_pntick on bo.bostamp = u_pntick.bostamp
			where 
				bo3.u_sefurl = '".$sefurl."' and 
				bo.ndos = 1 and
				bo.estab = 0
			order by
				u_pntick.no ASC
			";
		$query = $this->mssql->mssql__select( $query );
		return $query;
	}
	
	public function get_product_tickets_numbers( $sefurl ) {
		$this->db->select('
		u_pntick.*
		');
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->join('u_pntick', 'bo.bostamp = u_pntick.bostamp');
		$this->db->where('bo3.u_sefurl', $sefurl);
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.estab = 0');
		$this->db->order_by('no', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_product_seats( $sefurl ) {
		$this->db->select('
		u_pseat.*
		');
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->join('u_pseat', 'bo.bostamp = u_pseat.bostamp');
		$this->db->where('bo3.u_sefurl', $sefurl);
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.estab = 0');
		$this->db->order_by('seat', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_product_seats_mssql( $sefurl ) {
		$query = "
			select u_pseat.* 
			from bo 
				inner join bo2 on bo.bostamp = bo2.bo2stamp
				inner join bo3 on bo.bostamp = bo3.bo3stamp
				inner join u_pseat on bo.bostamp = u_pseat.bostamp
			where 
				bo3.u_sefurl = '".$sefurl."' and 
				bo.ndos = 1 and
				bo.estab = 0
			order by
				CONVERT(VARCHAR(254), seat) ASC
			";
		$query = $this->mssql->mssql__select( $query );
		return $query;
	}
	
	public function get_product_prices_by_ref( $ref ) {
		$this->db->select('
		sx.*
		');
		$this->db->from('sx');
		$this->db->where('sx.ref', $ref);
		$this->db->order_by('cor', 'ASC');
		$this->db->order_by('tam', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function update_product_price( $data ) {
		foreach( $data["prices"] as $price ) {
			$update_values = array();
			$update_values[] = $price[2];
			$update_values[] = $price[2] * 200.482;
			$update_values[] = $price[0];
			$update_values[] = $price[1];
			
			$update_values[] = $data["ref"];
			
			$query = "update sx set epv1 = ?, pv1 = ? where cor = ? and tam = ? and ref = ?";
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		}
		
		$result = array();
		$result["success"] = 1;
		$result["message"] = "Product's prices updated successfully";
		
		echo json_encode( $result );
	}
	
	public function get_product_img( $sefurl ) {
		$this->db->select('
		u_pimg.*
		');
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->join('u_pimg', 'bo.bostamp = u_pimg.bostamp');
		$this->db->where('bo3.u_sefurl', $sefurl);
		$this->db->where("u_pimg.img <> ''");
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.estab = 0');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_countries(  ) {
		$this->db->select('*');
		$this->db->from('u_countries');
		$this->db->order_by('printable_name', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function search_product( $query_search ) {
		
		$query_search = trim($query_search);
		$query_search = explode(' ', $query_search);
		
		$result_array = array();
		
		// paises
		$this->db->select('bo3.u_country label, bo3.u_country id');
		$this->db->distinct();
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.estab = 0');
		foreach( $query_search as $search_val ) {
			$this->db->where( " (bo3.u_country like '%" . $search_val . "%') " );
		}

		$query = $this->db->get();
		$result_array = $query->result_array();
		
		// cidades
		$this->db->select('bo3.u_city label, bo3.u_city id');
		$this->db->distinct();
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.estab = 0');
		foreach( $query_search as $search_val ) {
			$this->db->where( " (bo3.u_city like '%" . $search_val . "%') " );
		}

		$query = $this->db->get();
		$result_array = array_merge($result_array, $query->result_array());
		
		// categorias
		$this->db->select('u_pcateg.category label, u_pcateg.category id');
		$this->db->distinct();
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->join('u_pcateg', 'bo.bostamp = u_pcateg.bostamp');
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.estab = 0');
		foreach( $query_search as $search_val ) {
			$this->db->where( " (u_pcateg.category like '%" . $search_val . "%') " );
		}

		$query = $this->db->get();
		$result_array = array_merge($result_array, $query->result_array());
		
		// artigos
		$this->db->select('bo.u_name label, bo.bostamp id');
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.estab = 0');
		foreach( $query_search as $search_val ) {
			$this->db->where( " (bo3.u_country like '%" . $search_val . "%' or bo3.u_city like '%" . $search_val . "%' or bo.u_name like '%" . $search_val . "%') " );
		}

		$query = $this->db->get();
		$result_array = array_merge($result_array, $query->result_array());
		return $result_array;
	}
	
	public function search_product_wl( $query_search, $no ) {
		
		$query_search = trim($query_search);
		$query_search = explode(' ', $query_search);
		
		$result_array = array();
		
		// paises
		$this->db->select('bo3.u_country label, bo3.u_country id');
		$this->db->distinct();
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.estab = 0');
		$this->db->where('bo.no',$no);
		foreach( $query_search as $search_val ) {
			$this->db->where( " (bo3.u_country like '%" . $search_val . "%') " );
		}

		$query = $this->db->get();
		$result_array = $query->result_array();
		
		// cidades
		$this->db->select('bo3.u_city label, bo3.u_city id');
		$this->db->distinct();
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.estab = 0');
		$this->db->where('bo.no',$no);
		foreach( $query_search as $search_val ) {
			$this->db->where( " (bo3.u_city like '%" . $search_val . "%') " );
		}

		$query = $this->db->get();
		$result_array = array_merge($result_array, $query->result_array());
		
		// categorias
		$this->db->select('u_pcateg.category label, u_pcateg.category id');
		$this->db->distinct();
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->join('u_pcateg', 'bo.bostamp = u_pcateg.bostamp');
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.estab = 0');
		$this->db->where('bo.no',$no);
		foreach( $query_search as $search_val ) {
			$this->db->where( " (u_pcateg.category like '%" . $search_val . "%') " );
		}

		$query = $this->db->get();
		$result_array = array_merge($result_array, $query->result_array());
		
		// artigos
		$this->db->select('bo.u_name label, bo.bostamp id');
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.estab = 0');
		$this->db->where('bo.no',$no);
		foreach( $query_search as $search_val ) {
			$this->db->where( " (bo3.u_country like '%" . $search_val . "%' or bo3.u_city like '%" . $search_val . "%' or bo.u_name like '%" . $search_val . "%') " );
		}

		$query = $this->db->get();
		$result_array = array_merge($result_array, $query->result_array());
		return $result_array;
	}
	
	public function cria_grelha_mssql( $cor, $tam, $ref, $u_pseatstamp, $u_ptickstamp, $preço = -1 ) {
		//verificar se grelha ja existe
		$query = "select * from sx where ref = '".$ref."' and cor = '".$cor."' and tam = '".$tam."'";
		$query = $this->mssql->mssql__select( $query );
		
		//se nao existir, cria
		if( sizeof($query) == 0 ) {
			$update_values = array();
			$update_values[] = $ref;
			$update_values[] = $cor;
			$update_values[] = $tam;
			if( $preço > -1 ) {
				$update_values[] = $preço;
				$update_values[] = $preço * 200.482;
			}
			else {
				$update_values[] = 0;
				$update_values[] = 0;
			}
			$update_values[] = $ref;
			
			$query = "insert into sx (
				sxstamp,
				stock,
				ref,
				armazem,
				cor,
				tam,
				epv1,
				pv1,
				ststamp,
				ousrdata,
				ousrhora,
				ousrinis,
				usrdata,
				usrhora,
				usrinis
			) values (
				CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
				0,
				?,
				1,
				?,
				?,
				?,
				?,
				isnull((select ststamp from st where ref = ?), ''),
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8), 
				UPPER(suser_sname()), 
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8),
				UPPER(suser_sname())
			) 
			";
			
			$sql_status2 = $this->mssql->mssql__prepare_exec( $query, $update_values );
		}
		
		//verificar se cor ja existe no sgc
		$query = "select * from sgc where ref = '".$ref."' and cor = '".$cor."'";
		$query = $this->mssql->mssql__select( $query );
		
		//se nao existir, cria
		if( sizeof($query) == 0 ) {
			$update_values = array();
			$update_values[] = $ref;
			$update_values[] = $cor;
			$update_values[] = $ref;
			$update_values[] = $u_pseatstamp;
			
			$query = "insert into sgc (
				sgcstamp,
				ref,
				cor,
				ststamp,
				u_pseat,
				ousrdata,
				ousrhora,
				ousrinis,
				usrdata,
				usrhora,
				usrinis
			) values (
				CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
				?,
				?,
				isnull((select ststamp from st where ref = ?), ''),
				?,
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8), 
				UPPER(suser_sname()), 
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8),
				UPPER(suser_sname())
			) 
			";
			
			$sql_status2 = $this->mssql->mssql__prepare_exec( $query, $update_values );
		}
		
		//verificar se tam ja existe no sgc
		$query = "select * from sgt where ref = '".$ref."' and tam = '".$tam."'";
		$query = $this->mssql->mssql__select( $query ); 
		
		//se nao existir, cria
		if( sizeof($query) == 0 ) {
			$update_values = array();
			$update_values[] = $ref;
			$update_values[] = $tam;
			$update_values[] = $ref;
			$update_values[] = $u_ptickstamp;
			
			$query = "insert into sgt (
				sgtstamp,
				ref,
				tam,
				ststamp,
				u_ptick,
				ousrdata,
				ousrhora,
				ousrinis,
				usrdata,
				usrhora,
				usrinis
			) values (
				CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
				?,
				?,
				isnull((select ststamp from st where ref = ?), ''),
				?,
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8), 
				UPPER(suser_sname()), 
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8),
				UPPER(suser_sname())
			) 
			";
			
			$sql_status2 = $this->mssql->mssql__prepare_exec( $query, $update_values );
		}
	}

	public function get_product_extras_mssql( $sefurl ) {
		$query = "
		select u_prec.* 
		from bo 
		inner join bo2 on bo.bostamp = bo2.bo2stamp
		inner join bo3 on bo.bostamp = bo3.bo3stamp
		inner join u_prec on bo.bostamp = u_prec.bostamp
		where 
		bo3.u_sefurl = '".$sefurl."' and 
		bo.ndos = 1 and
		bo.estab = 0
		order by
		ref ASC
		";
		$query = $this->mssql->mssql__select( $query );
		return $query;
	}

	
	public function get_extras_mssql($operator) {
		$query = "
		select * 
		from bi
		where ndos = 3 and
		no = ".$operator." and estab = 0
		order by
					   ref ASC
		";
		$query = $this->mssql->mssql__select( $query );
		return $query;
	}
	
	public function apaga_extra( $ref, $bostamp ) {

		//apagar de u_prec
		$update_values = array();
		$update_values[] = $ref;
		$update_values[] = $bostamp;

		$query = "delete from u_prec where ref = ? and bostamp = ?";
		$sql_status2 = $this->mssql->mssql__prepare_exec( $query, $update_values );

	}
                
	public function cria_extra( $ref, $design,$qtt,$price,$extra,$varbilh, $bostamp ) {

		// u_prec
		$query = "select * from u_prec where ref = '".$ref."' and bostamp = '".$bostamp."'";

		$query = $this->mssql->mssql__select( $query );

		if( $extra ){
			$extra = 1;
		}else{
			$extra = 0;
		}

		if( $varbilh ) {
			$varbilh = 1;
		}else {
			$varbilh = 0;
		}
		//se nao existir, cria
		if( sizeof($query) == 0 ) {
			$update_values = array();
			$update_values[] = $bostamp;
			$update_values[] = $ref;                                             
			$update_values[] = $design;
			$update_values[] = $qtt;
			$update_values[] = $price;
			$update_values[] = $extra;
			$update_values[] = $varbilh;

			$query = "insert into u_prec (
			u_precstamp,
			u_rgrpstamp,
			bostamp,
			ref,
			design,
			qtt,
			price,
			extra,
			varbilh,
			rgrp,
			ousrdata,
			ousrhora,
			ousrinis,
			usrdata,
			usrhora,
			usrinis
			) values (
			CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
			'',
			?,
			?,
			?,
			?,
			?,
			?,
			?,
			'',
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
			CONVERT(VARCHAR(5), GETDATE(), 8), 
			UPPER(suser_sname()), 
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
			CONVERT(VARCHAR(5), GETDATE(), 8),
			UPPER(suser_sname())
			)
			";

			$sql_status2 = $this->mssql->mssql__prepare_exec( $query, $update_values );
		}
		else {
			$update_values = array();
			$update_values[] = $qtt;
			$update_values[] = $price;
			$update_values[] = $extra;
			$update_values[] = $varbilh;
			$update_values[] = $ref;
			$update_values[] = $bostamp;

			$query = "update u_prec set qtt = ?,price = ?,extra = ?,varbilh = ? where ref = ? and bostamp = ?";
			$sql_status2 = $this->mssql->mssql__prepare_exec( $query, $update_values );
		}
	}

	public function operator_get_payment_mssql($user_type,$id ) {
	$query = "
	select BO2.IDENTIFICACAO1 as payment
	from bo
	inner join bo2 (nolock) on bo.bostamp = bo2.bo2stamp
	where bo2.".$user_type." = ".$id." and bo.estab = 0
	group by IDENTIFICACAO1
	";
	$query = $this->mssql->mssql__select( $query );
	return $query;
	}

	public function operator_get_local_mssql( $operator) {
	$query = "
	select campo 
	from dytable 
	where entityname = 'a_zonas'
	";
	$query = $this->mssql->mssql__select( $query );
	return $query;
	}

	public function get_order_bystamp( $stamp, $usertype ) {
		$query = "
		select bo.*,(select nome from fl where no = bo2.TKHDID and estab = 0) agent,bo3.U_SESSDATE,BO2.IDENTIFICACAO2,BO2.NOMECTS,BO2.TKHDID,isnull((select u_name from bo a where bostamp=bo.origem), '') product,(select ihour from u_psess where u_psessstamp = bo3.u_psessstp) ihour,BO.ebo12_iva+BO.ebo22_iva+BO.ebo32_iva+BO.ebo42_iva+BO.ebo52_iva+BO.ebo62_iva + BO.etotaldeb etotal
		from bo (nolock)
		inner join bo2 (nolock) on bo.bostamp = bo2.bo2stamp
		inner join bo3 (nolock) on bo.bostamp = bo3.bo3stamp
		inner join fl (nolock) on bo2.$usertype = fl.no and bo.estab = fl.estab
		where bo.ndos = 4 and bo.estab = 0
		and BO.BOSTAMP  ='".$stamp."'

		";
		$sql_status = $this->mssql->mssql__select( $query );
		// log_message("ERROR", print_r($query, true) );
		return $sql_status;
	}
	
	public function get_order_bi_bystamp( $stamp ) {
	$query = "
	select *
	from bi (nolock)
	where BOSTAMP  ='".$stamp."'
	";
	//log_message("ERROR",$query );
	$sql_status = $this->mssql->mssql__select( $query );
	return $sql_status;

	}

	//o ricardo tem esta função
	public function agent_get_operators_mssql( $agent ) {
	$query = "
	select A.*
	from u_agop
	inner join fl A on u_agop.opstamp = A.flstamp and A.estab = 0
	inner join fl B on u_agop.agstamp = B.flstamp and B.estab = 0 
	where 
	B.no = ".$agent."
	";
	$query = $this->mssql->mssql__select( $query );
	return $query;
	}

	//o ricardo tem esta função
	public function agent_get_products_mssql( $agent ) {
	$query = "
	select bo.*, bo2.*, bo3.*
	from bo (nolock)
	inner join bo2 (nolock) on bo.bostamp = bo2.bo2stamp
	inner join bo3 (nolock) on bo.bostamp = bo3.bo3stamp
	inner join u_pagent (nolock) on u_pagent.bostamp = bo.bostamp
	where 
	bo.ndos = 1 and
	bo.estab = 0 and
	u_pagent.no = ".$agent."
	";
	$query = $this->mssql->mssql__select( $query );
	return $query;
	}

	
	public function apaga_tam( $u_tickstamp, $bostamp ) {
		$query = "select bo.obrano, u_sefurl from bo inner join bo3 on bo.bostamp = bo3.bo3stamp where bostamp = '".$bostamp."'";
		$query = $this->mssql->mssql__select( $query );
		$obrano = $query[0]["obrano"];
		
		$query = "select ticket, u_tickstamp from u_tick where u_tickstamp = '".$u_tickstamp."'";
		$query = $this->mssql->mssql__select( $query );
		$tam = $query[0]["ticket"];
		$u_tickstamp = $query[0]["u_tickstamp"];
		
		$query = "select ref from st where ref like 'P.".$obrano.".%'";
		$refs = $this->mssql->mssql__select( $query );
		
		//apagar de u_ptick
		$update_values = array();
		$update_values[] = $u_tickstamp;
		$update_values[] = $bostamp;
		
		$query = "delete from u_ptick where u_tickstamp = ? and bostamp = ?";
		$sql_status2 = $this->mssql->mssql__prepare_exec( $query, $update_values );
		
		foreach( $refs as $ref ) {
			//apagar de sgt
			$update_values = array();
			$update_values[] = $ref['ref'];	
			$update_values[] = $tam;	

			$query = "delete from sgt where ref = ? and tam = ?";
			$sql_status2 = $this->mssql->mssql__prepare_exec( $query, $update_values );
			
			//apagar de sx
			$update_values = array();
			$update_values[] = $ref['ref'];	
			$update_values[] = $tam;	
			$query = "delete from sx where ref = ? and tam = ?";
			$sql_status2 = $this->mssql->mssql__prepare_exec( $query, $update_values );
		}
	}
	
	public function cria_tam( $u_tickstamp, $custom_name, $bostamp ) {
		$query = "select bo.obrano, u_sefurl from bo inner join bo3 on bo.bostamp = bo3.bo3stamp where bostamp = '".$bostamp."'";
		$query = $this->mssql->mssql__select( $query );
		$obrano = $query[0]["obrano"];
		$u_sefurl = $query[0]["u_sefurl"];
		
		$query = "select id, ticket, u_tickstamp from u_tick where u_tickstamp = '".$u_tickstamp."'";
		$query = $this->mssql->mssql__select( $query );
		$tam = $query[0]["ticket"];
		$u_tickstamp = $query[0]["u_tickstamp"];
		$id = $query[0]["id"];
		
		$query = "select ref from st where ref like 'P.".$obrano.".%'";
		$refs = $this->mssql->mssql__select( $query );
		
		$cores = $this->get_product_seats( $u_sefurl );
		
		// u_ptick
		$query = "select * from u_ptick where u_tickstamp = '".$u_tickstamp."' and bostamp = '".$bostamp."'";
		$query = $this->mssql->mssql__select( $query );
		
		//se nao existir, cria
		if( sizeof($query) == 0 ) {
			$update_values = array();
			$update_values[] = $u_tickstamp;
			$update_values[] = $bostamp;
			$update_values[] = $id;
			$update_values[] = $tam;
			$update_values[] = $custom_name;
			
			$query = "insert into u_ptick (
				u_ptickstamp,
				u_tickstamp,
				bostamp,
				id,
				ticket,
				name,
				ousrdata,
				ousrhora,
				ousrinis,
				usrdata,
				usrhora,
				usrinis
			) values (
				CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
				?,
				?,
				?,
				?,
				?,
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8), 
				UPPER(suser_sname()), 
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8),
				UPPER(suser_sname())
			) 
			";
			
			$sql_status2 = $this->mssql->mssql__prepare_exec( $query, $update_values );
		}
		else {
			$update_values = array();
			$update_values[] = $custom_name;
			$update_values[] = $u_tickstamp;
			$update_values[] = $bostamp;
			
			$query = "update u_ptick set name = ? where u_tickstamp = ? and bostamp = ?";
			$sql_status2 = $this->mssql->mssql__prepare_exec( $query, $update_values );
		}
		
		foreach( $refs as $ref ) {
			foreach( $cores as $cor ) {
				$query = "select * from sx where ref = '".$ref['ref']."' and cor = '".$cor['seat']."' and tam = '".$tam."'";
				$query = $this->mssql->mssql__select( $query );
		
				//se nao existir, cria
				if( sizeof($query) == 0 ) {
					$update_values = array();
					$update_values[] = $ref['ref'];
					$update_values[] = $cor->seat;
					$update_values[] = $tam;
					$update_values[] = 0;
					$update_values[] = 0;
					$update_values[] = $ref['ref'];
					
					$query = "insert into sx (
						sxstamp,
						stock,
						ref,
						armazem,
						cor,
						tam,
						epv1,
						pv1,
						ststamp,
						ousrdata,
						ousrhora,
						ousrinis,
						usrdata,
						usrhora,
						usrinis
					) values (
						CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
						0,
						?,
						1,
						?,
						?,
						?,
						?,
						isnull((select ststamp from st where ref = ?), ''),
						CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
						CONVERT(VARCHAR(5), GETDATE(), 8), 
						UPPER(suser_sname()), 
						CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
						CONVERT(VARCHAR(5), GETDATE(), 8),
						UPPER(suser_sname())
					) 
					";
					
					$sql_status2 = $this->mssql->mssql__prepare_exec( $query, $update_values );
				}
		
				//verificar se tam ja existe no sgt
				$query = "select * from sgt where ref = '".$ref['ref']."' and tam = '".$tam."'";
				$query = $this->mssql->mssql__select( $query );
		
				//se nao existir, cria
				if( sizeof($query) == 0 ) {
					$update_values = array();
					$update_values[] = $ref['ref'];
					$update_values[] = $tam;
					$update_values[] = $ref['ref'];
					$update_values[] = $u_tickstamp;
					
					$query = "insert into sgt (
						sgtstamp,
						ref,
						tam,
						ststamp,
						u_ptick,
						ousrdata,
						ousrhora,
						ousrinis,
						usrdata,
						usrhora,
						usrinis
					) values (
						CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
						?,
						?,
						isnull((select ststamp from st where ref = ?), ''),
						?,
						CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
						CONVERT(VARCHAR(5), GETDATE(), 8), 
						UPPER(suser_sname()), 
						CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
						CONVERT(VARCHAR(5), GETDATE(), 8),
						UPPER(suser_sname())
					) 
					";
					
					$sql_status2 = $this->mssql->mssql__prepare_exec( $query, $update_values );
				}
			}
		}
	}
	
	public function create_product_mssql( $data ) {
		
		$this->mssql->utf8_decode_deep( $data );
		$operator = $data["user"];
		
		$update_values = array();
		//bo bo2 bo3
		$update_values[] = 'Produto';
		$update_values[] = $operator["nome"];
		$update_values[] = $operator["no"];
		$update_values[] = 1;
		$update_values[] = $operator["morada"];
		$update_values[] = $operator["local"];
		$update_values[] = $operator["codpost"];
		$update_values[] = $operator["ncont"];
		$update_values[] = $data['product_name'];
		$update_values[] = $this->generate_seo_link( $data['product_name'] );
		//st
		$update_values[] = substr($data['product_name'], 0, 60);
		$update_values[] = 'PRODUTOS';
		$update_values[] = 'Produtos';
		$update_values[] = 1;
		$update_values[] = 1;
		$update_values[] = 1;
		//stobs
		$update_values[] = 'O';
		
		$query = "
		BEGIN TRANSACTION [Tran1];
		BEGIN TRY 

		DECLARE @stamp VARCHAR(25);
		DECLARE @numero INT;

		SET @stamp = CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)));
		SET @numero = isnull((select max(obrano) + 1 from bo where ndos = 1), 1);
		
		insert into bo (
			bostamp,
			nmdos,
			obrano,
			dataobra,
			nome,
			no,
			obranome,
			boano,
			dataopen,
			ndos,
			moeda,
			morada,
			local,
			codpost,
			ncont,
			memissao,
			origem,
			u_name,
			u_qttmin,
			ousrdata,
			ousrhora,
			ousrinis,
			usrdata,
			usrhora,
			usrinis
		) values (
			@stamp,
			?,
			@numero,
			CONVERT(VARCHAR(10), GETDATE(), 20),
			?,
			?,
			'P.' + rtrim(ltrim(CONVERT(VARCHAR(15), @numero))) + '.0',
			year(getdate()),
			CONVERT(VARCHAR(10), GETDATE(), 20),
			?,
			'EURO',
			?,
			?,
			?,
			?,
			'EURO',
			'BO',
			?,
			1,
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
			CONVERT(VARCHAR(5), GETDATE(), 8), 
			UPPER(suser_sname()), 
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
			CONVERT(VARCHAR(5), GETDATE(), 8),
			UPPER(suser_sname())
		)
		
		INSERT INTO bo2 (bo2stamp, idserie, tiposaft) values 
		(
			@stamp, 
			'BO', 
			(select top 1 tiposaft from ts where ndos = 1)
		)
		
		INSERT INTO bo3 (bo3stamp, u_sefurl,u_country,u_latitude,u_longitud) values 
		(
			@stamp,
			?,
			'Portugal',
			'41.15794596785979',
			'-8.629202842712402'
		)

		insert into st (
			ststamp,
			ref,
			design,
			familia,
			faminome,
			stns,
			iva1incl,
			texteis,
			tabiva,
			ousrdata,
			ousrhora,
			ousrinis,
			usrdata,
			usrhora,
			usrinis
		) values (
			CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
			'P.' + rtrim(ltrim(CONVERT(VARCHAR(15), @numero))) + '.0',
			?,
			?,
			?,
			?,
			?,
			?,
			2,
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
			CONVERT(VARCHAR(5), GETDATE(), 8), 
			UPPER(suser_sname()), 
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
			CONVERT(VARCHAR(5), GETDATE(), 8),
			UPPER(suser_sname())
		)
		
		insert into stobs (
			stobsstamp,
			ref,
			tipoprod,
			u_bostamp,
			ousrdata,
			ousrhora,
			ousrinis,
			usrdata,
			usrhora,
			usrinis
		) values (
			CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
			'P.' + rtrim(ltrim(CONVERT(VARCHAR(15), @numero))) + '.0',
			?,
			@stamp,
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
			CONVERT(VARCHAR(5), GETDATE(), 8), 
			UPPER(suser_sname()), 
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
			CONVERT(VARCHAR(5), GETDATE(), 8),
			UPPER(suser_sname())
		) 
		
		COMMIT TRANSACTION [Tran1] 
		END TRY 
		BEGIN CATCH 
		ROLLBACK TRANSACTION [Tran1] 
		PRINT ERROR_MESSAGE() 
		END CATCH
		
		";
		
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		$res_update["stobs_ins"] = $sql_status;
		
		$result = array();
		$result["success"] = 1;
		$result["sefurl"] = $this->generate_seo_link( $data['product_name'] );
		
		echo json_encode( $result );
	}
	

	
	public function generate_seo_link($input, $replace = '-', $remove_words = true, $words_array = array()) {
		//make it lowercase, remove punctuation, remove multiple/leading/ending spaces
		$return = trim(preg_replace('/ +/', ' ', preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($input))));

		//remove words, if not helpful to seo
		//i like my defaults list in remove_words(), so I wont pass that array
		if($remove_words) { $return = $this->remove_words($return, $replace, $words_array); }

		//convert the spaces to whatever the user wants
		//usually a dash or underscore..
		//...then return the value.
		return str_replace(' ', $replace, $return);
	}

	public function remove_words($input,$replace,$words_array = array(),$unique_words = true)
	{
		//separate all words based on spaces
		$input_array = explode(' ',$input);

		//create the return array
		$return = array();

		//loops through words, remove bad words, keep good ones
		foreach($input_array as $word)
		{
			//if it's a word we should add...
			if(!in_array($word,$words_array) && ($unique_words ? !in_array($word,$return) : true))
			{
				$return[] = $word;
			}
		}

		//return good words separated by dashes
		return implode($replace,$return);
	}
	
	public function apaga_grelha_mssql( $ref ) {
		$update_values = array();
		$update_values[] = $ref;
		
		$query = "delete from sx where ref = ?";
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		
		$query = "delete from sgc where ref = ?";
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		
		$query = "delete from sgt where ref = ?";
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
	}
	
	public function apaga_artigo_mssql( $ref ) {
		$update_values = array();
		$update_values[] = $ref;
		
		$query = "delete from st where ref = ?";
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		
		$query = "delete from stobs where ref = ?";
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
	}
	
	public function stamp() {
		$query = "select CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))) stamp";
		$query = $this->mssql->mssql__select( $query );
		return $query[0]["stamp"];
	}
	
	public function update_product( $data ) {
		$res_update = array();
		
		$data['input'] = json_decode($data['input']);
		$data['textarea'] = json_decode($data['textarea']);
		$data['checkbox'] = json_decode($data['checkbox']);
		$data['scheduling_table'] = json_decode($data['scheduling_table']);
		$data['exclusion_table'] = json_decode($data['exclusion_table']);
		$data['language_table'] = json_decode($data['language_table']);
		$data['tickets_table'] = json_decode($data['tickets_table']);
		$data['ticket_num_table'] = json_decode($data['ticket_num_table']);
		$data['seats_table'] = json_decode($data['seats_table']);
		$data['extras_table'] = json_decode($data['extras_table']);
		$data['relprod_table'] = json_decode($data['relprod_table']);
		$data['pickups_table'] = json_decode($data['pickups_table']);
		$data['tax_table'] = json_decode($data['tax_table']);
		$product_data = $this->product_model->get_product_data_stamp( $data['bostamp'] );
		$product_data = $product_data->result_array();
		$product_data = $product_data[0];
		
		$product_obrano = $product_data["obrano"];
		$product_name = $product_data["u_name"];
		$product_sef = $product_data["u_sefurl"];
		
		$this->mssql->utf8_decode_deep($data);
		
		//bo update
		$update_query = "";
		$update_values = array();
		$update_where = "";
		
		//input
		if( isset($data['input']->bo) ) {
			foreach( $data['input']->bo as $key=>$value ) {
				$txtafound = 0;
				$chbfound = 0;
				foreach( $data['textarea'] as $textarea ) {
					if( $textarea[0] == "bo." . $key ) {
						$txtafound = 1;
					}
				}
				foreach( $data['checkbox'] as $checkbox ) {
					if( $checkbox[0] == "bo." . $key ) {
						$chbfound = 1;
					}
				}
				
				if( !$txtafound && !$chbfound ) {
					$update_query .= $key . " = ?, ";
					$update_values[] = $value;
				}
			}
		}
		//textarea mce
		foreach( $data['textarea'] as $textarea ) {
			if (strpos($textarea[0], 'bo.') !== false) {
				$update_query .= $textarea[0] . " = ?, ";
				$update_values[] = str_replace("'", "''", base64_decode($textarea[1]));
			}
		}
		//checkbox
		foreach( $data['checkbox'] as $checkbox ) {
			if (strpos($checkbox[0], 'bo.') !== false) {
				$update_query .= $checkbox[0] . " = ?, ";
				$update_values[] = $checkbox[1];
			}
		}

		$update_query = substr($update_query, 0, strlen($update_query) - 2);
		$update_where .= "bostamp = '" . $data['bostamp'] . "'";
		
		if( $update_query != "" ) {
			$query = "update bo set " . $update_query . " where " . $update_where;
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			
			$res_update["update_bo"] = $sql_status;
		}
		else {
			$res_update["update_bo"] = 1;
		}
		
		//update bo3
		$update_query = "";
		$update_values = array();
		$update_where = "";
		
		//input
		if( isset($data['input']->bo3) ) {
			foreach( $data['input']->bo3 as $key=>$value ) {
				$txtafound = 0;
				$chbfound = 0;
				foreach( $data['textarea'] as $textarea ) {
					if( $textarea[0] == "bo3." . $key ) {
						$txtafound = 1;
					}
				}
				foreach( $data['checkbox'] as $checkbox ) {
					if( $checkbox[0] == "bo3." . $key ) {
						$chbfound = 1;
					}
				}
				
				if( !$txtafound && !$chbfound ) {
					$update_query .= $key . " = ?, ";
					$update_values[] = $value;
				}
			}
		}
		//textarea mce
		foreach( $data['textarea'] as $textarea ) {
			if (strpos($textarea[0], 'bo3.') !== false) {
				$update_query .= $textarea[0] . " = ?, ";
				$update_values[] = str_replace("'", "''", base64_decode($textarea[1]));
			}
		}
		//checkbox
		foreach( $data['checkbox'] as $checkbox ) {
			if (strpos($checkbox[0], 'bo3.') !== false) {
				$update_query .= $checkbox[0] . " = ?, ";
				$update_values[] = $checkbox[1];
			}
		}
		
		$update_query = substr($update_query, 0, strlen($update_query) - 2);
		$update_where .= "bo3stamp = '" . $data['bostamp'] . "'";
		
		if( $update_query != "" ) {
			$query = "update bo3 set " . $update_query . " where " . $update_where;
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			$res_update["update_bo3"] = $sql_status;
		}
		else {
			$res_update["update_bo3"] = 1;
		}

		// category type
		//input
		if( isset($data['input']->u_pcateg) ) {
			foreach( $data['input']->u_pcateg as $key=>$value ) {
				$this->update_category( $value, $data['bostamp'] );
			}
		}
		
		//tickets
		foreach( $data['tickets_table'] as $table_row ) {
			if( $table_row[2] == 1 ) {
				//ticket (tam) existe para este artigo?
				$this->cria_tam( $table_row[0], $table_row[1], $data['bostamp'] );
			}
			else {
				$this->apaga_tam( $table_row[0], $data['bostamp'] );
			}
		}
		
		//extras_table
		foreach( $data['extras_table'] as $table_row ) {
			if( $table_row[6] == 1 ) {
				//extra existe para este artigo?
				$this->cria_extra( $table_row[0], $table_row[1],$table_row[2],$table_row[3],$table_row[4],$table_row[5], $data['bostamp'] );
			}
			else {
				$this->apaga_extra( $table_row[0], $data['bostamp'] );
			}
		}
		
		//relprod_table
		foreach( $data['relprod_table'] as $table_row ) {
			if( $table_row[2] == 1 ) {
				//extra existe para este artigo?
				$this->cria_relproduct( $table_row[0], $table_row[1] );
			}
			else {
				$this->apaga_relproduct( $table_row[0], $table_row[1] );
			}
		}
		
		//pickups_table
		foreach( $data['pickups_table'] as $table_row ) {
			if( $table_row[2] == 1 ) {
				//extra existe para este artigo?
				$this->cria_pickupproduct( $table_row[0], $table_row[1] );
			}
			else {
				$this->apaga_pickupproduct( $table_row[0], $table_row[1] );
			}
		}
		
		//tax_table
		foreach( $data['tax_table'] as $table_row ) {
			if( $table_row[2] == 1 ) {
				//extra existe para este artigo?
				$this->cria_taxproduct( $table_row[0], $table_row[1] );
			}
			else {
				$this->apaga_taxproduct( $table_row[0], $table_row[1] );
			}
		}

		//tickets num
		$updated_ticket_num_table = array();
				
		foreach( $data['ticket_num_table'] as $table_row ) {
			$updated_ticket_num_table_tmp = array();
			//update
			if( $table_row[0] != '' ) {			
				$update_values = array();
				$update_values[] = $table_row[1];
				$update_values[] = $table_row[0];
				
				$query = "update u_pntick set no = ? where u_pntickstamp = ?";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				$res_update["update_tick_num_tab_upd"] = $sql_status;
				
				$updated_ticket_num_table_tmp["no"] = $table_row[1];
				$updated_ticket_num_table_tmp["id"] = $table_row[2];
				$updated_ticket_num_table_tmp["u_pntickstamp"] = $table_row[0];
				$updated_ticket_num_table[] = $updated_ticket_num_table_tmp;
			}
			// insert
			else {
				$update_values = array();
				$u_pntickstamp = $this->product_model->stamp();
				$update_values[] = $u_pntickstamp;
				$update_values[] = $data['bostamp'];
				$update_values[] = $table_row[1];
				
				$query = "insert into u_pntick (
					u_pntickstamp,
					bostamp,
					no,
					issued,
					used,
					ousrdata,
					ousrhora,
					ousrinis,
					usrdata,
					usrhora,
					usrinis
				) values (
					?,
					?,
					?,
					0,
					0,
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8), 
					UPPER(suser_sname()), 
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8),
					UPPER(suser_sname())
				) 
				";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				$res_update["update_tick_num_tab_ins"] = $sql_status;
				
				$updated_ticket_num_table_tmp["no"] = $table_row[1];
				$updated_ticket_num_table_tmp["id"] = $table_row[2];
				$updated_ticket_num_table_tmp["u_pntickstamp"] = $u_pntickstamp;
				$updated_ticket_num_table[] = $updated_ticket_num_table_tmp;
			}
		}
		$res_update["updated_ticket_num_table"] = $updated_ticket_num_table;
		
		//seats_table
		$updated_seats_table = array();
				
		foreach( $data['seats_table'] as $table_row ) {
			$updated_seats_table_tmp = array();
			//update
			if( $table_row[0] != '' ) {			
				$update_values = array();
				$update_values[] = $table_row[1];
				$update_values[] = $table_row[0];
				
				$query = "update u_pseat set seat = ? where u_pseatstamp = ?";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				$res_update["update_seat_tab_upd"] = $sql_status;
				
				$updated_seats_table_tmp["seat"] = $table_row[1];
				$updated_seats_table_tmp["id"] = $table_row[2];
				$updated_seats_table_tmp["u_pseatstamp"] = $table_row[0];
				$updated_seats_table[] = $updated_seats_table_tmp;
			}
			// insert
			else {
				$update_values = array();
				$u_pseatstamp = $this->product_model->stamp();
				$update_values[] = $u_pseatstamp;
				$update_values[] = $data['bostamp'];
				$update_values[] = $table_row[1];
				
				$query = "insert into u_pseat (
					u_pseatstamp,
					bostamp,
					seat,
					ousrdata,
					ousrhora,
					ousrinis,
					usrdata,
					usrhora,
					usrinis
				) values (
					?,
					?,
					?,
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8), 
					UPPER(suser_sname()), 
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8),
					UPPER(suser_sname())
				) 
				";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				$res_update["update_seats_tab_ins"] = $sql_status;
				
				$updated_seats_table_tmp["seat"] = $table_row[1];
				$updated_seats_table_tmp["id"] = $table_row[2];
				$updated_seats_table_tmp["u_pseatstamp"] = $u_pseatstamp;
				$updated_seats_table[] = $updated_seats_table_tmp;
			}
		}
		$res_update["updated_seats_table"] = $updated_seats_table;

		//scheduling_table
		$updated_scheduling_table = array();
		$updated_scheduling_pricing = array();
		
		foreach( $data['scheduling_table'] as $table_row ) {
			$updated_scheduling_table_tmp = array();
			
			//update
			if( $table_row[0] != '' ) {
				
				$update_query = "price = ?, ";
				$update_query .= "lotation = ?, ";
				$update_query .= "ihour = ?, ";
				$update_query .= "fixday = ?,";
				$update_query .= "fixday_end = ?,";
				$update_query .= "mon = ?,";
				$update_query .= "tue = ?,";
				$update_query .= "wed = ?,";
				$update_query .= "thu = ?,";
				$update_query .= "fri = ?,";
				$update_query .= "sat = ?,";
				$update_query .= "sun = ? ";
				
				$update_values = array();
				$update_values[] = ($table_row[2] == "true" ? 1 : 0);
				$update_values[] = $table_row[3];
				$update_values[] = $table_row[4];
				$update_values[] = (strlen($table_row[5]) == 0) ? "1900-01-01" : $table_row[5];
				$update_values[] = (strlen($table_row[13]) == 0) ? "1900-01-01" : $table_row[13];
				$update_values[] = ($table_row[6] == "true" ? 1 : 0);
				$update_values[] = ($table_row[7] == "true" ? 1 : 0);
				$update_values[] = ($table_row[8] == "true" ? 1 : 0);
				$update_values[] = ($table_row[9] == "true" ? 1 : 0);
				$update_values[] = ($table_row[10] == "true" ? 1 : 0);
				$update_values[] = ($table_row[11] == "true" ? 1 : 0);
				$update_values[] = ($table_row[12] == "true" ? 1 : 0);
				
				$query = "update u_psess set " . $update_query . " where u_psessstamp = '" . $table_row[0] . "'";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				$res_update["update_sess_tab_upd"] = $sql_status;
				
				$updated_scheduling_table_tmp["id"] = $table_row[1];
				$updated_scheduling_table_tmp["u_psessstamp"] = $table_row[0];
				$updated_scheduling_table[] = $updated_scheduling_table_tmp;
			}
			// insert
			else {
				
				$update_values = array();
				$u_psessstamp = $this->product_model->stamp();
				$update_values[] = $u_psessstamp;
				$update_values[] = $data['bostamp'];
				$update_values[] = $table_row[1];
				$update_values[] = ($table_row[2] == "true" ? 1 : 0);
				$update_values[] = $table_row[3];
				$update_values[] = $table_row[4];
				$update_values[] = (strlen($table_row[5]) == 0) ? "1900-01-01" : $table_row[5];
				$update_values[] = (strlen($table_row[13]) == 0) ? "1900-01-01" : $table_row[13];
				$update_values[] = ($table_row[6] == "true" ? 1 : 0);
				$update_values[] = ($table_row[7] == "true" ? 1 : 0);
				$update_values[] = ($table_row[8] == "true" ? 1 : 0);
				$update_values[] = ($table_row[9] == "true" ? 1 : 0);
				$update_values[] = ($table_row[10] == "true" ? 1 : 0);
				$update_values[] = ($table_row[11] == "true" ? 1 : 0);
				$update_values[] = ($table_row[12] == "true" ? 1 : 0);
				
				$query = "insert into u_psess (
					u_psessstamp,
					bostamp,
					id,
					price,
					lotation,
					ihour,
					fixday,
					fixday_end,
					mon,
					tue,
					wed,
					thu,
					fri,
					sat,
					sun,
					ousrdata,
					ousrhora,
					ousrinis,
					usrdata,
					usrhora,
					usrinis
				) values (
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8), 
					UPPER(suser_sname()), 
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8),
					UPPER(suser_sname())
				) 
				";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				$res_update["update_sess_tab_ins"] = $sql_status;
				
				$updated_scheduling_table_tmp["id"] = $table_row[1];
				$updated_scheduling_table_tmp["u_psessstamp"] = $u_psessstamp;
				$updated_scheduling_table[] = $updated_scheduling_table_tmp;
			}
			
			//criar artigo
			//verificar se artigo ja existe
			$query = "select * from st where ref = '"."P." . $product_obrano . "." . $table_row[1]."'";
			$query = $this->mssql->mssql__select( $query ); 
			
			//produto com preco alternativo
			if( $table_row[2] == "true" ) {
				$updated_scheduling_pricing_tmp = array();
				$updated_scheduling_pricing_tmp["id"] = $table_row[1];
				$updated_scheduling_pricing_tmp["alt_price"] = 1;
				
				$updated_scheduling_pricing[] = $updated_scheduling_pricing_tmp;
			}	
			else {
				$updated_scheduling_pricing_tmp = array();
				$updated_scheduling_pricing_tmp["id"] = $table_row[1];
				$updated_scheduling_pricing_tmp["alt_price"] = 0;
				
				$updated_scheduling_pricing[] = $updated_scheduling_pricing_tmp;
			}				
			
			//se nao existir, cria
			if( $table_row[2] == "true" && sizeof($query) == 0) {
				//st
				$update_values = array();
				$update_values[] = "P." . $product_obrano . "." . $table_row[1];
				$update_values[] = substr($product_name, 0, 60);
				$update_values[] = 'PRODUTOS';
				$update_values[] = 'Produtos';
				$update_values[] = 1;
				$update_values[] = 1;
				$update_values[] = 1;
				
				$query = "insert into st (
					ststamp,
					ref,
					design,
					familia,
					faminome,
					stns,
					iva1incl,
					texteis,
					tabiva,
					ousrdata,
					ousrhora,
					ousrinis,
					usrdata,
					usrhora,
					usrinis
				) values (
					CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					2,
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8), 
					UPPER(suser_sname()), 
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8),
					UPPER(suser_sname())
				) 
				";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				$res_update["st_ins"] = $sql_status;
				
				//stobs
				$update_values = array();
				$update_values[] = "P." . $product_obrano . "." . $table_row[1];
				$update_values[] = 'O';
				$update_values[] = $data['bostamp'];
				
				$query = "insert into stobs (
					stobsstamp,
					ref,
					tipoprod,
					u_bostamp,
					ousrdata,
					ousrhora,
					ousrinis,
					usrdata,
					usrhora,
					usrinis
				) values (
					CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
					?,
					?,
					?,
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8), 
					UPPER(suser_sname()), 
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8),
					UPPER(suser_sname())
				) 
				";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				$res_update["stobs_ins"] = $sql_status;
			}
			
			// log_message('error', print_r($data['input']->tickets_table, true));
			
			//grelhas
			$lugares = $this->get_product_seats_mssql( $product_sef );
			$bilhetes = $this->get_product_tickets_mssql( $product_sef );
			
			//se existirem lugares
			if( sizeof($lugares) > 0 && $table_row[2] == "true" ) {
				foreach( $lugares as $lugar ) {
					foreach( $bilhetes as $bilhete ) {
						$this->cria_grelha_mssql( $lugar["seat"], $bilhete["ticket"], "P." . $product_obrano . "." . $table_row[1], $lugar["u_pseatstamp"], $bilhete["u_ptickstamp"] );
					}
				}
			}
			else if( $table_row[2] == "true" ) {
				foreach( $bilhetes as $bilhete ) {
					$this->cria_grelha_mssql( "ND", $bilhete["ticket"], "P." . $product_obrano . "." . $table_row[1], '', $bilhete["u_ptickstamp"] );
				}
			}
			else {
				foreach( $bilhetes as $bilhete ) {
					$this->apaga_grelha_mssql( "P." . $product_obrano . "." . $table_row[1] );
					$this->apaga_artigo_mssql( "P." . $product_obrano . "." . $table_row[1] );
				}
			}
		}
		$res_update["updated_scheduling_table"] = $updated_scheduling_table;
		$res_update["updated_scheduling_pricing"] = $updated_scheduling_pricing;		
//********************************************************************************************	
		//exclusion_table
		$updated_exclusion_table = array();
		
		foreach( $data['exclusion_table'] as $table_row ) {
			$updated_exclusion_table_tmp = array();
			
			//update
			if( $table_row[0] != '' ) {
				
				$update_query = "imonth = ?, ";
				$update_query .= "iday = ?, ";
				$update_query .= "fmonth = ?,";
				$update_query .= "fday = ? ";			
			
				$update_values = array();
				$update_values[] = $table_row[2];
				$update_values[] = $table_row[3];
				$update_values[] = $table_row[4];
				$update_values[] = $table_row[5];

				$query = "update u_pexcl set " . $update_query . " where u_pexclstamp = '" . $table_row[0] . "'";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				$res_update["update_excl_tab_upd"] = $sql_status;
				
				$updated_exclusion_table_tmp["u_pexclstamp"] = $table_row[0];
				$updated_exclusion_table_tmp["id"] = $table_row[1];
				$updated_exclusion_table[] = $updated_exclusion_table_tmp;
			}
			// insert
			else {
				
				$update_values = array();
				$u_pexclstamp = $this->product_model->stamp();
				$update_values[] = $u_pexclstamp;
				$update_values[] = $data['bostamp'];
				$update_values[] = $table_row[2];
				$update_values[] = $table_row[3];
				$update_values[] = $table_row[4];
				$update_values[] = $table_row[5];
				
				$query = "insert into u_pexcl (
					u_pexclstamp,
					bostamp,
					imonth,
					iday,
					fmonth,
					fday,
					ousrdata,
					ousrhora,
					ousrinis,
					usrdata,
					usrhora,
					usrinis
				) values (
					?,
					?,
					?,
					?,
					?,
					?,
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8), 
					UPPER(suser_sname()), 
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8),
					UPPER(suser_sname())
				) 
				";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				$res_update["update_excl_tab_ins"] = $sql_status;
				
				//$updated_exclusion_table_tmp["id"] = $table_row[1];
				$updated_exclusion_table_tmp["u_pexclstamp"] = $u_pexclstamp;
				$updated_exclusion_table_tmp["id"] = $table_row[1];
				$updated_exclusion_table[] = $updated_exclusion_table_tmp;
			}
		}
		$res_update["updated_exclusion_table"] = $updated_exclusion_table;
//********************************************************************************************
		//language_table
			
		$update_values = array();
		
		$query = "delete from u_plang where bostamp = '".$data['bostamp']."'";
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );

		
		foreach( $data['language_table'] as $table_row ) {
			$updated_language_table_tmp = array();
						
			$update_values = array();
			$u_plangstamp = $this->product_model->stamp();
			$update_values[] = $u_plangstamp;
			$update_values[] = $data['bostamp'];
			$update_values[] = $table_row[1];
			if($table_row[2] == 1){
				$query = "insert into u_plang (
					u_plangstamp,
					bostamp,
					language,
					ousrdata,
					ousrhora,
					ousrinis,
					usrdata,
					usrhora,
					usrinis
				) values (
					?,
					?,
					?,
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8), 
					UPPER(suser_sname()), 
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8),
					UPPER(suser_sname())
				) 
				";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			}
			
		}
		//$res_update["updated_language_table"] = $updated_language_table;
//********************************************************************************************

		//grelhas ref. base
		$lugares = $this->get_product_seats_mssql( $product_sef );
		$bilhetes = $this->get_product_tickets_mssql( $product_sef );
		//se existirem lugares
		if( sizeof($lugares) > 0 ) {
			foreach( $lugares as $lugar ) {
				foreach( $bilhetes as $bilhete ) {
					$this->cria_grelha_mssql( $lugar["seat"], $bilhete["ticket"], "P." . $product_obrano . ".0", $lugar["u_pseatstamp"], $bilhete["u_ptickstamp"] );
				}
			}
		}
		else {
			foreach( $bilhetes as $bilhete ) {
				$this->cria_grelha_mssql( "ND", $bilhete["ticket"], "P." . $product_obrano . ".0", '', $bilhete["u_ptickstamp"] );
			}
		}
			
		echo json_encode( $res_update );
	}
	
	function delete_product_ticket_number( $data ) {
		$u_pntickstamp = $data['u_pntickstamp'];

		//apagar u_pntick
		$update_values = array();
		$update_values[] = $u_pntickstamp;
		$query = "delete from u_pntick where u_pntickstamp = ?";
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		
		echo $sql_status;
	}
	
	function delete_product_seat( $data ) {
		$u_pseatstamp = $data['seat'];
		
		//obter seat
		$query = "
			select seat from u_pseat where u_pseatstamp = '".$u_pseatstamp."'";
		$query = $this->mssql->mssql__select( $query );

		if( sizeof($query) > 0 ) {
			$seat = $query[0]["seat"];
		
			//obter obrano
			$query = "
				select obrano 
				from bo inner join u_pseat on bo.bostamp = u_pseat.bostamp
				where u_pseatstamp = '".$u_pseatstamp."'";
			$query = $this->mssql->mssql__select( $query );
			
			if( sizeof($query) > 0 ) {
				$obrano = trim($query[0]["obrano"]);
			
				$ref = "P." . $obrano . ".%";
				
				//apagar sx
				$update_values = array();
				$update_values[] = $ref;
				$update_values[] = $seat;
				$query = "delete from sx where ref like ? and cor = ?";
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				
				//apagar sgc
				$update_values = array();
				$update_values[] = $u_pseatstamp;
				$query = "delete from sgc where u_pseat = ?";
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				
				//apagar u_pseat
				$update_values = array();
				$update_values[] = $u_pseatstamp;
				$query = "delete from u_pseat where u_pseatstamp = ?";
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				
				echo $sql_status;
			}
			else {
				echo 0;
			}
		}
		else {
			echo 0;
		}
	}
	
	function delete_product_session( $data ) {
		$session = $data['session'];
		
		//obter ref para sessao
		$query = "
			select bo.obrano, u_psess.id
			from bo 
				inner join u_psess on bo.bostamp = u_psess.bostamp
			where 
				u_psess.u_psessstamp = '".$session."'
		";

		$query = $this->mssql->mssql__select( $query );
		
		if( sizeof($query) > 0 ) {
			$ref = "P." . $query[0]["obrano"] . "." . $query[0]["id"];
			
			// log_message('error', print_r($ref, true));
			
			//apagar st
			$update_values = array();
			$update_values[] = $ref;
			$query = "delete from st where ref = ?";
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			
			//apagar stobs
			$update_values = array();
			$update_values[] = $ref;
			$query = "delete from stobs where ref = ?";
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			
			//apagar sgc
			$update_values = array();
			$update_values[] = $ref;
			$query = "delete from sgc where ref = ?";
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			
			//apagar sgt
			$update_values = array();
			$update_values[] = $ref;
			$query = "delete from sgt where ref = ?";
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			
			//apagar sx
			$update_values = array();
			$update_values[] = $ref;
			$query = "delete from sx where ref = ?";
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		}
		
		//apagar sessao
		$update_values = array();
		$update_values[] = $session;
		
		$query = "delete from u_psess where u_psessstamp = ?";

		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		echo $sql_status;
	}	
	
	function delete_product_exclusion( $data ) {
		$exclusion = $data['exclusion'];
	
		$update_values = array();
		$update_values[] = $exclusion;
		
		$query = "delete from u_pexcl where u_pexclstamp = ?";

		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		echo $sql_status;
	}


	function update_category( $u_categstamp, $bostamp ) {

		if( $u_categstamp != "" ) {
	
			//obter category
			$query = "
				select category
				from u_categ
				where 
					u_categstamp = '".$u_categstamp."'
			";

			$query = $this->mssql->mssql__select( $query );
			
			if( sizeof($query) > 0 ) {
		
				$category = $query[0]["category"];
				
				//apagar category
				$update_values = array();
				$update_values[] = $bostamp;
				$query = "delete from u_pcateg where bostamp = ?";
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			
				//add category
				$update_values = array();
				$update_values[] = $u_categstamp;
				$update_values[] = $category;
				$update_values[] = $bostamp;
				
				$query = "insert into u_pcateg (
					u_pcategstamp,
					u_categstamp,
					category,
					bostamp,
					ousrdata,
					ousrhora,
					ousrinis,
					usrdata,
					usrhora,
					usrinis
				) values (
					CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
					?,
					?,
					?,
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8), 
					UPPER(suser_sname()), 
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8),
					UPPER(suser_sname())
				) 
				";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				
				return $sql_status;
			}
			else {
				return 0;
			}
		}
		else {
			return 0;
		}
	}
	
}