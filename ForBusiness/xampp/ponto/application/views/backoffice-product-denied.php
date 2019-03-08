<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
		<div class="col-lg-12">
			
			<div class="row setup-content" id="step-1">
				<div class="col-xs-12">
					<div class="col-md-12 well text-center">
						YOU DO NOT HAVE PERMISSIONS TO ACCESS THIS PRODUCT OR THIS PRODUCT DONT EXIST
					</div>
				</div>
			</div>
		</div>
		<script>
			jQuery( document ).ready(function() {
				data_step( 1, 1, 1 );
			});
		</script>
		<script>
				var EventContent = tinymce.init({
				  selector: "#prod-long-desc",
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
				  }]
				});
		</script>
	</div>
</div>