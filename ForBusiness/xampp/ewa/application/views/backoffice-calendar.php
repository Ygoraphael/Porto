<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="clearfix page-head col-md-12">
	<h3 class="pull-left"></h3>
	<div class="pull-right form-inline">
		<div class="btn-group">
			<button class="btn btn-primary" data-calendar-nav="prev"><< <?php echo $this->translation->Translation_key("Previous", $_SESSION['lang_u']); ?></button>
			<button class="btn" data-calendar-nav="today"><?php echo $this->translation->Translation_key("Today", $_SESSION['lang_u']); ?></button>
			<button class="btn btn-primary" data-calendar-nav="next"><?php echo $this->translation->Translation_key("Next", $_SESSION['lang_u']); ?> >></button>
		</div>
		<div class="btn-group">
			<button class="btn btn-warning" data-calendar-view="year"><?php echo $this->translation->Translation_key("Year", $_SESSION['lang_u']); ?></button>
			<button class="btn btn-warning active" data-calendar-view="month"><?php echo $this->translation->Translation_key("Month", $_SESSION['lang_u']); ?></button>
			<button class="btn btn-warning" data-calendar-view="week"><?php echo $this->translation->Translation_key("Week", $_SESSION['lang_u']); ?></button>
			<button class="btn btn-warning" data-calendar-view="day"><?php echo $this->translation->Translation_key("Day", $_SESSION['lang_u']); ?></button>
		</div>
	</div>
</div>
<div class="main-content col-sm-12">
	<form action="#" class="form-horizontal group-border-dashed clearfix" >
		<div class="form-group">
			<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Product", $_SESSION['lang_u']); ?></label>
			<div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
				<select class="form-control" id="prod" name="">
					<option value=""></option>
					<?php foreach($products as $product) { ?>
					<option value="<?php echo $product["bostamp"]; ?>"><?php echo $product["u_name"]; ?></option>
					<?php } ?>
				</select>
			</div>
			<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Session", $_SESSION['lang_u']); ?></label>
			<div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
				<select class="form-control" id="sess" name="">
					<option value=""></option>
				</select>
			</div>
		</div>
	</form>
</div>
<div class="main-content col-sm-12">
	<div class="panel panel-default">
		<div id="calendar"></div>
		<script src="<?php echo base_url(); ?>js/bo/calendar.js"></script>
		<script src="<?php echo base_url(); ?>js/bo/underscore-min.js"></script>
		<script type="text/javascript">
			var calendar;
			
			function calendar_init() {
				calendar = $('#calendar').calendar({
					tmpl_path: "<?php echo base_url() ?>tmpls/",
					events_source: '<?php echo base_url() ?>backoffice/ajax/get_calendar',
					tmpl_cache: false,
					onAfterViewLoad: function(view) {
						$('.page-head h3').text(this.getTitle());
						$('.btn-group button').removeClass('active');
						$('button[data-calendar-view="' + view + '"]').addClass('active');
					},
					time_start: '00:00',
					time_end: '24:00',
					time_split: '30'
				});
			}
			
			$('.btn-group button[data-calendar-nav]').each(function() {
				var $this = $(this);
				$this.click(function() {
				calendar.navigate($this.data('calendar-nav'));
				});
			});

			$('.btn-group button[data-calendar-view]').each(function() {
				var $this = $(this);
				$this.click(function() {
				calendar.view($this.data('calendar-view'));
				});
			});
			
			jQuery("#prod").change(function() {
				$(".loading-overlay").show();
				
				jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>backoffice/ajax/get_product_session",
					data: { 
						"bostamp" : jQuery(this).val()
					},
					success: function(data) 
					{
						jQuery("#sess").find('option').remove();
						$('#sess').append($('<option>', {
							value: "",
							text: ""
						}));
						data = JSON.parse(data);
						data.forEach(function(entry) {
							$('#sess').append($('<option>', {
								value: entry['u_psessstamp'],
								text: entry['ihour']
							}));
						});
						
						calendar_init();
						
						$(".loading-overlay").hide();
					}
				});
			});
			
			jQuery("#sess").change(function() {
				$(".loading-overlay").show();
				calendar_init();
				$(".loading-overlay").hide();
			});
			
			jQuery(document).ready(function() {
				calendar_init();
			});
		</script>
	</div>
</div>