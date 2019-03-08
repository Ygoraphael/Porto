<?php
/**
 * ------------------------------------------------------------------------
 * JUForm for Joomla 2.5, 3.x
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

jimport('joomla.plugin.plugin');

class plgExtensionJUForm extends JPlugin
{
	/**
	 * @var    integer Extension Identifier
	 * @since  1.6
	 */
	private $eid = 0;

	/**
	 * @var    JInstaller Installer object
	 * @since  1.6
	 */
	private $installer = null;

	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 * @since  3.1
	 */
	protected $autoloadLanguage = true;

	/**
	 * Handle post extension install update sites
	 *
	 * @param   JInstaller  $installer  Installer object
	 * @param   integer     $eid        Extension Identifier
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public function onExtensionAfterInstall($installer, $eid)
	{
		if(!JFolder::exists(JPATH_ADMINISTRATOR . '/components/com_juform/'))
		{
			return;
		}

		$this->installer = $installer;
		$this->eid       = $eid;

		// Check if is JUFM plugin
		if ($eid && $this->getPluginType())
		{
			if ($this->isPluginExisted())
			{
				$this->updateExtension();
			}
			else
			{
				$this->installExtension();
			}
		}
	}

	private function updateExtension()
	{
		$this->installExtension(true);
	}

	private function installExtension($update = false)
	{
		if (!$this->installer)
		{
			return false;
		}

		JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_juform/tables');
		$manifest      = $this->installer->manifest;
		$extensionType = $this->getPluginType();
		$folder        = $manifest->folder->__toString();
		$pluginTable   = JTable::getInstance('Plugin', 'JUFormTable');

		if ($update)
		{
			// Load JUFM plugin to table, return false if plugin does not exist
			if (!$pluginTable->load(
					array(
						'type'   => $extensionType,
						'folder' => $folder
					))
				&& !$pluginTable->load(
					array(
						'extension_id' => $this->eid
					)
				)
			)
			{
				return false;
			}
		}
		else
		{
			$pluginTable->id = 0;
		}

		$pluginTable->extension_id = $this->eid;
		$pluginTable->type         = $extensionType;
		$pluginTable->folder       = $folder;
		$pluginTable->title        = $manifest->name->__toString();
		$pluginTable->author       = $manifest->author ? $manifest->author->__toString() : '';
		$pluginTable->email        = $manifest->authorEmail ? $manifest->authorEmail->__toString() : '';
		$pluginTable->website      = $manifest->authorUrl ? $manifest->authorUrl->__toString() : '';
		$pluginTable->license      = $manifest->license ? $manifest->license->__toString() : '';
		$pluginTable->version      = $manifest->version ? $manifest->version->__toString() : '';
		$pluginTable->date         = $manifest->creationDate ? $manifest->creationDate->__toString() : '';
		$pluginTable->description  = $manifest->description ? $manifest->description->__toString() : '';

		if ($pluginTable->check() && $pluginTable->store())
		{
			switch ($this->getPluginType())
			{
				// Code for special plugin type here...
			}

			return true;
		}
		else
		{
			return false;
		}
	}

	/*
	 * Get JUFM plugin type
	 * */
	private function getPluginType()
	{
		if ($this->installer && !is_null($this->installer->manifest->attributes()->jufmplugintype))
		{
			return $this->installer->manifest->attributes()->jufmplugintype->__toString();
		}
		else
		{
			return false;
		}
	}

	/*
	 * Check if plugin record exist
	 * */
	private function isPluginExisted()
	{
		$extensionType = $this->getPluginType();
		$folder        = $this->installer->manifest->folder->__toString();

		if (!$extensionType || !$folder)
		{
			return false;
		}

		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('COUNT(*)');
		$query->from('#__juform_plugins');
		$query->where('(type = ' . $db->Quote($extensionType) . ' AND folder = ' . $db->Quote($folder) . ')', 'OR');
		$query->where('extension_id = ' . $db->Quote($this->eid));
		$db->setQuery($query);

		return $db->loadResult();
	}

	private function UninstallField($plugin)
	{
		$manifestFile = JPATH_SITE . '/components/com_juform/fields/' . $plugin->folder . '/' . $plugin->folder . '.xml';
		if (!JFile::exists($manifestFile))
		{
			return false;
		}

		$xml = JFactory::getXML($manifestFile);
		if (!$xml)
		{
			return false;
		}

		$db = JFactory::getDBO();

		// Delete fields
		$query = $db->getQuery(true);
		$query->select('id');
		$query->from('#__juform_fields');
		$query->where('plugin_id = ' . $plugin->id);
		$db->setQuery($query);
		$fieldIds = $db->loadColumn();
		if ($fieldIds)
		{
			JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_juform/tables');
			$fieldTable = JTable::getInstance("Field", "JUFormTable");
			foreach ($fieldIds AS $fieldId)
			{
				if (!$fieldTable->delete($fieldId))
				{
					return false;
				}
			}
		}

		return true;
	}

	private function UninstallTemplate($plugin)
	{
		$manifestFile = JPATH_SITE . '/components/com_juform/templates/' . $plugin->folder . '/' . $plugin->folder . '.xml';
		if (!JFile::exists($manifestFile))
		{
			return false;
		}

		$xml = JFactory::getXML($manifestFile);
		if (!$xml)
		{
			return false;
		}

		// Delete JU Form template, form still use old code, and will be generated new code from new template when save form again
		// Do nothing

		return true;
	}

	/**
	 * Handle extension uninstall
	 *
	 * @param   JInstaller  $installer  Installer instance
	 * @param   integer     $eid        Extension id
	 * @param   integer     $result     Installation result
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public function onExtensionAfterUninstall($installer, $eid, $result)
	{
		if(!JFolder::exists(JPATH_ADMINISTRATOR . '/components/com_juform/'))
		{
			return;
		}

		if ($result)
		{
			// Don't use JTable::getInstance here, but require file directly in case conflict if has many tables named "plugin"
			require_once JPATH_ADMINISTRATOR . "/components/com_juform/tables/plugin.php";
			$db = JFactory::getDbo();
			$pluginTable = new JUFormTablePlugin($db);

			// If can not find extension_id in plugin table => return
			if (!$pluginTable || !$pluginTable->load(array('extension_id' => $eid)))
			{
				return;
			}

			$folder = '';
			switch ($pluginTable->type)
			{
				case 'field':
					$this->UninstallField($pluginTable);
					$folder = JPATH_SITE . '/components/com_juform/fields/' . $pluginTable->folder;
					break;

				case 'template':
					$this->UninstallTemplate($pluginTable);
					$folder = JPATH_SITE . '/components/com_juform/templates/' . $pluginTable->folder;
					break;

				case 'plugin':
					$folder = JPATH_SITE . '/components/com_juform/plugins/' . $pluginTable->folder;
					break;
			}

			// Delete folder of each plugin type
			if ($folder && JFolder::exists($folder))
			{
				JFolder::delete($folder);
			}

			$pluginTable->delete();
		}
	}
}

?>