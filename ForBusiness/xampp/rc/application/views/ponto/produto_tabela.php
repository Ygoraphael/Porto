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
		<div id="tarefas_all" >
			<div class=" table-responsive col-md-10 col-md-offset-1">
                <table class="table table-bordered table-hover mb-0" style=" background-color: white;">
					<thead >
						<tr>
							<th class="text-center">Trabalhador</th>
							<th class="text-center">Tarefa Iniciada</th>
							<th class="text-center">Ação</th>
						</tr>
                    </thead>
					<tbody>
					<tr>
						<td>
						<form action="<?php echo base_url(); ?>ponto/product_tabela" method="POST">
							<div class="col-lg-12">
								<?php 
								foreach ($trabalhador as $trabalhadore): ?>
									<div class="col-lg-12 box_hover" >
										<div class="bopper2">
											<p> <?php echo $trabalhadore["username"]; ?></p>
											<input type="hidden" name="u_codcart"  value="<?php echo $trabalhadore["u_codcart"]; ?>">
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</td>
						<td>
						<div class="col-lg-12">
							<?php 
							foreach ($produtos as $produto): ?>
								<div class="col-lg-12 box_hover" >
									<div class="bopper2">
										<p> <?php echo $produto["design"]; ?></p>
										<input type="hidden" name="produtostamp"  value="<?php echo $produto["produtostamp"]; ?>">
									</div>
								</div>
							<?php endforeach; ?>
						</div>
						</td>
						<td>
							<div class="col-lg-6 states-lg ">
								<input type="button"  onclick="window.location.href = '<?php echo base_url(); ?>ponto/familias'" style="font-size:20px;color:white" class="stats-ponto" value="<?php echo $la = lang('Go_back'); ?>">
								<div class="clearfix"></div>	
							</div>
							<div class="col-lg-6 ">
								<button  style="font-size:20px;color:white" class="stats-ponto"><?php echo $la = lang('close_task'); ?></button>
								<div class="clearfix"></div>	
							</div>
						</td>
						</form>
					</tr>
			        </tbody>
                </table>
			</div>
		</div>	
		<div class="clearfix"></div>
		<?php $this->load->view('ponto/footer'); ?>
    </body>
</html>
<script>
    function repla() {
        location.replace("<?php echo base_url() ?>ponto/familias")
    }
</script>
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
<style>

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