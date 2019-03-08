<?php

/**
 *
 * Modify user form view, User info
 *
 * @package	VirtueMart
 * @subpackage User
 * @author Oscar van Eijk, Eugen Stranz
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: edit_address_userfields.php 6349 2012-08-14 16:56:24Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Status Of Delimiter
$closeDelimiter = false;
$openTable = true;
$hiddenFields = '';

// Output: Userfields
foreach($this->userFields['fields'] as $field) {

	if ($field['hidden'] == true) {

		// We collect all hidden fields
		// and output them at the end
		$hiddenFields .= $field['formcode'] . "\n";

	} else {

		// If we have a new delimiter
		// we have to start a new table
		if($openTable) {
			$openTable = false;
			?>
<div class="row">
	<div class="col-md-1"></div>
<div class="col-md-10 col-xs-12">
    
    
			<table  class="table adminForm user-details" style="width:100%">

				<fieldset style="margin-top:3vh;margin-bottom:2vh;">
				    <legend>
                        <?php //echo '<h3>' .JText::_('COM_VIRTUEMART_USER_FORM_SHIPTO_LBL').'</h3>'; ?>
					  
			 	
					  </legend>
				</fieldset>

		<?php
		}

		// Output: Userfields
		$no_display = array("password", "password2");

		if ($field['name'] != "agreed") {
		?>
				<tr class="width100">
					<td class="key" style="width:100%;" title="<?php echo $field['description'] ?>" >
					<label class="<?php echo $field['name'] ?>" for="<?php echo $field['name'] ?>_field">
						<?php
							if ( !in_array($field['name'], $no_display) ) {
								echo $field['title'] . ($field['required'] ? ' *' : '');
							}
							else {
								echo $field['title'];
							}
						?>
					</label>
					</td>
					<td>
						<?php echo $field['formcode'] ?>
					</td>
				</tr>
	<?php
		}
	}

}

// At the end we have to close the current
// table and delimiter ?>

			</table>
	
	</div>
	<div class="col-md-2"></div>
	</div>
<?php // Output: Hidden Fields
echo $hiddenFields
?>
