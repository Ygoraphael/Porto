<?php
/*
 * @version $Id: bcache.php,v 1.7 2013/09/25 07:33:15 Jot Exp $
 * @package JotCache
 * @category Joomla 2.5
 * @copyright (C) 2010-2014 Vladimir Kanich
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');
JToolBarHelper::title(JText::_('JOTCACHE_BCACHE_TITLE'), 'jotcache-logo.gif');
$site_url = JURI::root();
$bar = JToolBar::getInstance('toolbar');
$msg = JText::_('JOTCACHE_RS_REFRESH_DESC');
JToolBarHelper::customX('bcapply', 'apply.png', 'apply.png', 'Apply', false);
JToolBarHelper::spacer();
JToolBarHelper::custom('bcsave', 'save.png', 'save.png', 'Save', false);
JToolBarHelper::spacer();
JToolBarHelper::deleteList(JText::_('JOTCACHE_RS_DEL_CONFIRM'), 'bcdelete');
JToolBarHelper::spacer();
JToolBarHelper::cancel('display', JText::_('CLOSE'));
JToolBarHelper::spacer();
$bar->appendButton('Popup', 'help', 'Help', $this->help_site . "browser_caching", 960, 600, 0, 0);
?>
<style type="text/css">
  .icon-48-jotcache-logo {
    background-image:url(<?php echo $site_url."administrator/components/com_jotcache/images/jotcache-logo-j16-2.png"; ?>);
  }
</style>
<form action="index.php" method="post" name="adminForm" id="adminForm">
  <table class="adminlist" style="width:60%;">
    <thead>
      <tr>
        <th nowrap="nowrap" width="120"><input type="checkbox" name="toggle" value=""  onclick="checkAll(20);" /></th>
        <th align="center"><?php echo JText::_('JOTCACHE_BCACHE_URI'); ?></th>
        <th title="<?php echo JText::_('JOTCACHE_BCACHE_TIME'); ?>"><?php echo JText::_('JOTCACHE_BCACHE_TIME'); ?></th>
      </tr>
    </thead>
    <?php
    $rows = $this->data;
$stop = count($rows);
$k = 0;
for ($i = 0, $n = 20; $i < $n; $i++) {
if ($i >= $stop) {
$id = 0;
$uri = '';
$time = '';
$pfx = "ix".$i;
$pfy = "iy".$i;
} else {
$row = &$rows[$i];
$id = $row->id;
$uri = $row->value;
$time = $row->name;
$pfx = "ux".$id;
$pfy = "uy".$id;
}$checked = '<input type="checkbox" id="cb' . $i . '" name="cid[]" value="' . $id . '" onclick="isChecked(this.checked);" />';
?>
      <tr class="<?php echo "row$k"; ?>">
        <td align="center"><?php echo $checked; ?></td>
        <td><input id="<?php echo "$pfx"; ?>" name="<?php echo "$pfx"; ?>" size="100" value="<?php echo $uri; ?>" ></td>
        <td><input id="<?php echo "$pfy"; ?>" name="<?php echo "$pfy"; ?>" size="30" value="<?php echo $time; ?>" ></td>
      </tr>
      <?php
      $k = 1 - $k;
}?>
  </table>
  <br/>
  <input type="hidden" name="option" value="com_jotcache" />
  <input type="hidden" name="view" value="reset" />
  <input type="hidden" name="task" value="bcache" />
  <input type="hidden" name="boxchecked" value="0" />
  <input type="hidden" name="hidemainmenu" value="0" />
</form>