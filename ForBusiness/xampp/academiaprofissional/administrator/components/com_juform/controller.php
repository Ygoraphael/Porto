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


jimport('joomla.application.component.controller');


class JUFormController extends JControllerLegacy
{

	
	public function display($cachable = false, $urlparams = false)
	{
		
		$app = JFactory::getApplication();
		$app->input->set('view', $app->input->get('view', 'dashboard'));

		$view   = $app->input->get('view', 'dashboard');
		$layout = $app->input->get('layout', 'default');
		$id     = $app->input->getInt('id', 0);

		
		

		parent::display($cachable, $urlparams);

		return $this;
	}
}
