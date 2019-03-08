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

class GantryFeatureBranding extends GantryFeature {
    var $_feature_name = 'branding';

	function render($position) {
	    ob_start();
	    ?>
	    <div class="rt-block">
			<a href="http://www.themerox.com" title="Quality Templates" class="powered-by"></a>
		</div>
		<?php
	    return ob_get_clean();
	}
}