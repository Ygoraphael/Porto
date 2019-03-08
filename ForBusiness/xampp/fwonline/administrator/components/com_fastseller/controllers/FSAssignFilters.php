<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


require(FS_PATH .'models/FSAssignFiltersModel.php');

$action = JRequest::getCmd('action', null);

switch ($action) {

	case 'DETAILS_AND_NAV':	
		FSAssignFiltersModel::showProductDetailsAndPageNavigation();
		break;

	case 'GET_CATEGORIES_TREE':
		FSAssignFiltersModel::showCategoriesTree();
		break;

	case 'GET_PT_LIST':
		FSAssignFiltersModel::showProductTypesList();
		break;

	case 'GET_PRODUCT_DESCRIPTION':
		FSAssignFiltersModel::showProductDescription();
		break;

	case 'ASSIGN_PT':
		FSAssignFiltersModel::processAssignProductTypeToProductEvent();
		break;

	case 'SAVE_PARAM':
		FSAssignFiltersModel::saveProductParameterFilters();
		break;

	case 'DELETE_PT_FROM_PRODUCT':
		FSAssignFiltersModel::deleteProductTypeFromProduct();
		break;

	case 'DELETE_PT_FROM_SELECTED_PRODUCTS':
		FSAssignFiltersModel::deleteProductTypesFromSelectedProducts();
		break;

	case 'GET_FILTERS_FOR_PARAM':
		FSAssignFiltersModel::loadAvailableFiltersForParameter();
		break;

	default:
		FSAssignFiltersModel::showFiltersAssignPage();
		break;

}

?>