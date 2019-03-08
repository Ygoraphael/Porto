<div class="navbar">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="index.php"><span><?php echo $glob_NomeApp; ?></span></a>	
			<!-- start: Header Menu -->
			<div class="nav-no-collapse header-nav">
				<ul class="nav pull-right">
					<li class="dropdown hidden-phone">
						<?php include("user_notifications.php"); ?>
					</li>
					<!-- start: Message Dropdown -->
					<li class="dropdown hidden-phone">
						<?php include("user_messages.php"); ?>
					</li>
					<!-- start: User Dropdown -->
					<?php include("user_panel.php"); ?>
					<!-- end: User Dropdown -->
				</ul>
			</div>
			<!-- end: Header Menu -->
		</div>
	</div>
</div>