<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require(FS_PATH .'models/FSHomeModel.php');

FSHomeModel::showFrontPageStats();

?>