<!DOCTYPE HTML>
<html>
    <?php $this->load->view("header.php"); ?> 
    
    <script>
    
        
    $(window).load(function() {
		// Animate loader off screen
		$('#overlay').fadeOut(1001);
	});    

    </script>
    
    <body>
        
        <div id="overlay" style="display:block;background-color:white;opacity:1"><svg style="position:absolute;width:15%;height:15%;text-align:center;left:42.5%;top:40%" aria-hidden="true" data-prefix="fas" data-icon="circle-notch" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-circle-notch fa-w-16 fa-spin fa-sm"><path fill="currentColor" d="M288 39.056v16.659c0 10.804 7.281 20.159 17.686 23.066C383.204 100.434 440 171.518 440 256c0 101.689-82.295 184-184 184-101.689 0-184-82.295-184-184 0-84.47 56.786-155.564 134.312-177.219C216.719 75.874 224 66.517 224 55.712V39.064c0-15.709-14.834-27.153-30.046-23.234C86.603 43.482 7.394 141.206 8.003 257.332c.72 137.052 111.477 246.956 248.531 246.667C393.255 503.711 504 392.788 504 256c0-115.633-79.14-212.779-186.211-240.236C302.678 11.889 288 23.456 288 39.056z" class=""></path></svg></div>
        
        <div class="col-lg-offset-1 main-content" >
            <div>
                <a href="<?= base_url() ?>ponto">
                    <h1><?= $this->config->item("nc_name"); ?></h1>
                </a>
            </div>	
        </div>	
        <!-- Menu para Trabalhador -->
        <div class="main-content">
            <div id="page-wrapper" style="min-height:87vh">
                <div class="col-lg-9">
                    <?php $tpm = $_SESSION['token_temp']; ?>
                    <?php if ($u_ncidef['tarefastipo'] == 0): ?>
                        <?php foreach ($items as $item): ?>
                            <div class="col-lg-3 boxhover" style="margin-bottom:25px;">
                                <a href="<?php echo base_url(); ?>ponto/popup_qtt/<?php echo $item["dytablestamp"]; ?>" class="fancybox fancybox.iframe">
                                    <div class="box-wrapper">
                                        <div class="box-content">
                                            <div class="title"><?php echo $item["campo"]; ?></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <?php if ($u_ncidef['tarefastipo'] == 1): ?>
                        <?php foreach ($items as $item): ?>
                            <div class="col-lg-3 boxhover" style="margin-bottom:25px;">
                                <a href="<?php echo base_url(); ?>ponto/popup_qtt/<?php echo $item[$u_ncidef["tarefastabela"] . "stamp"]; ?>" class="fancybox fancybox.iframe">
                                    <div class="box-wrapper">
                                        <div class="box-content">
                                            <div class="title"><?php echo $item["design"]; ?></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <?php if ($u_ncidef['tarefastipo'] == 2): ?>
                        <?php foreach ($items as $item): ?>
                            <div class="col-lg-3 boxhover" style="margin-bottom:25px;">
                                <a href="<?php echo base_url(); ?>ponto/popup_qtt/<?php echo $item["bistamp"]; ?>" class="fancybox fancybox.iframe">
                                    <div class="box-wrapper">
                                        <div class="box-content">
                                            <div class="title"><?php echo $item["design"]; ?></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <?php if ($u_ncidef['tarefastipo'] == 3): ?>
                        <?php foreach ($items as $item): ?>
                            <div class="col-lg-3 boxhover" style="margin-bottom:25px;">
                                <a href="<?php echo base_url(); ?>ponto/tarefas/<?php echo $item["stfamistamp"]; ?>">
                                    <div class="box-wrapper">
                                        <img style="background:url('<?php echo base_url(); ?><?php echo $item["imgqlook"]; ?>');" alt="">
                                        <div class="box-content">
                                            <div class="title"><?php echo $item["nome"]; ?></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                        <?php foreach ($subitems as $subitem): ?>
                            <div class="col-lg-2 boxhover" style="margin-bottom:25px;">
                                <a href="<?php echo base_url(); ?>ponto/popup_qtt/<?php echo $subitem["ststamp"]; ?>" class="fancybox fancybox.iframe">
                                    <div class="box-wrapper">
                                        <img class="" style="background:url('<?php echo $subitem["imagem"]; ?>');" alt="">
                                        <div class="box-content">
                                            <div class="title"><?php echo $subitem["design"] ?></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="col-lg-3">
                    <?php $this->load->view('ponto/cart/cart', $cart); ?>
                    <div class="clearfix"></div>

                    <div class="col-lg-6" style="margin-top:25px">
                        <button type ="button" onclick="window.location.href = '<?= base_url() . "ponto/" . $goback ?>'" class="stats-ponto" style="background-color:#D0333D"><i style="color:white; font-size:55px" class="fa fa-caret-square-o-left"></i></button>
                        <div class="clearfix"></div>	
                    </div>  

                    <div class="col-lg-6" style="margin-top:25px">
                        <button href="<?= base_url() ?>ponto/send_cart" class="stats-ponto fancybox fancybox.iframe fb_dynamic" data-toggle="modal" data-target="#popup"><i class="fa fa-check-square-o" style="font-size:56px;color:white"></i></button>
                        <div class="clearfix"></div>	
                    </div>

                </div>
                <div class="clearfix"></div>
            </div>
            <?php $this->load->view('ponto/footer'); ?>
        </div>	
    </body>

    <script type="text/javascript">                                                                                              
        $(document).ready(function () {
            var ifr = $('.fancybox').fancybox({
                afterClose: function () {
                    window.parent.location.reload();
                    window.parent.$.fancybox.close();
                    return;
                },
                touch: {
                    vertical: true, // Allow to drag content vertically
                    momentum: true   // Continuous movement when panning
                },
                toolbar : false,
            });
        });
    </script>
</html>

<style>

    body{
        overflow: hidden !important;                        
    }                     

    #page-wrapper {
        padding: 1.5em 0.5em 2.5em;

    }

    input {
        font-size: 2em;
        color: #fff;
    }             

    .boxhover {
        background-repeat: no-repeat; 
        height: 200px;
        margin: auto;
    }

    .box-wrapper {
        overflow: hidden;
        box-shadow: 0px 5px 42px rgba(0, 0, 0, 0.5);
        text-align: center;
        background-color: black;
        width:100%;
        height:100%;

    }

    .box-wrapper img {
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat; 
        opacity: 0.5;
        width: 100%;
        height: 100%;
    }

    .box-content {
        position: relative;
        z-index: 1;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        <?php if ($u_ncidef['tarefastipo'] == 3): ?>
            top: -200px;
        <?php endif; ?>
    }

    .box-content:before {
        content: '';
        width: 150%;
        height: 100px;
        position: absolute;
        display: block;
        top: -200px;
        left: 0;
        z-index: -1;
    }

    .title {
        font-size: 1em;
        width: 100%;
        font-weight: 600;
        text-transform: uppercase;
        font-family: 'Open Sans', sans-serif;
        color: #fff;
        word-wrap: break-word;
    }

    ul{
        list-style-type: none;
    }

    .row{
        box-shadow: 0 1px 0 #e1e5e8;
        padding-bottom :0;
        padding-left: 15px;
        background-color: #ffffff;
        margin-bottom: 11px;
        margin-top:5px !important;
    }

    .row span{
        padding: 15px 0 6px 0;
    }

    /* Column Captions */

    .columnCaptions{
        font-size:12px;
        text-transform: uppercase;
        padding: 0;
        box-shadow: 0 0 0;
    }

    .columnCaptions span:first-child{
        padding-left:8px;
    }

    .columnCaptions span{
        padding: 0 21px 0 0;
    }

    .columnCaptions span:last-child{
        float: right;
        padding-right: 72px;
    }


    /* Items */

    .itemName{	
        color: #727578;
        font-size :16px;
        font-weight: bold;
        float: left;
        padding-left:25px;
    }


    .quantity{	
        color: #4ea6bc;
        font-size :18px;
        font-weight: bold;
        float : left;
        width: 42px;
        padding-left: 7px;
    }


    .popbtn{
        background-color: #e6edf3;
        margin-left: 25px;
        height: 63px;
        width: 40px;
        padding: 32px 0 0 14px !important;
        float: right;
        cursor: pointer;
    }

    .arrow{
        width: 0; 
        height: 0; 
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 6px solid #858e97;
    }

    .remove{
        padding-top:10px !important;
        padding-right:10px !important;
        color: #f06953;
        font-size :18px;
        font-weight: bold;
        float: right;
    }
</style>
<?php $this->load->view('footerscript'); ?>