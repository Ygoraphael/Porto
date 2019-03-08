<?php

namespace App\Model;

use App\Interfaces\iPanel;

class PanelCompany implements iPanel {

    function __construct() {
    }
    
    private function getController() {
        return (new \App\Controller\Panel());
    }

    public function panel() {
        return $this->getController()->load('Panel', 'All');
    }
    
    public function dash() {
        return $this->getController()->load('Panel', 'All');
    }

    public function user() {
        return $this->getController()->load('Panel/User', 'Company');
    }

    public function survey() {
        return $this->getController()->load('Panel/Survey', 'Company');
    }
    
    public function safetywalk() {
        return $this->getController()->load('Panel/SafetyWalk', 'Company');
    }

    public function insecurity() {
        return $this->getController()->load('Panel/Insecurity', 'Company');
    }

    public function securitydialog() {
        return $this->getController()->load('Panel/SecurityDialog', 'Company');
    }

    public function company() {
        return $this->getController()->load('Panel/Company', 'Company');
    }

    public function factory() {
        return $this->getController()->load('Panel/Factory', 'Company');
    }

    public function sector() {
        return $this->getController()->load('Panel/Sector', 'Company');
    }
    
    public function category() {
        return $this->getController()->load('Panel/Category', 'Company');
    }

    public function profile() {
        return $this->getController()->load('Panel/Profile', 'Company');
    }
    
    public function settings() {
        return $this->getController()->load('Panel/Settings', 'Company');
    }

}
