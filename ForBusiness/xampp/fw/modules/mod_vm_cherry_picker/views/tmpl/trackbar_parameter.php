<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$conf = CPFactory::getConfiguration();
$filterDataModel = CPFactory::getFilterDataModel();
$filterModel = CPFactory::getFilterModel();

$moduleID = $conf->get('module_id');
$parameterMode = $filterDataModel->currentParameterAttribute('mode');
$trackbarIsOneKnob = (
	$parameterMode == CP_TRACKBAR_ONE_KNOB_EXACT ||
	$parameterMode == CP_TRACKBAR_ONE_KNOB_COMPARE);
$collapseClass = '';
if ($useCollapse = $conf->get('use_collapse')) {
	$collapseClass = ' cp-collapse';
}

$appliedFilters = $filterDataModel->currentParameterAppliedFilters();

$kExcludeAppliedRefinements = true;
$filters = $filterModel->getFiltersNameAndCountData($kExcludeAppliedRefinements);
if (count($filters) < 2)
	return;


$selectedValueTemplate = $conf->get('trackbar_selected_value_text');
$selectedFromTemplate = $conf->get('trackbar_selected_from_text');
$selectedToTemplate = $conf->get('trackbar_selected_to_text');
$translate = $conf->get('translate');

$parameterName = $filterDataModel->currentParameterName();
$parameterTitle = $filterDataModel->currentParameterTitle();
$parameterUnits = $filterDataModel->currentParameterUnits();
$uniqueId = $moduleID .'_'. $parameterName;
if ($translate)
	$parameterTitle = JText::_($parameterTitle);


//print_r($filters);
$availableFilters = $filterModel->getFiltersNameAndCountData();
if (count($availableFilters) == 0 && !$appliedFilters)
	return;
//echo "\n\nAVAILABLE:\n";
//print_r($availableFilters);

$values = array();
foreach ($filters as $filter)
	$values[] = $filter['name'];

natsort($values);
$values = array_values($values);
$anyFilter = $conf->get('trackbar_selected_any_text');
if ($trackbarIsOneKnob) {
	if ($anyFilter)
		array_splice($values, 0, 0, (array)$anyFilter);
}
$valuesCount = count($values);

$availableValues = array();
if ($availableFilters) {
	foreach ($availableFilters as $filter)
		$availableValues[] = $filter['name'];

	natsort($availableValues);
	$availableValues = array_values($availableValues);
}
$availableValuesCount = count($availableValues);


$selectedValue = null;
$selectedValues = array(null, null);
if ($appliedFilters) {
	if ($trackbarIsOneKnob) {
		if (in_array($appliedFilters, $values))
			$selectedValue = $appliedFilters;
	} else {
		$delimiter = $conf->get('trackbar_range_delimiter');
		$urlValues = explode($delimiter, $appliedFilters);
		if (in_array($urlValues[0], $values))
			$selectedValues[0] = $urlValues[0];
		if (in_array($urlValues[1], $values))
			$selectedValues[1] = $urlValues[1];
	}
}


echo '<div>';
$appliedAttr = ($appliedFilters) ? ' applied="1"' : '';
echo '<h2 class="cp-tbar-group-header'. $collapseClass .'"'. $appliedAttr .'
	data-name="'. $parameterName .'">';
if ($useCollapse) {
	echo '<span class="cp-tbar-group-header-state">';
	echo ($conf->get('default_collapsed') && !$appliedFilters) ? '[+]' : '[-]';
	echo '</span>';
}

?><span class="cp-tbar-group-title"><?php echo $parameterTitle ?></span>
</h2>
<div>
	<div class="cp-tbar-filter-group">
		<div class="cp-trackbar-selection-block">
			<div id="cp<?php echo $uniqueId ?>-selection-label" class="cp-tbar-selection-label"></div>
			<div style="float:right">
<?php
			if ($appliedFilters) {
				echo '<a href="'. $parameter['xurl']
					.'" class="cp-trackbar-selection-clear cp-clearlink">'. $conf->get('price_clear') .'</a>';
			}
?>
				<button class="cp-trackbar-button-apply"
						id="cp<?php echo $uniqueId ?>-trackbar-apply"
						style="visibility:hidden"><?php echo $conf->get('trackbar_apply') ?>
				</button>
				<div style="clear:both"></div>
			</div>
			<div style="clear:both"></div>
		</div>
		<div class="cp-trackbar-block">
			<div id="cp<?php echo $uniqueId ?>-trackbar"></div>
			<div id="cp<?php echo $uniqueId ?>-trackbar-mark-labels" class="cp-price-tickmarks"></div>
		</div>

		<input type="hidden" name="<?php echo $parameterName ?>" value="" class="hidden-filter" />
	</div>
</div>
<?php

$this->loadTrackbarJavascript = true;
//$this->loadParameterTrackbarJavascript = true;

?>
<script type="text/javascript">
(function() {
	var trackbarType = <?php echo $filterDataModel->currentParameterAttribute('mode') ?>;
	var parameterName = "<?php echo htmlentities($parameterTitle, ENT_QUOTES, "UTF-8") ?>";
	var units = "<?php echo ($parameterUnits) ? htmlentities($parameterUnits, ENT_QUOTES, "UTF-8") : '' ?>";
	var delimiter = "<?php echo $conf->get('trackbar_range_delimiter') ?>";
	var anyFilter = "<?php echo $anyFilter ?>";
	var selectedValueTemplate = "<?php echo $selectedValueTemplate ?>";
	var selectedFromTemplate = "<?php echo $selectedFromTemplate ?>";
	var selectedToTemplate = "<?php echo $selectedToTemplate ?>";
	var values = <?php echo "['". implode("', '", $values) ."']"; ?>;
<?php
	echo 'var availableValues = ';
	if ($parameterMode == CP_TRACKBAR_ONE_KNOB_EXACT)
		echo "['". implode("', '", $availableValues) ."'];";
	else
		echo '[];';
	echo "\n";
?>
	var numberOfTickMarks = <?php echo $valuesCount ?>;
	var filtersForm = document.getElementById('cpFilters<?php echo $moduleID ?>').getElementsByTagName('form')[0];
	var hiddenInput = filtersForm['<?php echo $parameterName ?>'];
	var applyButton = document.getElementById('cp<?php echo $uniqueId ?>-trackbar-apply');
	var applyButtonIsDisplayed = false;
	var selectionLabel = document.getElementById('cp<?php echo $uniqueId ?>-selection-label');

	var ONEKNOB_EXACT = 1,
		ONEKNOB_COMPR = 4,
		TWOKNOBS = 2;


	function displayApplyButton() {
		if (!applyButtonIsDisplayed) {
			applyButton.style.visibility = 'visible';
			applyButton.style.opacity = 1;
			applyButtonIsDisplayed = true;
		}
	}


	function textFromTemplateWithValue(template, value) {
		return template.replace(/(\{value\}|\{units\}|\{param_name\})/g, function ($0){
			var index = {
				'{value}': value,
				'{units}': units,
				'{param_name}': parameterName
			};
			return index[$0] != undefined ? index[$0] : $0;
		});
	}


	var oneKnobTrackbarValueDidChangeHandler = function(trackbar) {
		var selectedValue = trackbar.selectedValue(),
			availableMin = trackbar.availableValueMin(),
			availableMax = trackbar.availableValueMax(),
			text = '';

		if (selectedValueTemplate)
			text += textFromTemplateWithValue(selectedValueTemplate, selectedValue);

		selectionLabel.innerHTML = text;
		var value = (selectedValue == anyFilter) ? '' : selectedValue;
		hiddenInput.value = value;

		if (trackbar.isInitialized()) {
			displayApplyButton();
			var tbCompareValueNotInAvailable = (trackbarType == ONEKNOB_COMPR &&
				(!availableMin || !availableMax ||
				parseFloat(selectedValue) < parseFloat(availableMin)));
			var tbExactValueNotInAvailable = (trackbarType == ONEKNOB_EXACT
				&& availableValues.indexOf(selectedValue) == -1);

			if (selectedValue != anyFilter &&
				(tbCompareValueNotInAvailable || tbExactValueNotInAvailable))
			{
				applyButton.setAttribute('disabled', 'disabled');
			} else if (applyButton.getAttribute('disabled')) {
				applyButton.removeAttribute('disabled');
			}
		}
	}


	var twoKnobsTrackbarValueDidChangeHandler = function(trackbar) {
		var selectedMin = trackbar.selectedValueMin(),
			selectedMax = trackbar.selectedValueMax(),
			availableMin = trackbar.availableValueMin(),
			availableMax = trackbar.availableValueMax(),
			text = '';

		if (!selectedMin || !selectedMax)
			return;

		if (selectedFromTemplate)
			text += textFromTemplateWithValue(selectedFromTemplate, selectedMin);
		if (selectedToTemplate)
			text += ' ' + textFromTemplateWithValue(selectedToTemplate, selectedMax);

		selectionLabel.innerHTML = text;

		var valueMin = selectedMin == trackbar.limitMin() ? '' : selectedMin;
		var valueMax = selectedMax == trackbar.limitMax() ? '' : selectedMax;
		hiddenInput.value = (valueMin || valueMax) ?
			valueMin + delimiter + valueMax : '';

		if (trackbar.isInitialized()) {
			displayApplyButton();
			if (!availableMin || !availableMax ||
				parseFloat(selectedMin) > parseFloat(availableMax) ||
				parseFloat(selectedMax) < parseFloat(availableMin))
			{
				applyButton.setAttribute('disabled', 'disabled');
			} else if (applyButton.getAttribute('disabled')) {
				applyButton.removeAttribute('disabled');
			}
		}
	};


	var setUpTickMarkLabels = function(trackbar) {
		window.addEvent('domready', function() {
			var labelsContainer = document.getElementById('cp<?php echo $uniqueId ?>-trackbar-mark-labels');

			function addLabelWithTextAtPosition(text, index) {
				var label = document.createElement('div');
				label.className = 'cp-tick-mark-label';
				label.appendChild(document.createTextNode(text));
				label.style.left = trackbar.positionOfTickMarkAtIndex(index) + 'px';
				labelsContainer.appendChild(label);
				label.style.marginLeft = -1 * label.offsetWidth / 2 + 'px';
			}

			addLabelWithTextAtPosition('<?php echo $values[0] ?>', 0);
			addLabelWithTextAtPosition('<?php echo $values[$valuesCount - 1] ?>', <?php echo ($valuesCount - 1) ?>);
		});
	}


	var parameterTrackbar = new cpTrackbar({
		element: document.getElementById("cp<?php echo $uniqueId ?>-trackbar"),
		range: <?php
		echo ($parameterMode == CP_TRACKBAR_TWO_KNOBS) ? 'true' : 'false';
		echo ",\n";
		if ($parameterMode == CP_TRACKBAR_ONE_KNOB_EXACT)
			echo "fullRangeSelected: true,\n";
		?>
		valuesList: values,
		<?php
			if ($trackbarIsOneKnob) {
				echo 'selectedValue: ';
				echo ($selectedValue) ? "'". $selectedValue ."'" : 'null';
				//echo ",\n";
			} else {
				echo "selectedRange: [";
				echo ($selectedValues[0]) ? "'". $selectedValues[0] ."'" : 'null';
				echo ", ";
				echo ($selectedValues[1]) ? "'". $selectedValues[1] ."'" : 'null';
				echo ']';
			}
		?>,
		availableRange: <?php
			if (!$availableValues) {
				echo "[null, null]";
			} else if ($parameterMode == CP_TRACKBAR_ONE_KNOB_EXACT) {
				echo '[]';
			} else if ($availableValuesCount < 2) {
				echo "['". $availableValues[0] ."', '". $availableValues[0] ."']";
			} else {
				echo "['". $availableValues[0] . "','".
					$availableValues[$availableValuesCount - 1] ."']";
			}
		?>,
		tickMarks: {
			number: numberOfTickMarks
		},
		onValueChange: (trackbarType == TWOKNOBS ?
			twoKnobsTrackbarValueDidChangeHandler :
			oneKnobTrackbarValueDidChangeHandler),
		onReady: setUpTickMarkLabels

	});

	cpTrackbars.<?php echo $parameterName ?> = parameterTrackbar;

})();

</script>
</div>
