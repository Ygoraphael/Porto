<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class FSHomeModel {


	static public function showFrontPageStats() {
		self::initAndShowStats();
	}


	static private function initAndShowStats() {

		if( !self::virtuemartIsInstalled() ) {
			echo '<div style="font:13px Trebuchet MS, Arial;color:#F700A3;margin:30px 0">We found that Virtuemart is not installed. You\'ll need it eventually in order to create products.</div>';
		}

		$d = array();
		$db = JFactory::getDBO();

		$q = "SELECT COUNT(*) FROM `#__virtuemart_products`";
		$db->setQuery($q);
		$total_products = $db->loadResult();
		$d['total_products'] = ($total_products) ? $total_products : 0;

		if ( $total_products ) {
			$q = "SELECT COUNT(*) FROM `#__virtuemart_products` WHERE `product_parent_id`<>0";
			$db->setQuery($q);
			$d['children'] = $db->loadResult();
			$d['parents'] = $d['total_products'] - $d['children'];

			$q = "SELECT COUNT(*) FROM `#__virtuemart_products` WHERE `product_parent_id`=0 AND `published`='1'";
			$db->setQuery($q);
			$d['parent_published'] = $db->loadResult();

			$q = "SELECT COUNT(*) FROM `#__virtuemart_products` WHERE `product_parent_id`<>0 AND `published`='1'";
			$db->setQuery($q);
			$d['children_published'] = $db->loadResult();
		}

		$q = "SELECT `product_type_id`,`product_type_name` FROM `#__fastseller_product_type` ORDER BY `product_type_id`";
		$db->setQuery($q);
		$pts = $db->loadAssocList();
		$d['pt_count'] = count($pts);

		if ($pts) {
			foreach ($pts as $i => $pt){
				$d[$i]['id'] = $pt['product_type_id'];
				$d[$i]['name'] = $pt['product_type_name'];
				$q = "SELECT COUNT(*) FROM `#__fastseller_product_product_type_xref` WHERE `product_type_id`={$pt['product_type_id']}";
				$db->setQuery($q);
				$d[$i]['products_assigned'] = $db->loadResult();

				$q = "SELECT COUNT(*) FROM `#__fastseller_product_type_{$pt['product_type_id']}`";
				$db->setQuery($q);
				$d[$i]['values_assigned'] = $db->loadResult();
			}
		}

		require( FS_PATH .'views/FSHome/FSHomeView.php' );
		FSHomeView::printStats($d);
	}


	static private function virtuemartIsInstalled() {

		$db = JFactory::getDBO();

		//$q="SELECT COUNT(*) FROM `#__components` WHERE `name`='VirtueMart'";
		$q = "SELECT COUNT(*) FROM `#__extensions` WHERE `name`='virtuemart' OR `name`='com_virtuemart'";
		$db->setQuery($q);
		$installed = $db->loadResult();
		return ($installed) ? true : false;
	}

}
