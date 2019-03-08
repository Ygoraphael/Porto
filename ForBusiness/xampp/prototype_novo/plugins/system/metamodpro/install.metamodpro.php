<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2009-2011 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @version $Id: install.akeeba.php 697 2011-06-03 22:33:16Z nikosdion $
 * @since 3.0
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Joomla! 1.6 Beta 13+ hack
if( version_compare( JVERSION, '1.6.0', 'ge' ) && !defined('_MMP_HACK') ) {
	return;
} else {
	global $mmp_installation_has_run;
	if($mmp_installation_has_run) return;
}

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

// Schema modification -- BEGIN

$db = JFactory::getDBO();
$errors = array();


// Install modules and plugins -- BEGIN

// -- General settings
jimport('joomla.installer.installer');
$db = JFactory::getDBO();
$status = new JObject();
$status->modules = array();
$status->plugins = array();
if( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
	// Thank you for removing installer features in Joomla! 1.6 Beta 13 and
	// forcing me to write ugly code, Joomla!...
	$src = dirname(__FILE__);
} else {
	$src = $this->parent->getPath('source');
}

// -- Icon module
$installer = new JInstaller;
$result = $installer->install($src.'/mod_metamod');
$status->modules[] = array('name'=>'mod_metamod','client'=>'site', 'result'=>$result);


if($result) {
	$query = "UPDATE #__extensions SET enabled = 1, ordering = -10 WHERE element='metamodpro' AND folder='system' and type='plugin'";
	$db->setQuery($query);
	$db->query(); // deprecated, will change to execute()
}


// Install modules and plugins -- END

$jlang = JFactory::getLanguage();
$path = JPATH_ADMINISTRATOR.'/../plugins/system/metamodpro';


$jlang->load('plg_metamodpro.sys', $path, 'en-GB', true);
$jlang->load('plg_metamodpro.sys', $path, $jlang->getDefault(), true);
$jlang->load('plg_metamodpro.sys', $path, null, true);

if(!function_exists('pitext'))
{
	function pitext($key)
	{
		global $j15;
		$string = JText::_($key);
		if($j15)
		{
			$string = str_replace('"_QQ_"', '"', $string);
		}
		echo $string;
	}
}

if(!function_exists('pisprint'))
{
	function pisprint($key, $param)
	{
		global $j15;
		$string = JText::sprintf($key, $param);
		if($j15)
		{
			$string = str_replace('"_QQ_"', '"', $string);
		}
		echo $string;
	}
}

// Finally, show the installation results form
?>
<?php if(!empty($errors)): ?>
<div style="background-color: #900; color: #fff; font-size: large;">
	<h1><?php pitext('PLG_METAMODPRO_PIMYSQLERR_HEAD'); ?></h1>
	<p><?php pitext('PLG_METAMODPRO_PIMYSQLERR_BODY1'); ?></p>
	<p><?php pitext('PLG_METAMODPRO_PIMYSQLERR_BODY2'); ?></p>
	<p style="font-size: normal;">
<?php echo implode("<br/>", $errors); ?>
	</p>
</div>
<?php endif; ?>

<h1><?php pitext('PLG_METAMODPRO_PIHEADER'); ?></h1>

<?php $rows = 0;?>
<img src="../plugins/system/metamodpro/metamodpro.png" width="159" height="65" alt="MetaMod Pro" align="right" />

<h2><?php pitext('PLG_METAMODPRO_PIWELCOME') ?></h2>
<table class="adminlist table table-striped">
	<thead>
		<tr>
			<th class="title" colspan="2"><?php echo JText::_('Extension'); ?></th>
			<th width="30%"><?php echo JText::_('Status'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="3"></td>
		</tr>
	</tfoot>
	<tbody>
		<tr class="row0">
			<td class="key" colspan="2"><?php echo 'MetaMod Pro '.JText::_('Plugin'); ?></td>
			<td><strong><?php echo JText::_('Installed'); ?></strong></td>
		</tr>
		<?php if (count($status->modules)) : ?>
		<tr>
			<th><?php echo JText::_('Module'); ?></th>
			<th><?php echo JText::_('Client'); ?></th>
			<th></th>
		</tr>
		<?php foreach ($status->modules as $module) : ?>
		<tr class="row<?php echo (++ $rows % 2); ?>">
			<td class="key"><?php echo $module['name']; ?></td>
			<td class="key"><?php echo ucfirst($module['client']); ?></td>
			<td><strong><?php echo ($module['result'])?JText::_('Installed'):JText::_('Not installed'); ?></strong></td>
		</tr>
		<?php endforeach;?>
		<?php endif;?>
		<?php if (count($status->plugins)) : ?>
		<tr>
			<th><?php echo JText::_('Plugin'); ?></th>
			<th><?php echo JText::_('Group'); ?></th>
			<th></th>
		</tr>
		<?php foreach ($status->plugins as $plugin) : ?>
		<tr class="row<?php echo (++ $rows % 2); ?>">
			<td class="key"><?php echo ucfirst($plugin['name']); ?></td>
			<td class="key"><?php echo ucfirst($plugin['group']); ?></td>
			<td><strong><?php echo ($plugin['result'])?JText::_('Installed'):JText::_('Not installed'); ?></strong></td>
		</tr>
		<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>

<fieldset>
	<p>
		<?php pisprint('PLG_METAMODPRO_PITEXT1','http://www.metamodpro.com/metamod/quick-start') ?>
		<?php pisprint('PLG_METAMODPRO_PITEXT2','http://www.metamodpro.com/forums') ?>
	</p>

</fieldset>
