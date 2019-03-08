<?php
	if( isset($_POST) && isset($_POST["f"]) && isset($_POST["apikey"]) ) {
		if( $_POST["apikey"] == "phc656" ) {
			
			if($_POST["f"]=="026008") {
				echo 1;
			}
			else {
				echo 0;
			}
			return;
		}
	}
	
	echo 0;
?>