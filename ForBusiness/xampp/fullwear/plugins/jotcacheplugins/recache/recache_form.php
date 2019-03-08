<?php
/*
 * @version $Id: recache_form.php,v 1.3 2013/09/25 07:33:17 Jot Exp $
 * @package JotCachePlugins
 * @category Joomla 2.5
 * @copyright (C) 2011-2014 Vladimir Kanich
 * @license GPL2
 */
defined('_JEXEC') or die('Restricted access');
?>
<form action="<?php echo JRoute::_('index.php?option=com_jotcache'); ?>" method="post" name="adminForm_recache" id="adminForm_Recache">
  <h3>Overview of selected options for recache process</h3>
  <table class="adminlist" style="width:60%;">
    <tr>
      <th nowrap="nowrap" width="120"><?php echo JText::_('Enabled'); ?></th>
      <th nowrap="nowrap" width="220"><?php echo JText::_('Option'); ?></th>
      <th><?php echo JText::_('Selection'); ?></th>
    </tr>
    <tr>
      <td nowrap="nowrap" width="120"><input type="checkbox" name="search" value="<?php echo $this->filter['search']; ?>" <?php echo $this->filter['search'] ? 'checked' : 'disabled'; ?> /></td>
      <td><?php echo JText::_('JOTCACHE_RS_SEARCH'); ?></td>
      <td class="sel"><?php echo $this->filter['search']; ?></td>
    </tr>
    <tr>
      <td nowrap="nowrap" width="120"><input type="checkbox" name="com" value="<?php echo $this->filter['com']; ?>" <?php echo $this->filter['com'] ? 'checked' : 'disabled'; ?>/></td>
      <td><?php echo JText::_('JOTCACHE_RS_COMP'); ?></td>
      <td class="sel"><?php echo $this->filter['com']; ?></td>
    </tr>
    <tr>
      <td nowrap="nowrap" width="120"><input type="checkbox" name="pview" value="<?php echo $this->filter['view']; ?>" <?php echo $this->filter['view'] ? 'checked' : 'disabled'; ?>/></td>
      <td><?php echo JText::_('JOTCACHE_RS_VIEW'); ?></td>
      <td class="sel"><?php echo $this->filter['view']; ?></td>
    </tr>
    <tr>
      <td nowrap="nowrap" width="120"><input type="checkbox" name="mark" value="1" <?php echo $this->filter['mark'] ? 'checked' : 'disabled'; ?>/></td>
      <td><?php echo JText::_('JOTCACHE_RS_MARK'); ?></td>
      <td class="sel"><?php echo $this->filter['mark']; ?></td>
    </tr>
  </table>
  <br/>
  <h3>Scope of cached pages for recaching</h3>
  <table class="scope adminlist">
    <tr>
      <td><span <?php echo ($scope == 'chck') ? '' : 'style="color:silver;"'; ?>><input type="radio" name="scope" value="chck"  <?php echo ($scope == 'chck') ? 'checked' : 'disabled'; ?>/><?php echo JText::_('JOTCACHE_RECACHE_CHECKED'); ?></span></td>
      <td><span <?php echo ($scope == 'sel') ? '' : 'style="color:silver;"'; ?>><input type="radio" name="scope" value="sel"  <?php echo ($scope == 'sel') ? 'checked' : 'disabled'; ?>/> <?php echo JText::_('JOTCACHE_RECACHE_SEL'); ?></span></td>
      <td><span><input type="radio" name="scope" value="all"  <?php echo ($scope == 'all') ? 'checked' : ''; ?>/> <?php echo JText::_('JOTCACHE_RECACHE_ALL'); ?></span></td>
    </tr>
  </table>
  <input type="hidden" name="view" value="recache" />
  <input type="hidden" name="task" value="display" />
  <input type="hidden" name="jotcacheplugin" value="recache" />
  <input type="hidden" name="boxchecked" value="0" />
  <input type="hidden" name="hidemainmenu" value="0" />
  <?php echo JHtml::_('form.token'); ?>
</form>