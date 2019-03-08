<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Generates a select - form element from a ralated subtable
 * @usage {joodb subselect|TABLE_NAME|FIELD_NAME|VALUE_FIELD|[TITLE_FIELD]}
 */
if (isset($this->joobase) && count($part->parameter)>=3) {
    $db = $this->joobase->getTableDbo();
    $table = $db->escape($part->parameter[0]); // Name of the linked table
    $field = $db->escape($part->parameter[1]); // Name of the field in the main table
    $idfield = $db->escape($part->parameter[2]); // Name of the related field in the linked table (value)
    $titlefield = (isset($part->parameter[3])) ? $db->escape($part->parameter[3]) : $idfield; // Optional use the content of another field as (text)
    $db->setquery("SELECT `".$idfield."`,`".$titlefield."` FROM `".$table."` ORDER BY `".$titlefield."` ASC");
    if ($slist = $db->loadAssocList($idfield,$titlefield)) {
        $output .=  '<select class="inputbox"  id="jform_'.$field.'" name="'.$field.'" >';
        foreach ($slist AS $var => $val) {
            $output .= '<option value="'.addslashes($var).'" ';
            if (isset($this->item->{$field}) && $this->item->{$field}==$var) $output .= ' selected="selected"';
            $output .= '>'.$val.'</option>';
        }
        $output .=  '</select>';
    }
}
?>
