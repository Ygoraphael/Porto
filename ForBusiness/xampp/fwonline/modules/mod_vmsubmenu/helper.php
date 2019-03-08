<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_vmsubmenu
 * @copyright	Copyright 2015 Linelab.org. All rights reserved.
 * @license		GNU General Public License version 2
 */
// no direct access
defined('_JEXEC') or die;
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'config.php');
if (!class_exists('shopFunctionsF'))require(JPATH_VM_SITE.DS.'helpers'.DS.'shopfunctionsf.php'); //dont remove that file it is actually in every view
class modMenuLinelabHelper
{
	static function getList(&$params)
	{
		$app = JFactory::getApplication();
		$menu = $app->getMenu();
		// If no active menu, use default
		$active = ($menu->getActive()) ? $menu->getActive() : $menu->getDefault();
		$user = JFactory::getUser();
		$levels = $user->getAuthorisedViewLevels();
		asort($levels);
		$key = 'menu_items'.$params.implode(',', $levels).'.'.$active->id;
		$cache = JFactory::getCache('mod_vmsubmenu', '');
		if (!($items = $cache->get($key)))
		{
			// Initialise variables.
			$list		= array();
			$db			= JFactory::getDbo();
			$path		= $active->tree;
			$start		= (int) $params->get('startLevel');
			$end		= (int) $params->get('endLevel');
			$showAll	= $params->get('showAllChildren'); 
			$items 		= $menu->getItems('menutype', $params->get('menutype'));
			$category_list = self::getCategoryTreeArray();
			$lastitem	= 0;
			if ($items) {
				foreach($items as $i => $item)
				{
					if (($start && $start > $item->level)
						|| ($end && $item->level > $end)
						|| (!$showAll && $item->level > 1 && !in_array($item->parent_id, $path))
						|| ($start > 1 && !in_array($item->tree[$start-2], $path))
					) {
						unset($items[$i]);
						continue;
					}
					$item->deeper = false;
					$item->shallower = false;
					$item->level_diff = 0;
					if (isset($items[$lastitem])) {
						$items[$lastitem]->deeper		= ($item->level > $items[$lastitem]->level);
						$items[$lastitem]->shallower	= ($item->level < $items[$lastitem]->level);
						$items[$lastitem]->level_diff	= ($items[$lastitem]->level - $item->level);
					}
					$item->parent = (boolean) $menu->getItems('parent_id', (int) $item->id, true);
					$lastitem			= $i;
					$item->active		= false;
					$item->flink = $item->link;
					switch ($item->type)
					{
						case 'separator':
							// No further action needed.
							continue;
						case 'url':
							if ((strpos($item->link, 'index.php?') === 0) && (strpos($item->link, 'Itemid=') === false)) {
								// If this is an internal Joomla link, ensure the Itemid is set.
								$item->flink = $item->link.'&Itemid='.$item->id;
							}
							break;
						case 'alias':
							// If this is an alias use the item id stored in the parameters to make the link.
							$item->flink = 'index.php?Itemid='.$item->params->get('aliasoptions');
							break;
						default:
							$router = JSite::getRouter();
							if ($router->getMode() == JROUTER_MODE_SEF) {
								$item->flink = 'index.php?Itemid='.$item->id;
							}
							else {
								$item->flink .= '&Itemid='.$item->id;
							}
							break;
					}
					if (strcasecmp(substr($item->flink, 0, 4), 'http') && (strpos($item->flink, 'index.php?') !== false)) {
						$item->flink = JRoute::_($item->flink, true, $item->params->get('secure'));
					}
					else {
						$item->flink = JRoute::_($item->flink);
					}
					$item->title = htmlspecialchars($item->title);
					$item->anchor_css = htmlspecialchars($item->params->get('menu-anchor_css', ''));
					$item->anchor_title = htmlspecialchars($item->params->get('menu-anchor_title', ''));
					$item->menu_image = $item->params->get('menu_image', '') ? htmlspecialchars($item->params->get('menu_image', '')) : '';
					if ($item->component=='com_virtuemart') {
						switch ($item->query['view'])  {
							case 'virtuemart':
							case 'categories':
							case 'category':
								$item->html_categories=self::buildTreeHTML($category_list, (int)@$item->query['virtuemart_category_id'], 0, $item, $params);
								break;
						}
					}
				}
				if (isset($items[$lastitem])) {
					$items[$lastitem]->deeper		= (($start?$start:1) > $items[$lastitem]->level);
					$items[$lastitem]->shallower	= (($start?$start:1) < $items[$lastitem]->level);
					$items[$lastitem]->level_diff	= ($items[$lastitem]->level - ($start?$start:1));
				}
			}
			$cache->store($items, $key);
		}
		return $items;
	}
	/**
	* This function is repsonsible for returning an array containing category information
	* @param boolean Show only published products?
	* @param string the keyword to filter categories
	*/
	public static function getCategoryTreeArray( $only_published=true, $keyword = "" ) {
			$database = JFactory::getDBO();
			// Get only published categories
			$query  = "SELECT c.virtuemart_category_id AS cid, cl.category_description, cl.category_name,cx.category_child_id as cid, cx.category_parent_id as parent,c.ordering, c.published
						FROM #__virtuemart_categories AS c, #__virtuemart_category_categories AS cx, #__virtuemart_categories_".str_replace('-','_',strtolower(JFactory::getLanguage()->getTag()))." AS cl WHERE ";
			$query .= "(c.virtuemart_category_id=cx.category_child_id) AND (c.virtuemart_category_id=cl.virtuemart_category_id) ";
		    $query.="AND c.published=1 \n";
			$query .= "ORDER BY c.ordering ASC, cl.category_name ASC";
			// initialise the query in the $database connector
			// this translates the '#__' prefix into the real database prefix
			$database->setQuery( $query );
			$category_list = $database->loadAssocList('cid');
			// Transfer the Result into a searchable Array
			// establish the hierarchy of the menu
			$children = array();
			// first pass - collect children
			foreach ($category_list as $v ) {
				$v['category_name']=htmlspecialchars($v['category_name']);
				$pt = $v['parent'];
				$list = @$children[$pt] ? $children[$pt] : array();
				array_push( $list, $v );
				$children[$pt] = $list;
			}
			return $children;
	}
	function buildTree(&$fields, $index=0) {
		$list=array();
		if ($fields[$index]) {
			if (is_array($fields[$index])) {
				foreach ($fields[$index] as $key => $value) {
					$list[$value['cid']]['cid']=$value['cid'];
					$list[$value['cid']]['name']=$value['category_name'];
					$list[$value['cid']]['desc']=$value['category_description'];
					$list[$value['cid']]['children']=self::buildTree($fields, $value['cid']);
				}
			}
		}
		return $list;
	}
	public static function buildTreeHTML(&$fields, $index=0, $level=0, &$item, &$params) {
		$html='';
		$subcolumn = $params->get('subcol', 4);
		$subcolumod = $params->get('subcolmod', 1);
		if (@$fields[$index]) {
			if (is_array($fields[$index])) {
				if (count($fields[$index])) {
					$html.="\n<ul class=\"level".$level." chield\">\n";
					foreach ($fields[$index] as $key => $value) {
						$children = self::buildTreeHTML($fields, $value['cid'], $level+1, $item, $params);
						$li_level = $level+1;
						$li_parent = $children!=''?' parent':''; 
						$li_active = $value['cid']==JRequest::getVar('virtuemart_category_id')?' active':'';
						$html.="\t<li class=\"labcol-".$subcolumn." level".$li_level.$li_parent.$li_active."\">";
						$link = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$value['cid'].'&Itemid='.$item->id);
						if (substr($link,0,11)=='/component/') {
							$link.='?Itemid='.$item->id;
						}
						$html.="<a class=\"boxhover\" href=\"".$link."\">".trim($value['category_name']).'</a>';
						if ($level == 0)  {
							if($params->get('showVirtueMartCategoryDescription')) {
								if (trim($value['category_description'])) {
										$html.='<div class="vmdesc">'.shopFunctionsF::limitStringByWord(trim(strip_tags($value['category_description'])),70,' ...').'</div>';
								}
							}
						}
						$html.=$children;
						$html.="\t</li>\n";
					}
					if ($level==0) {
						$modules=JModuleHelper::getModules('vmsubmodule');
						if (is_array($modules)) {
							if (count($modules)) {
								$html.="<li class=\"submx labcol-".$subcolumod."\">";
								foreach($modules as $module) {
									$html.=JModuleHelper::renderModule($module,array('style'=>'none'));
								}
								$html.="</li>";
							}
						}
					}
					$html.="</ul>\n";				
				}
			}
		}
		return $html;
	}
}