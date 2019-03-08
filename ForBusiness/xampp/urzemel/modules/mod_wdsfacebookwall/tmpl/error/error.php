<?php
/**------------------------------------------------------------------------
03.# mod_wdsfacebookwall - WDS Facebook Wall for Joomla! 2.5, 3.X
04.# ------------------------------------------------------------------------
05.# author    Robert Long
06.# copyright Copyright (C) 2013 Webdesignservices.net. All Rights Reserved.
07.# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
08.# Websites: http://www.webdesignservices.net
09.# Technical Support:  Support - https://www.webdesignservices.net/support/customer-support.html
10.------------------------------------------------------------------*/
// no direct access
	defined('_JEXEC') or die;
?>

<div id="wds">
<?php if(isset($curlDisabled)): ?>
Your PHP doesn't have cURL extension enabled. Please contact your host and ask them to enable it.
<?php else: ?>
It seems that module parameters haven't been configured properly. Please make sure that you are using a valid twitter username, and
that you have inserted the correct keys. Detailed instructions are written in the module settings page.
<?php endif; ?>
</div>
