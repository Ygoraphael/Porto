<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<?php $this->load->view('admin/header_admin'); ?>
<body>
<div class="am-wrapper am-login">
	<div class="am-content">
	<div class="main-content">
	  <div class="login-container">
		<div class="panel panel-default">
		  <div class="panel-heading"><img  alt="logo" width="150px" height="39px" class="logo-img"><span>Please enter your user information.</span></div>
		  <div class="panel-body">
			<form action="index.php" method="get" class="form-horizontal">
			  <div class="login-form">
				<div class="form-group">
				  <div class="input-group"><span class="input-group-addon"><i class="icon s7-user"></i></span>
					<input id="username" type="text" placeholder="Username" autocomplete="off" class="form-control">
				  </div>
				</div>
				<div class="form-group">
				  <div class="input-group"><span class="input-group-addon"><i class="icon s7-lock"></i></span>
					<input id="password" type="password" placeholder="Password" class="form-control">
				  </div>
				</div>
				<div class="form-group login-submit">
                      <button  type="submit" class="btn btn-primary btn-lg">Log me in</button>
                </div>

			  </div>
			</form>
		  </div>
		</div>
	  </div>
	</div>
	</div>
	</div>
</body>
<?php $this->load->view('admin/footer_admin'); ?>