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
		$app      = JFactory::getApplication();
		
		$cachable = false;
		$id       = $app->input->getInt('id', 0);
		
		$vName = $app->input->getCmd('view', 'form');
		$app->input->set('view', $vName);

		$user = JFactory::getUser();

		
		if ($user->get('id') ||
			($_SERVER['REQUEST_METHOD'] == 'POST' && (($vName == 'category' && $app->input->get('layout') != 'blog') || $vName == 'archive'))
		)
		{
			$cachable = false;
		}

		
		$safeurlparams = array('catid'   => 'INT', 'id' => 'INT', 'cid' => 'ARRAY', 'year' => 'INT', 'month' => 'INT', 'limit' => 'UINT', 'limitstart' => 'UINT',
		                       'showall' => 'INT', 'return' => 'BASE64', 'filter' => 'STRING', 'filter_order' => 'CMD', 'filter_order_Dir' => 'CMD', 'filter-search' => 'STRING', 'print' => 'BOOLEAN', 'lang' => 'CMD', 'Itemid' => 'INT');

		
		parent::display($cachable, $safeurlparams);

		return $this;
	}
}
