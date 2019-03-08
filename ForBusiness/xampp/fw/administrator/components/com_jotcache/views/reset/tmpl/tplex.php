<?php
/*
 * @version $Id: tplex.php,v 1.6 2014/02/16 12:52:00 Jot Exp $
 * @package JotCache
 * @category Joomla 2.5
 * @copyright (C) 2010-2014 Vladimir Kanich
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
$site_url = JURI::root();
JHTML::_('behavior.tooltip');
JToolBarHelper::title(JText::_('JOTCACHE_TPLEX_TITLE'), 'jotcache-logo.gif');
$bar = JToolBar::getInstance('toolbar');
$msg = JText::_('JOTCACHE_RS_REFRESH_DESC');
JToolBarHelper::customX('tplapply', 'apply.png', 'apply.png', 'Apply', false);
JToolBarHelper::spacer();
JToolBarHelper::custom('tplsave', 'save.png', 'save.png', 'Save', false);
JToolBarHelper::spacer();
JToolBarHelper::cancel('close', JText::_('CLOSE'));
JToolBarHelper::spacer();
$bar->appendButton('Popup', 'help', 'Help', $this->help_site . "exclusion", 960, 600, 0, 0);
$rows = $this->lists['pos'];
?>
<style type="text/css">
  .icon-48-jotcache-logo {
    background-image:url(<?php echo $site_url . "administrator/components/com_jotcache/images/jotcache-logo-j16-2.png"; ?>);
  }
  table.adminlist thead tr td.no-border-select {
    outline-style:solid;
    outline-width:1px;
    outline-color:white;
    background-color:white;
  }
</style>
<form action="index.php" method="post" name="adminForm" id="adminForm">
  <div style="margin-bottom:15px; "><h3><?php echo JText::_('JOTCACHE_TPLEX_INFO'); ?></h3></div>
  <table class="adminlist" style="width:30%;">
    <thead>
      <tr>
        <th nowrap="nowrap" width="120"><input type="checkbox" name="toggle" value=""  onclick="checkAll(<?php echo count($rows); ?>);" />&nbsp;<?php echo JText::_('JOTCACHE_EXCLUDE_EXCLUDED'); ?></th>
        <th nowrap="nowrap"><?php echo JText::_('JOTCACHE_TPLEX_POS'); ?></th>
      </tr>
    </thead>
    <?php
    $k = 0;
foreach ($rows as $key => $value) {
$row = $value;
$checking = array_key_exists($row, $this->lists['value']) ? "checked" : "";
$checked = '<input type="checkbox" id="cb' . $key . '" name="cid[]" value="' . $row . '" ' . $checking . ' onclick="jotcache.valoff(this);isChecked(this.checked);" />';
?>
      <tr class="<?php echo "row$k"; ?>">
        <td align="center"><?php echo $checked; ?></td>
        <td><?php echo $row; ?></td>
      </tr>
      <?php
      $k = 1 - $k;
}?>
  </table>
  <br/>
  <input type="hidden" name="option" value="com_jotcache" />
  <input type="hidden" name="view" value="reset" />
  <input type="hidden" name="task" value="tplex" />
  <input type="hidden" name="boxchecked" value="0" />
  <input type="hidden" name="hidemainmenu" value="0" />
</form>