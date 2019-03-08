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


$mode = $conf->get('select_mode');
$show_clearlink = $conf->get('show_clearlink');


$moduleID = $conf->get('module_id');
echo '<div class="cp-filter-dropdown" id="cpFilters'. $moduleID .'">';

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

$translate = $conf->get('translate');
$hideParamsWith1Filter = $conf->get('hide_params_with1filter');
$showCount = ($conf->get('filter_count') == PROD_COUNT_SHOW) ? true : false;
$loadFiltersWithAjax = $conf->get('dd_load_filters_with_ajax');
$filtersPerColumn = $conf->get('filters_per_column');

$hideFilters = $conf->get('hide_filters');
$useScroll = ($hideFilters == CP_HIDE_FILTERS_USING_SCROLL);
$scrollHeight = $conf->get('scroll_height');


// --------------------------------------------------------------------
// Show available MANUFACTURERS
// --------------------------------------------------------------------

$manufacturersCollection = $manufacturers->getCollection();
if ($manufacturersCollection) {
	// echo '<pre>';
	// print_r($manufacturersCollection);
	// echo '</pre>';

	echo '<div>';

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

		$leftButtonSelectedClass = '';
		$rightButtonSelectedClass = '';
		if ($appliedManufacturers) {
			$leftButtonSelectedClass = ' cp-lbtn-selected';
			$rightButtonSelectedClass = ' cp-rbtn-selected';
		}

		echo '<div class="cp-dd-filter-group-button" data-id="cp'. $moduleID .'_'.
			$manufacturerCategorySlug .'_'. $i .'">';
		echo '<button class="cp-lbtn'. $leftButtonSelectedClass .'" type="button">';
		echo $manufacturerCategoryName;
		if ($appliedManufacturers)
			echo ': '. implode(', ', $appliedManufacturers);
		echo '</button>';
		echo '<button class="cp-rbtn'. $rightButtonSelectedClass .'" type="button"><div class="down-arrow"></div></button>';
		echo '</div>';

		$heightStyle = ($useScroll) ? ' style="max-height:'. $scrollHeight .'px"' : '';
		$singleModeWithFiltersApplied = ($mode == CP_SINGLE_SELECT_MODE && $appliedManufacturers);

		// if loading filters with Ajax, just prepare loader
		if ($loadFiltersWithAjax && !$singleModeWithFiltersApplied) {
			echo '<div id="cp'. $moduleID .'_'. $manufacturerCategorySlug .'_'. $i .
				'" data-loaded="0" data-groupname="'. $manufacturerCategorySlug .'" data-type="manufacturer"'.
				' class="cp-dd-filter-group hid">';
			echo '<div class="cp-dd-scroll-box"'. $heightStyle .'>';
			echo '<div style="padding:10px 20px"><img src="'. $conf->get('module_url')
				.'static/img/ajax-loader.gif" /></div>';
			echo '</div></div>';

			continue;
		}

		// otherwise load filters normally
		$loadedAttr = ($singleModeWithFiltersApplied) ? ' data-loaded="1"' : '';
		echo '<div id="cp'. $moduleID .'_'. $manufacturerCategorySlug .'_'. $i .
			'" class="cp-dd-filter-group hid"'. $loadedAttr .'>';
		echo '<div class="cp-dd-scroll-box"'. $heightStyle .'>';

		// list filters
		if ($mode == CP_SINGLE_SELECT_MODE) {
			if ($appliedManufacturers) {
				echo '<div><a href="'. $mf_category['xurl'] .'" class="cp-clearlink">&larr; '.
					$conf->get('backlink') .'</a></div>';
				echo '<div><span class="cp-singfil-selected">'. implode(', ', $appliedManufacturers) .'</span></div>';
			} else {
				echo '<ul class="cp-dd-list">';
				foreach ($mf_category['mfs'] as $k => $mf) {
					if ($filtersPerColumn && ($k % $filtersPerColumn) == 0)
						echo '</ul><ul class="cp-dd-list">';

					if ($mf['count']) {
						echo '<li><a href="'. $mf['url'] .'" class="cp-dd-filter-link">'.
							'<span class="cp-filter-filter">'. $mf['name'] .'</span> ';
						if ($showCount) echo '<span class="cp-filter-count">('. $mf['count'] .')</span>';
						echo '</a></li>';
					}
				}
				echo '</ul>';
			}
		} else {
			if ($show_clearlink && $mf_category['xurl']) {
				echo '<div><a href="'. $mf_category['xurl'] .'" class="cp-clearlink">'. $conf->get('clear') .'</a></div>';
				echo '<div class="clear"></div>';
			}

			echo '<ul class="cp-dd-list">';

			foreach ($mf_category['mfs'] as $k => $mf) {
				if ($filtersPerColumn && ($k % $filtersPerColumn) == 0)
					echo '</ul><ul class="cp-dd-list">';

				if ($mf['count']) {
					if ($mf['applied']) {
						echo '<li><a href="'. $mf['url'] .'" class="cp-dd-filter-link">'.
						'<span class="cp-dd-filter-checkbox selected"> </span> '.
						'<span class="cp-filter-filter selected">'. $mf['name'] .'</span></a></li>';
					} else {
						echo '<li><a href="'. $mf['url'] .'" class="cp-dd-filter-link">'.
						'<span class="cp-dd-filter-checkbox"> </span> '.
						'<span class="cp-filter-filter">'. $mf['name'] .'</span> ';
						if ($showCount) echo '<span class="cp-filter-count">('. $mf['count'] .')</span>';
						echo '</a></li>';
					}
				} else if ($mf['applied']) {
					echo '<li><span class="cp-dd-filter-checkbox unavailable"> </span> '.
					'<span class="cp-filter-filter unavailable">'. $mf['name'] .'</span></li>';
				}
			}
			echo '</ul>';
		}
		echo '</div></div>';
	}

	echo '</div>';
	echo '<div class="clear"></div>';
	echo '</div>';
}


// --------------------------------------------------------------------
// Show available FILTERS
// --------------------------------------------------------------------

foreach ($filtersCollection as $i => $productType) {
	$filterDataModel->setPTIndex($i);

	echo '<div>';
	if ($conf->get('show_pt_title')) echo '<h2 class="cp-group-parent">'. $filterDataModel->currentPTTitle() .'</h2>';

	foreach ($productType as $j => $parameter) {
		$filterDataModel->setParameterIndex($j);

		// skip parameters that end up with 1 filter
		if ($hideParamsWith1Filter && !$loadFiltersWithAjax && count($parameter['filters']) < 2) continue;

		$appliedFilters = $filterDataModel->currentParameterAppliedFilters();

		$leftButtonSelectedClass = '';
		$rightButtonSelectedClass = '';
		if ($appliedFilters) {
			$leftButtonSelectedClass = ' cp-lbtn-selected';
			$rightButtonSelectedClass = ' cp-rbtn-selected';
		}


		$parameterName = $filterDataModel->currentParameterName();
		$parameterTitle = $filterDataModel->currentParameterTitle();
		$units = $filterDataModel->currentParameterUnits();
		if ($translate)
			$parameterTitle = JText::_($parameterTitle);

		echo '<div class="cp-dd-filter-group-button" data-id="cp'. $moduleID .'_'.
			$parameterName .'_'. $j .'">';
		echo '<button class="cp-lbtn'. $leftButtonSelectedClass .'" type="button">';
		echo $parameterTitle;
		if ($appliedFilters) {
			if ($translate) {
				$appliedFiltersArray = explode('|', $appliedFilters);
				$appliedFiltersTranslated = array();
				foreach ($appliedFiltersArray as $filter) {
					$appliedFiltersTranslated[] = JText::_($filter);
				}
				echo ': '. implode(', ', $appliedFiltersTranslated);
			} else {
				echo ': '. str_replace('|', ', ', $appliedFilters);
			}
			if ($units)
				echo $units;
		}
		echo '</button>';
		echo '<button class="cp-rbtn'. $rightButtonSelectedClass .'" type="button"><div class="down-arrow"></div></button>';
		echo '</div>';

		$singleModeWithFiltersApplied = ($mode == CP_SINGLE_SELECT_MODE && $appliedFilters);

		$parameterHiding = $filterDataModel->currentParameterAttribute('hiding_filters');
		$parameterUseScroll = ($parameterHiding == CP_PARAMETER_HIDE_USING_SCROLL
			|| $useScroll && $parameterHiding == CP_PARAMETER_HIDING_GLOBAL);
		if ($parameterUseScroll) {
			$height = ($parameterHiding == CP_PARAMETER_HIDE_USING_SCROLL
				&& ($v = $filterDataModel->currentParameterAttribute('scroll_height'))) ? $v : $scrollHeight;
			$heightStyle = ' style="max-height:'. $scrollHeight .'px"';
		} else {
			$heightStyle = '';
		}


		// if loading filters with Ajax, just prepare loader
		if ($loadFiltersWithAjax && !$singleModeWithFiltersApplied) {
			echo '<div id="cp'. $moduleID .'_'. $parameterName .'_'. $j .
				'" data-loaded="0" data-groupname="'. $parameterName .'" data-type="filter"'.
				' class="cp-dd-filter-group hid">';
			echo '<div class="cp-dd-scroll-box"'. $heightStyle .'>';
			echo '<div style="padding:10px 20px"><img src="'. $conf->get('module_url')
				.'static/img/ajax-loader.gif" /></div>';
			echo '</div></div>';

			continue;
		}



		$loadedAttr = ($singleModeWithFiltersApplied) ? ' data-loaded="1"' : '';

		// otherwise load filters normally
		echo '<div id="cp'. $moduleID .'_'. $parameterName .'_'. $j .
			'" class="cp-dd-filter-group hid"'. $loadedAttr .'>';
		echo '<div class="cp-dd-scroll-box"'. $heightStyle .'>';

		// list filters
		if ($mode == CP_SINGLE_SELECT_MODE) {
			if ($appliedFilters) {
				echo '<div><a href="'. $parameter['xurl'] .'" class="cp-clearlink">&larr; '.
					$conf->get('backlink') .'</a></div>';
				echo '<div><span class="cp-singfil-selected">';
				if ($translate) {
					echo implode(', ', $appliedFiltersTranslated);
				} else {
					echo str_replace('|', ', ',	$appliedFilters);
				}
				echo '</span></div>';
			} else {
				echo '<ul class="cp-dd-list">';
				foreach ($parameter['filters'] as $k => $filter) {

					if ($filtersPerColumn && ($k % $filtersPerColumn) == 0) echo '</ul><ul class="cp-dd-list">';

					if ($filter['count']) {
						$filterName = ($translate) ? JText::_($filter['name']) : $filter['name'];
						if ($units) $filterName .= $units;

						echo '<li><a href="'. $filter['url'] .'" class="cp-dd-filter-link">'.
							'<span class="cp-filter-filter">'. $filterName .'</span> ';
						if ($showCount) echo '<span class="cp-filter-count">('. $filter['count'] .')</span>';
						echo '</a></li>';
					}
				}

				echo '</ul>';

			}

		} else {
			if ($show_clearlink && $parameter['xurl']) {
				echo '<div><a href="'. $parameter['xurl'] .'" class="cp-clearlink">'. $conf->get('clear') .'</a></div>';
				echo '<div class="clear"></div>';
			}

			echo '<ul class="cp-dd-list">';

			foreach ($parameter['filters'] as $k => $filter) {

				if ($filtersPerColumn && ($k % $filtersPerColumn) == 0) echo '</ul><ul class="cp-dd-list">';

				$filterName = ($translate) ? JText::_($filter['name']) : $filter['name'];
				if ($units) $filterName .= $units;

				if ($filter['count']) {
					if ($filter['applied']) {
						echo '<li><a href="'. $filter['url'] .'" class="cp-dd-filter-link">'.
						'<span class="cp-dd-filter-checkbox selected"> </span> '.
						'<span class="cp-filter-filter selected">'. $filterName .'</span></a></li>';
					} else {
						echo '<li><a href="'. $filter['url'] .'" class="cp-dd-filter-link">'.
						'<span class="cp-dd-filter-checkbox"> </span> '.
						'<span class="cp-filter-filter">'. $filterName .'</span> ';
						if ($showCount) echo '<span class="cp-filter-count">('. $filter['count'] .')</span>';
						echo '</a></li>';
					}
				} else if ($filter['applied']) {
					echo '<li><span class="cp-dd-filter-checkbox unavailable"> </span> '.
					'<span class="cp-filter-filter unavailable">'. $filterName .'</span></li>';
				}
			}

			echo '</ul>';

		}

		echo '</div></div>';
	}

	echo '<div class="clear"></div>';

	echo '</div>';
}

// if Price form is set to display at Bottom
if ($printPriceForm) $this->printPriceForm();

if ($conf->get('show_total_products')) $this->printTotalProducts();
echo '</form>';
echo '</div>';

if (!$inquiringWithAjax) {
	// load according CSS file
	$doc = JFactory::getDocument();
	$doc->addStyleSheet($conf->get('module_url') .'static/css/dropdown.css');

	$this->loadDropDownJavascript = true;
}

?>
