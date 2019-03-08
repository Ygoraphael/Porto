<?php
defined( '_JEXEC' ) or die( 'Restricted access' );


// Checkbox List layout always works in Multi select mode
if ($conf->get('layout') == CP_LAYOUT_CHECKBOX_LIST) $conf->set('select_mode', CP_MULTI_SELECT_MODE);

// Force Simple Drop-down layout to work always in Multi select mode
if ($conf->get('layout') == CP_LAYOUT_SIMPLE_DROPDOWN) $conf->set('select_mode', CP_MULTI_SELECT_MODE);

$ptids_str = JRequest::getVar('ptids', null);
$productTypeIDs = explode('|', $ptids_str);

$filterDataModel = CPFactory::getFilterDataModel();
$filterDataModel->initFiltersData($productTypeIDs);

if (!$filterDataModel->thereAreFiltersToShow()) {
	if ($filterDataModel->checkThereAreFiltersApplied()) {
		$filterDataModel->showDialogToRemoveFilterSelection();
	}

	if ($conf->get('do_not_show_up_if_no_filters')) return;
	$totalProducts = $filterDataModel->getTotalProductsCount();
	if ($totalProducts == 0) return;
}

$filterModel = CPFactory::getFilterModel();
$filtersCollection = $filterModel->getFiltersCollection();

if (empty($filtersCollection) && $conf->get('do_not_show_up_if_no_filters')) return;


$filterWriter = CPFactory::getFilterWriter();
$filterWriter->printFilters($filtersCollection);


/*
$ptids_str = JRequest::getVar('ptids', null);
$productTypeIDs = explode('|', $ptids_str);

$filterDataModel = CPFactory::getFilterDataModel();
$filterDataModel->initFiltersData($productTypeIDs);
if (!$filterDataModel->thereAreFiltersToShow()) return;


// require('../models/filterModel.php');
// require('../views/filterWriter.php');

$filterModel = CPFactory::getFilterModel();
$filtersCollection = $filterModel->getFiltersCollection();

$filterWriter = CPFactory::getFilterWriter();
$filterWriter->printFilters($filtersCollection);

// CPFilterModel::showFilters();*/