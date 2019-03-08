<?php

namespace Cosmos\System;

use App\Controller\Authentication;
use App\Controller\User;

abstract class Controller {

    private $class;
    private static $classModel;
    private static $headerInclude = APP_PATH . 'vendor/cosmos/App/Includes/header.php';
    private static $headerIncludeStatus = true;
    private static $footerInclude = APP_PATH . 'vendor/cosmos/App/Includes/footer.php';
    private static $footerIncludeStatus = true;
    private $authorized = true;
    protected $directory = 'Panel';
    protected $panel;

    function __construct($class) {
        $this->class = get_class($class);
        $this->setClassModel();
        $this->isAuthorized();
    }

    private function isAuthorized() {
        $parameters = [
            'link' => ['=', strtolower($_SERVER['REQUEST_URI'])]
        ];
        $page = (new \App\Model\Page)->listingRegisters($parameters)[0];
        if (!is_null($page)) {
            $this->authorized = $page->getAuthorized();
        }
    }

    private function setClassModel() {
        self::$classModel = str_replace("\\Controller\\", "\\Model\\", $this->class);
    }

    private function getObjectModel() {
        return new self::$classModel;
    }

    public function fetch(int $index) {
        return $this->getObjectModel()->fetch($index);
    }

    protected function setHeader(string $header) {
        self::$headerInclude = $header;
    }

    public static function getHeader(): string {
        return self::$headerInclude;
    }

    public static function getHeaderIncludeStatus(): bool {
        return self::$headerIncludeStatus;
    }

    protected static function setHeaderIncludeStatus(bool $headerIncludeStatus) {
        self::$headerIncludeStatus = $headerIncludeStatus;
    }

    protected function setFooter(string $footer) {
        self::$footerInclude = $footer;
    }

    public static function getFooter(): string {
        return self::$footerInclude;
    }

    public static function getFooterIncludeStatus(): bool {
        return self::$footerIncludeStatus;
    }

    protected static function setFooterIncludeStatus(bool $footerIncludeStatus) {
        self::$footerIncludeStatus = $footerIncludeStatus;
    }

    public function error404() {
        return $this->load('Public', '404');
    }

    public function index() {
        
    }

    protected function requiresAuthentication() {
        if (!\App\Model\User::getUserLoged()) {
            return Helper::redirect('/login');
        }
    }

    public function load(string $path, string $archive = null, bool $HeaderIncludeStatus = true, bool $FooterIncludeStatus = true, bool $path_view = true) {
        $path = ucfirst($path);
        $archive = $archive != null ? ucfirst($archive) : 'Index';
        $file = $path_view ? APP_PATH . "vendor/cosmos/App/Views/{$path}/{$archive}.php" : $path;
        if ($HeaderIncludeStatus) {
            include_once $this->getHeader();
        }
        if (is_readable($file)) {
            if ($this->authorized) {
                require_once($file);
            } else {
                require_once(APP_PATH . "vendor/cosmos/App/Views/Public/Unautorized.php");
            }
        } else {
            $this->error404();
        }
        if ($FooterIncludeStatus) {
            include_once $this->getFooter();
        }
    }

    public function unautorized() {
        return $this->load('Public', 'Unautorized');
    }

    public function upload() {
        if (!empty($_FILES['file_name'])) {
            $temp = file_get_contents($_FILES['file_name']['tmp_name']);
            $image = array('name' => $_FILES['file_name']['name'], 'data' => $temp);
            $_SESSION['imagem'][$_FILES['imagem']['name']] = $image;
            if (isset($_SESSION['imagem'])) {
                echo true;
            }
            echo false;
        }
    }

    protected function upload_session_folder() {
        Helper::my_session_start();
        $className = explode("\\", $this->class);
        $dir = strtolower(array_pop($className));
        $uploaddir = APP_PATH . "upload/{$dir}/";
        foreach ($_SESSION['imagem'] as $img) {
            file_put_contents("{$uploaddir}/{$img['name']}", $img['data']);
            $img_name = $img['name'];
        }
        session_unset('imagem');
        return $img_name;
    }

    protected function sendEmail(string $subject, string $message, string $email, string $name): bool {
        $mail = new \Cosmos\System\Mail();
        $mail->IsSMTP();
        $mail->Host = APP_EMAIL_HOST;
        $mail->SMTPAuth = APP_EMAIL_SSL;
        $mail->Username = APP_EMAIL_USERNAME; // Usuário do servidor SMTP
        $mail->Password = APP_EMAIL_PASSWORD; // Senha do servidor SMTP
        $mail->From = APP_EMAIL_FROMEMAIL; // Seu e-mail
        $mail->FromName = APP_EMAIL_FROMNAME; // Seu nome
        $mail->AddAddress($email, $name);
        $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $subject; // Assunto da mensagem
		
		$tpl = (new \Cosmos\System\Template(APP_PATH_TPL . 'public/email.html'));
		$tpl->body = $message;
		$message = $tpl->parse();
		
        $mail->Body = $message;
        $send = $mail->Send();
        $mail->ClearAllRecipients();
        $mail->ClearAttachments();
        return $send;
    }

}
