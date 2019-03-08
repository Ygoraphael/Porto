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


jimport('joomla.application.component.controllerform');


class JUFormControllerBackendPermission extends JControllerForm
{
	
	protected $text_prefix = 'COM_JUFORM_BACKEND_PERMISSION';

	
	public function save($key = null, $urlVar = null)
	{
		
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		$app        = JFactory::getApplication();
		$permission = $app->input->get('permission', '', 'string');
		JTable::addIncludePath(JPATH_ADMINISTRATOR . "/components/com_juform/tables");
		$backendPermissionTable = JTable::getInstance("BackendPermission", "JUFormTable");
		if ($permission)
		{
			$permission = json_decode($permission);
			foreach ($permission AS $group => $permission_arr)
			{
				$backendPermissionTable->reset();
				if ($backendPermissionTable->load(array("group_id" => $group)))
				{
					$backendPermissionTable->bind(array("permission" => json_encode($permission_arr)));
					$backendPermissionTable->store();
				}
				else
				{
					$backendPermissionTable->bind(array("id" => 0, "group_id" => $group, "permission" => json_encode($permission_arr)));
					$backendPermissionTable->store();
				}
			}
		}

		$app->setUserState('com_juform.backendpermission.message', JText::_('COM_JUFORM_BACKEND_PERMISSION_SAVED'));
	}
}
