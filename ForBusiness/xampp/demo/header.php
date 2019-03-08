<?php
	date_default_timezone_set('Europe/Lisbon');
	include("db.php");
	include("db2.php");
	include("funcoes_gerais_directo.php");
	
	if(empty($_SESSION['user']))
    {
        header("Location: index.php");
        die("Redirecting to index.php");
    }
?>

<!-- start: Meta -->
<meta charset="utf-8">
<title>Taskas - Novoscanais</title>
<meta name="description" content="Taskas - Novoscanais">
<meta name="author" content="Tiago Loureiro">
<!-- end: Meta -->

<!-- start: Mobile Specific -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- end: Mobile Specific -->

<!-- start: CSS -->
<link id="bootstrap-style" href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
<link id="base-style" href="css/style.css" rel="stylesheet">
<link id="base-style-responsive" href="css/style-responsive.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
<!-- end: CSS -->

<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<link id="ie-style" href="css/ie.css" rel="stylesheet">
<![endif]-->
<!--[if IE 9]>
	<link id="ie9style" href="css/ie9.css" rel="stylesheet">
<![endif]-->
<!-- start: Favicon -->
<link rel="shortcut icon" href="img/favicon.ico">
<script src="js/jquery-1.9.1.min.js"></script>
<!-- end: Favicon -->
<link id="base-style" href="css/loading.css" rel="stylesheet">
<script src="js/loading.js"></script>
<script src="js/validator.js"></script>
<script src="js/bootbox.js"></script>
<link href="css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="js/bootstrap-toggle.min.js"></script>
<script src="js/jquery.flot.js"></script>
<script src="js/jquery.flot.pie.js"></script>
<script src="js/jquery.flot.stack.js"></script>
<script src="js/jquery.flot.resize.min.js"></script>