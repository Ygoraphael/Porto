<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<?php $this->load->view('backoffice_header'); ?>
	<body>
	<div class="loading-overlay">
		<div class="spinner">
			<div class="bounce1"></div>
			<div class="bounce2"></div>
			<div class="bounce3"></div>
		</div>
	</div>
	<div class="am-wrapper">
		<nav class="navbar navbar-default navbar-fixed-top am-top-header">
			<?php $this->load->view('backoffice_menu_top'); ?>
		</nav>
		<div >
			<?php $this->load->view('backoffice_menu_left'); ?>
		</div>
		<div class="am-content">
			<?php
				echo $this->template->content;
			?>
		</div>
	</div>
	</body>
<?php $this->load->view('backoffice_footer'); ?>