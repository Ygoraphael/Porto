<?php
/**
* @version   $Id: index.php 6263 2013-01-01 22:00:40Z kevin $
 * @author ThemeRox http://www.themerox.com
 * @copyright Copyright (C) 2007 - 2013 ThemeRox
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */

defined('JPATH_BASE') or die();

gantry_import('core.gantryfeature');
/**
 * @package     gantry
 * @subpackage  features
 */
class GantryFeatureCopyright extends GantryFeature
{
	var $_feature_name = 'copyright';

	function render($position)
	{
		ob_start();
		?>
	<div class="clear"></div>
	<div class="rt-block">
		<a href="http://www.novoscanais.pt/" title="Novoscanais" id="rocket"></a>
		<?php echo $this->get('text'); ?>
	</div>
	<?php
		return ob_get_clean();
	}
}