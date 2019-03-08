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
		<div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
		<article class="container-login center-block">
			<section>
				<div id="login-form" class="tab-content tabs-login col-lg-6 col-md-6 col-sm-6 cols-xs-6">
					<div id="login-access" class="tab-pane fade active in">	
						<p>
							<b>Member Login</b><br><br>
							Already registered?
						</p>
						<form id="form1" method="post" accept-charset="utf-8" autocomplete="off" role="form" class="form-horizontal">
							<div class="form-group ">
								<label for="email" class="sr-only">Email</label>
								<input type="text" class="form-control" name="email" id="email" placeholder="Email" tabindex="1" value="" />
								<input type="text" class="form-control hide" name="agent_id" id="agent_id" placeholder="AGENT ID" tabindex="1" value="" />
							</div>
							<div class="form-group ">
								<label for="password" class="sr-only">Password</label>
								<input type="password" class="form-control" name="password" id="password" placeholder="Password" value="" tabindex="2" />
							</div>
							<div class="form-group ">				
								<button id="btn-login" name="log-me-in" tabindex="3" class="btn btn-lg btn-primary">LOGIN</button>
								<button id="btn-login-private" name="" tabindex="4" class="btn btn-lg btn-primary hide">LOGIN PRIVATE</button>
							</div>
							<div class="form-group" id="btn-login-fb">	
								<button type="button" tabindex="5" class="btn btn-lg btn-primary">LOGIN WITH FACEBOOK</button>
							</div>
							<div class="form-group centered">	
								<a class="pull-right btn-private" href="#" style="color:#818080;font-size: 13px;text-transform: uppercase;">Private</a>
								<a class="pull-right btn-public hide" href="#" style="color:#818080;font-size: 13px;text-transform: uppercase;">Public</a>
							</div>
						</form>			
					</div>
				</div>
				<div id="register-form" class="tab-content tabs-login col-lg-6 col-md-6 col-sm-6 cols-xs-6">
					<div id="register-access" class="tab-pane fade active in">
						<p>
							<b>Still not our customer?</b><br><br>
							Register now and have access to the best prices.
						</p>
						<form id="form2" method="post" accept-charset="utf-8" autocomplete="off" role="form" class="form-horizontal">
							<div class="form-group ">
								<label for="login" class="sr-only">Email</label>
								<input type="text" class="form-control" name="reg-email" id="reg-email" placeholder="Email" tabindex="6" value="" />
							</div>
							<div class="form-group ">
								<label for="password" class="sr-only">Password</label>
									<input type="password" class="form-control" name="reg-password" id="reg-password" placeholder="Password" value="" tabindex="7" />
							</div>
							<div class="form-group ">
								<label for="password" class="sr-only">Confirm Password</label>
									<input type="password" class="form-control" name="reg-cpassword" id="reg-cpassword" placeholder="Confirm Password" value="" tabindex="8" />
							</div>
							<div class="form-group ">				
								<button name="register-me-in" id="btn-register" tabindex="9" class="btn btn-lg btn-primary">REGISTER NOW</button>
							</div>
						</form>			
					</div>
				</div>
			</section>
		</article>
	</div>
	<script>  
		jQuery(document).ready(function(){
			//jQuery('#login_form').validate(); //form validation
			
			jQuery(document).on('click','.btn-private',function(){
				jQuery("#btn-login-private").removeClass("hide");
				jQuery(".btn-private").addClass("hide");
				jQuery("#btn-login").addClass("hide");
				jQuery(".btn-public").removeClass("hide");
				jQuery("#agent_id").removeClass("hide");
				jQuery("#email").addClass("hide");
				jQuery("#btn-login-fb").addClass("hide");
				
				jQuery("#btn-login").attr("disabled", "disabled");
				
				jQuery("#agent_id").focus();
			});
			
			jQuery(document).on('click','.btn-public',function(){
				jQuery("#btn-login-private").addClass("hide");
				jQuery(".btn-private").removeClass("hide");
				jQuery("#btn-login").removeClass("hide");
				jQuery(".btn-public").addClass("hide");
				jQuery("#agent_id").addClass("hide");
				jQuery("#email").removeClass("hide");
				jQuery("#btn-login-fb").removeClass("hide");
				
				jQuery("#btn-login").removeAttr("disabled");
				
				jQuery("#email").focus();
			});
			
			jQuery(document).on('click','#btn-login-private',function(){
				var url = "<?php echo base_url(); ?>wl/<?php echo $op; ?>/log_in_private";
				//if(jQuery('#login_form').valid()){
					jQuery.ajax({
						type: "POST",
						url: url,
						data: jQuery("#form1").serialize(),
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
										"priority": 'error'
									}
									]);
								}
							}
						}
					});
				//}
				return false;
			});
			
			jQuery(document).on('click','#btn-login',function(){
				var url = "<?php echo base_url(); ?>wl/<?php echo $op; ?>/log_in";
				//if(jQuery('#login_form').valid()){
					jQuery.ajax({
						type: "POST",
						url: url,
						data: jQuery("#form1").serialize(),
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
										"priority": 'error'
									}
									]);
								}
							}
						}
					});
				//}
				return false;
			});
			
			jQuery(document).on('click','#btn-register',function(){
				var url = "<?php echo base_url(); ?>wl/<?php echo $op; ?>/register";  
				//if(jQuery('#login_form').valid()){
					jQuery.ajax({
						type: "POST",
						url: url,
						data: jQuery("#form2").serialize(),
						success: function(data)
						{
							
							console.log(data);
							
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
										"priority": 'error'
									}
									]);
								}
							}
						}
					});
				//}
				return false;
			});
			
			jQuery(document).on('click','#btn-register-fb',function(){
				window.location.href = "<?php echo $url_register_fb; ?>";
				return false;
			});
			
			jQuery(document).on('click','#btn-login-fb',function(){
				window.location.href = "<?php echo $url_login_fb; ?>";
				return false;
			});
		});
	</script>
</body>