<!DOCTYPE HTML>
<html>
    <?php $this->load->view("header.php"); ?> 
    <!--Logo PSF-->	
    <body>
		<div class="col-lg-offset-1 col-lg-10 main-page">
			<div class="col-lg-12 " >
				<div class="pop-up_error " style="height=auto; width:100%;" >
					<h4><?php echo $la = lang('You_have_not_added_any_tasks'); ?></h4>
					<h4><?php echo $la = lang('Please'); ?></h4>
					<h4><?php echo $la = lang('Add_a_task_to_continue'); ?></h4>
				</div>
				<div class="clearfix"></div>	
			</div>
		</div>
	</body>	
</html>
<style>

    input {
        font-size: 2em;
        color: #fff;
        margin-top: 5px;
    }
</style>
