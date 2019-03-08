<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

define('FSVERSION', '2.4');

//$languages = JLanguageHelper::getLanguages('lang_code');
$lang = ($conf_lang = FSConf::get('vm_lang')) ? $conf_lang : strtolower(JFactory::getLanguage()->getTag());
$replaceChars = array("-", " ");
$lang = str_replace($replaceChars, "_", $lang);
define('VMLANG', $lang);
