<?php
include_once 'Mail.php';
include_once 'template.php';

if (!defined('_JEXEC'))
    define('_JEXEC', 1);
if (!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
if (!defined('JPATH_BASE'))
    define('JPATH_BASE', $_SERVER['DOCUMENT_ROOT']);

require_once( JPATH_BASE . DS . 'includes' . DS . 'defines.php' );
require_once( JPATH_BASE . DS . 'includes' . DS . 'framework.php' );
require_once( JPATH_BASE . DS . 'libraries' . DS . 'joomla' . DS . 'factory.php' );

if (!defined('ADP_EMAIL')) {
    define('ADP_EMAIL', 'rsimoes@academiadoprofissional.com');
    define('ADP_EMAIL2', 'lmelo@ltm.pt');
}

date_default_timezone_set('Europe/Lisbon');

function remNlRep($string) {
    return str_replace(">\\r\\n<", "><", $string);
}

function sendEmail($subject, $message, $email, $name, $email2 = "", $name2 = "") {
    $mail = new Mail();
    $mail->IsSMTP();
    $mail->Host = 'mail.academiadoprofissional.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'noreply@academiadoprofissional.com'; // Usuário do servidor SMTP
    $mail->Password = '!&2hvKmps}Ni'; // Senha do servidor SMTP
    $mail->From = 'noreply@academiadoprofissional.com'; // Seu e-mail
    $mail->FromName = 'Academia do Profissional'; // Seu nome
    $mail->AddAddress($email, $name);
    if ($email2 != "") {
        $mail->AddAddress($email2, $name2);
    }
    $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
    $mail->CharSet = 'UTF-8';
    $mail->Subject = $subject; // Assunto da mensagem
    $mail->Body = $message;
    $send = $mail->Send();
    $mail->ClearAllRecipients();
    $mail->ClearAttachments();
    return $send;
}

function addForms($linha, $resultsBAQ, $local) {

    echo "<div class='col-xs-12' style='margin:0px; padding:0px;'>";

    if ($linha['show_title']) {
        echo "<h3>" . $linha['title'] . "</h3><br>";
    }

    echo "<div class='col-sm-12 col-md-5'>";

    echo "<form method='POST' action='" . JURI::base() . "site/redirect.php' id='form_" . $linha['id'] . "'>";

    $counter = 0;
    foreach ($resultsBAQ as $BAQ) {

        if ($BAQ['form_id'] == $linha['id']) {
            switch ($BAQ['plugin_id']) {
                case "1":
                    if ($counter == 0) {

                        echo '<div class="form-group"><label for="f_' . $BAQ['field_name'] . '">' . $BAQ['caption'] . '</label>';
                        echo "<input required class='form-control' style='width:100%' type='text' id='f_" . $BAQ['field_name'] . "' name='f_" . $BAQ['field_name'] . "'></div><br>";
                        $counter++;
                    } else if ($counter == 1) {

                        echo '<div class="form-group"><label for="f_' . $BAQ['field_name'] . '">' . $BAQ['caption'] . '</label>';
                        echo "<input type='email' required class='form-control' style='width:100%' type='text' id='f_" . $BAQ['field_name'] . "' name='f_" . $BAQ['field_name'] . "'></div><br>";
                        $counter++;
                    } else if ($counter == 2) {

                        echo '<div class="form-group"  ><label for="f_' . $BAQ['field_name'] . '">' . $BAQ['caption'] . '</label>';
                        echo "<input type='tel' onkeypress='return event.charCode >= 48 && event.charCode <= 57' required class='form-control' style='width:100%' type='text' id='f_" . $BAQ['field_name'] . "' name='f_" . $BAQ['field_name'] . "'></div><br>";
                        $counter = 0;
                    }
                    break;
                case "2":
                    echo '<div class="form-group"  ><label for="' . $BAQ['form_id'] . "_" . $BAQ['field_name'] . '">' . $BAQ['field_name'] . '</label>';
                    echo "<input type='date' name='" . $BAQ['form_id'] . "_" . $BAQ['plugin_id'] . "_" . $BAQ['field_name'] . "'></div>";
                    break;
                case "3":
                    echo '<div class="form-group"  ><label for="f_' . $BAQ['field_name'] . '">' . $BAQ['field_name'] . '</label>';
                    echo "<textarea class='form-control' id='f_" . $BAQ['field_name'] . "' name='f_" . $BAQ['field_name'] . "' form='form_" . $BAQ['form_id'] . "'></textarea></div><br>";
                    break;
                case "4":
                    echo '<div class="form-group"><label for="' . $BAQ['form_id'] . "_" . $BAQ['field_name'] . '">' . $BAQ['field_name'] . '</label>';
                    echo "<input type='radio' name='" . $BAQ['form_id'] . "_" . $BAQ['plugin_id'] . "_" . $BAQ['field_name'] . "'></div>";
                    break;
                case "5":
                    echo '<div class="form-group"><label for="' . $BAQ['form_id'] . "_" . $BAQ['field_name'] . '">' . $BAQ['field_name'] . '</label>';
                    echo "<input type='checkbox' name='" . $BAQ['form_id'] . "_" . $BAQ['plugin_id'] . "_" . $BAQ['field_name'] . "'></div>";
                    break;
                case "6":
                    echo '<div class="form-group"><label for="' . $BAQ['form_id'] . "_" . $BAQ['field_name'] . '">' . $BAQ['field_name'] . '</label>';

                    echo "<select name='" . $BAQ['form_id'] . "_" . $BAQ['plugin_id'] . "_" . $BAQ['field_name'] . "'>";


                    for ($i = 0; $i < count($text); $i++) {

                        echo "<option value='" . $value[$i] . "' " . $default[$i] . ">" . $text[$i] . "</option>";
                    }

                    $text = array();
                    $value = array();
                    $default = array();

                    echo "</select></div>";

                    break;

                case "7":
                    echo '<div class="form-group"><label for="' . $BAQ['form_id'] . "_" . $BAQ['field_name'] . '">' . $BAQ['field_name'] . '</label>';
                    echo "<select multiple name='" . $BAQ['form_id'] . "_" . $BAQ['plugin_id'] . "_" . $BAQ['field_name'] . "'>";
                    for ($i = 0; $i < count($text); $i++) {
                        echo "<option value='" . $value[$i] . "' " . $default[$i] . ">" . $text[$i] . "</option>";
                    }
                    $text = array();
                    $value = array();
                    $default = array();
                    echo "</select></div>";
                    break;
                case "8":

                    echo '<div class="form-group"><label for="' . $BAQ['form_id'] . "_" . $BAQ['field_name'] . '">' . $BAQ['field_name'] . '</label>';
                    echo "<input type='file' name='" . $BAQ['form_id'] . "_" . $BAQ['plugin_id'] . "_" . $BAQ['field_name'] . "'></div>";
                    break;
                case "9":
                    echo '<div class="form-group"><label for="' . $BAQ['form_id'] . "_" . $BAQ['field_name'] . '">' . $BAQ['field_name'] . '</label>';
                    echo "<input type='file' name='" . $BAQ['form_id'] . "_" . $BAQ['plugin_id'] . "_" . $BAQ['field_name'] . "' accept='image/*'></div>";
                    break;
                case "10":
                    echo '<div class="form-group"><label for="' . $BAQ['form_id'] . "_" . $BAQ['field_name'] . '">' . $BAQ['field_name'] . '</label>';
                    echo "<input type='file' name='" . $BAQ['form_id'] . "_" . $BAQ['plugin_id'] . "_" . $BAQ['field_name'] . "' accept='audio/*|video/*|image/*'></div>";
                    break;


                default:
                    echo "";
            }
        }
    }
    ?>
    <br>
    <script>
        function enableBtn() {
            document.getElementById("btn_sub").disabled = false;
        }
    </script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <div class="g-recaptcha" data-sitekey="6Lf8dj8UAAAAAH0jP8eLQGTuJygXO1tCCeceslW_" data-callback="enableBtn"></div>
    <input style="margin-top:3%" id="btn_sub" type="submit" class="btn btn-primary" name="submit" value="Enviar" disabled />
    <br>
    <br>
    <br>
    <?php
    //////RECAPTCHA                                    
    if (isset($_POST['submit']) && !empty($_POST['submit'])) {
        if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
            //your site secret key
            $secret = '6Lf8dj8UAAAAALTfm75z0Gt6wp1s22Op4LyQN_OV';
            //get verify response data
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
            $responseData = json_decode($verifyResponse);
        }
    }
    echo "<input type='hidden' name='formid' value='" . $linha['id'] . "'>";
    echo "<input type='hidden' name='pageid' value='" . $linha['pagina'] . "'>";
    echo "</form></div><div class='col-sm-12 col-md-6'>";
    if (strlen(trim($linha['description']))) {
        echo $linha['description'];
    }
    echo "</div></div>";
}

function adpcrypt($string, $action = 'e') {
    $secret_key = 's$SNWAf?A7NDY3=m*6xh^x5?nfLEn5ajRPyBm^=Y';
    $secret_iv = 'ksWKMr$=9D4efV*+%CahyT9ZR_7yeaD#jQ_sJKK*';

    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ($action == 'e') {
        $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    } else if ($action == 'd') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

function EnviarEmailInscricaoAcademia($inscricao_id, $tipo) {
    $db = JFactory::getDbo();

    if ($tipo == "empresa") {
        //empresa
        $query = $db->getQuery(true);
        $query->select("e.*");
        $query->from($db->quoteName('empresa', 'e'));
        $query->join('INNER', $db->quoteName('inscricao', 'i') . ' ON (' . $db->quoteName('i.empresa') . ' = ' . $db->quoteName('e.ID') . ')');
        $query->where($db->quoteName('i.ID') . ' = ' . $db->quote($inscricao_id));
        $db->setQuery($query);
        $empresa = $db->loadAssocList();
    } else {
        //empresa - individual
        $query = $db->getQuery(true);
        $query->select("f.NomeFormando NomeEmpresa, f.Morada, f.CodigoPostal, f.Localidade, f.NIF, f.Email, f.Telemovel, f.NomeFormando PessoaContacto");
        $query->from($db->quoteName('inscricao_linha', 'i'));
        $query->join('INNER', $db->quoteName('formandos', 'f') . ' ON (' . $db->quoteName('i.formando') . ' = ' . $db->quoteName('f.ID') . ')');
        $query->where($db->quoteName('i.inscricao') . ' = ' . $db->quote($inscricao_id));
        $db->setQuery($query);
        $empresa = $db->loadAssocList();
    }

    //cabecalho
    $query = $db->getQuery(true);
    $query->select("i.*");
    $query->from($db->quoteName('inscricao', 'i'));
    $query->where($db->quoteName('i.ID') . ' = ' . $db->quote($inscricao_id));
    $db->setQuery($query);
    $cabecalho = $db->loadAssocList();

    //inscricao / formando
    $query = $db->getQuery(true);
    $query->select("f.*, a.Localidade Local, a.DataInicio, c.NomeCurso");
    $query->from($db->quoteName('inscricao_linha', 'i'));
    $query->join('INNER', $db->quoteName('formandos', 'f') . ' ON (' . $db->quoteName('i.formando') . ' = ' . $db->quoteName('f.ID') . ')');
    $query->join('INNER', $db->quoteName('acoes', 'a') . ' ON (' . $db->quoteName('i.acao') . ' = ' . $db->quoteName('a.ID') . ')');
    $query->join('INNER', $db->quoteName('cursos', 'c') . ' ON (' . $db->quoteName('a.RefCurso') . ' = ' . $db->quoteName('c.CC') . ')');
    $query->where($db->quoteName('i.inscricao') . ' = ' . $db->quote($inscricao_id));
    $query->where($db->quoteName('a.exame') . ' = ' . $db->quote(0));
    $db->setQuery($query);
    $inscricoes = $db->loadAssocList();

    //inscricao exame / formando
    $query = $db->getQuery(true);
    $query->select("f.*, a.Localidade Local, a.DataInicio, c.NomeCurso, case i.formacaoadp when 1 then 'Sim' else 'Não' end formacaoadp");
    $query->from($db->quoteName('inscricao_linha', 'i'));
    $query->join('INNER', $db->quoteName('formandos', 'f') . ' ON (' . $db->quoteName('i.formando') . ' = ' . $db->quoteName('f.ID') . ')');
    $query->join('INNER', $db->quoteName('acoes', 'a') . ' ON (' . $db->quoteName('i.acao') . ' = ' . $db->quoteName('a.ID') . ')');
    $query->join('INNER', $db->quoteName('cursos', 'c') . ' ON (' . $db->quoteName('a.RefCurso') . ' = ' . $db->quoteName('c.CC') . ')');
    $query->where($db->quoteName('i.inscricao') . ' = ' . $db->quote($inscricao_id));
    $query->where($db->quoteName('a.exame') . ' = ' . $db->quote(1));
    $db->setQuery($query);
    $inscricoes_exames = $db->loadAssocList();

    if (!empty($cabecalho) && !empty($empresa)) {

        $cabecalho = removeP($cabecalho);
        $empresa = removeP($empresa);
        $inscricoes = removeP($inscricoes);
        $inscricoes_exames = removeP($inscricoes_exames);

        $cabecalho = removeRepStr($cabecalho);
        $empresa = removeRepStr($empresa);
        $inscricoes = removeRepStr($inscricoes);
        $inscricoes_exames = removeRepStr($inscricoes_exames);

        $template = new Template();
        $template->assign('inscricao_id', $inscricao_id);
        $template->assign('empresa', $empresa);
        $template->assign('cabecalho', $cabecalho);
        $template->assign('inscricoes', $inscricoes);
        $template->assign('inscricoes_exames', $inscricoes_exames);

        if (count($inscricoes)) {
            $template->assign('inscricoes_if', array(array()));
        } else {
            $template->assign('inscricoes_if', array());
        }

        if (count($inscricoes_exames)) {
            $template->assign('inscricoes_exames_if', array(array()));
        } else {
            $template->assign('inscricoes_exames_if', array());
        }

        $html = $template->parse('site/email_academia.html');

        sendEmail("Inscrição Academia do Profissional", $html, ADP_EMAIL, "Academia do Profissional", ADP_EMAIL2, "Academia do Profissional");
    }
}

function EnviarEmailInscricaoEmpresa($inscricao_id) {
    $db = JFactory::getDbo();

    //empresa
    $query = $db->getQuery(true);
    $query->select("e.*");
    $query->from($db->quoteName('empresa', 'e'));
    $query->join('INNER', $db->quoteName('inscricao', 'i') . ' ON (' . $db->quoteName('i.empresa') . ' = ' . $db->quoteName('e.ID') . ')');
    $query->where($db->quoteName('i.ID') . ' = ' . $db->quote($inscricao_id));
    $db->setQuery($query);
    $empresa = $db->loadAssocList();

    //cabecalho
    $query = $db->getQuery(true);
    $query->select("i.*");
    $query->from($db->quoteName('inscricao', 'i'));
    $query->where($db->quoteName('i.ID') . ' = ' . $db->quote($inscricao_id));
    $db->setQuery($query);
    $cabecalho = $db->loadAssocList();

    //inscricao / formando
    $query = $db->getQuery(true);
    $query->select("f.*, a.Horario, a.DataInicio, c.NomeCurso, i.preco");
    $query->from($db->quoteName('inscricao_linha', 'i'));
    $query->join('INNER', $db->quoteName('formandos', 'f') . ' ON (' . $db->quoteName('i.formando') . ' = ' . $db->quoteName('f.ID') . ')');
    $query->join('INNER', $db->quoteName('acoes', 'a') . ' ON (' . $db->quoteName('i.acao') . ' = ' . $db->quoteName('a.ID') . ')');
    $query->join('INNER', $db->quoteName('cursos', 'c') . ' ON (' . $db->quoteName('a.RefCurso') . ' = ' . $db->quoteName('c.CC') . ')');
    $query->where($db->quoteName('i.inscricao') . ' = ' . $db->quote($inscricao_id));
    $query->where($db->quoteName('a.exame') . ' = ' . $db->quote(0));
    $db->setQuery($query);
    $inscricoes = $db->loadAssocList();

    //inscricao exame / formando
    $query = $db->getQuery(true);
    $query->select("f.*, a.Horario, a.DataInicio, c.NomeCurso, i.preco");
    $query->from($db->quoteName('inscricao_linha', 'i'));
    $query->join('INNER', $db->quoteName('formandos', 'f') . ' ON (' . $db->quoteName('i.formando') . ' = ' . $db->quoteName('f.ID') . ')');
    $query->join('INNER', $db->quoteName('acoes', 'a') . ' ON (' . $db->quoteName('i.acao') . ' = ' . $db->quoteName('a.ID') . ')');
    $query->join('INNER', $db->quoteName('cursos', 'c') . ' ON (' . $db->quoteName('a.RefCurso') . ' = ' . $db->quoteName('c.CC') . ')');
    $query->where($db->quoteName('i.inscricao') . ' = ' . $db->quote($inscricao_id));
    $query->where($db->quoteName('a.exame') . ' = ' . $db->quote(1));
    $db->setQuery($query);
    $inscricoes_exames = $db->loadAssocList();

    if (!empty($cabecalho) && !empty($empresa)) {

        $cabecalho = removeP($cabecalho);
        $empresa = removeP($empresa);
        $inscricoes = removeP($inscricoes);
        $inscricoes_exames = removeP($inscricoes_exames);

        $cabecalho = removeRepStr($cabecalho);
        $empresa = removeRepStr($empresa);
        $inscricoes = removeRepStr($inscricoes);
        $inscricoes_exames = removeRepStr($inscricoes_exames);

        $template = new Template();
        $template->assign('inscricao_id', $inscricao_id);
        $template->assign('empresa', $empresa);
        $template->assign('cabecalho', $cabecalho);
        $template->assign('inscricoes', $inscricoes);
        $template->assign('inscricoes_exames', $inscricoes_exames);

        if (count($inscricoes)) {
            $template->assign('inscricoes_if', array(array()));
        } else {
            $template->assign('inscricoes_if', array());
        }

        if (count($inscricoes_exames)) {
            $template->assign('inscricoes_exames_if', array(array()));
        } else {
            $template->assign('inscricoes_exames_if', array());
        }


        $html = $template->parse('site/email_empresa.html');

        sendEmail("Inscrição Academia do Profissional", $html, $empresa[0]["Email"], $empresa[0]["NomeEmpresa"]);
    }
}

function EnviarEmailInscricaoEmpresaFormando($inscricao_id) {
    $db = JFactory::getDbo();

    //cabecalho
    $query = $db->getQuery(true);
    $query->select("i.*");
    $query->from($db->quoteName('inscricao', 'i'));
    $query->where($db->quoteName('i.ID') . ' = ' . $db->quote($inscricao_id));
    $db->setQuery($query);
    $cabecalho = $db->loadAssocList();

    //inscricao / formando
    $query = $db->getQuery(true);
    $query->select("f.*, a.Horario, a.DataInicio, c.NomeCurso, i.preco");
    $query->from($db->quoteName('inscricao_linha', 'i'));
    $query->join('INNER', $db->quoteName('formandos', 'f') . ' ON (' . $db->quoteName('i.formando') . ' = ' . $db->quoteName('f.ID') . ')');
    $query->join('INNER', $db->quoteName('acoes', 'a') . ' ON (' . $db->quoteName('i.acao') . ' = ' . $db->quoteName('a.ID') . ')');
    $query->join('INNER', $db->quoteName('cursos', 'c') . ' ON (' . $db->quoteName('a.RefCurso') . ' = ' . $db->quoteName('c.CC') . ')');
    $query->where($db->quoteName('i.inscricao') . ' = ' . $db->quote($inscricao_id));
    $query->where($db->quoteName('a.exame') . ' = ' . $db->quote(0));
    $db->setQuery($query);
    $inscricoes = $db->loadAssocList();

    //inscricao exame / formando
    $query = $db->getQuery(true);
    $query->select("f.*, a.Horario, a.DataInicio, c.NomeCurso, i.preco");
    $query->from($db->quoteName('inscricao_linha', 'i'));
    $query->join('INNER', $db->quoteName('formandos', 'f') . ' ON (' . $db->quoteName('i.formando') . ' = ' . $db->quoteName('f.ID') . ')');
    $query->join('INNER', $db->quoteName('acoes', 'a') . ' ON (' . $db->quoteName('i.acao') . ' = ' . $db->quoteName('a.ID') . ')');
    $query->join('INNER', $db->quoteName('cursos', 'c') . ' ON (' . $db->quoteName('a.RefCurso') . ' = ' . $db->quoteName('c.CC') . ')');
    $query->where($db->quoteName('i.inscricao') . ' = ' . $db->quote($inscricao_id));
    $query->where($db->quoteName('a.exame') . ' = ' . $db->quote(1));
    $db->setQuery($query);
    $inscricoes_exames = $db->loadAssocList();

    if (!empty($cabecalho)) {
        $email = "";
        $nome = "";
        $cabecalho = removeP($cabecalho);
        $inscricoes = removeP($inscricoes);
        $inscricoes_exames = removeP($inscricoes_exames);

        $cabecalho = removeRepStr($cabecalho);
        $inscricoes = removeRepStr($inscricoes);
        $inscricoes_exames = removeRepStr($inscricoes_exames);

        $template = new Template();
        $template->assign('inscricao_id', $inscricao_id);

        $template->assign('cabecalho', $cabecalho);
        $template->assign('inscricoes', $inscricoes);
        $template->assign('inscricoes_exames', $inscricoes_exames);

        if (count($inscricoes)) {
            $email = $inscricoes[0]["Email"];
            $nome = $inscricoes[0]["NomeFormando"];
            $formando_id = $inscricoes[0]["ID"];
            $template->assign('inscricoes_if', array(array()));
        } else {
            $template->assign('inscricoes_if', array());
        }

        if (count($inscricoes_exames)) {
            $email = $inscricoes_exames[0]["Email"];
            $nome = $inscricoes_exames[0]["NomeFormando"];
            $formando_id = $inscricoes_exames[0]["ID"];
            $template->assign('inscricoes_exames_if', array(array()));
        } else {
            $template->assign('inscricoes_exames_if', array());
        }

        $template->assign('link', JURI::base() . "index.php/formdata?hs=" . adpcrypt($formando_id, 'e'));

        $html = $template->parse('site/email_empresaformando.html');

        sendEmail("Inscrição Academia do Profissional", $html, $email, $nome);
    }
}

function EnviarEmailInscricaoFormando($inscricao_id, $formando_id) {
    $db = JFactory::getDbo();

    //cabecalho
    $query = $db->getQuery(true);
    $query->select("i.*");
    $query->from($db->quoteName('inscricao', 'i'));
    $query->where($db->quoteName('i.ID') . ' = ' . $db->quote($inscricao_id));
    $db->setQuery($query);
    $cabecalho = $db->loadAssocList();

    //inscricao / formando
    $query = $db->getQuery(true);
    $query->select("f.*, a.Horario, a.DataInicio, c.NomeCurso, i.preco");
    $query->from($db->quoteName('inscricao_linha', 'i'));
    $query->join('INNER', $db->quoteName('formandos', 'f') . ' ON (' . $db->quoteName('i.formando') . ' = ' . $db->quoteName('f.ID') . ')');
    $query->join('INNER', $db->quoteName('acoes', 'a') . ' ON (' . $db->quoteName('i.acao') . ' = ' . $db->quoteName('a.ID') . ')');
    $query->join('INNER', $db->quoteName('cursos', 'c') . ' ON (' . $db->quoteName('a.RefCurso') . ' = ' . $db->quoteName('c.CC') . ')');
    $query->where($db->quoteName('i.inscricao') . ' = ' . $db->quote($inscricao_id));
    $query->where($db->quoteName('f.ID') . ' = ' . $db->quote($formando_id));
    $query->where($db->quoteName('a.exame') . ' = ' . $db->quote(0));
    $db->setQuery($query);
    $inscricoes = $db->loadAssocList();

    //inscricao exames / formando
    $query = $db->getQuery(true);
    $query->select("f.*, a.Horario, a.DataInicio, c.NomeCurso, i.preco");
    $query->from($db->quoteName('inscricao_linha', 'i'));
    $query->join('INNER', $db->quoteName('formandos', 'f') . ' ON (' . $db->quoteName('i.formando') . ' = ' . $db->quoteName('f.ID') . ')');
    $query->join('INNER', $db->quoteName('acoes', 'a') . ' ON (' . $db->quoteName('i.acao') . ' = ' . $db->quoteName('a.ID') . ')');
    $query->join('INNER', $db->quoteName('cursos', 'c') . ' ON (' . $db->quoteName('a.RefCurso') . ' = ' . $db->quoteName('c.CC') . ')');
    $query->where($db->quoteName('i.inscricao') . ' = ' . $db->quote($inscricao_id));
    $query->where($db->quoteName('f.ID') . ' = ' . $db->quote($formando_id));
    $query->where($db->quoteName('a.exame') . ' = ' . $db->quote(1));
    $db->setQuery($query);
    $inscricoes_exames = $db->loadAssocList();

    if (!empty($cabecalho)) {
        $template = new Template();

        $cabecalho = removeP($cabecalho);
        $inscricoes = removeP($inscricoes);
        $inscricoes_exames = removeP($inscricoes_exames);

        $cabecalho = removeRepStr($cabecalho);
        $inscricoes = removeRepStr($inscricoes);
        $inscricoes_exames = removeRepStr($inscricoes_exames);

        if (count($inscricoes)) {
            $email = $inscricoes[0]["Email"];
            $nome = $inscricoes[0]["NomeFormando"];
            $formando_id = $inscricoes[0]["ID"];
            $template->assign('inscricoes_if', array(array()));
        } else {
            $template->assign('inscricoes_if', array());
        }

        if (count($inscricoes_exames)) {
            $email = $inscricoes_exames[0]["Email"];
            $nome = $inscricoes_exames[0]["NomeFormando"];
            $formando_id = $inscricoes_exames[0]["ID"];
            $template->assign('inscricoes_exames_if', array(array()));
        } else {
            $template->assign('inscricoes_exames_if', array());
        }

        $template->assign('inscricao_id', $inscricao_id);
        $template->assign('nome_formando', $inscricoes[0]["NomeFormando"]);
        $template->assign('link', JURI::base() . "index.php/formdata?hs=" . adpcrypt($formando_id, 'e'));
        $template->assign('cabecalho', $cabecalho);
        $template->assign('inscricoes', $inscricoes);
        $template->assign('inscricoes_exames', $inscricoes_exames);

        $html = $template->parse('site/email_formando.html');
        sendEmail("Inscrição Academia do Profissional", $html, $inscricoes[0]["Email"], $inscricoes[0]["NomeFormando"]);
    }
}

function EnviarEmailDadosFaltaFormando($formando_id) {
    $db = JFactory::getDbo();

    //formando
    $query = $db->getQuery(true);
    $query->select("f.*");
    $query->from($db->quoteName('formandos', 'f'));
    $query->where($db->quoteName('f.ID') . ' = ' . $db->quote($formando_id));
    $db->setQuery($query);
    $formandos = $db->loadAssocList();

    if (!empty($formandos)) {

        $formandos = removeP($formandos);
        $formandos = removeRepStr($formandos);

        $template = new Template();
        $template->assign('nome_formando', $formandos[0]["NomeFormando"]);
        $template->assign('formandos', $formandos);
        $html = $template->parse('site/email_dadosfalta_formando.html');

        sendEmail("Inscrição Academia do Profissional", $html, $formandos[0]["Email"], $formandos[0]["NomeFormando"]);
    }
}

function EnviarEmailDadosFaltaAcademia($formando_id) {
    $db = JFactory::getDbo();

    //formando
    $query = $db->getQuery(true);
    $query->select("f.*");
    $query->from($db->quoteName('formandos', 'f'));
    $query->where($db->quoteName('f.ID') . ' = ' . $db->quote($formando_id));
    $db->setQuery($query);
    $formandos = $db->loadAssocList();

    if (!empty($formandos)) {
        $formandos = removeP($formandos);
        $formandos = removeRepStr($formandos);

        $template = new Template();
        $template->assign('formandos', $formandos);
        $html = $template->parse('site/email_dadosfalta_academia.html');

        sendEmail("ADP formando submeteu dados", $html, ADP_EMAIL, "Academia do Profissional", ADP_EMAIL2, "Academia do Profissional");
    }
}

function limpar_sessao() {
    unset($_SESSION['curso_corrente']);
    unset($_SESSION['caret']);
    unset($_SESSION['caret_user']);
    unset($_SESSION['type']);
    unset($_SESSION['acao']);
    unset($_SESSION['empresa']);
}

function repStr($str) {
    $str = str_replace(array("\\r\\n",), "\n", $str);
    $str = str_replace(array("\\r", "\\n"), "\n", $str);
    $str = str_replace(array('\\"'), "\"", $str);
    $str = str_replace(array("\\'"), "\'", $str);
    return $str;
}

function removeP($array) {
    if (!is_array($array)) {
        return str_replace(array("<p>", "</p>"), "", $array);
    } else {
        foreach ($array as $key => $value) {
            if (is_array($value))
                $array[$key] = removeP($value);
            else
                $array[$key] = str_replace(array("<p>", "</p>"), "", $value);
        }
    }
    return $array;
}

function removeRepStr($array) {
    if (!is_array($array)) {
        return repStr($array);
    } else {
        foreach ($array as $key => $value) {
            if (is_array($value))
                $array[$key] = removeRepStr($value);
            else
                $array[$key] = repStr($value);
        }
    }
    return $array;
}

$db = JFactory::getDbo();
?>

<script>
    jQuery(document).ready(function ($) {
        tinymce.init({
            selector: '.tinyedit',
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            },
            theme: 'modern',
            width: 900,
            height: 200,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons paste textcolor code imagetools"
            ],
            toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
            toolbar2: "| link unlink anchor | image media | forecolor backcolor | print preview code | caption",
            image_caption: true,
            image_advtab: true,
            visualblocks_default_state: true,
            style_formats_autohide: true,
            style_formats_merge: true
        });

        jQuery(function ($) {
            $(document).on('focusin', function (e) {
                if ($(e.target).closest(".mce-window").length) {
                    e.stopImmediatePropagation();
                }
            });
        });
    });

    function openNav() {
        var winwidth = jQuery(window).width();
        jQuery("#mySidenav").css("width", winwidth);
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }

    jQuery(".pagcursonav").on("click", "a", function () {
        scrollToDiv(jQuery(this).attr("data-href"), jQuery(this).attr("data-mob"))
        closeNav();
        window.location.hash = jQuery(this).attr("data-href");
    })

    function findBootstrapEnvironment() {
        
        var envs = ['xs', 'sm', 'md', 'lg'];

        var $el = jQuery('<div>');
        $el.appendTo(jQuery('body'));

        for (var i = envs.length - 1; i >= 0; i--) {
            var env = envs[i];

            $el.addClass('hidden-' + env);
            if ($el.is(':hidden')) {
                $el.remove();
                return env;
            }
        }
    }

    function scrollToDiv(element, mobile) {
        var coffset = 250;
        if (mobile == 1) {
            coffset = 150;
        }
        jQuery('html,body').unbind().animate({scrollTop: jQuery(element).offset().top - coffset}, 'slow');
    }
</script>

<style>
    .modal{
        width: 70% !important;
        margin-left: -35% !important;
    }
    .modal-dialog {
        width: 100% !important;
    }
    .modal-content {
        width: 100% !important;
    }
    .i900 {
        width:900px;
    }
    @media screen and (max-width: 480px) {
        .modal {
            margin-left:13% !important;
            margin-top: -30% !important;
        }
    }
    @media screen and (min-width: 480px) and (max-width: 767px) {
        .modal {
            margin-left:13% !important;
        }
    }
</style>