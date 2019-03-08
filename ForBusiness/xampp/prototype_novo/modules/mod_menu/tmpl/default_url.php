<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_menu
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Note. It is important to remove spaces between elements.
$class = $item->anchor_css ? 'class="'.$item->anchor_css.'" ' : '';
$title = $item->anchor_title ? 'title="'.$item->anchor_title.'" ' : '';
if ($item->menu_image) {
		$item->params->get('menu_text', 1 ) ?
		$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" /><span class="image-title">'.$item->title.'</span> ' :
		$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" />';
}
else { $linktype = $item->title;
}
$flink = $item->flink;
$flink = JFilterOutput::ampReplace(htmlspecialchars($flink));
$language = JFactory::getLanguage();

if( $item->note == "products" || $item->note == "brands" ) {
	
	if( $item->note == "products" ) {
		$db = JFactory::getDbo();
		$sql = "";
		$sql .= "select A.virtuemart_category_id, A.category_name, A.slug slugchild, E.slug slugfather ";
		$sql .= "
				from #__virtuemart_categories_" . strtolower(str_replace("-", "_", $language->getTag())) . " A
				inner join #__virtuemart_categories D on A.virtuemart_category_id = D.virtuemart_category_id
				inner join #__virtuemart_category_categories B on A.virtuemart_category_id = B.category_child_id
				inner join #__virtuemart_categories C on B.category_parent_id = C.virtuemart_category_id 
				inner join #__virtuemart_categories_" . strtolower(str_replace("-", "_", $language->getTag())) . " E on C.virtuemart_category_id = E.virtuemart_category_id
				";
		$sql .= "where C.phc_ref = 'PRODUTOS' and D.published = 1";
		
		$sql .= "
			order by A.category_name
		";
		
		$db->setQuery($sql);  
		$result = $db->loadObjectList();
		
		echo '<a href="'.JURI::base().$item->link.'" class="level-top">';
		echo '	<span>'.$item->title.'</span>';
		echo '</a>';
		
		echo '<div class="level0-wrapper dropdown-6col">';
		echo '<ul class="level0">';
		foreach ($result as $row) {
			echo '<li class="level1 nav-1-1 first">';
			echo '	<a data-category-id="'.$row->virtuemart_category_id.'" href="index.php/component/virtuemart/'.$row->slugfather.'/'.$row->slugchild.'" >';
			echo '	<span>'.$row->category_name.'</span>';
			echo '	</a>';
			echo '</li>';
		}
		echo '</ul>';
		echo '</div>';
	}
	// else if( $item->note == "brands" ) {
		// $db = JFactory::getDbo();
		// $sql = "";
		// $sql .= "select A.virtuemart_category_id, A.category_name, A.slug slugchild, E.slug slugfather ";
		// $sql .= "
				// from #__virtuemart_categories_" . strtolower(str_replace("-", "_", $language->getTag())) . " A
				// inner join #__virtuemart_categories D on A.virtuemart_category_id = D.virtuemart_category_id
				// inner join #__virtuemart_category_categories B on A.virtuemart_category_id = B.category_child_id
				// inner join #__virtuemart_categories C on B.category_parent_id = C.virtuemart_category_id
				// inner join #__virtuemart_categories_" . strtolower(str_replace("-", "_", $language->getTag())) . " E on C.virtuemart_category_id = E.virtuemart_category_id	
				// ";
		// $sql .= "where C.phc_ref = 'MARCAS' and D.published = 1";
		
		// $sql .= "
			// order by A.category_name
		// ";
		
		// $db->setQuery($sql);  
		// $result = $db->loadObjectList();
		
		// echo '<a href="'.JURI::base().$item->link.'" class="level-top">';
		// echo '	<span>'.$item->title.'</span>';
		// echo '</a>';
		
		// echo '<div class="level0-wrapper dropdown-6col">';
		// echo '<ul class="level0">';
		// foreach ($result as $row) {
			// echo '<li class="level1 nav-1-1 first">';
			// echo '	<a data-category-id="'.$row->virtuemart_category_id.'" href="index.php/component/virtuemart/'.$row->slugfather.'/'.$row->slugchild.'" >';
			// echo '	<span>'.$row->category_name.'</span>';
			// echo '	</a>';
			// echo '</li>';
		// }
		// echo '</ul>';
		// echo '</div>';
	// }
}
else {

switch ($item->browserNav) :
	default:
	case 0:
?><a <?php echo $class; ?>href="<?php echo $flink; ?>" <?php echo $title; ?>><span><?php echo $linktype; ?></span></a><?php
		break;
	case 1:
		// _blank
?><a <?php echo $class; ?>href="<?php echo $flink; ?>" target="_blank" <?php echo $title; ?>><span><?php echo $linktype; ?></span></a><?php
		break;
	case 2:
		// window.open
		$options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,'.$params->get('window_open');
			?><a <?php echo $class; ?>href="<?php echo $flink; ?>" onclick="window.open(this.href,'targetWindow','<?php echo $options;?>');return false;" <?php echo $title; ?>><span><?php echo $linktype; ?></span></a><?php
		break;
endswitch;

}
?>