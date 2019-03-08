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

class Index extends Controller {

    function __construct() {
        parent::__construct($this);
    }

    public function index() {
        $this->load('Public', 'Index', false, false, true);
    }
    
    public function sendFormDownloadEmail() {
        $nome = filter_input(INPUT_POST, 'InputNome', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'InputEmail1', FILTER_SANITIZE_STRING);
        $google = filter_input(INPUT_POST, 'g-recaptcha-response', FILTER_SANITIZE_STRING);

        if (strlen($google)) {
            $post_data = http_build_query(
                    array(
                        'secret' => "6LfIf00UAAAAAG8uyTtUdlz4Y4SKuNt0bbslt4V8",
                        'response' => $google,
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
            $message = "<p>Preenchimento Formulário Download Ficheiros</p>
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

            parent::sendEmail("Preenchimento Formulário Download Ficheiros IChooseSafety", $message, "lfeiteira@ltm.pt", "IChooseSafety");
            //parent::sendEmail("Preenchimento Formulário Download Ficheiros IChooseSafety", $message, "tiago.loureiro@novoscanais.com", "IChooseSafety");
        }
    }

}
