<!DOCTYPE HTML>
<html>
    <?php $this->load->view("header.php"); ?> 
    <!--Logo PSF-->	
    <body>
    <body>
		<div class="col-lg-10 main-page">
				<div class="stats-ponto4 ">
					<h5><?php echo $la = lang('Add_number_of_tasks_done'); ?></h5>
					<form action="<?php echo base_url(); ?>ponto/add_product2" method="POST">
					<div class="input-group">
					  <span class="input-group-btn">
						  <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="qtt">
							<span class="glyphicon glyphicon-minus"></span>
						  </button>
					  </span>
					  <input type="text" name="qtt" class="form-control input-number" value="<?php echo $qtt; ?>" min="1" max="999" pattern="[0-9]*" required>
					  <span class="input-group-btn">
						  <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="qtt">
							  <span class="glyphicon glyphicon-plus"></span>
						  </button>
					  </span>
					</div>
					<div class="col-lg-12"  style="margin-top:25px;">
						<button onClick="parent.jQuery.fancybox.close();" class="btn_cart2  fancybox fancybox.iframe" data-toggle="modal" data-target="#popup"><i class="fa fa-caret-square-o-left" aria-hidden="true" style="font-size:46px;color:white"></i></button>
						<button type="submit" class="btn_cart fancybox fancybox.iframe" data-toggle="modal" data-target="#popup" onclick="parent.jQuery.fancybox.close()"><i class="fa fa-check-square-o" style="font-size:46px;color:white"></i></button>
					<div class="clearfix"></div>	
					</div>
					<input type="hidden" name="stfamistamp"  value="<?php echo $tarefastamp; ?>" >
					<input type="hidden" name="ststamp"  value="<?php echo $ststamp; ?>" >
				</form>
				</div>
			</div>	
<script type="text/javascript">
//plugin bootstrap minus and plus
//http://jsfiddle.net/laelitenetwork/puJ6G/
$('.btn-number').click(function(e){
    e.preventDefault();
    
    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            } 
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {
    
    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());
    
    name = $(this).attr('name');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    
    
});
$(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
</script>		
    </body>
</html>

<style>




.btn-number{
	color: #fff;
	width: 40px;
	height: 63px;
	line-height: 30px;
	font-size: 14px;
	font-weight: bold;
	text-align: center;
	cursor: pointer;
	
}
.input-group{
	width: 140px;
	margin: 10px auto;
}

.input-number{
	font-size: 25px;
	width: 40px;
	height: 63px;
}

</style>
