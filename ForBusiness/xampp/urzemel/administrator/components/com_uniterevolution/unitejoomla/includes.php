<?php
/* @package Unite Revolution Slider for Joomla 1.7-2.5
*/

// No direct access.
defined('_JEXEC') or die;

	/**
	 * include the unitejoomla library
	 */
	$currentDir = dirname(__FILE__)."/";
	
	jimport('joomla.application.component.view');
	jimport('joomla.application.component.controller');
	
	require_once $currentDir.'functions.class.php';
	require_once $currentDir.'functions_joomla.class.php';
	
	$isJoomla3 = UniteFunctionJoomlaRev::isJoomla3();
	
	if($isJoomla3){
		require_once $currentDir.'masterfield_joomla3.class.php';
		
		class JMasterViewUniteBaseRev extends JViewLegacy{};
		class JControllerUniteBaseRev extends JControllerLegacy{};
		
		
	}else{		//joomla 2.5
		require_once $currentDir.'masterfield.class.php';
		
		class JMasterViewUniteBaseRev extends JView{};
		class JControllerUniteBaseRev extends JController{};
	}
	
	
	require_once $currentDir.'db.class.php';
	require_once $currentDir.'admintable.class.php';
	require_once $currentDir.'image_view.class.php';
	require_once $currentDir.'masterview.class.php';
	require_once $currentDir.'controls.class.php';
	require_once $currentDir.'cssparser.class.php';
	require_once $currentDir.'toolbar.class.php';
			
	
?>