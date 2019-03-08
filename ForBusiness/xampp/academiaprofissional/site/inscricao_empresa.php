<?php
include 'db_config.php';
if (!isset($_SESSION['empresa'])) { ?>
    <div class="container">
        <h3>Inscrição Empresa</h3><small style="margin-bottom:15px">preencha os dados da empresa abaixo</small>
        <form method="post" action="<?= JURI::base(); ?>index.php/inserir-formando" id="add_empresa">
            <h6>Nome:</h6>
            <input name="NomeEmpresa" id="NomeEmpresa" class="span12" type="text" wrap="soft" required="">
            <br/><br/>
            <h6>NIF:</h6>
            <input type="text" name="NIF" id="NIF" class="span12" wrap="soft" required="">
            <br/><br/>
            <h6>Morada:</h6>
            <input type="text" name="Morada" id="Morada" class="span12" wrap="soft" required="">
            <br/><br/>
            <h6>Código Postal:</h6>
            <input type="text" name="CodigoPostal" id="CodigoPostal" class="span12" wrap="soft" required="">
            <br/><br/>
            <h6>Localidade:</h6>
            <input type="text" name="Localidade" id="Localidade" class="span12" wrap="soft" required="">
            <br/><br/>
            <h6>Email:</h6>
            <input type="text" name="Email" id="Email" class="span12" wrap="soft" required="">
            <br/><br/>
            <h6>Telemóvel:</h6>
            <input type="text" name="Telemovel" id="Telemovel" class="span12" wrap="soft" required="">
            <br/><br/>
            <h6>Pessoa de Contacto:</h6>
            <input type="text" name="PessoaContacto" class="span12" id="PessoaContacto" wrap="soft" required="">
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
                <br/>
            </div>
            <input type="submit" value="Inscrever">
            <input type="button" value="Cancelar" onclick="window.location.href = '<?= JURI::base(); ?>index.php'"/>
            
            <input type="hidden" name="type" value="empresa" />
            <input type="hidden" name="curso" value="<?php echo $_SESSION['curso_corrente']['id']; ?>" />
            <input type="hidden" name="name" value="<?php echo $_SESSION['curso_corrente']['nome']; ?>" />
        </form>
    </div>

    <?php
} else {

    $empresa = $_SESSION['empresa'];
    ?>
    <div class="container">
        <div class="span12 text-center">
            <br>
            <button class="btn" id="new_emp">NOVA EMPRESA</button>
            <a class="btn btn-success" href="<?= JURI::base(); ?>index.php/inserir-formando">CONTINUAR COMO <?= strtoupper($empresa); ?></a>
        </div>
    </div>
    <?php
} 