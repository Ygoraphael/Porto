<!DOCTYPE HTML>
<html>
    <?php 
	$_SESSION['cod_trabalhador_temp'] = $cod_trabalhador;
	$this->load->view("header.php"); ?> 
    <body>	
        <div class=" col-lg-offset-2 col-lg-6 main-content">
            <div id="page-wrapper">
				<div class="text-center">
					<h4>Tarefas a fechar</h4>
					<hr class="style13">
				</div>
                <div class="col-lg-offset-1 col-lg-10 main-page">
					<div class="text-left">
						<ul>
							<li class="list-inline columnCaptions">
								<span>QTD.</span>
								<span>Produto</span>
								<span></span>
							</li>
							<?php 
								$count_staks = 0;
								foreach ($temp as $t): ?>
								<li class="row">
									<span class="quantity"><?php echo $t['qtt'] ?></span>
									<span class="itemName" style="font-size:15px;"><?php echo substr($t['design'], 0, 100); ?></span>
									<span class="remove"><button type="button" onclick="window.location.href = '<?php echo base_url(); ?>ponto/delete_tmp_tarefa5/<?php echo $t['ststamp'];?>'"class="btn btn-danger" style="font-size:18px;color:white"><i class="fa fa-times" aria-hidden="true"></i></button></span>
								</li>
							<?php $count_staks++;  endforeach; ?>
						</ul>
					</div>
					<div class="col-lg-12" style="margin-top:25px;" >
						<button onClick="parent.jQuery.fancybox.close();" class="btn_cart2  fancybox fancybox.iframe" data-toggle="modal" data-target="#popup"><i class="fa fa-caret-square-o-left" aria-hidden="true" style="font-size:46px;color:white"></i></button>
						<button type="submit" data-controller="ponto"  title="Fechar Tarefas" class="btn_cart btn_save  fancybox fancybox.iframe" data-toggle="modal" data-target="#popup" ><i class="fa fa-check-square-o" style="font-size:46px;color:white"></i></button>

						<input type="hidden" name="count1" id="count1" value="<?php echo $count_prod;?>">
						<input type="hidden" name="count2" id="count2" value="<?php echo $count_staks;?>">
						<input type="hidden" name="cod_trabalhador" id="cod_trabalhador" value="<?php echo $cod_trabalhador;?>">
						
					<div class="clearfix"></div>	
					</div>
				</div>
			</div>
		</div>
    </body>
</html>
<script>
$(document).ready(function () {
	$(document).on('click', '.btn_save', function () {
		var btn = $(this);
		btn.addClass('disabled');
		var count1 = $('#count1').val();
		var count2 = $('#count2').val();
		var cod_trabalhador = $('#cod_trabalhador').val();
		var src = <?php echo json_encode(base_url()); ?>;
		var action = src + '/' + btn.attr('data-controller') + '/save_fechar_tarefa';
		var action2 = src + '/' + btn.attr('data-controller') + '/save_fechar_tarefa';
		if( count2 < count1){
			bootbox.confirm({
				message: 'As tarefas a serem fechadas são menores do que as tarefas planejadas, Tem certeza de que deseja fechar apenas essas tarefas?',
				buttons: {
					confirm: {
						label: 'Si, fechar',
						className: 'btn-success ',
					},
					cancel: {
						label: 'Cancel',
						className: 'btn-danger',
					}
				},
				callback: function (result) {
					if (result) {
						$.post(action2, {cod_trabalhador: cod_trabalhador, status: '1'}, function () {
						}).done(function (response) {
							window.location.href = src + '/ponto/sv_tarefa_dossier/1';
						});
					}else{ parent.jQuery.fancybox.close();}
				}
			});	
		}else{
			$.post(action, {cod_trabalhador: cod_trabalhador, status: '0'}, function () {
			}).done(function (response) {
				window.location.href = src + '/ponto/sv_tarefa_dossier/0';
			});
		}	
	});
})	
</script>



<style>
    #page-wrapper {
        padding: 1em 1em 2em;
        text-align: center;
        background-color: #FFFFFF;
		width:100%;
		height:100%;
    }

	ul{
        list-style-type: none;
    }

    .row{
        box-shadow: 0 1px 0 #e1e5e8;
        padding-bottom :0;
        padding-left: 0px;
        background-color: #ffffff;
        margin-bottom: 11px;
        margin-top:5px !important;
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
        font-weight: bold;
        float : left;
        padding-left: 0px;
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
        padding-top:0px !important;
        padding-right:0px !important;
        color: #f06953;
        font-size :25px;
        font-weight: bold;
        float: right;
    }

	input {
        font-size: 2em;
        color: #fff;
        
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


	hr.style13 {
		height: 10px;
		border: 0;
		box-shadow: 0 10px 10px -10px #8c8b8b inset;
	}

</style>