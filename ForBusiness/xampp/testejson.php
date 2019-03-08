<?php
	$data = "%5B1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%5D";
	print_r(json_decode(rawurldecode($data)));
?>