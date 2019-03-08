<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2><?php echo $this->translation->Translation_key($title, $_SESSION['lang_u']);?></h2>
	</div>
</div>
<div class="main-content col-sm-12">
	<div class="col-lg-12">
		<div class="row form-group">
			<div class="col-xs-12">
				<ul class="nav nav-pills nav-justified thumbnail setup-panel">
					<?php  
						$ag = 0;
						if( $user["u_operador"] == 'Não' and $user["u_agente"] == 'Sim' ){
							$ag = 1 ;
						}	
					?>

					<li data-step-tab="1" class="active">
						<a onclick="update_charts(1, <?php echo $ag;?>); return false;" href="#tab1"><p class="list-group-item-text"><?php echo $this->translation->Translation_key("Last 7 days", $_SESSION['lang_u']); ?></p></a>
					</li>

					<li data-step-tab="2" class="">
						<a onclick="update_charts(2, <?php echo $ag;?>); return false;" href="#tab2"><p class="list-group-item-text"><?php echo $this->translation->Translation_key("Last month", $_SESSION['lang_u']); ?></p></a>
					</li>
					<li data-step-tab="3" class="">
						<a onclick="update_charts(3, <?php echo $ag;?>); return false;" href="#tab3"><p class="list-group-item-text"><?php echo $this->translation->Translation_key("Last quarter", $_SESSION['lang_u']); ?></p></a>
					</li>
					<li data-step-tab="4" class="">
						<a onclick="update_charts(4, <?php echo $ag;?>); return false;" href="#tab4"><p class="list-group-item-text"><?php echo $this->translation->Translation_key("Last half", $_SESSION['lang_u']); ?></p></a>
					</li>
					<li data-step-tab="5" class="">
						<a onclick="update_charts(5, <?php echo $ag;?>); return false;" href="#tab5"><p class="list-group-item-text"><?php echo $this->translation->Translation_key("Last year", $_SESSION['lang_u']); ?></p></a>
					</li>
				</ul>
			</div>
		</div>
		<div class='col-lg-12' style="text-align: -webkit-center; display:none;" id="no_data">
			<i class="s7-gleam" style="font-size: 112px;"></i>
			<br>
			<br>
			<b><?php echo $this->translation->Translation_key("NO DATA", $_SESSION['lang_u']); ?></b>
			<br>
			<?php echo $this->translation->Translation_key("There is no data for this report", $_SESSION['lang_u']); ?>
		</div>
		<div class='col-lg-6'>
			<div id='chart1'></div>
		</div>
		<div class='col-lg-6'>
			<div id='chart2'></div>
		</div>
		<div class='col-lg-6' >
			<div id='chart3'></div>
		</div>
		
		<div class='col-lg-6'>
			<div id='chart4'></div>
		</div>

		<script>
			$(document).ready(function() {		
				update_charts(1, <?php echo $ag;?>);
			});
			
			function update_charts(op, ag) {
				$(".loading-overlay").show();
				$( "#no_data" ).hide();
				jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>backoffice/ajax/update_chart",
					data: { 
						"op" : op,
						"ag" : ag
					},
					success: function(data) 
					{
						data = JSON.parse(data);
						if( data ) {
							$( '#chart1' ).css('margin-bottom',0);
							$( '#chart2' ).css('margin-bottom',0);
							
							if( data['chart1'].length > 0 ){
								$( '#chart1' ).css('margin-bottom',50);
								try {
									draw_chart(op, 1, data, 'chart1', '<?php echo $this->translation->Translation_key("Period sales", $_SESSION['lang_u']);?>', 'periodo', 'valor');
								}
								catch(err) {
								}
							}
							else
							{
								$( '#chart1' ).text( '' );
								$( '#chart1' ).height(0);
							}
							
							if( data['chart2'].length > 0 ) {
								if (ag==1){
									$( '#chart2' ).css('margin-bottom',50);
									try {
										draw_chart(op, 1, data, 'chart2', '<?php echo $this->translation->Translation_key("Period fees", $_SESSION['lang_u']);?>', 'periodo', 'valor');
									}
									catch(err) {
									}
								}
								else {
									$( '#chart2' ).css('margin-bottom',50);
									try {
										draw_chart(op, 1, data, 'chart2', '<?php echo $this->translation->Translation_key("Period fee payment", $_SESSION['lang_u']);?>', 'periodo', 'valor');
									}
									catch(err) {
									}
								}
							}
							else
							{
								$( '#chart2' ).text( '' );
								$( '#chart2' ).height(0);
							}
								
							if( data['chart3'].length > 0 ) {
								if (ag==1){
									try {
										draw_chart(op, 1, data, 'chart3', '<?php echo $this->translation->Translation_key("Period cash sales to reimburse", $_SESSION['lang_u']);?>', 'periodo', 'valor');
									}
									catch(err) {
									}
									
								}
								else {
									try {
										draw_chart(op, 1, data, 'chart3', '<?php echo $this->translation->Translation_key("Period transaction fee payment", $_SESSION['lang_u']);?>', 'periodo', 'valor');
									}
									catch(err) {
									}
									
								}
							}
							else
							{
								$( '#chart3' ).text( '' );
								$( '#chart3' ).height(0);
							}
								
							if( data['chart4'].length > 0 ){
								try {
									draw_chart(op, 2, data, 'chart4', '<?php echo $this->translation->Translation_key("Period sales by ticket type", $_SESSION['lang_u']);?>', 'tipo', 'valor');
								}
								catch(err) {
								}
								
							}
							else{
								$( '#chart4' ).text('');
								$( '#chart4' ).height(0);
							}
						}
						
						if( !data['chart1'].length > 0  && !data['chart2'].length > 0  && !data['chart3'].length > 0  && !data['chart4'].length > 0 ){
							$( "#no_data" ).show();
						}
						
						$(".loading-overlay").hide();
					}
				});
			}		
			function draw_chart(op, type, data, id, title, xlabel, ylabel) {
				switch(type) {					
					case 1:
						var s1 = [];
						var ticks = [];
						var inti = new Array();
						$.jqplot.config.enablePlugins = true;
		
						inti.push([0]);
						$.jqplot(id, inti, null).destroy();			
						
						jQuery.each( data[id], function( i, val ) {
							ticks.push(val[xlabel]);  
							s1.push(parseFloat(val[ylabel])); 
						});
										
						var plot1 = $.jqplot(id, [s1], {
							title: '<b>'+title+'</b>',
							animate: !$.jqplot.use_excanvas,
							seriesDefaults:{
								renderer:$.jqplot.BarRenderer,
								pointLabels: { show: true }
							},
							axes: {
								xaxis: {
									renderer: $.jqplot.CategoryAxisRenderer,
									ticks: ticks
								}
							},
							highlighter: { show: false }
						});
					break;
					
					case 2:
						var s1 = []
						var s2 = []

						var ticks = [];
						var inti = new Array();
						$.jqplot.config.enablePlugins = true;
		
						inti.push([0]);
						$.jqplot(id, inti, null).destroy();			
						
						jQuery.each( data[id], function( i, val ) {						
							s2.push([val[xlabel], parseFloat(val[ylabel])]); 
							
						});
						s1.push(s2); 

						var plot1 = $.jqplot(id, s1, {
							title: '<b>'+title+'</b>',
							animate: !$.jqplot.use_excanvas,
							seriesDefaults:{
								renderer:$.jqplot.PieRenderer, 
								trendline:{ show:false }, 
								rendererOptions: { showDataLabels: true, sliceMargin: 8}
							},
							legend:{
								show:true, 
								rendererOptions: {
									numberRows: 10
								}, 
								location:'e',
								marginTop: '25px'
								
							},
							highlighter: { show: true }							
						});
					break;
					
					default:
					break;
				}
			}
		</script>
		<script type="text/javascript" src="<?php echo base_url(); ?>jqplot/jquery.jqplot.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>jqplot/plugins/jqplot.canvasTextRenderer.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>jqplot/plugins/jqplot.canvasAxisLabelRenderer.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>jqplot/plugins/jqplot.barRenderer.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>jqplot/plugins/jqplot.pieRenderer.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>jqplot/plugins/jqplot.categoryAxisRenderer.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>jqplot/plugins/jqplot.dateAxisRenderer.js"></script>

		<script type="text/javascript" src="<?php echo base_url(); ?>jqplot/plugins/jqplot.pointLabels.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>jqplot/jquery.jqplot.css" />
	</div>
</div>