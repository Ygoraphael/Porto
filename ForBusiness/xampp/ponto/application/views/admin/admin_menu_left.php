<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<?php if ( !isset( $user ) )
		return false;
?>
<?php $cur_url = $this->uri->segment(1).'/'.$this->uri->segment(2); ?>
<div class="content">
  <div class="am-logo"></div>
  <ul class="sidebar-elements">
	<li class="parent <?php if( $cur_url == "admin/pages" || $cur_url == "admin/editpages" ) { echo "active"; }?>">
		<a href="<?php echo base_url(); ?>admin/pages"><i class="icon s7-diamond"></i><span>Pages</span></a>
	</li>
	<li class="parent"><a href="#"><i class="icon s7-graph"></i><span>MENUS</span></a>
	  <ul class="sub-menu">
		<li class="<?php if( $cur_url == "admin/menuscategory" ) { echo "active"; }?>"><a href="<?php echo base_url(); ?>admin/menuscategory">Categorias</a>
		</li>
		<li class="<?php if( $cur_url == "admin/menusitem" ) { echo "active"; }?>"><a href="<?php echo base_url(); ?>admin/menusitem">Items</a>
		</li>
	  </ul>
	</li>
	<li class="parent <?php if( $cur_url == "admin/plugin" || $cur_url == "admin/editplugin") { echo "active"; }?>">
		<a href="<?php echo base_url(); ?>admin/plugin"><i class="icon s7-ribbon"></i><span>Plugins</span></a>
	</li>
	<li class="parent <?php if( $cur_url == "admin/users") { echo "active"; }?>">
		<a href="<?php echo base_url(); ?>admin/users"><i class="icon s7-user"></i><span>Users</span></a>
	</li>
		<li class="parent <?php if( $cur_url == "admin/translations" ) { echo "active"; }?>"><a href="<?php echo base_url(); ?>admin/translations"><i class="icon s7-flag"></i>Languages</a>
	 
	</li>
	<li class=""><a href="<?php echo base_url(); ?>login_popup/logout"><i class="icon s7-power"></i><span>LOGOUT</span></a></li>

  </ul>
	 <!--Sidebar bottom content-->
</div>
