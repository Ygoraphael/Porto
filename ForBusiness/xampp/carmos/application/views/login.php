<!DOCTYPE HTML>
<html>
    <head>
        <?php $this->load->view('header'); ?>
    </head> 
    <body>
        <div class="main-content">
            <div id="page-wrapper">
                <div class="main-page login-page ">
                    <h3 class="title1"><?= $this->config->item('nc_name') ?></h3>
                    <div class="widget-shadow">
                        <div class="login-body">
                            <?php echo form_open(); ?>
                            <input type="text" class="user" name="username" placeholder="<?= lang('user'); ?>" required="">
                            <input type="password" name="password" class="lock" placeholder="<?= lang('password'); ?>">
                            <input type="submit" name="enviar" value="<?= lang('enter'); ?>">
                            <?php form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer">
                <p>&copy; <?= date('Y'); ?> <a href="https://novoscanais.com/" target="_blank">Novoscanais</a></p>
            </div>
        </div>
        <script src="js/jquery.nicescroll.js"></script>
        <script src="js/scripts.js"></script>
        <script src="js/bootstrap.js"></script>
    </body>
</html>