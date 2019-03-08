<?php
/*
 * @version $Id: default.php,v 1.12 2013/10/04 10:25:03 Jot Exp $
 * @package JotCache
 * @category Joomla 2.5
 * @copyright (C) 2010-2014 Vladimir Kanich
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
$site_url = JURI::root();
JHTML::_('behavior.tooltip');
JHTML::_('behavior.keepalive');
JToolBarHelper::title(JText::_('JOTCACHE_RECACHE_TITLE'), 'jotcache-logo.gif');
$bar = JToolBar::getInstance('toolbar');
JToolBarHelper::custom('start', 'start.png', 'start.png', JText::_('JOTCACHE_RECACHE_START'), false);
JToolBarHelper::spacer();
JToolBarHelper::custom('stop', 'stop.png', 'stop.png', JText::_('JOTCACHE_RECACHE_STOP'), false);
JToolBarHelper::spacer();
JToolBarHelper::spacer();
JToolBarHelper::spacer();
JToolBarHelper::cancel('close', JText::_('CLOSE'));
JToolBarHelper::spacer();
$bar->appendButton('Popup', 'help', 'Help', $this->help_site . "recache_use", 960, 600, 0, 0);
$scope = 'all';
if ($this->filter['search'] || $this->filter['com'] || $this->filter['view'] || $this->filter['mark']) {
$scope = 'sel';
}if ($this->filter['chck']) {
$scope = 'chck';
}?>
<script language="javascript" type="text/javascript">
  var jotcachereq="<?php echo JRoute::_($site_url . 'administrator/index.php?option=com_jotcache&view=recache&task=status&format=raw') ?>";
  var jotcacheflag = 1;
  var jotcacheform = "adminForm";
  Joomla.submitbutton = function(task){
    if (task == 'close') {
      self.close();
    }else{
      if (task == 'start') {
        jotcacheajax.again();
      }
      if (task == 'stop') {
        jotcacheflag = 0;
        return;
      }
      Joomla.submitform(task,document.getElementById(jotcacheform));
    }
  }
</script>
<table class="statuslist"><tr><td class="status-title">Status</td><td >&nbsp;</td>
    <td id="message-here"/>
  </tr></table>
<?php
$options = array(
'onActive' => 'function(title, description){
        description.setStyle("display", "block");
        title.addClass("open").removeClass("closed");
        jotcacheform = "adminForm_"+title.get("text");
    }',
'onBackground' => 'function(title, description){
        description.setStyle("display", "none");
        title.addClass("closed").removeClass("open");
    }',
'startOffset' => 0,     'useCookie' => true, );
if (count($this->plugins) > 0) {
echo JHtml::_('tabs.start', 'recache-tabs', $options);
foreach ($this->plugins as $plugin) {
echo JHtml::_('tabs.panel',  ucfirst($plugin->element), $plugin->element);
include JPATH_PLUGINS . '/jotcacheplugins/'.$plugin->element.'/'.$plugin->element.'_form.php';
}echo JHtml::_('tabs.end');
} else {
?> 
  <div style="color:red;"><?php echo JText::_('JOTCACHE_RECACHE_NO_PLUGINS'); ?></div>
<?php } ?>