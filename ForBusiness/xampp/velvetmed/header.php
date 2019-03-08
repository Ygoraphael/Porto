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
<link id="bootstrap-style" href="css/bootstrap.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="css/bootstrap-responsive.css" rel="stylesheet">
<link id="base-style" href="css/style.css" rel="stylesheet">
<link id="base-style" href="css/calendario.css" rel="stylesheet">
<link id="base-style-responsive" href="css/style-responsive.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
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
<script src="js/signature_pad.js"></script>
<script src="js/remodal.js"></script>
<script type="text/javascript" src="js/sticky-header.js"></script>
<script type="text/javascript" src="js/jquery.jqplot.min.js"></script>
<script class="include" type="text/javascript" src="plugins/jqplot.meterGaugeRenderer.js"></script>
<link id="base-style" href="css/loading.css" rel="stylesheet">
<link id="base-style" href="css/font-awesome.min.css" rel="stylesheet">
<link id="base-style" href="css/remodal.css" rel="stylesheet">
<link id="base-style" href="css/remodal-default-theme.css" rel="stylesheet">
<link id="base-style" href="css/jquery.jqplot.min.css" rel="stylesheet">


