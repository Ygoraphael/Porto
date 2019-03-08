<!DOCTYPE html>
<html lang="en-US">
<head>
	
    
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $title;?></title>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>favicon-16x16.png">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bo/backoffice_style.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bo/lib/stroke-7/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bo/lib/jquery.nanoscroller/css/nanoscroller.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bo/lib/jquery.vectormap/jquery-jvectormap-1.2.2.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bo/lib/theme-switcher/theme-switcher.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bo/lib/datatables/css/dataTables.bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bo/dist/summernote.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bo/bootstrap-colorpicker.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bo/jquery-gmaps-latlon-picker.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bo/lib/dropzone/dist/dropzone.css">
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.dataTables.min.css">
	<script src="<?php echo base_url(); ?>css/bo/lib/jquery/jquery.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>css/bo/lib/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>tinymce/js/tinymce/tinymce.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/bo/jquery.serializeToJSON.min.js" type="text/javascript"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/jquery.bsAlerts.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/bo/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/bo/bootstrap-colorpicker.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/bo/jquery-gmaps-latlon-picker.js" type="text/javascript"></script>
	<script src="//maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyAE9CXIB-QA8o99CnOnoSj55NHN9s2t6Iw"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/bo/calendar.css">
	<link href="<?php echo base_url(); ?>css/bootstrap-formhelpers.css" rel="stylesheet">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="//gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="//gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
	<script>
	jQuery(document).ready(function() {
		jQuery('input[type="number"]').focusout(function() {
			if( jQuery(this).val().toString().trim() == "" )
				jQuery(this).val("0.00");
			jQuery(this).val( parseFloat(jQuery(this).val()).toFixed(2) );
		})
	})
	</script>
</head>