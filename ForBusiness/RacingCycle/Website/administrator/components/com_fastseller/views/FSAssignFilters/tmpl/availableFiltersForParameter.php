<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$filters = explode(';', $filtersStr);
$filtersCount = count($filters);
$columns = FSConf::get('filter_columns');

if ($filtersCount < $columns) {

}

$filtersPerColumn = floor($filtersCount / $columns);
$mod = $filtersCount % $columns;
$column = array();

for ($i = 0; $i < $columns; $i++) {
	$c = $filtersPerColumn;
	if ($mod) {
		$c++;
		$mod--;
	}
	$column[$i] = $c;
}

//print_r($column);

$uniqueId = JRequest::getVar('uniqueid', null);
$appliedFiltersStr = JRequest::getVar('filters', null);
$appliedFilters = explode(';', $appliedFiltersStr);


echo '<div class="param-filters" data-uniqueid="'. $uniqueId .'">';

$i = 0;
foreach ($column as $k => $count) {

	echo '<div class="available-filters-column">';

	for ($j = 0; $j < $count; $j++) {

		if (!trim($filters[$i])) {
			$i++;
			continue;
		}

		$selected = (in_array($filters[$i], $appliedFilters)) ? ' selected' : '';

		echo '<a href="#" class="available-filters-filter'. $selected .'"><span class="available-filters-tick'. $selected .
			'"></span><span class="available-filters-value">'. $filters[$i] .'</span></a>';

		$i++;
	}

	echo '</div>';
}

echo '</div>';

?>
