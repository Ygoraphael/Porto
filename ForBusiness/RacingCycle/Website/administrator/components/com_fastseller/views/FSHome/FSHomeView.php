<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class FSHomeView {

	static public function printStats($d) {

		require(FS_PATH .'views/FSHome/tmpl/statistics.php');

	}

}

?>