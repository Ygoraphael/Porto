<?php

namespace App\Controller;

use Cosmos\System\Controller;

class Dialog extends Controller {

    private $securitydialog;
    private $securitydialogweek;
    private $response;

    function __construct() {
        $month = date('m');
        $year = date('Y');
        $day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));
        $daystart = date('Y-m-d', mktime(0, 0, 0, $month - 1, $day, $year));
        $dayend = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));

        $_SESSION['day_start'] = $daystart;
        $_SESSION['day_end'] = $dayend;
        parent::__construct($this);
    }

    public function new_dialog() {
        $this->load("{$this->directory}/SecurityDialog", 'New', false, false);
    }

    public function view() {
        if (func_num_args()) {
            $id = (int) func_get_arg(0);
            $_GET['id'] = $id;
            $this->load("{$this->directory}/SecurityDialog", 'View');
        } else {
            \Cosmos\System\Helper::redirect('/panel/securitydialogs');
        }
    }

    public function viewanswer() {
        if (func_num_args()) {
            $id = (int) func_get_arg(0);
            $_GET['id'] = $id;
            $this->load("{$this->directory}/SecurityDialog", 'ViewAnswer');
        } else {
            \Cosmos\System\Helper::redirect('/panel/securitydialogs');
        }
    }

    public function answer() {
        if (func_num_args()) {
            $id = (int) func_get_arg(0);
            $_GET['id'] = $id;
            $this->load("{$this->directory}/SecurityDialog", 'Answer');
        } else {
            \Cosmos\System\Helper::redirect('/panel/securitydialogs');
        }
    }

    public function dialogs() {
        if (func_num_args()) {
            parse_str( str_replace("?", "", func_get_arg(0)), $t);

            $_GET['dls'] = $t["s2"];
            $_GET['dle'] = $t["e2"];

            $_GET['user'] = $t["t"];
            $_GET['status'] = $t["t2"];

            $this->load("{$this->directory}/SecurityDialog", 'Dialogs');
        } else {
            $_GET['dls'] = $_SESSION['day_start'];
            $_GET['dle'] = $_SESSION['day_end'];

            $_GET['user'] = 0;
            $_GET['status'] = 100;
            $this->load("{$this->directory}/SecurityDialog", 'Dialogs');
        }
    }

    public function dialogstoanswer() {
        if (func_num_args()) {
            $t = explode("=", func_get_arg(0));
            $this->load("{$this->directory}/SecurityDialog", 'DialogsToAnswer');
        } else {
            $_GET['s'] = '';
            $_GET['e'] = '';
            $this->load("{$this->directory}/SecurityDialog", 'DialogsToAnswer');
        }
    }

    public function rules() {
        if (func_num_args())
            $ano = (int) func_get_arg(0);
        else
            $ano = 0;
        $_GET['ano'] = $ano;
        $this->load("{$this->directory}/SecurityDialog", 'Rules');
    }

    public function rulessave() {
        $this->helperRulesSaveSecurityDialog();
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo $this->response['type'];
    }

    private function helperRulesSaveSecurityDialog() {
        $securitydialogs = filter_input(INPUT_POST, 'securitydialogs', FILTER_SANITIZE_STRING);
        $year = filter_input(INPUT_POST, 'year', FILTER_SANITIZE_STRING);

        $securitydialogs = json_decode(rawurldecode($securitydialogs), true);
        if ($securitydialogs) {
            if (!empty($securitydialogs)) {
                foreach ($securitydialogs as $securitydialog) {
                    $parameters = [
                        'securitydialog' => ['=', $securitydialog["id"], 'AND'],
                        'year' => ['=', $year]
                    ];
                    $securitydialogweek = (new \App\Model\SecurityDialogWeek)->listingRegisters($parameters);

                    if (sizeof($securitydialogweek)) {
                        $this->securitydialogweek = $securitydialogweek[0];
                        $this->securitydialogweek->setWeek($securitydialog["value"]);
                        $this->securitydialogweek->saveUpdate();

                        if ($this->securitydialogweek->getMessage() == TRUE) {
                            $this->response['type'] = 1;
                            $this->response['message'] = '%%Dialogue updated successfully%%!';
                        } else {
                            $this->response['type'] = 0;
                            $this->response['message'] = '%%Could not update dialogue%%!';
                        }
                    } else {
                        $this->securitydialogweek = new \App\Model\SecurityDialogWeek();
                        $this->securitydialogweek->setSecurityDialog($securitydialog["id"]);
                        $this->securitydialogweek->setYear($year);
                        $this->securitydialogweek->setWeek($securitydialog["value"]);
                        $this->securitydialogweek->register();

                        if ($this->securitydialogweek->getMessage()->getType() == 1) {
                            $this->response['message'] = '%%Rule updated successfully%%!';
                            $this->response['type'] = 1;
                        } else {
                            $this->response['message'] = '%%Could not update rule%%!';
                            $this->response['type'] = 0;
                        }
                    }
                }
                $securitydialogweek = (new \App\Model\SecurityDialogWeek)->runDialogNotifications();
            } else {
                $this->response['message'] = '%%Could not update rules%%!';
                $this->response['type'] = 0;
            }
        } else {
            $this->response['message'] = '%%Could not update rules%%!';
            $this->response['type'] = 0;
        }
    }

    public function save() {
        $name = basename($_FILES['file_name']['name']);
        $encryp = bin2hex(openssl_random_pseudo_bytes(2));
        $name_encryp = $encryp . "_" . $name;
        $this->uploadRegister($name_encryp);
        $this->helperSaveSecurityDialog($name_encryp);
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo $this->response['type'];
        \Cosmos\System\Helper::redirect('/panel/securitydialogs');
    }

    private function uploadRegister($name_encryp) {
        $uploaddir = APP_PATH . 'html/assets/images/dialog/';
        $name_encryp2 = $name_encryp;
        $uploadfile = $uploaddir . $name_encryp2;
        move_uploaded_file($_FILES['file_name']['tmp_name'], $uploadfile);
    }

    private function helperSaveSecurityDialog($name_encryp) {
        $this->securitydialog = new \App\Model\SecurityDialog();
        $this->securitydialog->register($name_encryp);
        if ($this->securitydialog->getMessage()->getType() == 1) {
            $this->response['message'] = '%%Dialogue successfully saved%%!';
            $this->response['type'] = 1;
        } else {
            $this->response['message'] = '%%Unable to save dialogue%%!';
            $this->response['type'] = 0;
        }
    }

    public function edit() {
        $this->load("{$this->directory}/SecurityDialog", 'Edit', false, false);
    }

    public function saveedit() {
        if (!empty(basename($_FILES['file_name']['name']))) {
            $name = basename($_FILES['file_name']['name']);
            $encryp = bin2hex(openssl_random_pseudo_bytes(2));
            $name_encryp = $encryp . "_" . $name;
            $this->uploadRegister($name_encryp);
        } else {
            $name_encryp = filter_input(INPUT_POST, 'AltImage', FILTER_SANITIZE_STRING);
        }
        $this->saveUpdate($name_encryp);
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo $this->response['type'];
        \Cosmos\System\Helper::redirect('/panel/securitydialogs');
    }

    private function saveUpdate($name_encryp) {
        $this->id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $this->securitydialog = (new \App\Model\SecurityDialog())->fetch($this->id);
        $this->securitydialog->saveUpdate($name_encryp);
        if ($this->securitydialog->getMessage() == TRUE) {
            $this->response['type'] = 1;
            $this->response['message'] = '%%Dialogue updated successfully%%!';
        } else {
            $this->response['type'] = 0;
            $this->response['message'] = '%%Could not update dialogue%%!';
        }
    }

    public function delete() {
        $this->securitydialog = (new \App\Model\SecurityDialog());
        $this->status = $this->securitydialog->delete();
        if ($this->status) {
            $this->response['type'] = 1;
            $this->response['message'] = 'Diálogo apagado com sucesso!';
        }
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo json_encode($this->response);
    }

}
