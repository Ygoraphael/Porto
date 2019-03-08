jQuery(document).ready(function(){
	jQuery(".imgclick").mousedown(function(){
		var mrgtb = parseInt(jQuery(this).css("margin-top"));
		var mrglf = parseInt(jQuery(this).css("margin-left"));
		mrgtb=mrgtb+3;
		mrglf=mrglf+3;
		jQuery(this).css("margin-top",mrgtb+"px").css("margin-left",mrglf+"px");
	}).mouseup(function(){
		var mrgtb = parseInt(jQuery(this).css("margin-top"));
		var mrglf = parseInt(jQuery(this).css("margin-left"));
		mrgtb=mrgtb-3;
		mrglf=mrglf-3;
		jQuery(this).css("margin-top",mrgtb+"px").css("margin-left",mrglf+"px");
	}); 
});