<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if ( !isset( $user ) )
		return false;
?>
<div class="container-fluid">
	<div class="navbar-header">
		<div class="page-title"><span><?php echo $title; ?></span></div>
		<a href="#" class="fa fa-bars fa-2x toggle-btn bt_mobile" data-toggle="collapse" data-target="#menu-content">
			<span class="icon-bar">
				<span></span>
				<span></span>
				<span></span>
			</span>
		</a>
		<a href="<?php echo base_url(); ?>backoffice" class="navbar-brand"></a>
	</div>
	<div id="am-navbar-collapse" class="collapse navbar-collapse pull-right">
		<ul class="nav navbar-nav am-nav-right">
			<li><a href="#"><?php echo $this->translation->Translation_key("WELCOME", $_SESSION['lang_u']); ?> <b><?php echo strtoupper($user["nome"]); ?></b>!</a></li>
		</ul>
	</div>
</div>