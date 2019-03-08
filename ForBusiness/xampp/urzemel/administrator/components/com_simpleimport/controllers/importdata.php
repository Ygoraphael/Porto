<?php
/**
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_1
 * @license    GNU/GPL
 */
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
/**
 * Hello World Component Controller
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class SimpleimportControllerImportdata extends JController
{
    /**
     * Method to display the view
     *
     * @access    public
     */
	function __construct() {
		parent::__construct();
	}
	 
	 
    function Importdata()
    {
		JRequest::setVar('tmp_file', 'File Name from controller:'.$_FILES['file']['tmp_name']);
		$view = $this->getView('importdata', 'html');
		$view->setModel( $this->getModel( 'simpleimport', 'SimpleimportModel' ), true );
		$view->display();
    }
}
