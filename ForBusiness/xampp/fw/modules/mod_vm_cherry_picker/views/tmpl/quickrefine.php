<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

// <div class="cp-quickrefine-title">Quickly refine filters:</div>

$conf = CPFactory::getConfiguration();
// $filterDataModel = CPFactory::getFilterDataModel();
// $appliedFiltersStr = $filterDataModel->currentParameterAppliedFilters();
$moduleID = $conf->get('module_id');
$refineFiltersStr = $conf->get('quickrefine_refine_str');
// $parameterName = $filterDataModel->currentParameterName();

// $parameterMode = $filterDataModel->currentParameterMode();

?>
<div class="cp-quickrefine-container">
	<ul class="cp-quickrefine-field" id="<?php echo "cp". $moduleID ."_quickrefine_". $groupName ?>">
<?php

	$inputAttributes = '';

	if ($appliedFiltersStr) {
		$appliedFilters = explode('|', $appliedFiltersStr);
		foreach ($appliedFilters as $filter) {
			echo '<li class="cp-qr-field-layout-element">';
			echo '<span class="cp-qr-field-filter" title="Click to remove"><span class="cp-qr-field-filter-name">'. 
				$filter .'</span><span class="cp-qr-field-filter-x">x</span></span>';
			echo '</li>';
		}

		$inputAttributes = 'style="width:25px"';
	} else {
		$inputAttributes = 'placeholder="'. $refineFiltersStr .'" style="width:100%"';
	}

	// if ($parameterMode == CP_COLOR_PALETTE_PARAMETER)
	// 	$inputAttributes .= ' data-needshighlight="0"';
	// else
	// 	$inputAttributes .= ' data-needshighlight="1"';

?>
		<li class="cp-qr-field-layout-element">
			<input type="text" class="cp-quickrefine-input" 
				data-name="<?php echo $groupName ?>"
				autocomplete="off" data-placeholder="<?php echo $refineFiltersStr ?>" <?php echo $inputAttributes ?> />
		</li>
	</ul>
</div>
<?php

$this->loadQuickrefineJavascript = true;

?>