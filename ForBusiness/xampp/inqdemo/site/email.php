<?php
include_once 'Mail.php';
include_once 'db_config.php';

if (isset($_POST['type'])) {
	$_SESSION['type'] = $_POST['type'];
}

function sendEmail($subject, $message, $email, $name) {
    $mail = new Mail();
    $mail->IsSMTP();
    $mail->Host = 'mail.academiadoprofissional.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'noreply@academiadoprofissional.com'; // Usuário do servidor SMTP
    $mail->Password = '!&2hvKmps}Ni'; // Senha do servidor SMTP
    $mail->From = 'noreply@academiadoprofissional.com'; // Seu e-mail
    $mail->FromName = 'Academia do Profissional'; // Seu nome
    $mail->AddAddress($email, $name);
    $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
    $mail->CharSet = 'UTF-8';
    $mail->Subject = $subject; // Assunto da mensagem
    $mail->Body = $message;
    $send = $mail->Send();
    $mail->ClearAllRecipients();
    $mail->ClearAttachments();
    return $send;
}

$NomeFormando5 = mysqli_real_escape_string($conn, $_POST['NomeFormando5']);
$DataNasc5 = mysqli_real_escape_string($conn, $_POST['DataNasc5']);
$Morada5 = mysqli_real_escape_string($conn, $_POST['Morada5']);
$CodigoPostal5 = mysqli_real_escape_string($conn, $_POST['CodigoPostal5']);
$Email5 = mysqli_real_escape_string($conn, $_POST['Email5']);
$Telemovel5 = mysqli_real_escape_string($conn, $_POST['Telemovel5']);
$CartaoCidadao5 = mysqli_real_escape_string($conn, $_POST['CartaoCidadao5']);
$Validade5 = mysqli_real_escape_string($conn, $_POST['Validade5']);
$nCartaConducao5 = mysqli_real_escape_string($conn, $_POST['nCartaConducao5']);
$DataEmissao5 = mysqli_real_escape_string($conn, $_POST['DataEmissao5']);
$DataRenovADR5 = mysqli_real_escape_string($conn, $_POST['DataRenovADR5']);
$NIF5 = mysqli_real_escape_string($conn, $_POST['NIF5']);
$DataRenovCAM5 = mysqli_real_escape_string($conn, $_POST['DataRenovCAM5']);
$DataNasc5 = empty($DataNasc5) ? '00-00-000' : $DataNasc5;
$Validade5 = empty($Validade5) ? '00-00-000' : $Validade5;
$DataEmissao5 = empty($DataEmissao5) ? '00-00-000' : $DataEmissao5;
$DataRenovCAM5 = empty($DataRenovCAM5) ? '00-00-000' : $DataRenovCAM5;
$DataRenovADR5 = empty($DataRenovADR5) ? '00-00-000' : $DataRenovADR5;
$empresa = isset($_SESSION['empresa']) ? $_SESSION['empresa'] : 0;
$nao_envia_email = 0;
if( isset($_POST['NaoEnviaEmail']) )
	$nao_envia_email = $_POST['NaoEnviaEmail'];

$sql = "INSERT INTO formandos (empresa, NomeFormando, DataNasc, Morada, CodigoPostal, Email, Telemovel, CartaoCidadao, Validade, nCartaConducao, DataEmissao, NIF, DataRenovADR, DataRenovCAM)"
        . " VALUES ({$empresa},'$NomeFormando5', '$DataNasc5', '$Morada5', '$CodigoPostal5', '$Email5', '$Telemovel5', '$CartaoCidadao5',"
        . " '$Validade5', '$nCartaConducao5', '$DataEmissao5', '$NIF5', '$DataRenovADR5', '$DataRenovCAM5')";
if ($conn->query($sql) === TRUE) {
    $cliente = $conn->insert_id;
    if (!isset($_SESSION['empresa'])) {
        $_SESSION['cliente']['type'] = 'individual';
        $_SESSION['cliente']['nome'] = $NomeFormando5;
        $_SESSION['cliente']['email'] = $Email5;
        $_SESSION['cliente']['telemovel'] = $Telemovel5;
    } else {
        $_SESSION['cliente']['type'] = 'empresa';
        $sql = "SELECT * FROM empresa WHERE id = {$_SESSION['empresa']}";
        $retval = $conn->query($sql);
        if ($retval->num_rows > 0) {
            while ($row = $retval->fetch_row()) {
                $_SESSION['caret'][$_POST['curso']]['aluno']['id'][] = $cliente;
                $_SESSION['caret'][$_POST['curso']]['aluno']['nome'][] = $NomeFormando5;
                $_SESSION['caret'][$_POST['curso']]['aluno']['email'][] = $Email5;
                $_SESSION['cliente']['email'] = $row[7];
                $_SESSION['cliente']['nome'] = $row[1];
                $_SESSION['cliente']['telemovel'] = $row[8];
            }
        }
    }
    $subject = 'Sua inscrição';
    $email = filter_input(INPUT_POST, 'Email5', FILTER_SANITIZE_EMAIL);
    $name = filter_input(INPUT_POST, 'NomeFormando5', FILTER_SANITIZE_STRING);
    $message = "Olá, {$name}!<br><br> Sua inscrição foi realizada com sucesso!";

	if( !$nao_envia_email ) {
		$res = sendEmail($subject, $message, $email, $name);
		if ($res) {
			?>
			<div class="col-lg-12 text-center">
				<h3>Envio de email realizado com sucesso!</h3>
			</div>

		<?php } else { ?>
			<div class="col-lg-12 text-center">
				<h3>Não foi possivel realizar o envio do email.</h3>
			</div>
			<?php
		}
	}
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
header("Location: http://{$_SERVER['HTTP_HOST']}/inqdemo/index.php/compras");

