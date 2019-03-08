(function($) {

// prettyPhoto
	jQuery(document).ready(function(){
		jQuery('a[data-gal]').each(function() {
			jQuery(this).attr('rel', jQuery(this).data('gal'));
		});  	
		jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({animationSpeed:'slow',theme:'light_square',slideshow:false,overlay_gallery: false,social_tools:false,deeplinking:false});
	}); 

		
})(jQuery);

function input_qtt(sel, label, value, min, max, data_field, _id, _class, name, disabled, xs, sm, md, lg) {
	var output = "";
	output += '<div class="form-group">';
	if( label.toString().trim().length > 0 ) {
		output += '	<label for="category" class="col-sm-4 control-label">' + label + '</label>';
	}
	
	if( sel.toString().trim().length > 0 ) {
		output += '	<div class="col-sm-4">';
		output += sel;
		output += '	</div>';
	}
	
	output += '	<div class="col-xs-'+xs+' col-sm-'+sm+' col-md-'+md+' col-lg-'+lg+'">';
	output += '		<div class="input-group">';
	output += '			<span class="input-group-btn">';
	output += '				<button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="' + data_field + '">';
	output += '					<span class="glyphicon glyphicon-minus"></span>';
	output += '				</button>';
	output += '			</span>';
	output += '			<input type="text" id="' + _id + '" name="' + name + '" class="form-control input-number calendar-cat-picker ' + _class + '" value="' + value + '" min="' + min + '" max="' + max + '">';
	output += '			<span class="input-group-btn">';
	output += '				<button type="button" class="btn btn-default btn-number" data-type="plus" data-field="' + data_field + '">';
	output += '					<span class="glyphicon glyphicon-plus"></span>';
	output += '				</button>';
	output += '			</span>';
	output += '		</div>';
	output += '	</div>';
	output += '</div>';
	
	return output;
}

function label_qtt(sel, label, value, min, max, data_field, _id, _class, name, disabled, xs, sm, md, lg) {
	var output = "";
	output += '<div class="form-group">';
	if( label.toString().trim().length > 0 ) {
		output += '	<label for="category" class="col-sm-4 control-label">' + label + '</label>';
	}
	
	if( sel.toString().trim().length > 0 ) {
		output += '	<div class="col-sm-4">';
		output += sel;
		output += '	</div>';
	}
	
	output += '	<div class="col-xs-'+xs+' col-sm-'+sm+' col-md-'+md+' col-lg-'+lg+'">';
	output += '		<div class="input-group">';
	output += '			<input type="text" id="' + _id + '" name="' + name + '" ' + disabled + ' class="form-control input-number calendar-cat-picker ' + _class + '" value="' + value + '" min="' + min + '" max="' + max + '">';
	output += '		</div>';
	output += '	</div>';
	output += '</div>';
	
	return output;
}

function seat_qtt(sel, value, value2, data_field, _id, _class, name) {
	var output = "";
	output += '<div class="form-group">';
	output += '	<div class="col-sm-4">';
	output += sel;
	output += '	</div>';
	output += '	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">';
	output += '		<div class="input-group">';
	output += '			<input type="text" seat="'+data_field+'" id="' + _id + '" name="' + name + '" disabled class="form-control input-number seat-place' + _class + '" style="width:49%" value="' + value + '">';
	output += '			<input type="text" seat="'+data_field+'" id="' + _id + '" name="' + name + '" disabled class="form-control input-number seat-value' + _class + '" style="width:49%" value="' + value2 + '">';
	output += '		</div>';
	output += '	</div>';
	output += '</div>';
	
	return output;
}