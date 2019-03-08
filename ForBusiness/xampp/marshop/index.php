<!DOCTYPE html>
<html lang="pt">
<head>
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
	<?php 
		include("db2.php");
		if(!empty($_SESSION['user']))
		{
			header("Location: home.php");
			die("Redirecting to home.php");
		}
	?>
</head>

<body>
	<div class="container">
      <form action="login.php" method="post">
		<br>
			<center>
			<h2 class="form-signin-heading">Marshopping</h2><br>
				<input type="text" name="username" class="form-control span6" placeholder="UTILIZADOR" required="" autofocus="" value="<?php echo isset($submitted_username) ? $submitted_username : ''; ?>" /><br>
				<input type="password" name="password" value="" class="form-control span6" placeholder="SENHA" required="" /><br>
				<button class="btn btn-lg btn-primary btn-block" type="submit">ENTRAR</button>
			</center>
      </form>
    </div>
	<div class="clearfix"></div>
	
	<!-- start: JavaScript-->
	<?php include("footer_code.php"); ?>
	<!-- end: JavaScript-->
</body>
</html>
