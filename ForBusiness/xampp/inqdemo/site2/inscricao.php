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
 
 
<title>Adicionar Curso</title>
</head>
<body>

<?php

$teste3=$_POST['name'];

echo "Está a inscrever-se na ação";
echo "   $teste3";

?>

<div class="container">

								<h3 class="headingTop text-center">Selecione a opção:</h3>

                                <td class="inscindiv">
                                    <form action='inscricao_individual2.php?name="<?php echo "$teste3"; ?>"' method="post">
                                        <input type="hidden" name="name" value="<?php echo "$teste3"; ?>">
                                        <input type="submit" name="submit" value="Inscrição Individual">
                                    </form>
                                </td>
                                <td class="inscempresa">
                                    <form action='inscricao_empresa.php?name="<?php echo "$teste3"; ?>"' method="post">
                                        <input type="hidden" name="name" value="<?php echo "$teste3"; ?>">
                                        <input type="submit" name="submit" value="Inscrição Empresa">
                                    </form>
                                </td>


								<a href="inscricao_individual.php">Individual</a>
								<a href="inscricao_empresa.php">Empresa</a></div>
								<div class="btn btn-success pull-left btn-fyi"><a href="curso_admin.php">Voltar</a> <span class="glyphicon glyphicon-chevron-left"></span></div>
								
					
</div>


</body>
</html>