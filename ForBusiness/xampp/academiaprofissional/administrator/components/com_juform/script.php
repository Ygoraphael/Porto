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
defined('_JEXEC') or die ('Restricted access');

JLoader::register('JUFormInstallerHelper', __DIR__ . '/admin/helpers/installer.php');
JLoader::register('JUFormInstallerHelper', JPATH_ADMINISTRATOR . '/components/com_juform/helpers/installer.php');




class Com_JUFormInstallerScript
{
	
	public function install($parent)
	{
	}

	public function discover_install($parent)
	{
	}

	
	public function uninstall($parent)
	{
		
		$JUFormInstallerHelper = new JUFormInstallerHelper();
		$JUFormInstallerHelper->deleteJUFMMenu();
	}

	
	public function update($parent)
	{
		
		
		

		$old_version = $this->getOldVersion();
		
		if ($old_version < '1.1.2')
		{
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id, afterprocess_action_value')
				->from('#__juform_forms');
			$db->setQuery($query);
			$forms = $db->loadObjectList();

			foreach ($forms AS $form)
			{
				$registry     = new JRegistry($form->afterprocess_action_value);
				$new_registry = new JRegistry();

				$new_registry->set('redirect_url.url', $registry->get('redirect_url', ''));
				$new_registry->set('redirect_url.show_message', 0);
				$new_registry->set('redirect_menu.id', $registry->get('redirect_menu', ''));
				$new_registry->set('redirect_menu.show_message', 0);
				$new_registry->set('custom_message', $registry->get('show_message', ''));

				$new_action_value = $new_registry->toString();
				$query = $db->getQuery(true);
				$query->update('#__juform_forms')
					->set('afterprocess_action_value = ' . $db->quote($new_action_value))
					->where('id = ' . $form->id);
				$db->setQuery($query);
				$db->execute();
			}
		}
	}

	
	public function preflight($type, $parent)
	{
		
		$app = JFactory::getApplication();

		
		$phpVersion = floatval(phpversion());
		if ($phpVersion < 5.4)
		{
			$app->enqueueMessage('Installation was unsuccessful because you are using an unsupported version of PHP. JU Form supports only PHP5.4 and above. Please kindly upgrade your PHP version and try again.', 'error');

			return false;
		}

		if(version_compare(JVERSION, '3.4', 'lt'))
		{
			$app->enqueueMessage('Joomla version on your site is not supported. Please kindly upgrade your Joomla to 3.4+ and try again.', 'error');

			return false;
		}
	
		if(JFile::exists(JPATH_ADMINISTRATOR . '/components/com_juform/controllers/form.php'))
		{
			require_once JPATH_ADMINISTRATOR . '/components/com_juform/controllers/form.php';
			if(method_exists('JUFormControllerForm','saveCalculation'))
			{
				$app->enqueueMessage('You can not downgrade from Paid version to Lite version.', 'error');

				return false;
			}
		}
	}


	
	public function postflight($type, $parent)
	{
		if ($type == 'install')
		{
			
			$parent->getParent()->setRedirectURL('index.php?option=com_juform');
		}
	}

	public function getOldVersion()
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('manifest_cache')
			->from('#__extensions')
			->where('element = ' . $db->quote('com_juform'));
		$db->setQuery($query);
		$result   = $db->loadResult();
		$manifest = new JRegistry($result);

		return $manifest->get('version');
	}
}
