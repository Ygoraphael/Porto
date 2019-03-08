<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<?php
if (!isset($user))
    return false;
?>
<?php $cur_url = $this->uri->segment(1) . '/' . $this->uri->segment(2); ?>
<div class="am-logo"></div>
<div class="nav-side-menu">
    <div class="menu-list">
        <ul id="menu-content" class="menu-content collapse out">
            <li class="<?php echo( $cur_url == "admin/") ? "active" : ""; ?>"><a href="<?php echo base_url(); ?>admin"><i class="icon s7-monitor"></i><span>Home</span></a></li>
            <li class="<?php
            if ($cur_url == "admin/pages" || $cur_url == "admin/editpages") {
                echo "active";
            }
            ?>"><a href="<?php echo base_url(); ?>admin/pages"><i class="icon s7-diamond"></i><span>Pages</span></a></li>

            <li class="<?php echo( $cur_url == "admin/menuscategory" || $cur_url == "admin/menusitem" ) ? "active" : ""; ?>" data-toggle="collapse" data-target="#products">
                <a href="#"><i class="icon s7-network"></i><span>Menus</span><span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse" id="products">
                <li><a href="<?php echo base_url(); ?>admin/menuscategory">Categories</a></li>
                <li><a href="<?php echo base_url(); ?>admin/menusitem">Items</a></li>
            </ul>
            <li class="<?php echo( $cur_url == "admin/metatags") ? "active" : ""; ?>" data-toggle="collapse" data-target="#seo">
                <a href="#"><i class="icon s7-search"></i><span>SEO</span><span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse" id="seo">
                <li><a href="<?php echo base_url(); ?>admin/metatags">Meta Tags</a></li>
            </ul>
            <li class="<?php
            if ($cur_url == "admin/plugin" || $cur_url == "admin/editplugin") {
                echo "active";
            }
            ?>"><a href="<?php echo base_url(); ?>admin/plugin"><i class="icon s7-note2"></i><span>Plugins</span></a></li>
            <li class="<?php
            if ($cur_url == "admin/users") {
                echo "active";
            }
            ?>"><a href="<?php echo base_url(); ?>admin/users"><i class="icon s7-users"></i><span>Users</span></a></li>
            <li class="<?php
            if ($cur_url == "admin/translations") {
                echo "active";
            }
            ?>"><a href="<?php echo base_url(); ?>admin/translations"><i class="icon s7-science"></i><span>Languages</span></a></li>
            <li class=""><a href="<?php echo base_url(); ?>login_popup/logout"><i class="icon s7-power"></i><span>Logout</span></a></li>
            </li>
        </ul>
    </div>
</div>

<div class="content">
    <div class="am-logo"></div>
    <ul class="sidebar-elements">
        <li class="parent ">
            <a href=""><i class="icon s7-ribbon"></i><span>Plugins</span></a>
        </li>
        <li class="parent ">
            <a href=""><i class="icon s7-user"></i><span>Users</span></a>
        </li>
        <li class="parent "><a href=""><i class="icon s7-flag"></i>Languages</a>

        </li>
        <li class=""><a href="<?php echo base_url(); ?>login_popup/logout"><i class="icon s7-power"></i><span>LOGOUT</span></a></li>

    </ul>
    <!--Sidebar bottom content-->
</div>