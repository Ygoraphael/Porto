<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

$item = $this->item;
$jb = & $this->jb;

$editor = JFactory::getEditor();

?>
<form action="index.php" method="post" name="adminForm" id="adminForm"  class="form-validate form-inline" enctype="multipart/form-data">
    <input type="hidden" name="option" value="com_joodb" />
    <input type="hidden" name="joodbid" value="<?php echo $jb->id; ?>" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="<?php echo $jb->fid; ?>" value="<?php echo $this->id?>" />
    <div class="row-fluid">
        <div class="width-60 fltlft span8">
            <!--Stammdaten -->
            <fieldset class="adminform  block">
                <legend><?php echo JText::_( "Editable fields" ); ?></legend>
                <table class="paramlist">
                    <?php
                    foreach ($jb->fields as $fname=>$fcell) {
                        $typearr = preg_split("/\(/",$fcell->Type);
                        $fid = "jform_".preg_replace("/[^A-Z0-9]/i","",$fname);
                        if (!isset($item->{$fname})) $item->{$fname} = null;
                        $typevals = array("");
                        $required = ($fcell->Null=="NO"  || $fname==$jb->ftitle) ? "required" :"";
                        if (isset($typearr[1])) { $typevals =  preg_split("/','/",trim($typearr[1],"')"));	}
                        // get default value
                        if (($this->id==0) && ($fcell->Default!=NULL)) { $item->{$fname} = $fcell->Default; }
                        echo '<tr><td class="paramlist_key"><label for="'.$fid.'">'.ucfirst(str_replace("_"," ",$fname)).'</label></td><td class="paramlist_value">';
                        if ($fcell->Extra=='auto_increment') {
                            echo '<input class="inputbox" type="text" name="'.$fname.'" id="'.$fid.'" value="'.htmlspecialchars($item->{$fname}, ENT_COMPAT, 'UTF-8').'" maxlength="40" size="60" style="width: 200px" disabled />';
                        } else
                            switch ($typearr[0]) {
                                case 'varchar' :
                                case 'char' :
                                case 'tinytext' :
                                    echo '<input class="inputbox '.$required.'" type="text" name="'.$fname.'" id="'.$fid.'" value="'.htmlspecialchars($item->{$fname}, ENT_COMPAT, 'UTF-8').'" maxlength="'.$typevals[0].'" size="60" style="width: '.(($typevals[0]<30) ? '300px' : '500px').'" />';
                                    break;
                                case 'int' :
                                case 'smallint' :
                                case 'mediumint' :
                                case 'bigint' :
                                case 'decimal' :
                                case 'float' :
                                case 'double' :
                                case 'real' :
                                    echo '<input class="inputbox '.$required.'" type="text" name="'.$fname.'" id="'.$fid.'" value="'.htmlspecialchars($item->{$fname}, ENT_COMPAT, 'UTF-8').'" maxlength="40" size="60" style="width: 200px" />';
                                    break;
                                case 'tinyint' :
                                    if (!empty($jb->fstate) && $jb->fstate==$fname) {
                                        echo  '<select class="inputbox"  style="width: auto;" name="'.$fname.'" id="'.$fid.'"><option value="0">'.JText::_('JNo').'</option><option value="1" ';
                                        if (!empty($item->{$fname})) echo 'selected="selected"';
                                        echo '>'.JText::_('JYes').'</option></select>';
                                    } else
                                        echo '<input class="inputbox '.$required.'" type="text" name="'.$fname.'" value="'.htmlspecialchars($item->{$fname}, ENT_COMPAT, 'UTF-8').'" maxlength="4" size="4" style="width: 50px" />';
                                    break;
                                case 'datetime' :
                                case 'timestamp' :
                                    $item->{$fname} = preg_replace("/[^0-9:\- ]/","",$item->{$fname});
                                    echo JHTML::_('calendar', $item->{$fname} , $fname, $fid, '%Y-%m-%d %H:%M:%S', array('class'=>'inputbox '.$required, 'size'=>'25',  'maxlength'=>'19'));
                                    break;
                                case 'date' :
                                    $item->{$fname} = preg_replace("/[^0-9\-]/","",$item->{$fname});
                                    echo JHTML::_('calendar', $item->{$fname} , $fname, $fid, '%Y-%m-%d', array('class'=>'inputbox '.$required, 'size'=>'25',  'maxlength'=>'10'));
                                    break;
                                case 'year' :
                                    echo '<input class="inputbox '.$required.'" type="text" name="'.$fname.'" id="'.$fid.'" value="'.((int) $item->{$fname}).'" maxlength="4" size="4" style="width: 50px" />';
                                    break;
                                case 'time' :
                                    echo '<input class="inputbox '.$required.'" type="text" name="'.$fname.'"  id="'.$fid.'" value="'.($item->{$fname}).'" maxlength="8" size="4" style="width: 70px" />';
                                    break;
                                case 'text' :
                                case 'mediumtext' :
                                case 'longtext' :
                                    echo '<div style="display:inline-block; width: auto;">';
                                    // 	Load the JEditor object
                                    echo $editor->display($fname, stripslashes($item->{$fname}), '45ß', '250', '40', '6',false,"joodb_".$fname);
                                    echo '</div>';
                                    break;
                                // special handling for enum and set
                                case 'enum' :
                                    echo '<select class="inputbox '.$required.'" type="text" name="'.$fname.'" id="'.$fid.'" style="width: 200px" />';
                                    echo '<option value="" >...</option>';
                                    foreach ($typevals as $value) {
                                        echo '<option value="'.$value.'" '.(($value==$item->{$fname}) ? 'selected' : '' ).'>'.$value.'</option>';
                                    }
                                    echo '</select>';
                                    break;
                                case 'set' :
                                    $setarray = preg_split("/,/",$item->{$fname});
                                    if (count($typevals)<=5) {
                                        foreach ($typevals as $n => $value) {
                                            echo '<label class="inline checkbox" for="'.$fid.$n.'"><input type="checkbox" class="inline"  name="'.$fname.'[]" id="'.$fid.$n.'" value="'.$value.'" '.((in_array($value,$setarray))? 'checked' : '' ).' />&nbsp;'.$value.'</label> ';
                                        }
                                    } else {
                                        echo '<select class="inputbox '.$required.'" type="text" multiple="multiple" name="'.$fname.'[]" id="'.$fid.'" style="width: 200px" >';
                                        foreach ($typevals as $value) {
                                            echo '<option value="'.$value.'" '.(in_array($value,$setarray)? 'selected' : '' ).'>'.$value.'</option>';
                                        }
                                        echo '</select>';
                                    }
                                    break;
                                case 'tinyblob' :
                                case 'mediumblob' :
                                case 'blob' :
                                case 'longblob' :
                                    echo  '<input class="inputbox '.$required.'" type="file" name="'.$fname.'" id="'.$fid.'" size="30" />';
                                    if (!empty($item->{$fname})) {
                                        $mime = JooDBAdminHelper::getMimeType($item->{$fname});
                                        echo '<div style="clear:both; font-size: 10px;" > '.strlen($item->{$fname}).' Bytes ';
                                        if (substr($mime, 0,5)=="image") {
                                            echo '<a href="'.JURI::root().'index.php?option=com_joodb&task=getFileFromBlob&joobase='.$jb->id.'&id='.$item->{$jb->fid}.'&field='.$fname .'" class="modal" rel="{handler: \'image\'}">';
                                            echo '<img style="max-width:80px; max-height: 60px; border: 1px solid #ccc; float:left; margin-right: 15px;" src="data:'.$mime.';base64,'.base64_encode($item->{$fname}).'" alt="*" />';
                                            echo '</a>';
                                        }
                                        echo $mime;
                                        echo '</div>';
                                    }
                                    break;
                                default:
                                    echo '<input class="inputbox '.$required.'" type="text" name="'.$fname.'" id="'.$fid.'" value="'.htmlspecialchars($item->{$fname}, ENT_COMPAT, 'UTF-8').'" maxlength="'.$typevals[0].'" size="60" style="width: 500px;" />';
                            }
                        echo '</td></tr>';
                    }
                    ?>
                </table>
            </fieldset>
        </div>
        <div class="width-40 fltlft span4">
            <fieldset class="adminform block">
                <legend><?php echo JText::_( "Upload image" ); ?></legend>
                <?php
                $imgpath = JPATH_ROOT."/images/joodb/db".$jb->id;
                // attach image to dataset
                if (!file_exists($imgpath)) {
                    if (!@mkdir($imgpath,0777, true)) {
                        echo '<p style="color:red; font-weight: bold;">Can not create JooDB image directory. Make shure that /images is writable</p>';
                    }
                }
                ?>
                <table class="paramlist">
                    <tr>
                        <td colspan="2">
                            <input class="inputbox input-medium" name="dataset_image" type="file" size="30" style="width:200px" maxlength="1000000" accept="*.jpg, *.jpeg, *.png" /><br/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label><input type="checkbox" name="delete_image" value="1" />&nbsp;<?php echo JText::_('DELETE_IMAGE'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <td class="paramlist_key"><?php echo JText::_( "Existing image" ); ?></td>
                        <td>
                            <?php
                            if (($item->{$jb->fid}) && (file_exists($imgpath."/img".$item->{$jb->fid}.".jpg"))) {
                                echo '<img  style="border: 1px solid #444; background-color: #ccc; padding: 10px;" src="'.JURI::root(true).'/images/joodb/db'.$jb->id.'/img'.$item->{$jb->fid}.'-thumb.jpg" alt="*" />';
                            } else {
                                echo JText::_( "None" );
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
    </div>
    <?php echo JHTML::_( 'form.token' );?>
</form>
<script type="text/javascript">

    Joomla.submitbutton = function(task) {
        var frm = document.adminForm;
        if (task == 'listdata') {
            Joomla.submitform(task, frm);
            return true;
        }
        // do field validation
        var valid = document.formvalidator.isValid(frm);
        if (frm.<?php echo $jb->ftitle; ?>.value == ""){
            alert('<?php echo addslashes(JText::_( "Must have title" )); ?>');
            frm.<?php echo $jb->ftitle; ?>.focus();
            return false;
        } else  {
            if (valid == false) {
                alert("<?php echo addslashes(JText::_( "Fillout required fields" )); ?>");
                return false;
            } else {
                if (typeof tinyMCE != "undefined") window.onbeforeunload = function() {};
            }
        }
        Joomla.submitform(task, frm);
    }

</script>
