<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Translation_model extends CI_Model {

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

    public function get_translations_by_key($key, $lang) {
        $query = " 
		select 
                    ltrim(rtrim(u_translate.textvalue)) textvalue
		from 
                    u_translate
		where 
                    lang = '" . $lang . "'
		and
                    keyvalue = ISNULL((select top 1  keyvalue from u_translate where textvalue = '" . str_replace("'", "''", $key) . "'),'')
		";
        $qu = $this->mssql->mssql__select($query);
        return $qu;
    }

    public function get_translations() {
        $query = " 
		select *
		from
		u_translate
		";
        $qu = $this->mssql->mssql__select($query);
        return $qu;
    }

    public function get_translations2($language) {
        $query = " 
		select *
		from
			u_translate
		where 
			lang ='" . $language . "'
		";
        $qu = $this->mssql->mssql__select($query);

        return $qu;
    }

    public function get_languages() {
        $query = " 
			select *
			from u_lang
			order by language
		";
        $qu = $this->mssql->mssql__select($query);
        return $qu;
    }

    public function get_translations_by_id($u_translatestamp) {
        $query = " 
		select *
		From
			u_translate
		where 
			u_translatestamp ='" . $u_translatestamp . "'
		";
        $qu = $this->mssql->mssql__select($query);
        return $qu;
    }

    public function get_languages_by_code($code) {
        $this->db->select("*");
        $this->db->from('u_plang');
        $this->db->where('u_plangstamp', $code);
        return $this->db->get()->row();
    }

    public function create_country($country, $stamp) {
        $data = array(
            'language' => $country
        );
        $this->db->insert('u_plang', $data);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    public function create_translation($key, $value, $language) {
        $this->load->model('product_model');

        $query = "
		INSERT INTO u_translate (u_translatestamp, lang, textvalue, ousrdata, ousrhora, ousrinis, usrdata, usrhora, usrinis, keyvalue) 
		VALUES 
		(
			'" . $this->product_model->stamp() . "',
			'" . $language . "',
			'" . str_replace("'", "''", $value) . "',
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
			CONVERT(VARCHAR(5), GETDATE(), 8), 
			UPPER(suser_sname()), 
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
			CONVERT(VARCHAR(5), GETDATE(), 8),
			UPPER(suser_sname()),
			'" . $key . "'
		)
		";

        $u = $this->mssql->mssql__execute($query);
        return $u;
    }

    public function update_country($country, $flag, $code) {

        $data = array(
            'country' => $country,
            'flag' => $flag,
            'code' => $code
        );
        $this->db->where('code', $code);
        $sql = $this->db->update('u_plang', $data);


        return $code;
    }

    public function update_translation($key, $value, $language, $u_translatestamp) {
        $query = "
		UPDATE
			u_translate
			
		SET
				keyvalue ='" . $key . "',
				textvalue ='" . str_replace("'", "''", $value) . "'
		where	
			u_translatestamp = '" . $u_translatestamp . "'
			
		";
        $u = $this->mssql->mssql__execute($query);

        return $u;
    }

}
