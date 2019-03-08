<!DOCTYPE HTML>
<html>
    <?php $this->load->view('header'); ?>
    <body class="cbp-spmenu-push">
        <div class="loading-overlay">
            <div class="spinner">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
        <div class="modal fade animated bounceIn" id="modalResponsive" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="main-content">
            <!--left-fixed -navigation-->
            <?php
            if ($this->session->userdata('logged')) {
                $this->load->view('menu_left');
            } else if ($this->session->userdata('loggedroot')) {
                $this->load->view('menu_left_root');
            }
            ?>
            <!--left-fixed -navigation-->
            <!-- header-starts -->
            <?php $this->load->view('top_bar'); ?>
            <!-- //header-ends -->
            <!-- main content start-->
            <div id="page-wrapper" style="min-height:87vh">
                <div class="main-page">
                    <?php echo $this->template->content; ?>
                </div>
            </div>
            <!--footer-->
            <div class="footer">
                <p>&copy; 2017 <a href="https://novoscanais.com/" target="_blank">Novoscanais</a></p>
            </div>
            <!--//footer-->
        </div>
        <?php $this->load->view('footer'); ?>
    </body>
</html>