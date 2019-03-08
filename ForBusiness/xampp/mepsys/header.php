<?php
date_default_timezone_set('Europe/Lisbon');
include("config.php");
include("db.php");
include("db2.php");
include("funcoes_gerais_directo.php");

if (empty($_SESSION['user'])) {
    if (strpos($_SERVER['SCRIPT_NAME'], 'index.php') == false) {
        header("Location: index.php");
        die("Redirecting to index.php");
    }
}
?>

<!-- start: Meta -->
<meta charset="utf-8">
<title><?php echo $glob_NomeApp; ?> - <?php echo $glob_NomeEmp; ?></title>
<meta name="description" content="<?php echo $glob_NomeApp; ?> - <?php echo $glob_NomeEmp; ?>">
<meta name="author" content="Tiago Loureiro - Novoscanais">
<!-- end: Meta -->

<!-- start: Mobile Specific -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- end: Mobile Specific -->

<!-- start: CSS -->
<link id="bootstrap-style" href="css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="css/bootstrap-responsive.css" rel="stylesheet">
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
<script src="http://code.jquery.com/jquery-1.12.3.js"></script>
<!-- end: Favicon -->
<link id="base-style" href="css/loading.css" rel="stylesheet">
<script src="js/loading.js"></script>
<script src="js/validator.js"></script>
<link href="css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="js/bootstrap-toggle.min.js"></script>
<script src="js/jquery.flot.js"></script>
<script src="js/jquery.flot.pie.js"></script>
<script src="js/jquery.flot.stack.js"></script>
<script src="js/jquery.flot.resize.min.js"></script>
<script src="js/bootbox.js"></script>
<script src="js/main.js"></script>
<link id="base-style" href="css/loading.css" rel="stylesheet">
<link id="base-style" href="css/font-awesome.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>

