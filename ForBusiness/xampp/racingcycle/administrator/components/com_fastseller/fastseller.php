<?php
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// ini_set('display_errors', 1);

$base = JURI::base();
//$base = '/administrator/';

$root = JURI::root();

define('FS_AJAX', $base .'components/com_fastseller/ajax/ajax.php');
define('FS_PATH', JPATH_BASE .'/components/com_fastseller/');

require(FS_PATH .'controllers/FSConf.php');
FSConf::getConfiguration();

require('defines.php');


$doc = JFactory::getDocument();
$doc->setTitle('Fast Seller');
//$mainframe->getCfg('sitename')

$doc->addStyleSheet($base .'components/com_fastseller/static/css/style.css');
$doc->addScript($root .'media/system/js/mootools-core.js');
$doc->addScript($root .'media/system/js/mootools-more.js');

require(JPATH_COMPONENT . DIRECTORY_SEPARATOR .'controllers'. DIRECTORY_SEPARATOR .'FSLayout.php');
FSLayout::prepare();


?>
<div id="cmainnav">
	<div class="fs-logo" style="margin:0px 15px 0 0px;vertical-align:middle;display:inline-block"></div>
	<button class="ui-main-nav" data-url="i=HOME">Home</button>
	<button class="ui-main-nav" data-url="i=ASSIGN">Assign Filters</button>
	<button class="ui-main-nav" data-url="i=CREATE">Create Filters</button>
	<button class="ui-main-nav" data-url="i=CONF">Options</button>
	<button class="ui-main-nav" data-url="i=HELP">Help</button>
<?php
	if (JVERSION < 3.1)
		echo '<button class="ui-removetop" id="hideTop" title="Hide/Show top">&uarr;&darr;</button>';
?>
</div>
<div id="cstatus" class="cstatus hid">Loading..<br/><img src="<?php echo $base ?>components/com_fastseller/static/img/load.gif" /></div>
<div id="clayout"></div>
<script type="text/javascript">
var url = '<?php echo FS_AJAX ?>';
<?php 
	require(FS_PATH .'static/js/main.js');
?>
</script>
