<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$conf = CPFactory::getConfiguration();
$filterDataModel = CPFactory::getFilterDataModel();

if ($conf->get('transliterate_color_names'))
	require_once(CP_ROOT .'helpers/urlify.php');

// $parameterMode = $filterDataModel->currentParameterMode();
$moduleSelectMode = $conf->get('select_mode');
$moduleID = $conf->get('module_id');

$layout = $conf->get('layout');
$layoutNeedsFilterURL = ($layout == CP_LAYOUT_SIMPLE_LIST || $layout == CP_LAYOUT_DROPDOWN);

$translate = $conf->get('translate');
$show_clearlink = $conf->get('show_clearlink');

$collapseClass = '';
if ($useCollapse = $conf->get('use_collapse')) {
	$collapseClass = ' cp-collapse';
}

$appliedFilters = $filterDataModel->currentParameterAppliedFilters();

// print_r($parameter);

echo '<div>';

$parameterName = $filterDataModel->currentParameterName();
$parameterTitle = $filterDataModel->currentParameterTitle();

// header
$appliedAttr = ($appliedFilters) ? ' applied="1"' : '';
echo '<h2 class="cp-color-group-header'. $collapseClass .'"'. $appliedAttr .
	' data-name="'. $parameterName .'">';
if ($useCollapse) {
	echo '<span class="cp-group-header-state">';
	echo ($conf->get('default_collapsed') && !$appliedFilters) ? '[+]' : '[-]';
	echo '</span>';
}

if ($translate) $parameterTitle = JText::_($parameterTitle);
echo '<span class="cp-color-group-title">'. $parameterTitle .'</span>';
echo '</h2>';

echo '<div>';


/* These dedicated class names will be used for filters quickrefine feature,
	so they must be in place */
$useQuickrefine = false;
// $quickrefineParameter = ($useQuickrefine && $filterDataModel->currentParameterShowQuickrefine());
$quickrefineParameter = ($useQuickrefine && $filterDataModel->currentParamterAttribute('show_quickrefine'));
if ($quickrefineParameter) {
	$qrFilterClass = ' cp-qr-filter';
	$qrFilterParentClass = ' cp-qr-filter-parent';
	// $this->printQuickrefineFormForParameter($parameterName);
} else {
	$qrFilterClass = '';
	$qrFilterParentClass = '';
}


echo '<div id="cp'. $moduleID .'_group_'. $parameterName .'" class="cp-filter-group">';
echo '<div class="cp-color-palette">';

echo '<input type="hidden" name="'. $parameterName .'" value="'. $appliedFilters .'" class="hidden-filter" />';



if ($moduleSelectMode == CP_SINGLE_SELECT_MODE && $appliedFilters) {

	echo '<a href="'. $parameter['xurl'] .'" class="cp-clearlink">&larr; '. $conf->get('backlink') .'</a>';

	$appliedFiltersArray = explode('|', $appliedFilters);
	foreach ($appliedFiltersArray as $filter) {
		$filterName = ($translate) ? JText::_($filter) : $filter;
		if ($conf->get('transliterate_color_names'))
			$colorClass = ' cp-color-'. strtolower(str_replace(' ','', URLify::transliterate($filter)));
		else
			$colorClass = ' cp-color-'. strtolower(str_replace(' ','', $filter));
		echo '<span class="cp-color-palette-element'. $colorClass .
			'" title="'. $filterName .'" data-filtername="'. $filter .'" '.
			'data-groupname="'. $parameterName .'"></span>';
	}

} else {

	if ($show_clearlink && $appliedFilters) {
		echo '<div><a href="'. $parameter['xurl'] .'" class="cp-clearlink">'. $conf->get('clear') .'</a></div>';
	}


	foreach ($parameter['filters'] as $filter) {


		$filterName = ($translate) ? JText::_($filter['name']) : $filter['name'];

		$dataFilter = '';
		if ($quickrefineParameter) {
			$dataFilter = ' data-filter="'. htmlentities($filterName, ENT_QUOTES, "UTF-8") .'"';
		}

		$filterURL = ($layoutNeedsFilterURL && $filter['count']) ? ' href="'. $filter['url'] .'"' : '';
		if ($conf->get('transliterate_color_names'))
			$colorClass = ' cp-color-'. strtolower(str_replace(' ','', URLify::transliterate($filter['name'])));
		else
			$colorClass = ' cp-color-'. strtolower(str_replace(' ','', $filter['name']));
		$filterAppliedClass = ($filter['applied']) ? ' cp-color-applied' : '';
		$filterUnavailableClass = ($filter['count']) ? '' : ' cp-color-unavialable';



	//	if ($filter['count']) {

		echo '<a'. $filterURL .' class="cp-color-palette-element'.
			$colorClass . $filterAppliedClass . $filterUnavailableClass . $qrFilterParentClass .
			'" title="'. $filterName .'" data-filtername="'. $filter['name'] .'" '.
			'data-groupname="'. $parameterName .'"><span class="hid'. $qrFilterClass .
			'" data-filter="'. $filterName .'">'. $filterName .'</span></a>';

		//	if ($filter['applied']) {

				//echo '<li><a href="'. $filter['url'] .'" class="cp-filter-link">'.
				//'<span class="cp-filter-checkbox selected"> </span> '.
				//'<span class="cp-filter-filter selected">'. $filterName .'</span></a></li>';
		//	} else {
				//echo '<li><a href="'. $filter['url'] .'" class="cp-filter-link">'.
				//'<span class="cp-filter-checkbox"> </span> '.
				//'<span class="cp-filter-filter">'. $filterName .'</span> ';
				//if ($showCount) echo '<span class="cp-filter-count">('. $filter['count'] .')</span>';
				//echo '</a></li>';
		//	}
	//	} else if ($filter['applied']) {
			//echo '<li><span class="cp-filter-checkbox unavailable"> </span> '.
			//'<span class="cp-filter-filter unavailable">'. $filterName .'</span></li>';
	//	}

	}

}

echo '<div class="clear"></div>';

echo '</div></div></div></div>';

?>
