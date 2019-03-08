<?php
include 'db_config.php';
$id_empresa = null;
if (isset($_POST['NomeEmpresa'])) {
    $_SESSION['caret'][$_SESSION['curso_corrente']['id']]['aluno'] = [];
    $NomeEmpresa = mysqli_real_escape_string($conn, $_POST['NomeEmpresa']);
    $PessoaContacto = mysqli_real_escape_string($conn, $_POST['PessoaContacto']);
    $Morada = mysqli_real_escape_string($conn, $_POST['Morada']);
    $CodigoPostal = mysqli_real_escape_string($conn, $_POST['CodigoPostal']);
    $Localidade = mysqli_real_escape_string($conn, $_POST['Localidade']);
    $Email = mysqli_real_escape_string($conn, $_POST['Email']);
    $Telemovel = mysqli_real_escape_string($conn, $_POST['Telemovel']);
    $sql = "INSERT INTO empresa (NomeEmpresa, PessoaContacto, Morada, CodigoPostal, Localidade, Email, Telemovel)
    VALUES ('$NomeEmpresa', '$PessoaContacto', '$Morada', '$CodigoPostal', '$Localidade', '$Email', '$Telemovel')";

    if ($conn->query($sql) === TRUE) {
        $id_empresa = $conn->insert_id;
        $_SESSION['empresa'] = $id_empresa;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
$curso_nome = $_SESSION['curso_corrente']['nome'];
if (!isset($_SESSION['type']) || ($_SESSION['type'] == 'empresa')) {
    ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="alternate" type="application/json+oembed" href="https://www.jotform.com/oembed/?format=json&amp;url=http%3A%2F%2Fwww.jotform.com%2Fform%2F11301836230" title="oEmbed Form"><link rel="alternate" type="text/xml+oembed" href="https://www.jotform.com/oembed/?format=xml&amp;url=http%3A%2F%2Fwww.jotform.com%2Fform%2F11301836230" title="oEmbed Form">
    <meta property="og:title" content="JotForm" >
    <meta property="og:url" content="http://www.www.jotform.com/form/11301836230" >
    <meta property="og:description" content="Please click the link to complete this form.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="HandheldFriendly" content="true" />
    <title>JotForm</title>
    <link href="https://cdn.jotfor.ms/static/formCss.css?3.3.392" rel="stylesheet" type="text/css" />
    <link type="text/css" media="print" rel="stylesheet" href="https://cdn.jotfor.ms/css/printForm.css?3.3.392" />
    <style type="text/css">
        .form-label-left{
            width:150px !important;
        }
        .form-line{
            padding-top:10px;
            padding-bottom:10px;
        }
        .form-label-right{
            width:150px !important;
        }
        body, html{
            margin:0;
            padding:0;
            background:false;
        }

        .form-all{
            margin:0px auto;
            padding-top:0px;
            width:677px;
            color:Black !important;
            font-family:'Verdana';
            font-size:12px;
        }
        .form-radio-item label, .form-checkbox-item label, .form-grading-label, .form-header{
            color: Black;
        }

    </style>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

    <script src="https://cdn.jotfor.ms/static/prototype.forms.js" type="text/javascript"></script>
    <script src="https://cdn.jotfor.ms/static/jotform.forms.js?3.3.392" type="text/javascript"></script>
    <script type="text/javascript">
        JotForm.setConditions([{"action":{"field":"12", "visibility":"Show"}, "link":"Any", "terms":[{"field":"16", "operator":"equals", "value":"Yes"}], "type":"field"}, {"action":{"field":"13", "visibility":"Show"}, "link":"Any", "terms":[{"field":"19", "operator":"equals", "value":"Yes"}], "type":"field"}, {"action":{"field":"14", "visibility":"Show"}, "link":"Any", "terms":[{"field":"18", "operator":"equals", "value":"Yes"}], "type":"field"}, {"action":{"field":"15", "visibility":"Show"}, "link":"Any", "terms":[{"field":"17", "operator":"equals", "value":"Yes"}], "type":"field"}, {"action":{"field":"19", "visibility":"Show"}, "link":"Any", "terms":[{"field":"16", "operator":"equals", "value":"Yes"}], "type":"field"}, {"action":{"field":"18", "visibility":"Show"}, "link":"Any", "terms":[{"field":"19", "operator":"equals", "value":"Yes"}], "type":"field"}, {"action":{"field":"17", "visibility":"Show"}, "link":"Any", "terms":[{"field":"18", "operator":"equals", "value":"Yes"}], "type":"field"}]);
        JotForm.init(function(){
        setTimeout(function() {
        $('input_8').hint('ex: myname@example.com');
        }, 20);
        });
        JotForm.prepareCalculationsOnTheFly([null, null, null, null, {"name":"Date_", "qid":"4", "text":"Date:", "type":"control_textbox"}, {"name":"Additional_Comments_", "qid":"5", "text":"Additional Comments:", "type":"control_textarea"}, {"name":"_nbsp_", "qid":"6", "text":"Submit", "type":"control_button"}, {"name":"fullName", "qid":"7", "text":"Full Name", "type":"control_fullname"}, {"name":"email8", "qid":"8", "text":"E-mail", "type":"control_email"}, {"name":"phone", "qid":"9", "text":"Phone", "type":"control_phone"}, {"name":"clickTo", "qid":"10", "text":"Reservation", "type":"control_head"}, null, {"name":"guest1", "qid":"12", "text":"Guest 1", "type":"control_fullname"}, {"name":"guest2", "qid":"13", "text":"Guest 2", "type":"control_fullname"}, {"name":"guest3", "qid":"14", "text":"Guest 3", "type":"control_fullname"}, {"name":"guest4", "qid":"15", "text":"Guest 4", "type":"control_fullname"}, {"name":"addA", "qid":"16", "text":"Add a guest?", "type":"control_radio"}, {"name":"addAnother17", "qid":"17", "text":"Add another guest?", "type":"control_radio"}, {"name":"addAnother18", "qid":"18", "text":"Add another guest?", "type":"control_radio"}, {"name":"addAnother", "qid":"19", "text":"Add another guest?", "type":"control_radio"}]);</script>

    <h3>Inscrição Individual</h3><small>preencha os dados abaixo</small>
    <form class="jotform-form" action="index.php?option=com_jumi&view=application&fileid=10" method="post" name="form_11301836230" id="11301836230" accept-charset="utf-8">
        <input type="hidden" name="formID" value="11301836230" />
        <input type="hidden" name="type" value="individual" />
        <input type="hidden" name="curso" value="<?php echo $_SESSION['curso_corrente']['id']; ?>" />
        <div class="form-all">
            <ul class="form-section page-section">
                <li class="form-line" data-type="control_fullname" id="id_7">
                    <label class="form-label form-label-left form-label-auto" id="label_7" for="input_7"> Nome Formando </label>
                    <div id="cid_7" class="form-input jf-required">
                        <div data-wrapper-react="true">
                            <span class="form-sub-label-container" style="vertical-align:top;">
                                <input type="text" id="last_7" required name="NomeFormando5" class="form-textbox" size="15" value="" data-component="last" style="width: 300px;"/>
                                <label class="form-sub-label" for="last_7" id="sublabel_last" style="min-height:13px;"> Nome Completo </label>
                            </span>
                        </div>
                    </div>
                </li>
                <li class="form-line" data-type="control_email" id="id_8">
                    <label class="form-label form-label-left form-label-auto" id="label_8"  for="input_8"> E-mail </label>
                    <div id="cid_8" class="form-input jf-required">
                        <input type="email" id="input_8" style="width: 300px;" name="Email5" class="form-textbox validate[Email]" size="20" value="" placeholder="ex: myname@example.com" data-component="email"required/>
                    </div>
                </li>
                <li class="form-line" data-type="control_phone" id="id_9">
                    <label class="form-label form-label-left form-label-auto"  id="label_9" for="input_9"> Telemovel </label>
                    <div id="cid_9" class="form-input jf-required">
                        <div data-wrapper-react="true">

                            <span class="form-sub-label-container" style="vertical-align:top;">
                                <input type="tel" id="input_9_phone" style="width: 300px;" name="Telemovel5" class="form-textbox" size="8" value="" data-component="phone" />
                                <label class="form-sub-label" for="input_9_phone" id="sublabel_phone" style="min-height:13px;"> nº telemovel </label>
                            </span>
                        </div>
                    </div>
                </li>
                <li class="form-line" data-type="control_textbox" id="id_4">
                    <label class="form-label form-label-left form-label-auto" id="label_4" for="input_4"> Data Nascimento: </label>
                    <div id="cid_4" class="form-input jf-required">
                        <input type="date" style="width: 300px;" id="input_4" name="DataNasc5" data-type="input-textbox" class="form-textbox" size="10" value="" placeholder=" " data-component="textbox" />
                    </div>
                </li>
                <li class="form-line" data-type="control_textbox" id="id_4">
                    <label class="form-label form-label-left form-label-auto" id="label_4" for="input_4"> Morada: </label>
                    <div id="cid_4" class="form-input jf-required">
                        <input type="text" style="width: 300px;" id="input_4" name="Morada5" data-type="input-textbox" class="form-textbox" size="10" value="" placeholder=" " data-component="textbox" />
                    </div>
                </li>
                <li class="form-line" data-type="control_textbox" id="id_4">
                    <label class="form-label form-label-left form-label-auto" id="label_4" for="input_4"> Código Postal: </label>
                    <div id="cid_4" class="form-input jf-required">
                        <input type="text" style="width: 300px;" id="input_4" name="CodigoPostal5" data-type="input-textbox" class="form-textbox" size="10" value="" placeholder=" " data-component="textbox" />
                    </div>
                </li>
                <li class="form-line" data-type="control_textbox" id="id_4">
                    <label class="form-label form-label-left form-label-auto" id="label_4" for="input_4"> Cartão de Cidadão: </label>
                    <div id="cid_4" class="form-input jf-required">
                        <input type="text" style="width: 300px;" id="input_4" name="CartaoCidadao5" data-type="input-textbox" class="form-textbox" size="10" value="" placeholder=" " data-component="textbox" />
                    </div>
                </li>
                <li class="form-line" data-type="control_textbox" id="id_4">
                    <label class="form-label form-label-left form-label-auto" id="label_4" for="input_4"> Validade Cartão de Cidadão: </label>
                    <div id="cid_4" class="form-input jf-required">
                        <input type="date" style="width: 300px;" id="input_4" name="Validade5" data-type="input-textbox" class="form-textbox" size="10" value="" placeholder=" " data-component="textbox" />
                    </div>
                </li>
                <li class="form-line" data-type="control_textbox" id="id_4">
                    <label class="form-label form-label-left form-label-auto" id="label_4" for="input_4"> Carta Condução: </label>
                    <div id="cid_4" class="form-input jf-required">
                        <input type="text" style="width: 300px;" id="input_4" name="nCartaConducao5" data-type="input-textbox" class="form-textbox" size="10" value="" placeholder=" " data-component="textbox" />
                    </div>
                </li>
                <li class="form-line" data-type="control_textbox" id="id_4">
                    <label class="form-label form-label-left form-label-auto" id="label_4" for="input_4"> Data Emissão Cartão de Cidadão: </label>
                    <div id="cid_4" class="form-input jf-required">
                        <input type="date" style="width: 300px;" id="input_4" name="DataEmissao5" data-type="input-textbox" class="form-textbox" size="10" value="" placeholder=" " data-component="textbox" />
                    </div>
                </li>
                <li class="form-line" data-type="control_textbox" id="id_4">
                    <label class="form-label form-label-left form-label-auto" id="label_4" for="input_4"> NIF: </label>
                    <div id="cid_4" class="form-input jf-required">
                        <input type="text" style="width: 300px;"id="input_4" name="NIF5" data-type="input-textbox" class="form-textbox" size="10" value="" placeholder=" " data-component="textbox" />
                    </div>
                </li>
                <li class="form-line" data-type="control_textbox" id="id_4">
                    <label class="form-label form-label-left form-label-auto" id="label_4" for="input_4"> Data Renovação ADR: </label>
                    <div id="cid_4" class="form-input jf-required">
                        <input type="date" style="width: 300px;" id="input_4" name="DataRenovADR5" data-type="input-textbox" class="form-textbox" size="10" value="" placeholder=" " data-component="textbox" />
                    </div>
                </li>
                <li class="form-line" data-type="control_textbox" id="id_4">
                    <label class="form-label form-label-left form-label-auto" id="label_4" for="input_4"> Data Renovação CAM: </label>
                    <div id="cid_4" class="form-input jf-required">
                        <input type="date" style="width: 300px;" id="input_4" name="DataRenovCAM5" data-type="input-textbox" class="form-textbox" size="10" value="" placeholder=" " data-component="textbox" />
                        <input type="hidden" name="empresa" value="<?= $id_empresa; ?>">
                        <input type="hidden" name="NaoEnviaEmail" value="1">
                    </div>
                </li>


                <?php
                $teste4 = $curso_nome;

                echo "Está a inscrever-se na ação";
                echo "   $teste4";
                ?>

                <br />
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
                <input type="hidden" name="name" value="<?php echo "$teste4"; ?>" />


                <li class="form-line" data-type="control_button" id="id_6">
                    <div id="cid_6" class="form-input-wide">
                        <div class="form-buttons-wrapper">
                            <button id="input_6" type="submit" class="form-submit-button btn btn-success" data-component="button">
                                Inscrever
                            </button>
                        </div>
                    </div>
                </li>
                <li style="display:none">
                    Should be Empty:
                    <input type="text" name="website" value="" />
                </li>


            </ul>
        </div>

        


        <input type="hidden" id="simple_spc" name="simple_spc" value="11301836230" />
		<input type="hidden" id="type" name="type" value="<?php echo $_POST['type']; ?>" />
        <script type="text/javascript">
            document.getElementById("si" + "mple" + "_spc").value = "11301836230-11301836230";
        </script>
        <?php
    } else {
        header("Location: http://{$_SERVER['HTTP_HOST']}/inqdemo/index.php/compras");
    }
    // if (isset($_POST['type'])) {
        // $_SESSION['type'] = $_POST['type'];
    // }