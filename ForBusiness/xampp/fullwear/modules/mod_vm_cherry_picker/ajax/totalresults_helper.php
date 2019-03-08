<?php
defined( '_JEXEC' ) or die( 'Restricted access' );


$conf->set('use_seemore_ajax', 0);

$ptids_str = JRequest::getVar('ptids', null);
$productTypeIDs = explode('|', $ptids_str);

$filterDataModel = CPFactory::getFilterDataModel();
$filterDataModel->initFiltersDataLimited($productTypeIDs);

if (!$filterDataModel->thereAreFiltersToShow()) return;

echo $filterDataModel->getTotalProductsCount();