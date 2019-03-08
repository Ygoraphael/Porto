<?php 
    require("db.php"); 
    require("db2.php"); 
    $submitted_username = ''; 
	
    if(!empty($_POST)){ 
        $query = " 
            SELECT 
                cm id, 
                u_venduser, 
                u_vendpw, 
                email,
				cmdesc nicename
            FROM cm3 
            WHERE 
                u_venduser = '" . $_POST['username'] . "'";
        
		$data = mssql__select($query);
		$login_ok = false; 
		
		if( sizeof($data) > 0 ) {
			$cred = $data[0];
			
			if( $cred["u_vendpw"] == $_POST['password'] ) {
				$login_ok = true;
			}
		}
 
        if($login_ok){ 
            unset($cred['password']); 
			
            $_SESSION['user'] = $cred;  
            header("Location: home.php"); 
            die("Redirecting to: home.php"); 
        } 
        else{ 
            $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
			header("Location: index.php"); 
            die("Redirecting to: index.php");
        } 
    } 
?> 