<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class FSConfigureOptionsModel {

	static public function showConfigurationPage() {

		require(FS_PATH .'views/FSConfigureOptions/FSConfigureOptionsView.php');
		FSConfigureOptionsView::printConfigurationPage();

	}


	static public function saveConfiguration() {

		FSConf::writeConfigurationToFile();

	}

}
