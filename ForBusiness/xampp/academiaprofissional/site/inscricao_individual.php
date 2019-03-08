<?php
include 'db_config.php';

$curso_nome = $_SESSION['curso_corrente']['nome'];

if (!isset($_SESSION['type']) || ($_SESSION['type'] == 'individual')) {
    ?>
    <h3>Inscrição Individual</h3>
    <small>Está a inscrever-se na ação <?php echo $curso_nome; ?></small><br>
    <small>preencha os dados abaixo</small><br><br> 
    <form class="jotform-form" action="<?= JURI::base(); ?>index.php/finalizar-inscricao" method="post" accept-charset="utf-8">
        <h6>Nome (campo obrigatório):</h6>
        <input name="NomeFormando" id="NomeEmpresa" class="span12" type="text" wrap="soft" required="">
        <br/><br/>
        <h6>NIF (campo obrigatório):</h6>
        <input type="text" name="NIF" class="span12" id="PessoaContacto" wrap="soft" required="">
        <br><br>
        <h6>Email (campo obrigatório):</h6>
        <input type="text" name="Email" id="NIF" class="span12" wrap="soft" required="">
        <br/><br/>
        <h6>Telemóvel (campo obrigatório):</h6>
        <input type="text" name="Telemovel" id="Morada" class="span12" wrap="soft" required="">
        <br/><br/>
        <h6>Data nascimento:</h6>
        <input type="date" name="DataNasc" id="CodigoPostal" class="span12" wrap="soft" >
        <br/><br/>
		<h6>Escolaridade:</h6>
		<select name="escolaridade" id="escolaridade" class="span12" wrap="soft">
			<option value=""></option>
			<option value="4º Ano">4º Ano</option>
			<option value="6º Ano">6º Ano</option>
			<option value="9º Ano">9º Ano</option>
			<option value="Secundário">Secundário</option>
			<option value="Bacharelado">Bacharelado</option>
			<option value="Licenciatura">Licenciatura</option>
			<option value="Mestrado">Mestrado</option>
		</select>
        <br/><br/>
        <h6>Morada:</h6>
        <input type="text" name="Morada" id="Localidade" class="span12" wrap="soft">
        <br/><br/>
        <h6>Código postal:</h6>
        <input type="text" name="CodigoPostal" id="Email" class="span12" wrap="soft" >
        <br/><br/>
        <h6>Cartão cidadão:</h6>
        <input type="text" name="CartaoCidadao" id="Telemovel" class="span12" wrap="soft" >
        <br/><br/>
        <h6>Validade cartão cidadão:</h6>
        <input type="date" name="Validade" class="span12" id="PessoaContacto" wrap="soft" >
        <br><br>
        <h6>Nº carta condução:</h6>
        <input type="text" name="nCartaConducao" class="span12" id="PessoaContacto" wrap="soft" >
        <br><br>
        <h6>Data emissão carta condução:</h6>
        <input type="date" name="DataEmissao" class="span12" id="PessoaContacto" wrap="soft" >
        <br><br>
        <h6>Data renovação ADR:</h6>
        <input type="date" name="DataRenovADR" class="span12" id="PessoaContacto" wrap="soft" >
        <br><br>
        <h6>Data Renovação CAM:</h6>
        <input type="date" name="DataRenovCAM" class="span12" id="PessoaContacto" wrap="soft" >
        <br><br>
        <div id="CaptchaDiv"></div>
        <div class="capbox-inner">
            Indique o número abaixo:<br>
            <input type="hidden" id="txtCaptcha">
            <input type="text" name="CaptchaInput" id="CaptchaInput" size="15"><br>
            <script type="text/javascript">
                // Captcha Script
                function checkform(theform) {
                    var why = "";

                    if (theform.CaptchaInput.value == "") {
                        why += "- Please Enter CAPTCHA Code.\n";
                    }
                    if (theform.CaptchaInput.value != "") {
                        if (ValidCaptcha(theform.CaptchaInput.value) == false) {
                            why += "- The CAPTCHA Code Does Not Match.\n";
                        }
                    }
                    if (why != "") {
                        alert(why);
                        return false;
                    }
                }

                var a = Math.ceil(Math.random() * 9) + '';
                var b = Math.ceil(Math.random() * 9) + '';
                var c = Math.ceil(Math.random() * 9) + '';
                var d = Math.ceil(Math.random() * 9) + '';
                var e = Math.ceil(Math.random() * 9) + '';

                var code = a + b + c + d + e;
                document.getElementById("txtCaptcha").value = code;
                document.getElementById("CaptchaDiv").innerHTML = code;

                // Validate input against the generated number
                function ValidCaptcha() {
                    var str1 = removeSpaces(document.getElementById('txtCaptcha').value);
                    var str2 = removeSpaces(document.getElementById('CaptchaInput').value);
                    if (str1 == str2) {
                        return true;
                    } else {
                        return false;
                    }
                }

                // Remove the spaces from the entered and generated code
                function removeSpaces(string) {
                    return string.split(' ').join('');
                }
            </script>
        </div>
        <br/>
        <input type="submit" value="Inscrever">
        <input type="button" value="Cancelar" onclick="window.location.href = '<?= JURI::base(); ?>index.php'"/>
        
        <input type="hidden" name="type" value="individual" />
        <input type="hidden" name="curso" value="<?php echo $_SESSION['curso_corrente']['id']; ?>" />
        <input type="hidden" name="name" value="<?php echo $_SESSION['curso_corrente']['nome']; ?>" />
    </form>
    <?php
} else {
    header("Location: " . JURI::base() . "index.php/compras");
}
  // if (isset($_POST['type'])) {
    // $_SESSION['type'] = $_POST['type'];
  // }