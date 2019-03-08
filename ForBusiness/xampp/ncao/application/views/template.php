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
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
            <?php $this->load->view('logo_bar'); ?>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <!--menu left-->
                <?= $this->template->partial->widget('menu_left', $args = array()); ?>
                <?php $this->load->view('top_bar'); ?>
            </div>
        </nav>
        <div class="content-wrapper">
            <div class="container-fluid">
                <!-- Breadcrumbs-->
                <?= $this->breadcrumbs->show() ?>
                <?php echo $this->template->content; ?>
            </div>
            <!-- /.container-fluid-->
            <!-- /.content-wrapper-->
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
            <!-- Logout Modal-->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Deseja mesmo sair?</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Vai terminar a sua sessão</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                            <a class="btn btn-primary" href="login.html">Sair</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view('footer') ?>
        </div>
    </body>
</html>
