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


class JUFormViewHelp extends JUFMViewAdmin
{
	public function display($tpl = null)
	{
		JToolBarHelper::title(JText::_('COM_JUFORM_PAGE_HELP'), 'help');

		$app = JFactory::getApplication();

		$app->input->set('tmpl', 'component');

		$settings = $app->input->get('settings', '', 'string');
		
		$this->settings = new JRegistry(unserialize(base64_decode($settings)));

		parent::display();
	}
}
