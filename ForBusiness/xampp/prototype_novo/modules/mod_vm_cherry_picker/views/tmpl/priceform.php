<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$conf = CPFactory::getConfiguration();
$filterDataModel = CPFactory::getFilterDataModel();
$moduleID = $conf->get('module_id');

$appliedLowPrice = $filterDataModel->lowPrice();
$appliedHighPrice = $filterDataModel->highPrice();
$priceApplied = ($appliedLowPrice || $appliedHighPrice);

$collapseClass = '';
$layout = $conf->get('layout');
$layoutDoesNotNeedCollapse = ($layout == CP_LAYOUT_SIMPLE_DROPDOWN || $layout == CP_LAYOUT_DROPDOWN);
$useCollapse = ($conf->get('use_collapse') && !$layoutDoesNotNeedCollapse);
if ($useCollapse)
	$collapseClass = ' cp-collapse';

$showTrackbar = $conf->get('show_trackbar');
$showPriceLimits = $conf->get('show_price_limits');
$leftLimitAuto = $conf->get('set_left_limit');	// 0 -- manually, 1 -- automatically
$rightLimitAuto = $conf->get('set_right_limit');



if ($leftLimitAuto || $rightLimitAuto ) {
	$minMaxPrices = $filterDataModel->getMinMaxPrices();
//var_dump($minMaxPrices);
	$limitLeft = ($leftLimitAuto) ? $minMaxPrices['min'] : $conf->get('price_left_limit');
	$limitLeft = floor($limitLeft);
	$limitRight = ($rightLimitAuto) ? $minMaxPrices['max'] : $conf->get('price_right_limit');
	$limitRight = floor($limitRight + 0.5);
} else {
	$limitLeft = $conf->get('price_left_limit');
	$limitRight = $conf->get('price_right_limit');
}

if ($showPriceLimits) {
	$valueLeft = ($appliedLowPrice) ? $appliedLowPrice : $limitLeft;
	$valueRight = ($appliedHighPrice) ? $appliedHighPrice : $limitRight;
} else {
	$valueLeft = $appliedLowPrice;
	$valueRight = $appliedHighPrice;
}

// Hide trackbar in situations when there are none or just one product in
// category and no proper limits exist
if ($showTrackbar && ($limitLeft === null || $limitRight === null || $limitLeft == $limitRight))
	$showTrackbar = false;

?>
<div>
<?php
//hack tiago
if (false) {
?>
<h2 class="cp-price-group-header<?php echo $collapseClass ?>"<?php
	if ($priceApplied) echo ' applied="1"' ?>
	data-name="price">
<?php

if ($useCollapse) {
	echo '<span class="cp-price-group-header-state">';
	echo ($conf->get('default_collapsed') && !$priceApplied) ? '[+]' : '[-]';
	echo '</span>';
}

echo '<span class="cp-price-group-title">'. $conf->get('pricetitle') .'</span>';

?>
</h2>
<?php
}
?>
<div class="cp-price-cont">
<?php

if ($showTrackbar) {

?>
<div style="margin:10px 0">
	<div id="cp<?php echo $moduleID ?>-pricetrackbar"></div>
	<div id="cp<?php echo $moduleID ?>-pricetrackbar-marks" class="cp-price-tickmarks"></div>
</div>
<div style="margin-top:25px; height:1px;"></div>
<?php

}

?>
<div style="margin-top:10px">
	<span class="cp-price-rangelabel"><?php echo $conf->get('price_from') ?></span>
	<span class="cp-price-field"
		><span class="cp-price-field-currency"><?php
			echo $conf->get('price_currency_sign') ?></span
		><input type="number" name="low-price"
				value="<?php echo ($valueLeft) ? $valueLeft : '' ?>"
				class="cp-price-field-input" />
	</span
	><span class="cp-price-rangelabel cp-price-range-middle"><?php echo $conf->get('price_to') ?></span
	><span class="cp-price-field"
		><span class="cp-price-field-currency"><?php
			echo $conf->get('price_currency_sign') ?></span
		><input type="number" name="high-price"
				value="<?php echo ($valueRight) ? $valueRight : '' ?>"
				class="cp-price-field-input" />
	</span>
</div>
<div style="margin:15px 0 0">
	<button class="cp-price-button-apply"
			id="cp<?php echo $moduleID ?>-price-apply"
			style="visibility:hidden"><?php echo $conf->get('price_apply') ?>
	</button>
<?php

	if ($priceApplied && ($appliedLowPrice != $limitLeft || $appliedHighPrice != $limitRight)) {
		echo '<a href="'. JRoute::_($filterDataModel->getURLExcluding(CP_URL_PRICES))
			.'" class="cp-price-clear">'. $conf->get('price_clear') .'</a>';
	}

?>
	<div style="clear:both"></div>
</div>
</div>
</div>
<?php

if ($showTrackbar) {
	$kIncludeAppliedFilters = true;
	$availableMinMaxPrices = $filterDataModel->getMinMaxPrices($kIncludeAppliedFilters);
//var_dump($availableMinMaxPrices);
	$this->loadTrackbarJavascript = true;
}

?>
<script type="text/javascript">
(function() {
	var filtersForm = document.getElementById('cpFilters<?php echo $moduleID ?>').getElementsByTagName('form')[0];
	var priceInputMin = filtersForm['low-price'];
	var priceInputMax = filtersForm['high-price'];
	var priceApplyButton = document.getElementById('cp<?php echo $moduleID ?>-price-apply');
	var priceApplyButtonIsDisplayed = false;
	var priceTrackbar;


	function priceInputKeyDownEvent(input) {
		if (typeof adjustInputWidth === "function")
			adjustInputWidth(input);
		displayPriceApplyButton();
	}


	function priceInputKeyUpEvent(event) {
		if (typeof adjustInputWidth === "function")
			adjustInputWidth(event.target);
		displayPriceApplyButton();
	}

	function displayPriceApplyButton() {
		if (!priceApplyButtonIsDisplayed) {
			priceApplyButton.style.visibility = 'visible';
			priceApplyButton.style.opacity = 1;
			priceApplyButtonIsDisplayed = true;
		}
	}



	priceInputMin.addEventListener('keydown', function() {
		var input = this;
		setTimeout(function() {
			priceInputKeyDownEvent(input);
		}, 1);
	}, false);
	priceInputMax.addEventListener('keydown', function() {
		var input = this;
		setTimeout(function() {
			priceInputKeyDownEvent(input);
		}, 1);
	}, false);
	// Inputs on iOS devices behave differently: value changes only after
	// keyup. So the width must be adjusted after key was released.
	priceInputMin.addEventListener('keyup', priceInputKeyUpEvent, false);
	priceInputMax.addEventListener('keyup', priceInputKeyUpEvent, false);


	function focusPriceInput(event) {
		event.currentTarget.childNodes[1].focus();
		if (event.currentTarget == event.target)
			event.currentTarget.childNodes[1].select();
	}
	var priceFieldMin = document.getElementsByClassName('cp-price-field')[0];
	var priceFieldMax = document.getElementsByClassName('cp-price-field')[1];
	priceFieldMin.addEventListener('click', focusPriceInput, false);
	priceFieldMax.addEventListener('click', focusPriceInput, false);

<?php

if ($showTrackbar) {

?>
	function priceInputValueChanged(event) {
		var editedInput = event.target;
		var trackbar = priceTrackbar;
		if (editedInput.value == '' || isNaN(editedInput.value))
			return;

		if (editedInput == priceInputMin) {
			trackbar.setSelectedValueMin(parseFloat(editedInput.value));
		} else {
			trackbar.setSelectedValueMax(parseFloat(editedInput.value));
		}
	}

	priceInputMin.addEventListener('change', priceInputValueChanged, false);
	priceInputMax.addEventListener('change', priceInputValueChanged, false);


	var extremumValueToNull = <?php echo $conf->get('show_price_limits') ? 'false' : 'true' ?>;
	var firstLoadFlag = true;
	var priceTrackbarValueDidChangeHandler = function(trackbar) {
		var selectedMin = trackbar.selectedValueMin(),
			selectedMax = trackbar.selectedValueMax(),
			availableMin = trackbar.availableValueMin(),
			availableMax = trackbar.availableValueMax();

		var valueMin = (extremumValueToNull && selectedMin == trackbar.limitMin()) ?
					'' : selectedMin;
		var valueMax = (extremumValueToNull && selectedMax == trackbar.limitMax()) ?
					'' : selectedMax;

		if (priceInputMin.value != valueMin || firstLoadFlag) {
			priceInputMin.value = valueMin;
			adjustInputWidth(priceInputMin);
		}

		if (priceInputMax.value != valueMax || firstLoadFlag) {
			priceInputMax.value = valueMax;
			adjustInputWidth(priceInputMax);
		}
		firstLoadFlag = false;

		if (trackbar.isInitialized()) {
			displayPriceApplyButton();
			if (selectedMin > availableMax || selectedMax < availableMin)
				priceApplyButton.setAttribute('disabled', 'disabled');
			else if (priceApplyButton.getAttribute('disabled'))
				priceApplyButton.removeAttribute('disabled');
		}
	};



	var backstageElement;
	function adjustInputWidth(input) {
		var maxWidth = input.parentNode.offsetWidth - 8,
			width;

		var div;
		if (backstageElement) {
			div = backstageElement;
		} else {
			div = document.createElement('div');
			div.setAttribute('style', "position:absolute;left:-1000px;top:-1000px;");
			//var style_names = ['fontSize', 'fontStyle', 'fontWeight', 'fontFamily', 'lineHeight', 'textTransform', 'letterSpacing'];
			var style_names = ['font-size', 'font-style', 'font-weight', 'font-family', 'line-height', 'text-transfrom', 'letter-spacing'];
			for (var _i = 0, _len = style_names.length; _i < _len; _i++) {
				var style = style_names[_i];
				//div.style[style] = input.style[style];
				div.setStyle(style, input.getStyle(style));
			}
			document.body.appendChild(div);
			backstageElement = div;
		}

		div.innerHTML = input.value;
		width = div.offsetWidth;
		// Leave backstage element alive since width adjusting happens
		// rather frequently during trackbar scrolling.
		// document.body.removeChild(div);
		width += 4;
		if (width > maxWidth)
			width = maxWidth;

		input.style.width = width + 'px';
	}


	var setUpTickMarkLabels = function(trackbar) {
		window.addEvent('domready', function() {
			var labelsContainer = document.getElementById('cp<?php echo $moduleID ?>-pricetrackbar-marks');

			function addLabelWithTextAtPosition(text, index) {
				var label = document.createElement('div');
				label.className = 'cp-tick-mark-label';
				label.appendChild(document.createTextNode(text));
				label.style.left = trackbar.positionOfTickMarkAtIndex(index) + 'px';
				labelsContainer.appendChild(label);
				label.style.marginLeft = -1 * label.offsetWidth / 2 + 'px';
			}

			addLabelWithTextAtPosition(<?php echo $limitLeft ?>, 0);
			addLabelWithTextAtPosition(<?php echo round(($limitLeft + $limitRight) / 2) ?>, 1);
			addLabelWithTextAtPosition(<?php echo $limitRight ?>, 2);
		});
	}


	priceTrackbar = new cpTrackbar({
		element: document.getElementById("cp<?php echo $moduleID ?>-pricetrackbar"),
		range: true,
		limitRange: <?php echo '['. $limitLeft .', '. $limitRight .']'; ?>,
		selectedRange: <?php
			echo '[';
			echo ($valueLeft) ? $valueLeft : 'null';
			echo ', ';
			echo ($valueRight) ? $valueRight : 'null';
			echo ']';
		?>,
		availableRange: <?php
			if (!$availableMinMaxPrices['min'] || !$availableMinMaxPrices['max']) {
				echo '[]';
			} else if ($availableMinMaxPrices['min'] == $availableMinMaxPrices['max']) {
				$visibleRange = ($limitRight - $limitLeft) / 200;
				echo '['. ($availableMinMaxPrices['min'] - $visibleRange) .', '.
				($availableMinMaxPrices['max'] + $visibleRange) .']';
			} else {
				echo '['. $availableMinMaxPrices['min'] .', '.
				$availableMinMaxPrices['max'] .']';
			}
		?>,
		tickMarks: {
			number: 3
		},
		onValueChange: priceTrackbarValueDidChangeHandler,
		onReady: setUpTickMarkLabels
	});
	cpTrackbars.price = priceTrackbar;

<?php

	}

?>
})();
</script>
