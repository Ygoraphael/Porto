<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class CPFilterModel {

	private $filtersCollection = array();
	private $parameterBaseURL = '';
	private $currentParameterAppliedFilters = array();


	public function getFiltersCollection() {

		$conf = CPFactory::getConfiguration();
		$mode = $conf->get('select_mode');
		$layout = $conf->get('layout');

		$layoutDoesNotNeedFilters = ($layout == CP_LAYOUT_DROPDOWN && $conf->get('dd_load_filters_with_ajax'));
		$layoutDoesNotNeedClearURL = ($layout == CP_LAYOUT_SIMPLE_DROPDOWN);
		$layoutWithProgressiveFilterLoading = ($layout == CP_LAYOUT_SIMPLE_DROPDOWN &&
			$conf->get('simpledropdown_mode') == CP_SIMPLEDROPDOWN_PROGRESSIVE_LOAD);
		$layoutAllowsTrackbar = ($layout == CP_LAYOUT_SIMPLE_LIST || $layout == CP_LAYOUT_CHECKBOX_LIST);


		$showClearUrl = ($conf->get('show_clearlink') && !$layoutDoesNotNeedClearURL);

		$filterDataModel = CPFactory::getFilterDataModel();
		$parametersData = $filterDataModel->getParametersData();
		$filtersCollection = array();


		foreach ($parametersData as $i => $productType) {
			if ($productType['show'] == false) continue;

			// keep track on current Product Type looped
			$filterDataModel->setPTIndex($i);

			$firstFilterGroupDoesntHaveFilters = false;
			foreach ($productType['parameters'] as $j => $parameter) {
				// keep track on current Parameter looped
				$filterDataModel->setParameterIndex($j);


				$parameterIsTrackbar = $filterDataModel->currentParameterIsTrackbar();
				if ($parameterIsTrackbar && $layoutAllowsTrackbar) {
					//$filtersCollection[$i][$j] = '';
					$filtersCollection[$i][$j]['xurl'] = $this->getClearParameterSelectionURL();
					continue;
				}


				if ($layoutWithProgressiveFilterLoading &&
					!($j == 0 || $parametersData[$i]['parameters'][$j-1]['applied_filters'])) {

					if (!$firstFilterGroupDoesntHaveFilters) {
						$filtersCollection[$i][$j]['filters'] = array();
					}
					continue;
				}



				// e.g.: when Dropdown layout is used with loading filters with Ajax
				// If single-select mode with filters applied -- let it thru to form XURL
				//if ($layoutDoesNotNeedFilters && !$parameter['applied_filters']) {
				if ($layoutDoesNotNeedFilters && !($mode == CP_SINGLE_SELECT_MODE && $parameter['applied_filters'])) {
					$filtersCollection[$i][$j] = '';
					continue;
				}


				// $parameterDisplayMode = $parameter['mode'];
	//			$parameterDisplayMode = $filterDataModel->currentParameterAttribute('mode');
//				$parameterDoesNotNeedClearURL = ($parameterDisplayMode == CP_PARAMETER_ONE_SLIDER
//					|| $parameterDisplayMode == CP_PARAMETER_TWO_SLIDERS);
	//			$parameterDoesNotNeedClearURL = ($parameterDisplayMode == CP_TRACKBAR_ONE_KNOB_EXACT ||
	//				$parameterDisplayMode == CP_TRACKBAR_ONE_KNOB_COMPARE ||
	//				$parameterDisplayMode == CP_TRACKBAR_TWO_KNOBS);
				$parameterDoesNotNeedClearURL = false;


				if ($mode == CP_SINGLE_SELECT_MODE && $parameter['applied_filters'] && !$parameterDoesNotNeedClearURL) {
					$filtersCollection[$i][$j]['xurl'] = $this->getClearParameterSelectionURL();
				} else {
					$this->setCurrentParameterAppliedFilters();
					if ($filterData = $this->getActiveFilterDataForParameter()) {
						$this->appendAppliedFiltersIfNeeded($filterData);
						$filtersCollection[$i][$j]['filters'] = $filterData;

						if ($mode == CP_MULTI_SELECT_MODE) {
							$filtersCollection[$i][$j]['xurl'] = ($parameter['applied_filters']
									&& $showClearUrl
									&& !$parameterDoesNotNeedClearURL) ?
								$this->getClearParameterSelectionURL() : '';
						}

					} else if ($layoutWithProgressiveFilterLoading && $j == 0) {
						$firstFilterGroupDoesntHaveFilters = true;
					}


				}

			}
		}

		// echo '<pre style="font-size:13px;">';
		// echo '<br/><br/>Info:<br/>';
		// print_r($filtersCollection);
		// echo '</pre>';


		return $filtersCollection;
	}


	private function getActiveFilterDataForParameter() {

		$filterData = $this->getFiltersNameAndCountData();

		// echo '<pre style="font-size:13px;">';
		// print_r($filterData);

		if (! $filterData)
			return false;

		$conf = CPFactory::getConfiguration();
		$layout = $conf->get('layout');

		$filterDataModel = CPFactory::getFilterDataModel();

		// $parameterMode = $filterDataModel->currentParameterMode();
//		$parameterMode = $filterDataModel->currentParameterAttribute('mode');
//		$parameterIsSlider = ($parameterMode == CP_TRACKBAR_ONE_KNOB_EXACT ||
//			$parameterMode == CP_TRACKBAR_ONE_KNOB_COMPARE ||
//			$parameterMode == CP_TRACKBAR_TWO_KNOBS);

	//	$parameterIsTrackbar = $filterDataModel->currentParameterIsTrackbar();
	//	$parameterDoesNotNeedFilterURL = ($parameterIsTrackbar &&
	//		($layout == CP_LAYOUT_SIMPLE_LIST || $layout == CP_LAYOUT_CHECKBOX_LIST));

		$layoutDoesNotNeedFilterURL = ($layout == CP_LAYOUT_CHECKBOX_LIST || $layout == CP_LAYOUT_SIMPLE_DROPDOWN);

		// When ordering applied filters and loading filters with Ajax we already moved them to the top
		$loadingSeeMoreWithAjax = JRequest::getVar('cp_loading_seemore_with_ajax', 0);
		$orderAppliedFilters = $conf->get('order_applied_filters');
		$shouldRemoveAppliedFilters = ($loadingSeeMoreWithAjax && $orderAppliedFilters);

		//if (!$loadingSeeMoreWithAjax && $orderAppliedFilters) $this->orderAppliedFilters($filterData);

		//if (!$layoutDoesNotNeedFilterURL && !$parameterDoesNotNeedFilterURL)
		if (!$layoutDoesNotNeedFilterURL)
			$this->initBaseURLForCurrentParameter();

		foreach ($filterData as $i => &$filter) {
			$filterApplied = $this->isFilterApplied($filter['name']);
			if ($filterApplied && $shouldRemoveAppliedFilters) {
				unset($filterData[$i]);
				continue;
			}

			$filter['applied'] = $filterApplied;

			//if (!$layoutDoesNotNeedFilterURL && !$parameterDoesNotNeedFilterURL) {
			if (!$layoutDoesNotNeedFilterURL) {
				$filter['url'] = $this->getFilterURL($filter['name'], $filterApplied);
			}
		}

		if (!$loadingSeeMoreWithAjax && $orderAppliedFilters)
			$this->orderAppliedFilters($filterData);

		//print_r($filterData);

		return $filterData;
	}


	public function getFiltersNameAndCountData($excludeAppliedRefinements = false) {
		$conf = CPFactory::getConfiguration();
		$layout = $conf->get('layout');

		$filterDataModel = CPFactory::getFilterDataModel();
		// $parameterMode = $filterDataModel->currentParameterMode();
		$parameterMode = $filterDataModel->currentParameterAttribute('mode');
	//	$parameterIsSlider = ($parameterMode == CP_TRACKBAR_ONE_KNOB_EXACT ||
	//		$parameterMode == CP_TRACKBAR_ONE_KNOB_COMPARE ||
	//		$parameterMode == CP_TRACKBAR_TWO_KNOBS);
		$layoutAllowsTrackbarAndColorPalette = ($layout == CP_LAYOUT_SIMPLE_LIST
			|| $layout == CP_LAYOUT_CHECKBOX_LIST);
		$parameterIsTrackbar = $filterDataModel->currentParameterIsTrackbar();
		$parameterDoesNotNeedFilterCount = (
			$layoutAllowsTrackbarAndColorPalette &&
			($parameterIsTrackbar || $parameterMode == CP_COLOR_PALETTE_PARAMETER)
		);

		$parameterHiding = $filterDataModel->currentParameterAttribute('hiding_filters');
		$useLimit = (
			($conf->get('hide_filters') == CP_HIDE_FILTERS_USING_SEEMORE
				&& $parameterHiding == CP_PARAMETER_HIDING_GLOBAL
				|| $parameterHiding == CP_PARAMETER_HIDE_USING_SEEMORE)
			&&
			($conf->get('use_seemore_ajax') && $parameterMode == CP_DEFAULT_PARAMETER
				&& ($layout != CP_LAYOUT_SIMPLE_DROPDOWN && $layout != CP_LAYOUT_DROPDOWN))
		);

		$parameterSeeMoreSize = $filterDataModel->currentParameterAttribute('see_more_size');
		$showNFilters = ($parameterHiding == CP_PARAMETER_HIDE_USING_SEEMORE && $parameterSeeMoreSize) ?
			$parameterSeeMoreSize : $conf->get('b4seemore');
		$getOnlyFilterNames = ($conf->get('filter_count') != PROD_COUNT_SHOW || $parameterDoesNotNeedFilterCount);
		$progressiveFilterLoading = ($layout == CP_LAYOUT_SIMPLE_DROPDOWN &&
			$conf->get('simpledropdown_mode') == CP_SIMPLEDROPDOWN_PROGRESSIVE_LOAD);

		$parameterPTID = $filterDataModel->currentParameterPTID();
		$parameterName = $filterDataModel->currentParameterName();
		$parameterMultiAssigned = $filterDataModel->currentParameterMultiAssigned();

		$ptTableAliasMain = "pt$parameterPTID";
		$tables = array("`#__virtuemart_products` as p");
		//$joins = $filterDataModel->getBaseQueryJoins();
		//$where = $filterDataModel->getBaseQueryWheres();
		$sql_mask = CP_MASK_FILTERS;
		if ($excludeAppliedRefinements)
			$sql_mask |= CP_MASK_PRICES | CP_MASK_MANUFACTURERS;
		$joins = $filterDataModel->getSqlJoinsExcluding($sql_mask);
		$where = $filterDataModel->getSqlWheresExcluding($sql_mask);


		if ($conf->get('legacy_mode')) {
			$joins[] = "JOIN `#__vm_product_type_$parameterPTID` as $ptTableAliasMain".
				" ON p.`virtuemart_product_id`=$ptTableAliasMain.`product_id`";
		} else {
			$joins[] = "JOIN `#__fastseller_product_type_$parameterPTID` as $ptTableAliasMain".
				" ON p.`virtuemart_product_id`=$ptTableAliasMain.`product_id`";
		}

		if (!$excludeAppliedRefinements) {
			$parametersData = $filterDataModel->getParametersData();
			foreach ($parametersData as $i => $productType) {
				$joiningPTID = $productType['id'];

				if ($progressiveFilterLoading && ($parameterPTID != $joiningPTID) && $conf->get('global_scope') == false) {
					continue;
				}

				if ($joiningPTID != $parameterPTID && $productType['applied']) {
					if ($conf->get('legacy_mode')) {
						$joins[] = "JOIN `#__vm_product_type_$joiningPTID` as pt$joiningPTID".
							" ON p.`virtuemart_product_id`=pt$joiningPTID.`product_id`";
					} else {
						$joins[] = "JOIN `#__fastseller_product_type_$joiningPTID` as pt$joiningPTID".
							" ON p.`virtuemart_product_id`=pt$joiningPTID.`product_id`";
					}
				}

				foreach ($productType['parameters'] as $parameter) {
					if ($parameter['name'] != $parameterName) {
						if ($parameter['where_clause']) $where[] = $parameter['where_clause'];
					} else if ($progressiveFilterLoading) {
						break;
					}
				}
			}
		}

//		$mid = $filterDataModel->manufacturerId();
//		$manufacturers = CPFactory::getManufacturersDataModel();
//		if ($mid || $manufacturers->appliedCount() > 0) {
//			if ( !$filterDataModel->joinedManufacturers())
//				$joins[] = "JOIN `#__virtuemart_product_manufacturers` as vpm USING(`virtuemart_product_id`)";
//			$appliedIds = $manufacturers->appliedIds();
//			if ($mid)
//				array_merge($appliedIds, (array)$mid);
//			$where[] = "vpm.`virtuemart_manufacturer_id` IN ('". implode("', '", $appliedIds) ."')";
//		}


		if ($getOnlyFilterNames) {
			$q = "SELECT DISTINCT $ptTableAliasMain.`$parameterName`";
		} else {
			$q = "SELECT $ptTableAliasMain.`$parameterName` as name, COUNT(DISTINCT $ptTableAliasMain.`product_id`) as count";
		}

		$q .= " FROM (". implode(', ', $tables) .") ".
			implode(' ', $joins) .
			" WHERE $ptTableAliasMain.`$parameterName`<>''";

		if ($where)
			$q .= " AND ". implode(' AND ', $where);

		//$q .= " GROUP BY $ptTableAliasMain.`product_id`, $ptTableAliasMain.`$parameterName`";
		if (!$getOnlyFilterNames)
			$q .= " GROUP BY $ptTableAliasMain.`$parameterName`";
	//	$q .= " order by $ptTableAliasMain.`$parameterName`";

		if ($useLimit && !$parameterMultiAssigned)
			$q .= " LIMIT 0, $showNFilters";

		$db = JFactory::getDBO();
		$db->setQuery($q);

		//$result = $db->loadResultArray();
		$filterData = ($getOnlyFilterNames) ? $db->loadResultArray() : $db->loadAssocList();

		if (empty($filterData)) return array();

		//echo '<pre style="font-size:13px;">';
		//print_r($filterData);
		//echo '</pre>';

		// If Parameter has products with multiple assigned filters (10;20;30)
		// we need to normalize them
		if ($parameterMultiAssigned) {

			/* /

			$multipleFiltersArray = array();
			foreach ($filterData as $index => $filter) {
				$multiAssigned = strpos($filter['name'], ';');
				if ($multiAssigned !== false) {
					$multipleFiltersArray[] = $filter;
					unset($filterData[$index]);
				}
			}


			foreach ($multipleFiltersArray as $multipleFiltersElem) {
				$multipleFilters = explode(';', $multipleFiltersElem['name']);
				foreach ($multipleFilters as $mindex => $mfilter) {
					$isNewFilter = true;
					foreach ($filterData as &$filter) {
						if ($mfilter == $filter['name']) {
							$filter['count'] += $multipleFiltersElem['count'];
							$isNewFilter = false;
							break;
						}
					}

					if ($isNewFilter) $filterData[] = array("name" => $mfilter, "count" => $multipleFiltersElem['count']);
				}
			}

		/*	*/
		/*	*/
			$normalizedFilterArray = array();

			if ($getOnlyFilterNames) {
				//$uniqueFilters = array();
				foreach ($filterData as $multiFilters) {
					$filterParts = explode(';', $multiFilters);
					foreach ($filterParts as $filterPart) {
						if (!in_array($filterPart, $normalizedFilterArray))
							$normalizedFilterArray[] = $filterPart;
					}

				}
			} else {
				foreach ($filterData as $multiFilters) {
					$filterParts = explode(';', $multiFilters['name']);
					foreach ($filterParts as $filterPart) {
						$isNewFilter = true;
						foreach ($normalizedFilterArray as &$normalizedFilter) {
							if ($normalizedFilter['name'] == $filterPart) {
								$normalizedFilter['count'] += $multiFilters['count'];
								$isNewFilter = false;
								break;
							}
						}

						if ($isNewFilter) $normalizedFilterArray[] = array(
							"name" => $filterPart,
							"count" => $multiFilters['count']);
					}

				}
			}

			$filterData = $normalizedFilterArray;
	/*	*/

			// echo '<pre>';
			// print_r($filterData);
			// echo '</pre>';

		}


		// artificially add count = 1 to all filters
		if ($getOnlyFilterNames) {
			// simple sort
			natsort($filterData);
			foreach ($filterData as $i => $filterName) {
				$filterData[$i] = array("name" => $filterName, "count" => 1);
			}
		} else {
			// sort filters by name in multi-dimensional array
			$filterNames = array();
			foreach ($filterData as $i => $row) {
				$filterNames[$i] = $row['name'];
			}

			/*
			// sort filters according to sorting in Fast Seller
			$q = "SELECT `parameter_values` FROM `#__vm_product_type_parameter` WHERE `parameter_name`='$parameterName'";
			$db->setQuery($q);
			$dbNamesStr = $db->loadResult();
			$dbNames = explode(';', $dbNamesStr);
			$sortedData = array();
			foreach ($dbNames as $name) {
				foreach ($filterData as $i => $row) {
					if ($name == $row['name']) {
						$sortedData[] = array("name" => $name, "count" => $row['count']);
						break;
					}
				}
			}
			$filterData = $sortedData;
			*/

			// Note. You may experiment by using other sorting FLAGS, for example: SORT_NATURAL
			// You can get the list from here:
			// http://php.net/manual/en/function.array-multisort.php
			array_multisort($filterNames, SORT_NUMERIC, $filterData);
		}

		// normalize keys: to start from 0..
	//	$filterData = array_values($filterData);


		// after normalizing multiple filter we may end up with larger number of filters
		// then set in limit
		if ($useLimit && count($filterData) > $showNFilters)
			array_splice($filterData, $showNFilters);

		// echo '<pre style="font-size:13px;">';
		// print_r($filterData);


		return $filterData;
	}



	private function appendAppliedFiltersIfNeeded(&$filterData) {
		// if any filters left in Applied Filters array it means these have zero count

		//print_r($this->currentParameterAppliedFilters);

		$conf = CPFactory::getConfiguration();
		$filterDataModel = CPFactory::getFilterDataModel();

		// $parameterMode = $filterDataModel->currentParameterMode();
		$parameterMode = $filterDataModel->currentParameterAttribute('mode');
		if ($parameterMode == CP_TRACKBAR_TWO_KNOBS) {
			if ($appliedFiltersStr = $filterDataModel->currentParameterAppliedFilters()) {
				$appliedFilters = explode($conf->get('trackbar_range_delimiter'), $appliedFiltersStr);
				foreach ($appliedFilters as $appliedFilter) {
					if ($appliedFilter == null) continue;

					$appliedFilterIsInAvailableFilters = false;
					foreach ($filterData as $filter) {
						if ($appliedFilter == $filter['name']) {
							$appliedFilterIsInAvailableFilters = true;
							break;
						}
					}

					if (!$appliedFilterIsInAvailableFilters) {
						$newFilter = array("name" => $appliedFilter, "count" => 1);
						array_unshift($filterData, $newFilter);
					}
				}
			}

			return;
		}

		$shouldAppendFilters = true;
		// If $count stays zero, that means those filters were applied, but do no
		// match any products anymore. We still want to show them.
		$count = 0;
		$parameterHiding = $filterDataModel->currentParameterAttribute('hiding_filters');
		$useSeeMore = ($conf->get('hide_filters') == CP_HIDE_FILTERS_USING_SEEMORE
				&& $parameterHiding == CP_PARAMETER_HIDING_GLOBAL
				|| $parameterHiding == CP_PARAMETER_HIDE_USING_SEEMORE);

		// if ($conf->get('use_seemore') && $conf->get('use_seemore_ajax')) {
		if ($useSeeMore && $conf->get('use_seemore_ajax')) {
			if (! $conf->get('order_applied_filters'))
				$shouldAppendFilters = false;
			$count = 1;		// we do not need to know actual count for applied filters
		}

		if ($shouldAppendFilters && $this->currentParameterAppliedFilters) {
			foreach ($this->currentParameterAppliedFilters as $filterName) {
				$filter['name'] = $filterName;
				$filter['count'] = $count;
				if ($count) $filter['url'] = $this->getFilterURL($filterName, true);
				$filter['applied'] = true;
				array_unshift($filterData, $filter);
			}
		}
	}


	private function isFilterApplied($filter) {
		if (!$this->currentParameterAppliedFilters) return false;

		// Check if current filter among applied filters, and if Yes -- remove from the array.
		// The filters that's left are most likely the ones under See more.. that will be loaded with Ajax.
		// They might need to be appanded if Order Applied filter to Top is enabled.
		$positionOfFound = array_search($filter, $this->currentParameterAppliedFilters);
		if ($positionOfFound !== false) {
			array_splice($this->currentParameterAppliedFilters, $positionOfFound, 1);
			return true;
		} else {
			return false;
		}
	}


	private function setCurrentParameterAppliedFilters() {
		$filterDataModel = CPFactory::getFilterDataModel();
		$appliedFilters = $filterDataModel->currentParameterAppliedFilters();

		$this->currentParameterAppliedFilters = ($appliedFilters) ? explode('|', $appliedFilters) : array();
	}


	private function orderAppliedFilters(&$filters) {

		$applied = array();
		$notApplied = array();

		foreach ($filters as $filter) {
			if ($filter['applied']) {
				$applied[] = $filter;
			} else {
				$notApplied[] = $filter;
			}
		}

		$orderedFilters = array_merge($applied, $notApplied);
		$filters = $orderedFilters;
	}


	private function initBaseURLForCurrentParameter() {
		$filterDataModel = CPFactory::getFilterDataModel();
		$ptIndex = $filterDataModel->ptIndex();
		$parameterIndex = $filterDataModel->parameterIndex();
		$url = '';

		$parametersData = $filterDataModel->getParametersData();
		foreach ($parametersData as $i => $productType) {
			foreach ($productType['parameters'] as $j => $parameter) {
				if (!($i == $ptIndex && $j == $parameterIndex)) {
					if ($parameter['applied_filters'])
						$url .= '&'. $parameter['name'] .'='.
							urlencode($filterDataModel->encodeURLEntities($parameter['applied_filters']));
				}
			}
		}

		// $this->parameterBaseURL = $filterDataModel->baseURLWithPrices() . $url;
		$this->parameterBaseURL = $filterDataModel->getURLExcluding(CP_URL_FILTERS) . $url;
	}


	private function getFilterURL($filter, $filterApplied) {
		$conf = CPFactory::getConfiguration();
		$mode = $conf->get('select_mode');
		$useSmartRemove = $conf->get('use_smartremove');

		$url = '';

		$filterDataModel = CPFactory::getFilterDataModel();
		$parameterName = $filterDataModel->currentParameterName();

		if ($mode == CP_SINGLE_SELECT_MODE) {
			// $url .= '&'. $parameterName .'='. urlencode($filter);
			$url .= '&'. $parameterName .'='. urlencode($filterDataModel->encodeURLEntities($filter));
		} else {
			// $appliedFiltersStr = $filterDataModel->encodeURLEntities($filterDataModel->currentParameterAppliedFilters());
			$appliedFiltersStr = $filterDataModel->currentParameterAppliedFilters();
			$appliedFilters = ($appliedFiltersStr) ? explode('|', $appliedFiltersStr) : array();

			if ($filterApplied) {
				if ($useSmartRemove && $filterDataModel->appliedParametersCount() > 1 &&
					count($appliedFilters) > 1)
				{
					$count = $this->getProductCountAfterFilterRemoved($filter);
					if ($count == 0) return $this->getClearParameterSelectionURL();
				}

				$result = array_diff($appliedFilters, (array)$filter);
				if ($result)
					$url .= '&'. $parameterName .'='.
						urlencode($filterDataModel->encodeURLEntities(implode('|', $result)));
			} else {
				// $appliedFilters[] = $filterDataModel->encodeURLEntities($filter);
				$appliedFilters[] = $filter;
				$url .= '&'. $parameterName .'='.
					urlencode($filterDataModel->encodeURLEntities(implode('|', $appliedFilters)));
			}
		}

		$filterUrl = JRoute::_($this->parameterBaseURL . $url);

		return $filterUrl;
	}


	private function getClearParameterSelectionURL() {
		$filterDataModel = CPFactory::getFilterDataModel();
		$ptIndex = $filterDataModel->ptIndex();
		$parameterIndex = $filterDataModel->parameterIndex();
		$url = '';

		$parametersData = $filterDataModel->getParametersData();
		foreach ($parametersData as $i => $productType) {
			foreach ($productType['parameters'] as $j => $parameter) {
				if (!($ptIndex == $i && $parameterIndex == $j)) {
					if ($parameter['applied_filters'])
						$url .= '&'. $parameter['name'] .'='.
							urlencode($filterDataModel->encodeURLEntities($parameter['applied_filters']));
						//	$url .= '&'. $parameter['name'] .'='. urlencode($parameter['applied_filters']);
				}
			}
		}

		// $clearUrl = JRoute::_($filterDataModel->baseURLWithPrices() . $url);
		$clearUrl = JRoute::_($filterDataModel->getURLExcluding(CP_URL_FILTERS) . $url);

		return $clearUrl;
	}



	// private function encodeURLEntities($string) {
	// 	$config = JFactory::getConfig();
	// 	$sefEnabled = $config->getValue('config.sef');

	// 	 //When Joomla SEF is enabled we need to double-encode special chars.
	// 	//his way, when Joomla decodes URL, we end up with properly encoded URL.

	// 	if ($sefEnabled) {
	// 		$string = str_replace('&', '%2526', $string);
	// 		$string = str_replace('+', '%252B', $string);
	// 	} else {
	// 		$string = str_replace('&', '%26', $string);
	// 		$string = str_replace('+', '%2B', $string);
	// 	}

	// 	return $string;
	// }




	private function getProductCountAfterFilterRemoved($filter) {
		$filterDataModel = CPFactory::getFilterDataModel();
		$conf = CPFactory::getConfiguration();
		$ptIndex = $filterDataModel->ptIndex();
		$parameterIndex = $filterDataModel->parameterIndex();

		$db = JFactory::getDBO();

		$tables = array("`#__virtuemart_products` as p");
		//$joins = $filterDataModel->getBaseQueryJoins();
		//$where = $filterDataModel->getBaseQueryWheres();
		$joins = $filterDataModel->getSqlJoinsExcluding(CP_MASK_FILTERS);
		$where = $filterDataModel->getSqlWheresExcluding(CP_MASK_FILTERS);

		$parametersData = $filterDataModel->getParametersData();
		foreach ($parametersData as $i => $productType) {
			// if ($filterDataModel->productTypeIsApplied($i)) {
			if ($productType['applied']) {
				// $joiningPTID = $filterDataModel->ptIdByIndex($i);
				$joiningPTID = $productType['id'];
				if ($conf->get('legacy_mode')) {
					$joins[] = "JOIN `#__vm_product_type_$joiningPTID` as pt$joiningPTID".
						" ON p.`virtuemart_product_id`=pt$joiningPTID.`product_id`";
				} else {
					$joins[] = "JOIN `#__fastseller_product_type_$joiningPTID` as pt$joiningPTID".
						" ON p.`virtuemart_product_id`=pt$joiningPTID.`product_id`";
				}


				foreach ($productType['parameters'] as $j => $parameter) {
					if ($i == $ptIndex && $j == $parameterIndex) {
						$appliedFiltersStr = $filterDataModel->currentParameterAppliedFilters();
						$appliedFilters = explode('|', $appliedFiltersStr);
						$restFilters = array_diff($appliedFilters, (array)$filter);
						$parameterName = $filterDataModel->currentParameterName();
						$multiAssigned = $filterDataModel->currentParameterMultiAssigned();

						if ($multiAssigned) {
							$w = array();
							foreach ($restFilters as $f) {
								$w[] = "FIND_IN_SET(". $db->quote($f) .", REPLACE(pt$joiningPTID.`". $parameterName ."`, ';', ','))";
							}
							$where[] = "(". implode(' OR ', $w) .")";
						} else {
							$where[] = "pt$joiningPTID.`$parameterName` IN ('". implode("', '", $restFilters) ."')";
						}
					} else {
						if ($parameter['where_clause']) $where[] = $parameter['where_clause'];
					}
				}
			}
		}

		$q = "SELECT COUNT(*)".
			" FROM (". implode(', ', $tables) .") ".
			implode(' ', $joins) .
			" WHERE ". implode(' AND ', $where);





		$db->setQuery($q);
		$count = $db->loadResult();

		// echo '<br/>after-remove query for filter: '. $filter .'<br/>';
		// echo $q;
		// echo '<br/>Count:'. $count;
		// echo '<br/>---<br/>';

		return $count;
	}


	public function fillMetaTitle() {
		$selectionTitle = array();
		$filterDataModel = CPFactory::getFilterDataModel();

		$lp = $filterDataModel->lowPrice();
		$hp = $filterDataModel->highPrice();

		// change currency here
		$currency_sign = "$";

		if ($lp && $hp) {
			$selectionTitle[] = $currency_sign . $lp .' - '. $currency_sign . $hp;
		} else if ($lp) {
			$selectionTitle[] = $currency_sign . $lp .' & '. JText::_('Above');
		} else if ($hp) {
			$selectionTitle[] = $currency_sign . $hp .' & '. JText::_('Under');
		}

		$parametersData = $filterDataModel->getParametersData();
		foreach ($parametersData as $productType) {
			foreach ($productType['parameters'] as $parameter) {
				if ($parameter['applied_filters']) {
					$selectionTitle[] = $parameter['title'] .': '. str_replace('|', ', ', $parameter['applied_filters']);
				}
			}
		}

		if ($selectionTitle) {
			$doc = JFactory::getDocument();
			$doc->setTitle($doc->getTitle() .' - '. implode(' | ', $selectionTitle));
		}
	}

	public function addNoindexMeta() {
		$filterDataModel = CPFactory::getFilterDataModel();
		if ($filterDataModel->appliedParametersCount() > 0) {
			$doc = JFactory::getDocument();
			$doc->setMetaData('robots', 'nofollow, noindex');
			//$doc->setMetaData('googlebot', 'noindex');
		}
	}



	// -----------------------------------------------------------------------------
	// SEE MORE AJAX. When getting Parameters Data for See More.. in Ajax query,
	// we do not need full data, so we make it easier.
	// ------------------------------------------------------------------------------

	// public function showSeeMoreFilters() {
	public function getSeeMoreFilters() {

		//$inquiringCFid = JRequest::getVar('cfid', null);
		$inquiringParameterName = JRequest::getVar('data_value', null);
		$filterDataModel = CPFactory::getFilterDataModel();
		$parametersData = $filterDataModel->getParametersData();
		$filtersCollection = array();

		foreach ($parametersData as $i => $productType) {
			if ($productType['show'] == false)
				continue;

			// keep track on current Product Type looped
			$filterDataModel->setPTIndex($i);
			foreach ($productType['parameters'] as $j => $parameter) {
				// keep track on current Parameter looped
				$filterDataModel->setParameterIndex($j);

				if ($inquiringParameterName == $parameter['name']) {
					$this->setCurrentParameterAppliedFilters();
					$filtersCollection = $this->getActiveFilterDataForParameter();
					$this->appendAppliedFiltersIfNeeded($filtersCollection);

					// require_once('../filterWriter.php');
					// CPFilterWriter::printSeeMoreFilters($filterData);

					break 2;
				}
			}
		}

		// print_r($filtersCollection);

		return $filtersCollection;
	}


	// -----------------------------------------------------------------------------
	// Load specific Parameter filters with AJAX (like Drop-down). In this case
	// we do not need full data, so we make it easier.
	// ------------------------------------------------------------------------------


	// public function showParameterFilters() {
	public function getParameterFilters() {

		$inquiringParameterName = JRequest::getVar('data_value', null);
		$conf = CPFactory::getConfiguration();
		$showClearUrl = $conf->get('show_clearlink');
		$filterDataModel = CPFactory::getFilterDataModel();
		$parametersData = $filterDataModel->getParametersData();
		$filtersCollection = array();

		foreach ($parametersData as $i => $productType) {
			if ($productType['show'] == false) continue;

			// keep track on current Product Type looped
			$filterDataModel->setPTIndex($i);
			foreach ($productType['parameters'] as $j => $parameter) {
				// keep track on current Parameter looped
				$filterDataModel->setParameterIndex($j);

				if ($inquiringParameterName == $parameter['name']) {

					$this->setCurrentParameterAppliedFilters();
					$filterData = $this->getActiveFilterDataForParameter();
					$this->appendAppliedFiltersIfNeeded($filterData);

					//echo '<pre style="font-size:13px;">';
					//print_r($filterData);

					if ($filterData) {
						$filtersCollection = array("filters" => $filterData);

						$filtersCollection['xurl'] = ($parameter['applied_filters'] && $showClearUrl) ?
							$this->getClearParameterSelectionURL() : '';

						// require_once('../filterWriter.php');
						// CPFilterWriter::printParameterFilters($data);
					}

					break 2;

				}
			}
		}

		return $filtersCollection;
	}



}
?>
