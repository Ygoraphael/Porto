<?php
defined( '_JEXEC' ) or die( 'Restricted access' );


// $parameterName = JRequest::getVar('param_name', 0);
// if (!$parameterName) die();

$dataValue = JRequest::getVar('data_value', 0);
$dataType = JRequest::getVar('data_type', 0);

if (!$dataValue || !$dataType)
	die();


// override value since we're already in Ajax
$conf->set('use_seemore_ajax', 0);
// Checkbox list layout always works in multiselect mode
if ($conf->get('layout') == CP_LAYOUT_CHECKBOX_LIST)
	$conf->set('select_mode', CP_MULTI_SELECT_MODE);

// we need to init filters here, because Manufactueres need this data too, 
// e.g.: for building proper URLs
$ptids_str = JRequest::getVar('ptids', null);
$productTypeIDs = explode('|', $ptids_str);

$filterDataModel = CPFactory::getFilterDataModel();
$filterDataModel->initFiltersDataLimited($productTypeIDs);

if ($dataType == 'filter') {
	// $ptids_str = JRequest::getVar('ptids', null);
	// $productTypeIDs = explode('|', $ptids_str);

	// $filterDataModel = CPFactory::getFilterDataModel();
	// $filterDataModel->initFiltersDataLimited($productTypeIDs);
	if (! $filterDataModel->thereAreFiltersToShow())
		return;

	$filterModel = CPFactory::getFilterModel();
	$filterWriter = CPFactory::getFilterWriter();

	$filtersCollection = $filterModel->getSeeMoreFilters();
	$filterWriter->printSeeMoreFilters($filtersCollection);
} else if ($dataType == 'manufacturer') {
	$manufacturers = CPFactory::getManufacturersDataModel();
	$filterWriter = CPFactory::getFilterWriter();

	$manufacturers->initializeData($dataValue);
	$manufacturersCollection = $manufacturers->getCollection();
	$filterWriter->printSeeMoreManufacturers($manufacturersCollection);
}