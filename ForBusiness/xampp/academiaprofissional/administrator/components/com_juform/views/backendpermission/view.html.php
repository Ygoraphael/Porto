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


class JUFormViewBackendPermission extends JUFMViewAdmin
{
	
	public function display($tpl = null)
	{
		
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));

			return false;
		}
		$app         = JFactory::getApplication();
		$saveMessage = $app->getUserState('com_juform.backendpermission.message');
		if ($saveMessage)
		{
			$app->enqueueMessage($saveMessage);
			$app->setUserState('com_juform.backendpermission.message', '');
		}

		
		$this->items            = $this->get('Items');
		$this->pagination       = $this->get('Pagination');
		$this->state            = $this->get('State');
		$this->canDo            = JUFormHelper::getActions();
		$this->groupCanDoManage = JUFormHelper::checkGroupPermission("backendpermission.edit");
		$this->groups           = self::getGroups();
		$this->taskArray        = self::getTaskArray();
		$this->value            = array();
		$this->script           = $this->get('Script');

		
		$this->addToolBar();

		
		parent::display($tpl);

		
		$this->setDocument();
	}

	
	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_JUFORM_BACKEND_PERMISSION'), 'shield');
		if ($this->canDo->get('core.edit') && $this->groupCanDoManage)
		{
			JToolBarHelper::apply('backendPermission.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('backendPermission.save', 'JTOOLBAR_SAVE');
		}
		JToolBarHelper::cancel('dashboard.show', 'JTOOLBAR_CANCEL');

		JToolBarHelper::divider();
		$bar = JToolBar::getInstance('toolbar');
		$bar->addButtonPath(JPATH_ADMINISTRATOR . "/components/com_juform/helpers/button");
		$bar->appendButton('JUHelp', 'help', JText::_('JTOOLBAR_HELP'));
	}

	
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_JUFORM_BACKEND_PERMISSION'));
		$script = "var token = '" . JSession::getFormToken() . "';";
		$document->addScriptDeclaration($script);
		$document->addScript(JUri::root() . $this->script);
	}

	protected function getGroups()
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('a.*');
		$query->from('#__usergroups AS a');
		$query->order('a.lft ASC');
		$db->setQuery($query);

		return $db->loadObjectList();
	}

	protected function getTaskArray()
	{
		$task_array                      = array();
		$task_array['forms']             = array("title" => JText::_('COM_JUFORM_SUBMENU_FORMS'));
		$task_array['submissions']       = array("title" => JText::_('COM_JUFORM_SUBMENU_SUBMISSIONS'));
		$task_array['plugins']           = array("title" => JText::_('COM_JUFORM_SUBMENU_PLUGINS'));
		$task_array['languages']         = array("title" => JText::_('COM_JUFORM_SUBMENU_LANGUAGES'));
		$task_array['backendpermission'] = array("title" => JText::_('COM_JUFORM_SUBMENU_BACKENDPERMISSION'));

		return $task_array;
	}

	public function getPermission($groupId)
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('permission');
		$query->from('#__juform_backend_permission');
		$query->where('group_id = ' . $groupId);
		$db->setQuery($query);
		$permission = $db->loadResult();
		if ($permission)
		{
			$registry = new JRegistry;
			$registry->loadString($permission);

			return $registry->toArray();
		}
		else
		{
			return null;
		}
	}
}
