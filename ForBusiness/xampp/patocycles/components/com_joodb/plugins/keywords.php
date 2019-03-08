<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Output of a static keyword checkbox list
 * @usage {joodb keywords|KEYWORD_FIELD|Value1,Value2,Value3,...}
 */
$field = $part->parameter[0];
$kwords = preg_split("/,/",$part->parameter[1]);

$gs =  JRequest::getVar("gs",null,"default","array");
if (is_array($kwords)) {
    foreach ($kwords AS $n=>$word) {
        $value = '%'.addslashes($word).'%';
        $output .= '<input id="t'.$n.'" type="checkbox" name="gs['.$field.'][]" value="'.$value.'" ';
        if (isset($gs[$field]) && array_search($value,$gs[$field])!== false)  $output .= ' checked="checked"';
        $output .= '/>&nbsp;<label for="t'.$n.'">'.ucfirst($word).'</label>&nbsp;';
    }
}

?>
