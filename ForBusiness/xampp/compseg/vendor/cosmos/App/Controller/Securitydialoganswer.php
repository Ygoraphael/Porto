<?php

namespace App\Controller;

use Cosmos\System\Controller;

class SecurityDialogAnswer extends Controller {

    private $securitydialog_answer;
    private $response;
    private $user;
    private $securitydialog;

    function __construct() {
        $this->requiresAuthentication();
        $this->users = \App\Model\User::getAllUsers();
        parent::__construct($this);
    }

    public function save() {
        $this->helperSaveAnswer();
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo $this->response['type'];
    }

    private function helperSaveAnswer() {
        if (!empty($_POST['presencas']) && !empty($_POST['notification_id'])) {
            $notification_id = filter_input(INPUT_POST, 'notification_id', FILTER_SANITIZE_NUMBER_INT);
            $presencas = filter_input(INPUT_POST, 'presencas', FILTER_SANITIZE_STRING);

            $parameters = [
                'idNotification' => ['=', $notification_id, 'AND'],
                'user' => ['=', \App\Model\User::getUserLoged()->getId(), 'AND'],
                'deleted' => ['=', 0]
            ];
            $notification = (new \App\Model\Notification())->listingRegisters($parameters);

            if (!empty($notification)) {
                $notification = $notification[0];
                $this->securitydialog_answer = new \App\Model\SecurityDialogAnswer;
                $this->securitydialog_answer->setUser(\App\Model\User::getUserLoged()->getId());
                $this->securitydialog_answer->setSecurityDialogWeek($notification->getValue1());
                $this->securitydialog_answer->setAttendance($presencas);
                $this->securitydialog_answer->insert();
                if ($this->securitydialog_answer->getMessage()->getType() == 1) {
                    $this->response['message'] = '%%Dialogue responded successfully%%!';
                    $this->response['type'] = 1;
                } else {
                    $this->response['message'] = '%%Internal error responding to dialogue%%!';
                    $this->response['type'] = $this->securitydialog_answer->getMessage()->getType();
                }
                
                $this->securitydialog_answer = $this->securitydialog_answer->getMessage()->getId();

                $notification_id = $_POST['notification_id'];
                $notification = (new \App\Model\Notification())->fetch($notification_id);
                $notification->setDeleted(1);
                $notification->setTable2("securitydialoganswer");
                $notification->setValue2($this->securitydialog_answer);
                $notification->update();
            } else {
                //sem permissao ou nao existe
            }
        }
    }

}
