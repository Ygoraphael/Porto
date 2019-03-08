<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$showUnpublishedProducts = FSConf::get('show_unpublished_products');
$showPDescButton = FSConf::get('show_pdesc_button');
$showSKU = FSConf::get('show_sku');
$showProductImage = FSConf::get('show_product_image');
$filtersColumns = FSConf::get('filter_columns');
$numberOfProductsOnPage = FSConf::get('products_num_on_page');
$parameterButtonsWidth = FSConf::get('param_button_width');
$vmLang = FSConf::get('vm_lang');
$debug = FSConf::get('debug');

?>
<div id="configurationOptions">
	<form name="configuration">
		<input type="hidden" name="i" value="CONF" />
		<input type="hidden" name="action" value="SAVE_CONFIG" />

		<button type="button" class="default-button-type-0 conf-save-button" data-loaderid="savingLoader_0">Save changes</button>
		<div id="savingLoader_0" class="conf-loader hid">
			<img src="<?php echo FS_URL ?>static/img/ajax-loader.gif" width="16" height="11" />
		</div>

		<table cellspacing="0" cellpadding="0" width="100%">
		<tr>
			<td class="confopt-num">1.</td>
			<td class="confopt-value">
				<input type="checkbox" name="show_unpublished_products" id="show_unpublished_products"
				value="1"<?php if ($showUnpublishedProducts) echo ' checked' ?> class="confopt-chkbx" />
				<label for="show_unpublished_products" class="confopt-lbl">Show unpublished Products</label></td>
			<td class="confopt-figure">
				<div id="show_unpublished_products_fig"<?php if (!$showUnpublishedProducts)
					echo ' class="semi-transparent"' ?>>
					<img src="<?php echo FS_URL ?>static/img/conf/show_unpublished.png" height="35" />
				</div></td>
		</tr>


		<tr>
			<td class="confopt-num">2.</td>
			<td class="confopt-value">
				<input type="checkbox" name="show_pdesc_button" id="show_pdesc_button"
				value="1"<?php if ($showPDescButton) echo ' checked'; ?> class="confopt-chkbx" />
				<label for="show_pdesc_button" class="confopt-lbl">Show Product Description button</label></td>
			<td class="confopt-figure">
				<div id="show_pdesc_button_fig"<?php if ($showPDescButton != 1) echo ' class="semi-transparent"'; ?>>
					<img src="<?php echo FS_URL ?>static/img/conf/showpdesc.png" height="33" />
				</div></td>
		</tr>


		<tr>
			<td class="confopt-num">3.</td>
			<td class="confopt-value">
				<input type="checkbox" name="show_sku" id="show_sku"
				value="1"<?php if ($showSKU) echo ' checked'; ?> class="confopt-chkbx" />
				<label for="show_sku" class="confopt-lbl">Show Product SKU</label></td>
			<td class="confopt-figure">
				<div id="show_sku_fig"<?php if (!$showSKU) echo ' class="semi-transparent"'; ?>>
					<img src="<?php echo FS_URL ?>static/img/conf/sku.png" height="31" />
				</div></td>
		</tr>


		<tr>
			<td class="confopt-num">4.</td>
			<td class="confopt-value">
				<input type="checkbox" name="show_product_image" id="show_product_image"
				value="1"<?php if ($showProductImage) echo ' checked'; ?> class="confopt-chkbx" />
				<label for="show_product_image" class="confopt-lbl">Show Product Image</label></td>
			<td class="confopt-figure">
				<div id="show_product_image_fig"<?php if (!$showProductImage) echo ' class="semi-transparent"'; ?>>
					<img src="<?php echo FS_URL ?>static/img/conf/show_product_image.png" height="33" />
				</div></td>
		</tr>


		<tr>
			<td class="confopt-num">5.</td>
			<td class="confopt-value">
				<div class="conf-similaroption">
					<label for="filter_columns" class="confopt-lbl">Number of filter columns:</label>
					<select name="filter_columns" id="filter_columns" class="confopt-sel">
						<option <?php if ($filtersColumns == 2) echo 'selected'; ?> value="2">2</option>
						<option <?php if ($filtersColumns == 3) echo 'selected'; ?> value="3">3</option>
						<option <?php if ($filtersColumns == 4) echo 'selected'; ?> value="4">4</option>
					</select>
					</div></td>
			<td class="confopt-figure"><div class="conf-imgcont" id="filter_dialog_figures">
				<img src="<?php echo FS_URL ?>static/img/conf/filter_columns.png" height="105" />
				</div></td>
		</tr>


		<tr>
			<td class="confopt-num">6.</td>
			<td class="confopt-value">
				<label for="products_num_on_page" class="confopt-lbl">Default number of rows on page:</label>
				<select name="products_num_on_page" id="products_num_on_page" class="confopt-sel">
					<option <?php if ($numberOfProductsOnPage == 5) echo 'selected'; ?>>5</option>
					<option <?php if ($numberOfProductsOnPage == 10) echo 'selected'; ?>>10</option>
					<option <?php if ($numberOfProductsOnPage == 15) echo 'selected'; ?>>15</option>
					<option <?php if ($numberOfProductsOnPage == 20) echo 'selected'; ?>>20</option>
					<option <?php if ($numberOfProductsOnPage == 25) echo 'selected'; ?>>25</option>
					<option <?php if ($numberOfProductsOnPage == 30) echo 'selected'; ?>>30</option>
					<option <?php if ($numberOfProductsOnPage == 50) echo 'selected'; ?>>50</option>
				</select></td>
			<td class="confopt-figure">
				<div style="margin:3px 0;">
					<img src="<?php echo FS_URL ?>static/img/conf/defaultnumrows.png" width="221" height="62" />
				</div></td>
		</tr>

		<tr>
			<td class="confopt-num">7.</td>
			<td class="confopt-value">Parameter buttons width:
				<input type="radio" name="param_button_width" id="param_button_width_0" value="0" <?php
					if ($parameterButtonsWidth == 0) echo 'checked' ?> class="confopt-radiobx" />
				<label for="param_button_width_0" class="confopt-lbl">Auto</label>
				<input type="radio" name="param_button_width" id="param_button_width_1" value="1" <?php
					if ($parameterButtonsWidth == 1) echo 'checked' ?> class="confopt-radiobx" />
				<label for="param_button_width_1" class="confopt-lbl">Fixed</label>
				</td>
			<td class="confopt-figure"></td>
		</tr>


		<tr>
			<td class="confopt-num">8.</td>
			<td class="confopt-value">
				<label for="vm_lang" class="confopt-lbl">Override Virtuemart's lang value:</label>
				<input type="text" name="vm_lang" id="vm_lang" value="<?php echo $vmLang ?>" size="5" class="confopt-inpt" />
				<br/>
				<span style="font:11px Tahoma;">
					The suffix of #__virtuemart_products_&lt;lang&gt; table, e.g.: <i>en_gb</i> or <i>fr_fr</i>
				</span></td>
			<td class="confopt-figure"></td>
		</tr>

		<tr>
			<td class="confopt-num">9.</td>
			<td class="confopt-value">
				<input type="checkbox" name="debug" id="debug"
				value="1"<?php if ($debug) echo ' checked' ?> class="confopt-chkbx" />
				<label for="debug" class="confopt-lbl">Enable Debug</label></td>
			<td class="confopt-figure"></td>
		</tr>

		</table>

		<div style="text-align:right;padding:10px 20px 0 0;color:#AAAAAA">Fast Seller version: <?php echo FSVERSION ?></div>

		<button type="button" class="default-button-type-0 conf-save-button" style="margin:20px 0 20px 10px;"
			data-loaderid="savingLoader_1">Save changes</button>
		<div id="savingLoader_1" class="conf-loader hid">
			<img src="<?php echo FS_URL ?>static/img/ajax-loader.gif" width="16" height="11" />
		</div>
	</form>
</div>
