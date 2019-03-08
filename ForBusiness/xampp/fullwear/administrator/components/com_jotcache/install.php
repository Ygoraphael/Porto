<?php
/*
 * @version $Id: install.php,v 1.19 2014/06/07 12:15:07 Jot Exp $
 * @package JotCache
 * @category Joomla 2.5
 * @copyright (C) 2010-2014 Vladimir Kanich
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
function jotcache_upgrade(JDatabase $db) {
$message = '';
$query = $db->getQuery(true);
$query->select('COUNT(*)')
->from('#__jotcache_exclude')
->where('type=1');
$tplex_count = $db->setQuery($query)->loadResult();
if ($tplex_count == 0) {
return false;
}$query->clear('where');
$query->where('type=4');
  $count = $db->setQuery($query)->loadResult();
if ($count == 0) {
$query->clear('select')
->clear('where');
$query->select($db->quoteName('value'))
->from($db->quoteName('#__template_styles', 's'))
->where('name=s.id')
->where('type=1')
->order('s.home');
$defs = $db->setQuery($query)->loadResultArray();
    $positions = array();
foreach ($defs as $def) {
$def_array = unserialize($def);
$positions = array_merge($positions, $def_array);
}$query->clear();
$query->select('position')
->from('#__modules')
->where('client_id = 0')
->where('published = 1')
->where('position <>' . $db->quote(''))
->group('position')
->order('position');
$db->setQuery($query);
    $items = $db->loadResultArray();
$cleaned_positions = array();
foreach ($items as $item) {
if (array_key_exists($item, $positions)) {
$cleaned_positions[$item] = $positions[$item];
}}$defs = serialize($cleaned_positions);
$query->clear();
$query->insert('#__jotcache_exclude')
->columns('name,value,type')
->values('1,' . $db->quote($defs) . ',4');
if ($db->setQuery($query)->query()) {
$message = "TABLE #__jotcache_exclude has been upgraded. Check JotCache TPL exclude definitions for correct values.";
} else {
JError::raiseNotice(100, $db->getErrorMsg());
}return $message;
}}function com_install() {
$db_changed_msgs = array();
/* @var $db JDatabase */$db = JFactory::getDBO();
$ret = jotcache_upgrade($db);
if ($ret) {
$db_changed_msgs[] = $ret;
}$dbname = $db->name;
switch ($dbname) {
case 'sqlsrv':
case 'sqlzure':
      $items = array("jotcache,cookies,NVARCHAR(2000) NOT NULL",
"jotcache,domain,NVARCHAR(255) NOT NULL",
"jotcache,sessionvars,NVARCHAR(2000) NOT NULL",
"jotcache,recache,tinyint",
"jotcache,recache_chck,tinyint",
"jotcache,agent,tinyint"
);foreach ($items as $item) {
list($table, $column, $type) = explode(",", $item, 3);
$sql = $db->getQuery(true);
$prefix = $db->getPrefix();
$sql->select('column_name')
->from('information_schema.columns')
->where('table_name = ' . $db->quote($prefix . $table))
->where('column_name =' . $db->quote($column));
$res = $db->setQuery($sql)->loadResult();
        if (!$res) {
$query = "ALTER TABLE " . $prefix . $table . " ADD " . $column . " " . $type;
$db->setQuery($query);
$db_changed_msgs[] = substr($db->getQuery(), 15);
$db->query();
}}break;
    default:
$items = array("jotcache,mark,TINYINT(1)",
"jotcache,title,varchar(255) NOT NULL AFTER `fname`",
"jotcache,domain,varchar(255) NOT NULL AFTER `fname`",
"jotcache,uri,TEXT NOT NULL AFTER `title`",
"jotcache,recache,TINYINT(1) NOT NULL AFTER `mark`",
"jotcache,recache_chck,TINYINT(1) NOT NULL AFTER `recache`",
"jotcache,agent,TINYINT(1) NOT NULL AFTER `recache_chck`",
"jotcache,language,VARCHAR(5) NOT NULL AFTER `uri`",
"jotcache,browser,VARCHAR(50) NOT NULL AFTER `language`",
"jotcache,qs,TEXT NOT NULL",
"jotcache,cookies,TEXT NOT NULL",
"jotcache,sessionvars,TEXT NOT NULL",
"jotcache_exclude,type,TINYINT(4) NOT NULL"
);foreach ($items as $item) {
list($table, $column, $type) = explode(",", $item, 3);
$sql = "DESCRIBE `#__" . $table . "` `" . $column . "`";
$db->setQuery($sql);
if (!$db->loadResult()) {
$sql = "ALTER TABLE #__" . $table . " ADD `" . $column . "` " . $type . ";";
$db->setQuery($sql);
$db_changed_msgs[] = substr($db->getQuery(), 15);
$db->query();
}}break;
}?>
  <?php if (count($db_changed_msgs)) { ?>
    <h3><?php echo JText::_('Upgrade - Altering Database Table(s)'); ?></h3>
    <table class="adminlist">
      <tbody>
        <?php
        $k = 0;
foreach ($db_changed_msgs as $msg) {
?>
          <tr class="row<?php echo $k; ?>" >
            <td class="key" colspan="3"><?php echo $msg; ?></td>
          </tr>
          <?php
          $k = 1 - $k;
}?>
      </tbody>
    </table>
    <?php
  }
}$installer = new JInstaller();
$installer->install($this->parent->getPath('source') . '/plugin');
$installer = new JInstaller();
$installer->install($this->parent->getPath('source') . '/marker');
$installer = new JInstaller();
$installer->install($this->parent->getPath('source') . '/crawler');
$installer = new JInstaller();
$installer->install($this->parent->getPath('source') . '/crawlerext');
$installer = new JInstaller();
$installer->install($this->parent->getPath('source') . '/recache');
$db = JFactory::getDBO();
$query = $db->getQuery(true);
$query->select('ordering')
->from('#__extensions')
->where('type =' . $db->quote('plugin'))
->where('folder =' . $db->quote('system'))
->where($db->quoteName('element') . ' <> ' . $db->quote('jotmarker'))
->order('ordering');
$min_order = ($db->setQuery($query)->loadResult()) - 1;
$query->clear();
$query->update($db->quoteName('#__extensions'))
->set("ordering=$min_order")
->set('enabled=1')
->where($db->quoteName('element') . ' = ' . $db->quote('jotmarker'));
$query->clear();
$query->update($db->quoteName('#__extensions'))
->set('enabled=1')
->where('type =' . $db->quote('plugin'))
->where('folder =' . $db->quote('jotcacheplugins'));
if (!$db->setQuery($query)->query()) {
JError::raiseNotice(100, $db->getErrorMsg());
}echo "<p>Installation of JotCache ver.4.2.3 successful!</p><p><b>IMPORTANT NOTE : </b>When upgrading from old versions of JotCache (prior ver.3.2.0) check all module exclusions because in versions 3.2.x was module exclusion mechanism significantly changed.</p><p> More information you can find in JotCache Help (Components-&gt;JotCache).</p><p>Home site : <a href=\"http://www.jotcomponents.net\" target=\"_blank\">http://www.jotcomponents.net</a>.<br><br>When necessary contact us using <a href=\"http://www.jotcomponents.net/contact\" target=\"_blank\">http://www.jotcomponents.net/contact</a> with any questions.</p>";
return true;
?>