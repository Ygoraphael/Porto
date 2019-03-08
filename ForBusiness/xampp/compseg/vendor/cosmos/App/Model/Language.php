<?php

namespace App\Model;

use Cosmos\System\Model;

class Language extends Model {

    private $lang;
    private $text;

    public function __construct() {
        parent::__construct($this);
    }

    function getLang() {
        return $this->lang;
    }

    function getText() {
        return $this->text;
    }

    function setLang($lang) {
        $this->lang = $lang;
    }

    function setText($text) {
        $this->text = $text;
    }

    public function listing() {
        return (new \App\Dao\Language())->listing();
    }

}