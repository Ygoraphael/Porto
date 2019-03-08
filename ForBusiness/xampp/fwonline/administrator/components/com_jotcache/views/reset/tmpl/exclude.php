<?php
/*
 * @version $Id: exclude.php,v 1.8 2013/09/25 07:33:15 Jot Exp $
 * @package JotCache
 * @category Joomla 2.5
 * @copyright (C) 2010-2014 Vladimir Kanich
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');
JToolBarHelper::title(JText::_('JOTCACHE_EXCLUDE_TITLE'), 'jotcache-logo.gif');
$site_url = JURI::root();
$bar = JToolBar::getInstance('toolbar');
$msg = JText::_('JOTCACHE_RS_REFRESH_DESC');
JToolBarHelper::customX('apply', 'apply.png', 'apply.png', 'Apply', false);
JToolBarHelper::spacer();
JToolBarHelper::custom('save', 'save.png', 'save.png', 'Save', false);
JToolBarHelper::spacer();
JToolBarHelper::cancel('display', JText::_('CLOSE'));
JToolBarHelper::spacer();
$bar->appendButton('Popup', 'help', 'Help', $this->help_site."exclusion", 960, 600, 0, 0);
$rows = $this->data->rows;
?>
<script language="javascript" type="text/javascript">
  function submitbutton(pressbutton) {
    if (pressbutton == 'save'||pressbutton == 'apply') {
      if(!jotcache.pressed()){alert( "<?php echo JText::_('JOTCACHE_EXCLUDE_ERR'); ?>"); return;}
    }
    submitform( pressbutton );
  }
  window.addEvent('domready', function(){
    var lang =["<?php echo JText::_('JOTCACHE_EXCLUDE_ERR1'); ?>","<?php echo JText::_('JOTCACHE_EXCLUDE_ERR2'); ?>"];
    jotcache.init(lang);
  });
</script>
<style type="text/css">
  .icon-48-jotcache-logo {
    background-image:url(<?php echo $site_url."administrator/components/com_jotcache/images/jotcache-logo-j16-2.png"; ?>);
  }
</style>
<form action="index.php" method="post" name="adminForm">
  <table class="adminlist" style="width:60%;">
    <thead>
      <tr>
        <th nowrap="nowrap" width="120"><input type="checkbox" name="toggle" value=""  onclick="checkAll(<?php echo count($rows); ?>);" />&nbsp;<?php echo JText::_('JOTCACHE_EXCLUDE_EXCLUDED'); ?></th>
        <th nowrap="nowrap"><?php echo JText::_('JOTCACHE_EXCLUDE_CN'); ?></th>
        <th><?php echo JText::_('JOTCACHE_EXCLUDE_OPTION'); ?></th>
        <th title="<?php echo JText::_('JOTCACHE_EXCLUDE_VIEWS_DESC'); ?>"><?php echo JText::_('JOTCACHE_EXCLUDE_VIEWS'); ?></th>
      </tr>
    </thead>
    <?php
    $rows = $this->data->rows;
$k = 0;
for ($i = 0, $n = count($rows); $i < $n; $i++) {
$row = $rows[$i];
$checking = array_key_exists($row->option, $this->data->exclude) ? "checked" : "";
$checked = '<input type="checkbox" id="cb'.$i.'" name="cid[]" value="'.$row->id.'" '.$checking.' onclick="isChecked(this.checked);" />';
?>
      <tr class="<?php echo "row$k"; ?>">
        <td align="center"><?php echo $checked; ?></td>
        <td><?php echo $row->name; ?></td>
        <td><?php echo $row->option; ?></td>
        <td><?php if ($checking and $this->data->exclude[$row->option] != 1) { ?>
            <input name="<?php echo "ex_$row->option"; ?>" size="100" value="<?php echo $this->data->exclude[$row->option]; ?>" >
          <?php } else { ?>
            <input name="<?php echo "ex_$row->option"; ?>" size="100" value="" >
          <?php } ?>
        </td>
      </tr>
      <?php $k = 1 - $k;
} ?>
  </table>
  <br/>
  <?php echo $this->data->pageNav->getListFooter(); ?>
  <input type="hidden" name="option" value="com_jotcache" />
  <input type="hidden" name="view" value="reset" />
  <input type="hidden" name="task" value="exclude" />
  <input type="hidden" name="boxchecked" value="0" />
  <input type="hidden" name="hidemainmenu" value="0" />
</form>