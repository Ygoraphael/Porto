<?php
/*
 * @package		Joomla.Framework
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */

class PhocaEmailHelper
{	
	function getPath() {
		$path = array();
		$path['path_abs']		= JPATH_ROOT . DS . 'phocaemail'. DS ;
		$path['path_abs_nods']	= JPATH_ROOT . DS . 'phocaemail' ;
		$path['path_rel']		= 'phocaemail/';
		$path['path_rel_full']	= JURI::base(true) . '/' . $path['path_rel'];
		
		return $path;
	}


	function getPhocaVersion()
	{
		$folder = JPATH_ADMINISTRATOR .DS. 'components'.DS.'com_phocaemail';
		if (JFolder::exists($folder)) {
			$xmlFilesInDir = JFolder::files($folder, '.xml$');
		} else {
			$folder = JPATH_SITE .DS. 'components'.DS.'com_phocaemail';
			if (JFolder::exists($folder)) {
				$xmlFilesInDir = JFolder::files($folder, '.xml$');
			} else {
				$xmlFilesInDir = null;
			}
		}

		$xml_items = '';
		if (count($xmlFilesInDir))
		{
			foreach ($xmlFilesInDir as $xmlfile)
			{
				if ($data = JApplicationHelper::parseXMLInstallFile($folder.DS.$xmlfile)) {
					foreach($data as $key => $value) {
						$xml_items[$key] = $value;
					}
				}
			}
		}
		
		if (isset($xml_items['version']) && $xml_items['version'] != '' ) {
			return $xml_items['version'];
		} else {
			return '';
		}
	}
	
	/**
	 * Method to display multiple select box
	 * @param string $name Name (id, name parameters)
	 * @param array $active Array of items which will be selected
	 * @param int $nouser Select no user
	 * @param string $javascript Add javascript to the select box
	 * @param string $order Ordering of items
	 * @param int $reg Only registered users
	 * @return array of id
	 */
	
	function usersList( $name, $active, $nouser = 0, $javascript = NULL, $order = 'name', $reg = 1 ) {
		
		$activeArray = $active;		
		$db		= &JFactory::getDBO();
		
		$and	= '';
		/*if ( $reg ) {
			// does not include registered users in the list
			$and = ' AND gid > 18';
		}*/

		$query = 'SELECT id AS value, name AS text'
		. ' FROM #__users'
		. ' WHERE block = 0'
		. $and
		. ' ORDER BY '. $order
		;
		$db->setQuery( $query );
		
		$users = $db->loadObjectList();
		

		$users = JHTML::_('select.genericlist',   $users, $name, 'class="inputbox" size="4" multiple="multiple"'. $javascript, 'value', 'text', $activeArray );

		return $users;
	}
	
	public static function groupslist($name, $selected, $attribs = '', $allowAll = true)
	{
		$db = JFactory::getDbo();
		$db->setQuery(
			'SELECT a.id AS value, a.title AS text, COUNT(DISTINCT b.id) AS level' .
			' FROM #__usergroups AS a' .
			' LEFT JOIN #__usergroups AS b ON a.lft > b.lft AND a.rgt < b.rgt' .
			' GROUP BY a.id' .
			' ORDER BY a.lft ASC'
		);
		$options = $db->loadObjectList();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseNotice(500, $db->getErrorMsg());
			return null;
		}

		for ($i = 0, $n = count($options); $i < $n; $i++) {
			$options[$i]->text = str_repeat('- ', $options[$i]->level).$options[$i]->text;
		}

		// If all usergroups is allowed, push it into the array.
		/*if ($allowAll) {
			array_unshift($options, JHtml::_('select.option', '', JText::_('JOPTION_ACCESS_SHOW_ALL_GROUPS')));
		}*/

		return JHtml::_('select.genericlist', $options, $name,
			array(
				'list.attr' => 'class="inputbox" size="4" multiple="multiple"',
				'list.select' => $selected
			)
		);
	}
}
?>