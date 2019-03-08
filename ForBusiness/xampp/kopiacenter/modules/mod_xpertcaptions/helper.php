<?php
/**
 * @package Xpert Captions
 * @version 2.7
 * @author ThemeXpert http://www.themexpert.com
 * @copyright Copyright (C) 2009 - 2011 ThemeXpert
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// no direct access
defined( '_JEXEC' ) or die('Restricted access');

abstract class XEFXpertCaptionsHelper{
    
    public static function loadScripts($module, $params)
    {
        $doc = JFactory::getDocument();

        // Get module id
        $module_id = XEFUtility::getModuleId($module, $params);

        // Load jQuery
        XEFUtility::addjQuery($module, $params);
        
        $animation  = $params->get('animation','slide');
        $speed      = (int)$params->get('speed',150);
        $opacity    = $params->get('opacity',1);
        $anchor     = $params->get('anchor','left');
        $hover_x    = "'". (int) $params->get('hover_x',0) . "px'";
        $hover_y    = "'". (int) $params->get('hover_y',0) . "px'";
        $js         = '';
        
        if($anchor == 'left' OR $anchor == 'right'){
            $anchor = "anchor_x: '$anchor'";
        }else{
            $anchor = "anchor_y: '$anchor'";
        }
        if($animation == 'xc-fade'){
            $js = "
                jQuery.noConflict();
                jQuery(document).ready(function(){
                    jQuery('#$module_id .xc-block').xpertcaptions({
                        animation: 'fade',
                        opacity: {$opacity}
                    });
                });
            ";
        }else{
            $js = "
                jQuery.noConflict();
                jQuery(document).ready(function(){
                    jQuery('#$module_id .xc-block').xpertcaptions({
                        animation: 'slide',
                        speed: {$speed},
                        {$anchor},
                        hover_x: {$hover_x},
                        hover_y: {$hover_y}
                    });
                });
            ";
        }
        $doc->addScriptDeclaration($js);

        if(!defined('XPERT_CAPTIONS')){
            //add tab engine js file
            $doc->addScript(JURI::root(true).'/modules/mod_xpertcaptions/assets/js/xpertcaptions.js');
            define('XPERT_CAPTIONS',1);
        }
    }


    public static function loadStyles($module, $params)
    {
        // Get module id
        $module_id          = XEFUtility::getModuleId($module, $params);
        $doc                = JFactory::getDocument();
        $css                = '';
        $anchor             = $params->get('anchor','left');
        $anchor_position    = (int) $params->get('anchor_position',-100) . 'px';
        $width              = (int)$params->get('image_width',250).'px';
        $height             = (int)$params->get('image_height',250).'px';

        $css .= "
            #$module_id .xc-block, #$module_id img {width:$width; height:$height;}
            #$module_id .xc-overlay{{$anchor}:{$anchor_position};}
        ";
        
        $doc->addStyleDeclaration($css);
    }
}