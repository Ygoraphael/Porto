<?php
/*------------------------------------------------------------------------
# Rox Topbar Sliding by http://www.themerox.com
# ------------------------------------------------------------------------
# Author    ThemeRox  http://www.themerox.com
# Copyright (C) 2010 - 2015 http://www.themerox.com All Rights Reserved.
# @license - Copyrighted Commercial
# Websites: http://www.themerox.com
-------------------------------------------------------------------------*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.form.formfield');

class JFormFieldAsset extends JFormField
{
	protected	$type = 'Asset';
	
	protected function getInput() {
		$doc = JFactory::getDocument();	
		$doc->addStylesheet(JURI::root(true).'/modules/mod_rox_topbar_sliding/elements/css/style.css');
		return null;
	}
} 
?>