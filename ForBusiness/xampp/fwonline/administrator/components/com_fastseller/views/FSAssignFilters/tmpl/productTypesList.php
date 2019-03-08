 <?php
defined( '_JEXEC' ) or die( 'Restricted access' );

?>
<table cellspacing="0" cellpadding="0" border="0" width="100%" style="padding:0 0 3px 3px;">
	<tr>
		<td class="pt-list-pt">
			<div class="pt-content" style="color:#887A37;">w/o Product Type</div>
		</td>
		<td width="50" align="right" valign="top" class="pt-list-button-cont white">
			<div class="hid">
			<button data-ptid="wopt" data-ptname="w/o Product Type" class="pt-list-button" type="button">Go</button>
			</div>
		</td>
	</tr>
<?php

	foreach ($ptsData as $pt) {

?>
		<tr>
			<td class="pt-list-pt">
				<div class="pt-content<?php echo ($pt['product_type_publish'] == 'N') ? ' grayed' : '' ?>">
					<?php echo $pt['product_type_name'] ?>
				</div>
			</td>
			<td width="50" align="right" valign="top" class="pt-list-button-cont white">
				<div class="hid">
				<button data-ptid="<?php echo $pt['product_type_id'] ?>" data-ptname="<?php echo $pt['product_type_name'] ?>"
					class="pt-list-button" type="button">Go</button>
				</div>
			</td>
		</tr>
<?php

	}

?>
</table>
