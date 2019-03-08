<div id="sticky-anchor"></div>
<div class="col-lg-12 calendar-top-container">	
	<div class="col-lg-12 calendar-top-title calendar-title1">
		<span class="calendar-top-title-pos">1</span><b>Select date</b>
	</div>
	<div class="col-lg-12 calendar_div">
		<div id="calendar_place"></div>
	</div>
	
	<div class="col-lg-12 calendar-top-title calendar-title2">
		<span class="calendar-top-title-pos">2</span><b>Select time</b>
	</div>
	<div class="col-lg-12 calendar-time-div">
		<span class="clearfix"><b>Select a starting time:</b></span>
		<div class="calendar-time-div-container"></div>
	</div>
	
	<div class="col-lg-12 calendar-top-title calendar-title3">
		<span class="calendar-top-title-pos">3</span><b>Select participants <?php echo (sizeof($extras)>0) ? "& optional extras" : ""; ?></b>
	</div>
	<div class="col-lg-12 calendar-price" style="margin-top:15px;">
		<form class="form-horizontal">
			<?php
				foreach ($tickets as $ticket) {
			?>
				<div class="form-group">
					<label for="category" class="col-sm-4 control-label"><?php echo $ticket["name"]; ?></label>
					<div class="col-sm-8">
						<div class="input-group">
							<span class="input-group-btn">
								<button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="<?php echo $ticket["ticket"]; ?>">
									<span class="glyphicon glyphicon-minus"></span>
								</button>
							</span>
							<input type="text" onchange="update_lotation(jQuery(this))" name="<?php echo $ticket["ticket"]; ?>" class="form-control input-number calendar-cat-picker" value="0" min="0" max="99">
							<span class="input-group-btn">
								<button type="button" class="btn btn-default btn-number" data-type="plus" data-field="<?php echo $ticket["ticket"]; ?>">
									<span class="glyphicon glyphicon-plus"></span>
								</button>
							</span>
						</div>
					</div>
				</div>
			<?php
				}
			?>
			<?php
				if( sizeof($extras) ) {
			?>
				<div class="form-group">
					<div class="text-left col-sm-12"><b>Optional Extras</b></div>
				</div>
			<?php
					foreach ($extras as $extra) {
			?>
					<div class="form-group">
						<label for="category" class="col-sm-4 control-label"><?php echo $extra["design"]; ?> <small>(€<?php echo number_format($extra["price"], 2, '.', ''); ?>)</small></label>
						<div class="col-sm-8">
							<div class="input-group">
								<span class="input-group-btn">
									<button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="<?php echo $extra["ref"]; ?>">
										<span class="glyphicon glyphicon-minus"></span>
									</button>
								</span>
								<input type="text" onchange="update_lotation(jQuery(this), 1)" name="<?php echo $extra["ref"]; ?>" design="<?php echo $extra["design"]; ?>" price="<?php echo number_format($extra["price"], 2, '.', ''); ?>" class="form-control input-number calendar-extra-picker text-center" value="0" min="0" max="<?php echo ($extra["varbilh"]) ? "99" : "1"; ?>">
								<span class="input-group-btn">
									<button type="button" class="btn btn-default btn-number" data-type="plus" data-field="<?php echo $extra["ref"]; ?>">
										<span class="glyphicon glyphicon-plus"></span>
									</button>
								</span>
							</div>
						</div>
					</div>
			<?php
					}
				}
			?>
		</form>
	</div>
	<div class="col-lg-12 calendar-total" style="margin-top:15px;">
		<div class="price-breakdown-container">	<p class="price-breakdown-title">Price Breakdown</p>
			<div class="price-details price-details-line">
			</div>
			<div class="price-details" style="margin-top:15px;">
				<div class="calendar-price-total clearfix">
					<span class="price-total pull-right">TOTAL PRICE: <b></b></span>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-lg-12 calendar-but-3" style="margin:15px 0px;">
		<a onclick="calendar_page(2);" class="btn btn-primary">Back</a>
		<a onclick="checkout();" class="btn btn-primary btn-checkout">BUY NOW</a>
	</div>
	<div class="col-lg-12 calendar-but-1" style="margin:15px 0px;">
		<a onclick="calendar_page(2);" class="btn btn-primary">Continue</a>
	</div>
	<div class="col-lg-12" style="margin:15px 0px;">
		<a onclick="calendar_page(1);" style="display:none;" class="btn btn-primary calendar-but-2-1">Back</a>
		<a onclick="calendar_page(3);" style="display:none;" class="btn btn-primary calendar-but-2-2">Continue</a>
	</div>
	
	<div class="col-lg-12" style="margin:15px 0px;">
		BEST PRICE GUARANTEED
	</div>
	<form method="POST" id="checkout_form" action="<?php echo base_url(); ?>checkout">
		<input type="hidden" name="reservation_type" />
		<input type="hidden" name="reservation_data" />
		<input type="hidden" name="reservation_date" />
		<input type="hidden" name="reservation_session" />
		<input type="hidden" name="reservation_bostamp" />
	</form>
	
	<script>
		var max_lotation = 0;
		var cur_lotation = 0;
		
		jQuery(document).ready(function() {
			calendar_bic('<?php echo $row["bostamp"]; ?>');
			bind_day_event();
			calendar_page(1);
		});
		
		function update_lotation( input, onlyprices = 0 ) {
			if( !onlyprices ) {
				var lot_total = 0;
				
				$('.calendar-cat-picker').each(function(i, obj) {
					lot_total += parseFloat( jQuery(this).val() );
				});
				
				$('.calendar-cat-picker').each(function(i, obj) {
					if( input.attr("name") != jQuery(this).attr("name") ) {
						jQuery(this).attr("max", (parseFloat(jQuery(this).val()) + max_lotation - cur_lotation - lot_total));
						
						if( parseFloat(jQuery(this).attr("max")) == parseFloat(jQuery(this).val()) )
							jQuery('.btn-number[data-type="plus"][data-field="'+jQuery(this).attr("name")+'"]').attr("disabled", "disabled");
						else
							jQuery('.btn-number[data-type="plus"][data-field="'+jQuery(this).attr("name")+'"]').removeAttr("disabled");
					}
				});
			}
			
			var html = '';
			var price_total = 0;
			
			jQuery('.calendar-cat-picker').each(function(i, obj) {
				var tam = jQuery(this).attr("name");
				var qtt = parseFloat(jQuery(this).val()).toFixed(2);
				var price = parseFloat(jQuery(this).attr("price")).toFixed(2);
				if( jQuery(this).val() > 0 ){
					html+= '<div class="price-category clearfix"><span class="price-cat pull-left">' + tam + '</span><span class="price-qtt pull-left">' + qtt + ' x €' + price + '</span>';
					html+= '<span class="price-total pull-right">€' + parseFloat(qtt*price).toFixed(2) + '</span></div>';
				}
				price_total += (qtt*price);
			});
			
			jQuery.each( jQuery( ".calendar-extra-picker" ), function( i, val ) {
				if( jQuery(this).val() > 0 )
				{
					html+= '<div class="price-category clearfix"><span class="price-cat pull-left">' + jQuery(this).attr("design") + '</span><span class="price-qtt pull-left">' + jQuery(this).val() + ' x €' + jQuery(this).attr("price") + '</span>';
					html+= '<span class="price-total pull-right">€' + parseFloat(jQuery(this).val()*jQuery(this).attr("price")).toFixed(2) + '</span></div>';
					
					price_total += (jQuery(this).val()*jQuery(this).attr("price"));
				}	
			});
			
			$(".price-details-line").html(html);
			$(".price-total b").html("€" + parseFloat(price_total).toFixed(2));
			
			if( parseFloat(price_total) > 0 ) {
				jQuery( ".btn-checkout" ).css("display", "inline-block");
			}
			else {
				jQuery( ".btn-checkout" ).css("display", "none");
			}
		}
		
		function checkout() {
			var res_data = new Array();
			var res_date = $(".day.selected").attr("data-date");
			var res_session = $(".calendar-time-picker").val();
			
			$( ".calendar-cat-picker" ).each(function() {
				var seat = 'ND';
				var type = jQuery(this).attr("name");
				var qtt = jQuery(this).val();
				
				if( type.trim().length > 0 && qtt > 0) {
					var tmp_res_seats = new Array();
					tmp_res_seats.push( seat.trim() );
					tmp_res_seats.push( type.trim() );
					tmp_res_seats.push( qtt );
					tmp_res_seats.push( 0 );
					res_data.push( tmp_res_seats );
				}
			});
			
			$( ".calendar-extra-picker" ).each(function() {
				var seat = jQuery(this).attr("price");
				var type = jQuery(this).attr("name");
				var qtt = jQuery(this).val();
				
				if( type.trim().length > 0 && qtt > 0) {
					var tmp_res_seats = new Array();
					tmp_res_seats.push( seat.trim() );
					tmp_res_seats.push( type.trim() );
					tmp_res_seats.push( qtt );
					tmp_res_seats.push( 1 );
					res_data.push( tmp_res_seats );
				}
			});
			
			jQuery("input[name='reservation_data']").val( JSON.stringify(res_data) );
			jQuery("input[name='reservation_type']").val( 'tickets' );
			jQuery("input[name='reservation_date']").val( res_date );
			jQuery("input[name='reservation_session']").val( res_session );
			jQuery("input[name='reservation_bostamp']").val( '<?php echo $row["bostamp"]; ?>' );
			$( "#checkout_form" ).submit();
		}
		
		function bind_day_event() {
			$(document).on('click','.day', function(e)
			{
				if(!$(this).hasClass("event_tooltip"))
				{
					var data = $(this).attr("data-date");
					if($(this).hasClass("selected"))
					{
						$(".selected").each(function(){$(this).removeClass("selected")});
						$(this).removeClass("selected");
						jQuery(".calendar-but-1").css("display", "none");
					}
					else
					{
						$(".selected").each(function(){$(this).removeClass("selected")});
						$(this).addClass("selected");
						jQuery(".calendar-but-1").css("display", "inline");
					}
				}
			});
		}
		
		function calendar_bic(event_id) {
			var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
			var dayNames = ["M", "T", "W", "T", "F", "S", "S"];

			$('#calendar_place').bic_calendar({
				ending_month: 12,
				enableSelect: false,
				multiSelect: false,
				dayNames: dayNames,
				monthNames: monthNames,
				showDays: true,
				displayMonthController: true,
				displayYearController: true,                                
				reqAjax: {
					type: 'get',
					url: '<?php echo base_url(); ?>calendar?event='+event_id
				}
			});
		}
		
		$('.btn-number').click(function(e) {
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
				$(this).val($(this).data('oldValue'));
			}
			if(valueCurrent <= maxValue) {
				$(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
			} else {
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
		
		function update_prices() {
			$(".calendar-top-container").LoadingOverlay("show");
			var product = '<?php echo $row["bostamp"]; ?>';
			var datedata = $(".day.selected").attr("data-date");
			var session = $(".calendar-time-picker").val();
			
			$.ajax({
				method : 'GET',
				data : {date:datedata},
				datatype: "json",
				url: '<?php echo base_url(); ?>calendar/prices?event='+product+'&session='+session,
				success : function(result){
					try
					{
						var parse = JSON.parse(result);
						
						if(parse.length>0)
						{
							for(p in parse)
							{
								var preco = parse[p];
								jQuery(".calendar-cat-picker[name=" + preco["tam"].toString().trim() + "]").attr("price", parseFloat(preco["epv1"]).toFixed(2));
							}

							$(".calendar-top-container").LoadingOverlay("show");
							$.ajax({
								method : 'GET',
								data : {date:datedata},
								datatype: "json",
								url: '<?php echo base_url(); ?>calendar/maxlotation?event='+product+'&session='+session+'&op='+<?php echo $row["no"]; ?>,
								success : function(result){
									try
									{
										var parse = JSON.parse(result);
										cur_lotation = parseFloat(parse["current_lotation"]);
										max_lotation = parseFloat(parse["lotation"]);
										
										$('.calendar-cat-picker').each(function(i, obj) {
											jQuery(this).attr("max", max_lotation - cur_lotation);
											jQuery('.btn-number[data-type="plus"]').removeAttr("disabled");
											jQuery(this).val(0);

											if( parseFloat(jQuery(this).attr("max")) == parseFloat(jQuery(this).val()) ) {
												jQuery('.btn-number[data-type="plus"][data-field="'+jQuery(this).attr("name")+'"]').attr("disabled", "disabled");
											}
										});
										
										$('.calendar-extra-picker').each(function(i, obj) {
											jQuery(this).attr("max", max_lotation - cur_lotation);
											jQuery('.btn-number[data-type="plus"]').removeAttr("disabled");
											jQuery(this).val(0);

											if( parseFloat(jQuery(this).attr("max")) == parseFloat(jQuery(this).val()) ) {
												jQuery('.btn-number[data-type="plus"][data-field="'+jQuery(this).attr("name")+'"]').attr("disabled", "disabled");
											}
										});
										
										jQuery( ".calendar-but-2-2" ).css("display", "inline");
										$(".calendar-top-container").LoadingOverlay("hide");
									}   
									catch(e)
									{
										$(".calendar-top-container").LoadingOverlay("hide");
									}
									
								},
								error: function (xhr, ajaxOptions, thrownError) {
									$(".calendar-top-container").LoadingOverlay("hide");
								}
							});
						}
						else {
							jQuery( ".calendar-but-2-2" ).css("display", "none");
						}

						$(".calendar-top-container").LoadingOverlay("hide");
					}   
					catch(e)
					{
						$(".calendar-top-container").LoadingOverlay("hide");
					}
					
				},
				error: function (xhr, ajaxOptions, thrownError) {
					$(".calendar-top-container").LoadingOverlay("hide");
				}
			});
		}
		
		function update_hours() {
			$(".calendar-top-container").LoadingOverlay("show");
			var product = '<?php echo $row["bostamp"]; ?>';
			var data = $(".day.selected").attr("data-date");
			$.ajax({
				method : 'GET',
				data : {date:data},
				datatype: "json",
				url: '<?php echo base_url(); ?>calendar/session?event='+product,
				success : function(data){
					try
					{
						var parse = JSON.parse(data);

						var html = '<select onchange="update_prices();" class="calendar-time-picker clearfix form-control"><option></option>';
						if(parse.length>0)
						{
							for(p in parse)
							{
								var id = parse[p]["id"];
								var sess = parse[p]["ihour"];
								
								html+='<option value="'+id+'">'+sess+'</option>';
							}
						}
						html+='</select>';
						$(".calendar-time-div-container").html(html);
						$(".price-details-line").html("");
						$(".price-total b").html("");
						$(".calendar-top-container").LoadingOverlay("hide");
					}   
					catch(e)
					{
						$(".calendar-top-container").LoadingOverlay("hide");
					}
					
				},
				error: function (xhr, ajaxOptions, thrownError) {
					$(".calendar-top-container").LoadingOverlay("hide");
				}
			});
		}
		
		function calendar_page(page) {
			if( page == 1 ) {
				jQuery(".calendar-title1").css("display", "inline");
				jQuery(".calendar-title2").css("display", "none");
				jQuery(".calendar-title3").css("display", "none");
				jQuery(".calendar_div").css("display", "inline");
				jQuery(".calendar-price").css("display", "none");
				jQuery(".calendar-time-div").css("display", "none");
				jQuery(".calendar-but-1").css("display", "none");
				$(".day").each(function(){
					if($(this).hasClass("selected"))
					{
						jQuery(".calendar-but-1").css("display", "inline");
					}
				});
				jQuery(".calendar-but-2-1").css("display", "none");
				jQuery(".calendar-but-2-2").css("display", "none");
				jQuery(".calendar-but-3").css("display", "none");
				jQuery(".calendar-total").css("display", "none");
			}
			else if( page == 2 ) {
				jQuery(".calendar-title1").css("display", "none");
				jQuery(".calendar-title2").css("display", "inline");
				jQuery(".calendar-title3").css("display", "none");
				jQuery(".calendar_div").css("display", "none");
				jQuery(".calendar-price").css("display", "none");
				jQuery(".calendar-time-div").css("display", "inline");
				jQuery(".calendar-but-1").css("display", "none");
				jQuery(".calendar-but-2-1").css("display", "inline");
				jQuery(".calendar-but-2-2").css("display", "none");
				jQuery(".calendar-but-2").css("display", "inline");
				jQuery(".calendar-but-3").css("display", "none");
				jQuery(".calendar-total").css("display", "none");
				//carregar sessoes
				update_hours();
			}
			else if( page == 3 ) {
				//iniciar processamento
				$(".calendar-top-container").LoadingOverlay("show");
				jQuery(".calendar-title1").css("display", "none");
				jQuery(".calendar-title2").css("display", "none");
				jQuery(".calendar-title3").css("display", "inline");
				jQuery(".calendar_div").css("display", "none");
				jQuery(".calendar-price").css("display", "inline");
				jQuery(".calendar-time-div").css("display", "none");
				jQuery(".calendar-but-1").css("display", "none");
				jQuery(".calendar-but-2").css("display", "none");
				jQuery(".calendar-but-2-1").css("display", "none");
				jQuery(".calendar-but-2-2").css("display", "none");
				jQuery(".calendar-but-3").css("display", "inline");
				jQuery(".calendar-total").css("display", "inline");
				jQuery(".btn-checkout").css("display", "none");
				
				//finalizar processamento
				$(".calendar-top-container").LoadingOverlay("hide");
			}
		}
			
		//$('.calendar-top-container').css({'position': 'fixed','top': '100px','width': '380px','z-index': '10000'}); 
		 var h = $('.product_height').height();
		 var g = $('.calendar-top-container').height();
		 $('#sticky-anchor').css('max-height', h-g);
		function sticky_relocate() {
			var window_top = $(window).scrollTop();
			var div_top = $('#sticky-anchor').offset().top - 115;
			if (window_top > div_top) {
				$('.calendar-top-container').addClass('stick');
				$('#sticky-anchor').height(window_top - div_top);
			} else {
				$('.calendar-top-container').removeClass('stick');
				$('#sticky-anchor').height(0);
			}
		}

		$(function() {
			//$(window).scroll(sticky_relocate);
			//sticky_relocate();
		});
		window.onscroll = function() {scrollFunction()};

			function scrollFunction() {
				if (document.body.scrollTop >$(".calendar-top-container").offset().top-100|| document.documentElement.scrollTop > 20) {
					document.getElementById("myBtn").style.display = "block";
				} else {
					document.getElementById("myBtn").style.display = "none";
				}
			}

			// When the user clicks on the button, scroll to the top of the document
			function topFunction() {
				$('html, body').animate({
					scrollTop: $(".calendar-top-container").offset().top-100
				}, 1000);
			}
	</script>

</div>
<iframe style="margin-top:30px; width: 100%; height:250px;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?php echo $product[0]['u_latitude']?>,<?php echo $product[0]['u_longitud']?>&hl=es;z=14&amp;output=embed"></iframe>
<button onclick="topFunction()" id="myBtn" title="Go to">Book Now</button>

<style>
#myBtn {
    display: none; /* Hidden by default */
    position: fixed; /* Fixed/sticky position */
    bottom: 20px; /* Place the button at the bottom of the page */
    right: 30px; /* Place the button 30px from the right */
    z-index: 99; /* Make sure it does not overlap */
    border: none; /* Remove borders */
    outline: none; /* Remove outline */
    background: #1b2a33;
	color: white;	
	cursor: pointer; /* Add a mouse pointer on hover */
    padding: 15px; /* Some padding */
    box-shadow: 0 0 0 3px #86754d;
    border-radius: 4px;
}

#myBtn:hover {
    background-color: #555; /* Add a dark-grey background on hover */
}

.calendar-top-container .stick {
    margin-top: 0 !important;
    position: fixed;
    top: 0;
	width: 380px;
    z-index: 10000;
    border-radius: 0 0 0.5em 0.5em;
}
</style>