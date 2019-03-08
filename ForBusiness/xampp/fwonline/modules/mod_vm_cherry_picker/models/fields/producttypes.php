<?php
defined('_JEXEC') or die('Restricted access');

// Create custom Joomla form field.
// Guide could be found at:
// http://docs.joomla.org/Creating_a_custom_form_field_type

jimport('joomla.form.formfield');

class JFormFieldProductTypes extends JFormField {

	protected $type = 'producttypes';

	public function getInput() {
		$db = JFactory::getDBO();
		$q = "SELECT `product_type_id` as id,".
			" CONCAT(`product_type_name`, ' (id: ', `product_type_id`, ')') as label".
			" FROM `#__vm_product_type` ".
			" WHERE 1";

		$db->setQuery($q);
		$pts = $db->loadAssocList();
		if (!$pts) {
			$q = "SELECT `product_type_id` as id,".
				" CONCAT(`product_type_name`, ' (id: ', `product_type_id`, ')') as label".
				" FROM `#__fastseller_product_type` ".
				" WHERE 1";

			$db->setQuery($q);
			$pts = $db->loadAssocList();
			if (!$pts) {
				$q = "SELECT * FROM `#__extensions` WHERE `name` LIKE '%fastseller%'";
				$db->setQuery($q);
				$fastseller_installed = $db->loadResult();
				if ($fastseller_installed)
					return '<label style="clear:none">'.
						'<span style="color:#DD0000">Product Types are not created yet.</span>'.
						'<div style="margin-top:5px"><a href="index.php?option=com_fastseller#i=CREATE" '.
						'style="color:#007CFF">Proceed to <b>Fast Seller</b></a> '.
						'to create filters in it first. When you return -- you\'ll see here '.
						'a list of new Product Types instead of this message.'.
						'</label>';
				else
					return '<label style="clear:none">'.
						'<span style="color:#DD0000">Product Types are not created yet.</span>'.
						'<div style="margin-top:5px">You\'d need to use <a href="http://www.galt.md/fastseller" '.
						'style="color:#007CFF">Fast Seller</a> '.
						'to create and assign filters to products in order for Cherry Picker to display filters.'.
						'You can filter products by Price or Manufacturers though.'.
						'</label>';
			}
		}

		$element = '<select id="'. $this->id .'" name="'. $this->name .'"';
		if ($this->multiple)
			$element .= ' multiple="mutiple"';
		$element .= '>';
		foreach ($pts as $pt) {
			$element .= '<option value="'. $pt['id'] .'"';
			if (in_array($pt['id'], (array)$this->value))
				$element .= ' selected';
			$element .= '>'. $pt['label'] .'</option>';
		}
		$element .= '</select>';

		return $element;
	}
}
