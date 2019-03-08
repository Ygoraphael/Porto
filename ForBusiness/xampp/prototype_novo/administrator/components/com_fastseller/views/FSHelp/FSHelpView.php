<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class FSHelpView {

	static public function printHelp() {

		require(FS_PATH .'views/FSHelp/tmpl/help.php');

	}

}