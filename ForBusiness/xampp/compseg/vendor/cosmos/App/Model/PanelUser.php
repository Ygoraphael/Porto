<?php

namespace App\Model;

use App\Interfaces\iPanel;

class PanelUser implements iPanel {

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
        return $this->getController()->load('Panel/User', 'User');
    }

    public function survey() {
        return $this->getController()->load('Panel/Survey', 'User');
    }

    public function securitydialog() {
        return $this->getController()->load('Panel/SecurityDialog', 'DialogsToAnswer');
    }

    public function safetywalk() {
        return $this->getController()->load('Panel/SafetyWalk', 'SafetyWalksToAnswer');
    }

    public function insecurity() {
        return $this->getController()->load('Panel/Insecurity', 'User');
    }

    public function company() {
        return $this->getController()->load('Panel/Company', 'User');
    }

    public function sector() {
        return $this->getController()->load('Panel/Sector', 'Sector');
    }

    public function factory() {
        return $this->getController()->load('Panel/Factory', 'Factory');
    }
    
    public function settings() {
        return $this->getController()->load('Panel/Settings', 'Factory');
    }

}
