<?php

namespace App\Model;

use App\Interfaces\iPanel;

class PanelFactory implements iPanel {

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
        return $this->getController()->load('Panel/Users', 'Factory');
    }

    public function survey() {
        return $this->getController()->load('Panel/Users', 'Factory');
    }
    
    public function safetywalk() {
        return $this->getController()->load('Panel/SafetyWalk', 'Factory');
    }
    
    public function securitydialog() {
        return $this->getController()->load('Panel/SecurityDialog', 'Factory');
    }

    public function insecurity() {
        return $this->getController()->load('Panel/Insecuritys', 'Factory');
    }

    public function company() {
        return $this->getController()->load('Panel/Companys', 'Factory');
    }

    public function sector() {
        return $this->getController()->load('Panel/Sector', 'Factory');
    }
    
    public function settings() {
        return $this->getController()->load('Panel/Settings', 'Factory');
    }

}
