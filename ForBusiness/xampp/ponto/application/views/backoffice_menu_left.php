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
				<li  class="<?php echo( $cur_url == "backoffice/")? "active" : "";?>"><a href="<?php echo base_url(); ?>backoffice"><i class="icon s7-monitor"></i><span>DASHBOARD</span></a></li>
				<?php if( $user["u_operador"] == 'Sim' ) { ?>
				<li class="<?php echo( $cur_url == "backoffice/products" || $cur_url == "backoffice/extras" || $cur_url == "backoffice/vouchers" || $cur_url == "backoffice/pickups" || $cur_url == "backoffice/lastminute")? "active" : "";?>" data-toggle="collapse" data-target="#products"><a href="#"><i class="icon s7-science"></i><span>MY PRODUCTS</span><span class="arrow"></span></a>
				</li>
				<ul class="sub-menu collapse" id="products">
					<li><a href="<?php echo base_url(); ?>backoffice/products">PRODUCTS</a></li>
					<li><a href="<?php echo base_url(); ?>backoffice/extras">EXTRAS/RESOURCES</a></li>
					<li><a href="<?php echo base_url(); ?>backoffice/vouchers">VOUCHERS</a></li>
					<li><a href="<?php echo base_url(); ?>backoffice/pickups">PICKUPS</a></li>
					<li><a href="<?php echo base_url(); ?>backoffice/lastminute">PRODUCT ORDER /<br>LAST MINUTE</a></li>
				</ul>
				
				<?php } ?>
			<?php if( $user["u_operador"] == 'Sim' ) { ?>
			<li class="<?php echo( $cur_url == "backoffice/orders")? "active" : "";?>"><a href="<?php echo base_url(); ?>backoffice/orders"><i class="icon s7-note2"></i><span>ORDERS</span></a></li>
			<?php } ?>
			<?php if( $user["u_agente"] == 'Sim' && $user["u_operador"] == 'Não' ) { ?>
			<li class="<?php echo( $cur_url == "backoffice/orders")? "active" : "";?>"><a href="<?php echo base_url(); ?>backoffice/agent_orders"><i class="icon s7-note2"></i><span>ORDERS</span></a></li>
			<?php } ?>
			<?php if( $user["u_operador"] == 'Sim' ) { ?>
			<li class="<?php echo( $cur_url == "backoffice/customers")? "active" : "";?>"><a href="<?php echo base_url(); ?>backoffice/customers"><i class="icon s7-users"></i><span>CUSTOMERS</span></a></li>
			<?php } ?>
			<?php if( $user["u_operador"] == 'Sim' ) { ?>
			<li class="<?php echo( $cur_url == "backoffice/agents")? "active" : "";?>"><a href="<?php echo base_url(); ?>backoffice/agents"><i class="icon s7-id"></i><span>AGENTS</span></a></li>
			<?php } ?>
			<?php if( $user["u_operador"] == 'Sim' ) { ?>
			<li class="<?php echo( $cur_url == "backoffice/calendar")? "active" : "";?>"><a href="<?php echo base_url(); ?>backoffice/calendar"><i class="icon s7-date"></i><span>CALENDAR</span></a></li>
			<?php } ?>
			<?php if($user["u_agente"] == 'Sim' and $user["u_operador"] == 'Não'  ) { ?>
			<li class="<?php echo( $cur_url == "backoffice/rep_fees" || $cur_url == "backoffice/rep_orders" )? "active" : "";?>" data-toggle="collapse" data-target="#reports"><a href="#"><i class="icon s7-graph3"></i><span>REPORTS</span><span class="arrow"></span></a>
			</li>
			<ul class="sub-menu collapse" id="reports">
				<li><a href="<?php echo base_url(); ?>backoffice/rep_agent_fees">MY FEES</a></li>
				<li><a href="<?php echo base_url(); ?>backoffice/rep_agent_orders">SALES ORDERS</a></li>
				<li><a href="<?php echo base_url(); ?>backoffice/rep_agent_treasury">TREASURY</a></li>
			</ul>
			
			<li class="<?php echo( $cur_url == "backoffice/white_label")? "active" : "";?>"><a href="<?php echo base_url(); ?>backoffice/agent_reimbursement"><i class="icon s7-news-paper"></i><span>REIMBURSEMENT</span></a></li>
			<li class="<?php echo( $cur_url == "backoffice/white_label")? "active" : "";?>"><a href="<?php echo base_url(); ?>backoffice/fee_receipts"><i class="icon s7-news-paper"></i><span>FEE RECEIPTS</span></a></li>
			<?php 
				}
				else{
						if($user["u_operador"] == 'Sim' ) { ?>
			<li class="<?php echo( $cur_url == "backoffice/rep_fees" || $cur_url == "backoffice/rep_orders" )? "active" : "";?>" data-toggle="collapse" data-target="#reports"><a href="#"><i class="icon s7-graph3"></i><span>REPORTS</span><span class="arrow"></span></a>
			</li>
			<ul class="sub-menu collapse" id="reports">
				<li><a href="<?php echo base_url(); ?>backoffice/rep_fees">MY FEES</a></li>
				<li><a href="<?php echo base_url(); ?>backoffice/rep_reimbursement">REIMBURSEMENTS</a></li>
				<li><a href="<?php echo base_url(); ?>backoffice/rep_orders">SALES ORDERS</a></li>
				<li><a href="<?php echo base_url(); ?>backoffice/rep_treasury">TREASURY</a></li>
			</ul>
			<?php }}?>
			<?php if( $user["u_operador"] == 'Sim' ) { ?>
			<li class="<?php echo( $cur_url == "backoffice/white_label")? "active" : "";?>"><a href="<?php echo base_url(); ?>backoffice/white_label"><i class="icon s7-network"></i><span>WHITE LABEL</span></a></li>
			<?php } ?>
			<?php if( $user["u_operador"] == 'Sim' ) { ?>
			<li class="<?php echo( $cur_url == "backoffice/integration")? "active" : "";?>" class="parent" data-toggle="collapse" data-target="#INTEGRATION"><a href="#"><i class="icon s7-share"></i><span>INTEGRATION</span><span class="arrow"></span></a>
			</li>
			<ul class="sub-menu collapse" id="INTEGRATION">
				<li><a href="<?php echo base_url(); ?>backoffice/integration_website">WEBSITE</a></li>
				<li><a href="<?php echo base_url(); ?>backoffice/integration_apps">APPS</a></li>
				<li><a href="<?php echo base_url(); ?>backoffice/integration_payment">PAYMENT GATEWAYS</a></li>
			</ul>
			<?php } ?>
			<?php if( $user["u_agente"] == 'Sim' or $user["u_operador"] == 'Sim' ) { ?>
			<li class="<?php echo( $cur_url == "backoffice/settings_profile" ||  $cur_url == "backoffice/settings_online-payment" ||  $cur_url == "backoffice/settings_regional" ||  $cur_url == "backoffice/settings_billing" || $cur_url == "backoffice/settings_users" ||  $cur_url == "backoffice/settings_taxes" || $cur_url == "backoffice/settings_logs")? "active" : "";?>"data-toggle="collapse" data-target="#SETTINGS"><a href="#"><i class="icon s7-config"></i><span>SETTINGS</span><span class="arrow"></span></a>
			</li>
			<ul class="sub-menu collapse" id="SETTINGS">
				<li><a href="<?php echo base_url(); ?>backoffice/settings_profile">PROFILE</a></li>
				<li><a href="<?php echo base_url(); ?>backoffice/settings_online-payment">ONLINE PAYMENT</a></li>
				<li><a href="<?php echo base_url(); ?>backoffice/settings_regional">REGIONAL SETTINGS</a></li>
				<li><a href="<?php echo base_url(); ?>backoffice/settings_billing">BILLING & PLANS</a></li>
				<li><a href="<?php echo base_url(); ?>backoffice/settings_users">USERS</a></li>
				<li><a href="<?php echo base_url(); ?>backoffice/settings_taxes">TAXES & FEES</a></li>
				<li><a href="<?php echo base_url(); ?>backoffice/settings_logs">EMAIL LOGS</a></li>
			</ul>
		<?php } ?>
		<?php if( $user["u_agente"] == 'Sim' or $user["u_operador"] == 'Sim' ) { ?>
		<li class=""><a href="<?php echo base_url(); ?>backoffice/logs"><i class="icon s7-bookmarks"></i><span>ACTION LOGS</span></a></li>
		<?php } ?>
		<?php if( $user["u_agente"] == 'Sim' or $user["u_operador"] == 'Sim' ) { ?>
		<li class=""><a href="<?php echo base_url(); ?>backoffice/academy"><i class="icon s7-help1"></i><span>ACADEMY</span></a></li>
		<?php } ?>
		<?php if( $user["u_operador"] == 'Sim' ) { ?>
		<li class=""><a href="<?php echo base_url(); ?>backoffice/saft"><i class="icon s7-news-paper"></i><span>SAF-T PT</span></a></li>
		<?php } ?>
		<?php if( $user["u_agente"] == 'Sim' or $user["u_operador"] == 'Sim' ) { ?>
		<li class=""><a href="<?php echo base_url(); ?>backoffice/logout"><i class="icon s7-power"></i><span>LOGOUT</span></a></li>
		<?php } ?>
	</div>
	<div id="widget-area" class="widget-area" role="complementary">
		<aside id="text-2" class="widget-menu widget_text" style='padding:5px; font-size:10px;'>
			<h2 class="widget-title">Contact Us</h2>
			<div class="textwidget">Av. da Boavista n.1167<br>6º - 61<br>4100-130 Porto<br>Portugal<p></p><p><strong>Phone</strong><br>+ 351 224 100 682</p><p><strong>Hours</strong><br>Monday—Friday: 9:00AM–6:00PM</p><p><strong>info&#64;globalfragments.com</strong><br></p></div>
		</aside>			
	</div>
</div>


