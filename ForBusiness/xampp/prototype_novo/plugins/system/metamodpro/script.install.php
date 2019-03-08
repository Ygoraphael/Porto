<?php


class plgSystemMetamodproInstallerScript {
	function install($parent) {
		define('_MMP_HACK', 1);
		require_once('install.metamodpro.php');
	}	
	function update($parent) {
		define('_MMP_HACK', 1);
		require_once('install.metamodpro.php');
	}	
	function uninstall($parent) {
		define('_MMP_HACK', 1);
		require_once('uninstall.metamodpro.php');
	}	
}
