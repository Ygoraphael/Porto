<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="container">
<div class="row">

<div style="margin-top:25px;"></div>

<?php $cur_url = $this->uri->segment(1).'/'.$this->uri->segment(2); ?>

<div class="list-group col-sm-12 col-md-12 col-lg-3">
  <a href="<?php echo base_url(); ?>wl/<?php echo $op; ?>/account" class="list-group-item <?php if( $cur_url == "account/" ) { echo "active"; }?>">Personal Information</a>
  <a href="<?php echo base_url(); ?>wl/<?php echo $op; ?>/account_orders" class="list-group-item <?php if( $cur_url == "account/orders" ) { echo "active"; }?>">Orders</a>
  <?php if($user["facebook_login"] == 0) { ?>
  <a href="<?php echo base_url(); ?>wl/<?php echo $op; ?>/account_changepw" class="list-group-item <?php if( $cur_url == "account/changepw" ) { echo "active"; }?>">Change Password</a>
  <?php }?>
  <a href="<?php echo base_url(); ?>wl/<?php echo $op; ?>/logout" class="list-group-item">Logout</a>
</div>