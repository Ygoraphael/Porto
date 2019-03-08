<?php

namespace App\Dao;

use Cosmos\System\Dao;

class Translate extends Dao {

    private $translate;

    function __construct($translate) {
        $this->translate = $translate;
        parent::__construct($this);
    }

    public function getTextTranslate() {
        return $this->getTranslate();
    }

    private function getTranslate() {
        $parameters = [
            'lang' => ['=', $this->translate->getLang(), 'AND'],
            'text_default' => ['=', $this->translate->getText_default()]
        ];
        $object = parent::selectOne($parameters);
        if (is_object($object)) {
            $this->translate = $object;
        } else {
            $this->translate->setText($this->translate->getText_default());
        }
        return $this->translate;
    }

}
