<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<?php if ( !isset( $user ) )
		return false;

	$cur_url = $this->uri->segment(1).'/'.$this->uri->segment(2); 
?>

<div class="am-logo"></div>
	<div class="nav-side-menu">
		<div class="menu-list">
			<ul id="menu-content" class="menu-content collapse out">
				<li  class="<?php echo( $cur_url == "backoffice/")? "active" : "";?>"><a href="<?php echo base_url(); ?>backoffice"><i class="icon s7-monitor"></i><span><?php echo $this->translation->Translation_key("DASHBOARD", $_SESSION['lang_u']); ?></span></a></li>
				<?php if( $user["u_operador"] == 'Sim' ) { ?>
				<li class="<?php echo( $cur_url == "backoffice/products" || $cur_url == "backoffice/extras" || $cur_url == "backoffice/vouchers" || $cur_url == "backoffice/pickups" || $cur_url == "backoffice/lastminute")? "active" : "";?>" data-toggle="collapse" data-target="#products"><a href="#"><i class="icon s7-science"></i><span><?php echo $this->translation->Translation_key("MY PRODUCTS", $_SESSION['lang_u']); ?></span><span class="arrow"></span></a>
				</li>
				<ul class="sub-menu collapse" id="products">
					<li><a href="<?php echo base_url(); ?>backoffice/products"><?php echo $this->translation->Translation_key("PRODUCTS", $_SESSION['lang_u']); ?></a></li>
					<li><a href="<?php echo base_url(); ?>backoffice/extras"><?php echo $this->translation->Translation_key("EXTRAS/RESOURCES", $_SESSION['lang_u']); ?></a></li>
					<li><a href="<?php echo base_url(); ?>backoffice/vouchers"><?php echo $this->translation->Translation_key("VOUCHERS", $_SESSION['lang_u']); ?></a></li>
					<li><a href="<?php echo base_url(); ?>backoffice/pickups"><?php echo $this->translation->Translation_key("PICKUPS", $_SESSION['lang_u']); ?></a></li>
					<li><a href="<?php echo base_url(); ?>backoffice/lastminute"><?php echo $this->translation->Translation_key("PRODUCT ORDER / LAST MINUTE", $_SESSION['lang_u']); ?> </a></li>
				</ul>
				
			<?php } ?>
			<?php if( $user["u_operador"] == 'Sim' ) { ?>
			<li class="<?php echo( $cur_url == "backoffice/orders")? "active" : "";?>"><a href="<?php echo base_url(); ?>backoffice/orders"><i class="icon s7-note2"></i><span><?php echo $this->translation->Translation_key("ORDERS", $_SESSION['lang_u']); ?></span></a></li>
			<?php } ?>
			<?php if( $user["u_agente"] == 'Sim' && $user["u_operador"] == 'Não' ) { ?>
			<li class="<?php echo( $cur_url == "backoffice/orders")? "active" : "";?>"><a href="<?php echo base_url(); ?>backoffice/agent_orders"><i class="icon s7-note2"></i><span><?php echo $this->translation->Translation_key("ORDERS", $_SESSION['lang_u']); ?></span></a></li>
			<?php } ?>
			<?php if( $user["u_operador"] == 'Sim' ) { ?>
			<li class="<?php echo( $cur_url == "backoffice/customers")? "active" : "";?>"><a href="<?php echo base_url(); ?>backoffice/customers"><i class="icon s7-users"></i><span><?php echo $this->translation->Translation_key("CUSTOMERS", $_SESSION['lang_u']); ?></span></a></li>
			<?php } ?>
			<?php if( $user["u_operador"] == 'Sim' ) { ?>
			<li class="<?php echo( $cur_url == "backoffice/agents")? "active" : "";?>"><a href="<?php echo base_url(); ?>backoffice/agents"><i class="icon s7-id"></i><span><?php echo $this->translation->Translation_key("AGENTS", $_SESSION['lang_u']); ?></span></a></li>
			<?php } ?>
			<?php if( $user["u_operador"] == 'Sim' ) { ?>
			<li class="<?php echo( $cur_url == "backoffice/calendar")? "active" : "";?>"><a href="<?php echo base_url(); ?>backoffice/calendar"><i class="icon s7-date"></i><span><?php echo $this->translation->Translation_key("CALENDAR", $_SESSION['lang_u']); ?></span></a></li>
			<?php } ?>
			<?php if($user["u_agente"] == 'Sim' and $user["u_operador"] == 'Não'  ) { ?>
			<li class="<?php echo( $cur_url == "backoffice/rep_fees" || $cur_url == "backoffice/rep_orders" )? "active" : "";?>" data-toggle="collapse" data-target="#reports"><a href="#"><i class="icon s7-graph3"></i><span><?php echo $this->translation->Translation_key("REPORTS", $_SESSION['lang_u']); ?></span><span class="arrow"></span></a>
			</li>
			<ul class="sub-menu collapse" id="reports">
				<li><a href="<?php echo base_url(); ?>backoffice/rep_agent_fees"><?php echo $this->translation->Translation_key("MY FEES", $_SESSION['lang_u']); ?></a></li>
				<li><a href="<?php echo base_url(); ?>backoffice/rep_agent_orders"><?php echo $this->translation->Translation_key("SALES ORDERS", $_SESSION['lang_u']); ?></a></li>
				<li><a href="<?php echo base_url(); ?>backoffice/rep_agent_treasury"><?php echo $this->translation->Translation_key("TREASURY", $_SESSION['lang_u']); ?></a></li>
			</ul>
			
			<li class="<?php echo( $cur_url == "backoffice/white_label")? "active" : "";?>"><a href="<?php echo base_url(); ?>backoffice/agent_reimbursement"><i class="icon s7-news-paper"></i><span><?php echo $this->translation->Translation_key("REIMBURSEMENT", $_SESSION['lang_u']); ?></span></a></li>
			<li class="<?php echo( $cur_url == "backoffice/white_label")? "active" : "";?>"><a href="<?php echo base_url(); ?>backoffice/fee_receipts"><i class="icon s7-news-paper"></i><span><?php echo $this->translation->Translation_key("FEE RECEIPTS", $_SESSION['lang_u']); ?></span></a></li>
			<?php 
				}
				else{
						if($user["u_operador"] == 'Sim' ) { ?>
			<li class="<?php echo( $cur_url == "backoffice/rep_fees" || $cur_url == "backoffice/rep_orders" )? "active" : "";?>" data-toggle="collapse" data-target="#reports"><a href="#"><i class="icon s7-graph3"></i><span><?php echo $this->translation->Translation_key("REPORTS", $_SESSION['lang_u']); ?></span><span class="arrow"></span></a>
			</li>
			<ul class="sub-menu collapse" id="reports">
				<li><a href="<?php echo base_url(); ?>backoffice/rep_fees"><?php echo $this->translation->Translation_key("MY FEES", $_SESSION['lang_u']); ?></a></li>
				<li><a href="<?php echo base_url(); ?>backoffice/rep_pickups"><?php echo $this->translation->Translation_key("PICKUPS", $_SESSION['lang_u']); ?></a></li>
				<li><a href="<?php echo base_url(); ?>backoffice/rep_reimbursement"><?php echo $this->translation->Translation_key("REIMBURSEMENTS", $_SESSION['lang_u']); ?></a></li>
				<li><a href="<?php echo base_url(); ?>backoffice/rep_orders"><?php echo $this->translation->Translation_key("SALES ORDERS", $_SESSION['lang_u']); ?></a></li>
				<li><a href="<?php echo base_url(); ?>backoffice/rep_treasury"><?php echo $this->translation->Translation_key("TREASURY", $_SESSION['lang_u']); ?></a></li>
			</ul>
			<?php }}?>
			<?php if( $user["u_operador"] == 'Sim' ) { ?>
			<li class="<?php echo( $cur_url == "backoffice/white_label")? "active" : "";?>"><a href="<?php echo base_url(); ?>backoffice/white_label"><i class="icon s7-network"></i><span><?php echo $this->translation->Translation_key("WHITE LABEL", $_SESSION['lang_u']); ?></span></a></li>
			<?php } ?>
			<?php if( $user["u_operador"] == 'Sim' ) { ?>
			<li class="<?php echo( $cur_url == "backoffice/integration")? "active" : "";?>" class="parent" data-toggle="collapse" data-target="#INTEGRATION"><a href="#"><i class="icon s7-share"></i><span><?php echo $this->translation->Translation_key("INTEGRATION", $_SESSION['lang_u']); ?></span><span class="arrow"></span></a>
			</li>
			<ul class="sub-menu collapse" id="INTEGRATION">
				<li><a href="#"><?php echo $this->translation->Translation_key("WEBSITE", $_SESSION['lang_u']); ?></a></li>
				<li><a href="#"><?php echo $this->translation->Translation_key("APPS", $_SESSION['lang_u']); ?></a></li>
				<li><a href="#"><?php echo $this->translation->Translation_key("PAYMENT GATEWAYS", $_SESSION['lang_u']); ?></a></li>
			</ul>
			<?php } ?>
			<?php if( $user["u_agente"] == 'Sim' or $user["u_operador"] == 'Sim' ) { ?>
			<li class="<?php echo( $cur_url == "backoffice/settings_profile" ||  $cur_url == "backoffice/settings_online-payment" ||  $cur_url == "backoffice/settings_regional" ||  $cur_url == "backoffice/settings_billing" || $cur_url == "backoffice/settings_users" ||  $cur_url == "backoffice/settings_taxes" || $cur_url == "backoffice/settings_logs")? "active" : "";?>"data-toggle="collapse" data-target="#SETTINGS"><a href="#"><i class="icon s7-config"></i><span><?php echo $this->translation->Translation_key("SETTINGS", $_SESSION['lang_u']); ?></span><span class="arrow"></span></a>
			</li>
			<ul class="sub-menu collapse" id="SETTINGS">
				<li><a href="<?php echo base_url(); ?>backoffice/settings_profile"><?php echo $this->translation->Translation_key("PROFILE", $_SESSION['lang_u']); ?></a></li>
				<li><a href="#"><?php echo $this->translation->Translation_key("ONLINE PAYMENT", $_SESSION['lang_u']); ?></a></li>
				<li><a href="<?php echo base_url(); ?>backoffice/settings_regional"><?php echo $this->translation->Translation_key("REGIONAL SETTINGS", $_SESSION['lang_u']); ?></a></li>
				<li><a href="#"><?php echo $this->translation->Translation_key("BILLING & PLANS", $_SESSION['lang_u']); ?></a></li>
				<li><a href="<?php echo base_url(); ?>backoffice/settings_users"><?php echo $this->translation->Translation_key("USERS", $_SESSION['lang_u']); ?></a></li>
				<li><a href="<?php echo base_url(); ?>backoffice/settings_taxes"><?php echo $this->translation->Translation_key("TAXES & FEES", $_SESSION['lang_u']); ?></a></li>
				<li><a href="#"><?php echo $this->translation->Translation_key("EMAIL LOGS", $_SESSION['lang_u']); ?></a></li>
			</ul>
		<?php } ?>
		<?php if( $user["u_agente"] == 'Sim' or $user["u_operador"] == 'Sim' ) { ?>
		<li class=""><a href="#"><i class="icon s7-bookmarks"></i><span><?php echo $this->translation->Translation_key("ACTION LOGS", $_SESSION['lang_u']); ?></span></a></li>
		<?php } ?>
		<?php if( $user["u_agente"] == 'Sim' or $user["u_operador"] == 'Sim' ) { ?>
		<li class=""><a href="#"><i class="icon s7-help1"></i><span><?php echo $this->translation->Translation_key("ACADEMY", $_SESSION['lang_u']); ?></span></a></li>
		<?php } ?>
		<?php if( $user["u_operador"] == 'Sim' ) { ?>
		<li class=""><a href="<?php echo base_url(); ?>backoffice/saft"><i class="icon s7-news-paper"></i><span><?php echo $this->translation->Translation_key("SAF-T PT", $_SESSION['lang_u']); ?></span></a></li>
		<?php } ?>
		<?php if( $user["u_agente"] == 'Sim' or $user["u_operador"] == 'Sim' ) { ?>
		<li class=""><a href="<?php echo base_url(); ?>backoffice/logout"><i class="icon s7-power"></i><span><?php echo $this->translation->Translation_key("LOGOUT", $_SESSION['lang_u']); ?></span></a></li>
		<?php } ?>
	</div>
	<div id="widget-area" class="widget-area" role="complementary">
		<aside id="text-2" class="widget-menu widget_text" style='padding:5px; font-size:10px;'>
			<h2 class="widget-title"><?php echo $this->translation->Translation_key("Contact Us", $_SESSION['lang_u']); ?></h2>
			<div class="textwidget">Av. da Boavista n.1167<br>6º - 61<br>4100-130 Porto<br>Portugal<p></p><p><strong>Phone</strong><br>+ 351 224 100 682</p><p><strong>Hours</strong><br>Monday—Friday: 9:00AM–6:00PM</p><p><strong>info&#64;globalfragments.com</strong><br></p></div>
		</aside>			
	</div>
</div>


