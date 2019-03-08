<?php

namespace App\Model;

use Cosmos\System\Model;

class SafetyWalkQuestion extends Model {

    private $safetywalk;
    private $text;
    private $checkbox;
    private $ord;

    public function __construct() {
        parent::__construct($this);
    }

    function getSafetyWalk() {
        return $this->safetywalk;
    }

    function getCheckbox() {
        return $this->checkbox;
    }

    function getOrd() {
        return $this->ord;
    }

    function getText() {
        return $this->text;
    }

    function setText($text) {
        $this->text = $text;
    }

    function setSafetyWalk($safetywalk) {
        $this->safetywalk = $safetywalk;
    }

    function setCheckbox($checkbox) {
        $this->checkbox = $checkbox;
    }

    function setOrd($ord) {
        $this->ord = $ord;
    }

	public function ShadowQuestion(){
		$this->deleted = "1";
		$this->deleted_at = date('Y-m-d H:i:s');
		$this->update();
	}
}
