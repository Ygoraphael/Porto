<?php

namespace App\Model;

use App\Interfaces\iPanel;

class PanelAdministrator implements iPanel {

    private function getController() {
        return (new \App\Controller\Panel());
    }

    public function panel() {
        return $this->getController()->load('Panel', 'Administrator');
    }
    
    public function dash() {
        return $this->getController()->load('Panel', 'Administrator');
    }

    public function user() {
        return $this->getController()->load('Panel/User', 'Administrator');
    }

    public function survey() {
        return $this->getController()->load('Panel/Survey', 'Administrator');
    }
    
    public function safetywalk() {
        return $this->getController()->load('Panel/SafetyWalk', 'Administrator');
    }

    public function insecurity() {
        return $this->getController()->load('Panel/Insecurity', 'Administrator');
    }

    public function securitydialog() {
        return $this->getController()->load('Panel/SecurityDialog', 'Administrator');
    }

    public function factory() {
    }
    
    public function sector() {
    }
    
    public function category() {
    }
    
    public function profile() {
    }

    public function company() {
        return $this->getController()->load('Panel/Company', 'Index');
    }
    
    public function settings() {
        return $this->getController()->load('Panel/Settings', 'Administrator');
    }

}
