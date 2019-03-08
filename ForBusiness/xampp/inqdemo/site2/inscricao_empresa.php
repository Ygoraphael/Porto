<html>
<head>

<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">

    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">
    <link href="css/number.css" rel="stylesheet">
    <link href="css/accor.css" rel="stylesheet">
    <link href="css/active2.css" rel="stylesheet">

        <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <script src="js/accor.js"></script>


<style>
label{display:inline-block;width:100px;margin-bottom:10px;}
</style>
 
 
<title>Empresa</title>
</head>
<body>


<div class="container">



<form method="post" action="insert_empresa.php" id="add_empresa">
<label>Nome</label>
<textarea form ="add_empresa" name="NomeEmpresa" id="NomeEmpresa" cols="35" rows="4" wrap="soft" required=""></textarea>
<br />
<label>NIF</label>
<textarea form ="add_empresa" name="NIF" id="NIF" cols="35" rows="4" wrap="soft" required=""></textarea>
<br />
<label>Morada</label>
<textarea form ="add_empresa" name="Morada" id="Morada" cols="35" rows="4" wrap="soft" required=""></textarea>
<br />
<label>Código Postal</label>
<textarea form ="add_empresa" name="CodigoPostal" id="CodigoPostal" cols="35" rows="4" wrap="soft" required=""></textarea>
<br />
<label>Localidade</label>
<textarea form ="add_empresa" name="Localidade" id="Localidade" cols="35" rows="4" wrap="soft" required=""></textarea>
<br />
<label>Email</label>
<textarea form ="add_empresa" name="Email" id="Email" cols="35" rows="4" wrap="soft" required=""></textarea>
<br />
<label>Telemovel</label>
<textarea form ="add_empresa" name="Telemovel" id="Telemovel" cols="35" rows="4" wrap="soft" required=""></textarea>
<br />
<label>Pessoa de Contacto</label>
<textarea form ="aadd_empresa" name="PessoaContacto" id="PessoaContacto" cols="35" rows="4" wrap="soft" required=""></textarea>

 
<br />
<input type="submit" value="Proceder">
</form>


					
</div>


</body>
</html>