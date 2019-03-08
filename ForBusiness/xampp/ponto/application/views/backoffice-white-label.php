<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="clearfix page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2 class="col-md-6 col-sm-6"><?php echo $title; ?></h2>
		<a target="_blank" href="<?php echo base_url()."wl/".$whitelabel["no"]; ?>" class="btn btn-info pull-right" style="margin-right:15px;">View online</a>
	</div>
</div>
<div class="main-content col-sm-12">
	<div class="col-lg-12">
		<form>
			<div class="form-group">
				<label for="wl_template">Template</label>
				<select class="form-control" id="template" name="u_whitelabel.template">
				<?php foreach($templates as $template) { 
					if( $template['name'] == $whitelabel['template'] )
						$selected = "selected";
					else
						$selected = "";
				?>
					<option value='<?php echo $template['name']; ?>' <?php echo $selected; ?>><?php echo $template['name']; ?></option>
				<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<label for="">Logo</label>
				<div class="">
					<div id="logo_upload" class="dropzone" style="width:50%;">
						<div class="dz-default dz-message">
							<div class="icon">
								<span style="font-size: 50px;" class="s7-cloud-upload"></span>
							</div>
						</div>										
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>Background color</label>
				<div id="bg_pick" class="input-group colorpicker-component">
					<input type="text" class="form-control" id="bg_color" name="u_whitelabel.bg_color" value="<?php echo $whitelabel['bg_color']; ?>">
					<span class="input-group-addon"><i></i></span>
				</div>
			</div>
			<div class="form-group">
				<label>Content color</label>
				<div id="cont_pick" class="input-group colorpicker-component">
					<input type="text" class="form-control" id="content_color" name="u_whitelabel.content_color" value="<?php echo $whitelabel['content_color']; ?>">
					<span class="input-group-addon"><i></i></span>
				</div>
			</div>
			<div class="form-group">
				<label>Header/Footer color</label>
				<div id="headfoo_pick" class="input-group colorpicker-component">
					<input type="text" class="form-control" id="headfoot_color" name="u_whitelabel.headfoot_color" value="<?php echo $whitelabel['headfoot_color']; ?>">
					<span class="input-group-addon"><i></i></span>
				</div>
			</div>
			<div class="form-group">
				<label>Menu Font color</label>
				<div id="menufontcolor_pick" class="input-group colorpicker-component">
					<input type="text" class="form-control" id="menu_font_color" name="u_whitelabel.menu_font_color" value="<?php echo $whitelabel['menu_font_color']; ?>">
					<span class="input-group-addon"><i></i></span>
				</div>
			</div>
			<div class="form-group">
				<label>Search Font color</label>
				<div id="wtc_pick" class="input-group colorpicker-component">
					<input type="text" class="form-control" id="widget_text_color" name="u_whitelabel.widget_text_color" value="<?php echo $whitelabel['widget_text_color']; ?>">
					<span class="input-group-addon"><i></i></span>
				</div>
			</div>
			<div class="form-group">
				<label for="wl_font">Font-family</label>
				<select class="form-control" id="fontfamily" name="u_whitelabel.fontfamily">
					<?php foreach($fonts as $font) { 
						if( $font['name'] == $whitelabel['fontfamily'] )
							$selected = "selected";
						else
							$selected = "";
					?>
						<option value='<?php echo $font['name']; ?>' <?php echo $selected; ?>><?php echo $font['name']; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<label for="wl_font">Menu</label>
				<table id="menus_table" class="table table-striped table-bordered" cellspacing="0" style="margin-bottom:5px" >
					<thead>
						<tr>
							<th>TEXT</th>
							<th>Protocol</th>
							<th>URL</th>
							<th>New Window</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$menu = json_decode($whitelabel['menu'],true);
							$count=0;
							if(sizeof($menu) > 0){
								foreach( $menu as $row ) {							
						?>
									<tr>
										<td class="nopaddingmargin"><input type="text" class="form-control" value="<?php echo $row["text"]; ?>"></td>
										<td class="nopaddingmargin" style="width:100px">
											<select class="form-control" id="template" name="u_whitelabel.template">
												<option value="http://" <?php echo ($row["protocol"] == "http://") ? "selected" : ""; ?>>http://</option>
												<option value="https://" <?php echo ($row["protocol"] == "https://") ? "selected" : ""; ?>>https://</option>
											</select>
										</td>
										<td class="nopaddingmargin"><input type="text" class="form-control" value="<?php echo $row["url"]; ?>"></td>
										<?php
										if($row["target"] == "true"){
										?>
										<td class="nopaddingmargin" ><div class='am-checkbox' style="text-align: -webkit-center;"><input type='checkbox' id="<?php echo "check".$count; ?>" checked><label for="<?php echo "check".$count; ?>" ></label></div></td>
										<?php
										}else{
										?>
										<td class="nopaddingmargin" ><div class='am-checkbox' style="text-align: -webkit-center;"><input type='checkbox' id="<?php echo "check".$count; ?>"><label for="<?php echo "check".$count; ?>" ></label></div></td>
										<?php }?>
										<td class="text-center nopaddingmargin"><a href="#" onclick="delete_menu(jQuery(this)); return false;" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a></td>
									</tr>
						<?php 
							$count++;
								}
							}else{
							?>
								<tr>
									<td class="nopaddingmargin" ><input type="text" class="form-control"></td>
									<td class="nopaddingmargin" ><input type="text" class="form-control"></td>
									<td class="nopaddingmargin" ><div class='am-checkbox' style="text-align: -webkit-center;"><input type='checkbox' id="check00"><label for="check00" ></label></div></td>
									<td class="text-center nopaddingmargin"><a href="#" onclick="delete_menu(jQuery(this)); return false;" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a></td>
								</tr>
							<?php
						} ?>
					</tbody>
				</table>
				<input type="hidden" class="form-control" id="menu" name="u_whitelabel.menu" >
				<div class="col-lg-12 col-sm-12" style="margin-bottom:10px; ">
					<button type="button" id="menus_table_add" class="btn btn-info btn-lg pull-left" style=" margin-left:0;">Add</button>
				</div>
			</div>
			<div class="form-group">
				<label>Payment Accepted URL</label>
				<div id="cont_pick" class="input-group colorpicker-component">
					<input type="text" class="form-control" id="content_color" name="" value="">
					<span class="input-group-addon"><i></i></span>
				</div>
			</div>
			<div class="form-group">
				<label>Payment Rejected URL</label>
				<div id="cont_pick" class="input-group colorpicker-component">
					<input type="text" class="form-control" id="content_color" name="" value="">
					<span class="input-group-addon"><i></i></span>
				</div>
			</div>
			<div class="form-group">
				<label>Slider Images</label>
				<div class="">
					<div id="slider_upload" class="dropzone">
						<div class="dz-default dz-message">
							<div class="icon">
								<span style="font-size: 50px;" class="s7-cloud-upload"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="example-text-input" class="col-2 col-form-label">Slider Video URL</label>
				<div class="col-10">
					<input name="u_whitelabel.slidervideo" placeholder="http://example.com/video.mp4" class="form-control" type="text" value="<?php echo $whitelabel['slidervideo']; ?>" id="whitelabel.slidervideo">
					<small>
						For youtube videos, you can use these parameters in URL:<br>
						Ex. <i>https://www.youtube.com/embed/XXXXXXXX?rel=0&controls=0&showinfo=0&autoplay=1&playlist=XXXXXXXX&loop=1</i><br>Note: 0 - disable / 1 - enable
					</small>
				</div>
			</div>
			<div class="form-group">
				<label for="example-text-input" class="col-2 col-form-label">Search Title</label>
				<div class="col-10">
					<input name="u_whitelabel.home_widget_title" placeholder="" class="form-control" type="text" value="<?php echo $whitelabel['home_widget_title']; ?>" id="whitelabel.home_widget_title">
				</div>
			</div>
			<div class="form-group">
				<label for="example-text-input" class="col-2 col-form-label">Search Description</label>
				<div class="col-10">
					<input name="u_whitelabel.home_widget_description" placeholder="" class="form-control" type="text" value="<?php echo $whitelabel['home_widget_description']; ?>" id="whitelabel.home_widget_description">
				</div>
			</div>
			<div class="form-group">
				<label for="whitelabel.customcss">Custom CSS</label>
				<textarea rows="15" class="form-control coding_textarea" id="whitelabel.customcss" name="u_whitelabel.customcss"><?php echo $whitelabel['customcss']; ?></textarea>
			</div>
			<div class="checkbox">
				<label>
					<input name="u_whitelabel.sliderproducts" type="checkbox" <?php echo ($whitelabel['sliderproducts'] == 1) ? "checked=''" : ""; ?>> Slider active in products page
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input name="u_whitelabel.booknowproducts" type="checkbox" <?php echo ($whitelabel['booknowproducts'] == 1) ? "checked=''" : ""; ?>> Products presentation with BOOK NOW button
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input name="u_whitelabel.sliderproduct" type="checkbox" <?php echo ($whitelabel['sliderproduct'] == 1) ? "checked=''" : ""; ?>> Slider active in product page
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input name="u_whitelabel.sliderimage" type="checkbox" <?php echo ($whitelabel['sliderimage'] == 1) ? "checked=''" : ""; ?>> First product image in product page as fixed slider
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input name="u_whitelabel.listgridbut" type="checkbox" <?php echo ($whitelabel['listgridbut'] == 1) ? "checked=''" : ""; ?>> List/Grid Button active
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input name="u_whitelabel.filtersactive" type="checkbox" <?php echo ($whitelabel['filtersactive'] == 1) ? "checked=''" : ""; ?>> Filters active
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input name="u_whitelabel.bxslider_auto" type="checkbox" <?php echo ($whitelabel['bxslider_auto'] == 1) ? "checked=''" : ""; ?>> Slider Auto Start
				</label>
			</div>
			<div class="form-group">
				<label for="whitelabel.bxslider_time">Slide transition duration (in ms)</label>
				<input type="text" class="form-control coding_textarea" id="whitelabel.bxslider_time" name="u_whitelabel.bxslider_time" value="<?php echo $whitelabel['bxslider_time']; ?>"/>
			</div>
		</form>
		<p style="margin-bottom:25px"></p>
		<div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
		<button data-step-control="save"  class="btn btn-info btn-lg pull-left" style="margin-bottom:25px">SAVE</button>
	</div>
</div>
<script>
	$(document).ready(function () {
		var wl_id = '<?php echo $whitelabel['id'];?>';
		Dropzone.autoDiscover = false;
		
		$("#logo_upload").dropzone({
			url: '<?php echo site_url('/backoffice/ajax/wl_upload_logo'); ?>',
			params:{id:wl_id},
			acceptedFiles: 'image/*',
			maxFiles: 1,
			maxFilesize: 2,
			addRemoveLinks: true,
			success: function (file, response) {
				var imgName = response;
				file.previewElement.classList.add("dz-success");
				},
			error: function (file, response) {
				this.removeFile(file);
			},
			init: function () {
				this.on('removedfile', function (file) {
					  $.ajax({
							type:'POST',
							url:'<?php echo base_url("backoffice/ajax/wl_delete_logo"); ?>',
							data:{'name':file['name'],
								'id':wl_id
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
					if( $whitelabel['logo'] != '' ) {
						$img_tmp = array();
						$img_tmp['img'] = base_url() . 'image_product/' . $whitelabel["logo"];
						$path_images[] = $img_tmp;
					}
				?>
				var myArray = <?php echo json_encode($path_images);?>;
				if(myArray.length >= 0){
					for (var key in myArray) {
						var link_file ="";
						var link = myArray[key]['img'];
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
		
		$("#slider_upload").dropzone({
			url: '<?php echo site_url('/backoffice/ajax/wl_upload_slimg'); ?>',
			params:{id:wl_id},
			acceptedFiles: 'image/*',
			maxFilesize: 2,
			addRemoveLinks: true,
			success: function (file, response) {
				var imgName = response;
				file.previewElement.classList.add("dz-success");
				},
			error: function (file, response) {
				this.removeFile(file);
			},
			init: function () {
				this.on('removedfile', function (file) {
					  $.ajax({
							type:'POST',
							url:'<?php echo base_url("backoffice/ajax/wl_delete_slimg"); ?>',
							data:{'name':file['name'],
								'id':wl_id
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
					foreach( $sl_img as $slider_img )
					if( $slider_img['img'] != '' ) {
						$img_tmp = array();
						$img_tmp['img'] = base_url() . 'image_product/' . $slider_img["img"];
						$path_images[] = $img_tmp;
					}
				?>
				var myArray = <?php echo json_encode($path_images);?>;
				if(myArray.length >= 0){
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
		
		jQuery('#bg_pick').colorpicker();
		jQuery('#cont_pick').colorpicker();
		jQuery('#headfoo_pick').colorpicker();
		jQuery('#menufontcolor_pick').colorpicker();
		jQuery('#wtc_pick').colorpicker();
	});
	
	jQuery( "[data-step-control='save']" ).click(function() {
		
		$(".loading-overlay").show();
		
		//menus_table_table
		var menus_table_table = Array();

		jQuery( "#menus_table tbody tr" ).each(function() {
			
			//text
			var text = jQuery(this).children().eq(0).find("input").val();
			var protocol = jQuery(this).children().eq(1).find("select").val();
			var url = jQuery(this).children().eq(2).find("input").val();
			var target = jQuery(this).children().eq(3).find("input").is(":checked");
			if (text != "") {
				var values = { };
				values.text = text;
				values.protocol = protocol;
				values.url = url;
				values.target = target;
				menus_table_table.push(values);
			}
		
		});

		$('#menu').val(JSON.stringify(menus_table_table));

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
				
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>backoffice/ajax/update_whitelabel",
			data: { 
				"input" : JSON.stringify(jQuery("form").serializeToJSON()),
				"id" : '<?php echo $whitelabel['id']; ?>',
				"checkbox" : JSON.stringify(checkbox)
			},
			success: function(data) 
			{
				data = JSON.parse(data);
				
				if( data["update_wl"] == 1 ) {
					
					$(".loading-overlay").hide();
					jQuery(document).trigger("add-alerts", [
					{
						"message": "White label updated successfully",
						"priority": 'success'
					}
					]);
				}
				else {
					$(".loading-overlay").hide();
					jQuery(document).trigger("add-alerts", [
					{
						"message": "Error updating white label",
						"priority": 'error'
					}
					]);
				}
			}
		});
		
	});
	var max_id = 0;
	jQuery('#menus_table_add').on( 'click', function () {
		
		jQuery( "#menus_table tbody tr" ).each(function() {
			var menu_id = parseFloat( jQuery(this).children().eq(0).attr("menu_id") );
			
			if( menu_id > max_id ) {
				max_id = menu_id;
			}
		});
		
		max_id = max_id + 1;
		
		var row = '';
		row += '<tr>';
		row += '	<td  class="nopaddingmargin"><input type="text" class="form-control" value=""></td>';
		row += '	<td class="nopaddingmargin" style="width:100px"><select class="form-control" id="template" name="u_whitelabel.template"><option value="http://" >http://</option><option value="https://">https://</option></select></td>';
		row += '	<td class="nopaddingmargin"><input type="text" class="form-control" value=""></td>';
		row += '	<td class="nopaddingmargin" ><div class="am-checkbox" style="text-align: -webkit-center;"><input type="checkbox" id="check' + max_id + '"><label for="check' + max_id + '" ></label></div></td>';
		row += '	<td class="text-center nopaddingmargin"><a href="#" onclick="delete_menu(jQuery(this)); return false;" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a></td>';
		row += '</tr>';
		
		jQuery('#menus_table tbody').append(row);
	});
	
	function delete_menu( obj ) {
		
		var stamp = obj.parent().parent().children().eq(0).attr('stamp');
		
		obj.parent().parent().remove();
	}
		
</script>