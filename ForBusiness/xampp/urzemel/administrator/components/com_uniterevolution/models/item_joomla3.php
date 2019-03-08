<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

abstract class UniteRevolutionModelItemCommon extends JModelAdmin
{
	
	protected function prepareTable($table){
		$this->prepareTableReal($table);
	}
		
}