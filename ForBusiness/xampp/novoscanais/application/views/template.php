<!DOCTYPE html>
<html lang="pt">
    <?php $this->load->view('header'); ?>
    <body class="homepage">
        <?php $this->load->view('menu_topo'); ?>
        <?= $this->template->content ?>
        <?php $this->load->view('footer'); ?>
    </body>
</html>
