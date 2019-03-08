<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

//echo '<pre style="font-size:13px;">';
//print_r($filtersCollection);

$conf = CPFactory::getConfiguration();
$filterDataModel = CPFactory::getFilterDataModel();
$manufacturers = CPFactory::getManufacturersDataModel();

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

// 	$seeMoreAnchor = $conf->get('smanchor');
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


$show_clearlink = $conf->get('show_clearlink');
$moduleID = $conf->get('module_id');
$useQuickrefine = $conf->get('use_quickrefine');
$quickrefineManufacturers = ($useQuickrefine && $conf->get('quickrefine_manufacturers'));

echo '<div class="cp-filter-checkboxlist" id="cpFilters'. $moduleID .'">';

$this->printFiltersTitle();
$this->printFormStart();

$printPriceForm = false;
// $filterDataModel->showPriceFormForCurrentUser();
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

		$parameterMode = $filterDataModel->currentParameterAttribute('mode');
		if ($filterDataModel->currentParameterIsTrackbar()) {
			$this->printTrackbarParameter($parameter);
			continue;
		}

		// skip parameters that end up with 1 filter
		if ($hideParamsWith1Filter && count($parameter['filters']) < 2)
			continue;


		if ($parameterMode == CP_COLOR_PALETTE_PARAMETER) {
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


		$add_seemore_handle = false;
		$appliedFilters = $filterDataModel->currentParameterAppliedFilters();

		echo '<div>';

		$parameterName = $filterDataModel->currentParameterName();
		echo '<input type="hidden" name="'. $parameterName .'" value="'.
			htmlentities($appliedFilters, ENT_QUOTES, "UTF-8") .'" class="hidden-filter" />';

		// header
		// $groupCollapseState = $filterDataModel->currentParameterCollapseState();
		$groupCollapseState = $filterDataModel->currentParameterAttribute('collapse');
		$appliedAttr = ($appliedFilters) ? ' applied="1"' : '';
		echo '<h2 class="cp-chkb-group-header'. $collapseClass .'"'. $appliedAttr .'
			data-name="'. $parameterName .'"';
		if ($useCollapse)
			echo ' data-default="'. $groupCollapseState .'"';
		echo '>';
		if ($useCollapse) {
			echo '<span class="cp-group-header-state">';
			// echo (!$appliedFilters && $groupCollapseState != 2 && $conf->get('default_collapsed')) ? '+' : '-';
			echo (!$appliedFilters && ($groupCollapseState == CP_COLLAPSE_GROUP_YES ||
					$conf->get('default_collapsed') && $groupCollapseState == CP_COLLAPSE_GROUP_GLOBAL)) ? '[+]' : '[-]';
			echo '</span>';
		}
		$parameterTitle = $filterDataModel->currentParameterTitle();
		if ($translate)
			$parameterTitle = JText::_($parameterTitle);
		
		//tiago hack
		$lang = JFactory::getLanguage();
		if ( $parameterTitle == "Preço" and $lang->getTag() == "en-GB" ) {
			$parameterTitle = "Price";
		}
		if ( $parameterTitle == "Cor" and $lang->getTag() == "en-GB" ) {
			$parameterTitle = "Color";
		}
		if ( $parameterTitle == "Tamanho" and $lang->getTag() == "en-GB" ) {
			$parameterTitle = "Size";
		}
		if ( $parameterTitle == "Modalidade" and $lang->getTag() == "en-GB" ) {
			$parameterTitle = "Sport";
		}
		if ( $parameterTitle == "Género" and $lang->getTag() == "en-GB" ) {
			$parameterTitle = "Gender";
		}
		if ( $parameterTitle == "Linha" and $lang->getTag() == "en-GB" ) {
			$parameterTitle = "Line";
		}
		if ( $parameterTitle == "Categoria" and $lang->getTag() == "en-GB" ) {
			$parameterTitle = "Category";
		}
		//tiago hack
		
		echo '<span class="cp-chkb-group-title">'. JText::_($parameterTitle) .'</span>';
		echo '</h2>';

		echo '<div>';

		/* These dedicated class names will be used for filters quickrefine feature,
			so they must be in place */
		// $quickrefineParameter = ($useQuickrefine && $filterDataModel->currentParameterShowQuickrefine());
		$quickrefineParameter = ($useQuickrefine && $filterDataModel->currentParameterAttribute('show_quickrefine'));
		if ($quickrefineParameter) {
			$qrFilterClass = ' class="cp-qr-filter"';
			$qrFilterParentClass = ' class="cp-qr-filter-parent"';
			$this->printQuickrefineFieldForGroup($parameterName, $appliedFilters);
		} else {
			$qrFilterClass = '';
			$qrFilterParentClass = '';
		}

		$parameterUseScroll = ($parameterHiding == CP_PARAMETER_HIDE_USING_SCROLL
			|| $useScroll && $parameterHiding == CP_PARAMETER_HIDING_GLOBAL);

		echo '<div id="cp'. $moduleID .'_group_'. $parameterName .'" class="cp-chkb-filter-group">';
		if ($parameterUseScroll) {
			$height = ($parameterHiding == CP_PARAMETER_HIDE_USING_SCROLL
				&& ($v = $filterDataModel->currentParameterAttribute('scroll_height'))) ? $v : $scrollHeight;
			echo '<div class="cp-chkb-scroll-box" style="max-height:'. $height .'px">';
		}
		echo '<div class="cp-chkb-padding-cont"><ul class="cp-chkb-list">';

		$units = $filterDataModel->currentParameterUnits();


		// list filters

		if ($show_clearlink && $appliedFilters) {
			//tiago hack
			if ( strpos($parameter['xurl'], "index.php/" . substr($lang->getTag(), 0, 2)) === false ) {
				echo '<li><a href="'. str_replace("index.php", "index.php/" . substr($lang->getTag(), 0, 2), $parameter['xurl']) .'" class="cp-clearlink">'. JText::_( $conf->get('clear') ) .'</a></li>';
			}
			else {
				echo '<li><a href="'. $parameter['xurl'] .'" class="cp-clearlink">'. JText::_( $conf->get('clear') ) .'</a></li>';
			}
			//tiago hack
		}
		
		$db = JFactory::getDbo();
		
		foreach ($parameter['filters'] as $k => $filter) {
			// regular See More.. (without Ajax)
			// if ($showNFilters && $k == $show_before && $parameterUseSeeMore) {
			// 	echo '</ul>';
			// 	if ($seeMoreAnchor == CP_ANCHOR_TOP) {
			// 		$this->printSeeMore($parameterName, 'filter');
			// 	} else {
			// 		$add_seemore_handle = true;
			// 	}
			// 	echo '<ul class="cp-chkb-list hid">';
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
				echo '<ul class="cp-chkb-list hid">';
			}


			$filterName = ($translate) ? JText::_($filter['name']) : $filter['name'];
			if ($units) $filterName .= $units;

			$checked = ($filter['applied']) ? ' checked' : '';

			$dataFilter = '';
			if ($quickrefineParameter) {
				$dataFilter = ' data-filter="'. htmlentities($filterName, ENT_QUOTES, "UTF-8") .'"';
			}
			
			echo '<li'. $qrFilterParentClass .'><input id="cp'. $moduleID .'_inpt_'. $parameterName .'_'. $k .'" type="checkbox" value="'.
				htmlentities($filter['name'], ENT_QUOTES, "UTF-8") .'" class="cp-filter-input" data-groupname="'.
				$parameterName .'"'. $checked .' />';
			
			//tiago hack
			if ( $lang->getTag() == "en-GB" ) {
				$query = $db->getQuery(true);
				$query->select($db->quoteName(array('en_gb')));
				$query->from($db->quoteName('#__filtros'));
				$query->where($db->quoteName('pt_pt') . ' = '. $db->quote($filterName) . ' AND ' . $db->quoteName('nome') . ' = '. $db->quote($parameterName) );
				
				$db->setQuery($query);
				$db->execute();
				$num_rows = $db->getNumRows();
				
				if( $num_rows > 0 ) {
					$result = $db->loadRowList();
					echo '<label for="cp'. $moduleID .'_inpt_'. $parameterName .'_'. $k .'" class="cp-filter-label">' . '<span'. $qrFilterClass . $dataFilter .'>'. $result[0][0] .'</span>';
				}
				else {
					echo '<label for="cp'. $moduleID .'_inpt_'. $parameterName .'_'. $k .'" class="cp-filter-label">' . '<span'. $qrFilterClass . $dataFilter .'>'. $filterName .'</span>';
				}
			}
			else {
				echo '<label for="cp'. $moduleID .'_inpt_'. $parameterName .'_'. $k .'" class="cp-filter-label">' . '<span'. $qrFilterClass . $dataFilter .'>'. $filterName .'</span>';
			}
			//tiago hack
			
			if ($showCount)
				echo '<span class="cp-filter-count">('. $filter['count'] .')</span>';
			echo '</label>';
			echo '</li>';
		}


		echo '</ul>';

		// regular See More.. process
		if ($add_seemore_handle)
			$this->printSeeMore($parameterName, 'filter');
		// Ajax See More.. process
		// if ($useSeeMoreAjax && $parameterUseSeeMore) {
		// 	if ($seeMoreAnchor == CP_ANCHOR_TOP) {
		// 		$this->printSeeMore($parameterName, 'filter');
		// 		echo '<ul class="cp-chkb-list hid"></ul>';
		// 	} else {
		// 		echo '<ul class="cp-chkb-list hid"></ul>';
		// 		$this->printSeeMore($parameterName, 'filter');
		// 	}
		// }
		if ($useSeeMoreAjax && ($parameterHiding == CP_PARAMETER_HIDE_USING_SEEMORE ||
			$useSeeMore && $parameterHiding == CP_PARAMETER_HIDING_GLOBAL)) {
			if ($seeMoreAnchor == CP_ANCHOR_TOP) {
				$this->printSeeMore($parameterName, 'filter');
				echo '<ul class="cp-chkb-list hid"></ul>';
			} else {
				echo '<ul class="cp-chkb-list hid"></ul>';
				$this->printSeeMore($parameterName, 'filter');
			}
		}

		if ($parameterUseScroll)
			echo '</div>';

		echo '</div></div></div></div>';
	}
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


		$appliedManufacturersSlug = $manufacturers->currentMCAppliedMFsSlug();
		$appliedManufacturers = $manufacturers->currentMCAppliedMFsNames();
		$add_seemore_handle = false;

		$manufacturerCategorySlug = $manufacturers->currentManufacturerCategorySlug();
		$manufacturerCategoryName = $manufacturers->currentManufacturerCategoryName();


		echo '<input type="hidden" name="'. $manufacturerCategorySlug .'" value="'.
			htmlentities($appliedManufacturersSlug, ENT_QUOTES, "UTF-8") .'" class="hidden-filter" />';

		// header
		$appliedAttr = ($appliedManufacturers) ? ' applied="1"' : '';
		echo '<h2 class="cp-chkb-group-header'. $collapseClass .'"'. $appliedAttr .'
			data-name="'. $manufacturerCategorySlug .'">';
		if ($useCollapse) {
			echo '<span class="cp-group-header-state">';
			echo ($conf->get('default_collapsed') && !$appliedManufacturers) ? '[+]' : '[-]';
			echo '</span>';
		}
		echo '<span class="cp-chkb-group-title">'. $mf_category['mfc_name'] .'</span>';
		echo '</h2>';

		echo '<div>';

		/* These dedicated class names will be used for filters quickrefine feature,
			so they must be in place */
		if ($quickrefineManufacturers) {
			$qrFilterClass = ' class="cp-qr-filter"';
			$qrFilterParentClass = ' class="cp-qr-filter-parent"';
			$this->printQuickrefineFieldForGroup($manufacturerCategorySlug, implode('|', $appliedManufacturers));
		} else {
			$qrFilterClass = '';
			$qrFilterParentClass = '';
		}


		echo '<div id="cp'. $moduleID .'_group_'. $manufacturerCategorySlug .'" class="cp-chkb-filter-group">';
		if ($useScroll) {
			echo '<div class="cp-chkb-scroll-box" style="max-height:'. $scrollHeight .'px">';
		}

		echo '<div class="cp-chkb-padding-cont"><ul class="cp-chkb-list">';

		// list manufacturers as filters
		if ($show_clearlink && $appliedManufacturers) {
			echo '<li><a href="'. $mf_category['xurl'] .'" class="cp-clearlink">'.
				$conf->get('clear') .'</a></li>';
		}

		foreach ($mf_category['mfs'] as $k => $mf) {
			// regular See More.. (without Ajax)
			// if ($showNFilters && $k == $show_before) {
			// 	echo '</ul>';
			// 	if ($seeMoreAnchor == CP_ANCHOR_TOP) {
			// 		$this->printSeeMore($manufacturerCategorySlug, 'manufacturer');
			// 	} else {
			// 		$add_seemore_handle = true;
			// 	}
			// 	echo '<ul class="cp-chkb-list hid">';
			// }

			if ($useSeeMore && !$useSeeMoreAjax && $k == $showBeforeSeeMore) {
				echo '</ul>';
				if ($seeMoreAnchor == CP_ANCHOR_TOP) {
					$this->printSeeMore($manufacturerCategorySlug, 'manufacturer');
				} else {
					$add_seemore_handle = true;
				}
				echo '<ul class="cp-chkb-list hid">';
			}

			$checked = ($mf['applied']) ? ' checked' : '';

			$dataFilter = '';
			if ($quickrefineManufacturers) {
				$dataFilter = ' data-filter="'. htmlentities($mf['name'], ENT_QUOTES, "UTF-8") .'"';
			}

			echo '<li'. $qrFilterParentClass .'><input id="cp'. $moduleID .'_inpt_'. $manufacturerCategorySlug .'_'. $k .
				'" type="checkbox" value="'. htmlentities($mf['slug'], ENT_QUOTES, "UTF-8") .'"'. $dataFilter .
				' class="cp-filter-input" data-groupname="'. $manufacturerCategorySlug .'"'. $checked .' />';
			echo '<label for="cp'. $moduleID .'_inpt_'. $manufacturerCategorySlug .'_'. $k .
				'" class="cp-filter-label">'.
				'<span'. $qrFilterClass . $dataFilter .'>'. $mf['name'] .'</span>';
			if ($showCount)
				echo '<span class="cp-filter-count">('. $mf['count'] .')</span>';
			echo '</label>';
			echo '</li>';
		}

		echo '</ul>';

		// regular See More.. process
		if ($add_seemore_handle)
			$this->printSeeMore($manufacturerCategorySlug, 'manufacturer');
		// Ajax See More.. process
		if ($useSeeMore && $useSeeMoreAjax) {
			if ($seeMoreAnchor == CP_ANCHOR_TOP) {
				$this->printSeeMore($manufacturerCategorySlug, 'manufacturer');
				echo '<ul class="cp-chkb-list hid"></ul>';
			} else {
				echo '<ul class="cp-chkb-list hid"></ul>';
				$this->printSeeMore($manufacturerCategorySlug, 'manufacturer');
			}
		}

		if ($useScroll)
			echo '</div>';

		echo '</div></div></div>';
	}

	echo '</div>';
}




if (!($conf->get('enable_dynamic_update') && $conf->get('update_each_step'))) {
	echo '<div style="margin-top:15px; text-align:center; "><button type="submit" class="cp-apply-filters button button-caution">'. JText::_($conf->get('apply_filters')) .'</button></div>';
}

// if Price form is set to display at Bottom
if ($printPriceForm)
	$this->printPriceForm();

if ($conf->get('show_total_products'))
	$this->printTotalProducts();
echo '</form>';

echo '<div class="cp-checkboxlist-liveresult hid"><div class="cp-dr-arrow cp-dr-arrow-outer-left"></div>'.
	'<div class="cp-dr-arrow cp-dr-arrow-inner-left"></div>'.
	'<div class="cp-dr-cont-outer"><div class="cp-dr-cont-inner">'.
	'<span>'. $conf->get('results') .'</span> <span class="cp-dr-resvalue"></span> '.
	'<span class="cp-dr-go">'. $conf->get('show_results') .'</span></div></div></div>';


echo '</div>';

// echo '<div id="cpDynamicResults" class="hid"><div id="cp-dr-arrow-outer" class="cp-dr-arrow cp-left"></div>'.
// 	'<div id="cp-dr-arrow-inner" class="cp-dr-arrow cp-left"></div>'.
// 	'<div class="cp-dr-cont-outer"><div class="cp-dr-cont-inner">'.
// 	'<span>'. $conf->get('results') .'</span> <span class="cp-dr-resvalue"></span> '.
// 	'<span class="cp-dr-go" onclick="cpSubmitFilters()">'. $conf->get('show_results') .'</span></div></div></div>';

if (! $inquiringWithAjax) {
	// load according CSS file
	$doc = JFactory::getDocument();
	$doc->addStyleSheet($conf->get('module_url') .'static/css/checkboxlist.css');

	$this->loadCheckboxListJavascript = true;
}

?>
