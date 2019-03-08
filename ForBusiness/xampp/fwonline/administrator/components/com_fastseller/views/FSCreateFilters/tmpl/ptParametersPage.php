<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$ptid = (int)JRequest::getVar('ptid', null);
$ptName = FSCreateFiltersModel::getProductTypeNameById($ptid);
$parametersData = FSCreateFiltersModel::getParametersDataForPT($ptid);

?>
<div class="ptp-ttl">You are editing parameters of <span class="ptp-ttlName">"<?php echo $ptName ?>"</span> product type</div>
<div style="margin:5px 0">
	<button class="default-button-type-0 ptp-back-button">&larr; Back to Product Types list</button>
	<button id="ptp-save-parameters-button" class="default-button-type-0">
		<img src="<?php echo FS_URL ?>static/img/Save16.png" width="16" height="16" 
			style="vertical-align:middle" /> &nbsp;
		<span style="vertical-align:middle">Save all changes</span>
	</button>
</div>
<div id="ptpParamCont">
	<table class="ptp-tbl" style="background:white;">
	<tr>
		<td class="ptp-leftNav"><div style="position:relative;right:-1px"><ul id="ptpNavTabs">
<?php
	
	$count = count($parametersData);
	
	foreach ($parametersData as $i => $parameter) {
		$class = '';
		if ($i == 0) $class .= ' tab-first tab-selected';
		if ($i == ($count - 1)) $class .= ' tab-last';

?>
	<li id="ptpNavTab<?php echo $i ?>" class="ptp-navTab<?php echo $class ?>" data-tab="<?php echo $i ?>" 
			data-order="<?php echo $i ?>">
		<span class="ptp-tabParamLabel"><?php echo $parameter['parameter_label'] ?></span>
		<span class="ptp-tabParamName">(<?php echo $parameter['parameter_name'] ?>)</span>
		<div class="ptp-tabUpBtn">&uarr;</div>
	</li>
<?php
	}
?>
	</ul></div>
	<div style="margin:20px 0;text-align:center">
		<span class="ptp-addNewTab">Add new parameter</span></div>
	</td>
	<td class="ptp-rightData">
		<form method="get" name="parametersForm">
			<input type="hidden" name="i" value="CREATE" />
			<input type="hidden" name="action" value="SAVE_PARAMETERS" />
			<input type="hidden" name="ptid" value="<?php echo $ptid ?>" />
			<div id="ptpForms">
<?php

if ($count == 0) {
	echo '<div style="font:italic 13px Arial;text-align:center;color:#888888;margin-top:20px">'.
		'You do not have parameters yet. Add your first one.</div>';
} else {
	foreach ($parametersData as $i => $parameter){
		$class = ($i == 0) ? '' : ' hid';
?>
	<div class="ptp-formCont<?php echo $class ?>" id="ptpForm<?php echo $i?>">
<?php 
	
	self::printParameterForm($parameter, $i);

?>
	</div>
<?php
	}
}

?>
			</div>
		</form></td>
	</tr>
	</table>
</div>