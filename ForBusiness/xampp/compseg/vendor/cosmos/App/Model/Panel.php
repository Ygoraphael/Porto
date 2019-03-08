<?php

namespace App\Model;

use App\Interfaces\iPanel;

class Panel {
    private $ipanel;

    public function __construct(iPanel $ipanel) {
        $this->ipanel = $ipanel;
    }

    public function panel() {
        return $this->ipanel->panel();
    }
	
	public function dash() {
        return $this->ipanel->dash();
    }

    public function company() {
        return $this->ipanel->company();
    }

    public function user() {
        return $this->ipanel->user();
    }

    public function survey() {
        return $this->ipanel->survey();
    }

}
