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
				<div class="col-lg-5 text-left">
				<h3 style="padding: 1.2em 1em 2em;">Escolhe a tarefa para começar</h3>
				</div>
				<form action="<?php echo base_url(); ?>ponto/tarefa_dossier/" method="get">
				<div class="col-lg-5 text-right" style="padding: 1.5em 1em 1.5em;">
					<p><input type="tel" placeholder="Search document" name="d" class="keyboard form-control keyboard-numpad" id="custom"></p>
				</div>
				</form>
				<div class="col-lg-2 btn-red" style="padding: 0.5em 2em 2em;">
					<input type="button" onclick="window.location.href = '<?php echo base_url(); ?>ponto'" class="btn_cart3" value="<?php echo $la = lang('Go_back'); ?>">
					<div class="clearfix"></div>	
				</div>
                <div class="col-lg-12">
                    <?php if(empty($designs)){ ?>
						<div class="col-lg-12 box_hover" style="margin-bottom:25px;">
                                <div class="bopper">
									<h2>Não ha produtos</h2><br>
									<h4></h4>
                                </div>
                        </div>
					<?php }else{
					foreach ($designs as $design): ?>
                        <div class="col-lg-3 box_hover" style="margin-bottom:25px;">
                            <a href="<?php echo base_url(); ?>ponto/registo_tarefasDossier/<?php echo $design["bistamp"]; ?>" class=" fancybox fancybox.iframe" data-toggle="modal" data-target="#popup" >
                                <div class="bopper">
									<h2><?php echo $design["design"]; ?></h2><br>
									<h4>( <?php echo $design["obrano"]; ?> )</h5>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; }?>
                </div>
				<div class="clearfix"></div>
            </div>
<?php $this->load->view('ponto/footer'); ?>
        </div>	
    </body>
	<script type="text/javascript">
		
function filter(){
	$(document).ready(function () {
		$(document).on('click', '.keyboard-numpad', function () {
			var filter =  $("#custom").val();			
			window.location.href = '<?php echo base_url(); ?>ponto/tarefa_dossier/'+ filter
		});
	});
}


$(document).ready(function() {
	$('.fancybox').fancybox({
		afterClose : function() {
			window.parent.location.reload();
			window.parent.$.fancybox.close();
		return;
		}	
	});
});

$(function(){
$('#custom').keyboard({
	layout: [
		[ ['1'] ,  ['2'] ,  ['3'] ],
		[ ['4'] ,  ['5'] ,  ['6'] ],
		[ ['7'] ,  ['8'] ,  ['9'] ],
		[['0', '0'], ['del', 'del'],['enter', 'enter']]
	]
});
});

	</script>
</html>


