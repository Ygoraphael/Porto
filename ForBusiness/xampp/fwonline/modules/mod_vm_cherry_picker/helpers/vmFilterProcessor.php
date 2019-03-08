<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class VMFilterProcessorPT {

	private static $module = null;
	private static $shouldRunInLegacyMode = -1;
	private static $low_price = 0;
	private static $high_price = 0;
	private static $priceAdjustments = -1;
	private static $parametersData = -1;
	private static $thereAreFiltersApplied = -1;

	private static $appliedManufacturerIds = -1;
	private static $thereAreManufacturersApplied = -1;

	private static $subcategoryIds = -1;


	public static function getFilterSelection() {
		$parameters = self::getParameters();

		if (empty($parameters))
			return null;

		$db = JFactory::getDBO();

		$where = array();
		$appliedProductTypeIDs = array();
		foreach ($parameters as $parameter) {
			$appliedFilters = JRequest::getVar($parameter['parameter_name'], null);

			if ($appliedFilters) {
				$ptid = $parameter['product_type_id'];

				if (!in_array($ptid, $appliedProductTypeIDs))
					$appliedProductTypeIDs[] = $ptid;

				$attributes = new JRegistry;
				$attributes->loadString($parameter['cherry_picker_attribs']);

				$multiAssigned = ($parameter['parameter_type'] == "V") ? true : false;
				$where[] = self::getParameterWhereClause(
							$ptid,
							$parameter['parameter_name'],
							$appliedFilters,
							$multiAssigned,
							$attributes->get('mode'));
			}
		}


		// print_r($where);
		// print_r($appliedProductTypeIDs);


		$instock_filter_applied = JRequest::getVar('instock', 0);
		if ($instock_filter_applied)
			$where[] = "p.`product_in_stock`>0";

		self::$thereAreFiltersApplied = ($where) ? 1 : 0;

		if ($where) {
			$whereStr = implode(' AND ', $where);
			$joins = '';
			foreach ($appliedProductTypeIDs as $appliedProductTypeID) {
				if (self::shouldRunInLegacyMode()) {
					$joins .= " JOIN `#__vm_product_type_$appliedProductTypeID` as pt$appliedProductTypeID".
						" ON p.`virtuemart_product_id`=pt$appliedProductTypeID.`product_id`";
				} else {
					$joins .= " JOIN `#__fastseller_product_type_$appliedProductTypeID` as pt$appliedProductTypeID".
						" ON p.`virtuemart_product_id`=pt$appliedProductTypeID.`product_id`";
				}
			}

			// maks: pull parent products from it's children
			// Set this var to TRUE
			// Note 1: In order for Parent to appear in results it must have ALL Product Types that its
			// child product has.
			$showParentProductsOfMatchedChildren = 0;
			if ($showParentProductsOfMatchedChildren) {
				$childWhere = "p.`virtuemart_product_id` IN (".
					" SELECT `product_parent_id`".
					" FROM `#__virtuemart_products` as p".
					$joins .
					" WHERE `product_parent_id` <> 0".
					" AND ". $whereStr .
				")";
				$whereStr = "(". $whereStr . " OR ". $childWhere .")";
			}


			return array("join" => $joins, "where" => $whereStr);
		}


		return null;
	}


	public static function thereAreFiltersApplied() {
		if (self::$thereAreFiltersApplied != -1) return self::$thereAreFiltersApplied;

		$parameters = self::getParameters();
		$filtersApplied = 0;
		foreach ($parameters as $parameter) {
			if (JRequest::getVar($parameter['parameter_name'], null)) {
				$filtersApplied = 1;
				break;
			}
		}

		if (self::$low_price || self::$high_price)
			$filtersApplied = 1;

		self::$thereAreFiltersApplied = $filtersApplied;
		return $filtersApplied;
	}


	private static function getParameters() {

		if (self::$parametersData != -1) return self::$parametersData;

		$db = JFactory::getDBO();
		if (self::shouldRunInLegacyMode()) {
			$q = "SELECT * FROM `#__vm_product_type_parameter` ORDER BY `product_type_id`";
		} else {
			$q = "SELECT * FROM `#__fastseller_product_type_parameter` ORDER BY `product_type_id`";
		}
		$db->setQuery($q);
		$parameters = $db->loadAssocList();
		self::$parametersData = $parameters;

		return $parameters;
	}


	public static function getManufacturersSelection() {
		$appliedManufacturerIds = self::getAppliedManufacturerIds();

		if ($appliedManufacturerIds) {
			$where = "`#__virtuemart_product_manufacturers`.`virtuemart_manufacturer_id` IN ('".
				implode("', '", $appliedManufacturerIds) ."')";
			return $where;
		} else
			return '';
	}


	private static function getAppliedManufacturerIds() {
		if (self::$appliedManufacturerIds != -1)
			return self::$appliedManufacturerIds;

		$db = JFactory::getDBO();
		$q = "SELECT `slug` FROM `#__virtuemart_manufacturercategories_". VMLANG ."`";
		$db->setQuery($q);
		$mf_categories = $db->loadResultArray();

		$delimiter = '|';
		$appliedManufacturersSlug = array();
		foreach ($mf_categories as $mf_category) {
			$appliedStr = JRequest::getVar($mf_category, '');
			if ($appliedStr) {
				$appliedArray = explode($delimiter, $appliedStr);
				foreach ($appliedArray as $value) {
					if (trim($value))
						$appliedManufacturersSlug[] = $value;
				}
			}
		}

		if (!$appliedManufacturersSlug) {
			self::$appliedManufacturerIds = 0;
			self::$thereAreManufacturersApplied = 0;
			return 0;
		}

		self::$thereAreManufacturersApplied = 1;

		$q = "SELECT `virtuemart_manufacturer_id` FROM `#__virtuemart_manufacturers_". VMLANG ."`".
			" WHERE `slug` IN ('". implode("', '", $appliedManufacturersSlug) ."')";
		$db->setQuery($q);
		$appliedIds = $db->loadResultArray();
		self::$appliedManufacturerIds = $appliedIds;

		return $appliedIds;
	}


	public static function thereAreManufacturersApplied() {
		if (self::$thereAreManufacturersApplied != -1)
			return self::$thereAreManufacturersApplied;

		$manufacturersApplied = self::getAppliedManufacturerIds();
		self::$thereAreManufacturersApplied = ($manufacturersApplied) ? 1 : 0;

		return self::$thereAreManufacturersApplied;
	}


	private static function getParameterWhereClause($ptid, $parameterName, $applied_filters, $multiAssigned, $parameterMode) {
		require_once(dirname(__FILE__) ."/../defines.php");
		// Allows: Simple List or Checkbox List
		// Not allows: Drop-down and Simple Drop-down
		//$layoutAllowsTrackbar = true;
		$layout = self::getModuleOption('layout');
		$layoutAllowsTrackbar = ($layout == CP_LAYOUT_SIMPLE_LIST || $layout == CP_LAYOUT_CHECKBOX_LIST);

		$db = JFactory::getDBO();
		//$ptTableAlias = "pt". $ptid;
		$column = "pt". $ptid .".`". $parameterName ."`";

		if ($parameterMode == CP_TRACKBAR_TWO_KNOBS && $layoutAllowsTrackbar) {
			$delimiter = '|';
			$urlValues = explode($delimiter, $applied_filters);
			$urlValueLeft = $urlValues[0];
			$urlValueRight = (isset($urlValues[1])) ? $urlValues[1] : null;
			//$s = "$ptTableAlias.`$parameterName`";
			$s = $column;
			if ($urlValueLeft && !$urlValueRight) {
				$s .= ">=". $urlValueLeft ."";
			} else if (!$urlValueLeft && $urlValueRight) {
				$s .= "<=". $urlValueRight ."";
			} else if ($urlValueLeft == $urlValueRight) {
				$s .= "=". $urlValueLeft;
			} else {
				$s .= " BETWEEN ". $urlValueLeft ." AND ". $urlValueRight ."";
			}
		} else if ($parameterMode == CP_TRACKBAR_ONE_KNOB_COMPARE &&
			$layoutAllowsTrackbar)
		{
			$s = $column ."<=". $applied_filters;
		} else {
			$array = explode('|', $applied_filters);
			if ($multiAssigned) {
				$where = array();
				foreach ($array as $filter) {
					$where[] = "FIND_IN_SET(". $db->quote($filter) .
						", REPLACE(". $column .", ';', ','))";
						//", REPLACE($ptTableAlias.`". $parameterName ."`, ';', ','))";
					// Use this LIKE comparison instead of FIND_IN_SET if there is a need
					// to search among filters that contain comma character.
					// Make sure to do the same in filterData.php at getParameterWhereClause().
					// $where[] = $ptTableAlias .".`". $parameterName . "` LIKE '%". $filter ."%'";
				}
				$s = "(". implode(' OR ', $where) .")";
			} else {
				//$s = "$ptTableAlias.`$parameterName` IN ('". implode("', '", $array) ."')";
				$s = $column ." IN ('". implode("', '", $array) ."')";
			}
		}

		return $s;
	}


	public static function getSubcategoryIds($cid) {
		if (! $cid)
			return 0;

		if (self::$subcategoryIds != -1)
			return self::$subcategoryIds;

		$ids = self::walkTree($cid);
		// var_dump($ids);
		self::$subcategoryIds = $ids;

		return $ids;
	}


	private function walkTree($cids) {
		$db = JFactory::getDBO();
		$cids = (array)$cids;

		$q = "SELECT `category_child_id` FROM `#__virtuemart_category_categories` as cc".
			" LEFT JOIN `#__virtuemart_categories` as c ON cc.`category_parent_id`=c.`virtuemart_category_id`".
			" WHERE cc.`category_parent_id` IN (". implode(", ", $cids) .") AND c.`published`=1";
		$db->setQuery($q);
		$array = $db->loadResultArray();

		if ($array) {
			$children = self::walkTree($array);
			$array = array_merge($array, $children);
		}

		return $array;
	}


	public static function getPriceSelection() {
		self::getAppliedPrices();

		$lp = self::$low_price;
		$hp = self::$high_price;

		if (!$lp && !$hp)
			return false;

		defined('CP_INCLUDE_PRODUCT_PRICE_ADJUSTMENT')
			|| define('CP_INCLUDE_PRODUCT_PRICE_ADJUSTMENT', 1);
		defined('CP_INCLUDE_MANUFACTURERS_PRICE_ADJUSTMENT')
			|| define('CP_INCLUDE_MANUFACTURERS_PRICE_ADJUSTMENT', 2);
		$include_category_price_adjustment = self::getModuleOption('include_category_price_adjustment');
		$include_individual_price_adjustment = self::getModuleOption('include_individual_price_adjustment');
		if ($include_category_price_adjustment) {
			$lp = self::adjustPrice($lp);
			$hp = self::adjustPrice($hp);
		}

		$joins = array();
		$where = array();
		$join_manufacturers = false;
		if ($include_individual_price_adjustment != 0) {
			if ($include_individual_price_adjustment == CP_INCLUDE_PRODUCT_PRICE_ADJUSTMENT) {
				$joins[] = "LEFT JOIN `#__virtuemart_calcs` as calcs".
					" ON pp.`product_tax_id`=calcs.`virtuemart_calc_id`";

			} if ($include_individual_price_adjustment == CP_INCLUDE_MANUFACTURERS_PRICE_ADJUSTMENT) {
				$join_manufacturers = true;
				// $joins[] = "JOIN `#__virtuemart_product_manufacturers` as vpm USING(`virtuemart_product_id`)";
				$joins[] = "LEFT JOIN `#__virtuemart_calc_manufacturers` as calc_manuf".
					" ON `#__virtuemart_product_manufacturers`.`virtuemart_manufacturer_id`=calc_manuf.`virtuemart_manufacturer_id`";
				$joins[] = "LEFT JOIN `#__virtuemart_calcs` as calcs".
					" ON calc_manuf.`virtuemart_calc_id`=calcs.`virtuemart_calc_id`";
			}

			$where[] = "(calcs.`published`=1 OR calcs.`virtuemart_calc_id` IS NULL)";

			// here comes some Virtuemart price discounts HELL
			if ($lp && $hp && $lp != $hp) {
				$where[] = "(CASE WHEN `calc_value_mathop` = '+' THEN ".
						" pp.`product_price`*(1+((select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1 limit 1)/100)) BETWEEN (". $lp ." - `calc_value`)".
						" AND (". $hp ." - `calc_value`)".
					" WHEN `calc_value_mathop` = '-' THEN ".
						" pp.`product_price`*(1+((select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1 limit 1)/100)) BETWEEN (". $lp ." + `calc_value`)".
						" AND (". $hp ." + `calc_value`)".
					" WHEN `calc_value_mathop` = '+%' THEN".
						" pp.`product_price`*(1+((select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1 limit 1)/100)) BETWEEN (". $lp ." / (1 + `calc_value` / 100))".
						" AND (". $hp ." / (1 + `calc_value` / 100))".
					" WHEN `calc_value_mathop` = '-%' THEN".
						" pp.`product_price`*(1+((select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1 limit 1)/100)) BETWEEN (". $lp ." / (1 - `calc_value` / 100))".
						" AND (". $hp ." / (1 - `calc_value` / 100))".
					" ELSE pp.`product_price`*(1+((select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1 limit 1)/100)) BETWEEN ". $lp ." AND ". $hp .
					" END)";

			} else {
				if ($lp && !$hp) {
					$operation = '>=';
					$search_price = $lp;
				} else if ( !$lp && $hp) {
					$operation = '<=';
					$search_price = $hp;
				} else {
					$operation = '=';
					$search_price = $lp;
				}


				$where[] = "(CASE WHEN `calc_value_mathop` = '+' THEN ".
						" pp.`product_price`*(1+((select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1 limit 1)/100)) ". $operation ." (". $search_price ." - `calc_value`)".
					" WHEN `calc_value_mathop` = '-' THEN ".
						" pp.`product_price`*(1+((select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1 limit 1)/100)) ". $operation ." (". $search_price ." + `calc_value`)".
					" WHEN `calc_value_mathop` = '+%' THEN ".
						" pp.`product_price`*(1+((select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1 limit 1)/100)) ". $operation ." (". $search_price ." / (1 + `calc_value` / 100))".
					" WHEN `calc_value_mathop` = '-%' THEN ".
						" pp.`product_price`*(1+((select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1 limit 1)/100)) ". $operation ." (". $search_price ." / (1 - `calc_value` / 100))".
					" ELSE pp.`product_price`*(1+((select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1 limit 1)/100)) ". $operation ." ". $search_price .
					" END)";
			}

		} else {		// do a regular search without discounts
				if ($lp && !$hp) {
					$where[] = "pp.`product_price`*(1+((select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1 limit 1)/100))>=". $lp;
				} else if (!$lp && $hp) {
					$where[] = "pp.`product_price`*(1+((select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1 limit 1)/100))<=". $hp;
				} else if ($lp == $hp) {
					$where[] = "pp.`product_price`*(1+((select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1 limit 1)/100))=". $lp;
				} else {
					$where[] = "pp.`product_price`*(1+((select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1 limit 1)/100)) BETWEEN $lp AND $hp";
				}
			}

		// if ($tax) {
		// 	$lp = $lp / $tax;
		// 	$hp = $hp / $tax;
		// }

		// if ($lp && !$hp) {
		// 	return "`product_price`*(1+((select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1 limit 1)/100))>=". $lp;
		// }
		// else if (!$lp && $hp) {
		// 	return "`product_price`*(1+((select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1 limit 1)/100))<=". $hp;
		// }
		// else if ($lp && $hp && ($hp > $lp)) {
		// 	return "`product_price`*(1+((select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1 limit 1)/100)) BETWEEN ". $lp ." AND ". $hp;
		// }
		if ( !$where)
			return false;
		else {
			return array(
				"join" => implode(' ', $joins),
				"where" => implode(' AND ', $where),
				"join_manufacturers" => $join_manufacturers
			);
		}
	}


	private static function getAppliedPrices() {
		$lp = self::validatePriceValue(JRequest::getVar('low-price', 0));
		$hp = self::validatePriceValue(JRequest::getVar('high-price', 0));
		if ( !($lp && $hp && $hp < $lp)) {
			self::$low_price = $lp;
			self::$high_price = $hp;
		}
	}


	private static function validatePriceValue($price) {
		// not empty
		if (empty($price)) return false;
		// not -X or 0
		if ($price <= 0) return false;
		// change , with .
		$price = str_replace(',','.',$price);
		if (!is_numeric($price)) return false;
		// remove leading/trailing zeros
		$price += 0;

		return $price;
	}


	/**
	* Adjust prices according to current category and table #__virtuemart_calcs
	* @param $forwardOrBackward Price could be adjusted either from Base to Resulting
	*	or back from already adjusted to Base.
	*/
	public function adjustPrice($price) {
		if (! $price)
			return 0;

		if (self::$priceAdjustments == -1) {
			$db = JFactory::getDBO();
			$cid = JRequest::getVar('virtuemart_category_id', 0);
			if (! $cid) {
				self::$priceAdjustments = null;
				return $price;
			}

			$q = "SELECT `calc_value_mathop` as operation, `calc_value` as value".
				" FROM (`#__virtuemart_calcs` as calcs)".
				" JOIN `#__virtuemart_calc_categories` USING (`virtuemart_calc_id`)".
				" WHERE `virtuemart_category_id`='". $cid ."'".
				" AND calcs.`published`=1".
				" ORDER BY `ordering`";

			$db->setQuery($q);
			$priceAdjustments = $db->loadAssocList();
			self::$priceAdjustments = $priceAdjustments;
		} else
			$priceAdjustments = self::$priceAdjustments;


		if (! $priceAdjustments)
			return $price;

		$i = count($priceAdjustments);
		// we "de-apply" adjustments in other direction then they were applied
		while ($i--) {
			switch ($priceAdjustments[$i]['operation']) {
				case '+':
					$price -= $priceAdjustments[$i]['value'];
					break;

				case '-':
					$price += $priceAdjustments[$i]['value'];
					break;

				case '+%':
					$price /= 1 + $priceAdjustments[$i]['value'] / 100;
					break;

				case '-%':
					$price /= 1 - $priceAdjustments[$i]['value'] / 100;
					break;
			}
		}

		return $price;
	}


	private function getModuleOption($optionName) {
		if (self::$module)
			return self::$module->params->get($optionName);


		jimport( 'joomla.application.module.helper' );

		/* For Cherry Picker users:
		* If you want to use options of some specific copy of CP module
		* provide its title in $specificModuleTitle.
		* More info can be found at Joomla Docs:
		* http://docs.joomla.org/JModuleHelper/getModule
		*/
		$specificModuleTitle = '';
		$module = JModuleHelper::getModule('mod_vm_cherry_picker', $specificModuleTitle);
		if (! $module)
			return;

		$params = new JRegistry;
		$params->loadString($module->params);
		$module->params = $params;
		self::$module = $module;
		// var_dump($module);
		return $params->get($optionName);
	}


	private function shouldRunInLegacyMode() {
		if (self::$shouldRunInLegacyMode != -1)
			return self::$shouldRunInLegacyMode;

		$db = JFactory::getDBO();
		$q = "SHOW TABLES LIKE '%_vm_product_type_parameter%'";
		$db->setQuery($q);
		$tableExists = ($db->loadResult()) ? true : false;
		self::$shouldRunInLegacyMode = $tableExists;

		return $tableExists;
	}

}
?>
