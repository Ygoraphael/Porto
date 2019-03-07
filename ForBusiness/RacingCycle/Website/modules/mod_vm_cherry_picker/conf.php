<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
class chpconf{
	protected static $options=array();
	
	static function setOptions($_options){
		self::$options=$_options;
	}
	
	static function option($key){
		return self::$options[$key];
	}
	
	static function set($key,$value){
		self::$options[$key]=$value;
	}
	
	static function getOptionsFromDB($mid){
		$q="SELECT `params` FROM `#__modules` WHERE id=$mid;";
		$db =& JFactory::getDBO();
		$db->setQuery($q);
		$res=$db->loadResult();
		$params=json_decode($res, true);
		self::setOptions($params);
		//echo $mid;
		//var_dump($params);
	}

}
?>