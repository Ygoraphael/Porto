<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

// echo '<pre style="font-size:13px;">';
// print_r($filtersCollection);

$conf = CPFactory::getConfiguration();
$filterDataModel = CPFactory::getFilterDataModel();
$manufacturers = CPFactory::getManufacturersDataModel();

$simpleDropDownMode = $conf->get('simpledropdown_mode');
$chooseLabel = $conf->get('simpledropdown_choose');

$inquiringWithAjax = $conf->get('ajax_request');
if ($inquiringWithAjax) {
	$this->loadJavascript = false;
}


$moduleId = $conf->get('module_id');
echo '<div class="cp-filter-simpledropdown" id="cpFilters'. $moduleId .'">';
echo '<div>';


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
$progressiveFilterLoading = ($conf->get('simpledropdown_mode') == CP_SIMPLEDROPDOWN_PROGRESSIVE_LOAD);


// --------------------------------------------------------------------
// Show available MANUFACTURERS
// --------------------------------------------------------------------

$manufacturersCollection = $manufacturers->getCollection();
if ($manufacturersCollection) {
	// echo '<pre>';
	// print_r($manufacturersCollection);
	// echo '</pre>';

	if ($conf->get('mf_title'))
		echo '<h2 class="cp-group-parent-header">'. $conf->get('mf_title') .'</h2>';

	echo '<div class="cp-group-parent">';

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

		echo '<div class="cp-filters-group-container">';

		// header
		$appliedAttr = '';
		$appliedClass = '';
		if ($appliedManufacturers) {
			$appliedAttr = ' applied="1"';
			$appliedClass = ' title-selected';
		}

		echo '<h2 class="cp-sdd-group-header"'. $appliedAttr .'>';
		echo '<span class="cp-sdd-group-title'. $appliedClass .'">'. $manufacturerCategoryName .'</span>';
		echo '</h2>';
		echo '<div class="cp-filter-group">';

		echo '<select name="'. $manufacturerCategorySlug .
			'" class="cp-filter-select" data-type="manufacturer">';

		echo '<option value="" class="cp-filter-option">'. $chooseLabel .' '. $manufacturerCategoryName .'</option>';

		foreach ($mf_category['mfs'] as $k => $mf) {
			if ($mf['count']) {
				$selected = ($mf['applied']) ? ' selected' : '';
				echo '<option value="'. htmlentities($mf['slug'], ENT_QUOTES, "UTF-8") .'"'.
					$selected .' class="cp-filter-option">'. $mf['name'];

				if ($showCount && !$selected) echo ' ('. $mf['count'] .')';
				echo '</option>';
			}
		}
		echo '</select>';
		echo '</div></div>';
	}

	echo '<div class="clear"></div>';
	echo '</div>';
}




// --------------------------------------------------------------------
// Show available FILTERS
// --------------------------------------------------------------------

foreach ($filtersCollection as $i => $productType) {
	$filterDataModel->setPTIndex($i);

	if ($conf->get('show_pt_title')) echo '<h2 class="cp-group-parent-header">'. $filterDataModel->currentPTTitle() .'</h2>';

	echo '<div class="cp-group-parent">';

	foreach ($productType as $j => $parameter) {
		$filterDataModel->setParameterIndex($j);

		$appliedFilters = $filterDataModel->currentParameterAppliedFilters();

		// skip parameters that end up with 1 filter
		if ($hideParamsWith1Filter && !$appliedFilters && count($parameter['filters']) < 2)
			continue;

		echo '<div class="cp-filters-group-container">';

		// header
		$appliedAttr = '';
		$appliedClass = '';
		if ($appliedFilters) {
			$appliedAttr = ' applied="1"';
			$appliedClass = ' title-selected';
		}

		echo '<h2 class="cp-sdd-group-header"'. $appliedAttr .'>';
		$parameterTitle = $filterDataModel->currentParameterTitle();
		if ($translate) $parameterTitle = JText::_($parameterTitle);
		echo '<span class="cp-sdd-group-title'. $appliedClass .'">'. $parameterTitle .'</span>';
		if ($progressiveFilterLoading) {
			echo '<span class="cp-group-loader"><img src="'. $conf->get('module_url') .
			'static/img/35.png" class="hid" /></span>';
		}
		echo '</h2>';
		echo '<div class="cp-filter-group">';


		$previousParameterAppliedFilters = $filterDataModel->previousParameterAppliedFilters();
		$disabled = ($simpleDropDownMode == CP_SIMPLEDROPDOWN_PROGRESSIVE_LOAD
			&& ($j != 0 && !$previousParameterAppliedFilters)) ? ' disabled' : '';


		$parameterName = $filterDataModel->currentParameterName();
		echo '<select name="'. $parameterName .'" class="cp-filter-select"'. $disabled .
			' data-type="filter">';

		$units = $filterDataModel->currentParameterUnits();

		// list filters
		// $previousParameterAppliedFilters = $filterDataModel->previousParameterAppliedFilters();

		// $firstOptionLabel = ($simpleDropDownMode == CP_SIMPLEDROPDOWN_PROGRESSIVE_LOAD
		// 	&& ($j != 0 && !$previousParameterAppliedFilters)) ? ' - ' : $chooseLabel .' '. $parameterTitle;

		// echo '<option value="" class="cp-filter-option">'. $firstOptionLabel .'</option>';
		echo '<option value="" class="cp-filter-option">'. $chooseLabel .' '. $parameterTitle .'</option>';

		foreach ($parameter['filters'] as $k => $filter) {
			if ($filter['count']) {
				$filterName = ($translate) ? JText::_($filter['name']) : $filter['name'];
				if ($units) $filterName .= $units;

				$selected = ($filter['applied']) ? ' selected' : '';

				echo '<option value="'. htmlentities($filter['name'], ENT_QUOTES, "UTF-8") .'"'.
					$selected .' class="cp-filter-option">'. $filterName;

				if ($showCount && !$selected) echo ' ('. $filter['count'] .')';

				echo '</option>';

			}
		}

		echo '</select>';

		echo '</div></div>';
	}

	echo '<div class="clear"></div>';

	echo '</div>';

}

//echo '<div class="clear"></div>';

echo '<div><button type="submit" class="cp-apply-filters">'. JText::_($conf->get('apply_filters')) .'</button></div>';

// if Price form is set to display at Bottom
if ($printPriceForm) $this->printPriceForm();

if ($conf->get('show_total_products')) $this->printTotalProducts();
echo '</form>';

echo '</div>';
echo '<div class="cp-sdd-blanket hid"></div>';
echo '</div>';

if (!$inquiringWithAjax) {
	// load according CSS file
	$doc = JFactory::getDocument();
	$doc->addStyleSheet($conf->get('module_url') .'static/css/simpledropdown.css');

	$this->loadSimpleDropdownJavascript = true;
}

?>
