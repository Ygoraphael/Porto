<?php // no direct access
defined('_JEXEC') or die('Restricted access');
/**
 * Category menu module
 *
 * @package VirtueMart
 * @subpackage Modules
 * @copyright Copyright (C) OpenGlobal E-commerce. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL V3, see LICENSE.php
 * @author OpenGlobal E-commerce
 *
 */

require_once('printcategories.php');

$moduleclass_sfx = $params->get('moduleclass_sfx');
$ID = str_replace('.', '_', substr(microtime(true), -8, 8));

if ($params->get('use_vm_accordion')) {
  $js="
//<![CDATA[
jQuery(document).ready(function() {
                jQuery('#virtuemartcategories".$ID." li.VmClose ul').hide();
                jQuery('#virtuemartcategories".$ID." li .VmArrowdown').click(
                function() {

                        if (jQuery(this).parent().next('ul').is(':hidden')) {
                        		jQuery('#virtuemartcategories".$ID." li').addClass('VmClose').removeClass('VmOpen');
                                jQuery(this).parents('li').addClass('VmOpen').removeClass('VmClose');
                                jQuery('#virtuemartcategories".$ID." li.VmClose ul:visible').delay(500).slideUp(500,'linear');
                                jQuery(this).parent().next('ul').slideDown(500,'linear');
                        }
                });
        });
//]]>
" ;

  $document = JFactory::getDocument();
  $document->addScriptDeclaration($js);
}

echo '<div class="virtuemartcategories'.$moduleclass_sfx.'" id="virtuemartcategories'.$ID.'">';
printCategories($params, $categories, $class_sfx, $parentCategories);
echo '</div>';


