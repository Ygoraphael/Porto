function data_step_init() {
	var hash = window.location.hash;
	if ( hash != "" && hash.includes("#tab") && parseFloat( hash.split("#tab").join("") ) ) {
		data_step( parseFloat( hash.split("#tab").join("") ) );
	}
	else {
		data_step( 1 );
	}
}

function data_step( step, show_mov_controls = 1, show_reg_controls = 1 ) {
	var num_steps = -999;
	
	jQuery("[data-step]").each(function() {
		var cur_step = parseFloat( jQuery(this).attr("data-step") );
		if( cur_step > num_steps ) {
			num_steps = cur_step;
		}
	})
	
	if( step == 1 ) {
		jQuery( "[data-step-control='back']" ).hide();
		jQuery( "[data-step-control='next']" ).show();
		jQuery( "[data-step-control='save']" ).show();
		jQuery( "[data-step-control='cancel']" ).show();
	}
	else if( step == num_steps ) {
		jQuery( "[data-step-control='back']" ).show();
		jQuery( "[data-step-control='next']" ).hide();
		jQuery( "[data-step-control='save']" ).show();
		jQuery( "[data-step-control='cancel']" ).show();
	}
	else {
		jQuery( "[data-step-control='back']" ).show();
		jQuery( "[data-step-control='next']" ).show();
		jQuery( "[data-step-control='save']" ).show();
		jQuery( "[data-step-control='cancel']" ).show();
	}
	
	if( !show_mov_controls ) {
		jQuery( "[data-step-control='back']" ).hide();
		jQuery( "[data-step-control='next']" ).hide();
	}
	if( !show_reg_controls ) {
		jQuery( "[data-step-control='save']" ).hide();
		jQuery( "[data-step-control='cancel']" ).hide();
	}
	
	jQuery("[data-step]").each(function() {
		var cur_step = parseFloat( jQuery(this).attr("data-step") );
		if( cur_step == step ) {
			jQuery(this).show();
		}
		else {
			jQuery(this).hide();
		}
	})
	
	jQuery("[data-step-tab]").each(function() {
		var cur_step = parseFloat( jQuery(this).attr("data-step-tab") );
		if( cur_step == step ) {
			jQuery(this).addClass("active");
		}
		else {
			jQuery(this).removeClass("active");
		}
	})
}

jQuery( "[data-step-tab]" ).click(function() {
	data_step( parseFloat(jQuery(this).attr("data-step-tab")) );
});

jQuery( "[data-step-control='back']" ).click(function() {
	var active_step = -999;
	jQuery("[data-step]").each(function() {
		if( jQuery(this).css("display") != "none" ) {
			active_step = parseFloat(jQuery(this).attr("data-step"));
		}
	})
	data_step( active_step - 1 );
});

jQuery( "[data-step-control='next']" ).click(function() {
	var active_step = -999;
	jQuery("[data-step]").each(function() {
		if( jQuery(this).css("display") != "none" ) {
			active_step = parseFloat(jQuery(this).attr("data-step"));
		}
	})
	data_step( active_step + 1 );
});