<?php
/**
 * @package     Crosstec Template Tools
 * @author      Markus Bopp
 * @link        http://www.crosstec.de
 * @license     GNU/GPL
*/

class plgSystemRokextenderInstallerScript
{
    function preflight(){
    }
    
    function postflight(){
        $db = JFactory::getDBO();
        try{
            $db->setQuery("Update #__extensions Set `enabled` = 1 Where `element` = 'rokextender'");
            $db->query();
        }catch(Exception $e){}
    }
    
    function install($parent) {
        
    }
    
    function update($parent) {
    }
    
    function uninstall($parent) { 
    }
}
