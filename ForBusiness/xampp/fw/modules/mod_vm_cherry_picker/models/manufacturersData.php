<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class CPManufacturersData {

	private $initialized = 0;
	private $manufacturersData = array();
	private $fetchedCollection = 0;
	private $manufacturersCollection = array();

	private $appliedIds = array();
	private $appliedCount = 0;
	private $appliedManufacturersURL = '';

	private $mfcIndex = 0;
	private $currentMFCategoryAppliedManufacturers = array();
	private $manufacturerBaseURL = '';


	public function initializeData($manufacturerSlug = '') {
		$conf = CPFactory::getConfiguration();

		if ($conf->get('mf_show_manufacturers') == false) {
			$this->initializeData = 1;
			return;
		}

		$filterDataModel = CPFactory::getFilterDataModel();
		$db = JFactory::getDBO();
		$delimiter = '|';

		$columns = "vmc.`virtuemart_manufacturercategories_id`, vmcl.`mf_category_name`, vmcl.`slug`";
		$columns .= ", GROUP_CONCAT( vm.`virtuemart_manufacturer_id` SEPARATOR ';' ) AS `mf_ids`";

		$tables = array();
		$joins = array();
		$where = array();

		$tables[] = "`#__virtuemart_manufacturercategories` as vmc";
		// $joins[] = "LEFT JOIN `#__virtuemart_manufacturers_". CP_VMLANG ."` as vml USING (`virtuemart_manufacturer_id`)";
		$joins[] = "LEFT JOIN `#__virtuemart_manufacturers` as vm ON vm.`virtuemart_manufacturercategories_id`=".
			"vmc.`virtuemart_manufacturercategories_id`";
		$joins[] = "LEFT JOIN `#__virtuemart_manufacturercategories_". CP_VMLANG ."` as vmcl".
			" ON vmcl.`virtuemart_manufacturercategories_id`=vm.`virtuemart_manufacturercategories_id`";

		$where[] = "vm.`published`=1";
		$where[] = "vmc.`published`=1";

		// If provided manufacturer Slug name, get data just for that manufacturer
		if ($manufacturerSlug)
			$where[] = "vmcl.`slug`=". $db->quote($manufacturerSlug);


		$q = "SELECT ". $columns .
			" FROM (". implode(", ", $tables) .") ".
			implode(" ", $joins) .
			" WHERE ". implode(" AND ", $where) .
			" GROUP BY vmc.`virtuemart_manufacturercategories_id`";

		$db->setQuery($q);
		$mfData = $db->loadAssocList();

		$appliedManufacturersURL = '';
		$appliedCount = 0;
		if ($mfData) {
			foreach ($mfData as &$mf_category) {
				$appliedStr = JRequest::getVar($mf_category['slug'], '');
				$appliedManufacturers = array();
				if ($appliedStr) {
					$appliedArray = explode($delimiter, $appliedStr);
					foreach ($appliedArray as $mf) {
						if (trim($mf))
							$appliedManufacturers[] = $mf;
					}

					$mf_category['applied_mfs_slug'] = implode('|', $appliedManufacturers);
					$appliedManufacturersURL .= '&'. $mf_category['slug'] .'='.
						urlencode($filterDataModel->encodeURLEntities($mf_category['applied_mfs_slug']));
					$count = count($appliedManufacturers);
					$mf_category['applied_mfs_count'] = $count;
					$appliedCount += $count;

					$mf_category['applied_mfs_values'] = $appliedManufacturers;

					$q = "SELECT `virtuemart_manufacturer_id`, `mf_name` FROM `#__virtuemart_manufacturers_". CP_VMLANG ."` ".
						" WHERE `slug` IN ('". implode("', '", $appliedManufacturers) ."')";
					$db->setQuery($q);
					$appliedData = $db->loadAssocList();
					foreach ($appliedData as $row) {
						$mf_category['applied_mfs_ids'][] = $row['virtuemart_manufacturer_id'];
						$mf_category['applied_mfs_names'][] = $row['mf_name'];
					}
					if (!$this->appliedIds)
						$this->appliedIds = $mf_category['applied_mfs_ids'];
					else
						$this->appliedIds = array_merge($this->appliedIds, $mf_category['applied_mfs_ids']);
				} else {
					$mf_category['applied_mfs_slug'] = '';
					$mf_category['applied_mfs_ids'] = array();
					$mf_category['applied_mfs_names'] = array();
					$mf_category['applied_mfs_count'] = 0;
				}
			}
		}

		// var_dump($mfData);
		// var_dump($appliedManufacturersURL);


		$this->appliedCount = $appliedCount;
		$this->manufacturersData = $mfData;
		$this->appliedManufacturersURL = $appliedManufacturersURL;

		$this->initialized = 1;
	}


	function fetchCollection() {
		$conf = CPFactory::getConfiguration();

		if ($conf->get('mf_show_manufacturers') == false) {
			$this->fetchedCollection = 1;
			return;
		}

		$mode = $conf->get('select_mode');
		$layout = $conf->get('layout');
		$mfcData = $this->manufacturersData;
		$manufacturersCollection = array();

		$layoutDoesNotNeedFilters = ($layout == CP_LAYOUT_DROPDOWN && $conf->get('dd_load_filters_with_ajax'));
		$loadingDropDownFiltersWithAjax = (JRequest::getVar('action_type', '') == 'get_dd_filters');
		$layoutDoesNotNeedClearURL = ($layout == CP_LAYOUT_SIMPLE_DROPDOWN);
		$showClearUrl = ($conf->get('show_clearlink') && !$layoutDoesNotNeedClearURL);


		$thereAreManufacturersToShow = 0;
		foreach ($mfcData as $i => $mf_category) {
			$this->mfcIndex = $i;
			$thereAreManufacturersToShow = 0;

			// e.g.: when Dropdown layout is used with loading filters with Ajax
			// If single-select mode with filters applied -- let it thru to form XURL
			if ($layoutDoesNotNeedFilters && !$loadingDropDownFiltersWithAjax
				&& !($mode == CP_SINGLE_SELECT_MODE && $mf_category['applied_mfs_slug'])) {
					$manufacturersCollection[$i] = '';
					continue;
			}


			if ($mode == CP_SINGLE_SELECT_MODE && $mf_category['applied_mfs_slug']) {
				$manufacturersCollection[$i]['xurl'] = $this->getClearMfCategoryURL();
				$thereAreManufacturersToShow = 1;
			} else {
				$this->setCurrentMFCategoryAppliedManufacturers();
				if ($mfData = $this->getActiveManufacturersData()) {
					$this->appendAppliedManufacturersIfNeeded($mfData);
					$manufacturersCollection[$i]['mfs'] = $mfData;
					if ($mode == CP_MULTI_SELECT_MODE) {
						$manufacturersCollection[$i]['xurl'] = ($mf_category['applied_mfs_slug']
								&& $showClearUrl) ?
							$this->getClearMfCategoryURL() : '';
					}
					$thereAreManufacturersToShow = 1;
				}
			}

			if ($thereAreManufacturersToShow)
				$manufacturersCollection[$i]['mfc_name'] = $this->currentManufacturerCategoryName();

		}

		// echo '<pre>';
		// print_r($manufacturersCollection);

		$this->manufacturersCollection = $manufacturersCollection;
		$this->fetchedCollection = 1;
	}


	private function getActiveManufacturersData() {
		$mfData = $this->getManufacturersNameAndCountData();

		if (!$mfData) return false;

		$conf = CPFactory::getConfiguration();
		$layout = $conf->get('layout');
		$filterDataModel = CPFactory::getFilterDataModel();

		$layoutDoesNotNeedFilterURL = ($layout == CP_LAYOUT_CHECKBOX_LIST || $layout == CP_LAYOUT_SIMPLE_DROPDOWN);

		if (!$layoutDoesNotNeedFilterURL)
				$this->initBaseURLForManufacturerFilters();

		// When ordering applied filters and loading filters with Ajax we already moved them to the top
		$loadingSeeMoreWithAjax = JRequest::getVar('cp_loading_seemore_with_ajax', 0);
		$orderAppliedFilters = $conf->get('order_applied_filters');
		$shouldRemoveAppliedFilters = ($loadingSeeMoreWithAjax && $orderAppliedFilters);

		foreach ($mfData as $i => &$mf) {
			$manufacturerApplied = $this->isManufacturerApplied($mf['slug']);
			if ($manufacturerApplied && $shouldRemoveAppliedFilters) {
				unset($mfData[$i]);
				continue;
			}

			$mf['applied'] = $manufacturerApplied;

			if (!$layoutDoesNotNeedFilterURL)
				$mf['url'] = $this->getManufacturerURL($mf);
		}

		if (!$loadingSeeMoreWithAjax && $orderAppliedFilters) $this->orderAppliedManufacturers($mfData);

		// var_dump($mfData);
		return $mfData;
	}


	private function getManufacturersNameAndCountData() {
		$conf = CPFactory::getConfiguration();
		$layout = $conf->get('layout');

		$filterDataModel = CPFactory::getFilterDataModel();

		$useLimit = ($conf->get('hide_filters') == CP_HIDE_FILTERS_USING_SEEMORE
			&& $conf->get('use_seemore_ajax')
			&& ($layout != CP_LAYOUT_SIMPLE_DROPDOWN && $layout != CP_LAYOUT_DROPDOWN));
		$showNFilters = $conf->get('b4seemore');
		$getOnlyFilterNames = ($conf->get('filter_count') != PROD_COUNT_SHOW);

		$tables = array("`#__virtuemart_products` as p");
		//$joins = $filterDataModel->getBaseQueryJoins();
		//$where = $filterDataModel->getBaseQueryWheres();
		//$joins = $filterDataModel->getSqlJoinsExcluding(CP_MASK_MANUFACTURERS);
		//$where = $filterDataModel->getSqlWheresExcluding(CP_MASK_MANUFACTURERS);


//		$parametersData = $filterDataModel->getParametersData();
//		foreach ($parametersData as $i => $productType) {
//			$joiningPTID = $productType['id'];
//			if ($productType['applied']) {
//				if ($conf->get('legacy_mode')) {
//					$joins[] = "JOIN `#__vm_product_type_$joiningPTID` as pt$joiningPTID".
//						" ON p.`virtuemart_product_id`=pt$joiningPTID.`product_id`";
//				} else {
//					$joins[] = "JOIN `#__fastseller_product_type_$joiningPTID` as pt$joiningPTID".
//						" ON p.`virtuemart_product_id`=pt$joiningPTID.`product_id`";
//				}
//
//				foreach ($productType['parameters'] as $parameter) {
//					if ($parameter['where_clause'])
//						$where[] = $parameter['where_clause'];
//				}
//			}
//		}

		$currentMfcId = $this->currentManufacturerCategoryId();
		$joins[] = "JOIN `#__virtuemart_product_manufacturers` as vpm USING(`virtuemart_product_id`)";
		$joins[] = "JOIN `#__virtuemart_manufacturers` as vm".
			" ON vpm.`virtuemart_manufacturer_id`=vm.`virtuemart_manufacturer_id`";
		$joins[] = "JOIN `#__virtuemart_manufacturers_". CP_VMLANG ."` as vml".
			" ON vpm.`virtuemart_manufacturer_id`=vml.`virtuemart_manufacturer_id`";
		// $joins[] = "JOIN `#__virtuemart_manufacturercategories` as vmc".
		// 	" ON vm.`virtuemart_manufacturercategories_id`=vmc.`virtuemart_manufacturercategories_id`";
		
		// The order, that these joins are added after the manufacturers is
		// important. Order of joins in SQL matters. The above joins declare
		// table aliases (like `vpm`, `vm`) that the below (default) joins
		// use.
		$joins = array_merge($joins, $filterDataModel->getSqlJoinsExcluding(CP_MASK_MANUFACTURERS));

		$where[] = "vm.`virtuemart_manufacturercategories_id`='". $currentMfcId ."'";
		$where[] = "vm.`published`=1";
		$where = array_merge($where, $filterDataModel->getSqlWheresExcluding(CP_MASK_MANUFACTURERS));
		// $where[] = "vmc.`published`=1";

		if ($getOnlyFilterNames) {
			$q = "SELECT DISTINCT vml.`mf_name` as name, vml.`slug` as slug";
		} else {
			$q = "SELECT vml.`mf_name` as name, vml.`slug` as slug,".
				" COUNT(DISTINCT vpm.`virtuemart_product_id`) as count";
		}

		$q .= " FROM (". implode(', ', $tables) .") ".
			implode(' ', $joins) .
			" WHERE ";
		if ($where) $q .= implode(' AND ', $where);

		if (!$getOnlyFilterNames) $q .= " GROUP BY vml.`mf_name`";
		if ($useLimit) $q .= " LIMIT 0, $showNFilters";

		$db = JFactory::getDBO();
		$db->setQuery($q);

		$mfData = ($getOnlyFilterNames) ? $db->loadAssocList() : $db->loadAssocList();

		if (empty($mfData)) return array();

		// artificially add count = 1 to all filters
		if ($getOnlyFilterNames) {
			foreach ($mfData as $i => $mf)
				$mfData[$i] = array("name" => $mf['name'], "slug" => $mf['slug'], "count" => 1);
		}

		// sort filters by name in multi-dimensional array
		$mfNames = array();
		foreach ($mfData as $i => $mf) {
			$mfNames[$i] = $mf['name'];
		}

		// Note. You may experiment by using other sorting FLAGS, for example: SORT_ASC or SORT_DESC
		// You can get the list from here:
		// http://php.net/manual/en/function.array-multisort.php
		array_multisort($mfNames, SORT_ASC, $mfData);


		// echo '<pre style="font-size:13px;">';
		// print_r($mfData);

		return $mfData;
	}


	private function getManufacturerURL($mf) {
		$conf = CPFactory::getConfiguration();
		$filterDataModel = CPFactory::getFilterDataModel();
		$mode = $conf->get('select_mode');
		$useSmartRemove = $conf->get('use_smartremove');

		$url = '';
		$manufacturerCategorySlug = $this->currentManufacturerCategorySlug();
		if ($mode == CP_SINGLE_SELECT_MODE) {
			$url .= '&'. $manufacturerCategorySlug .'='.
				urlencode($filterDataModel->encodeURLEntities($mf['slug']));
		} else {
			$appliedMfsStr = $filterDataModel->encodeURLEntities($this->currentMCAppliedMFsSlug());
			$appliedMfs = ($appliedMfsStr) ? explode('|', $appliedMfsStr) : array();

			if ($mf['applied']) {
				// if ($useSmartRemove && $filterDataModel->appliedParametersCount() > 1 &&
				// 	count($appliedMfs) > 1)
				// {
				// 	$count = $this->getProductCountAfterFilterRemoved($filter);
				// 	if ($count == 0) return $this->getClearParameterSelectionURL();
				// }

				$result = array_diff($appliedMfs, (array)$mf['slug']);
				if ($result)
					$url .= '&'. $manufacturerCategorySlug .'='. urlencode(implode('|', $result));
			} else {
				$appliedMfs[] = $filterDataModel->encodeURLEntities($mf['slug']);
				$url .= '&'. $manufacturerCategorySlug .'='. urlencode(implode('|', $appliedMfs));
			}
		}

		$mfUrl = JRoute::_($this->manufacturerBaseURL . $url);

		return $mfUrl;
	}


	private function getClearMfCategoryURL() {
		$filterDataModel = CPFactory::getFilterDataModel();
		$url = '';
		$currentMfc = $this->mfcIndex;
		foreach ($this->manufacturersData as $i => $mf_category) {
			if ($i != $currentMfc && $mf_category['applied_mfs_slug']) {
				$url .= '&'. $mf_category['slug'] .'='.
					urlencode($filterDataModel->encodeURLEntities($mf_category['applied_mfs_slug']));
			}
		}

		$clearUrl = JRoute::_($filterDataModel->getURLExcluding(CP_URL_MANUFACTURERS) . $url);

		return $clearUrl;
	}


	private function initBaseURLForManufacturerFilters() {
		$filterDataModel = CPFactory::getFilterDataModel();

		$url = '';
		$manufacturersData = $this->manufacturersData();
		foreach ($manufacturersData as $i => $mf_category) {
			if ($i != $this->mfcIndex) {
				if ($mf_category['applied_mfs_slug'])
					$url .= '&'. $mf_category['slug'] .'='.
						urlencode($filterDataModel->encodeURLEntities($mf_category['applied_mfs_slug']));
			}
		}

		$this->manufacturerBaseURL = $filterDataModel->getURLExcluding(CP_URL_MANUFACTURERS) . $url;
	}


	private function isManufacturerApplied($mf_slug) {
		if (!$this->currentMFCategoryAppliedManufacturers) return false;

		// Check if current filter among applied filters, and if Yes -- remove from the array.
		// The filters that's left are most likely the ones under See more.. that will be loaded with Ajax.
		// They might need to be appanded if Order Applied filter to Top is enabled.
		$positionOfFound = array_search($mf_slug, $this->currentMFCategoryAppliedManufacturers);
		if ($positionOfFound !== false) {
			array_splice($this->currentMFCategoryAppliedManufacturers, $positionOfFound, 1);
			return true;
		} else {
			return false;
		}
	}


	private function setCurrentMFCategoryAppliedManufacturers() {
		$currentMfc = $this->mfcIndex;
		$appliedManufacturers = $this->manufacturersData[$currentMfc]['applied_mfs_slug'];
		$this->currentMFCategoryAppliedManufacturers = ($appliedManufacturers) ?
			explode('|', $appliedManufacturers) : array();
	}


	private function appendAppliedManufacturersIfNeeded(&$mfData) {
		$conf = CPFactory::getConfiguration();

		$shouldAppendFilters = true;
		$count = 0;
		if ($conf->get('hide_filters') == CP_HIDE_FILTERS_USING_SEEMORE && $conf->get('use_seemore_ajax')) {
			if (! $conf->get('order_applied_filters'))
				$shouldAppendFilters = false;
			$count = 1;
		}

		if ($shouldAppendFilters && $this->currentMFCategoryAppliedManufacturers) {
			// When applied manufacturers are taken from URL those are slugs.
			// To make them look beautiful again we take according names.
			$db = JFactory::getDBO();
			$q = "SELECT `slug`, `mf_name` FROM `#__virtuemart_manufacturers_". CP_VMLANG .
				"` WHERE `slug` IN('". implode("', '", $this->currentMFCategoryAppliedManufacturers) . "')";
			$db->setQuery($q);
			$result = $db->loadRowList();
			$mf_name_for_slug = array();
			foreach ($result as $r)
				$mf_name_for_slug[$r[0]] = $r[1];

			foreach ($this->currentMFCategoryAppliedManufacturers as $mf_slug) {
				$mf['name'] = $mf_name_for_slug[$mf_slug];
				$mf['slug'] = $mf_slug;
				$mf['count'] = $count;
				$mf['applied'] = true;
				if ($count)
					$mf['url'] = $this->getManufacturerURL($mf);
				array_unshift($mfData, $mf);
			}
		}
	}


	private function orderAppliedManufacturers(&$mfData) {
		$applied = array();
		$notApplied = array();

		foreach ($mfData as $mf) {
			if ($mf['applied']) {
				$applied[] = $mf;
			} else {
				$notApplied[] = $mf;
			}
		}

		$orderedFilters = array_merge($applied, $notApplied);
		$mfData = $orderedFilters;
	}



	// Accessor methods

	public function manufacturersData() {
		if ($this->initialized == 0)
			$this->initializeData();

		return $this->manufacturersData;
	}


	public function getCollection() {
		if ($this->fetchedCollection == 0)
			$this->fetchCollection();

		return $this->manufacturersCollection;
	}


	public function appliedIds() {
		if ($this->initialized == 0)
			$this->initializeData();

		return $this->appliedIds;
	}


	public function appliedManufacturersURL() {
		if ($this->initialized == 0)
			$this->initializeData();

		return $this->appliedManufacturersURL;
	}


	public function appliedManufacturers() {
		if ($this->initialized == 0)
			$this->initializeData();

		$params = array();
		$manufacturersData = $this->manufacturersData();
		foreach ($manufacturersData as $i => $mf_category) {
			if ($mf_category['applied_mfs_slug'])
				$params[] = $mf_category['slug'] .'='.
					urlencode($mf_category['applied_mfs_slug']);

		}

		return implode('&', $params);
	}


	public function appliedCount() {
		if ($this->initialized == 0)
			$this->initializeData();

		return $this->appliedCount;
	}

	public function setManufacturerCategory($index) {
		$this->mfcIndex = $index;
	}

	public function currentManufacturerCategoryId() {
		return $this->manufacturersData[$this->mfcIndex]['virtuemart_manufacturercategories_id'];
	}

	public function currentManufacturerCategoryName() {
		return $this->manufacturersData[$this->mfcIndex]['mf_category_name'];
	}

	public function currentManufacturerCategorySlug() {
		return $this->manufacturersData[$this->mfcIndex]['slug'];
	}

	/*
	* Return type String
	*/
	public function currentMCAppliedMFsSlug() {
		return $this->manufacturersData[$this->mfcIndex]['applied_mfs_slug'];
	}

	/*
	* Return type Array
	*/
	public function currentMCAppliedMFsNames() {
		return $this->manufacturersData[$this->mfcIndex]['applied_mfs_names'];
	}

	public function currentMFCategoryAppliedManufacturersCount() {
		return $this->manufacturersData[$this->mfcIndex]['applied_mfs_count'];
	}

}
