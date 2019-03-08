<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require(FS_PATH .'models/FSCreateFiltersModel.php');

$ptid = JRequest::getVar('ptid', null);
$action = JRequest::getCmd('action', null);

switch ($action) {
	case 'SAVE_PT':
		FSCreateFiltersModel::saveProductTypeInfo();
		break;

	case 'DELETE_PT':
		FSCreateFiltersModel::deleteProductType();
		break;

	case 'REORDER_PT':
		FSCreateFiltersModel::reorderProductTypes();
		break;

	case 'GET_PARAMETER_FORM':
		FSCreateFiltersModel::showParameterForm();
		break;

	case 'DELETE_PARAMETER':
		FSCreateFiltersModel::deleteParameter();
		break;

	case 'SAVE_PARAMETERS':
		FSCreateFiltersModel::saveProductTypeParameters();
		break;


	default:
		if ($ptid) {
			FSCreateFiltersModel::showProductTypeParametersPage();
		} else {
			FSCreateFiltersModel::showProductTypesPage();
		}
		break;
}

/*

default:

				if($ptid){
					$do->getManageParametersPage();
				}else{
					$do->getProductTypes();
				}
			break;
			case 'SAVEPT': $do->saveProductType(); break;
			case 'REMPT': $do->removeProductType(); break;
			case 'PFORM': $do->getParameterForm(); break;
			case 'REMPAR': $do->removeParameter(); break;
			case 'SAVEPARAMS': $do->saveParameters(); break;
			case 'INCR': $do->increaseParameterValuesColumnSize(); break;
*/
?>
