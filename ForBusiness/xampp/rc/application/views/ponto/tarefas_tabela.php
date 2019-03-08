<!DOCTYPE HTML>
<html>
    <?php $this->load->view("header.php"); ?> 
    <body>
        <div class="col-lg-offset-1 main-content" >
            <div >
                <a href="#">
                    <h1><?php echo $this->config->item("nc_name"); ?></h1>
                </a>
            </div>	
        </div>	
        <!-- Menu para Trabalhador -->
        <div class="main-content">
            <div id="page-wrapper" style="padding: 1.5em 0.5em 2.5em;">
				<div class="col-lg-10 text-left">
					<h1 style="padding: 0.5em 0.5em 1em;">Escolhe a tarefa para começar</h1>
				</div>
				<div class="col-lg-2 btn-red" style="padding: 0.5em 2em 0.2em;">
					<input type="button"  onclick="window.location.href = '<?php echo base_url(); ?>ponto'" class="btn_cart3" value="<?php echo $la = lang('Go_back'); ?>">
					<div class="clearfix"></div>	
				</div>
                <div class="col-lg-12">
                    <?php 
					foreach ($designs as $design): ?>
                        <div class="col-lg-3 boxhover" style="margin-bottom:25px;">
                            <a href="<?php echo base_url(); ?>ponto/registo_tarefasTabela/<?php echo $design["produtostamp"]; ?>" class=" fancybox fancybox.iframe" data-toggle="modal" data-target="#popup" >
                  			    <div class="box-wrapper">
                                    <img class="" style="background:url('<?php echo base_url(); ?><?php echo $design["imagem"]; ?>');" alt="">
                                    <div class="box-content">
                                        <div class="title"><?php echo $design["design"] ?></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
				<div class="clearfix"></div>
            </div>
	<?php $this->load->view('ponto/footer'); ?>
        </div>	
    </body>
<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox({
			afterClose : function() {
				window.parent.location.reload();
				window.parent.$.fancybox.close();
			return;
			}	
		});
	});
</script>
</html>
<style>
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
        margin-top: -200px;
        display: flex;
        align-items: center;
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

