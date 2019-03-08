<?php

/**
 * @name        CodeIgniter Template Library
 * @author      Jens Segers
 * @link        http://www.jenssegers.be
 * @license     MIT License Copyright (c) 2012 Jens Segers
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
 */
if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class DossierInterno {

    public $bo = array();
    public $bo2 = array();
    public $bo3 = array();
    public $bi = array();
    public $curbi;

    public function __construct($config = array()) {
        $this->_ci = & get_instance();
        $this->_ci->load->model('Bo_model', 'bo_model');

        $this->initializeArrays();
        log_message('debug', 'Dossier Interno inicializado');
    }

    private function initializeArrays() {
        $this->bo["no"] = 0;
        $this->bo["nome"] = '';
        $this->bo["morada"] = '';
        $this->bo["ncont"] = '';
        $this->bo["local"] = '';
        $this->bo["codpost"] = '';
        $this->bo["email"] = '';
        $this->bo["telefone"] = '';
        $this->bo["ndos"] = 0;
        $this->bo["obs"] = '';
        $this->bo["obstab2"] = '';
        $this->bo["vendedor"] = 0;
        $this->bo["etotal"] = 0;
        $this->bo["tpstamp"] = '';

        $curbi = -1;
    }

    private function exists($table, $index) {
        switch ($table) {
            case "bo":
                return array_key_exists($index, $this->bo);
                break;
            case "bo2":
                return array_key_exists($index, $this->bo2);
                break;
            case "bo3":
                return array_key_exists($index, $this->bo3);
                break;
        }
    }

    public function dobotots() {
        $curetotal = 0;
        if(count($this->bi)) {
            foreach($this->bi as $_bi) {
                $curetotal += $_bi["ettdeb"];
            }
        }
        
        $this->bo["etotal"] = $curetotal;
    }
    
    public function doetiliq() {
        $qtt = $this->bi[$this->curbi]["qtt"];
        $epv = $this->bi[$this->curbi]["edebito"];
        $desconto = $this->bi[$this->curbi]["desconto"];

        $ettiliq = $qtt * $epv;
        $ettiliq = ($desconto > 0) ? $ettiliq * (1 - ($desconto / 100)) : $ettiliq;
        
        $this->bi[$this->curbi]["ettdeb"] = $ettiliq;
        $this->dobotots();
    }

    public function set($table, $name, $value) {
        if ($table == "bi") {
            $this->$table[$this->curbi][$name] = $value;
            $this->doetiliq();
        } else {
            $this->$table[$name] = $value;
        }
    }

    public function get($table, $name = "") {
        if ($table == "bi") {
            if ($name == "") {
                return $this->$table[$this->curbi];
            } else {
                return $this->$table[$this->curbi][$name];
            }
        } else {
            if ($name == "") {
                return $this->$table;
            } else {
                return $this->$table[$name];
            }
        }
    }

    public function newBi() {
        $this->bi[] = array();
        $this->curbi = sizeof($this->bi) - 1;

        $this->bi[$this->curbi]["ref"] = "";
        $this->bi[$this->curbi]["design"] = "";
        $this->bi[$this->curbi]["qtt"] = 0;
        $this->bi[$this->curbi]["edebito"] = 0;
        $this->bi[$this->curbi]["desconto"] = 0;
        $this->bi[$this->curbi]["ettdeb"] = 0;
    }

    public function save() {
        return $this->_ci->bo_model->saveNewBo($this);
    }

    public function printData() {
        log_message("error", print_r($this->bo, true));
        log_message("error", print_r($this->bo2, true));
        log_message("error", print_r($this->bo3, true));
        log_message("error", print_r($this->bi, true));
    }

}
