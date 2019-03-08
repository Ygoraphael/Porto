<?php // no direct access
defined('_JEXEC') or die('Restricted access');

$jb = &$this->joobase;
$imgpart = "/images/joodb/db".$jb->id."/img".$this->item->{$jb->fid};

?>
<div class="database-article item-page<?php echo $this->params->get('pageclass_sfx')?>">
<div class="page-header">
    <h1><?php echo (empty($this->item->{$jb->fid})) ? JText::_('NEW_DATABASE_ENTRY') : JText::_('EDIT_DATABASE_ENTRY'); ?></h1>
</div>
<div class="database-form">
<form action="<?php echo JRoute::_( 'index.php' );?>" method="post" name="joodbForm" id="joodbForm" class="form-validate form-inline" enctype="multipart/form-data">
    <input type="hidden" name="option" value="com_joodb" />
    <input type="hidden" name="view" value="article" />
    <input type="hidden" name="Itemid" value="<?php echo $this->menu->id; ?>" />
    <input type="hidden" name="id" value="<?php echo $this->item->{$jb->fid}; ?>" />
    <input type="hidden" name="joobase" value="<?php echo $jb->id; ?>" />
    <input type="hidden" name="<?php echo $jb->fid; ?>" value="<?php echo $this->item->{$jb->fid}; ?>" />
    <input type="hidden" name="task" value="save" />
    <?php echo JHTML::_( 'form.token' ); ?>
    <?php if ($fuser=$jb->getSubdata('fuser')) :?>
        <input type="hidden" name="<?php echo $fuser ?>" value="<?php echo $this->item->{$fuser} ?>" />
    <?php
        unset($this->item->{$fuser});
        endif;
    ?>
	<fieldset>
		<dl>

<?php 
	unset($this->item->{$jb->fid}); 
	foreach ($this->item AS $var => $val) :
?>
			<dt><label for="jform_<?php echo preg_replace("/[^A-Z0-9]/i","",$var); ?>"><?php echo ucfirst($var); ?></label></dt>
			<dd><?php echo JoodbHelper::getFormField($jb,array($var),$this->item->{$var}); ?></dd>
<?php endforeach; ?>
		</dl>
			<hr/>
		<dl>		
			<dt><?php echo JText::_('ITEM_IMAGE'); ?></dt>
			<dd>
				<input name="joodb_dataset_image" class="inputbox file" type="file" accept="image/*" />
				<div style="margin: 10px 0;">
<?php 
		$thumb = JURI::root(true).(file_exists(JPATH_ROOT.$imgpart."-thumb.jpg") ? $imgpart."-thumb.jpg" : "/components/com_joodb/assets/images/nopic.png");
		$image = JURI::root(true).(file_exists(JPATH_ROOT.$imgpart.".jpg") ? $imgpart.".jpg" : "/components/com_joodb/assets/images/nopic.png");
		echo '<a href="'.$image.'" class="modal"><img src="'.$thumb.'" alt="thumb" class="database-thumb" /></a>';
?>				
				</div>
			</dd>
			<dt>&nbsp;</dt>
			<dd>
				<button class="button btn validate" onmousedown="validateForm();" type="submit"><?php echo JText::_('Save') ?></button>
			</dd>	
		</dl>
	</fieldset>
</form>
</div>
</div>
<script type="text/javascript">
<!--
	function validateForm() {
		var frm = document.joodbForm;
		var valid = document.formvalidator.isValid(frm);
		if (valid == false) {
			// do field validation
			alert( "<?php echo JText::_( 'Required fields', true ); ?>" );
			return false;
		}
		return true;
	}
// -->
</script>
