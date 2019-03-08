<?php
	session_name('Demo');
	
    $username = "root"; 
    $password = "tml"; 
    $host = "127.0.0.1"; 
    $dbname = "demo_taskas"; 
     
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
    try { $db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options); } 
    catch(PDOException $ex){ die("Failed to connect to the database: " . $ex->getMessage());} 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
    header('Content-Type: text/html; charset=utf-8'); 
    session_start(); 
	
	function mysql__select( $query ) {
		global $db;
		try { 
            $stmt = $db->prepare($query); 
            $stmt->execute();		
        } 
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 
        
		if( $stmt->rowCount() > 0 ) {
			$data = []; 
			while( $row = $stmt->fetch() ) {
				$data[] = $row;
			}
			
			return $data;
		}
		else {
			$data = []; 
			return $data;
		}
	}
	
	function mysql__execute( $query ) {
		global $db;
		$resultado = 0;
		try { 
            $stmt = $db->prepare($query); 
            $resultado = $stmt->execute();		
        } 
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
		return $resultado;
	}
	
?>