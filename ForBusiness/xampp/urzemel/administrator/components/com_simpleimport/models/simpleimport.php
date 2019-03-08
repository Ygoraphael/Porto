<?php
/**
 * Hellos Model for Hello World Component
 * 
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_5
 * @license        GNU/GPL
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
 
jimport( 'joomla.application.component.model' );
 
/**
 * Hello Model
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class SimpleimportModelSimpleimport extends JModel
{
    function getFileName()
    {
        // Lets load the data if it doesn't already exist
        if (empty( $this->_data ))
        {
			
			$this->_data = "FileName:" . $_FILES["file"]["tmp_name"];
			
			/*if($_FILES["file"]["type"] == "text/csv"){
				if ($_FILES["file"]["error"] > 0) {
				  $this->_data = "!Error: " . $_FILES["file"]["error"] . "<br />";
				}
				else {
				  $this->_data = "FileName:" . $_FILES["file"]["tmp_name"];
				}
			}else{
				$this->_data = "File Error: " . $_FILES["file"]["error"] . "<br />";
				$invalid_file=1;	
			}*/			
        }
        return $this->_data;
    }
}