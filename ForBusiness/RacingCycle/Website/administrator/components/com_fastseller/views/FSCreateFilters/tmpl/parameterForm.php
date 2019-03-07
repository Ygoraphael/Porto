<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

// data not always passed here. In case we call for a new form, we check data.
$parameterDataExists = ($parameter) ? true : false;

if (!$tabIndex) $tabIndex = JRequest::getVar('tabno', 0);

$key = ($parameterDataExists) ? $parameter['parameter_name'] : 'new'. $tabIndex;

if ($parameterDataExists) {
	$parameterName = $parameter['parameter_name'];
	$parameterLabel = $parameter['parameter_label'];
	$parameterFilters = $parameter['parameter_values'];
	$parameterDescription = $parameter['parameter_description'];
	$parameterUnit = $parameter['parameter_unit'];
	// $parameterMode = $parameter['mode'];
	$parameterCPAttributes = new JRegistry;
	$parameterCPAttributes->loadString($parameter['cherry_picker_attribs']);
	// $parameterShowQuickrefine = $parameter['show_quickrefine'];
	// $parameterCollapse = $parameter['collapse'];
	$parameterMultiassigned = ($parameter['parameter_type'] == 'V') ? true : false;
	$defineFiltersManually = $parameter['define_filters_manually'];

} else {
	$parameterName = '';
	$parameterLabel = '';
	$parameterFilters = '';
	$parameterDescription = '';
	$parameterUnit = '';
	// $parameterMode = 0;
	$parameterCPAttributes = new JRegistry;
	// $parameterShowQuickrefine = 0;
	// $parameterCollapse = 0;
	$parameterMultiassigned = false;
	$defineFiltersManually = false;
}

?>
<button class="glass-btn ptp-delete-parameter-button" title="Delete Parameter"
	data-tab="<?php echo $tabIndex ?>" data-key="<?php echo $key ?>" style="font:11px Tahoma;float:right">
	<img src="<?php echo FS_URL ?>static/img/Delete16.png" width="10" /> &nbsp;Delete
</button>
<div class="clear"></div>

<input type="hidden" name="key[]" value="<?php echo $key ?>" />
<input type="hidden" name="parameter_name_active_<?php echo $key ?>" id="parameter_name_active_<?php echo $key ?>"
	value="<?php echo $parameterName ?>" />
<input type="hidden" name="list_order_<?php echo $key ?>" id="list_order_<?php echo $tabIndex ?>"
	value="<?php echo $tabIndex ?>" />

<table class="ptp-paramTbl">
	<tr>
		<td class="titleCell">Name</td>
		<td class="valueCell">
			<input type="text" name="parameter_name_<?php echo $key ?>" id="parameter_name_<?php echo $key ?>"
				value="<?php echo $parameterName ?>" class="ptp-parameter-name ptp-hint-listener"
				data-tab="<?php echo $tabIndex ?>" /></td>
		<td>
			<span id="parameter_name_<?php echo $key ?>_hint" class="simpleHint">
				Required and should be unique among all Parameters of all Product Types.
				This parameter name is being used in URL, so name it nicely (e.g.: brand).
			</span></td>
	</tr>

	<tr>
		<td class="titleCell">Label</td>
		<td class="valueCell">
			<input type="text" name="parameter_label_<?php echo $key ?>" id="parameter_label_<?php echo $tabIndex ?>"
				value="<?php echo $parameterLabel ?>" class="input ptp-parameter-label ptp-hint-listener"
				data-tab="<?php echo $tabIndex ?>" /></td>
		<td>
			<span id="parameter_label_<?php echo $tabIndex ?>_hint" class="simpleHint">
				Parameter label is displayed on site (e.g.: Brand).</span></td>
	</tr>

	<tr>
		<td class="titleCell">Description</td>
		<td class="valueCell">
			<textarea name="parameter_description_<?php echo $key ?>" rows="1" style="width:254px;max-width:400px"><?php
				echo $parameterDescription
			?></textarea></td>
		<td></td>
	</tr>

	<tr>
		<td class="titleCell">Unit</td>
		<td class="valueCell">
			<input type="text" name="parameter_unit_<?php echo $key ?>" id="parameter_unit_<?php echo $tabIndex ?>"
			value="<?php echo htmlspecialchars($parameterUnit) ?>" class="input ptp-hint-listener" /></td>
		<td><span id="parameter_unit_<?php echo $tabIndex ?>_hint" class="simpleHint">
			Could be someting like: Gb or Inches or "</span></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="2" style="font:bold 14px Arial;padding:35px 0 15px">
			Cherry Picker individual Parameter options</td>
	</tr>

	<tr>
		<td class="titleCell">
			<label for="show_in_cherry_picker_<?php echo $tabIndex ?>">Show in Cherry Picker</label>
		</td>
		<td class="valueCell">
			<input type="checkbox" name="show_in_cherry_picker_<?php echo $key ?>"
				id="show_in_cherry_picker_<?php echo $tabIndex ?>" value="1"<?php
				// if ($parameterShowQuickrefine)
				if ($parameterCPAttributes->get('show_in_cherry_picker') !== 0)
					echo ' checked' ?> />
		</td>
		<td></td>
	</tr>

	<tr>
		<td class="titleCell" style="vertical-align:top;padding-top:7px">Mode</td>
		<td class="valueCell" colspan="2" style="vertical-align:top;padding-top:5px;">
			<select name="mode_<?php echo $key ?>" id="mode_<?php echo $tabIndex ?>"
				class="tpt-parameter-mode" data-tab="<?php echo $tabIndex ?>">
				<option value="0"<?php
					if ($parameterCPAttributes->get('mode') == 0)
						echo ' selected="selected"' ?>>Default</option>
				<option value="1"<?php
					if ($parameterCPAttributes->get('mode') == 1)
						echo ' selected="selected"' ?>>Trackbar: 1 slider, Exact Match</option>
				<option value="4"<?php
					if ($parameterMultiassigned) {
						echo ' disabled';
					} else if ($parameterCPAttributes->get('mode') == 4) {
						 echo ' selected="selected"';
					}
				?>>Trackbar: 1 slider, Comparison</option>
				<option value="2"<?php
					if ($parameterMultiassigned) {
						echo ' disabled';
					} else if ($parameterCPAttributes->get('mode') == 2) {
						 echo ' selected="selected"';
					}
				?>>Trackbar: 2 sliders</option>
				<option value="3"<?php
					if ($parameterCPAttributes->get('mode') == 3)
						echo ' selected="selected"' ?>>Color</option>
			</select><?php
					if ($parameterMultiassigned) {
						echo '<div style="font:11px Arial;color:#587F9F;margin-top:5px">
							"Trackbar with 1 slider, Comparison" and
							"Trackbar with 2 sliders" are disabled because this Parameter has products
							with multiple filters assigned.</div>';
					}
?>
			</td>
	</tr>

	<tr>
		<td class="titleCell">
			<label for="show_quickrefine_<?php echo $tabIndex ?>">Show Quick-refine</label>
		</td>
		<td class="valueCell">
			<input type="checkbox" name="show_quickrefine_<?php echo $key ?>"
				id="show_quickrefine_<?php echo $tabIndex ?>" value="1"<?php
				// if ($parameterShowQuickrefine)
				if ($parameterCPAttributes->get('show_quickrefine'))
					echo ' checked' ?> />
		</td>
		<td></td>
	</tr>

	<tr>
		<td class="titleCell">Collapse state</td>
		<td class="valueCell">
			<input type="radio" name="collapse_<?php echo $key ?>"
				id="collapse_global_<?php echo $tabIndex ?>" value="0"<?php
					// if ($parameterCollapse == 0)
					if ($parameterCPAttributes->get('collapse') == 0)
						echo ' checked';
				?> />
			<label for="collapse_global_<?php echo $tabIndex ?>">As set in Cherry Picker (Global)</label>
			<br/>
			<input type="radio" name="collapse_<?php echo $key ?>"
				id="collapse_yes_<?php echo $tabIndex ?>" value="1"<?php
					// if ($parameterCollapse == 1)
					if ($parameterCPAttributes->get('collapse') == 1)
						echo ' checked';
				?> />
			<label for="collapse_yes_<?php echo $tabIndex ?>">Is Collapsed</label>
			<br/>
			<input type="radio" name="collapse_<?php echo $key ?>"
				id="collapse_no_<?php echo $tabIndex ?>" value="2"<?php
					// if ($parameterCollapse == 2)
					if ($parameterCPAttributes->get('collapse') == 2)
						echo ' checked';
				?> />
			<label for="collapse_no_<?php echo $tabIndex ?>">Is Expanded</label>
		</td>
		<td></td>
	</tr>

	<tr><td colspan="3" style="padding:6px"></td></tr>

	<tr>
		<td class="titleCell">Hiding filters</td>
		<td class="valueCell" colspan="2">
			<input type="radio" name="hiding_filters_<?php echo $key ?>"
				id="hiding_filters_global_<?php echo $tabIndex ?>" value="0"<?php
					// if ($parameterCollapse == 0)
					if ($parameterCPAttributes->get('hiding_filters') == 0)
						echo ' checked';
				?> />
			<label for="hiding_filters_global_<?php echo $tabIndex ?>">As set in Cherry Picker (Global)</label>
			<br/>
			<input type="radio" name="hiding_filters_<?php echo $key ?>"
				id="hiding_filters_no_<?php echo $tabIndex ?>" value="1"<?php
					// if ($parameterCollapse == 0)
					if ($parameterCPAttributes->get('hiding_filters') == 1)
						echo ' checked';
				?> />
			<label for="hiding_filters_no_<?php echo $tabIndex ?>">Do not hide</label>
			<br/>
			<input type="radio" name="hiding_filters_<?php echo $key ?>"
				id="hiding_filters_see_more_<?php echo $tabIndex ?>" value="2"<?php
					// if ($parameterCollapse == 1)
					if ($parameterCPAttributes->get('hiding_filters') == 2)
						echo ' checked';
				?> />
			<label for="hiding_filters_see_more_<?php echo $tabIndex ?>">Use See More..</label>
			<label for="see_more_size_<?php echo $tabIndex ?>"
				style="margin:0 5px 0 10px">Number of filters before:</label>
			<input type="text" name="see_more_size_<?php echo $key ?>"
				id="see_more_size_<?php echo $tabIndex ?>"
				class="input" style="width:50px;" value="<?php
					if ($v = $parameterCPAttributes->get('see_more_size'))
						echo $v;
				?>" />
			<br/>
			<input type="radio" name="hiding_filters_<?php echo $key ?>"
				id="hiding_filters_scroll_box_<?php echo $tabIndex ?>" value="3"<?php
					// if ($parameterCollapse == 2)
					if ($parameterCPAttributes->get('hiding_filters') == 3)
						echo ' checked';
				?> />
			<label for="hiding_filters_scroll_box_<?php echo $tabIndex ?>">Use Scroll</label>
			<label for="scroll_size_<?php echo $tabIndex ?>"
				style="margin:0 5px 0 10px">Scroll height in pixels:</label>
			<input type="text" name="scroll_height_<?php echo $key ?>"
				id="scroll_size_<?php echo $tabIndex ?>"
				class="input" style="width:50px;" value="<?php
					if ($v = $parameterCPAttributes->get('scroll_height'))
						echo $v;
				?>" />
		</td>
	</tr>

</table>
<div class="ptp-filtersinfo-title">Filters Information</div>
<div class="ptp-define-filters-manually-cont">
	<input type="checkbox"
		name="define_filters_manually_<?php echo $key ?>"
		id="define_filters_manually_<?php echo $tabIndex ?>"
		class="ptp-define-filters-manually"
		value="1"

		<?php echo ($defineFiltersManually) ? 'checked' : '' ?> />
	<label for="define_filters_manually_<?php echo $tabIndex ?>" >I want to pre-define filters manually</label>
</div>
<?php

$hiddenClass = ($defineFiltersManually) ? ' hid' : '';
echo '<div class="ptp-filters-cont-variant'. $hiddenClass .'">';
if ($parameterFilters) {
	echo '<div style="font:13px Arial;margin:20px 5px 0 20px">'.
		'Currently all new filters that you assign to products will be added to the list of '.
		'Available Filters automatically.<br/>'.
		'You have the following filters in use for this Parameter:</div>';
	echo '<div class="ptp-used-filters-outer">';

	$filters = explode(';', $parameterFilters);
	foreach ($filters as $i => $filter) {
		echo '<div class="ptp-used-filters-filter">'. $filter .'</div>';
	}
	echo '<div class="clear"></div></div>';
	echo '<div style="font:13px Arial;margin:5px 0 0 20px">Filters count: '. ($i + 1) .'</div>';

} else {
	echo '<div style="font:13px Arial;margin:20px 5px 0 20px">This parameter does not have any filters assigned to products.</div>';
}
echo '</div>';

$filtersCount = ($parameterFilters) ? count(explode(';', $parameterFilters)) : 0;
$hiddenClass = ($defineFiltersManually) ? '' : ' hid';
?>
<div class="ptp-filters-cont-variant<?php echo $hiddenClass ?>" style="font:13px Arial;margin:20px 5px 0 20px">
<div style="margin:5px 0 10px">Currently only the filters you define here will be added to the list of Available Filters.</div>
<textarea name="defined_filters_<?php echo $key ?>"
		id="defined_filters_<?php echo $key ?>"
		class="ptp-parameter-predefined-filters ptp-hint-listener"
		rows="3"
		data-tab="<?php echo $tabIndex ?>"><?php echo $parameterFilters ?>
</textarea>
<div id="numberOfFilters_<?php echo $tabIndex ?>" style="color:#777777;margin:0 0 5px 0;font:11px Arial">
	<span>Filters count:</span> <span><?php echo $filtersCount ?></span>
</div>
<div style="margin:0 0 0px 0">
	<span id="defined_filters_<?php echo $key ?>_hint" class="simpleHint">
		List all your possible filters here through semicolon. E.g.: White;Black;Blue
	</span>
</div>
</div>
