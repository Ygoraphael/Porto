<?php

class Customer_model extends CI_Model {

	var $exists = 0;
	var $jFields = array();
	var $fields = array();
	var $fields2 = array();
	var $fields3 = array();
	var $fields4 = array();

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }
    
	function getcountry($country) {
		$data = $this->db->get_where( 'd2e0b_virtuemart_countries', array('country_2_code' => trim($country) ));
		if ($data->num_rows() > 0 ) 
		{
			foreach( $data->result_array() as $row ) 
			{
				return $row["virtuemart_country_id"];
			}
		}
		else {
			return '171';
		}
	}
	
	function WriteLog($message)
	{
		$f = fopen("MyLog.txt", "a");
		fwrite($f, date("Y-m-d H:i:s") . " - " . print_r($message,true) . "\n");
		fclose($f);
	}
	
	function get_max_mdate()
	{
		$this->db->select_max('modified_on');
		$value = $this->db->get('d2e0b_virtuemart_vmusers')->row()->modified_on;
		
		if(!is_null($value))
			return $value;
		else
			return "1900-01-01 00:00:00";
	}
	
	function get( $id ) 
	{
		$data1 = $this->db->get_where( 'd2e0b_users', array( 'phc_no' => $id ) );
		if ( $data1->num_rows() > 0 ) 
		{
			foreach ($data1->result_array() as $row ) 
			{
				$this->jFields = $row;
				
				$data2 = $this->db->get_where( 'd2e0b_virtuemart_vmusers', array('virtuemart_user_id' => $row['id'] ));
				if ($data2->num_rows() > 0 ) 
				{
					foreach( $data2->result_array() as $row2 ) 
					{
						$this->fields = $row2;
						break;
					}
				}
				
				$data3 = $this->db->get_where( 'd2e0b_virtuemart_userinfos', array('virtuemart_user_id' => $row['id'] ));
				if ($data3->num_rows() > 0 ) 
				{
					foreach( $data3->result_array() as $row3 ) 
					{
						$this->fields2 = $row3;
						break;
					}
				}
				
				$data4 = $this->db->get_where( 'd2e0b_virtuemart_vmuser_shoppergroups', array('virtuemart_user_id' => $row['id'] ));
				if ($data4->num_rows() > 0 ) 
				{
					foreach( $data4->result_array() as $row4 ) 
					{
						$this->fields3 = $row4;
						break;
					}
				}
				
				$data5 = $this->db->get_where( 'd2e0b_user_usergroup_map', array('user_id' => $row['id'] ));
				if ($data5->num_rows() > 0 ) 
				{
					foreach( $data5->result_array() as $row5 ) 
					{
						$this->fields4 = $row5;
						break;
					}
				}
				
				$this->exists = 1;
				return $this;
			}
		}
		
		$this->exists = 0;
		return $this;
	}

	function delete()
	{
		$this->db->trans_start();
		
		$id = $this->fields['virtuemart_user_id'];
		
		$this->db->where('id', $id);
		$query = $this->db->delete( 'd2e0b_users' );

		if ( $query ) 
		{
			$this->db->where('virtuemart_user_id', $id);
			$query = $this->db->delete( 'd2e0b_virtuemart_vmusers' );

			if ( $query ) 
			{
				$this->db->where('virtuemart_user_id', $id);
				$query = $this->db->delete( 'd2e0b_virtuemart_userinfos' );

				if ( $query ) 
				{
					$this->db->where('virtuemart_user_id', $id);
					$query = $this->db->delete( 'd2e0b_virtuemart_vmuser_shoppergroups' );

					if ( $query ) 
					{
						$this->db->where('user_id', $id);
						$query = $this->db->delete( 'd2e0b_user_usergroup_map' );

						if ( $query ) 
						{
							$this->db->trans_complete();
							return true;
						}
						else
						{
							 $this->db->trans_rollback();
							 $this->WriteLog( "Falhou Apagar Update Utilizador d2e0b_user_usergroup_map - " . $this->jFields["phc_no"] );
							 return false;
						}
					}
					else
					{
						 $this->db->trans_rollback();
						 $this->WriteLog( "Falhou Apagar Update Utilizador d2e0b_virtuemart_userinfos - " . $this->jFields["phc_no"] );
						 return false;
					}
				}
				else
				{
					 $this->db->trans_rollback();
					 $this->WriteLog( "Falhou Apagar Update Utilizador d2e0b_virtuemart_vmusers - " . $this->jFields["phc_no"] );
					 return false;
				}
			}
			else
			{
				 $this->db->trans_rollback();
				 $this->WriteLog( "Falhou Apagar Update Utilizador d2e0b_users - " . $this->jFields["phc_no"] );
				 return false;
			}
		}
		else
		{
			 $this->db->trans_rollback();
			 return false;
		}
	}
	
	function save( $insert = false ) 
	{	
		if ( $insert ) 
		{
			
			$this->db->trans_start();
			$query = $this->db->insert( 'd2e0b_users', $this->jFields );

			if ( $query ) 
			{
				$id = $this->db->insert_id();
				$this->fields['virtuemart_user_id'] = $id;
				$this->fields2['virtuemart_user_id'] = $id;
				$this->fields3['virtuemart_user_id'] = $id;
				$this->fields4['user_id'] = $id;

				$query = $this->db->insert( 'd2e0b_virtuemart_vmusers', $this->fields ); 
				if ( $query ) 
				{
					$query = $this->db->insert( 'd2e0b_virtuemart_userinfos', $this->fields2 ); 
					if ( $query ) 
					{
						$query = $this->db->insert( 'd2e0b_virtuemart_vmuser_shoppergroups', $this->fields3 );
						if ( $query ) 
						{
							$query = $this->db->insert( 'd2e0b_user_usergroup_map', $this->fields4 );
							if ( $query ) 
							{
								$this->db->trans_complete();
								return true;
							}
							else
							{
								 $this->db->trans_rollback();
								 $this->WriteLog( "Falhou Gravar Novo Utilizador d2e0b_user_usergroup_map - " . $this->jFields["phc_no"] );
								 return false;
							}
						}
						else
						{
							 $this->db->trans_rollback();
							 $this->WriteLog( "Falhou Gravar Novo Utilizador d2e0b_virtuemart_userinfos - " . $this->jFields["phc_no"] );
							 return false;
						}
					}
					else
					{
						 $this->db->trans_rollback();
						 $this->WriteLog( "Falhou Gravar Novo Utilizador d2e0b_virtuemart_vmusers - " . $this->jFields["phc_no"] );
						 return false;
					}
				}
				else
				{
					 $this->db->trans_rollback();
					 $this->WriteLog( "Falhou Gravar Novo Utilizador d2e0b_users - " . $this->jFields["phc_no"] );
					 return false;
				}
			}
			else
			{
				 $this->db->trans_rollback();
				 return false;
			}
		} 
		else 
		{
			$this->db->trans_start();
			
			$this->db->where( 'id', $this->jFields['id'] );
			$query = $this->db->update( 'd2e0b_users', $this->jFields );

			if ( $query ) 
			{
				$this->db->where( 'virtuemart_user_id', $this->fields['virtuemart_user_id'] );
				$query = $this->db->update( 'd2e0b_virtuemart_vmusers', $this->fields );
				
				if ( $query ) 
				{
					$this->db->where( 'virtuemart_user_id', $this->fields2['virtuemart_user_id'] );
					$query = $this->db->update( 'd2e0b_virtuemart_userinfos', $this->fields2 );
					
					if ( $query ) 
					{
						$this->db->where( 'virtuemart_user_id', $this->fields3['virtuemart_user_id'] );
						$query = $this->db->update( 'd2e0b_virtuemart_vmuser_shoppergroups', $this->fields3 );
						
						if ( $query ) 
						{
							if ( true ) 
							{
								$this->db->where( 'user_id', $this->fields4['user_id'] );
								$query = $this->db->update( 'd2e0b_user_usergroup_map', $this->fields4 );
								
								if ( $query ) 
								{
									$this->db->trans_complete();
									return true;
								}
								else
								{
									 $this->db->trans_rollback();
									 $this->WriteLog( "Falhou Gravar Update Utilizador d2e0b_user_usergroup_map - " . $this->jFields["phc_no"] );
									 return false;
								}
							}
							else
							{
								 $this->db->trans_rollback();
								 $this->WriteLog( "Falhou Gravar Update Utilizador d2e0b_virtuemart_vmuser_shoppergroups - " . $this->jFields["phc_no"] );
								 return false;
							}
						}
					}
					else
					{
						 $this->db->trans_rollback();
						 $this->WriteLog( "Falhou Gravar Update Utilizador d2e0b_virtuemart_userinfos - " . $this->jFields["phc_no"] );
						 return false;
					}
				}
				else
				{
					 $this->db->trans_rollback();
					 $this->WriteLog( "Falhou Gravar Update Utilizador d2e0b_virtuemart_vmusers - " . $this->jFields["phc_no"] );
					 return false;
				}
			}
			else
			{
				 $this->db->trans_rollback();
				 $this->WriteLog( "Falhou Gravar Update Utilizador d2e0b_users - " . $this->jFields["phc_no"] );
				 return false;
			}
		}
	} 


	function get_by_user_id ( $id ) {

		$this->db->select('user_info_id, user_id, last_name, first_name, 
			middle_name, phone_1, address_1, address_2, city, user_email, 
			cdate, mdate');

        
        $this->db->where('user_id >', $id);

        $result = $this->db->get('d2e0b_vm_user_info');


		if ( $result->num_rows() > 0 ) {

			return $result->result_array();
		}


		return false;
	}
    
    function getSalt($encryption = 'md5-hex', $seed = '', $plaintext = '')
    {
        switch ($encryption)
        {
            case 'crypt' :
            case 'crypt-des' :
                if ($seed) {
                    return substr(preg_replace('|^{crypt}|i', '', $seed), 0, 2);
                } else {
                    return substr(md5(mt_rand()), 0, 2);
                }
                break;

            case 'crypt-md5' :
                if ($seed) {
                    return substr(preg_replace('|^{crypt}|i', '', $seed), 0, 12);
                } else {
                    return '$1$'.substr(md5(mt_rand()), 0, 8).'$';
                }
                break;

            case 'crypt-blowfish' :
                if ($seed) {
                    return substr(preg_replace('|^{crypt}|i', '', $seed), 0, 16);
                } else {
                    return '$2$'.substr(md5(mt_rand()), 0, 12).'$';
                }
                break;

            case 'ssha' :
                if ($seed) {
                    return substr(preg_replace('|^{SSHA}|', '', $seed), -20);
                } else {
                    return mhash_keygen_s2k(MHASH_SHA1, $plaintext, substr(pack('h*', md5(mt_rand())), 0, 8), 4);
                }
                break;

            case 'smd5' :
                if ($seed) {
                    return substr(preg_replace('|^{SMD5}|', '', $seed), -16);
                } else {
                    return mhash_keygen_s2k(MHASH_MD5, $plaintext, substr(pack('h*', md5(mt_rand())), 0, 8), 4);
                }
                break;

            case 'aprmd5' :
                /* 64 characters that are valid for APRMD5 passwords. */
                $APRMD5 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

                if ($seed) {
                    return substr(preg_replace('/^\$apr1\$(.{8}).*/', '\\1', $seed), 0, 8);
                } else {
                    $salt = '';
                    for ($i = 0; $i < 8; $i ++) {
                        $salt .= $APRMD5 {
                            rand(0, 63)
                            };
                    }
                    return $salt;
                }
                break;

            default :
                $salt = '';
                if ($seed) {
                    $salt = $seed;
                }
                return $salt;
                break;
        }
    }

    function _toAPRMD5($value, $count)
    {
        /* 64 characters that are valid for APRMD5 passwords. */
        $APRMD5 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        $aprmd5 = '';
        $count = abs($count);
        while (-- $count) {
            $aprmd5 .= $APRMD5[$value & 0x3f];
            $value >>= 6;
        }
        return $aprmd5;
    }

    function _bin($hex)
    {
        $bin = '';
        $length = strlen($hex);
        for ($i = 0; $i < $length; $i += 2) {
            $tmp = sscanf(substr($hex, $i, 2), '%x');
            $bin .= chr(array_shift($tmp));
        }
        return $bin;
    }

    function genRandomPassword($length = 8)
    {
        $salt = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $len = strlen($salt);
        $makepass = '';

        $stat = @stat(__FILE__);
        if(empty($stat) || !is_array($stat)) $stat = array(php_uname());

        mt_srand(crc32(microtime() . implode('|', $stat)));

        for ($i = 0; $i < $length; $i ++) {
            $makepass .= $salt[mt_rand(0, $len -1)];
        }

        return $makepass;
    }

    function getCryptedPassword($plaintext, $salt = '', $encryption = 'md5-hex', $show_encrypt = false)
    {
        // Get the salt to use.
        $salt = $this->getSalt($encryption, $salt, $plaintext);

        // Encrypt the password.
        switch ($encryption)
        {
            case 'plain' :
                return $plaintext;

            case 'sha' :
                $encrypted = base64_encode(mhash(MHASH_SHA1, $plaintext));
                return ($show_encrypt) ? '{SHA}'.$encrypted : $encrypted;

            case 'crypt' :
            case 'crypt-des' :
            case 'crypt-md5' :
            case 'crypt-blowfish' :
                return ($show_encrypt ? '{crypt}' : '').crypt($plaintext, $salt);

            case 'md5-base64' :
                $encrypted = base64_encode(mhash(MHASH_MD5, $plaintext));
                return ($show_encrypt) ? '{MD5}'.$encrypted : $encrypted;

            case 'ssha' :
                $encrypted = base64_encode(mhash(MHASH_SHA1, $plaintext.$salt).$salt);
                return ($show_encrypt) ? '{SSHA}'.$encrypted : $encrypted;

            case 'smd5' :
                $encrypted = base64_encode(mhash(MHASH_MD5, $plaintext.$salt).$salt);
                return ($show_encrypt) ? '{SMD5}'.$encrypted : $encrypted;

            case 'aprmd5' :
                $length = strlen($plaintext);
                $context = $plaintext.'$apr1$'.$salt;
                $binary = _bin(md5($plaintext.$salt.$plaintext));

                for ($i = $length; $i > 0; $i -= 16) {
                    $context .= substr($binary, 0, ($i > 16 ? 16 : $i));
                }
                for ($i = $length; $i > 0; $i >>= 1) {
                    $context .= ($i & 1) ? chr(0) : $plaintext[0];
                }

                $binary = _bin(md5($context));

                for ($i = 0; $i < 1000; $i ++) {
                    $new = ($i & 1) ? $plaintext : substr($binary, 0, 16);
                    if ($i % 3) {
                        $new .= $salt;
                    }
                    if ($i % 7) {
                        $new .= $plaintext;
                    }
                    $new .= ($i & 1) ? substr($binary, 0, 16) : $plaintext;
                    $binary = _bin(md5($new));
                }

                $p = array ();
                for ($i = 0; $i < 5; $i ++) {
                    $k = $i +6;
                    $j = $i +12;
                    if ($j == 16) {
                        $j = 5;
                    }
                    $p[] = _toAPRMD5((ord($binary[$i]) << 16) | (ord($binary[$k]) << 8) | (ord($binary[$j])), 5);
                }

                return '$apr1$'.$salt.'$'.implode('', $p)._toAPRMD5(ord($binary[11]), 3);

            case 'md5-hex' :
            default :
                $encrypted = ($salt) ? md5($plaintext.$salt) : md5($plaintext);
                return ($show_encrypt) ? '{MD5}'.$encrypted : $encrypted;
        }
    }
	
    //password
	function criar_password( $pw )
	{
		$salt = $this->genRandomPassword(32);
		$crypt = $this->getCryptedPassword( $pw, $salt );
		$password = $crypt.':'.$salt;
		return $password;
	}
}
