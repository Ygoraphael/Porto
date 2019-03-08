<?php
defined( '_JEXEC' ) or die( 'Restricted access' );


// Force Simple Drop-down layout to work always in Multi select mode
$conf->set('select_mode', 1);

$ptids_str = JRequest::getVar('ptids', null);
$productTypeIDs = explode('|', $ptids_str);

$filterDataModel = CPFactory::getFilterDataModel();
$filterDataModel->initFiltersDataLimited($productTypeIDs);

if (!$filterDataModel->thereAreFiltersToShow()) return;


$filterModel = CPFactory::getFilterModel();
$filtersCollection = $filterModel->getParameterFilters();

$filterWriter = CPFactory::getFilterWriter();
$filterWriter->printParameterFilters($filtersCollection);