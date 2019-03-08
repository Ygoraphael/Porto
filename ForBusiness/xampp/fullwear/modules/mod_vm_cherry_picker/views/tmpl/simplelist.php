<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$conf = CPFactory::getConfiguration();
$filterDataModel = CPFactory::getFilterDataModel();
$manufacturers = CPFactory::getManufacturersDataModel();

$mode = $conf->get('select_mode');
$show_clearlink = $conf->get('show_clearlink');
$moduleID = $conf->get('module_id');
$useQuickrefine = $conf->get('use_quickrefine');
$quickrefineManufacturers = ($useQuickrefine && $conf->get('quickrefine_manufacturers'));

$inquiringWithAjax = $conf->get('ajax_request');
if ($inquiringWithAjax)
	$this->loadJavascript = false;


// $showNFilters = false;
// $useSeeMoreAjax = false;
// if ($conf->get('use_seemore')) {
// 	if ($conf->get('use_seemore_ajax')) {
// 		$useSeeMoreAjax = true;
// 	} else {
// 		$showNFilters = true;
// 		$show_before = $conf->get('b4seemore');
// 	}

// 	$seemore_anchor = $conf->get('smanchor');
// 	$this->loadSeeMoreJavascript = true;
// }


$hideFilters = $conf->get('hide_filters');
$useSeeMore = ($hideFilters == CP_HIDE_FILTERS_USING_SEEMORE);
$useSeeMoreAjax = $conf->get('use_seemore_ajax');
$showBeforeSeeMore = $conf->get('b4seemore');
$seeMoreAnchor = $conf->get('smanchor');
if ($useSeeMore)
	$this->loadSeeMoreJavascript = true;

$useScroll = ($hideFilters == CP_HIDE_FILTERS_USING_SCROLL);
$scrollHeight = $conf->get('scroll_height');



echo '<div class="cp-filter-simplelist" id="cpFilters'. $moduleID .'">';

$this->printFiltersTitle();
$this->printFormStart();

$printPriceForm = false;
if ($conf->get('use_price_search')) {
	if ($conf->get('price_position') == CP_PRICE_TOP) {
		$this->printPriceForm();
	} else {
		$printPriceForm = true;
	}
}

$collapseClass = '';
if ($useCollapse = $conf->get('use_collapse')) {
	$collapseClass = ' cp-collapse';
	$this->loadCollapseJavascript = true;
}

$translate = $conf->get('translate');
$hideParamsWith1Filter = $conf->get('hide_params_with1filter');
$showCount = ($conf->get('filter_count') == PROD_COUNT_SHOW) ? true : false;



// --------------------------------------------------------------------
// Show available FILTERS
// --------------------------------------------------------------------

foreach ($filtersCollection as $i => $productType) {
	$filterDataModel->setPTIndex($i);

	if ($conf->get('show_pt_title'))
		echo '<h2 class="cp-group-parent">'. $filterDataModel->currentPTTitle() .'</h2>';

	foreach ($productType as $j => $parameter) {
		$filterDataModel->setParameterIndex($j);

		// skip parameters that end up with 1 filter
		if ($hideParamsWith1Filter && count($parameter['filters']) < 2)
			continue;

		// $parameterMode = $filterDataModel->currentParameterMode();
		$parameterMode = $filterDataModel->currentParameterAttribute('mode');
		if ($parameterMode == CP_TRACKBAR_ONE_KNOB_EXACT ||
			$parameterMode == CP_TRACKBAR_ONE_KNOB_COMPARE ||
			$parameterMode == CP_TRACKBAR_TWO_KNOBS)
		{
			$this->printTrackbarParameter($parameter);
			continue;
		} else if ($parameterMode == CP_COLOR_PALETTE_PARAMETER) {
			$this->printColorPaletteParameter($parameter);
			continue;
		}


		$parameterHiding = $filterDataModel->currentParameterAttribute('hiding_filters');
		if ( !$this->loadSeeMoreJavascript && $parameterHiding == CP_PARAMETER_HIDE_USING_SEEMORE) {
			$this->loadSeeMoreJavascript = true;
		}

		$parameterSeeMoreSize = $filterDataModel->currentParameterAttribute('see_more_size');
		$parameterShowBeforeSeeMore = ($parameterHiding == CP_PARAMETER_HIDE_USING_SEEMORE && $parameterSeeMoreSize) ?
			$parameterSeeMoreSize : $showBeforeSeeMore;


		$appliedFilters = $filterDataModel->currentParameterAppliedFilters();
		$add_seemore_handle = false;

		echo '<div>';

		$parameterName = $filterDataModel->currentParameterName();

		// header
		// $groupCollapseState = $filterDataModel->currentParameterCollapseState();
		$groupCollapseState = $filterDataModel->currentParameterAttribute('collapse');
		$appliedAttr = ($appliedFilters) ? ' applied="1"' : '';
		echo '<h2 class="cp-group-header'. $collapseClass .'"'. $appliedAttr .
			' data-name="'. $parameterName .'"';
		if ($useCollapse)
			echo ' data-default="'. $groupCollapseState .'"';
		echo '>';
		if ($useCollapse) {
			echo '<span class="cp-group-header-state">';
			// echo ($conf->get('default_collapsed') && !$appliedFilters) ? '+' : '-';
			echo (!$appliedFilters && ($groupCollapseState == CP_COLLAPSE_GROUP_YES ||
					$conf->get('default_collapsed') && $groupCollapseState == CP_COLLAPSE_GROUP_GLOBAL)) ? '[+]' : '[-]';
			echo '</span>';
		}
		$parameterTitle = $filterDataModel->currentParameterTitle();
		if ($translate) $parameterTitle = JText::_($parameterTitle);
		echo '<span class="cp-group-title">'. $parameterTitle .'</span>';
		echo '</h2>';

		echo '<div>';

		/* These dedicated class names will be used for filters quickrefine feature,
			so they must be in place */
		// $quickrefineParameter = ($useQuickrefine && $filterDataModel->currentParameterShowQuickrefine());
		$quickrefineParameter = ($useQuickrefine && $filterDataModel->currentParameterAttribute('show_quickrefine'));
		if ($quickrefineParameter) {
			$qrFilterClass = ' cp-qr-filter';
			$qrFilterParentClass = ' class="cp-qr-filter-parent"';
			$this->printQuickrefineFieldForGroup($parameterName, $appliedFilters);
		} else {
			$qrFilterClass = '';
			$qrFilterParentClass = '';
		}

		$parameterUseScroll = ($parameterHiding == CP_PARAMETER_HIDE_USING_SCROLL
			|| $useScroll && $parameterHiding == CP_PARAMETER_HIDING_GLOBAL);

		echo '<div id="cp'. $moduleID .'_group_'. $parameterName .
			'"class="cp-filter-group" data-name="'. $parameterName .'">';
		if ($parameterUseScroll) {
			$height = ($parameterHiding == CP_PARAMETER_HIDE_USING_SCROLL
				&& ($v = $filterDataModel->currentParameterAttribute('scroll_height'))) ? $v : $scrollHeight;
			echo '<div class="cp-scroll-box" style="max-height:'. $height .'px">';
		}
		echo '<div class="cp-padding-cont"><ul class="cp-list">';

		$units = $filterDataModel->currentParameterUnits();

		// list filters
		if ($mode == CP_SINGLE_SELECT_MODE) {
			if ($appliedFilters) {
				echo '<li><a href="'. $parameter['xurl'] .'" class="cp-clearlink">&larr; '.
					$conf->get('backlink') .'</a></li>';
				echo '<li><span class="cp-singfil-selected">'. str_replace('|', ', ', $appliedFilters) .'</span></li>';
			} else {
				foreach ($parameter['filters'] as $k => $filter) {
					//if ($use_seemore && $k == $show_before) {
					// regular See More.. (without Ajax)
					// if ($showNFilters && $k == $show_before) {
					// 	echo '</ul>';
					// 	if ($seemore_anchor == CP_ANCHOR_TOP) {
					// 		$this->printSeeMore($parameterName, 'filter');
					// 	} else {
					// 		$add_seemore_handle = true;
					// 	}
					// 	echo '<ul class="cp-list hid">';

					// 	//$this->loadSeeMoreJavascript = true;
					// }

					if (!$useSeeMoreAjax && ($parameterHiding == CP_PARAMETER_HIDE_USING_SEEMORE
					|| $useSeeMore && $parameterHiding == CP_PARAMETER_HIDING_GLOBAL)
					&& $k == $parameterShowBeforeSeeMore) {
						echo '</ul>';
						if ($seeMoreAnchor == CP_ANCHOR_TOP) {
							$this->printSeeMore($parameterName, 'filter');
						} else {
							$add_seemore_handle = true;
						}
						echo '<ul class="cp-list hid">';
					}


					if ($filter['count']) {
						$filterName = ($translate) ? JText::_($filter['name']) : $filter['name'];
						if ($units)
							$filterName .= $units;
						$dataFilter = '';
						if ($quickrefineParameter) {
							$dataFilter = ' data-filter="'. htmlentities($filterName, ENT_QUOTES, "UTF-8") .'"';
						}
						echo '<li'. $qrFilterParentClass .'><a href="'. $filter['url'] .'" class="cp-filter-link">'.
							'<span class="cp-filter-filter'. $qrFilterClass .'"'. $dataFilter .'>'.
							$filterName .'</span> ';
						if ($showCount) echo '<span class="cp-filter-count">('. $filter['count'] .')</span>';
						echo '</a></li>';
					}
				}
			}
		} else {
			if ($show_clearlink && $parameter['xurl']) {
				echo '<li><a href="'. $parameter['xurl'] .'" class="cp-clearlink">'. $conf->get('clear') .'</a></li>';
			}
			foreach ($parameter['filters'] as $k => $filter) {
				//if ($use_seemore && $k == $show_before) {
				// regular See More.. (without Ajax)
				// if ($showNFilters && $k == $show_before) {
				// 	echo '</ul>';
				// 	if ($seemore_anchor == CP_ANCHOR_TOP) {
				// 		$this->printSeeMore($parameterName, 'filter');
				// 	} else {
				// 		$add_seemore_handle = true;
				// 	}
				// 	echo '<ul class="cp-list hid">';

				// 	//$this->loadSeeMoreJavascript = true;
				// }

				if (!$useSeeMoreAjax && ($parameterHiding == CP_PARAMETER_HIDE_USING_SEEMORE
					|| $useSeeMore && $parameterHiding == CP_PARAMETER_HIDING_GLOBAL)
					&& $k == $parameterShowBeforeSeeMore) {
					echo '</ul>';
					if ($seeMoreAnchor == CP_ANCHOR_TOP) {
						$this->printSeeMore($parameterName, 'filter');
					} else {
						$add_seemore_handle = true;
					}
					echo '<ul class="cp-list hid">';
				}


				$filterName = ($translate) ? JText::_($filter['name']) : $filter['name'];
				if ($units)
					$filterName .= $units;
				$dataFilter = '';
				if ($quickrefineParameter) {
					$dataFilter = ' data-filter="'. htmlentities($filterName, ENT_QUOTES, "UTF-8") .'"';
				}
				if ($filter['count']) {
					if ($filter['applied']) {
						echo '<li'. $qrFilterParentClass .'><a href="'. $filter['url'] .'" class="cp-filter-link">'.
						'<span class="cp-filter-checkbox selected"> </span> '.
						'<span class="cp-filter-filter selected'. $qrFilterClass .'"'.
							$dataFilter .'>'. $filterName .'</span></a></li>';
					} else {
						echo '<li'. $qrFilterParentClass .'><a href="'. $filter['url'] .'" class="cp-filter-link">'.
						'<span class="cp-filter-checkbox"> </span> '.
						'<span class="cp-filter-filter'. $qrFilterClass .'"'.
							$dataFilter .'>'. $filterName .'</span> ';
						if ($showCount)
							echo '<span class="cp-filter-count">('. $filter['count'] .')</span>';
						echo '</a></li>';
					}
				} else if ($filter['applied']) {
					echo '<li><span class="cp-filter-checkbox unavailable"> </span> '.
					'<span class="cp-filter-filter unavailable">'. $filterName .'</span></li>';
				}
			}
		}

		echo '</ul>';

		$singleModeWithFiltersApplied = ($mode == CP_SINGLE_SELECT_MODE && $appliedFilters);

		// regular See More.. process
		if ($add_seemore_handle)
			$this->printSeeMore($parameterName, 'filter');
		// Ajax See More.. process
		// if ($useSeeMoreAjax && !$singleModeWithFiltersApplied) {
		// 	if ($seemore_anchor == CP_ANCHOR_TOP) {
		// 		$this->printSeeMore($parameterName, 'filter');
		// 		echo '<ul class="cp-list hid"></ul>';
		// 	} else {
		// 		echo '<ul class="cp-list hid"></ul>';
		// 		$this->printSeeMore($parameterName, 'filter');
		// 	}
		// }

		if ($useSeeMoreAjax && ($parameterHiding == CP_PARAMETER_HIDE_USING_SEEMORE ||
			$useSeeMore && $parameterHiding == CP_PARAMETER_HIDING_GLOBAL)) {
			if ($seeMoreAnchor == CP_ANCHOR_TOP) {
				$this->printSeeMore($parameterName, 'filter');
				echo '<ul class="cp-list hid"></ul>';
			} else {
				echo '<ul class="cp-list hid"></ul>';
				$this->printSeeMore($parameterName, 'filter');
			}
		}

		echo '</div>';

		if ($parameterUseScroll)
			echo '</div><div class="cp-scroll-box-bottom-line"></div>';

		echo '</div></div></div>';
	}
}


// SHOW IN-STOCK FILTER
if ($conf->get('show_instock_filter')) {
	echo '<div>';
	//$groupCollapseState = $filterDataModel->currentParameterAttribute('collapse');
	$appliedAttr = ($appliedFilters) ? ' applied="1"' : '';
	echo '<h2 class="cp-group-header'. $collapseClass .'"'. $appliedAttr .
		' data-name="instock_filter"';
	//echo ' data-default="0"';
	echo '>';
	if ($useCollapse) {
		echo '<span class="cp-group-header-state">';
		echo (!$appliedFilters) ? '[+]' : '[-]';
		echo '</span>';
	}
	$groupLabel = $conf->get('instock_filter_group_label');
	if ($translate)
		$groupLabel = JText::_($groupLabel);
	echo '<span class="cp-group-title">'. $groupLabel .'</span>';
	echo '</h2>';
	echo '<div>';

	$stock_filter_applied = JRequest::getVar('instock', 0);
	$url = $filterDataModel->getURLExcluding(CP_URL_INSTOCK_FILTER);
	if (!$stock_filter_applied)
		$url .= '&instock=1';
	echo '<div id="cp'. $moduleID .'_group_instock'.
		'"class="cp-filter-group" data-name="instock_filter">';
	echo '<div class="cp-padding-cont"><ul class="cp-list">';
	if ($stock_filter_applied) {
		echo '<li><a href="'. $url .'" class="cp-filter-link">'.
			'<span class="cp-filter-checkbox selected"> </span> '.
			'<span class="cp-filter-filter selected">'.
			$conf->get('instock_filter_name') .'</span></a></li>';
	} else {
		echo '<li><a href="'. $url .'" class="cp-filter-link">'.
			'<span class="cp-filter-checkbox"> </span> '.
			'<span class="cp-filter-filter">'. $conf->get('instock_filter_name') .'</span> ';
		if ($showCount)
			echo '<span class="cp-filter-count">('.
				$filterDataModel->instockProductsCount() .')</span>';
		echo '</a></li>';
	}
	echo '</ul>';
	echo '</div></div></div></div>';
}



// --------------------------------------------------------------------
// Show available MANUFACTURERS
// --------------------------------------------------------------------

$manufacturersCollection = $manufacturers->getCollection();
if ($manufacturersCollection) {
	// echo '<pre>';
	// print_r($manufacturersCollection);
	// echo '</pre>';

	if ($conf->get('mf_title'))
		echo '<h2 class="cp-group-parent">'. $conf->get('mf_title') .'</h2>';

	echo '<div>';

	foreach ($manufacturersCollection as $i => $mf_category) {
		$manufacturers->setManufacturerCategory($i);

		// skip parameters that end up with 1 filter
		if ($hideParamsWith1Filter && count($mf_category['mfs']) < 2)
			continue;

		$appliedManufacturers = $manufacturers->currentMCAppliedMFsNames();
		$add_seemore_handle = false;

		$manufacturerCategorySlug = $manufacturers->currentManufacturerCategorySlug();
		$manufacturerCategoryName = $manufacturers->currentManufacturerCategoryName();

		// header
		$appliedAttr = ($appliedManufacturers) ? ' applied="1"' : '';
		echo '<h2 class="cp-group-header-manufacturer'. $collapseClass .'"'. $appliedAttr .
			' data-name="'. $manufacturerCategorySlug .'">';
		if ($useCollapse) {
			echo '<span class="cp-group-header-state">';
			echo ($conf->get('default_collapsed') && !$appliedManufacturers) ? '[+]' : '[-]';
			echo '</span>';
		}
		// if ($translate) $manufacturerCategoryName = JText::_($manufacturerCategoryName);
		echo '<span class="cp-group-title">'. $mf_category['mfc_name'] .'</span>';
		echo '</h2>';

		echo '<div>';

		/* These dedicated class names will be used for filters quickrefine feature,
			so they must be in place */
		if ($quickrefineManufacturers) {
			$qrFilterClass = ' cp-qr-filter';
			$qrFilterParentClass = ' class="cp-qr-filter-parent"';
			$this->printQuickrefineFieldForGroup($manufacturerCategorySlug, implode('|', $appliedManufacturers));
		} else {
			$qrFilterClass = '';
			$qrFilterParentClass = '';
		}

		// echo '<div class="cp-filter-group"><ul class="cp-list">';
		echo '<div id="cp'. $moduleID .'_group_'. $manufacturerCategorySlug .
			'" class="cp-filter-group" data-name="'. $manufacturerCategorySlug .'">';
		if ($useScroll)
			echo '<div class="cp-scroll-box" style="max-height:'. $scrollHeight .'px">';
		echo '<div class="cp-padding-cont"><ul class="cp-list">';

		// list manufacturers as filters
		if ($mode == CP_SINGLE_SELECT_MODE) {
			if ($appliedManufacturers) {
				echo '<li><a href="'. $mf_category['xurl'] .'" class="cp-clearlink">&larr; '.
					$conf->get('backlink') .'</a></li>';
				echo '<li><span class="cp-singfil-selected">'. implode(', ', $appliedManufacturers) .'</span></li>';
			} else {
				foreach ($mf_category['mfs'] as $k => $mf) {
					//if ($use_seemore && $k == $show_before) {
					// regular See More.. (without Ajax)
					// if ($showNFilters && $k == $show_before) {
					// 	echo '</ul>';
					// 	if ($seemore_anchor == CP_ANCHOR_TOP)
					// 		$this->printSeeMore($manufacturerCategorySlug, 'manufacturer');
					// 	else
					// 		$add_seemore_handle = true;

					// 	echo '<ul class="cp-list hid">';
					// 	//$this->loadSeeMoreJavascript = true;
					// }

					if ($useSeeMore && !$useSeeMoreAjax && $k == $showBeforeSeeMore) {
						echo '</ul>';
						if ($seeMoreAnchor == CP_ANCHOR_TOP) {
							$this->printSeeMore($manufacturerCategorySlug, 'manufacturer');
						} else {
							$add_seemore_handle = true;
						}
						echo '<ul class="cp-list hid">';
					}


					if ($mf['count']) {
						$dataFilter = '';
						if ($quickrefineManufacturers) {
							$dataFilter = ' data-filter="'. htmlentities($mf['name'], ENT_QUOTES, "UTF-8") .'"';
						}
						echo '<li'. $qrFilterParentClass .'><a href="'. $mf['url'] .'" class="cp-filter-link">'.
							'<span class="cp-filter-filter'. $qrFilterClass .'"'. $dataFilter .'>'. $mf['name'] .'</span> ';
						if ($showCount)
							echo '<span class="cp-filter-count">('. $mf['count'] .')</span>';
						echo '</a></li>';
					}
				}
			}
		} else {
			if ($show_clearlink && $mf_category['xurl']) {
				echo '<li><a href="'. $mf_category['xurl'] .'" class="cp-clearlink">'. $conf->get('clear') .'</a></li>';
			}
			foreach ($mf_category['mfs'] as $k => $mf) {
				// regular See More.. (without Ajax)
				// if ($showNFilters && $k == $show_before) {
				// 	echo '</ul>';
				// 	if ($seemore_anchor == CP_ANCHOR_TOP)
				// 		$this->printSeeMore($manufacturerCategorySlug, 'manufacturer');
				// 	else
				// 		$add_seemore_handle = true;

				// 	echo '<ul class="cp-list hid">';
				// 	//$this->loadSeeMoreJavascript = true;
				// }

				if ($useSeeMore && !$useSeeMoreAjax && $k == $showBeforeSeeMore) {
					echo '</ul>';
					if ($seeMoreAnchor == CP_ANCHOR_TOP) {
						$this->printSeeMore($manufacturerCategorySlug, 'manufacturer');
					} else {
						$add_seemore_handle = true;
					}
					echo '<ul class="cp-list hid">';
				}


				$dataFilter = '';
				if ($quickrefineManufacturers) {
					$dataFilter = ' data-filter="'. htmlentities($mf['name'], ENT_QUOTES, "UTF-8") .'"';
				}
				if ($mf['count']) {
					if ($mf['applied']) {
						echo '<li'. $qrFilterParentClass .'><a href="'. $mf['url'] .'" class="cp-filter-link">'.
						'<span class="cp-filter-checkbox selected"> </span> '.
						'<span class="cp-filter-filter selected'. $qrFilterClass .'"'. $dataFilter .'>'.
						$mf['name'] .'</span></a></li>';
					} else {
						echo '<li'. $qrFilterParentClass .'><a href="'. $mf['url'] .'" class="cp-filter-link">'.
						'<span class="cp-filter-checkbox"> </span> '.
						'<span class="cp-filter-filter'. $qrFilterClass .'"'. $dataFilter .'>'.
						$mf['name'] .'</span> ';
						if ($showCount)
							echo '<span class="cp-filter-count">('. $mf['count'] .')</span>';
						echo '</a></li>';
					}
				} else if ($mf['applied']) {
					echo '<li><span class="cp-filter-checkbox unavailable"> </span> '.
					'<span class="cp-filter-filter unavailable">'. $mf['name'] .'</span></li>';
				}
			}
		}

		echo '</ul>';

		$singleModeWithFiltersApplied = ($mode == CP_SINGLE_SELECT_MODE && $appliedManufacturers);

		// regular See More.. process
		if ($add_seemore_handle)
			$this->printSeeMore($manufacturerCategorySlug, 'manufacturer');
		// Ajax See More.. process
		// if ($useSeeMoreAjax && !$singleModeWithFiltersApplied) {
		// 	if ($seemore_anchor == CP_ANCHOR_TOP) {
		// 		$this->printSeeMore($manufacturerCategorySlug, 'manufacturer');
		// 		echo '<ul class="cp-list hid"></ul>';
		// 	} else {
		// 		echo '<ul class="cp-list hid"></ul>';
		// 		$this->printSeeMore($manufacturerCategorySlug, 'manufacturer');
		// 	}
		// }

		if ($useSeeMore && $useSeeMoreAjax) {
			if ($seeMoreAnchor == CP_ANCHOR_TOP) {
				$this->printSeeMore($manufacturerCategorySlug, 'manufacturer');
				echo '<ul class="cp-list hid"></ul>';
			} else {
				echo '<ul class="cp-list hid"></ul>';
				$this->printSeeMore($manufacturerCategorySlug, 'manufacturer');
			}
		}

		echo '</div>';

		if ($useScroll)
			echo '</div><div class="cp-scroll-box-bottom-line"></div>';

		echo '</div></div>';
	}

	echo '</div>';
}



// if Price form is set to display at Bottom
if ($printPriceForm)
	$this->printPriceForm();

if ($conf->get('show_total_products'))
	$this->printTotalProducts();
echo '</form>';
echo '</div>';

if (! $inquiringWithAjax) {
	// load according CSS file
	$doc = JFactory::getDocument();
	$doc->addStyleSheet($conf->get('module_url') .'static/css/simplelist.css');

	$this->loadSimpleListJavascript = true;
}

?>
