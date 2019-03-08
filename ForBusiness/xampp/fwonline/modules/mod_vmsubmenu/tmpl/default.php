<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_vmsubmenu
 * @copyright	Copyright 2015 Linelab.org. All rights reserved.
 * @license		GNU General Public License version 3
 */
// No direct access.
defined('_JEXEC') or die;
$doc = JFactory::getDocument();
$doc->addStyleSheet( 'modules/mod_vmsubmenu/tmpl/submenupro.css' );
?>
<style type="text/css">
#menupro{position: relative;}
#menupro #linemenus ul.vert > li.virtuemart-menu:hover > ul.chield {
left: <?php echo $params->def('subvertleft','0');?>px;
width: <?php echo $params->def('subvertwidth','100').$params->def('subvertwidthpar','%');?>;
top: -<?php echo $params->def('subverttop','0');?>px;
}  
#menupro .nav::before, #menupro .nav::after {display: <?php echo $params->def('botfix','block');?>;
} 
#menupro #linemenus ul > li.virtuemart-menu:hover > ul.chield {
left: 0;
width: 100%;
top: auto;
}
.js .selectnav li.submx {display: none;}
#menupro #linemenus ul > li.virtuemart-menu > ul.chield > li.submx {background: none !important;}  
#menupro .vmdesc  { font-size: 11px; height: 56px; line-height: normal; overflow: visible; padding: <?php echo $params->def('apadtm','15').'px '.$params->def('apadrm','15').'px '.$params->def('apadbm','15').'px '.$params->def('apadlm','15');?>px;}
#menupro .custom  {line-height: normal; overflow: hidden; padding: <?php echo $params->def('apadtm','15').'px '.$params->def('apadrm','15').'px '.$params->def('apadbm','15').'px '.$params->def('apadlm','15');?>px;}
#menupro #linemenus ul > li.virtuemart-menu > ul.chield {
color: <?php echo $params->def('subul','#000').' '.$params->def('subforceul');?>;
background: <?php echo $params->def('subulbg','#eee');?> url(/<?php echo $params->get('subulbgimg');?>) no-repeat right top;
text-align: <?php echo $params->def('subalign','left');?>; 
box-shadow: 0 3px 5px rgba(0, 0, 0, 0.2);
z-index: <?php echo $params->def('subzindex','999999');?>;
}
#menupro #linemenus ul > li.virtuemart-menu > ul.chield > li, #menupro #linemenus ul > li.virtuemart-menu > ul.chield > li li {
background: <?php echo $params->def('sublibg','#eee').' '.$params->def('subforcelibg');?>;
color: <?php echo $params->def('subli','#000').' '.$params->def('subforceli');?>;
padding: <?php echo $params->def('lipadt','0').'px '.$params->def('lipadr','5').'px '.$params->def('lipadb','0').'px '.$params->def('lipadl','5');?>px;
text-align: <?php echo $params->def('subalign','left');?>;
border: 0 none !important;
}
#menupro #linemenus ul > li.virtuemart-menu > ul.chield > li > a, #menupro #linemenus ul > li.virtuemart-menu > ul.chield > li li a {
background: <?php echo $params->def('sublibg','#eee').' '.$params->def('subforcelibg');?>;
color: <?php echo $params->def('suba','#666').' '.$params->def('subforcea');?>;
border-color: <?php echo $params->def('subabr','#cfcfcf').' '.$params->def('subforceabr');?>;
border-style: solid;
border-width: <?php echo $params->def('subbrt','0').'px '.$params->def('subbrr','0').'px '.$params->def('subbrb','1').'px '.$params->def('subbrl','0');?>px;
padding: <?php echo $params->def('apadt','0').'px '.$params->def('apadr','0').'px '.$params->def('apadb','0').'px '.$params->def('apadl','15');?>px;
font-size: <?php echo $params->def('subfont','13');?>px;
font-weight: normal;
text-decoration: none;
text-transform: none;
height: <?php echo $params->def('subheight','40');?>px;
line-height: <?php echo $params->def('subheight','40');?>px;
text-align: <?php echo $params->def('subalign','left');?>;
}
#menupro #linemenus ul > li.virtuemart-menu > ul.chield > li > a:hover, #menupro #linemenus ul > li.virtuemart-menu > ul.chield > li > a:focus, #menupro #linemenus ul > li.virtuemart-menu > ul.chield > li > a:active, #menupro #linemenus ul > li.virtuemart-menu > ul.chield > li li a:hover, #menupro #linemenus ul > li.virtuemart-menu > ul.chield > li li a:focus, #menupro #linemenus ul > li.virtuemart-menu > ul.chield > li li a:active, #menupro #linemenus ul > li.virtuemart-menu > ul.chield > li li.active a, #menupro #linemenus ul > li.virtuemart-menu > ul.chield > li.active a {
background: <?php echo $params->def('subabgh','#666').' '.$params->def('subforceabgh');?>;
color: <?php echo $params->def('subah','#f1f1f1').' '.$params->def('subforceah');?>;
font-weight: <?php echo $params->def('subfoh','bold').' '.$params->def('subforcfoh');?>;
text-decoration: none;
text-transform: none;
}
@media only screen and (max-width: 980px) {
#menupro #linemenus ul > li.virtuemart-menu > ul.chield {
background: <?php echo $params->def('subulbg','#eee');?>;
float: left;
position: static;
width: 100% !important;}
#menupro #linemenus ul > li.virtuemart-menu > ul.chield > li, #menupro #linemenus ul > li.virtuemart-menu > ul.chield > li li  {
clear: none;
width: 50% !important;
}
#menupro #linemenus ul > li.virtuemart-menu > ul.chield > li:nth-child(2n+1) {
clear: left;
}
#menupro #linemenus ul > li.virtuemart-menu > ul.chield > li.submx {
    width: 100% !important;
}
#menupro #linemenus ul.vert > li.virtuemart-menu:hover > ul.chield {
left: <?php echo $params->def('subvertleft','0');?>px;
width: <?php echo $params->def('subvertwidth','100').$params->def('subvertwidthpar','%');?>;
top: -<?php echo $params->def('subverttop','0');?>px;
}  
}
@media only screen and (max-width: <?php echo $params->def('submobile','630');?>px) {
#menupro #linemenus ul > li.virtuemart-menu:hover > ul.chield {
opacity: 1;
display: block;
left: auto !important;
top: auto !important;
width: auto !important;
padding: 0;
margin: 0;
position: relative;
}
#menupro #linemenus ul > li.virtuemart-menu > ul.chield {
background: none;
display:block;
float: none;
box-shadow: 0 0 0 rgba(0, 0, 0, 0.0);
position: static;
width: 100% !important;}
#menupro #linemenus ul > li.virtuemart-menu > ul.chield > li {
float: none;
}
#menupro .vmdesc, #menupro .custom, #menupro .submx  {display: none;}
#menupro #linemenus ul > li.virtuemart-menu > ul.chield > li, #menupro #linemenus ul > li.virtuemart-menu > ul.chield > li li, #menupro #linemenus ul > li.virtuemart-menu > ul.chield > li > a, #menupro #linemenus ul > li.virtuemart-menu > ul.chield > li li a, #menupro #linemenus ul > li.virtuemart-menu > ul.chield > li > a:hover, #menupro #linemenus ul > li.virtuemart-menu > ul.chield > li li a:hover {
width: 100% !important;
background: none !important;
height: auto !important;
line-height: normal !important;
padding: 0 !important;
border:0 none !important;
left: 0; top: auto;
}
#menupro #linemenus ul > li.virtuemart-menu > ul.chield > li:nth-child(2n+1) {
clear: left;
}
}
</style>
<div id="menupro">
<div id="linemenus">
<ul class="linemenu nav <?php echo $class_sfx;?>"<?php
	$tag = '';
	if ($params->get('tag_id')!=NULL) {
		$tag = $params->get('tag_id').'';
		echo ' id="'.$tag.'"';
	}
?>>
<?php
foreach ($list as $i => &$item) :
	$class = 'labitem item-'.$item->id;
	if ($item->id == $active_id) {
		$class .= ' current';
	}
	if (in_array($item->id, $path)) {
		$class .= ' active';
	}
	elseif ($item->type == 'alias') {
		$aliasToId = $item->params->get('aliasoptions');
		if (count($path) > 0 && $aliasToId == $path[count($path)-1]) {
			$class .= ' active';
		}
		elseif (in_array($aliasToId, $path)) {
			$class .= ' alias-parent-active';
		}
	}
	if ($item->deeper) {
		$class .= ' deeper';
	}
	if ($item->parent) {
		$class .= ' parent';
	}
	if (strpos($item->link,'option=com_virtuemart')>0 && strpos($item->link,'view=virtuemart')>0) {
		$class .= ' virtuemart-menu';
	}
		if (strpos($item->link,'com_virtuemart')>0 && strpos($item->link,'view=category')>0) {
		$class .= ' virtuemart-menu';
	}
	if (!empty($class)) {
		$class = ' class="'.trim($class) .'"';
	}
	echo '<li'.$class.'>';
	// Render the menu item.
	switch ($item->type) :
		case 'separator':
		case 'url':
		case 'component':
			require JModuleHelper::getLayoutPath('mod_vmsubmenu', 'default_'.$item->type);
			break;
		default:
			require JModuleHelper::getLayoutPath('mod_vmsubmenu', 'default_url');
			break;
	endswitch;
	// The next item is deeper.
	if ($item->deeper) {
		echo '<ul>';
	}
	// The next item is shallower.
	elseif ($item->shallower) {
		echo '</li>';
		echo str_repeat('</ul></li>', $item->level_diff);
	}
	// The next item is on the same level.
	else {
		echo '</li>';
	}
endforeach;
?></ul></div></div>