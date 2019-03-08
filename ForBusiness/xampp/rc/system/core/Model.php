<?php

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2017, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2017, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/libraries/config.html
 */
class CI_Model {

    /**
     * Class constructor
     *
     * @return	void
     */
    public function __construct() {
        log_message('info', 'Model Class Initialized');
    }

    // --------------------------------------------------------------------

    /**
     * __get magic
     *
     * Allows models to access CI's loaded classes using the same
     * syntax as controllers.
     *
     * @param	string	$key
     */
    public function __get($key) {
        // Debugging note:
        //	If you're here because you're getting an error message
        //	saying 'Undefined Property: system/core/Model.php', it's
        //	most likely a typo in your model code.
        return get_instance()->$key;
    }

    public function getRegister($obj) {
        //params
        if (is_array($obj)) {
            $this->db->select('*');
            $this->db->from(str_replace("_model", "", strtolower(get_class($this))));

            foreach ($obj as $param) {
                $this->db->where($param[0], $param[1]);
            }
            $result = $this->db->get()->result_array();
            if (count($result))
                return $result[0];
            else
                return array();
        }
        //stamp
        if (is_string($obj)) {
            $this->db->select('*');
            $this->db->from(str_replace("_model", "", strtolower(get_class($this))));
            $this->db->where(str_replace("_model", "", strtolower(get_class($this))) . 'stamp', $obj);

            $result = $this->db->get()->result_array();
            if (count($result))
                return $result[0];
            else
                return array();
        }
    }

    public function getAll($params=array(), $where=array(), $orderby=array(), $limit=0) {
        $this->db->select($params);
        $this->db->from(str_replace("_model", "", strtolower(get_class($this))));
        if(count($where)) {
            foreach ($where as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        if(count($orderby)) {
            foreach ($orderby as $key => $value) {
                $this->db->order_by($key, $value);
            }
        }
        if($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get()->result_array();
    }

}
