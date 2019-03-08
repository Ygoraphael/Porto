<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
	<body onload="document.getElementById('redirectForm').submit()">
		<form id='redirectForm' method='POST' action='<?php echo $url; ?>'>
			<?php
				foreach( $passData as $key => $val ) {
			?>
				<input type='hidden' name='<?php echo $key; ?>' value='<?php echo $val; ?>'/>
			<?php
				}
			?>
		</form>
	</body>
</html>