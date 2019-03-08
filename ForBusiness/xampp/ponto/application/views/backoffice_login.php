<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<body>
	<style>
		.container-login {
			min-height: 0;
			color: #333333;
			padding: 0;
		}
		.center-block {
		}
		.container-login > section {
			margin-left: 0;
			margin-right: 0;
			padding-bottom: 10px;
		}
		#top-bar {
			display: inherit;
		}
		.nav-tabs.nav-justified {
			border-bottom: 0 none;
			width: 100%;
		}
		.nav-tabs.nav-justified > li {
			display: table-cell;
			width: 1%;
			float: none;
		}
		.container-login .nav-tabs.nav-justified > li > a,
		.container-login .nav-tabs.nav-justified > li > a:hover,
		.container-login .nav-tabs.nav-justified > li > a:focus {
			background: #ea533f;
			border: medium none;
			color: #ffffff;
			margin-bottom: 0;
			margin-right: 0;
			border-radius: 0;
		}
		.container-login .nav-tabs.nav-justified > .active > a,
		.container-login .nav-tabs.nav-justified > .active > a:hover,
		.container-login .nav-tabs.nav-justified > .active > a:focus {
			background: #ffffff;
			color: #333333;
		}
		.container-login .nav-tabs.nav-justified > li > a:hover,
		.container-login .nav-tabs.nav-justified > li > a:focus {
			background: #de2f18;
		}
		.tabs-login {
			border: medium none;
			margin-top: -1px;
			padding: 10px 30px;
		}
		.container-login h2 {
			color: #ea533f;
		}
		.form-control {
			background-color: #ffffff;
			background-image: none;
			border: 1px solid #999999;
			border-radius: 0;
			box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
			color: #333333;
			display: block;
			font-size: 14px;
			height: 34px;
			line-height: 1.42857;
			padding: 6px 12px;
			transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
			width: 100%;
		}
		.container-login .checkbox {
			margin-top: -15px;
		}
		.container-login button {
			background-color: #428bca;
			border-color: #357ebd;
			color: #ffffff;
			border-radius: 0;
			font-size: 18px;
			line-height: 1.33;
			padding: 10px 16px;
			width: 100%;
		}
	</style>

	<div class="login-body">
		<div class="container">
			<div data-alerts="alerts" data-titles='{"warning": "<em>Warning!</em>", "error": "<em>Error!</em>"}' data-ids="myid" data-fade="3000"></div>
			<article class="container-login center-block">
				<section>
					<div id="login-form" class="tab-content tabs-login col-lg-12 col-md-12 col-sm-12 cols-xs-12">
						<div id="login-access" class="tab-pane fade active in">	
							<p class="text-center" style="color:#fff;">
								<b>Backoffice Login</b>
							</p>
							<form id="form1" method="post" accept-charset="utf-8" autocomplete="off" role="form" class="form-horizontal">
								<div class="form-group ">
									<label for="no" class="sr-only">Company</label>
									<input type="text" class="form-control" name="no" id="no" placeholder="Company" tabindex="1" value="" />
								</div>
								<div class="form-group ">
									<label for="no" class="sr-only">ID</label>
									<input type="text" class="form-control" name="estab" id="estab" placeholder="ID" tabindex="1" value="" />
								</div>
								<div class="form-group ">
									<label for="password" class="sr-only">Password</label>
									<input type="password" class="form-control" name="password" id="password" placeholder="Password" value="" tabindex="2" />
								</div>
								<div class="form-group ">				
									<button id="btn-login" name="log-me-in" tabindex="5" class="btn btn-lg btn-primary">LOGIN</button>
								</div>
							</form>			
						</div>
					</div>
				</section>
			</article>
		</div>
	</div>
	<script>  
		jQuery(document).ready(function(){
			//jQuery('#login_form').validate(); //form validation
			
			jQuery(document).on('click','#btn-login',function(){
				var url = "<?php echo base_url(); ?>backoffice_login/login";
				//if(jQuery('#login_form').valid()){
					jQuery.ajax({
						type: "POST",
						url: url,
						data: jQuery("#form1").serialize()<?php //echo $postRed; ?><?php //echo $postDt; ?>,
						success: function(data)
						{
							var objData = jQuery.parseJSON(data);
							
							if( objData.success ) {
								if( objData.redirect_page_success != '' ) {
									window.location.href = objData.redirect_page_success;
								}
								else {
									window.location.href = "";
								}
							}
							else {
								if( objData.redirect_page_error != '' ) {
									window.location.href = objData.redirect_page_error;
								}
								else {
									jQuery(document).trigger("add-alerts", [
									{
										"message": objData.error,
										"priority": 'warning'
									}
									]);
								}
							}
						}
					});
				//}
				return false;
			});
		});
	</script>
</body>