<?php
require("db.php");
require("db2.php");
$submitted_username = '';
if (!empty($_POST)) {
    $query = " 
            SELECT 
                usstamp, 
                usercode username, 
                aextpw, 
                email,
				username nicename,
				u_ref
            FROM us 
            WHERE 
                usercode = '" . $_POST['username'] . "' and aextpw = '" . $_POST['password'] . "' and inactivo = 0
        ";

    $data = mssql__select($query);

    if( sizeof($data) ) {
        $data = $data[0];
        unset($data['aextpw']);
        $_SESSION['user'] = $data;
        
        header("Location: home.php");
        die("Redirecting to: home.php");
    } else {
        $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
        header("Location: index.php");
        die("Redirecting to: index.php");
    }
}
?> 