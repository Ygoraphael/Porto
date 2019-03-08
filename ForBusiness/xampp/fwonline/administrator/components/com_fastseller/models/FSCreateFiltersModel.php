<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class FSCreateFiltersModel {

	static private $productTypesCount = 0;

	static public function showProductTypesPage() {

		$ptData = self::getProductTypeData();

		self::loadView();
		FSCreateFiltersView::printProductTypesPage($ptData);

	}


	static public function showProductTypeParametersPage() {

		self::loadView();
		FSCreateFiltersView::printSelectedProductTypeParameters();

	}


	// Selected Product Type's Parameters
	static public function showParameterForm() {
		self::loadView();
		FSCreateFiltersView::printParameterForm();
	}


	static public function loadView() {

		require(FS_PATH .'views/FSCreateFilters/FSCreateFiltersView.php');

	}



	static private function getProductTypeData() {

		$db = JFactory::getDBO();
		$q = "SELECT * FROM `#__fastseller_product_type` ORDER BY `product_type_list_order`";
		$db->setQuery($q);
		$d = $db->loadAssocList();

		if ($d) {
			self::$productTypesCount = count($d);

			foreach ($d as $i => $pt){
				$q = "SELECT COUNT(*) FROM `#__fastseller_product_type_parameter` WHERE `product_type_id`='". $pt['product_type_id'] ."'";
				$db->setQuery($q);
				$res = $db->loadResult();
				$d[$i]['count'] = $res;
			}
		}

		return $d;
	}


	static public function saveProductTypeInfo() {
		$name = JRequest::getVar('name', null);
		$desc = $_POST['desc'];
		$ptid = (int)JRequest::getVar('ptid', null);
		$order = (int)JRequest::getVar('order', 0);

		$db = JFactory::getDBO();

		if ($ptid){ // update
			$q = "UPDATE `#__fastseller_product_type` SET ".
				"`product_type_name`=". $db->quote($name) .", ".
				"`product_type_description`=". $db->quote($desc) .", ".
				"`product_type_list_order`='". $order ."' ".
				"WHERE `product_type_id`='$ptid'";

			$db->setQuery($q);
			if ($db->query()) {
				echo $ptid;
			} else {
				echo '0';
			}
		} else { // insert new record
			//$q="INSERT INTO `#__fastseller_product_type` VALUES('',".$db->quote($name).",".$db->quote($desc).",'Y', '', '', '')";
			$q = "INSERT INTO `#__fastseller_product_type` SET ".
				"`product_type_name`=". $db->quote($name) .", ".
				"`product_type_description`=". $db->quote($desc) .", ".
				"`product_type_publish`='Y', ".
				"`product_type_list_order`='". $order ."'";

			$db->setQuery($q);
			if ($db->query()) {
				$id=$db->insertid();
				//$q = "CREATE TABLE IF NOT EXISTS `#__fastseller_product_type_$id` (".
				//	"`product_id` int(11) NOT NULL,  PRIMARY KEY (`product_id`) ) ".
				//	"ENGINE=MyISAM DEFAULT CHARSET=utf8";

				$q = "CREATE TABLE IF NOT EXISTS `#__fastseller_product_type_$id` (".
					"`id` int(11) NOT NULL AUTO_INCREMENT, ".
					"`product_id` int(11) NOT NULL, ".
					"PRIMARY KEY (`id`), ".
					"KEY `product_id` (`product_id`) ".
					") ENGINE=MyISAM  DEFAULT CHARSET=utf8";
				$db->setQuery($q);
				echo ($db->query()) ? $id : '0';
			} else {
				echo '0';
			}
		}

	}


	static public function deleteProductType() {
		$ptid = (int)JRequest::getVar('ptid', null);

		if (!$ptid) die();

		$db = JFactory::getDBO();
		$q = "DELETE FROM `#__fastseller_product_type` WHERE `product_type_id`='$ptid'";
		$db->setQuery($q);
		$db->query();

		$q = "DELETE FROM `#__fastseller_product_product_type_xref` WHERE `product_type_id`='$ptid'";
		$db->setQuery($q);
		$db->query();

		$q = "DELETE FROM `#__fastseller_product_type_parameter` WHERE `product_type_id`='$ptid'";
		$db->setQuery($q);
		$db->query();

		$q = "DROP TABLE IF EXISTS `#__fastseller_product_type_$ptid`";
		$db->setQuery($q);
		$db->query();
	}


	static public function reorderProductTypes() {
		$db = JFactory::getDBO();

		for ($i = 1; $i < 3; $i++) {
			$id = (int)JRequest::getVar('id'. $i, 0);
			$order = (int)JRequest::getVar('order'. $i, 0);

			if (!$id) continue;

			$q = "UPDATE `#__fastseller_product_type` SET `product_type_list_order`='". $order ."'".
				" WHERE `product_type_id`='". $id ."'";
			$db->setQuery($q);
			$db->query();
		}
	}


	static public function getProductTypeNameById($ptid) {

		if (!$ptid) return;

		$db = JFactory::getDBO();

		$q = "SELECT `product_type_name` FROM `#__fastseller_product_type` WHERE `product_type_id`='$ptid'";
		$db->setQuery($q);
		$ptName = $db->loadResult();

		return $ptName;
	}


	static public function getParametersDataForPT($ptid) {
		$db = JFactory::getDBO();

		$q = "SELECT * FROM `#__fastseller_product_type_parameter` WHERE `product_type_id`='$ptid'".
			" ORDER BY `parameter_list_order` ASC";
		$db->setQuery($q);
		$parameters = $db->loadAssocList();

		return $parameters;
	}


	static public function saveProductTypeParameters() {
		$keys = JRequest::getVar('key', null);
		$ptid = (int)JRequest::getVar('ptid', 0);

		ini_set('display_errors', 1);

		if (! $keys)
			return;

		foreach ($keys as $key) {

			$parameterName = trim(JRequest::getVar('parameter_name_'. $key, null));
			if (!$parameterName) continue;

			$parameter_name_active = JRequest::getVar('parameter_name_active_'. $key, null);
			//$parameterNameIsValid=($parameter_name==$parameter_name_active)? true : $this->parameterNameIsValid($parameter_name);
			//if(!$parameterNameIsValid) continue;

			if ($parameterName != $parameter_name_active && !self::parameterNameIsValid($parameterName))
				continue;

			$db = JFactory::getDBO();
			$parameter_label = JRequest::getVar('parameter_label_'. $key, null);
			$define_filters_manually = JRequest::getVar('define_filters_manually_'. $key, 0);
			$defined_filters = JRequest::getVar('defined_filters_'.$key, null);
			$parameter_description = JRequest::getVar('parameter_description_'. $key, null);
			$parameter_unit = JRequest::getVar('parameter_unit_'. $key, null);

			$show_in_cherry_picker = JRequest::getVar('show_in_cherry_picker_'. $key, 0);
			$parameter_mode = JRequest::getVar('mode_'. $key, 0);
			$show_quickrefine = JRequest::getVar('show_quickrefine_'. $key, 0);
			$collapse_state = JRequest::getVar('collapse_'. $key, 0);
			$hiding_filters = JRequest::getVar('hiding_filters_'. $key, 0);
			$see_more_size = JRequest::getVar('see_more_size_'. $key, 0);
			$scroll_height = JRequest::getVar('scroll_height_'. $key, 0);

			$attribs = new JRegistry;
			$attribs->loadArray(array(
				"show_in_cherry_picker" => $show_in_cherry_picker,
				"mode" => $parameter_mode,
				"show_quickrefine" => $show_quickrefine,
				"collapse" => $collapse_state,
				"hiding_filters" => $hiding_filters,
				"see_more_size" => $see_more_size,
				"scroll_height" => $scroll_height
			));

			//$parameter_type=JRequest::getVar('parameter_type_'. $key, null);
			//$parameter_multiselect=JRequest::getVar('parameter_multiselect_'.$key, null);
			$list_order = JRequest::getVar('list_order_'. $key, null);

			//if(!$parameter_multiselect) $parameter_multiselect='N';

			if ($define_filters_manually) {
				$defined_filters = self::validateDefinedFilters($defined_filters);
				//self::checkFiltersColumSize($defined_filters);
			}


			// We make it easier for user -- he doesn't need to specify Parameter Type.
			// He can choose to assign one or multiple filters directly on Assign Page.
			// Since "S" = "V" let's assume parameter_type = "S".
			$parameter_type = "S";

			if (!$parameter_name_active) { // it's a new parameter

				$q = "INSERT INTO `#__fastseller_product_type_parameter` SET ".
					"`product_type_id`='$ptid', ".
					"`parameter_name`='$parameterName', ".
					"`parameter_label`='$parameter_label', ".
					"`parameter_description`=". $db->quote($parameter_description) .", ".
					"`parameter_list_order`='$list_order', ".
					"`parameter_type`='$parameter_type', ".
					//"`parameter_values`=". $db->quote($defined_filters).", ".
					//"`parameter_multiselect`='$parameter_multiselect', ".
					"`parameter_unit`=". $db->quote($parameter_unit) .", ".
					// "`mode`='$parameter_mode', ".
					// "`show_quickrefine`='". $parameter_show_quickrefine ."', ".
					// "`collapse`='". $parameter_collapse_state ."', ".
					"`cherry_picker_attribs`='". $attribs->toString() ."', ".
					"`define_filters_manually`='$define_filters_manually'";

				if ($define_filters_manually) {
					$q .= ", `parameter_values`=". $db->quote($defined_filters);
				}

				//echo $q.'<br/><br/>';
				$db->setQuery($q);
				if ($db->query()) {
					$data_type = self::getSQLDataType($parameter_type);
					$q="ALTER TABLE `#__fastseller_product_type_$ptid` ADD `$parameterName` $data_type NULL DEFAULT NULL";

					//echo $q.'<br/><br/>';
					$db->setQuery($q);
					$db->query();

					$size = ($parameter_type == 'T') ? 128 : 0;
					self::addIndex("#__fastseller_product_type_$ptid", $parameterName, $size);
				}

			} else {

				$q = "UPDATE `#__fastseller_product_type_parameter` SET ".
					"`parameter_name`='$parameterName', ".
					"`parameter_label`='$parameter_label', ".
					"`parameter_description`=". $db->quote($parameter_description) .", ".
					"`parameter_list_order`='$list_order', ".
					//"`parameter_type`='$parameter_type', ".
					//"`parameter_values`=". $db->quote($defined_filters). ", ".
					//"`parameter_multiselect`='$parameter_multiselect', ".
					"`parameter_unit`=".$db->quote($parameter_unit).", ".
					// "`mode`='$parameter_mode', ".
					// "`show_quickrefine`='". $parameter_show_quickrefine ."', ".
					// "`collapse`='". $parameter_collapse_state ."', ".
					"`cherry_picker_attribs`='". $attribs->toString() ."', ".
					"`define_filters_manually`='$define_filters_manually'";

				if ($define_filters_manually) {
					$q .= ", `parameter_values`=". $db->quote($defined_filters);
				}

				$q .= " WHERE `product_type_id`='$ptid' AND `parameter_name`='$parameter_name_active'";

				// echo $q.'<br/><br/>';
				$db->setQuery($q);
				$db->query();

				// when parameter name is changed--update column name and index
				if ($parameterName != $parameter_name_active) {
					$data_type = self::getSQLDataType($parameter_type);
					$q = "ALTER TABLE `#__fastseller_product_type_$ptid` CHANGE ".
						"`$parameter_name_active` `$parameterName` $data_type ".
						"CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL";

					$db->setQuery($q);
					$db->query();

					self::dropIndex("#__fastseller_product_type_$ptid", $parameter_name_active);
					$size = ($parameter_type == 'T') ? 128 : 0;
					self::addIndex("#__fastseller_product_type_$ptid", $parameterName, $size);
				}
			}
		}
	}


	static public function deleteParameter() {
		$parameterName = JRequest::getVar('parameter_name', null);
		$ptid = (int)JRequest::getVar('ptid', null);

		if (!$parameterName || !$ptid) die();

		$db = JFactory::getDBO();

		$q = "DELETE FROM `#__fastseller_product_type_parameter` WHERE `product_type_id`='$ptid'".
			" AND `parameter_name`='$parameterName'";
		$db->setQuery($q);
		$db->query();

		$q = "ALTER TABLE `#__fastseller_product_type_$ptid` DROP `$parameterName`";
		$db->setQuery($q);
		$db->query();
	}


	static public function getOtherParameterNames() {
		$db = JFactory::getDBO();
		$ptid = (int)JRequest::getVar('ptid', 0);

		$q = "SELECT `parameter_name` FROM `#__fastseller_product_type_parameter` WHERE `product_type_id`<>'$ptid'";
		$db->setQuery($q);
		$names = $db->loadResultArray();

		return $names;
	}


	static private function parameterNameIsValid($name) {
		$db = JFactory::getDBO();

		$regex = '/[^a-zA-Z0-9_]/';
		if (preg_match($regex, $name)) return false;

		$q = "SELECT COUNT(`parameter_name`) FROM `#__fastseller_product_type_parameter` WHERE `parameter_name`='$name'";
		$db->setQuery($q);

		return ($db->loadResult() == 0) ? true : false;
	}


	private static function validateDefinedFilters($filtersStr){
		$filters = explode(';', $filtersStr);
		$temp = array();
		foreach ($filters as $filter) {
			$v = trim($filter);
			if ($v) $temp[] = $v;
		}
		$result = implode(';', $temp);

		return $result;
	}


	static private function getSQLDataType($type) {
		switch ($type){
			case 'S': $r = 'varchar(255)'; break;
			case 'V': $r = 'varchar(255)'; break;
			case 'I': $r = 'int(11)'; break;
			case 'T': $r = 'text'; break;
			case 'C': $r = 'char(1)'; break;
		}

		return $r;
	}


	static private function addIndex($table, $column, $_size = 0) {
		$db = JFactory::getDBO();
		$size = ($_size) ? "( $_size ) " : "";
		$q = "ALTER TABLE `$table` ADD INDEX `idx_$column` ( `$column` $size) ";
		$db->setQuery($q);
		$db->query();
	}


	static private function dropIndex($table, $column) {
		$db = JFactory::getDBO();
		$q = "ALTER TABLE `$table` DROP INDEX `idx_$column`";
		$db->setQuery($q);
		$db->query();
	}



	//private static function checkFiltersColumSize($filtersStr) {
	//	// --- COPIED FROM FSAssignFilterModel ---
	//	// We need to keep eye on "parameter_values" VARCHAR(LIMIT)
	//	// If current filters string size larger then the limit -- increase it.
	//	$filtersColumnSize = self::getSizeOfParameterValuesColumn();
	//	if (function_exists('mb_strlen')) {
	//		$currentFiltersLen = mb_strlen($filtersStr, 'UTF-8');
	//	} else {
	//		$currentFiltersLen = strlen($filtersStr);
	//	}

	//	if ($currentFiltersLen > $filtersColumnSize)
	//		self::increaseParameterValuesColumnSize($currentFiltersLen);
	//}


	//private static function getSizeOfParameterValuesColumn() {
	//	$db = JFactory::getDBO();
	//	$config = JFactory::getConfig();

	//	$q = "SELECT CHARACTER_MAXIMUM_LENGTH FROM INFORMATION_SCHEMA.COLUMNS".
	//		" WHERE table_name = '". $config->get('config.dbprefix'). "fastseller_product_type_parameter'".
	//		" AND table_schema = '". $config->get('config.db') ."'".
	//		" AND column_name LIKE 'parameter_values'";

	//	$db->setQuery($q);
	//	$size = $db->loadResult();

	//	return $size;
	//}


	//private static function increaseParameterValuesColumnSize($curentSize) {
	//	$chunks = ceil($curentSize / 256);
	//	$next_column_size = $chunks * 256;

	//	$db = JFactory::getDBO();

	//	$q = "ALTER TABLE `#__fastseller_product_type_parameter` CHANGE `parameter_values` `parameter_values`".
	//		" VARCHAR( $next_column_size )";
	//	$db->setQuery($q);
	//	if ($db->query())
	//		echo $next_column_size;
	//}



	public static function productTypesCount() {
		return self::$productTypesCount;
	}
}

?>
