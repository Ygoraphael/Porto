<?php
/**
 * @package Vallis Administrator Template for Joomla 3.x By Joomlatema.net
 * @subpackage  Templates.Vallis  2014-12-26  Joomlatema.Net $
 * @author Muratyil
 * @copyright (C) 2014- Muratyil
 * @license GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die;


$app             = JFactory::getApplication();
$doc             = JFactory::getDocument();
$lang            = JFactory::getLanguage();
$this->language  = $doc->language;
$this->direction = $doc->direction;

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');

$doc->addScript('templates/' . $this->template . '/js/template.js');

// Add Stylesheets
$doc->addStyleSheet('templates/' . $this->template . '/css/template.css');
$doc->addStyleSheet('templates/' . $this->template . '/css/$colorVariation.css');

// Load optional RTL Bootstrap CSS
JHtml::_('bootstrap.loadCss', false, $this->direction);

// Load specific language related CSS
$file = 'language/' . $lang->getTag() . '/' . $lang->getTag() . '.css';

if (is_file($file))
{
	$doc->addStyleSheet($file);
}


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<jdoc:include type="head" />
	<!--[if lt IE 9]>
		<script src="../media/jui/js/html5.js"></script>
	<![endif]-->
</head>
<body class="contentpane component">
	<jdoc:include type="message" />
	<jdoc:include type="component" />
</body>
</html>
