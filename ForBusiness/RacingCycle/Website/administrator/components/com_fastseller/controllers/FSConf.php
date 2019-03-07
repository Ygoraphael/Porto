<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class FSConf {

	static private $options = array();


	static public function getConfiguration(){
		require(FS_PATH .'configuration.php');
		self::$options = $confopt;
	}


	static public function get($name) {
		return self::$options[$name];
	}


	static public function set($name, $value) {
		self::$options[$name] = $value;
	}


	static public function printOptions() {
		echo '<pre>';
		print_r(self::$options);
		echo '</pre>';
	}



	static public function writeConfigurationToFile() {

		$s = "<?php defined('_JEXEC') or die('Restricted access');\n\n";

		foreach (self::$options as $i => $v) {
			$value = JRequest::getVar($i, 0);
			if (!is_numeric($value)) $value = "'". $value ."'";

			$s .= "\$confopt['$i'] = ". $value .";\n";
		}

		$s .= "\n?>";
		$conffile = FS_PATH .'configuration.php';
		$handle = fopen($conffile, "w");
		fwrite($handle, $s);
		fclose($handle);
	}
}
?>
