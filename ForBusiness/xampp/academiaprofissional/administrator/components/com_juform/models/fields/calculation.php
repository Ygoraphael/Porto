<?php
/**
 * ------------------------------------------------------------------------
 * JUForm for Joomla 3.x
 * ------------------------------------------------------------------------
 *
 * @copyright      Copyright (C) 2010-2016 JoomUltra Co., Ltd. All Rights Reserved.
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 * @author         JoomUltra Co., Ltd
 * @website        http://www.joomultra.com
 * @----------------------------------------------------------------------@
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class JFormFieldCalculation extends JFormField
{
	public $type = 'calculation';

	public function getLabel()
	{
		return '';
	}

	public function getInput()
	{
		$html = "Field calculation is used to calculate field value based on user defined formula. Please upgrade to <a href='http://www.joomultra.com/ju-form-comparison.html' target='_blank'>Paid Version</a> to use this feature";

		return $html;
	}
}

?>