<?php
defined( '_JEXEC' ) or die( 'Restricted access' );


// $parameterName = JRequest::getVar('param_name', 0);
// if (!$parameterName) die();

$dataValue = JRequest::getVar('data_value', 0);
$dataType = JRequest::getVar('data_type', 0);

if (!$dataValue || !$dataType)
	die();

$conf->set('use_seemore_ajax', 0);


$ptids_str = JRequest::getVar('ptids', null);
$productTypeIDs = explode('|', $ptids_str);

$filterDataModel = CPFactory::getFilterDataModel();
$filterDataModel->initFiltersDataLimited($productTypeIDs);

if ($dataType == 'filter') {
	if (!$filterDataModel->thereAreFiltersToShow())
		return;

	$filterModel = CPFactory::getFilterModel();
	$filterWriter = CPFactory::getFilterWriter();

	$filtersCollection = $filterModel->getParameterFilters();
	$filterWriter->printParameterFilters($filtersCollection);

} else if ($dataType == 'manufacturer') {
	$manufacturers = CPFactory::getManufacturersDataModel();
	$filterWriter = CPFactory::getFilterWriter();

	$manufacturers->initializeData($dataValue);
	$manufacturersCollection = $manufacturers->getCollection();
	$filterWriter->printMCManufacturers($manufacturersCollection);
}
