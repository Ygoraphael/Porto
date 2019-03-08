<?php

namespace App\Model;

use App\Interfaces\iPanel;

class UserPanel implements iPanel {

    public function panel() {
        return 'User';
    }

}
