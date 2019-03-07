<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

//var_dump($categoriesData);

$categoryTreeId = JRequest::getVar('category_tree_id', '');

?>
<table cellspacing="0" cellpadding="0" border="0" width="100%" <?php if ($categoryTreeId == 'cbranch') echo 'style="padding-left:10px"'; ?>>
<?php

foreach ($categoriesData as $i => $category) {

	$id = $categoryTreeId .'-'. $i;

?>
	<tr>
		<td data-catid="<?php echo $category['id'] ?>" data-branchid="<?php echo $id ?>" class="category-tree-categories">
			<div class="cat-content<?php echo ($category['published'] == 0) ? ' grayed' : '' ?>">
				<?php echo $category['name'] ?>
			</div>
			<div id="<?php echo $id .'-loader' ?>" class="cat-loader hid">
				<img src="<?php echo FS_URL ?>static/img/ajax-loader.gif" width="16" height="11" />
			</div>
		</td>
		<td width="50" align="right" valign="top" class="category-tree-button-cont white">
			<div class="hid">
			<button data-catid="<?php echo $category['id'] ?>" data-catname="<?php echo $category['name'] ?>"
				class="category-tree-button" type="button">Go</button>
			</div>
		</td>
	</tr>
	<tr><td colspan="3" id="<?php echo $id ?>"></td></tr>
<?php

	}

?>
</table>
