<?php
/*
 * @version $Id: browsers.php,v 1.2 2013/08/16 05:17:21 Jot Exp $
 * @package JotCache
 * @category Joomla 2.5
 * @copyright (C) 2011-2014 Vladimir Kanich
 * @license GPL2
 */
defined('JPATH_PLATFORM') or die;
include_once JPATH_ADMINISTRATOR . '/components/com_jotcache/helpers/browseragents.php';
class JFormFieldBrowsers extends JFormField {
protected $type = 'Browsers';
protected $browsers;
public function __construct() {
$this->browsers = BrowserAgents::getBrowserAgents();
parent::__construct();
}protected function getInput() {
$options = array();
foreach ($this->browsers as $key => $value) {
$obj = new stdClass();
$obj->value = $key;
$obj->text = $value[0];
$options[] = $obj;
}$size = count($this->browsers);
return JHtml::_('select.genericlist', $options, 'jform[params][cacheclient][]', 'multiple="multiple" size="' . $size . '"', 'value', 'text', $this->value, $this->id);
}}