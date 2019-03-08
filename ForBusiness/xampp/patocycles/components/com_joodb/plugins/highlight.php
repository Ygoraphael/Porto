<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

	$search = Jrequest::getCmd("search");
	$html = $item->{$part->parameter[0]};
	if (!empty($search)) {
		$html = preg_replace('/'.$search.'/i', '<span class="hl">'.$search.'</span>',$html);	
	}	
	$output .= $html;
 
?>
