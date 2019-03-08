<?php

namespace App\Model;

use Cosmos\System\Model;

class Translate extends Model {

    private $text_default;
    private $lang;
    private $text;

    public function __construct() {
        if ((new \App\Model\User())->getUserLoged()) {
            if ((new \App\Model\User())->getUserLoged()->getUser_type() == 1) {
                $_SESSION['lang'] = 'pt';
                $this->lang = $_SESSION['lang'];
            } else {
                $companys = (\App\Model\Company::getCompany());
                $idLanguage = $companys->getLanguage();
                $language = (new \App\Model\Language())->fetch($idLanguage);
                $lang = $language->getLang();
                $_SESSION['lang'] = $lang;
                $this->lang = $_SESSION['lang'];
            }
        } else {
            $_SESSION['lang'] = 'pt';
            $this->lang = $_SESSION['lang'];
        }
        parent::__construct($this);
    }

    function getLang() {
        return $this->lang;
    }

    function getText() {
        return $this->text;
    }

    function getText_default() {
        return $this->text_default;
    }

    function setText_default($text_default) {
        $this->text_default = $text_default;
    }

    function setLang($lang) {
        $this->lang = $lang;
    }

    function setText($text) {
        $this->text = $text;
    }

    public function getTextTranslate() {
        return (new \App\Dao\Translate($this))->getTextTranslate();
    }

    public function translater($data) {
        $this->setText_default($data);
        $this->translate = ($this->getTextTranslate()->getText());
        return $this->translate;
    }
}
