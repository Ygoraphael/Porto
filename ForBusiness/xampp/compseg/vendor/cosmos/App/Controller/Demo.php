<?php

/**
 * Product: Meteor
 * Created by Cosmos Digital.
 * Developer: Jeferson Kaefer
 * Date: 12/09/2016
 * Time: 02:43
 */

namespace App\Controller;

use Cosmos\System\Controller;

class Demo extends Controller {

    function __construct() {
        parent::__construct($this);
    }

    public function index() {
        $nome = filter_input(INPUT_POST, 'demo_nome', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'demo_email', FILTER_SANITIZE_STRING);

        if (isset($_POST['g-recaptcha-response'])) {
            $post_data = http_build_query(
                    array(
                        'secret' => "6LfIf00UAAAAAG8uyTtUdlz4Y4SKuNt0bbslt4V8",
                        'response' => $_POST['g-recaptcha-response'],
                        'remoteip' => $_SERVER['REMOTE_ADDR']
                    )
            );

            $opts = array('http' =>
                array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $post_data
                )
            );
            $context = stream_context_create($opts);
            $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
            $result = json_decode($response);
        } else {
            $result = (object) array('success' => false);
        }

        if ($result->success) {
            $message = "<p>Pedido de Demonstração IChooseSafety</p>
		<p>Dados Formulário:</p>
		<table border='0' cellpadding='0' cellspacing='0' class='btn btn-primary'>
                    <tbody>
                        <tr>
                            <td align='center'>Nome: </td>
                            <td align='left'>" . $nome . "</td>
                        </tr>
                        <tr>
                            <td align='center'>Email: </td>
                            <td align='left'>" . $email . "</td>
                        </tr>
                    </tbody>
		</table>";

            parent::sendEmail("Pedido de Demonstração IChooseSafety", $message, "lfeiteira@ltm.pt", "IChooseSafety");

            \Cosmos\System\Helper::my_session_start();
            $_SESSION['msg'] = "Pedido de demonstração enviado com sucesso!";
            $_SESSION['tipo'] = 1;
        }
        \Cosmos\System\Helper::redirect('/');
    }

}
