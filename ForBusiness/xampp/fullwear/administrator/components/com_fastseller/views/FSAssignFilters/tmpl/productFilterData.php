<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

//echo '<pre style="font-size:13px">';
//print_r($assignedFilters);
//echo '</pre>';


$fixedWidthClass = (FSConf::get('param_button_width')) ? ' fixed-width' : '';

$urlptid = JRequest::getVar('ptid', null);

$currentRow = self::getCurrentRow();

$cont = '';

foreach ($assignedFilters as $i => $pt) {

	$ptid = $pt['ptid'];
	//$ptName = FSAssignFiltersModel::getProductTypeName($ptid);
	$recordId = $pt['id'];

	$ptUniqueId = $ptid .'_'. $recordId;


	$containerSelected = '';
	if ($urlptid) {
		$containerSelected = ($urlptid == $ptid) ? '' : ' hid';
	}


	$cont .= '<div class="pt-container'. $containerSelected .'" data-ptid="'. $ptid .'" data-recordid="'. $recordId .'" '.
		'data-row="'. $currentRow .'" id="ptCont_'. $ptUniqueId .'">';

	$ptParameters = FSAssignFiltersModel::getProductTypeParameters($ptid);

	if (!$ptParameters) {
		$cont .= '<div style="font:italic 12px Arial;margin:6px 0 7px">You need to create <b>Parameters</b> for this Product Type. ';
		$cont .= 'Go to <b>Create Filters</b> tab and click on Product Type Name to open it.';
		$cont .= '</div></div>';

		continue;
	}

	foreach ($ptParameters as $ptParameter) {

		$paramName = $ptParameter['parameter_name'];
		$uniqueId = $paramName .'_'. $ptid .'_'. $recordId;

		$parameterAssignedFilters = $pt[$paramName];
		if ($parameterAssignedFilters) {
			$btnValue = '';
			$filtersArr = explode(';', $parameterAssignedFilters);

			$newFiltersArr = array();
			foreach ($filtersArr as $f) if (trim($f)) $newFiltersArr[] = $f;
			$parameterAssignedFilters = implode(';', $newFiltersArr);

			$filtersCount = count($newFiltersArr);
			if ($filtersCount > 1) {
				$btnValue .= ' <sup class="filter-select-button-count">'. $filtersCount .'</sup>';
			}
			$btnValue .= '<span class="filter-select-button-value">'. self::squeeze($parameterAssignedFilters, 18) .'</span>';
		} else {
			$innerCont = ($ptParameter['parameter_label']) ? $ptParameter['parameter_label'] : $ptParameter['parameter_name'];
			$btnValue = '<span class="filter-select-button-value"><span class="fsb-value-unavail">['.
				$innerCont .']</span></span>';
		}


		$cont .= '<input type="hidden" value="'. htmlentities($parameterAssignedFilters, ENT_QUOTES, "UTF-8") .
			'" name="'. $uniqueId .'" '.
			'id="paramInput_'. $uniqueId .'" data-name="'. $paramName .'" />';

		$cont .= '<div class="param-button-cont"><div class="param-button-cont-inner">'.
			'<button type="button" class="filter-select-button'. $fixedWidthClass .'" id="paramButton_'.
			$uniqueId .'" data-uniqueId="'. $uniqueId .'" data-label="'.
			htmlentities($ptParameter['parameter_label'], ENT_QUOTES, "UTF-8") .
			'" data-name="'. $paramName .'">';
		$cont .= $btnValue;
		$cont .= '</button></div></div>';

	}


	$cont .= '<div class="clear"></div></div>';

}


?>
