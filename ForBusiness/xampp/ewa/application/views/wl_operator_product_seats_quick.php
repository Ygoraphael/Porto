<div id="sticky-anchor" class="hide"></div>
<div class="col-lg-12 noleftrightmargin" id="seat_buy">
	<div class="col-lg-12 calendar-top-container noleftrightmargin">
		<div class="calendar-title3 text-center">
			<h3 class="card-header white-text"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Select seats'); ?></h3>
		</div>

		<div class="col-lg-12 calendar-price noleftrightmargin" style="margin-top:15px; padding-bottom:15px; ">
			<div id="seat-map" class="seatCharts-container" tabindex="0" aria-activedescendant="9_1">
				<?php
					$num_lug_max = 0;
					$lugares_linhas = explode("\n", $row["u_seatdisp"]);
					foreach( $lugares_linhas as $lug_linha ) {
						$lugares = explode("|", $lug_linha);
						echo '<div class="seatCharts-row">';
						$lug_tmp = 0;
						foreach( $lugares as $lugar) {
							if( strlen(trim($lugar)) > 0 )
								echo '<div id="lug_' . trim($lugar) . '" role="checkbox" aria-checked="false" focusable="true" tabindex="-1" class="seatCharts-seat seatCharts-cell available">' . trim($lugar) . '</div>';
							else
								echo '<div class="seatCharts-cell seatCharts-space"></div>';
							$lug_tmp++;
						}
						if ($lug_tmp > $num_lug_max) {
							$num_lug_max = $lug_tmp;
						}
						echo '</div>';
					}
				?>
			</div>
			<style>
				div.seatCharts-container { width:<?php echo ($num_lug_max*20) + ($num_lug_max*6); ?>px; margin-left:auto; margin-right:auto; }
			</style>
		</div>
		<div class="col-lg-12 noleftrightmargin">
			<div class="col-lg-12">
				<div id="seat-tickets" class="seat-tickets-container">
					<form class="form-horizontal">
					</form>
					<?php
						if( sizeof($extras) ) {
					?>
						<div class="form-horizontal">
							<div class="form-group">
								<div class="text-left col-sm-12"><b><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Optional Extras'); ?></b></div>
							</div>
					<?php
							foreach ($extras as $extra) {
					?>
							<div class="form-group">
								<label for="category" class="col-sm-4 control-label"><?php echo $extra["design"]; ?> <small>(<i class="fa"><?php echo $_SESSION["i"];?></i><?php echo number_format($extra["price"], 2, '.', ''); ?>)</small></label>
								<div class="col-sm-8">
									<div class="input-group">
										<span class="input-group-btn">
											<button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="<?php echo $extra["ref"]; ?>">
												<span class="glyphicon glyphicon-minus"></span>
											</button>
										</span>
										<input onchange="update_prices_seats()" type="text" name="<?php echo $extra["ref"]; ?>" design="<?php echo $extra["design"]; ?>" price="<?php echo number_format($extra["price"], 2, '.', ''); ?>" class="form-control input-number calendar-extra-picker text-center" value="0" min="0" max="<?php echo ($extra["varbilh"]) ? "99" : "1"; ?>">
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
					?>
						</div>
					<?php
						}
						if( sizeof($pickups) ) {
						?>
							<div class="form-group">
								<label for="pickup" class="col-sm-4 control-label" style="padding-top: 9px;"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'PICKUP'); ?></label>
								<div class="col-sm-8">
									<div class="input-group">
										<select class="form-control" id="pickup">
											<option value="" disabled="" selected=""><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'SELECT PICKUP'); ?></option>
											<?php
											foreach ($pickups as $pickup) {
											?>
												<option value="<?php echo $pickup['u_pickupstamp']; ?>"><?php echo $this->googletranslate->translate($_SESSION["language_code"], $pickup['name']); ?></option>
											<?php 
											}
											?>	
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="pickup" class="col-sm-4 control-label" style="padding-top: 9px;"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'ROOM'); ?></label>
								<div class="col-sm-8">
									<div class="input-group col-sm-12">
										<input type="text" class="form-control" id="room" />
									</div>
								</div>
							</div>
							<?php
						}
						if( sizeof($planguages) ) {
						?>
							<div class="form-group">
								<label for="language" class="col-sm-4 control-label" style="padding-top: 9px;"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'LANGUAGE'); ?></label>
								<div class="col-sm-8">
									<div class="input-group col-sm-12">
										<select class="form-control" id="language">
											<option value="" disabled="" selected=""><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'SELECT LANGUAGE'); ?></option>
											<?php
											foreach ($planguages as $planguage) {
											?>
												<option value="<?php echo $planguage['code']; ?>"><?php echo $planguage['language']; ?></option>
											<?php 
											}
											?>	
										</select>
									</div>
								</div>
							</div>
							<?php
						}
					?>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="col-lg-12 calendar-total" style="margin-top:15px;">
					<div class="price-breakdown-container">
						<div class="price-details price-details-line">
						</div>
						<div class="price-details" style="margin-top:15px;">
							<div class="calendar-price-total clearfix">
								<span class="price-total pull-right"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'TOTAL PRICE'); ?>: <b></b></span>
							</div>
						</div>
					</div>
					<div class="col-lg-12 bestprice" style="margin:15px 0px;">
						<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'BEST PRICE GUARANTEED'); ?>
					</div>
				</div>
			</div>
		</div>
		<form method="POST" id="checkout_form" action="<?php echo base_url(); ?>wl/<?php echo $op; ?>/checkout">
			<input type="hidden" name="reservation_type" />
			<input type="hidden" name="reservation_data" />
			<input type="hidden" name="reservation_date" />
			<input type="hidden" name="reservation_session" />
			<input type="hidden" name="reservation_bostamp" />
			<input type="hidden" name="reservation_room" />
			<input type="hidden" name="reservation_pickup" />
			<input type="hidden" name="reservation_language" />
		</form>
		<div class="col-lg-12 calendar-time-div">
			<span class="clearfix"><b><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Select a starting time'); ?>:</b></span>
			<div class="calendar-time-div-container"></div>
		</div>
		<div class="col-lg-12 calendar-but-1" style="margin:15px 0px;">
			<a onclick="calendar_page(2);" class="btn btn-primary"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Continue'); ?></a>
		</div>
		<div class="col-lg-12" style="margin:15px 0px;">
			<a onclick="calendar_page(1);" style="display:none;" class="btn btn-primary calendar-but-2-1"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Go Back'); ?></a>
			<a onclick="calendar_page(3);" style="display:none;" class="btn btn-primary calendar-but-2"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Continue'); ?></a>
		</div>
		<div class="col-lg-12 calendar-but-3" style="margin:15px 0px;">
			<a onclick="calendar_page(2);" class="btn btn-primary"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Go Back'); ?></a>
			<a onclick="checkout();" class="btn btn-primary"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'BUY NOW'); ?></a>
		</div>
		<script>
			jQuery(".seatCharts-cell").hover(
				function() {
					if( $( this ).hasClass("available") ) {
						$( this ).addClass( "focused" );
					}
				}, function() {
					if( $( this ).hasClass("available") ) {
						$( this ).removeClass( "focused" );
					}
				}
			);
			
			jQuery(".seatCharts-cell").click(function() {
				if( $( this ).hasClass("available") ) {
					if( $( this ).hasClass("selected") ) {
						$( this ).removeClass( "selected" );
						var seat = $( this ).attr("id");
						seat = seat.replace("lug_", "").trim();
						jQuery(".seat-sel[seat='" + seat + "']").parent().parent().remove();
						update_prices_seats();
					}
					else {
						$( this ).addClass( "selected" );
						
						//get tickets
						var product = '<?php echo $row["bostamp"]; ?>';
						var data = '<?php echo date("n/j/Y"); ?>';
						var session = '';
						var seat = $( this ).attr("id");
						$.ajax({
							method : 'GET',
							data : {date:data},
							datatype: "json",
							url: '<?php echo base_url(); ?>calendar/seat_tickets?event='+product+'&session='+session+'&seat='+seat,
							success : function(data){
								try
								{
									seat = seat.replace("lug_", "").trim();
									var parse = JSON.parse(data);
									
									if(parse.length>0)
									{
										var sel_ticket = '<select seat="' + seat + '" onchange="update_prices( jQuery(this) );" class="form-control seat-sel">';
										sel_ticket += '<option value=""></option>';
										for(p in parse)
										{
											var ticket = parse[p];
											sel_ticket += '<option value="' + ticket["ticket"].toString().trim() + '">' + ticket["name"].toString().trim() + '</option>';
										}
										sel_ticket += "</select>";
									}
									else {
										var sel_ticket = '<select seat="' + seat + '" onchange="update_prices( jQuery(this) );" class="form-control seat-sel"></select>';
									}
									
									var new_tick = seat_qtt(sel_ticket, seat, '', seat, '', '', '')
									jQuery(".seat-tickets-container").find("form").append(new_tick);
									
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
				}
			});

			function checkout() {
				var numItems = $('.seat-sel').length;
				var u_qttmin = <?php echo $row['u_qttmin'];?>;
				var qtt = 0;
				$( ".calendar-extra-picker" ).each(function() {
				qtt += Number(jQuery(this).val());
					
				});
				if(numItems >= u_qttmin || qtt >= u_qttmin){
					var res_data = new Array();
					var res_date = '<?php echo date("n/j/Y"); ?>';
					var res_session = '';
					var res_pickup = $("#pickup").val();
					var res_room = $("#room").val();
					var res_language = $("#language").val();
					
					$( ".seat-sel" ).each(function() {
						var seat = jQuery(this).attr("seat");
						var type = jQuery(this).val();
						var qtt = 1;
						
						if( type.trim().length > 0 ) {
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
					
					jQuery("input[name='reservation_pickup']").val( res_pickup );
					jQuery("input[name='reservation_room']").val( res_room );
					jQuery("input[name='reservation_language']").val( res_language );
					jQuery("input[name='reservation_type']").val( 'seats' );
					jQuery("input[name='reservation_data']").val( JSON.stringify(res_data) );
					jQuery("input[name='reservation_date']").val( res_date );
					jQuery("input[name='reservation_session']").val( res_session );
					jQuery("input[name='reservation_bostamp']").val( '<?php echo $row["bostamp"]; ?>' );
					$( "#checkout_form" ).submit();
				}else{
					alert("Quantity Min!");
				}
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
					alert('Sorry, the minimum quantity was reached');
					$(this).val($(this).data('oldValue'));
				}
				if(valueCurrent <= maxValue) {
					$(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
				} else {
					alert('Sorry, the maximum quantity was reached');
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
			
			function update_prices( obj ) {
				$(".calendar-top-container").LoadingOverlay("show");
				var product = '<?php echo $row["bostamp"]; ?>';
				var data = '<?php echo date("n/j/Y"); ?>';
				var session = '';
				
				var type = obj.val().toString().trim();
				var seat = obj.attr("seat").toString().trim();
				
				$.ajax({
					method : 'GET',
					data : {date:data},
					datatype: "json",
					url: '<?php echo base_url(); ?>calendar/seat_prices?event='+product+'&session='+session+'&type='+type+'&seat='+seat,
					success : function(data){
						try
						{
							var parse = JSON.parse(data);
							
							if(parse.length>0)
							{
								for(p in parse)
								{
									var preco = parse[p];
									jQuery(".seat-value[seat="+seat+"]").val(parseFloat(preco["epv1"]*<?php echo $this->currency->multiplicador($_SESSION["ch"]);?>).toFixed(2));
								}
							}
							update_prices_seats();
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
			
			function update_prices_seats() {
				var html = '';
				var price_total = 0;
				var currency = '<?php echo $_SESSION["i"];?>';
				
				$( ".seat-sel" ).each(function() {
					var place = jQuery(this).attr("seat");
					
					if( jQuery(this).val().trim().length > 0 ) {
						value = parseFloat(jQuery( ".seat-value[seat="+place+"]" ).val()).toFixed(2);
						
						html+= '<div class="price-category clearfix"><span class="price-cat pull-left">' + place + '</span><span class="price-qtt pull-left">1 x <i class="fa">'+currency+'</i> ' + value + '</span>';
						html+= '<span class="price-total pull-right"><i class="fa">'+currency+'</i> ' + parseFloat(value).toFixed(2) + '</span></div>';
						
						price_total += parseFloat(value);
					}
				});
				
				jQuery.each( jQuery( ".calendar-extra-picker" ), function( i, val ) {
					if( jQuery(this).val() > 0 )
					{
						html+= '<div class="price-category clearfix"><span class="price-cat pull-left">' + jQuery(this).attr("design") + '</span><span class="price-qtt pull-left">' + parseFloat($(this).val()).toFixed(2) + ' x <i class="fa">'+currency+'</i> ' + jQuery(this).attr("price") + '</span>';
						html+= '<span class="price-total pull-right"><i class="fa">'+currency+'</i> ' + parseFloat(jQuery(this).val()*jQuery(this).attr("price")).toFixed(2) + '</span></div>';
						
						price_total += (jQuery(this).val()*jQuery(this).attr("price"));
					}	
				});
				
				$(".price-details-line").html(html);
				$(".price-total b").html('<i class="fa">'+currency+'</i> ' + parseFloat(price_total).toFixed(2));
			}
			
			function update_hours() {
				$(".calendar-top-container").LoadingOverlay("show");
				var product = '<?php echo $row["bostamp"]; ?>';
				var data = '<?php echo date("n/j/Y"); ?>';
				$.ajax({
					method : 'GET',
					data : {date:data},
					datatype: "json",
					url: '<?php echo base_url(); ?>calendar/session?event='+product,
					success : function(data){
						try
						{
							var parse = JSON.parse(data);

							var html = '<select onchange="jQuery(\'.calendar-but-2\').css(\'display\', \'inline\');" class="calendar-time-picker clearfix form-control"><option value="" disabled="" selected="">Select a starting time</option>';
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
			
			function update_seats() {
				$(".calendar-top-container").LoadingOverlay("show");
				var product = '<?php echo $row["bostamp"]; ?>';
				var data = '<?php echo date("n/j/Y"); ?>';
				var session = '';
				$.ajax({
					method : 'GET',
					data : {date:data},
					datatype: "json",
					url: '<?php echo base_url(); ?>calendar/get_unavailableseats?event='+product+'&session='+session,
					success : function(data){
						try
						{
							var parse = JSON.parse(data);
							
							$( ".seatCharts-cell.unavailable" ).each(function() {
								$( this ).removeClass( "unavailable" );
								$( this ).addClass( "available" );
							});
							
							$( ".seatCharts-cell" ).each(function() {
								$( this ).removeClass( "selected" );
							});
							
							if(parse.length>0)
							{
								// jQuery(".calendar-but-2").css("display", "inline");
								for(p in parse)
								{
									var row = parse[p];
									var lugar = row["cor"].toString().trim();
									var tipo = row["tam"].toString().trim();
									var qtt = row["qtt"];
									
									if( qtt > 0 && jQuery("#lug_" + lugar).hasClass("available") ) {
										jQuery("#lug_" + lugar).removeClass( "available" );
										jQuery("#lug_" + lugar).addClass( "unavailable" );
									}
								}
							}
							
							jQuery(".calendar-title1").css("display", "none");
							jQuery(".calendar-title2").css("display", "none");
							jQuery(".calendar-title3").css("display", "inline");
							jQuery(".calendar_div").css("display", "none");
							jQuery(".calendar-price").css("display", "contents");
							jQuery(".calendar-time-div").css("display", "none");
							jQuery(".calendar-but-1").css("display", "none");
							jQuery(".calendar-but-2").css("display", "none");
							jQuery(".calendar-but-2-1").css("display", "none");
							jQuery(".calendar-but-3").css("display", "inline");
							jQuery(".calendar-total").css("display", "inline");
							jQuery(".seat-tickets-container").css("display", "inline");
							
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
				//iniciar processamento
				$(".calendar-top-container").LoadingOverlay("show");
				update_seats();
				//finalizar processamento
				$(".calendar-top-container").LoadingOverlay("hide");
			}
			
			function fixDiv() {
				var $cache = $('.calendar-top-container');
				var top = $("#sticky-anchor").offset().top;
				var menu_height = $( ".primary-header" ).height();
				var footer_height = $( ".footer-wrapper" ).height();
				var footer_top = $( ".footer-wrapper" ).offset().top;

				if ($(window).scrollTop() > top-menu_height && $(window).scrollTop() < footer_top-footer_height)
				{
				  $cache.css({
					'position': 'fixed',
					'top': menu_height+'px',
					'width': '380px',
					'z-index': '200'
				  });
				}else if ($(window).scrollTop() >  footer_top-$(window).scrollTop()-footer_height)
				{
					$cache.css({
					'position': 'fixed',
					'top': footer_top-$(window).scrollTop()-footer_height+'px',
					'width': '380px',
					'z-index': '2'
				  });
				}else{
				  $cache.css({
					'position': 'relative',
					'top': 'auto'
				  });
				}
			}
			
			jQuery(document).ready(function() {
				$(".calendar-top-container").LoadingOverlay("show");
				calendar_bic('<?php echo $row["bostamp"]; ?>');
				bind_day_event();
				calendar_page(1);
				//$(window).scroll(fixDiv);
				//fixDiv();
				$(".calendar-top-container").LoadingOverlay("hide");
			});
			
		</script>
		<iframe style="margin-top:20px; width: 100%; height:250px;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?php echo $product[0]['u_latitude']?>,<?php echo $product[0]['u_longitud']?>&hl=es;z=14&amp;output=embed"></iframe>
		
	</div>
</div>

