<div id="black_wrap">
	<div class="container">
		<div class="row centered">
		
			<?php 
			$CI =& get_instance();
			$CI->load->library('translation');
			echo $CI->translation->Translation_key('country'); 
			?>
		</div>
	</div>
</div>
