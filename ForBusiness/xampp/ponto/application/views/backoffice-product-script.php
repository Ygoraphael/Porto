<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<script>
	//var array =();
	$('[data-step-control="save"]').hide();
	$('[data-step-control="cancel"]').hide();
	
	function bt_save_cancel(){
		if( !$('[data-step-control="save"]').is(":visible") && !$('[data-step-control="cancel"]').is(":visible") ){
			$('[data-step-control="save"]').show();
			$('[data-step-control="cancel"]').show();
		}		
	}
	
	$('[data-step-control="cancel"]').click(function() {
	  location.reload();
	});
	
	$(document).ready(function () {
		$(function(){
		   $('input, textarea, select, #exclusion_table_wrapper, #seats_table').change(function(e){
			 bt_save_cancel();
		   });
		});
		
		var bostamp = '<?php echo $product['bostamp'];?>';
		Dropzone.autoDiscover = false;
		
		$("#dZUpload").dropzone({
			url: '<?php echo site_url('/backoffice/upload'); ?>',
			params:{bostamp:bostamp},
			acceptedFiles: 'image/*',
			maxFilesize: 2,
			addRemoveLinks: true,
			success: function (file, response) {
				var imgName = response;
				file.previewElement.classList.add("dz-success");
				//console.log("Successfully uploaded :" + imgName);
				//alert(response);
				},
			error: function (file, response) {
				//file.previewElement.classList.add("dz-error");
				this.removeFile(file);
				//alert(response);
			},
			 init: function () {
				this.on('removedfile', function (file) {
					  $.ajax({
							type:'POST',
							url:'<?php echo base_url("backoffice/deletefile"); ?>',
							data:{'search':file['name'],
								'bostamp':bostamp
							},
							success:function(data){
								// alert(data);
							},error:
							function(data){
								//alert(JSON.stringify(data));
							}
						});
				});
				<?php 
					$path_images = array();
					foreach( $images as $image ) {
						$img_tmp = array();
						$img_tmp['img'] = base_url() . 'image_product/' . $image["img"];
						$path_images[] = $img_tmp;
					}
				?>
				var myArray = <?php echo json_encode($path_images);?>;
				if(myArray.length > 0){
					for (var key in myArray) {
						var link_file ="";
						var link=myArray[key]['img'];
						var name = link.substring(link.lastIndexOf('/')+1);
						var mockFile = { name: name, type: 'image/*' };
						if(link.charAt(0) != "C"){
							link_file = link;
						}else{
							var parts = link.split('htdocs');
							link_file = parts[1];
						}							
						this.options.addedfile.call(this, mockFile);
						this.options.thumbnail.call(this, mockFile,link_file );
						mockFile.previewElement.classList.add('dz-success');
						mockFile.previewElement.classList.add('dz-complete');
					}				
				
				}
			}
		});
		
		$("#dZUpload2").dropzone({
			url: '<?php echo site_url('/backoffice/upload_image_voucher'); ?>',
			params:{bostamp:bostamp},
			acceptedFiles: 'image/*',
			maxFiles: 1,
			addRemoveLinks: true,
			success: function (file, response) {
				var imgName = response;
				file.previewElement.classList.add("dz-success");
				//alert(this.files.length)
				},
			error: function (file, response) {
				this.removeFile(file);
				alert(response);
			},
			 init: function () {
			 this.on('removedfile', function (file) {
					  $.ajax({
							type:'POST',
							url:'<?php echo base_url("backoffice/deletefile_voucher"); ?>',
							data:{'search':file['name'],
								'bostamp':bostamp
							},
							success:function(data){
								//alert(data);
								
							}
						});
					
				});
				
				var myArray = <?php echo json_encode($image_voucher);?>;
				if(myArray.length > 0){	
					for (var key in myArray) {
						var link_file ="";
						var link= '<?php echo base_url() . 'image_product/'; ?>' + myArray[key]['u_imgvouch'];
						var name = link.substring(link.lastIndexOf('/')+1);
						var mockFile = { name: name, type: 'image/*' };
						if(link.charAt(0) != "C"){
							link_file = link;
						}else{
							var parts = link.split('htdocs');
							link_file = parts[1];
						}							
						this.options.addedfile.call(this, mockFile);
						this.options.thumbnail.call(this, mockFile,link_file );
						mockFile.previewElement.classList.add('dz-success');
						mockFile.previewElement.classList.add('dz-complete');
					}
				}
			}
		});
		
		
		(function ($) {
		  $.each(['show', 'hide'], function (i, ev) {
			var el = $.fn[ev];
			$.fn[ev] = function () {
			  this.trigger(ev);
			  return el.apply(this, arguments);
			};
		  });
		})(jQuery);
		
	});
	var s_t;
	
	function initialize() {
		jQuery('form').validator();
		jQuery("input").inputmask({ definitions: {
			'2': {
				validator: "[0-2]",
				cardinality: 1
			},
			'5': {
				validator: "[0-5]",
				   cardinality: 1   
			}
		}});
		jQuery("[data-limit='true']").keyup(function() {
			var text_length = $(this).val().length;
			var text_remaining = $(this).attr("maxlength") - text_length;
			jQuery("[data-limit-holder='" + $(this).attr("id") + "']").html( text_remaining + " out of " + $(this).attr("maxlength") + " characters" );
		});
		jQuery('#cp2').colorpicker();
	}
	
	jQuery( document ).ready(function() {
		s_t = $('#scheduling_table').DataTable();
		e_t = $('#exclusion_table').DataTable();
		initialize();
	});
	
	function delete_tick_num( obj ) {
		
		var stamp = obj.parent().parent().children().eq(0).attr('stamp');
		
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>backoffice/ajax/delete_product_ticket_number",
			data: { 
				"stamp" : stamp
			},
			success: function(data) 
			{
				data = JSON.parse(data);
				
				if( data ) {
					obj.parent().parent().remove();
					
					jQuery(document).trigger("add-alerts", [
					{
						"message": "Ticket number deleted successfully",
						"priority": 'success'
					}
					]);
				}
				else {
					jQuery(document).trigger("add-alerts", [
					{
						"message": "Error deleting ticket number",
						"priority": 'error'
					}
					]);
				}
			}
		});
	}
	
	function delete_seat( obj ) {
		
		var stamp = obj.parent().parent().children().eq(0).attr('stamp');
		
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>backoffice/ajax/delete_product_seat",
			data: { 
				"stamp" : stamp
			},
			success: function(data) 
			{
				data = JSON.parse(data);
				
				if( data ) {
					obj.parent().parent().remove();
					
					jQuery(document).trigger("add-alerts", [
					{
						"message": "Seat deleted successfully",
						"priority": 'success'
					}
					]);
				}
				else {
					jQuery(document).trigger("add-alerts", [
					{
						"message": "Error deleting seat",
						"priority": 'error'
					}
					]);
				}
			}
		});
	}
	
	function delete_session( obj ) {
		
		var stamp = obj.parent().parent().children().eq(0).attr('stamp');
		
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>backoffice/ajax/delete_product_session",
			data: { 
				"stamp" : stamp
			},
			success: function(data) 
			{
				data = JSON.parse(data);
				
				if( data ) {
					s_t.row( obj.parent().parent() ).remove().draw();
					
					jQuery(document).trigger("add-alerts", [
					{
						"message": "Session deleted successfully",
						"priority": 'success'
					}
					]);
				}
				else {
					jQuery(document).trigger("add-alerts", [
					{
						"message": "Error deleting session",
						"priority": 'error'
					}
					]);
				}
			}
		});
	}	
	
	function delete_exclusion( obj ) {
		
		var stamp = obj.parent().parent().children().eq(0).attr('stamp');
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>backoffice/ajax/delete_product_exclusion",
			data: { 
				"stamp" : stamp
			},
			success: function(data) 
			{
				data = JSON.parse(data);
				
				if( data ) {
					obj.parent().parent().remove();
					//e_t.row( obj.parent().parent() ).remove().draw();
					
					jQuery(document).trigger("add-alerts", [
					{
						"message": "Exclusion deleted successfully",
						"priority": 'success'
					}
					]);
				}
				else {
					jQuery(document).trigger("add-alerts", [
					{
						"message": "Error deleting exclusion",
						"priority": 'error'
					}
					]);
				}
			}
		});
	}
	
	$('#ticket_num_table_import_input').change(function(e) {
		
		if (e.target.files != undefined) {
			var reader = new FileReader();
			reader.onload = function(e) {
				var csvval = e.target.result.split(/\r\n|\n/);
				
				for(var i=0; i < csvval.length; i++)
				{
					var csvvalue = csvval[i].split(";");
					
					var max_id = 0;
					jQuery( "#ticket_num_table tbody tr" ).each(function() {
						var tick_id = parseFloat( jQuery(this).children().eq(0).attr("tick_id") );
						
						if( tick_id > max_id ) {
							max_id = tick_id;
						}
					});
					max_id = max_id + 1;
					var row = '';
					row += '<tr>';
					row += '	<td tick_id="' + max_id + '" class="nopaddingmargin"><input type="text" class="form-control" value="' + csvvalue[0] + '"></td>';
					row += '	<td class="nopaddingmargin"><input type="checkbox" disabled=""></td>';
					row += '	<td class="nopaddingmargin"><input type="checkbox" disabled=""></td>';
					row += '	<td class="text-center nopaddingmargin"><a href="#" onclick="delete_tick_num(jQuery(this)); return false;" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a></td>';
					row += '</tr>';
					
					jQuery('#ticket_num_table tbody').append(row);
				}
			};
			reader.readAsText(e.target.files.item(0));
		}
	});
	
	$('#seats_table_import_input').change(function(e) {
		
		if (e.target.files != undefined) {
			var reader = new FileReader();
			reader.onload = function(e) {
				var csvval = e.target.result.split(/\r\n|\n/);
				
				for(var i=0; i < csvval.length; i++)
				{
					var csvvalue = csvval[i].split(";");
					
					var max_id = 0;
					jQuery( "#seats_table tbody tr" ).each(function() {
						var tick_id = parseFloat( jQuery(this).children().eq(0).attr("tick_id") );
						
						if( tick_id > max_id ) {
							max_id = tick_id;
						}
					});
					max_id = max_id + 1;
					var row = '';
					row += '<tr>';
					row += '	<td tick_id="' + max_id + '" class="nopaddingmargin"><input type="text" class="form-control" value="' + csvvalue[0] + '"></td>';
					row += '	<td class="text-center nopaddingmargin"><a href="#" onclick="delete_session(jQuery(this)); return false;" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a></td>';
					row += '</tr>';
					
					jQuery('#seats_table tbody').append(row);
				}
			};
			reader.readAsText(e.target.files.item(0));
		}
	});
	
	jQuery('#ticket_num_table_import').on( 'click', function () {
		$('#ticket_num_table_import_input').click();
	});
	
	jQuery('#seats_table_import').on( 'click', function () {
		$('#seats_table_import_input').click();
	});
	
	jQuery('#seats_table_add').on( 'click', function () {
		var max_id = 0;
		
		jQuery( "#seats_table tbody tr" ).each(function() {
			var seat_id = parseFloat( jQuery(this).children().eq(0).attr("seat_id") );
			
			if( seat_id > max_id ) {
				max_id = seat_id;
			}
		});
		
		max_id = max_id + 1;
		
		var row = '';
		row += '<tr>';
		row += '	<td seat_id="' + max_id + '" class="nopaddingmargin"><input type="text" class="form-control" value=""></td>';
		row += '	<td class="text-center nopaddingmargin"><a href="#" onclick="delete_session(jQuery(this)); return false;" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a></td>';
		row += '</tr>';
		
		jQuery('#seats_table tbody').append(row);
	});
	
	jQuery('#ticket_num_table_add').on( 'click', function () {
		
		var max_id = 0;
		
		jQuery( "#ticket_num_table tbody tr" ).each(function() {
			var tick_id = parseFloat( jQuery(this).children().eq(0).attr("tick_id") );
			
			if( tick_id > max_id ) {
				max_id = tick_id;
			}
		});
		
		max_id = max_id + 1;
		
		var row = '';
		row += '<tr>';
		row += '	<td tick_id="' + max_id + '" class="nopaddingmargin"><input type="text" class="form-control" value=""></td>';
		row += '	<td class="nopaddingmargin"><input type="checkbox" disabled=""></td>';
		row += '	<td class="nopaddingmargin"><input type="checkbox" disabled=""></td>';
		row += '	<td class="text-center nopaddingmargin"><a href="#" onclick="delete_tick_num(jQuery(this)); return false;" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a></td>';
		row += '</tr>';
		
		jQuery('#ticket_num_table tbody').append(row);
	});
	
	jQuery('#scheduling_table_add').on( 'click', function () {
		var max_id = 0;
		
		s_t.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
			var data = this.data();
			var id = parseFloat(data[0]);
			if( id > max_id ) {
				max_id = id;
			}
		});
		
		s_t.row.add( [
			max_id+1,
			'<input type="checkbox">',
			'<input type="number" style="width:100px" step="1" class="form-control" value="0">',
			'<input type="text" style="width:100px" data-inputmask="\'mask\': \'29:59\'" class="form-control" value="00:00">',
			'<input type="date" class="form-control" value="">',
			'<input type="date" class="form-control" value="">',
			'<input type="checkbox" checked>',
			'<input type="checkbox" checked>',
			'<input type="checkbox" checked>',
			'<input type="checkbox" checked>',
			'<input type="checkbox" checked>',
			'<input type="checkbox" checked>',
			'<input type="checkbox" checked>',
			'<a href="#" class="btn btn-default"><span onclick="delete_session(jQuery(this)); return false;" class="glyphicon glyphicon-remove"></span></a>',
			''
		] ).draw( false );
		initialize();
	});	
	
	jQuery('#exclusion_table_add').on( 'click', function () {
		var max_id = 0;
		
/*		e_t.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
			var data = this.data();
			var id = parseFloat(data[0]);
			if( id > max_id ) {
				max_id = id;
			}
		});
*/
		var max_id = 0;
		
		jQuery( "#exclusion_table tbody tr" ).each(function() {
			var excl_id = parseFloat( jQuery(this).children().eq(0).attr("excl_id") );
			
			if( excl_id > max_id ) {
				max_id = excl_id;
			}
		});
		
		max_id = max_id + 1;
		
		var row = '';
		row += '<tr>';
		row += '	<td excl_id="' + max_id + '" ><input type="number" id="smonth' + max_id + '" min="1" max="12" step="1" class="form-control" value="0"></td>';
		row += '	<td><input type="number" min="1" max="31" step="1" id="sday' + max_id + '" class="form-control" value="0"></td>';
		row += '	<td><input type="number" min="1" max="12" step="1" id="fmonth' + max_id + '" class="form-control" value="0"></td>';
		row += '	<td><input type="number" min="1" max="31" step="1" id="fday' + max_id + '" class="form-control" value="0"></td>';
		row += '	<td class="text-center"><a href="#" onclick="delete_exclusion(jQuery(this)); return false;" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a></td>';
		row += '</tr>';
		
		jQuery('#exclusion_table tbody').find(".dataTables_empty").parent().remove();
		jQuery('#exclusion_table tbody').append(row);
	});
	
	//Exclusões Validar dia/mês
	$('#exclusion_table tbody').on('change', 'input', function(e) {
		
		var max1 = parseInt(jQuery(this).attr("max"), 10);
		var num = parseInt(jQuery(this).val(), 10);
		var id= jQuery(this).attr("id");

		if( num >= max1){
			jQuery(this).val(max1);
		}
		
		if(id.indexOf("smonth") != -1){
			var input = jQuery(this).parent().eq(0).attr("excl_id");
			get_day_of_months(num,input,"sday");
		}
		if(id.indexOf("sday") != -1){
			
		}
		if(id.indexOf("fmonth") != -1){
			
			var input = jQuery(this).parent().parent().children().eq(0).attr("excl_id");
			get_day_of_months(num,input,"fday");
		}
		if(id.indexOf("fday") != -1){
		
		}
		
	});	
	
	function get_day_of_months(month,input,value){
		var today = new Date();
		var d = new Date(2016, month, 0);
		var max = d.getDate(); 
		$('#'+value+input+'').attr({
		   "max" : max        // substitute your own
		});
		
		var max1 = parseInt(jQuery('#'+value+input+'').attr("max"), 10);
		var num = parseInt(jQuery('#'+value+input+'').val(), 10);

		if( num >= max1){
			jQuery('#'+value+input+'').val(max1);
		}
	}
	
	jQuery('form').validator().on('submit', function (e) {
		if (e.isDefaultPrevented()) {
			// handle the invalid form...
		} else {
			e.preventDefault();
			$(".loading-overlay").show();
			//textarea mce
			var textarea = new Array();
			jQuery('.mce-control').each(function() {
				mce_id = jQuery(this).attr('id').toString();
				mce_name = jQuery(this).attr('name').toString();
				mce_content = btoa(tinyMCE.get( mce_id ).getContent());
				
				var textarea_tmp = new Array();
				textarea_tmp.push(mce_name);
				textarea_tmp.push(mce_content);
				
				textarea.push(textarea_tmp);
			})
			
			//checkboxes
			var checkbox = new Array();
			$('input[type=checkbox]').each(function() {
				var checkbox_tmp = new Array();
				checkbox_tmp.push(this.name);
				if (!this.checked) {
					checkbox_tmp.push(0);
				}
				else {
					checkbox_tmp.push(1);
				}
				checkbox.push(checkbox_tmp);
			});

			//scheduling_table
			var scheduling_table = Array();
			var sData = s_t.$('tr', { "filter": "applied" });
			
			var $table = s_t.table().node();
			if( s_t.data().length > 0 ) {
				jQuery( "tbody tr", $table ).each(function() {
					var scheduling_table_tmp = new Array();
					
					//stamp
					var attr = jQuery(this).children().eq(0).attr("stamp");
					if (typeof attr !== typeof undefined && attr !== false) {
						scheduling_table_tmp.push( jQuery(this).children().eq(0).attr("stamp") );
					}
					else {
						scheduling_table_tmp.push( '' );
					}
					//id
					scheduling_table_tmp.push( jQuery(this).children().eq(0).html() );
					//price
					scheduling_table_tmp.push( jQuery(this).children().eq(1).find("input").is(":checked") );
					//Max Lotation
					scheduling_table_tmp.push( jQuery(this).children().eq(2).find("input").val() );
					//starting hour
					scheduling_table_tmp.push( jQuery(this).children().eq(3).find("input").val() );
					//date
					scheduling_table_tmp.push( jQuery(this).children().eq(4).find("input").val() );
					//mon
					scheduling_table_tmp.push( jQuery(this).children().eq(6).find("input").is(":checked") );
					//tue
					scheduling_table_tmp.push( jQuery(this).children().eq(7).find("input").is(":checked") );
					//wed
					scheduling_table_tmp.push( jQuery(this).children().eq(8).find("input").is(":checked") );
					//thu
					scheduling_table_tmp.push( jQuery(this).children().eq(9).find("input").is(":checked") );
					//fri
					scheduling_table_tmp.push( jQuery(this).children().eq(10).find("input").is(":checked") );
					//sat
					scheduling_table_tmp.push( jQuery(this).children().eq(11).find("input").is(":checked") );
					//sun
					scheduling_table_tmp.push( jQuery(this).children().eq(12).find("input").is(":checked") );
					//date end
					scheduling_table_tmp.push( jQuery(this).children().eq(5).find("input").val() );
					
					scheduling_table.push( scheduling_table_tmp );
				});
			}
			
			//exclusion_table
			var exclusion_table = Array();
/*			var eData = e_t.$('tr', { "filter": "applied" });
			
			var $table = e_t.table().node();
			if( e_t.data().length > 0 ) {*/
			jQuery("#exclusion_table tbody tr").each(function() {
				var exclusion_table_tmp = new Array();
				
				//stamp
				var attr = jQuery(this).children().eq(0).attr("stamp");
				if (typeof attr !== typeof undefined && attr !== false) {
					exclusion_table_tmp.push( jQuery(this).children().eq(0).attr("stamp") );
				}
				else {
					exclusion_table_tmp.push( '' );
				}
				//exclusion_table_tmp.push( jQuery(this).children().eq(0).html() );
				var excl_id = jQuery(this).children().eq(0).attr("excl_id");
				exclusion_table_tmp.push( excl_id );
	
				exclusion_table_tmp.push( jQuery(this).children().eq(0).find("input").val());
				exclusion_table_tmp.push( jQuery(this).children().eq(1).find("input").val());
				exclusion_table_tmp.push( jQuery(this).children().eq(2).find("input").val());
				exclusion_table_tmp.push( jQuery(this).children().eq(3).find("input").val());
		
				exclusion_table.push( exclusion_table_tmp );
			});
			
			//language_table
			var language_table = Array();
			jQuery("#language_table tbody tr").each(function() {
				var language_table_tmp = new Array();
				
				//stamp
				var attr = jQuery(this).children().eq(1).attr("stamp");
				if (typeof attr !== typeof undefined && attr !== false) {
					language_table_tmp.push( jQuery(this).children().eq(1).attr("stamp") );
				}
				else {
					language_table_tmp.push( '' );
				}
				language_table_tmp.push( jQuery(this).children().eq(1).attr("language_val") );					
				//is selected
				var selected = "0";
				if( jQuery(this).children().eq(2).find("input").is(":checked")){
					selected = "1";
				}else{
					selected = "0";
				}
				language_table_tmp.push( selected);
		
				language_table.push( language_table_tmp );
			});
			//}
			//tickets_table
			var tickets_table = Array();

			jQuery( "#tickets_table tbody tr" ).each(function() {
				var tickets_table_tmp = new Array();
				
				//stamp
				var attr = jQuery(this).children().eq(0).attr("stamp");
				if (typeof attr !== typeof undefined && attr !== false) {
					tickets_table_tmp.push( jQuery(this).children().eq(0).attr("stamp") );
				}
				else {
					tickets_table_tmp.push( '' );
				}
				//custom
				tickets_table_tmp.push( jQuery(this).children().eq(1).find("input").val() );
				//checked
				tickets_table_tmp.push( jQuery(this).children().eq(2).find("input").is(":checked") );
				
				tickets_table.push( tickets_table_tmp );
			});
			
			//ticket_num_table
			var ticket_num_table = Array();

			jQuery( "#ticket_num_table tbody tr" ).each(function() {
				var ticket_num_table_tmp = new Array();
				
				//stamp
				var attr = jQuery(this).children().eq(0).attr("stamp");
				if (typeof attr !== typeof undefined && attr !== false) {
					ticket_num_table_tmp.push( jQuery(this).children().eq(0).attr("stamp") );
				}
				else {
					ticket_num_table_tmp.push( '' );
				}
				//number
				ticket_num_table_tmp.push( jQuery(this).children().eq(0).find("input").val() );
				//tick id
				var tick_id = jQuery(this).children().eq(0).attr("tick_id");
				ticket_num_table_tmp.push( tick_id );
				
				ticket_num_table.push( ticket_num_table_tmp );
			});
			
			//extras_table
			var extras_table = Array();

			jQuery( "#extras_table tbody tr" ).each(function() {
			var extras_table_tmp = new Array();

			//ref
			var attr = jQuery(this).children().eq(0).attr("ref");
			if (typeof attr !== typeof undefined && attr !== false) {
			extras_table_tmp.push( jQuery(this).children().eq(0).attr("ref") );
			}
			else {
			extras_table_tmp.push( '' );
			}
			//design


			var attr1 = jQuery(this).children().eq(0).attr("design");
			if (typeof attr1 !== typeof undefined && attr1 !== false) {
			extras_table_tmp.push( jQuery(this).children().eq(0).attr("design") );
			}
			else {
			extras_table_tmp.push( '' );
			}
			//qtt
			extras_table_tmp.push( jQuery(this).children().eq(1).find("input").val() );

			//price
			extras_table_tmp.push( jQuery(this).children().eq(2).find("input").val() );

			//checked extra
			extras_table_tmp.push( jQuery(this).children().eq(3).find("input").is(":checked") );

			//checked per price
			extras_table_tmp.push( jQuery(this).children().eq(4).find("input").is(":checked") );

			//checked activated
			extras_table_tmp.push( jQuery(this).children().eq(5).find("input").is(":checked") );

			extras_table.push( extras_table_tmp );
			});

			//seats table
			var seats_table = Array();

			jQuery( "#seats_table tbody tr" ).each(function() {
				var seats_table_tmp = new Array();
				
				//stamp
				var attr = jQuery(this).children().eq(0).attr("stamp");
				if (typeof attr !== typeof undefined && attr !== false) {
					seats_table_tmp.push( jQuery(this).children().eq(0).attr("stamp") );
				}
				else {
					seats_table_tmp.push( '' );
				}
				//seat
				seats_table_tmp.push( jQuery(this).children().eq(0).find("input").val() );
				//seat id
				var seat_id = jQuery(this).children().eq(0).attr("seat_id");
				seats_table_tmp.push( seat_id );
				
				seats_table.push( seats_table_tmp );
			});
			
			//relprod table
			var relprod_table = Array();

			jQuery( "#relprod_table tbody tr" ).each(function() {
				var relprod_table_tmp = new Array();

				relprod_table_tmp.push( '<?php echo $product["bostamp"]; ?>' );
				relprod_table_tmp.push( jQuery(this).children().eq(0).attr("stamp") );
				if( jQuery(this).children().eq(1).find("input").prop('checked') )
					relprod_table_tmp.push( 1 );
				else
					relprod_table_tmp.push( 0 );
				
				relprod_table.push( relprod_table_tmp );
			});
			
			//pickups table
			var pickups_table = Array();

			jQuery( "#pickups_table tbody tr" ).each(function() {
				var pickups_table_tmp = new Array();

				pickups_table_tmp.push( '<?php echo $product["bostamp"]; ?>' );
				pickups_table_tmp.push( jQuery(this).children().eq(0).attr("stamp") );
				if( jQuery(this).children().eq(5).find("input").prop('checked') )
					pickups_table_tmp.push( 1 );
				else
					pickups_table_tmp.push( 0 );
				
				pickups_table.push( pickups_table_tmp );
			});
			
			//tax table
			var tax_table = Array();

			jQuery( "#tax_table tbody tr" ).each(function() {
				var tax_table_tmp = new Array();

				tax_table_tmp.push( '<?php echo $product["bostamp"]; ?>' );
				tax_table_tmp.push( jQuery(this).children().eq(0).attr("stamp") );
				if( jQuery(this).children().eq(4).find("input").prop('checked') )
					tax_table_tmp.push( 1 );
				else
					tax_table_tmp.push( 0 );
				
				tax_table.push( tax_table_tmp );
			});

			jQuery.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>backoffice/ajax/update_product",
				data: { 
					"input" : JSON.stringify(jQuery("form").serializeToJSON()),
					"textarea" : JSON.stringify(textarea),
					"checkbox" : JSON.stringify(checkbox),
					"scheduling_table" : JSON.stringify( scheduling_table ),
					"exclusion_table" : JSON.stringify( exclusion_table ),
					"language_table" : JSON.stringify( language_table ),
					"tickets_table" : JSON.stringify( tickets_table ),
					"ticket_num_table" : JSON.stringify( ticket_num_table ),
					"seats_table" : JSON.stringify( seats_table ),
					"extras_table" : JSON.stringify( extras_table ),
					"relprod_table" : JSON.stringify( relprod_table ),
					"pickups_table" : JSON.stringify( pickups_table ),
					"tax_table" : JSON.stringify(tax_table),
					"bostamp" : '<?php echo $product["bostamp"]; ?>'
				},
				success: function(data) 
				{
					data = JSON.parse(data);
					
					if( data["update_bo"] == 1 ) {
						
						//atualizar dados scheduling table
						data["updated_scheduling_table"].forEach(function(entry) {
							var $table = s_t.table().node();
							jQuery( "tbody tr", $table ).each(function() {
								if( jQuery(this).children().eq(0).html() == entry["id"] ) {
									jQuery(this).children().eq(0).attr("stamp", entry["u_psessstamp"]);
								}
							});
						});				

						//scheduling table - pricing
						data["updated_scheduling_pricing"].forEach(function(entry) {
							var $table = s_t.table().node();
							jQuery( "tbody tr", $table ).each(function() {
								if( jQuery(this).children().eq(0).html() == entry["id"] ) {
									if( entry["alt_price"] ) {
										jQuery(this).children().eq(14).html( '<a href="<?php echo base_url()."backoffice/product_price/".$product["u_sefurl"]."/" ?>' + entry["id"] + '" class="btn btn-default"><span class="glyphicon glyphicon-euro"></span></a>' );
									}
									else {
										jQuery(this).children().eq(14).html("");
									}
								}
							});
						});
						
						//atualizar dados exclusion table
						data["updated_exclusion_table"].forEach(function(entry) {
							jQuery( "#exclusion_table tbody tr" ).each(function() {
								if( jQuery(this).children().eq(0).attr("excl_id") == entry["id"] ) {
									jQuery(this).children().eq(0).attr("stamp", entry["u_pexclstamp"]);
								}
							});
						});
												
						
						//atualizar dados ticket_num_table
						data["updated_ticket_num_table"].forEach(function(entry) {
							var $table = s_t.table().node();
							jQuery( "#ticket_num_table tbody tr" ).each(function() {
								if( jQuery(this).children().eq(0).attr("tick_id") == entry["id"] ) {
									jQuery(this).children().eq(0).attr("stamp", entry["u_pntickstamp"]);
								}
							});
						});
						
						//atualizar dados seats_table
						data["updated_seats_table"].forEach(function(entry) {
							var $table = s_t.table().node();
							jQuery( "#seats_table tbody tr" ).each(function() {
								if( jQuery(this).children().eq(0).attr("seat_id") == entry["id"] ) {
									jQuery(this).children().eq(0).attr("stamp", entry["u_pseatstamp"]);
								}
							});
						});
						
						$(".loading-overlay").hide();
						jQuery(document).trigger("add-alerts", [
						{
							"message": "Product updated successfully",
							"priority": 'success'
						}
						]);
					}
					else {
						$(".loading-overlay").hide();
						jQuery(document).trigger("add-alerts", [
						{
							"message": "Error updating product",
							"priority": 'error'
						}
						]);
					}
				}
			});
		}
	})
	
	jQuery( "[data-step-control='save']" ).click(function() {
		jQuery("form").submit();
	});
</script>
<script>
		var EventContent = tinymce.init({
		  selector: "#u_lngdesc",
		  height: 500,
		  plugins: [
			"advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
			"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
			"table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
		  ],

		  toolbar1: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
		  toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
		  toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft",

		  menubar: false,
		  toolbar_items_size: 'small',

		  style_formats: [{
			title: 'Bold text',
			inline: 'b'
		  }, {
			title: 'Red text',
			inline: 'span',
			styles: {
			  color: '#ff0000'
			}
		  }, {
			title: 'Red header',
			block: 'h1',
			styles: {
			  color: '#ff0000'
			}
		  }, {
			title: 'Example 1',
			inline: 'span',
			classes: 'example1'
		  }, {
			title: 'Example 2',
			inline: 'span',
			classes: 'example2'
		  }, {
			title: 'Table styles'
		  }, {
			title: 'Table row 1',
			selector: 'tr',
			classes: 'tablerow1'
		  }],
		   init_instance_callback: function (editor) {
			editor.on('Change', function (e) {
			  bt_save_cancel();
			});
		  }
		});
		
		$('#select_all').change(function() {
			var checkboxes = $(this).closest('form').find(':checkbox');
			if($(this).is(':checked')) {
				checkboxes.prop('checked', true);
			} else {
				checkboxes.prop('checked', false);
			}
		});
		
		$( "#u_city, #u_address, #u_country" ).change(function() {
			var address = $( "#u_address" ).val() + "," + $( "#u_city" ).val() + "," + $( "#u_country" ).val();
			$( "#inputmap" ).val( address );
			$('#btmap').trigger('click');
		});
		
</script>