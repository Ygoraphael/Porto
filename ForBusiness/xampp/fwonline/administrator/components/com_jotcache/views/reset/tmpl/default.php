<?php
/*
 * @version $Id: default.php,v 1.30 2014/06/07 12:15:07 Jot Exp $
 * @package JotCache
 * @category Joomla 2.5
 * @copyright (C) 2010-2014 Vladimir Kanich
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.database.table');
$site_path = JPATH_SITE;
$site_url = JURI::root();
$img_dir = $site_url . "administrator/components/com_jotcache/assets/images/";
$document = JFactory::getDocument();
$user = JFactory::getUser();
$canManage = $user->authorise('core.manage', 'com_jotcache') && $user->authorise('jotcache.manage', 'com_jotcache');
$cacheplg = JPluginHelper::getPlugin('system', 'jotcache');
$plg_disabled = true;
$front_classes = array('front-off', 'front-off', 'front-off');
if (is_object($cacheplg)) {
$plg_disabled = false;
$pars = json_decode($cacheplg->params);
$cachemark = $pars->cachemark;
$cookie_mark = JRequest::getVar('jotcachemark', '0', 'COOKIE', 'INT');
}Jhtml::_('behavior.tooltip');
JToolBarHelper::title(JText::_('JOTCACHE_RS_TITLE'), 'jotcache-logo.gif');
$bar = JToolBar::getInstance('toolbar');
$msg = JText::_('JOTCACHE_RS_REFRESH_DESC');
JToolBarHelper::custom('refresh', 'refresh.png', 'refresh.png', JText::_('JOTCACHE_RS_REFRESH'), false);
if ($this->data->fastdelete) {
JToolBarHelper::custom('delete', 'delete.png', 'delete.png', JText::_('JOTCACHE_RS_DELETE'), false);
} else {
JToolBarHelper::deleteList(JText::_('JOTCACHE_RS_DEL_CONFIRM'), 'delete', JText::_('JOTCACHE_RS_DELETE'));
}JToolBarHelper::custom('deleteall', 'deleteall.png', 'deleteall.png', JText::_('JOTCACHE_RS_DELETE_ALL'), false);
JToolBarHelper::custom('recache', 'recache.png', 'recache.png', JText::_('JOTCACHE_RS_RECACHE'), false);
JToolBarHelper::spacer('35px');
if ($canManage) {
JToolBarHelper::customX('exclude', 'unpublish.png', 'unpublish.png', JText::_('JOTCACHE_RS_EXCL'), false);
JToolBarHelper::customX('tplex', 'tplex.png', 'tplex.png', JText::_('JOTCACHE_RS_TPL_EXCL'), false);
JToolBarHelper::customX('bcache', 'bcache.png', 'bcache.png', JText::_('JOTCACHE_RS_BCACHE'), false);
JToolBarHelper::spacer('35px');
JToolBarHelper::preferences('com_jotcache', '500');
}$bar->appendButton('Popup', 'help', 'Help', $this->help_site . "management", 960, 600, 0, 0);
$mode = $this->data->mode;
if (is_object($cacheplg) && isset($pars->cachecookies)) {
$showcookies = $pars->cachecookies && $this->data->showcookies;
} else {
$showcookies = false;
}if (is_object($cacheplg) && isset($pars->cachesessionvars)) {
$showsessionvars = $pars->cachesessionvars && $this->data->showsessionvars;
} else {
$showsessionvars = false;
}$colrange = 4;
$colrange = ($showcookies) ? $colrange + 1 : $colrange;
$colrange = ($showsessionvars) ? $colrange + 1 : $colrange;
$showcolumn = ($this->data->showfname) ? $colrange + 1 : $colrange;
$status_class = 'status ';
$status_title = JText::_('JOTCACHE_RS_PLUGIN_NORMAL');
if ($plg_disabled) {
  $status_class.='status-warning';
$status_title = JText::_('JOTCACHE_RS_PLUGIN_WARNING');
} else {
if ($this->lists['last']) {
    $status_class.='status-attention';
$status_title = JText::_('JOTCACHE_RS_PLUGIN_ATTENTION');
} else {
    $status_class.='status-normal';
}}$clear_class = 'status status-normal';
$clear_title = JText::_('JOTCACHE_RS_CLEAR_NORMAL');
if ($this->status['clear'] === 0) {
$clear_class = 'status status-special';
$clear_title = JText::_('JOTCACHE_RS_CLEAR_SPECIAL');
;}$status_img = '<img src="' . $img_dir . 'plugin.png" class="' . $status_class . '" alt="' . $status_title . '" title="' . $status_title . '"/>';
$status_glob = '<img src="' . $img_dir . 'global.png" class="' . $this->status['gclass'] . '" alt="' . $this->status['gtitle'] . '" title="' . $this->status['gtitle'] . '"/>';
$status_clear = '<img src="' . $img_dir . 'clear.png" class="' . $clear_class . '" alt="' . $clear_title . '" title="' . $clear_title . '"/>';
?>
<script language="javascript" type="text/javascript">
  /*  function resetSelect() {
   document.getElementById("filter_view").value="";
   document.adminForm.submit();
   } */
  Joomla.submitbutton = function(task) {
    if (task == 'deleteall') {
      if (confirm("<?php echo JText::_('JOTCACHE_RS_DELETE_ALL_CONFIRM'); ?>") != true) {
        return;
      }
    }
    jotcache.submitform(task);
    /*    Joomla.submitform(task); */
  };
  Joomla.submitform = function(task, form) {
    jotcache.submitform(task, form);
  };
</script>
<style type="text/css">
  .icon-32-cookie {
    background-image:url(<?php echo $icon_cookie; ?>);
  }
  #toolbar-box .m {
    min-height: 70px !important;
  }
</style>
<table class="statuslist">
  <tr>
    <?php if ($canManage) { ?>
      <td>
        <div class="status-title">Status </div>
        <a target="_blank" href="<?php echo JRoute::_('index.php?option=com_plugins&task=plugin.edit&extension_id=' . $this->lists['plgid']); ?>">
          <?php echo $status_img; ?>
        </a>
        <a target="_blank" href="<?php echo JRoute::_('index.php?option=com_config'); ?>">
          <?php echo $status_glob; ?>
        </a>
        <a target="_blank" href="<?php echo JRoute::_('index.php?option=com_cache'); ?>">
          <?php ?>
          <?php echo $status_clear; ?>
        </a>
      </td>
    <?php } ?>
    <td>
      <span class="status-title" style="padding-left: 20px;">Frontend</span>
      <?php
      for ($i = 1; $i < 4; $i++) {
echo $this->marks[$i];
}?>
    </td>
  </tr>
</table>
<form action="<?php echo JRoute::_('index.php?option=com_jotcache'); ?>" method="post" name="adminForm" id="adminForm">
  <table class="adminlist">
    <thead>
      <tr>
        <td nowrap colspan="3" class="no-border-select"><?php echo JText::_('JOTCACHE_RS_SEARCH') . " : "; ?>
          <input type="text" name="search" id="search" value="<?php echo $this->lists['search']; ?>" class="text_area" onChange="jotcache.resetSelect(0);" />
          <?php echo $this->lists['reset']; ?>
          <button onclick="this.form.submit();"><?php echo JText::_('Go'); ?></button>
        </td>
        <td class="no-border-select"><?php echo $this->lists['com']; ?></td>
        <td class="no-border-select"><?php echo $this->lists['view']; ?></td>
        <td class="no-border-select" colspan="<?php echo $showcolumn; ?>" >&nbsp;</td>
        <td class="no-border-select"><?php echo $this->lists['mark']; ?></td>
      </tr>
      <tr><th width="50">#</th>
        <th width="5"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->data->rows); ?>);" /></th>
        <th class="title"><?php
          if ($mode) {
echo JHTML::_('grid.sort', 'JOTCACHE_RS_UTITLE', 'm.uri', @$this->lists['order_Dir'], @$this->lists['order']);
} else {
echo JHTML::_('grid.sort', 'JOTCACHE_RS_PTITLE', 'm.title', @$this->lists['order_Dir'], @$this->lists['order']);
}?></th>
        <?php if ($this->data->showfname) { ?>
          <th nowrap="true"><?php echo JText::_('JOTCACHE_RS_FNAME'); ?></th>
        <?php } ?>
        <th nowrap="nowrap"><?php echo JText::_('JOTCACHE_RS_COMP'); ?></th>
        <th nowrap="true"><?php echo JText::_('JOTCACHE_RS_VIEW'); ?></th>
        <th><?php echo Jhtml::_('grid.sort', 'JOTCACHE_RS_ID', 'm.id', $this->lists['order_Dir'], $this->lists['order']); ?></th>
        <th nowrap="nowrap"><?php echo Jhtml::_('grid.sort', 'JOTCACHE_RS_CREATED', 'm.ftime', $this->lists['order_Dir'], $this->lists['order']); ?></th>
        <th nowrap="nowrap"><?php echo Jhtml::_('grid.sort', 'JOTCACHE_RS_LANG', 'm.language', @$this->lists['order_Dir'], @$this->lists['order']); ?></th>
        <th nowrap="nowrap"><?php echo Jhtml::_('grid.sort', 'JOTCACHE_RS_BROWSER', 'm.browser', @$this->lists['order_Dir'], @$this->lists['order']); ?></th>
        <?php if ($showcookies) { ?>
          <th nowrap="nowrap"><?php echo JText::_('JOTCACHE_RS_COOKIES'); ?></th>
        <?php } ?>
        <?php if ($showsessionvars) { ?>
          <th nowrap="nowrap"><?php echo JText::_('JOTCACHE_RS_SESSIONVARS'); ?></th>
        <?php } ?>
        <th nowrap="nowrap"><?php echo JText::_('JOTCACHE_RS_MARK'); ?></th>
      </tr>
    </thead>
    <?php
    $rows = $this->data->rows;
$k = 0;
for ($i = 0, $n = count($rows); $i < $n; $i++) {
$row = $rows[$i];
$checked = '<input type="checkbox" onclick="isChecked(this.checked);" value="' . $row->fname . '" name="cid[]" id="cb' . $i . '">';
      $expired = strlen($row->ftime) > 20 ? ' style="font-style: italic;"' : '';
      $mark_qs = '';
if ($row->mark == 1) {
if (strlen($row->qs) > 0) {
$qitems = unserialize($row->qs);
foreach ($qitems as $key => $value) {
if ($mark_qs != '')
$mark_qs.='&';
$mark_qs.=$key . '=' . $value;
}$mark_qs = $site_url . 'index.php?' . $mark_qs;
$mark_qs = '<a href="' . $mark_qs . '" target="_blank">' . JText::_('JOTCACHE_RS_SEL_MARK_YES') . '</a>';
}else {
$mark_qs = JText::_('JOTCACHE_RS_SEL_MARK_YES');
}}?>
      <tr class="<?php echo "row$k"; ?>" <?php echo $expired; ?>>
        <td align="right"><?php echo $this->data->pageNav->getRowOffset($i); ?></td>
        <td align="center"><?php echo $checked; ?></td>
        <?php if ($mode) { ?>
          <td><a href="<?php echo $row->uri; ?>" target="_blank" title="<?php echo $row->title; ?>"><?php echo $row->uri; ?></a></td>
        <?php } else { ?>
          <td><a href="<?php echo $row->uri; ?>" target="_blank"><?php echo $row->title; ?></a></td>
        <?php } ?>
        <?php if ($this->data->showfname) { ?>
          <td><a href="<?php echo JRoute::_('index.php?option=com_jotcache&view=reset&task=debug&mode=preview&fname=' . $row->fname); ?>" target="_top" title="<?php echo $row->title; ?>"><?php echo $row->fname; ?></a></td>
        <?php } ?>
        <td><?php echo $row->com; ?></td>
        <td><?php echo $row->view; ?></td>
        <td align="right" style="padding-right:30px;"><?php echo $row->id; ?></td>
        <td align="center"><?php echo $row->ftime; ?></td>
        <td align="center"><?php echo $row->language; ?></td>
        <td align="center"><?php echo $row->browser; ?></td>
        <?php
        if ($showcookies) {
$rcookies = substr($row->cookies, 1);
$cookies = explode('#', $rcookies);
?>
          <td align="center"><table class="showcookies"><?php
              foreach ($cookies as $cookie) {
echo '<tr><td  style="border:0px;">' . $cookie . '</td></tr>';
}?></table></td>
        <?php } ?>
                  <?php
        if ($showsessionvars) {
$rcookies = substr($row->sessionvars, 1);
$cookies = explode('#', $rcookies);
?>
          <td align="center"><table class="showcookies"><?php
              foreach ($cookies as $cookie) {
echo '<tr><td  style="border:0px;">' . $cookie . '</td></tr>';
}?></table></td>
        <?php } ?>
        <td align="center"><?php echo $mark_qs; ?></td>
      </tr>
      <?php
      $k = 1 - $k;
}?>
  </table>
  <br/>
  <?php echo $this->data->pageNav->getListFooter(); ?>
  <input type="hidden" id="form_view" name="view" value="reset" />
  <input type="hidden" id="form_task" name="task" value="" />
  <input type="hidden" name="boxchecked" value="0" />
  <input type="hidden" name="hidemainmenu" value="0" />
  <input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
  <input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</form>