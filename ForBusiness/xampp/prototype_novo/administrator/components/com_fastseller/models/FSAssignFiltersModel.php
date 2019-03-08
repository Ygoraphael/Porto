<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class FSAssignFiltersModel {

	static private $productsCount = 0;
	static private $productTypesData = array();
	static private $parametersData = array();
	static private $executeTime = 0;
	static private $thereAreChildrenProducts = -1;


	static public function showFiltersAssignPage() {


		self::initProductTypeAndParameterData();

		self::loadView();
	//	require(FS_PATH .'views/FSAssignFiltersView.php');
		FSAssignFiltersView::printFiltersAssignPage();


	}


	static public function showProductDetailsAndPageNavigation() {

		self::initProductTypeAndParameterData();

		self::loadView();
		//require(FS_PATH .'views/FSAssignFiltersView.php');
		FSAssignFiltersView::printProductDetailsAndPageNavigation();

	}


	static public function showAvailableParametersForProductType() {

		self::initProductTypeAndParameterData();

		$pid = (int)JRequest::getVar('pid', null);
		$ptid = (int)JRequest::getVar('ptid', null);
		$record_id = (int)JRequest::getVar('record_id', null);
		$currentRow = JRequest::getVar('current_row', null);
		$assignedFilters = self::getAssignedFilterData($pid, $ptid, $record_id);


		//require(FS_PATH .'views/FSAssignFiltersView.php');
		self::loadView();

		FSAssignFiltersView::setCurrentRow($currentRow);
		echo FSAssignFiltersView::getProductFilterData($assignedFilters);

	}




	static public function getProductsData() {

		$db = JFactory::getDBO();
		$time_start = microtime(true);

		$keyword = JRequest::getVar('q','');
		$page = intval(JRequest::getCmd('page',1));
		$skip = intval(JRequest::getCmd('skip',0));
		$showonpage = intval(JRequest::getCmd('showonpage', FSConf::get('products_num_on_page')));
		$session_onpage = (isset($_COOKIE['onpage'])) ? $_COOKIE['onpage'] : null;
		if ($session_onpage) $showonpage = $session_onpage;

		$cid = JRequest::getVar('cid', null);
		$ptid = JRequest::getVar('ptid', null);
		$ppid = JRequest::getVar('ppid', null); // product parent id
		$orderby = JRequest::getVar('orderby', 'cat');
		$sc = JRequest::getVar('sc', 'asc');

		$show_sku = FSConf::get('show_sku');
		$showProductImage = 1;

		$columns = array("p.`virtuemart_product_id` as pid, plan.`product_name`, p.`published`");
		$columns[] = "GROUP_CONCAT(DISTINCT CAST(`product_type_id` AS CHAR) SEPARATOR ';') as ptids";
		$tables = array("`#__virtuemart_products` as p");
		$joins = array();
		$joins[] = "LEFT JOIN `#__virtuemart_products_". VMLANG ."` as plan ON p.`virtuemart_product_id`=plan.`virtuemart_product_id`";
		$joins[] ="LEFT JOIN `#__fastseller_product_product_type_xref` as ptx ON p.`virtuemart_product_id`=ptx.`product_id`";
		$where = array();

		if ($show_sku) $columns[] = '`product_sku`';

		if (($cid || $orderby == 'cat') && !$ppid) {
			$joins[] = "LEFT JOIN `#__virtuemart_product_categories` as pc ON p.`virtuemart_product_id`=pc.`virtuemart_product_id`";
			if ($orderby == 'cat') {
				$columns[] = "pc.`virtuemart_category_id` as cid, `category_name`";
				$joins[] = "LEFT JOIN `#__virtuemart_categories_". VMLANG ."` as clan ".
						"ON pc.`virtuemart_category_id`=clan.`virtuemart_category_id` ";
			}
		}


		if ($ppid) {
			$where[] = "(p.`virtuemart_product_id`=$ppid OR `product_parent_id`=$ppid)";
		} else if ($cid) {
			$where[] = "pc.`virtuemart_category_id`=$cid";
		}


		if ($ptid == 'wopt') {
			$where[] = "ptx.`product_type_id` IS NULL ";
		} else if ($ptid) {
			//$where[] = "ptx.`product_type_id`=$ptid";
			$where[] = "p.`virtuemart_product_id` IN (SELECT `product_id` FROM `#__fastseller_product_product_type_xref` WHERE `product_type_id`=$ptid)";
		}


		if (!$ppid) $where[] = "`product_parent_id`=0";


		if ($keyword) {
			$sq = "`product_name` LIKE '%$keyword%'";
			if ($show_sku) $sq .= " OR `product_sku` LIKE '%$keyword%'";
			if (is_numeric($keyword)) $sq.= " OR p.`virtuemart_product_id`=$keyword";

			$where[] = "($sq)";
		}


		if ($showProductImage) {
			$columns[] = "medias.`file_url_thumb` as thumb_image, medias.`file_url` as image";
			$joins[] = "LEFT JOIN `#__virtuemart_product_medias` as pm ON p.`virtuemart_product_id`=pm.`virtuemart_product_id`";
			$joins[] = "LEFT JOIN `#__virtuemart_medias` as medias ON pm.`virtuemart_media_id`=medias.`virtuemart_media_id`";
		}


		if (!FSConf::get('show_unpublished_products')) $where[] = "p.`published`='1'";



		$query = "SELECT SQL_CALC_FOUND_ROWS ". implode(', ', $columns) ." FROM (". implode(', ', $tables) .") ".
				implode(' ', $joins) ." WHERE ". implode(' AND ', $where);



		if ($orderby) {
			switch ($orderby) {
				case 'cat':
					if (!$ppid) {
						$ordercolumn = '`cid`, `pid`';
						break;
					}

				case 'pid':
					$ordercolumn = '`pid`';
					break;

				case 'pname':
					$ordercolumn = '`product_name`';
					break;

				case 'ptid':
					$ordercolumn = '`product_type_id`';
					break;
			}

			$query .= " GROUP BY p.`virtuemart_product_id`";
			$query .= " ORDER BY $ordercolumn ". strtoupper($sc);
		}

		$query .= " LIMIT $skip, $showonpage";

		$db->setQuery($query);
		$rows = $db->loadAssocList();

		// now for each product get it's assigned filters
		if ($rows) {

			$db->setQuery('SELECT FOUND_ROWS()');
			self::$productsCount = $db->loadResult();

			foreach ($rows as &$row) {
				$row['assigned_filters'] = ($row['ptids']) ? self::getAssignedFilterData($row['pid'], $row['ptids']) : '';
			}

		}


//		echo '<pre style="font-size:13px">';
		//echo $query;
//		var_dump($db);
//		print_r($rows);


		$time_end = microtime(true);
		$elapsed = $time_end - $time_start;

		self::$executeTime = $elapsed;

		return $rows;
	}


	static private function getAssignedFilterData($pid, $ptids_str, $record_id = null) {
//return null;
		$ptids = explode(';', $ptids_str);
		sort($ptids);

		$db = JFactory::getDBO();
		$d = array();

		foreach ($ptids as $ptid) {

			$q = "SELECT * FROM `#__fastseller_product_type_$ptid` WHERE `product_id`='$pid'";
			if ($record_id) $q .= " AND `id`='$record_id'";

			$db->setQuery($q);
			$res = $db->loadAssocList();

			if (!$res) continue;

			foreach ($res as $r) {
				$r['ptid'] = $ptid;
				$d[] = $r;
			}

		}

		return $d;
	}


	static private function initProductTypeAndParameterData() {

		$db = JFactory::getDBO();

		$q = "SELECT `product_type_id` as id, `product_type_name` as name FROM `#__fastseller_product_type`";
		$db->setQuery($q);
		$res = $db->loadAssocList();

		if ($res) {
			$d = array();
			foreach ($res as $r) {
				$d[$r['id']] = $r;
			}

			self::$productTypesData = $d;
		}


		$q = "SELECT * FROM `#__fastseller_product_type_parameter` ORDER BY `parameter_list_order`";
		$db->setQuery($q);
		$res = $db->loadAssocList();

		// structurize data for ease of access
		if ($res) {
			$d = array();
			foreach ($res as $r) {
				$d[$r['product_type_id']][] = $r;
			}

			self::$parametersData = $d;
		}

	}



	static public function processAssignProductTypeToProductEvent() {
		$pid = (int)JRequest::getVar('pid', null);
		$ptid = (int)JRequest::getVar('ptid', null);

		if (!$pid || !$ptid) die();

		$lastInsertId = self::assignProductToProductType($pid, $ptid);

		JRequest::setVar('record_id', $lastInsertId);

		self::showAvailableParametersForProductType();
	}


	static private function assignProductToProductType($pid, $ptid) {
		$db = JFactory::getDBO();

		$q = "INSERT INTO `#__fastseller_product_product_type_xref` SET `product_id`='$pid', `product_type_id`='$ptid'";
		$db->setQuery($q);
		$db->query();

		$q = "INSERT INTO `#__fastseller_product_type_$ptid` SET `product_id`='$pid'";
		$db->setQuery($q);
		$db->query();

		$lastInsertId = $db->insertid();

		return $lastInsertId;
	}


	static public function deleteProductTypeFromProduct() {
		$pid = (int)JRequest::getVar('pid', null);
		$ptids = JRequest::getVar('ptid', null);
		$recordId = (int)JRequest::getVar('record_id', null);


		$db = JFactory::getDBO();

		if ($recordId) { // delete just one PT

			$ptid = (int)$ptids[0];
			if (!$ptid) die();

			$q = "DELETE FROM `#__fastseller_product_type_$ptid` WHERE `id`='$recordId'";
			$db->setQuery($q);
			$db->query();

			$q = "DELETE FROM `#__fastseller_product_product_type_xref` WHERE `product_id`='$pid' AND `product_type_id`='$ptid' LIMIT 1";
			$db->setQuery($q);
			$db->query();

		} else { // delete all PTs for this product

			foreach ($ptids as $_ptid) {
				$ptid = (int)$_ptid;
				if (!$ptid) continue;

				$q = "DELETE FROM `#__fastseller_product_type_$ptid` WHERE `product_id`='$pid'";
				$db->setQuery($q);
				$db->query();

				$q = "DELETE FROM `#__fastseller_product_product_type_xref` WHERE `product_id`='$pid' AND `product_type_id`='$ptid'";
				$db->setQuery($q);
				$db->query();

			}

		}
	}


	public static function deleteProductTypesFromSelectedProducts() {
		$pids = JRequest::getVar('pids', null);
		$ptid = JRequest::getVar('ptid', null);
		$pidsArray = explode('|', $pids);

		if ($ptid) {
			self::_deleteProductsFromProductType($pidsArray, $ptid);
		} else {
			$db = JFactory::getDBO();
			$q = "SELECT `product_type_id` FROM `#__fastseller_product_type`";
			$db->setQuery($q);
			$ptids = $db->loadResultArray();
			foreach ($ptids as $ptid) self::_deleteProductsFromProductType($pidsArray, $ptid);
		}
	}


	private static function _deleteProductsFromProductType($pids = array(), $ptid) {
		if (!$pids || !$ptid) return;

		$db = JFactory::getDBO();
		$q = "DELETE FROM `#__fastseller_product_type_$ptid` WHERE `product_id` IN ('".
			implode("', '", $pids) ."')";
		$db->setQuery($q);
		$db->query();

		$q = "DELETE FROM `#__fastseller_product_product_type_xref` WHERE ".
			"`product_id` IN ('". implode("', '", $pids) ."')".
			" AND `product_type_id`='$ptid'";
		$db->setQuery($q);
		$db->query();
	}


	static public function saveProductParameterFilters() {

		$pid = (int)JRequest::getVar('pid', null);
		$ptid = (int)JRequest::getVar('ptid', null);
		$recordId = (int)JRequest::getVar('record_id', null);
		$paramName = JRequest::getVar('param_name', null);
		$filters = JRequest::getVar('filters', null);

		if (!$pid || !$ptid || !$recordId || !$paramName) die();

		$db = JFactory::getDBO();

		$value = ($filters) ? $db->quote($filters) : 'NULL';

		$q = "UPDATE `#__fastseller_product_type_". $ptid ."` SET `". $paramName ."`=". $value .
			" WHERE `id`='". $recordId ."' AND `product_id`='". $pid ."'";

		$db->setQuery($q);
		$db->query();

		//var_dump($db);
		//var_dump($filters);

		if (self::parameterFiltersAreDefinedManually($paramName)) {
			self::determineParameterMultiAssignedStatus($ptid, $paramName);
		} else {
			self::rebuildFiltersForParameter($ptid, $paramName);
		}
	}


	private static function parameterFiltersAreDefinedManually($paramName) {
		$db = JFactory::getDBO();

		$q = "SELECT `define_filters_manually` FROM `#__fastseller_product_type_parameter`".
			" WHERE `parameter_name`='$paramName'";
		$db->setQuery($q);

		return $db->loadResult();
	}



	private function determineParameterMultiAssignedStatus($ptid, $paramName) {
		$db = JFactory::getDBO();

		$q = "SELECT `$paramName` FROM `#__fastseller_product_type_$ptid` WHERE `$paramName` LIKE '%;%' LIMIT 1";
		$db->setQuery($q);
		$thereAreMultiAssigned = $db->loadResult();
		$paramType = ($thereAreMultiAssigned) ? 'V' : 'S';

		$q = "UPDATE `#__fastseller_product_type_parameter` SET `parameter_type`='$paramType'".
			" WHERE `product_type_id`='$ptid' AND `parameter_name`='$paramName'";

		$db->setQuery($q);
		$db->query();
	}


	// We collect all currently assigned filters for certain parameter,
	// sort them, and update "parameter_values" column
	static private function rebuildFiltersForParameter($ptid, $paramName) {
		$db = JFactory::getDBO();

		$q = "SELECT DISTINCT `$paramName` FROM `#__fastseller_product_type_$ptid`";
		$db->setQuery($q);
		$result = $db->loadResultArray();


		$data = array();
		$multiAssigned = false;
		foreach ($result as $r) {
			if (!$r) continue;

			$values = explode(';', $r);
			if (count($values) > 1) {
				$multiAssigned = true;
				foreach ($values as $value) {
					if (!in_array($value, $data)) $data[] = $value;
				}
			} else {
				if (!in_array($values[0], $data)) $data[] = $values[0];
			}
		}

		//if (!$data) return;

		//sort($data);
		if ($data) natcasesort($data);
		$filtersStr = implode(';', $data);

		// We need to keep eye on "parameter_values" VARCHAR(LIMIT)
		// If current filters string size larger then the limit -- increase it.
		// Update: we're using TEXT type now for paramter schema
		//$filtersColumnSize = self::getSizeOfParameterValuesColumn();
		//if (function_exists('mb_strlen')) {
		//	$currentFiltersLen = mb_strlen($filtersStr, 'UTF-8');
		//} else {
		//	$currentFiltersLen = strlen($filtersStr);
		//}
		//if ($currentFiltersLen > $filtersColumnSize)
		//	self::increaseParameterValuesColumnSize($currentFiltersLen);

		//print_r($data);
		//echo $multiAssigned;

		$paramType = ($multiAssigned) ? 'V' : 'S';

		$q = "UPDATE `#__fastseller_product_type_parameter` SET `parameter_type`='$paramType', `parameter_values`=".
			$db->quote($filtersStr) ." WHERE `product_type_id`='$ptid' AND `parameter_name`='$paramName'";


		$db->setQuery($q);
		$db->query();

		//var_dump($db);

	}


	static public function loadAvailableFiltersForParameter() {

		$ptid = (int)JRequest::getVar('ptid', null);
		$paramName = JRequest::getVar('param_name', null);

		if (!$ptid || !$paramName) die();

		$db = JFactory::getDBO();

		$q = "SELECT `parameter_values` FROM `#__fastseller_product_type_parameter`".
			" WHERE `product_type_id`='$ptid' AND `parameter_name`='$paramName' LIMIT 1";

		$db->setQuery($q);
		$filtersStr = $db->loadResult();

		//require(FS_PATH .'views/FSAssignFiltersView.php');
		self::loadView();
		FSAssignFiltersView::printAvailableFiltersForParameter($filtersStr);

	}


	static public function showCategoriesTree() {

		$db = JFactory::getDBO();
		$cid = (int)JRequest::getVar('cid', null);

		//if (!$cid) die();

		$q = "SELECT `category_child_id` as id, `category_name` as name, `published`".
			" FROM `#__virtuemart_categories` as c, `#__virtuemart_category_categories` as cc,".
			" `#__virtuemart_categories_". VMLANG ."` as c_lang".
			" WHERE c.`virtuemart_category_id`=cc.`category_child_id`".
			" AND cc.`category_parent_id`='$cid'".
			" AND c.`virtuemart_category_id`=c_lang.`virtuemart_category_id`".
			" ORDER BY c.`ordering`";

		$db->setQuery($q);
		$categoriesData = $db->loadAssocList();

		if (!$categoriesData) return;

		//require(FS_PATH .'views/FSAssignFiltersView.php');
		self::loadView();
		FSAssignFiltersView::printCategoriesTree($categoriesData);

	}


	static public function showProductTypesList() {

		$db = JFactory::getDBO();

		$q = "SELECT * FROM `#__fastseller_product_type` ORDER BY `product_type_list_order`";
		$db->setQuery($q);
		$ptsData = $db->loadAssocList();

		//require(FS_PATH .'views/FSAssignFiltersView.php');
		self::loadView();
		FSAssignFiltersView::printProductTypesList($ptsData);
	}


	static public function getCategoryName($cid) {

		$db = JFactory::getDBO();

		$q = "SELECT `category_name` FROM `#__virtuemart_categories_". VMLANG ."` WHERE `virtuemart_category_id`='$cid'";
		$db->setQuery($q);
		$categoryName = $db->loadResult();

		return $categoryName;
	}


	static public function product_has_children($pid) {

		if (!self::thereAreChildrenProducts()) return false;

		$db = JFactory::getDBO();
		$q = "SELECT COUNT(`virtuemart_product_id`) FROM `#__virtuemart_products` WHERE `product_parent_id`='$pid'".
			" LIMIT 1";
		$db->setQuery($q);

		return ($db->loadResult())? true : false;
	}


	static private function thereAreChildrenProducts() {

		if (self::$thereAreChildrenProducts !== -1) {
			return self::$thereAreChildrenProducts;
		}

		$db = JFactory::getDBO();
		$q = "SELECT `virtuemart_product_id` FROM `#__virtuemart_products`".
			" WHERE `product_parent_id`<>0".
			" LIMIT 1";

		$db->setQuery($q);
		$res = $db->loadResult();

		$thereAreChildrenProducts = ($res) ? true : false;
		self::$thereAreChildrenProducts = $thereAreChildrenProducts;

		return $thereAreChildrenProducts;
	}


	static public function showProductDescription() {

		$db = JFactory::getDBO();

		$pid = (int)JRequest::getVar('pid',null);

		$q = "SELECT `product_name`, `product_desc`, `product_s_desc`, medias.`file_url` as image".
			" FROM (`#__virtuemart_products_". VMLANG ."` as pl)".
			" LEFT JOIN `#__virtuemart_product_medias` as pm USING(`virtuemart_product_id`) ".
			" LEFT JOIN `#__virtuemart_medias` as medias ON pm.`virtuemart_media_id`=medias.`virtuemart_media_id` ".
			" WHERE `virtuemart_product_id`='$pid'";

		$db->setQuery($q);
		$productData = $db->loadAssoc();

		//require(FS_PATH .'views/FSAssignFiltersView.php');
		self::loadView();
		FSAssignFiltersView::printProductDescription($productData);
	}



	static public function loadView() {

		require(FS_PATH .'views/FSAssignFilters/FSAssignFiltersView.php');

	}


	//static public function getSizeOfParameterValuesColumn() {
	//	$db = JFactory::getDBO();
	//	$config = JFactory::getConfig();

	//	$q = "SELECT CHARACTER_MAXIMUM_LENGTH FROM INFORMATION_SCHEMA.COLUMNS".
	//		" WHERE table_name = '". $config->getValue( 'config.dbprefix' ). "fastseller_product_type_parameter'".
	//		" AND table_schema = '". $config->getValue( 'config.db' ) ."'".
	//		" AND column_name LIKE 'parameter_values'";

	//	$db->setQuery($q);
	//	$size = $db->loadResult();

	//	return $size;
	//}


	//static public function increaseParameterValuesColumnSize($curentSize) {
	//	$chunks = ceil($curentSize / 256);
	//	$next_column_size = $chunks * 256;

	//	$db = JFactory::getDBO();

	//	$q = "ALTER TABLE `#__fastseller_product_type_parameter` CHANGE `parameter_values` `parameter_values`".
	//		" VARCHAR( $next_column_size )";
	//	$db->setQuery($q);
	//	if ($db->query()) echo $next_column_size;
	//}






	//

	static public function getProductTypeName($id) {
		return self::$productTypesData[$id]['name'];
	}

	static public function getProductTypeParameters($id) {
		return self::$parametersData[$id];
	}

	static public function getAvailableProductTypes() {
		return self::$productTypesData;
	}

	static public function getExecuteTime() {
		return self::$executeTime;
	}

	static public function getProductsCount() {
		return self::$productsCount;
	}


}
