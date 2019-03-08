<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class CPFilterData {

	private $parametersData = array();
	private $parametersRawData = -1;

	private $ptidsToShow = array();
	private $thereAreFiltersToShow = true;

	private $ptIndex = 0;
	private $parameterIndex = 0;
	private $productTypesRawData = -1;
	private $totalProductsCount = -1;
	private $instockProductsCount = -1;
	private $low_price = 0;
	private $high_price = 0;
	private $priceAdjustments = -1;
	// private $low_price_adjusted = 0;		// prices adjusted according to category tax
	// private $high_price_adjusted = 0;


//	private $baseQuery = '';

	//private $baseQueryTables = array();
	private $baseQueryJoins = array();
	private $baseQueryWheres = array();
	private $sqlJoins = array();
	private $sqlWheres = array();
	//private $baseQueryJoinedParts = 0;		// keep track which tables where joined

	private $baseURL = '';
	// private $baseURLWithPrices = '';
	// private $baseURLWithAppliedFilters = '';
	private $appliedFiltersURL = '';
	private $appliedParametersCount = 0;

	private $categoryId = 0;
	private $manufacturerId = 0;
	private $searchKeyword = null;
	private $itemId = 0;

	private $subcategoryIds = -1;
	private $lookupInSubcategories = false;			// set this TRUE if you want to search in subcategories too



	public function initFiltersData($specific_ptids = array()) {
		$conf = CPFactory::getConfiguration();
		$this->initEnvironmentData();

		if ($specific_ptids) {
			$ptids = $specific_ptids;
		} else if ($conf->get('display_mode') == CP_SHOW_SPECIFIC_PTS && $conf->get('ptids')) {
			$_ptids = $conf->get('ptids');
			// Logical optimization: in multi product type display mode with certain selections
			// not all PTs necessarily need to be displayed. For example: when selecting filter from
			// "Televsitions", "Notebooks" product type can be omited from the start. Otherwise all filters from
			// "Notebooks" will make useless SQL queries.
			// if (count($_ptids) > 1) {
			// 	$ptids = $this->getProductTypes($_ptids);
			// } else {
				$ptids = $_ptids;
			// }
		} else {
			$ptids = $this->getProductTypes();
		}


		if (!$ptids) {
			$this->thereAreFiltersToShow = false;
			//return;
		} else {
			$this->ptidsToShow = $ptids;

			// $this->parametersData = $this->getParametersDataForProductTypes($ptids);
			$this->parametersData = $this->getSortedParametersData();

		}

		// set some base data
		$this->getAppliedPrices();
		$this->initBaseQueryParts();
		$this->initBaseURL();


	    // echo '<div><pre style="font-size:13px;">';
		// print_r($this->productTypesRawData);
		// print_r($this->parametersData);
		// var_dump($this->parametersData[0]);
		// print_r($this->baseQueryWheres);
		// echo "<br/>";
		// echo 'Applied Parameters Count: '. $this->appliedParametersCount;
		// echo '</pre></div>';

	}


	private function initEnvironmentData() {
		$conf = CPFactory::getConfiguration();
		if ($conf->get('display_mode') != CP_SHOW_SPECIFIC_PTS) {
			$this->categoryId = (int)JRequest::getVar('virtuemart_category_id', 0);
			$this->manufacturerId = (int)JRequest::getVar('virtuemart_manufacturer_id', 0);
			$this->searchKeyword = JRequest::getVar('keyword', null);
		}

		$option = JRequest::getVar('option');
		$itemid = JRequest::getVar('Itemid', null);
		if ($option != 'com_virtuemart') {
			$vmMenuItems = JSite::getMenu()->getItems('component', 'com_virtuemart');
			if ($vmMenuItems) {
				$itemid = $vmMenuItems[0]->id;
			}
		}
		$this->itemId = $itemid;
	}


	private function getProductTypes($specific_ptids = array()) {
		$cid = $this->categoryId();
		$mid = $this->manufacturerId();
		$keyword = $this->searchKeyword();

		$conf = CPFactory::getConfiguration();
		$db = JFactory::getDBO();

		$showSpecificPTWithGlobalScope = ($conf->get('display_mode') == CP_SHOW_SPECIFIC_PTS
			&& $conf->get('ptids') && $conf->get('global_scope'));
		$rawParameters = ($showSpecificPTWithGlobalScope) ?
			$this->getParametersRawData() : $this->getParametersRawData($specific_ptids);

		if (! $rawParameters)
			return null;


		// $columns = "ptx.`product_type_id` as id, pt.`product_type_name` as title";
		$columns = "ptx.`product_type_id`";
		$tables = array();
		$joins = array();
		//$joins[] = "JOIN `#__vm_product_type` as pt USING(`product_type_id`)";
		$joins[] = "JOIN `#__virtuemart_products` as vp ON ptx.`product_id`=vp.`virtuemart_product_id`";
		if ($conf->get('legacy_mode')) {
			$tables[] = "`#__vm_product_product_type_xref` as ptx";
			$joins[] = "JOIN `#__vm_product_type` as pt USING(`product_type_id`)";
		} else {
			$tables[] = "`#__fastseller_product_product_type_xref` as ptx";
			$joins[] = "JOIN `#__fastseller_product_type` as pt USING(`product_type_id`)";
		}
		$where = array();
		$where[] = "vp.`published`=1";

		if ($cid) {
			$joins[] = "JOIN `#__virtuemart_product_categories` as vpcat ON ptx.`product_id`=vpcat.`virtuemart_product_id`";
			if ($this->lookupInSubcategories) {
				$cids = $this->getSubcategoryIds($cid);
				if ($cids)
					$where[] = "vpcat.`virtuemart_category_id` IN (". implode(", ", $cids) .")";
				else
					$where[] = "vpcat.`virtuemart_category_id`=$cid";
			} else
				$where[] = "vpcat.`virtuemart_category_id`=$cid";
			// $where[] = "vpcat.`virtuemart_category_id`='$cid'";
		}

		if ($mid) {
			$joins[] = "JOIN `#__virtuemart_product_manufacturers` as vpm ON ptx.`product_id`=vpm.`virtuemart_product_id`";
			$where[] = "vpm.`virtuemart_manufacturer_id`='$mid'";
		}

		
		//tiago hack
		if ($keyword) {
			$joins[] = "JOIN `#__virtuemart_products_". CP_VMLANG ."` as vpl".
				" ON vp.`virtuemart_product_id`=vpl.`virtuemart_product_id`";
			$where[] = "vpl.`product_name` LIKE ". $db->quote("%$keyword%");
			
			$mywhere = "vpl.`product_name` LIKE " . $db->quote("%$keyword%") . " OR " . "vp.`product_sku` LIKE " . $db->quote("%$keyword%") . " OR " . "vpl.`product_desc` LIKE " . $db->quote("%$keyword%");
			$mywhere .= " OR vpl.`product_s_desc` LIKE " . $db->quote("%$keyword%") . " OR " . "(
							select distinct category_name 
							from e506s_virtuemart_categories_pt_pt 
							where virtuemart_category_id=
							(
								select virtuemart_category_id 
								from e506s_virtuemart_product_categories 
								where virtuemart_product_id=vp.virtuemart_product_id
							)
						) LIKE ". $db->quote("%$keyword%");
			$where[] = $mywhere;
		}
		//tiago hack

		$appliedProductTypeIDs = array();
		foreach ($rawParameters as $parameter) {
			if ($appliedValues = JRequest::getVar($parameter['parameter_name'], null)) {
				if (!in_array($parameter['product_type_id'], $appliedProductTypeIDs))
					$appliedProductTypeIDs[] = $parameter['product_type_id'];

				$multiAssigned = ($parameter['parameter_type'] == "V") ? true : false;

				$attributes = new JRegistry;
				$attributes->loadString($parameter['cherry_picker_attribs']);

				$where[] = $this->getParameterWhereClause(
							$parameter['product_type_id'],
							$parameter['parameter_name'],
							$appliedValues,
							$multiAssigned,
							$attributes->get('mode'));
			}
		}

		foreach ($appliedProductTypeIDs as $appliedPTID) {
			if ($conf->get('legacy_mode')) {
				$joins[] = "JOIN `#__vm_product_type_$appliedPTID` as pt". $appliedPTID .
					" ON ptx.`product_id`=pt$appliedPTID.`product_id`";
			} else {
				$joins[] = "JOIN `#__fastseller_product_type_$appliedPTID` as pt". $appliedPTID .
					" ON ptx.`product_id`=pt$appliedPTID.`product_id`";
			}
		}



		$q = "SELECT DISTINCT $columns FROM (". implode(', ', $tables) .") ".
			implode(' ', $joins) . " WHERE ". implode(' AND ', $where) .
			" ORDER BY pt.`product_type_list_order`";

		// echo $q;


		$db->setQuery($q);
		$ptids = $db->loadResultArray();


		// if (!$ptids) return false;
		//var_dump($db);


		return $ptids;
	}



	private function getParametersRawData($ptids = array()) {
		if ($this->parametersRawData != -1)
			return $this->parametersRawData;

		$db = JFactory::getDBO();
		$conf = CPFactory::getConfiguration();

		if ($conf->get('legacy_mode')) {
			$q = "SELECT * FROM `#__vm_product_type_parameter` as ptp".
				" JOIN `#__vm_product_type` as pt USING (`product_type_id`)";
		} else {
			$q = "SELECT * FROM `#__fastseller_product_type_parameter` as ptp".
				" JOIN `#__fastseller_product_type` as pt USING (`product_type_id`)";
		}

		if ($ptids)
			$q .= " WHERE `product_type_id` IN ('". implode("', '", $ptids) ."')";
		$q .= " ORDER BY `product_type_list_order`, ptp.`product_type_id`, `parameter_list_order`";

		$db->setQuery($q);
		$data = $db->loadAssocList();

		$this->parametersRawData = $data;

		return $data;
	}



	private function getSortedParametersData() {
		$conf = CPFactory::getConfiguration();

		$showSpecificPTWithGlobalScope = ($conf->get('display_mode') == CP_SHOW_SPECIFIC_PTS
			&& $conf->get('ptids') && $conf->get('global_scope'));
		$ptidsToShow = $this->ptidsToShow;
		$rawParameters = ($showSpecificPTWithGlobalScope) ?
			$this->getParametersRawData() : $this->getParametersRawData($ptidsToShow);

		if (!$rawParameters) {
			$this->thereAreFiltersToShow = false;
			return array();
		}


		$applied_ptids = array();
		$unsortedData = array();
		foreach ($rawParameters as $parameter) {
			$data = array();

			$attributes = new JRegistry;
			$attributes->loadString($parameter['cherry_picker_attribs']);

			if ($attributes->get('show_in_cherry_picker') === 0)
				continue;

			$ptid = $parameter['product_type_id'];
			$data['ptid'] = $ptid;
			$data['name'] = $parameter['parameter_name'];
			$data['title'] = $parameter['parameter_label'];
			$data['units'] = $parameter['parameter_unit'];
			$data['attributes'] = $attributes;

			$applied_filters = JRequest::getVar($parameter['parameter_name'], '');
			$data['applied_filters'] = $applied_filters;
			$data['applied_filters_count'] = count(explode(';', $applied_filters));

			$multiAssigned = ($parameter['parameter_type'] == "V") ? true : false;
			$data['multi_assigned'] = $multiAssigned;

			$data['where_clause'] = ($applied_filters) ?
				$this->getParameterWhereClause(
					$ptid,
					$parameter['parameter_name'],
					$applied_filters,
					$multiAssigned,
					// $parameter['mode'])
					$data['attributes']->get('mode'))
				: "";

			$unsortedData[$ptid][] = $data;

			if ($applied_filters) {
				if (!in_array($ptid, $applied_ptids)) $applied_ptids[] = $ptid;

				$this->appliedParametersCount++;
			}

		}


		$sortedData = array();
		foreach ($unsortedData as $id => $data) {
			$show = ($showSpecificPTWithGlobalScope && !in_array($id, $ptidsToShow)) ? false : true;
			$applied = (in_array($id, $applied_ptids)) ? true : false;
			$title = ($show) ? $this->getProductTypeTitle($id) : null;
			$sortedData[] = array(
				"id" => $id,
				"show" => $show,
				"applied" => $applied,
				"title" => $title,
				"parameters" => $data
			);
		}


		return $sortedData;
	}



	private function getProductTypeTitle($id) {
		if ($this->productTypesRawData == -1) {
			$db = JFactory::getDBO();
			$conf = CPFactory::getConfiguration();
			$table = ($conf->get('legacy_mode')) ?
				"`#__vm_product_type`" : "`#__fastseller_product_type`";
			$q = "SELECT `product_type_id` as id, `product_type_name` as title".
				" FROM ". $table ." WHERE `product_type_id` IN (".
				implode(', ', $this->ptidsToShow) .")";

			$db->setQuery($q);
			$data = $db->loadAssocList();
			$this->productTypesRawData = $data;
		} else {
			$data = $this->productTypesRawData;
		}

		$title = null;
		foreach ($data as $pt) {
			if ($pt['id'] == $id) {
				$title = $pt['title'];
				break;
			}
		}

		return $title;
	}


	private function getParameterWhereClause($ptid, $parameterName, $applied_filters, $multiAssigned, $parameterMode) {
		$conf = CPFactory::getConfiguration();
		$layout = $conf->get('layout');
		$layoutAllowsTrackbar = ($layout == CP_LAYOUT_SIMPLE_LIST || $layout == CP_LAYOUT_CHECKBOX_LIST);

		$db = JFactory::getDBO();
		//$ptTableAlias = "pt". $ptid;
		$column = "pt". $ptid .".`". $parameterName ."`";

		if ($parameterMode == CP_TRACKBAR_TWO_KNOBS && $layoutAllowsTrackbar) {
			$delimeter = $conf->get('trackbar_range_delimiter');
			$urlValues = explode($delimeter, $applied_filters);
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
				$s .= " BETWEEN ". $urlValueLeft ." AND ". $urlValueRight;
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
					// Make sure to do the same in vmFilterProcessor.php at getParameterWhereClause().
					// $where[] = $ptTableAlias .".`". $parameterName ."` LIKE ". $db->quote('%'. $filter .'%');
				}
				$s = "(". implode(' OR ', $where) .")";
			} else {
				//$s = "$ptTableAlias.`$parameterName` IN ('". implode("', '", $array) ."')";
				$s = $column ." IN ('". implode("', '", $array) ."')";
			}
		}

		return $s;
	}



	private function initBaseQueryParts() {
		$cid = $this->categoryId();
		$mid = $this->manufacturerId();
		$keyword = $this->searchKeyword();
		$instock_filter_applied = JRequest::getVar('instock', 0);

		$conf = CPFactory::getConfiguration();
		$manufacturers = CPFactory::getManufacturersDataModel();
		$db = JFactory::getDBO();

	//	$tables = array("`#__virtuemart_products` as p");
		$joins = array();
		$joins['base'] = array();
		$joins['prices'] = array();
		$joins['filters'] = array();
		$joins['manufacturers'] = array();
		$where = array();
		$where['base'] = array();
		$where['prices'] = array();
		$where['filters'] = array();
		$where['manufacturers'] = array();

		$where['base'][] = "p.`published`=1";

		if (!class_exists( 'VmConfig' ))
			require(JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR .'components'. DIRECTORY_SEPARATOR .
				'com_virtuemart'. DIRECTORY_SEPARATOR .'helpers'. DIRECTORY_SEPARATOR .'config.php');
		// if (!VmConfig::get('use_as_catalog',0) && VmConfig::get('stockhandle', 'none') == 'disableit' ) {
		// if (VmConfig::get('stockhandle', 'none') == 'disableit' ) {
		if (VmConfig::get('stockhandle', 'none') == 'disableit' ||
			VmConfig::get('stockhandle', 'none') == 'disableit_children' ||
			$instock_filter_applied)
		{
			//$where[] = "p.`product_in_stock`>0";
			$where['base'][] = "p.`product_in_stock`>0";
		}

		if ($cid) {
			$joins['base'][] = "JOIN `#__virtuemart_product_categories` as vpcat USING(`virtuemart_product_id`)";
			if ($this->lookupInSubcategories) {
				$cids = $this->getSubcategoryIds($cid);
				if ($cids)
					$where['base'][] = "vpcat.`virtuemart_category_id` IN (". implode(", ", $cids) .")";
				else
					$where['base'][] = "vpcat.`virtuemart_category_id`=$cid";
			} else
				$where['base'][] = "vpcat.`virtuemart_category_id`=$cid";
			// $where[] = "vpcat.`virtuemart_category_id`='$cid'";
		}

		if ($mid || $manufacturers->appliedCount() > 0) {
			//if ( !$this->joinedManufacturers())
			$joins['manufacturers'][] = "JOIN `#__virtuemart_product_manufacturers` as vpm USING(`virtuemart_product_id`)";
			$appliedIds = $manufacturers->appliedIds();
			if ($mid)
				array_merge($appliedIds, (array)$mid);
			$where['manufacturers'][] = "vpm.`virtuemart_manufacturer_id` IN ('". implode("', '", $appliedIds) ."')";
		}

		//tiago hack
		
		if ($keyword) {
			$joins['base'][] = "JOIN `#__virtuemart_products_". CP_VMLANG ."` as vpl USING(`virtuemart_product_id`)";
			$mywhere = "vpl.`product_name` LIKE " . $db->quote("%$keyword%") . " OR " . "p.`product_sku` LIKE " . $db->quote("%$keyword%") . " OR " . "vpl.`product_desc` LIKE " . $db->quote("%$keyword%");
			$mywhere .= " OR vpl.`product_s_desc` LIKE " . $db->quote("%$keyword%") . " OR " . "(
							select distinct category_name 
							from e506s_virtuemart_categories_pt_pt 
							where virtuemart_category_id=
							(
								select virtuemart_category_id 
								from e506s_virtuemart_product_categories 
								where virtuemart_product_id=p.virtuemart_product_id
							)
						) LIKE ". $db->quote("%$keyword%");
			$where['base'][] = $mywhere;
		}

		//tiago hack
		
		$adjustPriceBackward = 1;
		$lp = $this->adjustPrice($this->low_price, $adjustPriceBackward);
		$hp = $this->adjustPrice($this->high_price, $adjustPriceBackward);
		// $lp = $this->low_price_adjusted;
		// $hp = $this->high_price_adjusted;
		if ($lp || $hp) {
			$joins['prices'][] = "JOIN `#__virtuemart_product_prices` as prices USING(`virtuemart_product_id`)";

			// If we want to search with adjusted prices:
			if ($conf->get('include_individual_price_adjustment') != 0) {
				// Product VAT taxes or discounts
				if ($conf->get('include_individual_price_adjustment') == CP_INCLUDE_PRODUCT_PRICE_ADJUSTMENT) {
					$joins['prices'][] = "LEFT JOIN `#__virtuemart_calcs` as calcs".
						" ON prices.`product_tax_id`=calcs.`virtuemart_calc_id`";

				} else if ($conf->get('include_individual_price_adjustment') == CP_INCLUDE_MANUFACTURERS_PRICE_ADJUSTMENT) {
					if (!$joins['manufacturers'])
						$joins['manufacturers'][] = "LEFT JOIN `#__virtuemart_product_manufacturers` as vpm USING(`virtuemart_product_id`)";
					$joins['prices'][] = "LEFT JOIN `#__virtuemart_calc_manufacturers` as calc_manuf".
						" ON vpm.`virtuemart_manufacturer_id`=calc_manuf.`virtuemart_manufacturer_id`";
					$joins['prices'][] = "LEFT JOIN `#__virtuemart_calcs` as calcs".
						" ON calc_manuf.`virtuemart_calc_id`=calcs.`virtuemart_calc_id`";

					// Keep track that we already JOINed Manufacturers table for other queries
					// that JOIN on it too.
					//$this->baseQueryJoinedParts |= CP_JOINED_MANUFACTURERS;
				}

				$where['prices'][] = "(calcs.`published`=1 OR calcs.`virtuemart_calc_id` IS NULL)";

				// here comes some Virtuemart price discounts HELL
				if ($lp && $hp && $lp != $hp) {
					$where['prices'][] = "(CASE WHEN `calc_value_mathop` = '+' THEN ".
							" prices.`product_price` BETWEEN (". $lp ." - `calc_value`)".
							" AND (". $hp ." - `calc_value`)".
						" WHEN `calc_value_mathop` = '-' THEN ".
							" prices.`product_price` BETWEEN (". $lp ." + `calc_value`)".
							" AND (". $hp ." + `calc_value`)".
						" WHEN `calc_value_mathop` = '+%' THEN".
							" prices.`product_price` BETWEEN (". $lp ." / (1 + `calc_value` / 100))".
							" AND (". $hp ." / (1 + `calc_value` / 100))".
						" WHEN `calc_value_mathop` = '-%' THEN".
							" prices.`product_price` BETWEEN (". $lp ." / (1 - `calc_value` / 100))".
							" AND (". $hp ." / (1 - `calc_value` / 100))".
						" ELSE prices.`product_price` BETWEEN ". $lp ." AND ". $hp .
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

					$where['prices'][] = "(CASE WHEN `calc_value_mathop` = '+' THEN ".
							" prices.`product_price` ". $operation ." (". $search_price ." - `calc_value`)".
						" WHEN `calc_value_mathop` = '-' THEN ".
							" prices.`product_price` ". $operation ." (". $search_price ." + `calc_value`)".
						" WHEN `calc_value_mathop` = '+%' THEN ".
							" prices.`product_price` ". $operation ." (". $search_price ." / (1 + `calc_value` / 100))".
						" WHEN `calc_value_mathop` = '-%' THEN ".
							" prices.`product_price` ". $operation ." (". $search_price ." / (1 - `calc_value` / 100))".
						" ELSE prices.`product_price` ". $operation ." ". $search_price .
						" END)";
				}

			} else {		// do a regular search without discounts
				if ($lp && !$hp) {
					$where['prices'][] = "prices.`product_price`*(1+((select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1 limit 1)/100)) >= $lp";
				} else if (!$lp && $hp) {
					$where['prices'][] = "prices.`product_price`*(1+((select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1 limit 1)/100)) <= $hp";
				} else if ($lp == $hp) {
					$where['prices'][] = "prices.`product_price`*(1+((select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1 limit 1)/100)) = $lp";
				} else {
					$where['prices'][] = "prices.`product_price`*(1+((select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1 limit 1)/100)) BETWEEN $lp AND $hp";
				}

			}
		}


		foreach ($this->parametersData as $i => $productType) {
			$joiningPTID = $productType['id'];
			if ($productType['applied']) {
				if ($conf->get('legacy_mode')) {
					$joins['filters'][] = "JOIN `#__vm_product_type_$joiningPTID` as pt$joiningPTID".
						" ON p.`virtuemart_product_id`=pt$joiningPTID.`product_id`";
				} else {
					$joins['filters'][] = "JOIN `#__fastseller_product_type_$joiningPTID` as pt$joiningPTID".
						" ON p.`virtuemart_product_id`=pt$joiningPTID.`product_id`";
				}
			}

			foreach ($productType['parameters'] as $parameter) {
				if ($parameter['where_clause'])
					$where['filters'][] = $parameter['where_clause'];
			}
		}


	//	$this->baseQueryTables = $tables;
//		$this->baseQueryJoins = $joins;
//		$this->baseQueryWheres = $where;

		$this->sqlJoins = $joins;
		$this->sqlWheres = $where;


		//echo '<pre style="font-size:13px;">';
		//print_r($this->sqlJoins);
		//print_r($this->sqlWheres);
		//echo '</pre>';

	}



	private function initBaseURL() {
		$cid = $this->categoryId();
		$mid = $this->manufacturerId();
		$keyword = $this->searchKeyword();
		$itemid = $this->itemId();

		$s = 'option=com_virtuemart&view=category';
		if ($cid)
			$s .= "&virtuemart_category_id=". $cid;
		else
			$s .= "&search=true";
		if ($mid)
			$s .= "&virtuemart_manufacturer_id=". $mid;
		if ($itemid)
			$s .= "&Itemid=". $itemid;
		if ($keyword)
			$s .= "&keyword=". urlencode($keyword);

		// $this->setBaseURLWithAppliedFilters($s);

		$this->baseURL = $s;

		// $conf = CPFactory::getConfiguration();
		// if ($conf->get('use_price_search')) {
		// 	if ($this->low_price) $s .= '&low-price='. $this->low_price;
		// 	if ($this->high_price) $s .= '&high-price='. $this->high_price;
		// }

		// $this->baseURLWithPrices = $s;
		$this->setAppliedFiltersURL();
	}


	private function setAppliedFiltersURL() {
		$params = array();
		foreach ($this->parametersData as $productType) {
			foreach ($productType['parameters'] as $parameter) {
				if ($parameter['applied_filters'])
					$params[] = $parameter['name'] .'='.
						urlencode($this->encodeURLEntities($parameter['applied_filters']));
			}
		}

		// $manufacturers = CPFactory::getManufacturersDataModel();
		// $url .= '&'. $manufacturers->appliedURL();

		// $this->appliedFiltersURL = $url;
		// $this->baseURLWithAppliedFilters = $url;
		$this->appliedFiltersURL = implode('&', $params);
	}


	public function encodeURLEntities($string) {
		$jconfig = JFactory::getConfig();
		$sefEnabled = $jconfig->getValue('config.sef');
		$conf = CPFactory::getConfiguration();
		$encodeURL = $conf->get('encode_url');

		/* When Joomla SEF is enabled we need to double-encode special chars.
		* This way, when Joomla decodes URL, we end up with properly encoded URL.
		*/
		if ($sefEnabled && $encodeURL) {
			$string = str_replace('&', '%2526', $string);
			$string = str_replace('+', '%252B', $string);
		} else {
			$string = str_replace('&', '%26', $string);
			$string = str_replace('+', '%2B', $string);
		}

		return $string;
	}


	private function calculateTotalProductsCount() {
		$db = JFactory::getDBO();
		$mid = $this->manufacturerId();
		$manufacturers = CPFactory::getManufacturersDataModel();
		$conf = CPFactory::getConfiguration();

		$tables = array("`#__virtuemart_products` as p");
		//$joins = $this->getBaseQueryJoins();
		//$where = $this->getBaseQueryWheres();
		$joins = $this->getSqlJoinsExcluding();
		$where = $this->getSqlWheresExcluding();

//		foreach ($this->parametersData as $i => $productType) {
//			$joiningPTID = $productType['id'];
//
//			if ($productType['applied']) {
//				if ($conf->get('legacy_mode')) {
//					$joins[] = "JOIN `#__vm_product_type_$joiningPTID` as pt$joiningPTID".
//						" ON p.`virtuemart_product_id`=pt$joiningPTID.`product_id`";
//				} else {
//					$joins[] = "JOIN `#__fastseller_product_type_$joiningPTID` as pt$joiningPTID".
//						" ON p.`virtuemart_product_id`=pt$joiningPTID.`product_id`";
//				}
//			}
//
//			foreach ($productType['parameters'] as $parameter) {
//				if ($parameter['where_clause']) $where[] = $parameter['where_clause'];
//			}
//		}
//
//		if ($mid || $manufacturers->appliedCount() > 0) {
//			if ( !$this->joinedManufacturers())
//				$joins[] = "JOIN `#__virtuemart_product_manufacturers` as vpm USING(`virtuemart_product_id`)";
//			$appliedIds = $manufacturers->appliedIds();
//			if ($mid)
//				array_merge($appliedIds, (array)$mid);
//			$where[] = "vpm.`virtuemart_manufacturer_id` IN ('". implode("', '", $appliedIds) ."')";
//		}


		// $q = "SELECT COUNT(*)".
		$q = "SELECT COUNT(DISTINCT p.`virtuemart_product_id`)".
			" FROM (". implode(', ', $tables) .") ".
			implode(' ', $joins);

		if ($where) $q .= " WHERE ". implode(' AND ', $where);

		// echo 'total:' . $q;

		$db->setQuery($q);
		$result = $db->loadResult();
		return $result;
	}


	private function calculateInstockProductsCount() {
		$db = JFactory::getDBO();
		$mid = $this->manufacturerId();
		$manufacturers = CPFactory::getManufacturersDataModel();
		$conf = CPFactory::getConfiguration();

		$tables = array("`#__virtuemart_products` as p");
		//$joins = $this->getBaseQueryJoins();
		//$where = $this->getBaseQueryWheres();
		$joins = $this->getSqlJoinsExcluding();
		$where = $this->getSqlWheresExcluding();

		//foreach ($this->parametersData as $i => $productType) {
		//	$joiningPTID = $productType['id'];

		//	if ($productType['applied']) {
		//		if ($conf->get('legacy_mode')) {
		//			$joins[] = "JOIN `#__vm_product_type_$joiningPTID` as pt$joiningPTID".
		//				" ON p.`virtuemart_product_id`=pt$joiningPTID.`product_id`";
		//		} else {
		//			$joins[] = "JOIN `#__fastseller_product_type_$joiningPTID` as pt$joiningPTID".
		//				" ON p.`virtuemart_product_id`=pt$joiningPTID.`product_id`";
		//		}
		//	}

		//	foreach ($productType['parameters'] as $parameter) {
		//		if ($parameter['where_clause']) $where[] = $parameter['where_clause'];
		//	}
		//}

		//if ($mid || $manufacturers->appliedCount() > 0) {
		//	if ( !$this->joinedManufacturers())
		//		$joins[] = "JOIN `#__virtuemart_product_manufacturers` as vpm USING(`virtuemart_product_id`)";
		//	$appliedIds = $manufacturers->appliedIds();
		//	if ($mid)
		//		array_merge($appliedIds, (array)$mid);
		//	$where[] = "vpm.`virtuemart_manufacturer_id` IN ('". implode("', '", $appliedIds) ."')";
		//}

		$where[] = "p.`product_in_stock`>0";

		$q = "SELECT COUNT(DISTINCT p.`virtuemart_product_id`)".
			" FROM (". implode(', ', $tables) .") ".
			implode(' ', $joins);
		$q .= " WHERE ". implode(' AND ', $where);

		$db->setQuery($q);
		$result = $db->loadResult();
		return $result;
	}


	private function getAppliedPrices() {
		$conf = CPFactory::getConfiguration();
		if ($conf->get('use_price_search')) {
			$lp = $this->validatePriceValue(JRequest::getVar('low-price', 0));
			$hp = $this->validatePriceValue(JRequest::getVar('high-price', 0));
			if ( !($hp && $lp && $hp < $lp)) {
				$this->low_price = $lp;
				$this->high_price = $hp;
			}

			// if ($lp)
			// 	$this->low_price_adjusted = $this->adjustPrice($lp);
			// if ($hp)
			// 	$this->high_price_adjusted = $this->adjustPrice($hp);
		}
	}


	private function validatePriceValue($price) {
		// not empty
		if (empty($price))
			return 0;
		// not -X or 0
		if ($price <= 0)
			return 0;
		// change , with .
		$price = str_replace(',','.',$price);
		if (! is_numeric($price))
			return 0;
		// remove leading/trailing zeros
		$price += 0;

		return $price;
	}


	/**
	* Adjust prices according to current category and table #__virtuemart_calcs
	* @param $adjustmentDirection Price could be adjusted either from Base to Resulting
	*	or back from already adjusted to Base.
	*/
	public function adjustPrice($price, $adjustmentDirection = 0) {
		if (! $price)
			return 0;

		$conf = CPFactory::getConfiguration();
		if (! $conf->get('include_category_price_adjustment'))
			return $price;

		// const
		$forward = 0;

		if ($this->priceAdjustments == -1) {
			$db = JFactory::getDBO();
			$cid = $this->categoryId();
			if (! $cid) {
				$this->priceAdjustments = null;
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
			$this->priceAdjustments = $priceAdjustments;
		} else
			$priceAdjustments = $this->priceAdjustments;

		// var_dump($priceAdjustments);
		// echo 'befor: '. $price;

		if (! $priceAdjustments)
			return $price;

		if ($adjustmentDirection == $forward) {
			foreach ($priceAdjustments as $adjustment) {
				switch ($adjustment['operation']) {
					case '+':
						$price += $adjustment['value'];
						break;

					case '-':
						$price -= $adjustment['value'];
						break;

					case '+%':
						$price *= 1 + $adjustment['value'] / 100;
						break;

					case '-%':
						$price *= 1 - $adjustment['value'] / 100;
						break;
				}
			}

		} else {
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
		}
		// echo 'after:'. $price;
		return $price;
	}


	public function getMinMaxPrices($includeAppliedFilters = false) {
		$cid = $this->categoryId();
		$mid = $this->manufacturerId();
		$manufacturers = CPFactory::getManufacturersDataModel();
		$keyword = $this->searchKeyword();

		$conf = CPFactory::getConfiguration();
		$db = JFactory::getDBO();

		$tables = array("`#__virtuemart_products` as p");
		$joins = array();
		$joins[] = "JOIN `#__virtuemart_product_prices` as prices USING(`virtuemart_product_id`)";
		$where = array();
		$where[] = "p.`published`=1";

		$joinedManufacturers = false;
		if ($conf->get('include_individual_price_adjustment') != 0) {
			// Product VAT taxes or discounts
			// Observation note.
			// In order for VAT to be taken into account during SQL execution
			// it must be explicitly selected for product,
			// not just "Apply default rules".
			if ($conf->get('include_individual_price_adjustment') == CP_INCLUDE_PRODUCT_PRICE_ADJUSTMENT) {
				$joins[] = "LEFT JOIN `#__virtuemart_calcs` as calcs".
					" ON prices.`product_tax_id`=calcs.`virtuemart_calc_id`";
			} else if ($conf->get('include_individual_price_adjustment') == CP_INCLUDE_MANUFACTURERS_PRICE_ADJUSTMENT) {
				$joins[] = "LEFT JOIN `#__virtuemart_product_manufacturers` as vpm USING(`virtuemart_product_id`)";
				$joins[] = "LEFT JOIN `#__virtuemart_calc_manufacturers` as calc_manuf".
					" ON vpm.`virtuemart_manufacturer_id`=calc_manuf.`virtuemart_manufacturer_id`";
				$joins[] = "LEFT JOIN `#__virtuemart_calcs` as calcs".
						" ON calc_manuf.`virtuemart_calc_id`=calcs.`virtuemart_calc_id`";
				$joinedManufacturers = true;
			}

			$intricateCondition = "CASE WHEN `calc_value_mathop` = '+' THEN prices.`product_price` + `calc_value`".
				" WHEN `calc_value_mathop` = '-' THEN prices.`product_price` - `calc_value`".
				" WHEN `calc_value_mathop` = '+%' THEN prices.`product_price` * (1 + `calc_value` / 100)".
				" WHEN `calc_value_mathop` = '-%' THEN prices.`product_price` * (1 - `calc_value` / 100)".
				" ELSE prices.`product_price`".
				" END";

			$columns = "MIN(". $intricateCondition .") as min, MAX(". $intricateCondition .") as max";
			$where[] = "(calcs.`published`=1 OR calcs.`virtuemart_calc_id` IS NULL)";
		} else {
			$columns = "MIN(prices.`product_price`*(1+((select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1 limit 1)/100))) as min, MAX(prices.`product_price`*(1+((select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1 limit 1)/100))) as max";
		}

		if ($cid) {
			$joins[] = "JOIN `#__virtuemart_product_categories` as vpcat USING(`virtuemart_product_id`)";
			if ($this->lookupInSubcategories) {
				$cids = $this->getSubcategoryIds($cid);
				if ($cids)
					$where[] = "vpcat.`virtuemart_category_id` IN (". implode(", ", $cids) .")";
				else
					$where[] = "vpcat.`virtuemart_category_id`=$cid";
			} else
				$where[] = "vpcat.`virtuemart_category_id`=$cid";
		}

//		if ($mid) {
//			if (! $joinedManufacturers)
//				$joins[] = "JOIN `#__virtuemart_product_manufacturers` as vpm USING(`virtuemart_product_id`)";
//				// $joins[] = "JOIN `#__virtuemart_product_manufacturers` as vpm ON vp.`virtuemart_product_id`=vpm.`virtuemart_product_id`";
//			$where[] = "vpm.`virtuemart_manufacturer_id`='$mid'";
//		}

		if ($mid || ($includeAppliedFilters && $manufacturers->appliedCount() > 0)) {
			if (! $joinedManufacturers)
				$joins[] = "JOIN `#__virtuemart_product_manufacturers` as vpm USING(`virtuemart_product_id`)";
			$appliedIds = $manufacturers->appliedIds();
			if ($mid)
				array_merge($appliedIds, (array)$mid);
			$where[] = "vpm.`virtuemart_manufacturer_id` IN ('". implode("', '", $appliedIds) ."')";
		}


		if ($keyword) {
			$joins[] = "JOIN `#__virtuemart_products_". CP_VMLANG ."` as vpl USING(`virtuemart_product_id`)";
			$where[] = "vpl.`product_name` LIKE ". $db->quote("%$keyword%");
		}


		if ($includeAppliedFilters) {
			foreach ($this->parametersData as $i => $productType) {
				$joiningPTID = $productType['id'];

				if ($productType['applied']) {
					if ($conf->get('legacy_mode')) {
						$joins[] = "JOIN `#__vm_product_type_$joiningPTID` as pt$joiningPTID".
							" ON p.`virtuemart_product_id`=pt$joiningPTID.`product_id`";
					} else {
						$joins[] = "JOIN `#__fastseller_product_type_$joiningPTID` as pt$joiningPTID".
							" ON p.`virtuemart_product_id`=pt$joiningPTID.`product_id`";
					}
				}

				foreach ($productType['parameters'] as $parameter) {
					if ($parameter['where_clause']) $where[] = $parameter['where_clause'];
				}
			}
		}


		$q = "SELECT $columns FROM (". implode(', ', $tables) .") ".
			implode(' ', $joins) . " WHERE ". implode(' AND ', $where);

		//echo $q;

		$db->setQuery($q);
		$prices = $db->loadAssoc();
		// take into account possible category price adjustments:
		$prices = array("min" => $this->adjustPrice($prices['min']), "max" => $this->adjustPrice($prices['max']));

		return $prices;
	}



	public function categoryName($cid) {
		$db = JFactory::getDBO();

		$q = "SELECT `category_name` FROM `#__virtuemart_categories_". CP_VMLANG ."` WHERE `virtuemart_category_id`=$cid";
		$db->setQuery($q);
		$cName = $db->loadResult();

		return $cName;
	}


	/*
	* Method returns an array of subcategory ids of the passed category id.
	*/
	private function getSubcategoryIds($cid) {
		if (! $cid)
			return 0;

		if ($this->subcategoryIds != -1)
			return $this->subcategoryIds;

		$ids = $this->walkTree($cid);
		// var_dump($ids);
		$this->subcategoryIds = $ids;

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
			$children = $this->walkTree($array);
			$array = array_merge($array, $children);
		}

		return $array;
	}



	public function checkThereAreFiltersApplied() {
		foreach ($this->parametersRawData as $parameter) {
			$applied_filters = JRequest::getVar($parameter['parameter_name'], '');
			if ($applied_filters) return true;
		}

		return false;
	}


	public function showDialogToRemoveFilterSelection() {
		$this->initBaseURL();

		require_once(CP_ROOT .'views/filterWriter.php');

		$filterWriter = CPFactory::getFilterWriter();
		$filterWriter->printDialogToRemoveFilterSelection();
	}


	/*
	* Return BOOL whether current customer must see Price Form (depends on
	* Virtuemart configuration)
	*/
	public function showPriceFormForCurrentUser() {
		$user = JFactory::getUser();

		if ($user->id != 0) {
			$db = JFactory::getDBO();
			$q = "SELECT `virtuemart_shoppergroup_id` FROM `#__virtuemart_vmuser_shoppergroups`".
				" WHERE `virtuemart_user_id`=". $user->id;
			$db->setQuery($q);
			$shoppergroup_id = $db->loadResult();

			if ($shoppergroup_id) {
				$q = "SELECT `price_display` FROM `#__virtuemart_shoppergroups`".
					" WHERE `virtuemart_shoppergroup_id`=". $shoppergroup_id;
				$db->setQuery($q);
				$res = $db->loadResult();
				$price_display = unserialize($res);

				return $price_display->get('show_prices');
			}
		}

		// if here -- return global value
		if (!class_exists( 'VmConfig' ))
			require(JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR .'components'. DIRECTORY_SEPARATOR .
				'com_virtuemart'. DIRECTORY_SEPARATOR .'helpers'. DIRECTORY_SEPARATOR .'config.php');

		return VmConfig::get('show_prices', 1);
	}




	// -----------------------------------------------------------------------------
	// Initialize Partial Data. Full data prepared only for specific Parameter.
	// Used for SEE MORE AJAX, LOAD FILTERS FOR DROP-DOWN WITH AJAX.
	// ------------------------------------------------------------------------------

	public function initFiltersDataLimited($specific_ptids = array()) {
		$this->initEnvironmentData();

		if ($specific_ptids) {
			$ptids = $specific_ptids;
		} else if ($conf->get('display_mode') == CP_SHOW_SPECIFIC_PTS && $conf->get('ptids')) {
			$_ptids = $conf->get('ptids');
			if (count($_ptids) > 1) {
				$ptids = $this->getProductTypes($_ptids);
			} else {
				$ptids = $_ptids;
			}
		} else {
			$ptids = $this->getProductTypes();
		}


		if (!$ptids) {
			$this->thereAreFiltersToShow = false;
			return;
		}

		$this->ptidsToShow = $ptids;
		$this->parametersData = $this->getSortedParametersData();

		// set some base data
		$this->getAppliedPrices();
		$this->initBaseQueryParts();
		$this->initBaseURL();


		// echo '<div><pre style="font-size:13px;">';
		// print_r($this->productTypesRawData);
		// print_r($this->parametersData);
		// print_r($this->baseQueryWheres);
		// echo "<br/>";
		// echo 'Applied Parameters Count: '. $this->appliedParametersCount;
		// echo '</pre></div>';
	}



	// public function currentPTId() {
	// 	return $this->productTypesData[$this->ptIndex]['id'];
	// }

	// public function currentParameterFilters() {
	// 	return $this->parametersData[$this->ptIndex]['parameters'][$this->parameterIndex]['filters'];
	// }

	public function currentParameterAppliedFilters() {
		return $this->parametersData[$this->ptIndex]['parameters'][$this->parameterIndex]['applied_filters']; // [applied_filters] is a string
	}

	public function currentParameterAppliedFiltersCount() {
		return $this->parametersData[$this->ptIndex]['parameters'][$this->parameterIndex]['applied_filters_count'];
	}

	public function previousParameterAppliedFilters() {
		$prevIndex = $this->parameterIndex - 1;
		if ($prevIndex < 0) return null;
		return $this->parametersData[$this->ptIndex]['parameters'][$prevIndex]['applied_filters']; // [applied_filters] is a string
	}

	public function currentParameterName() {
		return $this->parametersData[$this->ptIndex]['parameters'][$this->parameterIndex]['name'];
	}

	public function currentParameterTitle() {
		return $this->parametersData[$this->ptIndex]['parameters'][$this->parameterIndex]['title'];
	}

	public function currentParameterUnits() {
		return $this->parametersData[$this->ptIndex]['parameters'][$this->parameterIndex]['units'];
	}

	// public function currentParameterMode() {
	// 	return $this->parametersData[$this->ptIndex]['parameters'][$this->parameterIndex]['mode'];
	// }

	public function currentParameterPTID() {
		return $this->parametersData[$this->ptIndex]['parameters'][$this->parameterIndex]['ptid'];
	}

	// public function currentParameterShowQuickrefine() {
	// 	return $this->parametersData[$this->ptIndex]['parameters'][$this->parameterIndex]['show_quickrefine'];
	// }

	// public function currentParameterCollapseState() {
	// 	return $this->parametersData[$this->ptIndex]['parameters'][$this->parameterIndex]['collapse'];
	// }

	public function currentParameterAttribute($attribute) {
		return $this->parametersData[$this->ptIndex]['parameters'][$this->parameterIndex]['attributes']->get($attribute);
	}

	public function currentPTTitle() {
		// return $this->productTypesData[$this->ptIndex]['title'];
		return $this->parametersData[$this->ptIndex]['title'];
	}

	public function currentParameterMultiAssigned() {
		return $this->parametersData[$this->ptIndex]['parameters'][$this->parameterIndex]['multi_assigned'];
	}


	public function currentParameterIsTrackbar() {
		$parameterMode = $this->currentParameterAttribute('mode');
		return ($parameterMode == CP_TRACKBAR_ONE_KNOB_EXACT ||
			$parameterMode == CP_TRACKBAR_ONE_KNOB_COMPARE ||
			$parameterMode == CP_TRACKBAR_TWO_KNOBS);
	}


	// public function getProductTypeIDs() {
	public function getPTIDsToShow() {
		return $this->ptidsToShow;
	}


	public function getAllURLParameters() {
		$params = array();
		if ($this->low_price)
			$params[] = 'low-price='. $this->low_price;
		if ($this->high_price)
			$params[] = 'high-price='. $this->high_price;

		foreach ($this->parametersData as $productType) {
			foreach ($productType['parameters'] as $parameter) {
				if ($parameter['applied_filters'])
					$params[] = $parameter['name'] .'='.
						urlencode($parameter['applied_filters']);
			}
		}

		$manufacturers = CPFactory::getManufacturersDataModel();
		$mfs = $manufacturers->appliedManufacturers();
		if ($mfs)
			$params[] = $mfs;

		$s = $this->baseURL;
		if ($params)
			$s .= '&'. implode('&', $params);

		return $s;
	}



	// Produce URL with parameters that don't match flags.
	public function getURLExcluding($flags = 0) {
		$params = array();

		if (($flags & CP_URL_PRICES) == 0) {
			if ($this->low_price)
				$params[] = 'low-price='. $this->low_price;
			if ($this->high_price)
				$params[] = 'high-price='. $this->high_price;
		}

		if (($flags & CP_URL_FILTERS) == 0) {
			if ($s = $this->appliedFiltersURL())
				$params[] = $s;
		}

		if (($flags & CP_URL_MANUFACTURERS) == 0) {
			$manufacturers = CPFactory::getManufacturersDataModel();
			if ($s = $manufacturers->appliedManufacturersURL())
				$params[] = $s;
		}

		if (($flags & CP_URL_INSTOCK_FILTER) == 0) {
			$instock_filter_applied = JRequest::getVar('instock', 0);
			if ($instock_filter_applied)
				$params[] = 'instock=1';
		}

		$url = 'index.php?'. $this->baseURL;
		if ($params)
			$url .= '&'. implode('&', $params);

		return $url;
	}

	// Opposite of getURLExcluding()
	public function getURLFor($flags = 0) {
		$params = array();

		if ($flags & CP_URL_PRICES) {
			if ($this->low_price)
				$params[] = 'low-price='. $this->low_price;
			if ($this->high_price)
				$params[] = 'high-price='. $this->high_price;
		}

		if ($flags & CP_URL_FILTERS) {
			if ($s = $this->appliedFiltersURL())
				$params[] = $s;
		}

		if ($flags & CP_URL_MANUFACTURERS) {
			$manufacturers = CPFactory::getManufacturersDataModel();
			if ($s = $manufacturers->appliedManufacturersURL())
				$params[] = $s;
		}

		if ($flags & CP_URL_INSTOCK_FILTER) {
			$instock_filter_applied = JRequest::getVar('instock', 0);
			if ($instock_filter_applied)
				$params[] = 'instock=1';
		}

		$url = 'index.php?'. $this->baseURL;
		if ($params)
			$url .= '&'. implode('&', $params);

		return $url;
	}

//	public function joinedManufacturers() {
//		return ($this->baseQueryJoinedParts & CP_JOINED_MANUFACTURERS);
//	}


	// Accessor methods

	public function getParametersData() {
		return $this->parametersData;
	}

	public function thereAreFiltersToShow() {
		return $this->thereAreFiltersToShow;
	}

	public function setPTIndex($index) {
		$this->ptIndex = $index;
	}

	public function ptIndex() {
		return $this->ptIndex;
	}

	public function setParameterIndex($index) {
		$this->parameterIndex = $index;
	}

	public function parameterIndex() {
		return $this->parameterIndex;
	}

//	public function baseQuery() {
//		return $this->baseQuery;
//	}

	public function getSqlJoinsExcluding($mask = 0) {
		$joins = array();

		$joins = array_merge($joins, $this->sqlJoins['base']);

		if (($mask & CP_MASK_MANUFACTURERS) == 0) {
			$joins = array_merge($joins, $this->sqlJoins['manufacturers']);
		}

		if (($mask & CP_MASK_PRICES) == 0) {
			$joins = array_merge($joins, $this->sqlJoins['prices']);
		}

		if (($mask & CP_URL_FILTERS) == 0) {
			$joins = array_merge($joins, $this->sqlJoins['filters']);
		}

//		if (($mask & CP_URL_INSTOCK_FILTER) == 0) {
//			$joins = array_merge($joins, $this->sqlJoins['instock']);
//		}

		return $joins;
	}

	public function getSqlWheresExcluding($mask = 0) {
		$where = array();

		$where = array_merge($where, $this->sqlWheres['base']);

		if (($mask & CP_MASK_PRICES) == 0) {
			$where = array_merge($where, $this->sqlWheres['prices']);
		}

		if (($mask & CP_URL_FILTERS) == 0) {
			$where = array_merge($where, $this->sqlWheres['filters']);
		}

		if (($mask & CP_MASK_MANUFACTURERS) == 0) {
			$where = array_merge($where, $this->sqlWheres['manufacturers']);
		}

		return $where;
	}

//	public function getBaseQueryJoins() {
//		return $this->baseQueryJoins;
//	}
//
//	public function getBaseQueryWheres() {
//		return $this->baseQueryWheres;
//	}

	public function baseURL() {
		return 'index.php?'. $this->baseURL;
	}

	// public function baseURLWithPrices() {
	// 	return 'index.php?'. $this->baseURLWithPrices;
	// }

	public function lowPrice() {
		return $this->low_price;
	}

	public function highPrice() {
		return $this->high_price;
	}

	// public function baseURLWithAppliedFilters() {
	// 	return 'index.php?'. $this->baseURLWithAppliedFilters;
	// }

	// public function clearPriceURL() {
	// 	return 'index.php?'. $this->baseURLWithAppliedFilters;
	// }

	public function appliedFiltersURL() {
		return $this->appliedFiltersURL;
	}

	public function getTotalProductsCount() {
		if ($this->totalProductsCount == -1) {
			$count = $this->calculateTotalProductsCount();
			$this->totalProductsCount = $count;
			return $count;
		} else {
			return $this->totalProductsCount;
		}
	}

	public function instockProductsCount() {
		if ($this->instockProductsCount == -1) {
			$count = $this->calculateInstockProductsCount();
			$this->instockProductsCount = $count;
			return $count;
		} else {
			return $this->instockProductsCount;
		}
	}

	public function appliedParametersCount() {
		return $this->appliedParametersCount;
	}

	public function categoryId() {
		return $this->categoryId;
	}

	public function manufacturerId() {
		return $this->manufacturerId;
	}

	public function searchKeyword() {
		return $this->searchKeyword;
	}

	public function itemId() {
		return $this->itemId;
	}


}

?>
