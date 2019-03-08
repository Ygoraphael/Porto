<?php 
/*
* Pixel Point Creative - Simple Spotlight
* License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* Copyright (c) Pixel Point Creative LLC.
* More info at http://www.pixelpointcreative.com
* Last Updated: 5/8/13
*/
// no direct access
defined('_JEXEC') or die ;

class JFormFieldUpgradecheck extends JFormField {
	
	var   $_name = 'Upgradecheck';
	
	protected function getInput()
	{
		return ' ';
	}	
	
	protected function getLabel()
	{
		//check for cURL support before we do anyting esle.
		if(!function_exists("curl_init")) return 'cURL is not supported by your server. Please contact your hosting provider to enable this capability.';
		//If cURL is supported, check the current version available.
		else 
				$version = 3.1;
				$target = 'http://www.pixelpointcreative.com/upgradecheck/simplespotlight/index.txt';
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $target);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_HEADER, false);
				$str = curl_exec($curl);
				curl_close($curl);
				
						
				$message = '<div><label style="max-width:100%"><b>Installed Version '.$version.'</b> ';
				
				//If the current version is out of date, notify the user and provide a download link.
				if ($version < $str)
					$message = $message . '&nbsp;&nbsp;|&nbsp;&nbsp;<b>Latest Version '.$str.'</b><br />
					<a href="index.php?option=com_installer&view=update">Update</a> &nbsp;&nbsp;|&nbsp; &nbsp;<a href="http://www.pixelpointcreative.com/support.html" target="_blank">Get Help</a> &nbsp;&nbsp;|&nbsp;&nbsp;<a href="http://www.pixelpointcreative.com/changelogs/simplespotlight.txt" target="_blank">View the Changelog</a></label></div>';
				//If the current version is up to date, notify the user. 	
				elseif (($version == $str) || ($version > $str))
				$message = $message . '</br>There are no updates available at this time.</br>Having Trouble?  <a href="http://www.pixelpointcreative.com/support.html" target="_blank">Get Help</a> </label></div>';
				echo'<div><img width="160" height="85" border="0" src="../modules/mod_ppc_simple_spotlight/elements/logo.png" title="Simple Spotlight" alt="Simple Spotlight"></div>';  
				return 
				$message;
				
											
	  }
}
