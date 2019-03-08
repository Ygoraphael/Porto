<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


require(FS_PATH .'models/FSConfigureOptionsModel.php');

$action = JRequest::getCmd('action', null);

switch ($action) {

	case 'SAVE_CONFIG':
		FSConfigureOptionsModel::saveConfiguration();
		break;

	default:
		FSConfigureOptionsModel::showConfigurationPage();

}

?> 