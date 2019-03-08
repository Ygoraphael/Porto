<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<ul class="nav nav-pills nav-justified thumbnail setup-panel">
    <li class="<?php echo ($page == "type") ? "active" : ""; ?>">
        <a href="<?php echo base_url() . "backoffice/product/" . $product["u_sefurl"]; ?>"><p class="list-group-item-text"><?php echo $this->translation->Translation_key("TYPE", $_SESSION['lang_u']); ?></p></a>
    </li>
    <li class="<?php echo ($page == "details") ? "active" : ""; ?>">
        <a href="<?php echo base_url() . "backoffice/product/" . $product["u_sefurl"]; ?>/details"><p class="list-group-item-text"><?php echo $this->translation->Translation_key("DETAILS", $_SESSION['lang_u']); ?></p></a>
    </li>
    <li class="dropdown <?php echo ($page == "tickets" || $page == "tickets-number" || $page == "seats" || $page == "seats-disposition" ) ? "active" : ""; ?>">
        <a class="dropdown-toggle list-group-item-text" data-toggle="dropdown" href="#"><?php echo $this->translation->Translation_key("TICKETS", $_SESSION['lang_u']); ?>
            <span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li class="<?php echo ($page == "tickets") ? "active" : ""; ?>"><a href="<?php echo base_url() . "backoffice/product/" . $product["u_sefurl"]; ?>/tickets"><?php echo $this->translation->Translation_key("TICKETS", $_SESSION['lang_u']); ?></a></li>
            <li class="<?php echo ($page == "tickets-number") ? "active" : ""; ?>"><a href="<?php echo base_url() . "backoffice/product/" . $product["u_sefurl"]; ?>/tickets-number"><?php echo $this->translation->Translation_key("TICKETS NUMBER", $_SESSION['lang_u']); ?></a></li>
            <li class="<?php echo ($page == "seats") ? "active" : ""; ?>"><a href="<?php echo base_url() . "backoffice/product/" . $product["u_sefurl"]; ?>/seats"><?php echo $this->translation->Translation_key("SEATS", $_SESSION['lang_u']); ?></a></li>
            <li class="<?php echo ($page == "seats-disposition") ? "active" : ""; ?>"><a href="<?php echo base_url() . "backoffice/product/" . $product["u_sefurl"]; ?>/seats-disposition"><?php echo $this->translation->Translation_key("SEATS DISPOSITION", $_SESSION['lang_u']); ?></a></li>
        </ul>
    </li>
    <li class="<?php echo ($page == "scheduling") ? "active" : ""; ?>">
        <a href="<?php echo base_url() . "backoffice/product/" . $product["u_sefurl"]; ?>/scheduling"><p class="list-group-item-text"><?php echo $this->translation->Translation_key("SCHEDULING", $_SESSION['lang_u']); ?></p></a>
    </li>
    <li class="<?php echo ($page == "location") ? "active" : ""; ?>">
        <a href="<?php echo base_url() . "backoffice/product/" . $product["u_sefurl"]; ?>/location"><p class="list-group-item-text"><?php echo $this->translation->Translation_key("LOCATION", $_SESSION['lang_u']); ?></p></a>
    </li>
    <li class="<?php echo ($page == "extras-resources") ? "active" : ""; ?>">
        <a href="<?php echo base_url() . "backoffice/product/" . $product["u_sefurl"]; ?>/extras-resources"><p class="list-group-item-text"><?php echo $this->translation->Translation_key("EXTRAS/RESOURCES", $_SESSION['lang_u']); ?></p></a>
    </li>
    <li class="<?php echo ($page == "taxes-fees") ? "active" : ""; ?>">
        <a href="<?php echo base_url() . "backoffice/product/" . $product["u_sefurl"]; ?>/taxes-fees"><p class="list-group-item-text"><?php echo $this->translation->Translation_key("TAXES & FEES", $_SESSION['lang_u']); ?></p></a>
    </li>
    <li class="<?php echo ($page == "pickups") ? "active" : ""; ?>">
        <a href="<?php echo base_url() . "backoffice/product/" . $product["u_sefurl"]; ?>/pickups"><p class="list-group-item-text"><?php echo $this->translation->Translation_key("PICKUPS", $_SESSION['lang_u']); ?></p></a>
    </li>

    <li class="<?php echo ($page == "languages") ? "active" : ""; ?>">
        <a href="<?php echo base_url() . "backoffice/product/" . $product["u_sefurl"]; ?>/languages"><p class="list-group-item-text"><?php echo $this->translation->Translation_key("LANGUAGES", $_SESSION['lang_u']); ?></p></a>
    </li>

    <li class="<?php echo ($page == "related-products") ? "active" : ""; ?>">
        <a href="<?php echo base_url() . "backoffice/product/" . $product["u_sefurl"]; ?>/related-products"><p class="list-group-item-text"><?php echo $this->translation->Translation_key("RELATED PRODUCTS", $_SESSION['lang_u']); ?></p></a>
    </li>
</ul>