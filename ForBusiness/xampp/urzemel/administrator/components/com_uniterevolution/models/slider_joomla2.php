<?php

jimport('joomla.application.component.modeladmin');

abstract class UniteRevolutionModelSliderCommon extends JModelAdmin{
	
	protected function prepareTable(&$table){
		$this->prepareTableReal($table);
	}
	
}

?>