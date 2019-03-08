
<?php
if (!isset($_SESSION['empresa'])) {
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        html, body, h1, h2, h3, h4, h5, h6 {
            font-family: "Roboto", sans-serif
        }
    </style>
    <style>
        html, body, h1, h2, h3, h4, h5, h6 {
            font-family: "Roboto", sans-serif
        }
        input[type="text"]{
            width: 100%;
        }
        .capbox {
            background-color: #92D433;
            border: #B3E272 0px solid;
            border-width: 0px 12px 0px 0px;
            display: inline-block;
            *display: inline;
            zoom: 1; /* FOR IE7-8 */
            padding: 8px 40px 8px 8px;
        }

        .capbox-inner {
            font: bold 11px arial, sans-serif;
            color: #000000;
            background-color: #DBF3BA;
            margin: 5px auto 0px auto;
            padding: 3px;
            -moz-border-radius: 4px;
            -webkit-border-radius: 4px;
            border-radius: 4px;
        }

        #CaptchaDiv {
            font: bold 17px verdana, arial, sans-serif;
            font-style: italic;
            color: #000000;
            background-color: #FFFFFF;
            padding: 4px;
            -moz-border-radius: 4px;
            -webkit-border-radius: 4px;
            border-radius: 4px;
        }

        #CaptchaInput {
            margin: 1px 0px 1px 0px;
            width: 135px;
        }

    </style>
    <?php
    if (isset($_POST['type'])) {
        $_SESSION['type'] = $_POST['type'];
    }
    ?>
    <div class="w3-main">
        <div class="w3-twothird w3-container">
            <div class="form-style-8">
                <div class="container">

                    <form method="post" action="/inqdemo/index.php/inserir-formando" id="add_empresa">
                        <h6>Nome:</h6>
                        <input form="add_empresa" name="NomeEmpresa" id="NomeEmpresa" rows="4" type="text" wrap="soft"
                               required="">
                        <br/>
                        <h6>NIF:</h6>
                        <input type ="text" form="add_empresa" name="NIF" id="NIF" cols="35" rows="4" wrap="soft"
                               required="">
                        <br/>
                        <h6>Morada:</h6>
                        <input type ="text" form="add_empresa" name="Morada" id="Morada" cols="35" rows="4" wrap="soft"
                               required="">
                        <br/>
                        <h6>Código Postal:</h6>
                        <input type ="text" form="add_empresa" name="CodigoPostal" id="CodigoPostal" cols="35" rows="4"
                               wrap="soft" required="">
                        <br/>
                        <h6>Localidade:</h6>
                        <input type ="text" form="add_empresa" name="Localidade" id="Localidade" cols="35" rows="4" wrap="soft"
                               required="">
                        <br/>
                        <h6>Email:</h6>
                        <input type ="text" form="add_empresa" name="Email" id="Email" cols="35" rows="4" wrap="soft"
                               required="">
                        <br/>
                        <h6>Telemovel:</h6>
                        <input type ="text" form="add_empresa" name="Telemovel" id="Telemovel" cols="35" rows="4" wrap="soft"
                               required="">
                        <br/>
                        <h6>Pessoa de Contacto:</h6>
                        <input type ="text" form="add_empresa" name="PessoaContacto" id="PessoaContacto" wrap="soft" required="">
                        <br><br>
                        <div id="CaptchaDiv"></div>

                        <div class="capbox-inner">
                            Type the above number:<br>

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
                            <input type="submit" value="Proceder">
                            <input type="button" value="Cancelar" onclick="window.location.href = '/inqdemo/index.php'"/>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {

    include 'db_config.php';

    $conn = mysql_connect($servername, $username, $password);

    if (!$conn) {
        die('Could not connect: ' . mysql_error());
    }
    $teste2 = $_POST['name'];

    $sql = "SELECT * FROM empresa WHERE id = '{$_SESSION['empresa']}'";
    mysql_select_db('acadprof_inqdemo');
    $retval = mysql_query($sql, $conn);

    if (!$retval) {
        die('Could not get data: ' . mysql_error());
    }

    while ($row = mysql_fetch_assoc($retval)) {
        $empresa = $row['NomeEmpresa'];
    }

    mysql_close($conn);
    ?>
    <div class="container">
        <div class="span12 text-center">
            <br>
            <button class="btn" id="new_emp">NOVA EMPRESA</button>
            <a class="btn btn-success" href="/inqdemo/index.php/inserir-formando">CONTINUAR COMO <?= strtoupper($empresa); ?></a>
        </div>
    </div>
    <?php
} 