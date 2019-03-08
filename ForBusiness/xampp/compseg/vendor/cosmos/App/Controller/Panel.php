<?php

namespace App\Controller;

use Cosmos\System\Controller;

class Panel extends Controller {

    public function __construct() {
        $this->requiresAuthentication();
        $this->panel = (new \App\Model\UserType())->getPanel();

        $month = date('m');
        $year = date('Y');
        $day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));
        $daystart = date('Y-m-d', mktime(0, 0, 0, $month - 1, $day, $year));
        $dayend = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));

        $_SESSION['day_start'] = $daystart;
        $_SESSION['day_end'] = $dayend;
        parent::__construct($this);
    }

    public function index() {
        $this->panel->panel();
    }

    public function dash() {
        if (func_num_args()) {
            parse_str(func_get_arg(0), $output);
            $_POST["params"] = rawurlencode(json_encode($output));
            $this->panel->dash();
        } else {
            $this->panel->dash();
        }
    }

    public function users() {
        if (func_num_args()) {
            $t = explode("=", func_get_arg(0));
            $this->panel->user();
        } else {
            $_GET['t'] = 100;
            $_GET['c'] = 0;
            $_GET['p'] = 0;
            $this->panel->user();
        }
    }

    public function surveys() {
        if (func_num_args()) {
            $t = explode("=", func_get_arg(0));
            $t2 = $t[1];
            $t3 = $t[2];
            $t4 = (int) $t[3];
            $p = (int) $t[4];
            $t22 = explode("&", $t[1]);
            $s = $t22[0];
            $t23 = explode("&", $t[2]);
            $e = $t23[0];

            $_GET['t'] = $t4;
            $_GET['s'] = $s;
            $_GET['e'] = $e;
            $_GET['p'] = $p;
            $this->panel->survey();
        } else {
            $_GET['t'] = 100;
            $_GET['s'] = $_SESSION['day_start'];
            $_GET['e'] = $_SESSION['day_end'];
            $_GET['p'] = 0;
            $this->panel->survey();
        }
    }

    public function safetywalks() {
        if (func_num_args()) {
            $t = explode("=", func_get_arg(0));
            $this->panel->safetywalk();
        } else {

            $_GET['s'] = $_SESSION['day_start'];
            $_GET['e'] = $_SESSION['day_end'];
            $_GET['t'] = 100;
            $_GET['p'] = 0;
            $this->panel->safetywalk();
        }
    }

    public function insecuritys() {
        if (func_num_args()) {
            $t = explode("=", func_get_arg(0));
            $t22 = explode("&", $t[1]);
            $s = $t22[0];
            $t23 = explode("&", $t[2]);
            $e = $t23[0];

            $u23 = explode("&", $t[3]);
            $u = $u23[0];
            $t2 = $t[4];

            $_GET['s'] = $s;
            $_GET['e'] = $e;
            $_GET['u'] = $u;
            $_GET['t'] = $t2;
            $this->panel->insecurity();
        } else {
            $s = '';
            $e = '';
            $t2 = 100;
            $u = '';
            $_GET['t'] = $t2;
            $_GET['s'] = $_SESSION['day_start'];
            $_GET['e'] = $_SESSION['day_end'];
            $_GET['u'] = $u;

            $this->panel->insecurity();
        }
    }

    public function securitydialogs() {
        if (func_num_args()) {
            $t = explode("=", func_get_arg(0));
            $p = $t[1];

            $_GET['p'] = $p;
            $this->panel->securitydialog();
        } else {
            $_GET['p'] = 0;
            $_GET['s'] = $_SESSION['day_start'];
            $_GET['e'] = $_SESSION['day_end'];
            $this->panel->securitydialog();
        }
    }

    public function companys() {
        if (func_num_args()) {
            $this->panel->company();
        } else {
            $_GET['s'] = 100;
            $this->panel->company();
        }
    }

    public function factory() {
        $this->panel->factory();
    }

    public function sector() {
        if (func_num_args()) {
            $t = explode("=", func_get_arg(0));
            $this->panel->sector();
        } else {
            $_GET['f'] = 0;
            $this->panel->sector();
        }
    }

    public function category() {
        $this->panel->category();
    }

    public function profile() {
        $this->panel->profile();
    }

    public function settings() {
        $this->panel->settings();
    }

}
