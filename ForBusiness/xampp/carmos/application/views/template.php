<!DOCTYPE HTML>
<html lang="pt">
    <head>
        <?php $this->load->view('header'); ?>
    </head>
    <div id="preloader"><div class="spinner-sm spinner-sm-1" id="status"> </div></div>
    <body class="fixed-nav sticky-footer bg-dark" id="page-top">
        <div class="loading-overlay">
            <div class="spinner">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="container-fluid">
                <?php echo $this->template->content; ?>
            </div>
            <footer class="sticky-footer">
                <div class="container">
                    <div class="text-center">
                        <small>© Novoscanais <?= date('Y') ?></small>
                    </div>
                </div>
            </footer>
            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fa fa-angle-up"></i>
            </a>
            <?php $this->load->view('footer') ?>
        </div>
    </body>
</html>
