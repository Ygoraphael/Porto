<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class CPFilterConfiguration {

	private $_options = array();
	private $_assistOptions = array();


	public function initializeOptions($options) {
		$this->_options = $options;
	}


	public function get($key) {
		if (!isset($this->_options[$key])) {
			if ($this->_options['enable_debug'] == true) {
				//echo '<pre>';
				//echo 'Undefinded index: '. $key;
				//echo '</pre>';
				return false;
			} else {
				return false;
			}
		}

		return $this->_options[$key];
	}


	public function set($key, $value) {
		$this->_options[$key] = $value;
	}


	public function getOptionsForModule($mid) {
		$q = "SELECT `params` FROM `#__modules` WHERE id='$mid'";
		$db = JFactory::getDBO();
		$db->setQuery($q);
		$res = $db->loadResult();

		$params = json_decode($res, true);
		$this->initializeOptions($params);

		$this->set('module_id', $mid);

		//echo $mid;
		//var_dump($params);
	}


	// this is for assistant options in file
	public function initAssistOptions() {
		require(CP_ROOT .'assistOptions.php');
		$this->_assistOptions = $cpAssistOption;
	}


	public function getAssist($key) {
		return $this->_assistOptions[$key];
	}


	public function setAssist($key, $value) {
		$this->_assistOptions[$key] = $value;
	}


	public function writeAssistConfigurationToFile() {

		$s = "<?php \n".
			"defined('_JEXEC') or die('Restricted access');\n\n";

		foreach ($this->_assistOptions as $key => $value) {
			//$value = JRequest::getVar($key, 0);
			if (!is_numeric($value)) $value = "'". $value ."'";

			$s .= "\$cpAssistOption['$key'] = ". $value .";\n";
		}

		//$s .= "\n? >";

		$conffile = CP_ROOT .'assistOptions.php';
		if (!chmod($conffile, 0644))
			return 1;
		if (!$handle = fopen($conffile, "w"))
			return 1;
		if (fwrite($handle, $s) === false)
			return 1;
		fclose($handle);
		chmod($conffile, 0444);

		return 0;
	}

}
?>
