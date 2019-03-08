<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$conf->initAssistOptions();

$messageType = JRequest::getVar('message', null);

if ($messageType == 'first_run_confirm') {

	$conf->setAssist('cp_first_run', 0);

	// get and save current version of Virtuemart
	require_once(JPATH_ADMINISTRATOR .'/components/com_virtuemart/version.php');
	$vmVersion = vmVersion::$RELEASE;
	$conf->setAssist('vm_version', $vmVersion);

	$result = $conf->writeAssistConfigurationToFile();
	echo $result;

} else if ($messageType == 'vm_version_change') {

	require_once(JPATH_ADMINISTRATOR .'/components/com_virtuemart/version.php');
	$vmVersion = vmVersion::$RELEASE;
	$conf->setAssist('vm_version', $vmVersion);

	$result = $conf->writeAssistConfigurationToFile();
	echo $result;
}
