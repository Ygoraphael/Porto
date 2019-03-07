<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


class FSConfigureOptionsView {

	static public function printConfigurationPage() {

		require(FS_PATH .'views/FSConfigureOptions/tmpl/configurationPage.php');

		self::loadJavascript();

	}


	static private function loadJavascript() {

		echo '<script type="text/javascript">';

		require(FS_PATH .'static/js/configOptions_basicEvents.js');

		echo '</script>';

	}

}