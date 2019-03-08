<?php
/**
 * @package         Articles Anywhere
 * @version         6.0.6
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2017 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

require_once __DIR__ . '/script.install.helper.php';

class PlgSystemArticlesAnywhereInstallerScript extends PlgSystemArticlesAnywhereInstallerScriptHelper
{
	public $name           = 'ARTICLES_ANYWHERE';
	public $alias          = 'articlesanywhere';
	public $extension_type = 'plugin';

	public function uninstall($adapter)
	{
		$this->uninstallPlugin($this->extname, 'editors-xtd');

		$this->enableCoreEditorPlugin();
	}

	public function onBeforeInstall($route)
	{
		if ($this->install_type == 'install')
		{
			$this->setOldTagCharacters();
		}
	}

	public function onAfterInstall($route)
	{
		$this->disableCoreEditorPlugin();
	}

	private function setOldTagCharacters()
	{
		$plugin = $this->getPluginParams();

		if (empty($plugin))
		{
			return;
		}

		$params = json_decode($plugin->params);

		if (isset($params->tag_characters_data))
		{
			return;
		}

		// Set tag_characters_data to old (pre v4.2.0) value
		$params->tag_characters_data = '{.}';

		$this->savePluginParams($plugin->extension_id, $params);
	}

	private function getPluginParams()
	{
		$query = $this->db->getQuery(true)
			->select(['extension_id', 'params'])
			->from($this->db->quoteName('#__extensions'))
			->where($this->db->quoteName('element') . ' = ' . $this->db->quote('articlesanywhere'))
			->where($this->db->quoteName('type') . ' = ' . $this->db->quote('plugin'))
			->where($this->db->quoteName('folder') . ' = ' . $this->db->quote('system'));
		$this->db->setQuery($query, 0, 1);

		return $this->db->loadObject();
	}

	private function savePluginParams($id, $params)
	{
		$params = json_encode($params);

		$query = $this->db->getQuery(true)
			->update('#__extensions')
			->set($this->db->quoteName('params') . ' = ' . $this->db->quote($params))
			->where($this->db->quoteName('extension_id') . ' = ' . (int) $id);
		$this->db->setQuery($query);
		$this->db->execute();

		JFactory::getCache()->clean('_system');
	}

	private function disableCoreEditorPlugin()
	{
		$query = $this->getCoreEditorPluginQuery()
			->set($this->db->quoteName('enabled') . ' = 0')
			->where($this->db->quoteName('enabled') . ' = 1');
		$this->db->setQuery($query);
		$this->db->execute();

		if (!$this->db->getAffectedRows())
		{
			return;
		}

		JFactory::getApplication()->enqueueMessage(JText::_('Joomla\'s own "Article" editor button has been disabled'), 'warning');
	}

	private function enableCoreEditorPlugin()
	{
		$query = $this->getCoreEditorPluginQuery()
			->set($this->db->quoteName('enabled') . ' = 1')
			->where($this->db->quoteName('enabled') . ' = 0');
		$this->db->setQuery($query);
		$this->db->execute();

		if (!$this->db->getAffectedRows())
		{
			return;
		}

		JFactory::getApplication()->enqueueMessage(JText::_('Joomla\'s own "Article" editor button has been re-enabled'), 'warning');
	}

	private function getCoreEditorPluginQuery()
	{
		return $this->db->getQuery(true)
			->update('#__extensions')
			->where($this->db->quoteName('element') . ' = ' . $this->db->quote('article'))
			->where($this->db->quoteName('folder') . ' = ' . $this->db->quote('editors-xtd'))
			->where($this->db->quoteName('custom_data') . ' NOT LIKE ' . $this->db->quote('%articlesanywhere_ignore%'));
	}
}