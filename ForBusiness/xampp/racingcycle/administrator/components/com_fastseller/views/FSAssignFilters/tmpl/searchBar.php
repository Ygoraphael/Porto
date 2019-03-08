<?php
defined( '_JEXEC' ) or die( 'Restricted access' );


$q = JRequest::getVar('q', null);
$showonpage = JRequest::getVar('showonpage', null);
$cid = JRequest::getVar('cid', null);
$ptid = JRequest::getVar('ptid', null);
$ppid = JRequest::getVar('ppid', null);
$orderby = JRequest::getVar('orderby', null);
//$scending = JRequest::getVar('sc', 'Asc');	// Ascending, Descending order
$scending = JRequest::getVar('sc', null);	// Ascending, Descending order

?>
<div id="searchBarContainer">
<div class="search-logo" onclick="document.searchForm.q.focus();">Search</div>
<form name="searchForm" id="searchForm" action="index.php" method="get" style="display:inline-block;">
	<input type="hidden" name="option" value="com_fastseller" />
	<input type="hidden" name="showonpage" value="<?php if ($showonpage) echo $showonpage;?>" />
	<input type="hidden" name="cid" value="<?php if ($cid) echo $cid;?>" />
	<input type="hidden" name="ptid" value="<?php if ($ptid) echo $ptid;?>" />
	<input type="hidden" name="orderby" value="<?php if ($orderby) echo $orderby;?>" />
	<input type="hidden" name="sc" value="<?php if ($scending) echo $scending ?>" />
	<input type="hidden" name="ppid" value="<?php if ($ppid) echo $ppid ?>" />
	<input type="hidden" name="skip" value="" />
	<input type="hidden" name="old_skip" value="" />

	<div style="width:550px;">
	<table cellspacing="0" cellpadding="0" border="0" style="border-collapse:separate;"><tr>
	<td width="100%" class="fsSearch-td" style="border-left:2px solid #AAAAAA;">
		<input class="fsSearch" type="text" name="q" value="<?php echo $q ?>" autocomplete="off" />
	</td><td class="fsSearch-td" style="padding:0 5px 0 10px;">
		<span id="search-xbtn" class="<?php echo ($q)? '' : 'hid' ?>" >Remove</span></td>
	<td><button type="submit" class="search-btn">
		<img src="<?php echo FS_URL ?>static/img/search.png" width="25" height="20" /></button></td>
	</tr></table>
	<div id="productsFound">Matches ..</div>
	</div>
</form>
</div>
