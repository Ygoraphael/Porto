<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$productsCount = FSAssignFiltersModel::getProductsCount();

$keyword = JRequest::getVar('q', null);

$showonpage = FSConf::get('products_num_on_page');
$onpage_url = (int)JRequest::getCmd('showonpage', null);
$session_onpage = (isset($_COOKIE['onpage'])) ? $_COOKIE['onpage'] : null;
if ($onpage_url) {
	$showonpage = $onpage_url;
} else if ($session_onpage) {
	$showonpage = $session_onpage;
}


$skip = intval(JRequest::getCmd('skip', 0));
$cid = JRequest::getVar('cid', null);
$ptid = JRequest::getVar('ptid', null);
$orderby = JRequest::getVar('orderby', null);
$scending = JRequest::getVar('sc', null);
$ppid = JRequest::getVar('ppid', null);


$page = $skip / $showonpage + 1;
$pagesNumber = ($productsCount == 0) ? 1 : ceil($productsCount / $showonpage);


$url = 'i='. JRequest::getCmd('i', '');
if ($keyword) $url .= '&q='. urlencode($keyword);
if ($cid) $url .= '&cid='. $cid;
if ($ptid) $url .= '&ptid='. $ptid;
if ($orderby) $url .= '&orderby='. $orderby;
if ($scending) $url .= '&sc='. $scending;
if ($ppid) $url .= '&ppid='. $ppid;

$urla = $url;
if ($onpage_url) $urla .= '&showonpage='. $showonpage;

if ($pagesNumber > 11) {
	$startdelta = $page - 4;
	if ($startdelta > 1) {
		$start = $startdelta;
		$startdelta = 0;
	} else {
		$start = 2;
		if ($startdelta != 1) {
			$startdelta = abs($startdelta) + 2;
		}
	}

	$enddelta = $pagesNumber - ($page + 4);

	if ($enddelta > 0) {
		$end = $page + 4;
		$enddelta = 0;
	} else {
		$end = $pagesNumber - 1;
		$enddelta = abs($enddelta) + 1;
	}

	//echo 'start:'.$start;
	//echo 'end:'.$end;
	if ($startdelta && !$enddelta) {
		$end = ($end + $startdelta < $pagesNumber) ? $end + $startdelta : $pagesNumber - 1;
	} else if (!$startdelta && $enddelta) {
		$start = ($start - $enddelta < 2) ? 2 : $start - $enddelta;
	}
	//echo 'start2:'.$start;
	//echo 'end2:'.$end;

	$first = ($page > 6) ? 'First' : '1';
	echo '<button class="page-nav-element ';
	echo ($page == 1) ? 'selected' : 'available';
	echo '" data-href="'. $urla .'&skip=0" data-skip="0" type="button"><span>'. $first .'</span></button>';

	for ($i = $start; $i <= $end; $i++) {
		$sk = ($i - 1) * $showonpage;
		echo '<button class="page-nav-element ';
		echo ($page == $i) ? 'selected' : 'available';
		echo '" data-href="'. $urla .'&skip='. $sk .'" data-skip="'.$sk.'" type="button"><span>'. $i .'</span></button>';
	}

	$last = ($pagesNumber - 5 > $page) ? 'Last ('. $pagesNumber .')' : $pagesNumber;
	$sk = ($pagesNumber - 1) * $showonpage;
	echo '<button class="page-nav-element ';
	echo ($page == $pagesNumber) ? 'selected' : 'available';
	echo '" data-href="'. $urla .'&skip='. $sk .'" data-skip="'.$sk.'" type="button"><span>'. $last .'</span></button>';

} else {

	for ($i = 1; $i <= $pagesNumber; $i++) {
		$sk = ($i - 1) * $showonpage;
		echo '<button class="page-nav-element ';
		echo ($i == $page) ? 'selected' : 'available';

		echo '" data-href="'. $urla .'&skip='. $sk .'" data-skip="'. $sk .'" type="button"><span>'. $i .'</span></button>';
	}

}

if ($page > $pagesNumber)
	echo '<span style="font-size:12px;font-weight:bold;vertical-align:middle;padding-left:10px;">'. $page .'</span>';

$urlb = $url .'&showonpage=';

echo '<div class="fsShowonpage"><button type="button" id="showOnPageButton" class="glass-btn">'.
	'Show on page: <span>'. $showonpage .'</span></button>';

// <td><a href="#'. $urlb .'1" class="showonpage-menu-item">1</a></td>

echo '<div class="popmenu hid" id="showonpage-menu">
	<table cellpadding="0"><tr>
	<td><a href="#'. $urlb .'5" class="showonpage-menu-item">5</a></td>
	<td><a href="#'. $urlb .'10" class="showonpage-menu-item">10</a></td>
	<td><a href="#'. $urlb .'15" class="showonpage-menu-item">15</a></td>
	<td><a href="#'. $urlb .'20" class="showonpage-menu-item">20</a></td>
	<td><a href="#'. $urlb .'25" class="showonpage-menu-item">25</a></td>
	<td><a href="#'. $urlb .'30" class="showonpage-menu-item">30</a></td>
	<td><a href="#'. $urlb .'50" class="showonpage-menu-item">50</a></td>
	</tr></table>
</div></div>';


?>
