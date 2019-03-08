<?php

defined ('_JEXEC') or die('Restricted access');

/**
 * Shipment plugin for general, rules-based shipments, like regular postal services with complex shipping cost structures
 *
 * @package VirtueMart
 * @subpackage Plugins - shipment
 * @copyright Copyright (C) 2004-2012 VirtueMart Team - All rights reserved.
 * @copyright Copyright (C) 2013 Reinhold Kainhofer, reinhold@kainhofer.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.txt
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 *
 * @author Reinhold Kainhofer, based on the weight_countries shipping plugin by Valerie Isaksen
 *
 */
if (!class_exists ('vmPSPlugin')) {
	require(JPATH_VM_PLUGINS . DS . 'vmpsplugin.php');
}
// Only declare the class once...
if (class_exists ('plgVmShipmentRules_Shipping_Base')) {
	return;
}


function is_equal($a, $b) {
	if (is_array($a) && is_array($b)) {
		return !array_diff($a, $b) && !array_diff($b, $a);
	} elseif (is_string($a) && is_string($b)) {
		return strcmp($a,$b) == 0;
	} else {
		return $a == $b;
	}
}


/** Shipping costs according to general rules.
 *  Supported Variables: Weight, ZIP, Amount, Products (1 for each product, even if multiple ordered), Articles
 *  Assignable variables: Shipping, Name
 */
class plgVmShipmentRules_Shipping_Base extends vmPSPlugin {
	// Store the parsed and possibly evaluated rules for each method (method ID is used as key)
	protected $rules = array();
	protected $match = array();
	var $custom_functions = array ();

	/**
	 * @param object $subject
	 * @param array  $config
	 */
	function __construct (& $subject, $config) {
		parent::__construct ($subject, $config);

		$this->_loggable = TRUE;
		$this->_tablepkey = 'id';
		$this->_tableId = 'id';
		$this->tableFields = array_keys ($this->getTableSQLFields ());
		$varsToPush = $this->getVarsToPush ();
		$this->setConfigParameterable ($this->_configTableFieldName, $varsToPush);
		
		// PLUGIN FUNCTIONALITY:
		// Let other plugins add custom functions! 
		// The onVmShippingRulesRegisterCustomFunctions() trigger is expected to return an array of the form:
		//   array ('functionname1' => 'function-to-be-called',
		//          'functionname2' => array($classobject, 'memberfunc')),
		//          ...);
		JPluginHelper::importPlugin('vmshipmentrules');
		$dispatcher = JDispatcher::getInstance();
		$custfuncdefs = $dispatcher->trigger('onVmShippingRulesRegisterCustomFunctions',array());
		// Loop through the return values of all plugins:
		foreach ($custfuncdefs as $custfuncs) {
			if (empty($custfuncs))
				continue;
			if (!is_array($custfuncs)) {
				$this->printWarning(JText::sprintf('VMSHIPMENT_RULES_CUSTOMFUNCTIONS_NOARRAY', $method->rule_name));
			}
			// Now loop through all custom function definitions of this plugin
			// If a function was registered before, print a warning and use the first definition
			foreach ($custfuncs as $fname => $func) {
				if (isset($this->custom_functions[$fname])) {
					$this->printWarning(JText::sprintf('VMSHIPMENT_RULES_CUSTOMFUNCTIONS_ALREADY_DEFINED', $fname));
				} else {
					vmDebug("Defining custom function $fname");
					$this->custom_functions[strtolower($fname)] = $func;
				}
			}
		}
	}

	/**
	 * Create the table for this plugin if it does not yet exist.
	 *
	 * @author Valérie Isaksen
	 */
	public function getVmPluginCreateTableSQL () {
		return $this->createTableSQL ('Shipment Rules Table');
	}
	
	public function printWarning($message) {
		// Keep track of warning messages, so we don't print them twice:
		global $printed_warnings;
		if (!isset($printed_warnings))
			$printed_warnings = array();
		if (!in_array($message, $printed_warnings)) {
			JFactory::getApplication()->enqueueMessage($message, 'error');
			$printed_warnings[] = $message;
		}
	}

	/**
	 * @return array
	 */
	function getTableSQLFields () {
		$SQLfields = array(
			'id'                           => 'int(1) UNSIGNED NOT NULL AUTO_INCREMENT',
			'virtuemart_order_id'          => 'int(11) UNSIGNED',
			'order_number'                 => 'char(32)',
			'virtuemart_shipmentmethod_id' => 'mediumint(1) UNSIGNED',
			'shipment_name'                => 'varchar(5000)',
			'rule_name'                    => 'varchar(500)',
			'order_weight'                 => 'decimal(10,4)',
			'order_articles'               => 'int(1)',
			'order_products'               => 'int(1)',
			'shipment_weight_unit'         => 'char(3) DEFAULT \'KG\'',
			'shipment_cost'                => 'decimal(10,2)',
			'tax_id'                       => 'smallint(1)'
		);
		return $SQLfields;
	}

	/**
	 * This method is fired when showing the order details in the frontend.
	 * It displays the shipment-specific data.
	 *
	 * @param integer $virtuemart_order_id The order ID
	 * @param integer $virtuemart_shipmentmethod_id The selected shipment method id
	 * @param string  $shipment_name Shipment Name
	 * @return mixed Null for shipments that aren't active, text (HTML) otherwise
	 * @author Valérie Isaksen
	 * @author Max Milbers
	 */
	public function plgVmOnShowOrderFEShipment ($virtuemart_order_id, $virtuemart_shipmentmethod_id, &$shipment_name) {
		$this->onShowOrderFE ($virtuemart_order_id, $virtuemart_shipmentmethod_id, $shipment_name);
	}

	/**
	 * This event is fired after the order has been stored; it gets the shipment method-
	 * specific data.
	 *
	 * @param int    $order_id The order_id being processed
	 * @param object $cart  the cart
	 * @param array  $order The actual order saved in the DB
	 * @return mixed Null when this method was not selected, otherwise true
	 * @author Valerie Isaksen
	 */
	function plgVmConfirmedOrder (VirtueMartCart $cart, $order) {

		if (!($method = $this->getVmPluginMethod ($order['details']['BT']->virtuemart_shipmentmethod_id))) {
			return NULL; // Another method was selected, do nothing
		}
		if (!$this->selectedThisElement ($method->shipment_element)) {
			return FALSE;
		}
		// We need to call getCosts, because in J3 $method->rule_name and $method->cost as set in getCosts is no longer preserved.
		// Instead, we simply call getCosts again, which as a side-effect sets all those members of $method.
		$costs = $this->getCosts($cart,$method,$cart->cartPrices);
		$values['virtuemart_order_id'] = $order['details']['BT']->virtuemart_order_id;
		$values['order_number'] = $order['details']['BT']->order_number;
		$values['virtuemart_shipmentmethod_id'] = $order['details']['BT']->virtuemart_shipmentmethod_id;
		$values['shipment_name'] = $this->renderPluginName ($method);
		$values['rule_name'] = $method->rule_name;
		$weights = $this->getOrderWeights ($cart, $cart->products, $method->weight_unit);
		$values['order_weight'] = $weights['weight'];
		$values['order_articles'] = $this->getOrderArticles ($cart, $cart->products);
		$values['order_products'] = $this->getOrderProducts ($cart, $cart->products);
		$values['shipment_weight_unit'] = $method->weight_unit;
		$values['shipment_cost'] = $method->cost;
		$values['tax_id'] = $method->tax_id;
		$this->storePSPluginInternalData ($values);

		return TRUE;
	}

	/**
	 * This method is fired when showing the order details in the backend.
	 * It displays the shipment-specific data.
	 * NOTE, this plugin should NOT be used to display form fields, since it's called outside
	 * a form! Use plgVmOnUpdateOrderBE() instead!
	 *
	 * @param integer $virtuemart_order_id The order ID
	 * @param integer $virtuemart_shipmentmethod_id The order shipment method ID
	 * @param object  $_shipInfo Object with the properties 'shipment' and 'name'
	 * @return mixed Null for shipments that aren't active, text (HTML) otherwise
	 * @author Valerie Isaksen
	 */
	public function plgVmOnShowOrderBEShipment ($virtuemart_order_id, $virtuemart_shipmentmethod_id) {
		if (!($this->selectedThisByMethodId ($virtuemart_shipmentmethod_id))) {
			return NULL;
		}
		$html = $this->getOrderShipmentHtml ($virtuemart_order_id);
		return $html;
	}

	/**
	 * @param $virtuemart_order_id
	 * @return string
	 */
	function getOrderShipmentHtml ($virtuemart_order_id) {

		$db = JFactory::getDBO ();
		$q = 'SELECT * FROM `' . $this->_tablename . '` '
			. 'WHERE `virtuemart_order_id` = ' . $virtuemart_order_id;
		$db->setQuery ($q);
		if (!($shipinfo = $db->loadObject ())) {
			vmWarn (500, $q . " " . $db->getErrorMsg ());
			return '';
		}

		if (!class_exists ('CurrencyDisplay')) {
			require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'currencydisplay.php');
		}

		$currency = CurrencyDisplay::getInstance ();
		$tax = ShopFunctions::getTaxByID ($shipinfo->tax_id);
		$taxDisplay = is_array ($tax) ? $tax['calc_value'] . ' ' . $tax['calc_value_mathop'] : $shipinfo->tax_id;
		$taxDisplay = ($taxDisplay == -1) ? JText::_ ('COM_VIRTUEMART_PRODUCT_TAX_NONE') : $taxDisplay;

		$html = '<table class="adminlist">' . "\n";
		$html .= $this->getHtmlHeaderBE ();
		$html .= $this->getHtmlRowBE ('RULES_SHIPPING_NAME', $shipinfo->shipment_name);
		$html .= $this->getHtmlRowBE ('RULES_WEIGHT', $shipinfo->order_weight . ' ' . ShopFunctions::renderWeightUnit ($shipinfo->shipment_weight_unit));
		$html .= $this->getHtmlRowBE ('RULES_ARTICLES', $shipinfo->order_articles . '/' . $shipinfo->order_products);
		$html .= $this->getHtmlRowBE ('RULES_COST', $currency->priceDisplay ($shipinfo->shipment_cost));
		$html .= $this->getHtmlRowBE ('RULES_TAX', $taxDisplay);
		$html .= '</table>' . "\n";

		return $html;
	}
	
	/** Include the rule name in the shipment name */
	protected function renderPluginName ($plugin) {
		$return = '';
		$plugin_name = $this->_psType . '_name';
		$plugin_desc = $this->_psType . '_desc';
		$description = '';
		// 		$params = new JParameter($plugin->$plugin_params);
		// 		$logo = $params->get($this->_psType . '_logos');
		$logosFieldName = $this->_psType . '_logos';
		$logos = $plugin->$logosFieldName;
		if (!empty($logos)) {
			$return = $this->displayLogos ($logos) . ' ';
		}
		if (!empty($plugin->$plugin_desc)) {
			$description = '<span class="' . $this->_type . '_description">' . $plugin->$plugin_desc . '</span>';
		}
		$rulename='';
		if (!empty($plugin->rule_name)) {
			$rulename=" (".htmlspecialchars($plugin->rule_name).")";
		}
		$pluginName = $return . '<span class="' . $this->_type . '_name">' . $plugin->$plugin_name . $rulename.'</span>' . $description;
		return $pluginName;
	}


	/** This function evaluates all rules, one after the other until it finds a matching rule that
	 *  defines shipping costs (or uses NoShipping). If a modifier or definition is encountered,
	 *  its effect is stored, but the loop continues */
	protected function evaluateMethodRules ($cart, $method, $cart_prices) {
		// $method->match will cache the matched rule and the modifiers
		if (isset($this->match[$method->virtuemart_shipmentmethod_id])) {
			return $this->match[$method->virtuemart_shipmentmethod_id];
		} else {
			// Evaluate all rules and find the matching ones (including modifiers and definitions!)
			$result = array("rule"=>Null, "rule_name"=>"", "modifiers_add"=>array(), "modifiers_multiply"=>array());
			$cartvals = $this->getCartValues ($cart, $cart->products, $method, $cart_prices);
			// Pass a callback function to the rules to obtain the cartvals for a subset of the products
			$this_class = $this;
			$cartvals_callback = function ($products) use ($this_class, $cart, $method, $cart_prices) {
				return $this_class->getCartValues ($cart, $products, $method, NULL);
			};
			foreach ($this->rules[$method->virtuemart_shipmentmethod_id] as $r) {
				if ($r->matches($cartvals, $cart->products, $cartvals_callback)) {
					$rtype = $r->getType();
					switch ($rtype) {
						case 'shipping': 
						case 'shippingwithtax':
						case 'noshipping': 
								$result["rule"] = $r;
								$result["rule_name"] = $r->getRuleName();
								break;
						case 'modifiers_add':
						case 'modifiers_multiply':
								$result[$rtype][] = $r;
								break;
						case 'definition': // A definition updates the $cartvals, but has no other effects
								$cartvals[strtolower($r->getRuleName())] = $r->getValue();
								break;
						default:
								$this->printWarning(JText::sprintf('VMSHIPMENT_RULES_UNKNOWN_TYPE', $r->getType(), $r->rulestring));
								break;
					}
				}
				if (!is_null($result["rule"])) {
					$this->match[$method->virtuemart_shipmentmethod_id] = $result;
					return $result; // <- This also breaks out of the foreach loop!
				}
			}
		}
		// None of the rules matched, so return NULL, but keep the evaluated results;
		$this->match[$method->virtuemart_shipmentmethod_id] = $result;
		return NULL;
	}

	/**
	 * @param \VirtueMartCart $cart
	 * @param int             $method
	 * @param array           $cart_prices
	 * @return bool
	 */
	protected function checkConditions ($cart, $method, $cart_prices) {
		if (!isset($this->rules[$method->virtuemart_shipmentmethod_id])) 
			$this->parseMethodRules($method);
		$match = $this->evaluateMethodRules ($cart, $method, $cart_prices);
		if ($match && !is_null ($match['rule'])) {
			$method->rule_name = $match["rule_name"];
			// If NoShipping is set, this method should NOT offer any shipping at all, so return FALSE, otherwise TRUE
			// If the rule has a name, print it as warning (otherwise don't print anything)
			if ($match['rule']->isNoShipping()) {
				if (!empty($method->rule_name))
					$this->printWarning(JText::sprintf('VMSHIPMENT_RULES_NOSHIPPING_MESSAGE', $method->rule_name));
				vmdebug('checkConditions '.$method->shipment_name.' indicates NoShipping for this method, specified by rule "'.$method->rule_name.'" ('.$match['rule']->rulestring.').');
				return FALSE;
			} else {
				return TRUE;
			}
		}
		vmdebug('checkConditions '.$method->shipment_name.' does not fulfill all conditions, no rule matches');
		return FALSE;
	}

	/**
	 * @param VirtueMartCart $cart
	 * @param                $method
	 * @param                $cart_prices
	 * @return int
	 */
	function getCosts (VirtueMartCart $cart, $method, $cart_prices) {
		if (!isset($this->rules[$method->virtuemart_shipmentmethod_id])) 
			$this->parseMethodRules($method);
		$match = $this->evaluateMethodRules ($cart, $method, $cart_prices);
		if ($match) {
			$r = $match["rule"];
			vmdebug('Rule ' . $match["rule_name"] . ' ('.$r->rulestring.') matched.');
			$method->tax_id = $r->tax_id;
			// TODO: Shall we include the name of the modifiers, too?
			$method->rule_name = $match["rule_name"];
			// Final shipping costs are calculated as:
			//   Shipping*ExtraShippingMultiplier + ExtraShippingCharge
			// with possibly multiple modifiers
			$method->cost = $r->getShippingCosts();
			foreach ($match['modifiers_multiply'] as $modifier) {
				$method->cost *= $modifier->getValue();
			}
			foreach ($match['modifiers_add'] as $modifier) {
				$method->cost += $modifier->getValue();
			}
			$method->includes_tax = $r->includes_tax;
			return $method->cost;
		}
		
		vmdebug('getCosts '.$method->name.' does not return shipping costs');
		return 0;
	}


	/**
	 * update the plugin cart_prices
	 *
	 * Override the plugin's setCartPrices to allow reverse tax calculation (i.e. shipping costs are 
	 * given with taxes, the net price and the tax is calculated from the gross shipping costs)-
	 *  We need separate versions for VM2 and VM3.
	 *
	 * @author Valérie Isaksen (original), Reinhold Kainhofer (tax calculations from shippingWithTax)
	 *
	 * @param $cart_prices: $cart_prices['salesPricePayment'] and $cart_prices['paymentTax'] updated. Displayed in the cart.
	 * @param $value :   fee
	 * @param $tax_id :  tax id
	 */
	function setCartPrices (VirtueMartCart $cart, &$cart_prices, $method, $progressive = true) {
		// Copied and adjusted from VirtueMart 2.6.2
		// Lines 984ff, File administrator/components/com_virtuemart/plugins/vmpsplugin.php

		if (!class_exists ('calculationHelper')) {
			if(!defined('VM_VERSION') or VM_VERSION < 3){ // VM2:
				require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'calculationh.php');
			} else { // VM 3:
				require(VMPATH_ADMIN . DS . 'helpers' . DS . 'calculationh.php');
			}
		}
		$_psType = ucfirst ($this->_psType);
		$calculator = calculationHelper::getInstance ();

		$cart_prices[$this->_psType . 'Value'] = $calculator->roundInternal ($this->getCosts ($cart, $method, $cart_prices), 'salesPrice');
		// BEGIN_RK_CHANGES
		$includes_tax = isset($method->includes_tax) && $method->includes_tax;
		if ($includes_tax) {
			$cart_prices['salesPrice' . $_psType] = $cart_prices[$this->_psType . 'Value'];
		}
		// END_RK_CHANGES
		if(!isset($cart_prices[$this->_psType . 'Value'])) $cart_prices[$this->_psType . 'Value'] = 0.0;
		if(!isset($cart_prices[$this->_psType . 'Tax'])) $cart_prices[$this->_psType . 'Tax'] = 0.0;

		if($this->_psType=='payment'){
			$cartTotalAmountOrig=$this->getCartAmount($cart_prices);
			if(!$progressive){
				//Simple
				$cartTotalAmount=($cartTotalAmountOrig + $method->cost_per_transaction) * (1 +($method->cost_percent_total * 0.01));
				//vmdebug('Simple $cartTotalAmount = ('.$cartTotalAmountOrig.' + '.$method->cost_per_transaction.') * (1 + ('.$method->cost_percent_total.' * 0.01)) = '.$cartTotalAmount );
				//vmdebug('Simple $cartTotalAmount = '.($cartTotalAmountOrig + $method->cost_per_transaction).' * '. (1 + $method->cost_percent_total * 0.01) .' = '.$cartTotalAmount );
			} else {
				//progressive
				$cartTotalAmount = ($cartTotalAmountOrig + $method->cost_per_transaction) / (1 -($method->cost_percent_total * 0.01));
				//vmdebug('Progressive $cartTotalAmount = ('.$cartTotalAmountOrig.' + '.$method->cost_per_transaction.') / (1 - ('.$method->cost_percent_total.' * 0.01)) = '.$cartTotalAmount );
				//vmdebug('Progressive $cartTotalAmount = '.($cartTotalAmountOrig + $method->cost_per_transaction) .' / '. (1 - $method->cost_percent_total * 0.01) .' = '.$cartTotalAmount );
			}
			$cart_prices[$this->_psType . 'Value'] = $cartTotalAmount - $cartTotalAmountOrig;
		}

		if(!isset($cart_prices['salesPrice' . $_psType])) $cart_prices['salesPrice' . $_psType] = $cart_prices[$this->_psType . 'Value'];

		$taxrules = array();
		if(isset($method->tax_id) and (int)$method->tax_id === -1){

		} else if (!empty($method->tax_id)) {
			$cart_prices[$this->_psType . '_calc_id'] = $method->tax_id;

			$db = JFactory::getDBO ();
			$q = 'SELECT * FROM #__virtuemart_calcs WHERE `virtuemart_calc_id`="' . $method->tax_id . '" ';
			$db->setQuery ($q);
			$taxrules = $db->loadAssocList ();

			if(!empty($taxrules) ){
				foreach($taxrules as &$rule){
					if(!isset($rule['subTotal'])) $rule['subTotal'] = 0;
					if(!isset($rule['taxAmount'])) $rule['taxAmount'] = 0;
					$rule['subTotalOld'] = $rule['subTotal'];
					$rule['taxAmountOld'] = $rule['taxAmount'];
					$rule['taxAmount'] = 0;
					// BEGIN_RK_CHANGES
					if ($includes_tax) {
						$calculator->setRevert (true);
						$rule['subTotal'] = $cart_prices[$this->_psType . 'Value'];
						$valueWithoutTax = $calculator->roundInternal ($calculator->interpreteMathOp($rule, $rule['subTotal']));
						$cart_prices[$this->_psType . 'TaxPerID'][$rule['virtuemart_calc_id']] = $calculator->roundInternal($rule['subTotal'] - $valueWithoutTax, 'salesPrice');
						$calculator->setRevert (false);
					} else {
					// END_RK_CHANGES
						$rule['subTotal'] = $cart_prices[$this->_psType . 'Value'];
						$cart_prices[$this->_psType . 'TaxPerID'][$rule['virtuemart_calc_id']] = $calculator->roundInternal($calculator->roundInternal($calculator->interpreteMathOp($rule, $rule['subTotal'])) - $rule['subTotal'], 'salesPrice');
					// BEGIN_RK_CHANGES
					}
					// END_RK_CHANGES
					$cart_prices[$this->_psType . 'Tax'] += $cart_prices[$this->_psType . 'TaxPerID'][$rule['virtuemart_calc_id']];
				}
			}
		} else {
			// BEGIN_RK_CHANGES: VM change in VM3!
			if (isset($calculator->_cartData) && is_array($calculator->_cartData)) { // VM2:
				$taxrules = array_merge($calculator->_cartData['VatTax'],$calculator->_cartData['taxRulesBill']);
			} else { // VM3:
				$taxrules = array_merge($cart->cartData['VatTax'],$cart->cartData['taxRulesBill']);
			}
			// END_RK_CHANGES

			if(!empty($taxrules) ){
				$denominator = 0.0;
				foreach($taxrules as &$rule){
					//$rule['numerator'] = $rule['calc_value']/100.0 * $rule['subTotal'];
					if(!isset($rule['subTotal'])) $rule['subTotal'] = 0;
					if(!isset($rule['taxAmount'])) $rule['taxAmount'] = 0;
					// BEGIN_RK_CHANGES
					if ($includes_tax) {
						$denominator += $rule['subTotal'];
					} else {
					// END_RK_CHANGES
						$denominator += ($rule['subTotal']-$rule['taxAmount']);
					// BEGIN_RK_CHANGES
					}
					// END_RK_CHANGES
					$rule['subTotalOld'] = $rule['subTotal'];
					$rule['subTotal'] = 0;
					$rule['taxAmountOld'] = $rule['taxAmount'];
					$rule['taxAmount'] = 0;
					//$rule['subTotal'] = $cart_prices[$this->_psType . 'Value'];
				}
				if(empty($denominator)){
					$denominator = 1;
				}

				foreach($taxrules as &$rule){
					// BEGIN_RK_CHANGES
					if ($includes_tax) {
						$calculator->setRevert (true);
						$frac = $rule['subTotalOld']/$denominator;
						$rule['subTotal'] = $cart_prices[$this->_psType . 'Value'] * $frac;
						$valueWithoutTax = $calculator->roundInternal ($calculator->interpreteMathOp($rule, $rule['subTotal']));
						$cart_prices[$this->_psType . 'TaxPerID'][$rule['virtuemart_calc_id']] = $calculator->roundInternal($rule['subTotal'] - $valueWithoutTax, 'salesPrice');
						$calculator->setRevert (false);
					} else {
					// END_RK_CHANGES
						$frac = ($rule['subTotalOld']-$rule['taxAmountOld'])/$denominator;
						$rule['subTotal'] = $cart_prices[$this->_psType . 'Value'] * $frac;
						//vmdebug('Part $denominator '.$denominator.' $frac '.$frac,$rule['subTotal']);
						$cart_prices[$this->_psType . 'TaxPerID'][$rule['virtuemart_calc_id']] = $calculator->roundInternal($calculator->roundInternal($calculator->interpreteMathOp($rule, $rule['subTotal'])) - $rule['subTotal'], 'salesPrice');
					// BEGIN_RK_CHANGES
					}
					if(!isset($cart_prices[$this->_psType . 'Tax'])) $cart_prices[$this->_psType . 'Tax'] = 0.0;
					// END_RK_CHANGES
					$cart_prices[$this->_psType . 'Tax'] += $cart_prices[$this->_psType . 'TaxPerID'][$rule['virtuemart_calc_id']];
				}
			}
		}


		if(empty($method->cost_per_transaction)) $method->cost_per_transaction = 0.0;
		if(empty($method->cost_percent_total)) $method->cost_percent_total = 0.0;

		if (count ($taxrules) > 0 ) {

			// BEGIN_RK_CHANGES
			if ($includes_tax) {
				// Calculate the net shipping cost by removing all taxes:
				$calculator->setRevert (true);
				$cart_prices[$this->_psType . 'Value'] = $calculator->roundInternal ($calculator->executeCalculation($taxrules, $cart_prices[$this->_psType . 'Value'], true), 'salesPrice');
				$calculator->setRevert (false);
			} else {
			// END_RK_CHANGES
				$cart_prices['salesPrice' . $_psType] = $calculator->roundInternal ($calculator->executeCalculation ($taxrules, $cart_prices[$this->_psType . 'Value'],true,false), 'salesPrice');
				//vmdebug('I am in '.get_class($this).' and have this rules now',$taxrules,$cart_prices[$this->_psType . 'Value'],$cart_prices['salesPrice' . $_psType]);
//				$cart_prices[$this->_psType . 'Tax'] = $calculator->roundInternal (($cart_prices['salesPrice' . $_psType] -  $cart_prices[$this->_psType . 'Value']), 'salesPrice');
			// BEGIN_RK_CHANGES
			}
			// END_RK_CHANGES
			reset($taxrules);
//			$taxrule =  current($taxrules);
//			$cart_prices[$this->_psType . '_calc_id'] = $taxrule['virtuemart_calc_id'];

			foreach($taxrules as &$rule){
				if(!isset($cart_prices[$this->_psType . '_calc_id']) or !is_array($cart_prices[$this->_psType . '_calc_id'])) $cart_prices[$this->_psType . '_calc_id'] = array();
				$cart_prices[$this->_psType . '_calc_id'][] = $rule['virtuemart_calc_id'];
				if(isset($rule['subTotalOld'])) $rule['subTotal'] += $rule['subTotalOld'];
				if(isset($rule['taxAmountOld'])) $rule['taxAmount'] += $rule['taxAmountOld'];
			}

		} else {
			$cart_prices['salesPrice' . $_psType] = $cart_prices[$this->_psType . 'Value'];
			$cart_prices[$this->_psType . 'Tax'] = 0;
			$cart_prices[$this->_psType . '_calc_id'] = 0;
		}

		return $cart_prices['salesPrice' . $_psType];

	}

	protected function createMethodRule ($r, $countries, $tax) {
		return new ShippingRule($this, $r, $countries, $tax);
	}

	private function parseMethodRule ($rulestring, $countries, $tax, &$method) {
		$rules1 = preg_split("/(\r\n|\n|\r)/", $rulestring);
		foreach ($rules1 as $r) {
			// Ignore empty lines
			if (empty($r)) continue;
			$this->rules[$method->virtuemart_shipmentmethod_id][] = $this->createMethodRule ($r, $countries, $tax);
		}
	}
	
	protected function parseMethodRules (&$method) {
		if (!isset($this->rules[$method->virtuemart_shipmentmethod_id])) 
			$this->rules[$method->virtuemart_shipmentmethod_id] = array();
		$this->parseMethodRule ($method->rules1, $method->countries1, $method->tax_id1, $method);
		$this->parseMethodRule ($method->rules2, $method->countries2, $method->tax_id2, $method);
		$this->parseMethodRule ($method->rules3, $method->countries3, $method->tax_id3, $method);
		$this->parseMethodRule ($method->rules4, $method->countries4, $method->tax_id4, $method);
		$this->parseMethodRule ($method->rules5, $method->countries5, $method->tax_id5, $method);
		$this->parseMethodRule ($method->rules6, $method->countries6, $method->tax_id6, $method);
		$this->parseMethodRule ($method->rules7, $method->countries7, $method->tax_id7, $method);
		$this->parseMethodRule ($method->rules8, $method->countries8, $method->tax_id8, $method);
	}

	/** Functions to calculate all the different variables for the given cart and given (sub)set of products in the cart */
	protected function getOrderArticles (VirtueMartCart $cart, $products) {
		$articles = 0;
		foreach ($products as $product) {
			$articles += $product->quantity;
		}
		return $articles;
	}

	protected function getOrderProducts (VirtueMartCart $cart, $products) {
		return count($products);
	}

	protected function getOrderDimensions (VirtueMartCart $cart, $products, $length_dimension) {
		/* Cache the value in a static variable and calculate it only once! */
		$dimensions=array(
			'volume' => 0,
			'maxvolume' => 0, 'minvolume' => 9999999999,
			'maxlength' => 0, 'minlength' => 9999999999, 'totallength' => 0,
			'maxwidth'  => 0, 'minwidth' => 9999999999,  'totalwidth'  => 0,
			'maxheight' => 0, 'minheight' => 9999999999, 'totalheight' => 0,
			'maxpackaging' => 0, 'minpackaging' => 9999999999, 'totalpackaging' => 0,
		);
		foreach ($products as $product) {
	
			$l = ShopFunctions::convertDimensionUnit ($product->product_length, $product->product_lwh_uom, $length_dimension);
			$w = ShopFunctions::convertDimensionUnit ($product->product_width, $product->product_lwh_uom, $length_dimension);
			$h = ShopFunctions::convertDimensionUnit ($product->product_height, $product->product_lwh_uom, $length_dimension);

			$volume = $l * $w * $h;
			$dimensions['volume'] += $volume * $product->quantity;
			$dimensions['maxvolume'] = max ($dimensions['maxvolume'], $volume);
			$dimensions['minvolume'] = min ($dimensions['minvolume'], $volume);
				
			$dimensions['totallength'] += $l * $product->quantity;
			$dimensions['maxlength'] = max ($dimensions['maxlength'], $l);
			$dimensions['minlength'] = min ($dimensions['minlength'], $l);
			$dimensions['totalwidth'] += $w * $product->quantity;
			$dimensions['maxwidth'] = max ($dimensions['maxwidth'], $w);
			$dimensions['minwidth'] = min ($dimensions['minwidth'], $w);
			$dimensions['totalheight'] += $h * $product->quantity;
			$dimensions['maxheight'] = max ($dimensions['maxheight'], $h);
			$dimensions['minheight'] = min ($dimensions['minheight'], $h);
			$dimensions['totalpackaging'] += $product->product_packaging * $product->quantity;
			$dimensions['maxpackaging'] = max ($dimensions['maxpackaging'], $product->product_packaging);
			$dimensions['minpackaging'] = min ($dimensions['minpackaging'], $product->product_packaging);
		}

		return $dimensions;
	}
	
	protected function getOrderWeights (VirtueMartCart $cart, $products, $weight_unit) {
		$dimensions=array(
			'weight' => 0,
			'maxweight' => 0, 'minweight' => 9999999999,
		);
		foreach ($products as $product) {
			$w = ShopFunctions::convertWeigthUnit ($product->product_weight, $product->product_weight_uom, $weight_unit);
			$dimensions['maxweight'] = max ($dimensions['maxweight'], $w);
			$dimensions['minweight'] = min ($dimensions['minweight'], $w);
			$dimensions['weight'] += $w * $product->quantity;
		}
		return $dimensions;
	}
	
	protected function getOrderListProperties (VirtueMartCart $cart, $products) {
		$categories = array();
		$vendors = array();
		$skus = array();
		$manufacturers = array();
		foreach ($products as $product) {
			$skus[] = $product->product_sku;
			$categories = array_merge ($categories, $product->categories);
			$vendors[] = $product->virtuemart_vendor_id;
			if (is_array($product->virtuemart_manufacturer_id)) {
				$manufacturers = array_merge($manufacturers, $product->virtuemart_manufacturer_id);
			} elseif ($product->virtuemart_manufacturer_id) {
				$manufacturers[] = $product->virtuemart_manufacturer_id;
			}
		}
		$skus = array_unique($skus);
		$vendors = array_unique($vendors);
		$categories = array_unique($categories);
		$manufacturers = array_unique($manufacturers);
		return array ('skus'=>$skus, 
			      'categories'=>$categories,
			      'vendors'=>$vendors,
			      'manufacturers'=>$manufacturers,
		);
	}
	
	protected function getOrderCountryState (VirtueMartCart $cart, $address) {
		$data = array (
			'countryid' => 0, 'country' => '', 'country2' => '', 'country3' => '',
			'stateid'   => 0, 'state'   => '', 'state2'   => '', 'state3'   => '',
		);
		
		$countriesModel = VmModel::getModel('country');
		if (isset($address['virtuemart_country_id'])) {
			$data['countryid'] = $address['virtuemart_country_id'];
			// The following is a workaround to make sure the cache is invalidated
			// because if some other extension meanwhile called $countriesModel->getCountries,
			// the cache will be modified, but the model's id will not be changes, so the
			// getData call will return the wrong cache.
			$countriesModel->setId(0); 
			$countriesModel->setId($address['virtuemart_country_id']);
			$country = $countriesModel->getData($address['virtuemart_country_id']);
			if (!empty($country)) {
				$data['country'] = $country->country_name;
				$data['country2'] = $country->country_2_code;
				$data['country3'] = $country->country_3_code;
			}
		}
		
		$statesModel = VmModel::getModel('state');
		if (isset($address['virtuemart_state_id'])) {
			$data['stateid'] = $address['virtuemart_state_id'];
			// The following is a workaround to make sure the cache is invalidated
			// because if some other extension meanwhile called $countriesModel->getCountries,
			// the cache will be modified, but the model's id will not be changes, so the
			// getData call will return the wrong cache.
			$statesModel->setId(0); 
			$statesModel->setId($address['virtuemart_state_id']);
			$state = $statesModel->getData($address['virtuemart_state_id']);
			if (!empty($state)) {
				$data['state'] = $state->state_name;
				$data['state2'] = $state->state_2_code;
				$data['state3'] = $state->state_3_code;
			}
		}
		
		return $data;

	}
	
	protected function getOrderAddress (VirtueMartCart $cart, $address) {
		$zip = isset($address['zip'])?trim($address['zip']):'';
		$data = array('zip'=>$zip,
			'zip1'=>substr($zip,0,1),
			'zip2'=>substr($zip,0,2),
			'zip3'=>substr($zip,0,3),
			'zip4'=>substr($zip,0,4),
			'zip5'=>substr($zip,0,5),
			'zip6'=>substr($zip,0,6),
			'city'=>isset($address['city'])?trim($address['city']):'',
		);
		$data['company'] = isset($address['company'])?$address['company']:'';
		$data['title'] = isset($address['title'])?$address['title']:'';
		$data['first_name'] = isset($address['title'])?$address['title']:'';
		$data['middle_name'] = isset($address['middle_name'])?$address['middle_name']:'';
		$data['last_name'] = isset($address['last_name'])?$address['last_name']:'';
		$data['address1'] = isset($address['address_1'])?$address['address_1']:'';
		$data['address2'] = isset($address['address_2'])?$address['address_2']:'';
		$data['city'] = isset($address['city'])?$address['city']:'';
		$data['phone1'] = isset($address['phone_1'])?$address['phone_1']:'';
		$data['phone2'] = isset($address['phone_2'])?$address['phone_2']:'';
		$data['fax'] = isset($address['fax'])?$address['fax']:'';
		$data['email'] = isset($address['email'])?$address['email']:'';
		return $data;
	}
	
	protected function getOrderPrices (VirtueMartCart $cart, $products, $cart_prices) {
		$data = array(
			'amount' => 0, 
			'amountwithtax' => 0, 
			'amountwithouttax' => 0, 
			'baseprice' => 0, 
			'basepricewithtax' => 0, 
			'discountedpricewithouttax' => 0, 
			'salesprice' => 0, 
			'taxamount' => 0, 
			'salespricewithdiscount' => 0, 
			'discountamount' => 0, 
			'pricewithouttax' => 0,
		);
		if (!empty($cart_prices)) {
			// get prices for the whole cart -> simply user the cart_prices
			$data['amount']                 = $cart_prices['salesPrice'];
			$data['amountwithtax']          = $cart_prices['salesPrice'];
			$data['amountwithouttax']       = $cart_prices['priceWithoutTax'];
			$data['baseprice']              = $cart_prices['basePrice'];
			$data['basepricewithtax']       = $cart_prices['basePriceWithTax'];
			$data['discountedpricewithouttax'] = $cart_prices['discountedPriceWithoutTax'];
			$data['salesprice']             = $cart_prices['salesPrice'];
			$data['taxamount']              = $cart_prices['taxAmount'];
			$data['salespricewithdiscount'] = $cart_prices['salesPriceWithDiscount'];
			$data['discountamount']         = $cart_prices['discountAmount'];
			$data['pricewithouttax']        = $cart_prices['priceWithoutTax'];
		} else {
			// Calculate the prices from the individual products!
			// Possible problems are discounts on the order total
			foreach ($products as $product) {
				$data['amount']                    += $product->quantity*$product->allPrices[$product->selectedPrice]['salesPrice'];
				$data['amountwithtax']             += $product->quantity*$product->allPrices[$product->selectedPrice]['salesPrice'];
				$data['amountwithouttax']          += $product->quantity*$product->allPrices[$product->selectedPrice]['priceWithoutTax'];
				$data['baseprice']                 += $product->quantity*$product->allPrices[$product->selectedPrice]['basePrice'];
				$data['basepricewithtax']          += $product->quantity*$product->allPrices[$product->selectedPrice]['basePriceWithTax'];
				$data['discountedpricewithouttax'] += $product->quantity*$product->allPrices[$product->selectedPrice]['discountedPriceWithoutTax'];
				$data['salesprice']                += $product->quantity*$product->allPrices[$product->selectedPrice]['salesPrice'];
				$data['taxamount']                 += $product->quantity*$product->allPrices[$product->selectedPrice]['taxAmount'];
				$data['salespricewithdiscount']    += $product->quantity*$product->allPrices[$product->selectedPrice]['salesPriceWithDiscount'];
				$data['discountamount']            += $product->quantity*$product->allPrices[$product->selectedPrice]['discountAmount'];
				$data['pricewithouttax']           += $product->quantity*$product->allPrices[$product->selectedPrice]['priceWithoutTax'];
			}
		}
		return $data;
	}

	/** Allow child classes to add additional variables for the rules or modify existing one
	 */
	protected function addCustomCartValues (VirtueMartCart $cart, $products, $cart_prices, &$values) {
	}

	public function getCartValues (VirtueMartCart $cart, $products, $method, $cart_prices) {
		$address = (($cart->ST == 0 || $cart->STsameAsBT == 1) ? $cart->BT : $cart->ST);
		$cartvals = array_merge (
			array(
				'articles'=>$this->getOrderArticles($cart, $products),
				'products'=>$this->getOrderProducts($cart, $products),
			),
			// Add the prices, optionally calculated from the products subset of the cart
			$this->getOrderPrices ($cart, $products, $cart_prices),
			// Add 'skus', 'categories', 'vendors' variables:
			$this->getOrderListProperties ($cart, $products),
			// Add country / state variables:
			$this->getOrderAddress ($cart, $address),
			$this->getOrderCountryState ($cart, $address),
			// Add Total/Min/Max weight and dimension variables:
			$this->getOrderWeights ($cart, $products, $method->weight_unit),
			$this->getOrderDimensions ($cart, $products, $method->length_unit)
		);
		// Let child classes update the $cartvals array, or add new variables
		$this->addCustomCartValues($cart, $products, $cart_prices, $cartvals);

		// Finally, call the triger of vmshipmentrules plugins to let them add/modify variables
		JPluginHelper::importPlugin('vmshipmentrules');
		JDispatcher::getInstance()->trigger('onVmShippingRulesGetCartValues',array(&$cartvals, $cart, $products, $method, $cart_prices));

		return $cartvals;
	}

	/**
	 * Create the table for this plugin if it does not yet exist.
	 * This functions checks if the called plugin is active one.
	 * When yes it is calling the standard method to create the tables
	 *
	 * @author Valérie Isaksen
	 *
	 */
	function plgVmOnStoreInstallShipmentPluginTable ($jplugin_id) {
		return $this->onStoreInstallPluginTable ($jplugin_id);
	}

	/**
	 * @param VirtueMartCart $cart
	 * @return null
	 */
	public function plgVmOnSelectCheckShipment (VirtueMartCart &$cart) {
		return $this->OnSelectCheck ($cart);
	}

	/**
	 * plgVmDisplayListFE
	 * This event is fired to display the pluginmethods in the cart (edit shipment/payment) for example
	 *
	 * @param object  $cart Cart object
	 * @param integer $selected ID of the method selected
	 * @return boolean True on success, false on failures, null when this plugin was not selected.
	 * On errors, JError::raiseWarning (or JError::raiseError) must be used to set a message.
	 *
	 * @author Valerie Isaksen
	 * @author Max Milbers
	 */
	public function plgVmDisplayListFEShipment (VirtueMartCart $cart, $selected = 0, &$htmlIn) {
		return $this->displayListFE ($cart, $selected, $htmlIn);
	}

	/**
	 * @param VirtueMartCart $cart
	 * @param array          $cart_prices
	 * @param                $cart_prices_name
	 * @return bool|null
	 */
	public function plgVmOnSelectedCalculatePriceShipment (VirtueMartCart $cart, array &$cart_prices, &$cart_prices_name) {
		return $this->onSelectedCalculatePrice ($cart, $cart_prices, $cart_prices_name);
	}

	/**
	 * plgVmOnCheckAutomaticSelected
	 * Checks how many plugins are available. If only one, the user will not have the choice. Enter edit_xxx page
	 * The plugin must check first if it is the correct type
	 *
	 * @author Valerie Isaksen
	 * @param VirtueMartCart cart: the cart object
	 * @return null if no plugin was found, 0 if more then one plugin was found,  virtuemart_xxx_id if only one plugin is found
	 *
	 */
	function plgVmOnCheckAutomaticSelectedShipment (VirtueMartCart $cart, array $cart_prices = array(), &$shipCounter) {
		if ($shipCounter > 1) {
			return 0;
		}
		return $this->onCheckAutomaticSelected ($cart, $cart_prices, $shipCounter);
	}

	/**
	 * This method is fired when showing when priting an Order
	 * It displays the the payment method-specific data.
	 *
	 * @param integer $_virtuemart_order_id The order ID
	 * @param integer $method_id  method used for this order
	 * @return mixed Null when for payment methods that were not selected, text (HTML) otherwise
	 * @author Valerie Isaksen
	 */
	function plgVmonShowOrderPrint ($order_number, $method_id) {
		return $this->onShowOrderPrint ($order_number, $method_id);
	}

	function plgVmDeclarePluginParamsShipment ($name, $id, &$data) {
		return $this->declarePluginParams ('shipment', $name, $id, $data);
	}

	/* This function is needed in VM 2.0.14 etc. because otherwise the params are not saved */
	function plgVmSetOnTablePluginParamsShipment ($name, $id, &$table) {

		return $this->setOnTablePluginParams ($name, $id, $table);
	}

	function plgVmDeclarePluginParamsShipmentVM3 (&$data) {
		return $this->declarePluginParams ('shipment', $data);
	}

	function plgVmSetOnTablePluginShipment(&$data,&$table){

		$name = $data['shipment_element'];
		$id = $data['shipment_jplugin_id'];

		if (!empty($this->_psType) and !$this->selectedThis ($this->_psType, $name, $id)) {
			return FALSE;
		}
		if (isset($data['rules1'])) {
			// Try to parse all rules (and spit out error) to inform the user. There is no other 
			// reason to parse the rules here, it's really only to trigger warnings/errors in case of a syntax error.
			$method = new StdClass ();
			$method->virtuemart_shipmentmethod_id = $data['virtuemart_shipmentmethod_id'];
			$this->parseMethodRule ($data['rules1'], isset($data['countries1'])?$data['countries1']:array(), $data['tax_id1'], $method);
			$this->parseMethodRule ($data['rules2'], isset($data['countries2'])?$data['countries2']:array(), $data['tax_id2'], $method);
			$this->parseMethodRule ($data['rules3'], isset($data['countries3'])?$data['countries3']:array(), $data['tax_id3'], $method);
			$this->parseMethodRule ($data['rules4'], isset($data['countries4'])?$data['countries4']:array(), $data['tax_id4'], $method);
			$this->parseMethodRule ($data['rules5'], isset($data['countries5'])?$data['countries5']:array(), $data['tax_id5'], $method);
			$this->parseMethodRule ($data['rules6'], isset($data['countries6'])?$data['countries6']:array(), $data['tax_id6'], $method);
			$this->parseMethodRule ($data['rules7'], isset($data['countries7'])?$data['countries7']:array(), $data['tax_id7'], $method);
			$this->parseMethodRule ($data['rules8'], isset($data['countries8'])?$data['countries8']:array(), $data['tax_id8'], $method);
		}
		$ret=$this->setOnTablePluginParams ($name, $id, $table);
		return $ret;
	}

}

if (class_exists ('ShippingRule')) {
	return;
}

/** Filter the given array of products and return only those that belong to the categories, manufacturers, 
 *  vendors or products given in the $filter_conditions. The $filter_conditions is an array of the form:
 *     array( 'skus'=>array(....), 'categories'=>array(1,2,3,42), 'manufacturers'=>array(77,78,83), 'vendors'=>array(1,2))
 *  Notice that giving an empty array for any of the keys means "no restriction" and is exactly the same 
 *  as leaving out the enty altogether
 */
function filterProducts($products, $filter_conditions) {
	$result = array();
	foreach ($products as $p) {
// JFactory::getApplication()->enqueueMessage("<pre>Product: ".print_r($p,1)."</pre>", 'error');
		if (!empty($filter_conditions['skus']) && !in_array($p->product_sku, $filter_conditions['skus']))
			continue;
		if (!empty($filter_conditions['categories']) && count(array_intersect($filter_conditions['categories'], $p->categories))==0)
			continue;
		if (!empty($filter_conditions['manufacturers']) && count(array_intersect($filter_conditions['manufacturers'], $p->virtuemart_manufacturer_id))==0)
			continue;
		if (!empty($filter_conditions['vendors']) && !in_array($p->virtuemart_vendor_id, $filter_conditions['vendors']))
			continue;
		$result[] = $p;
	}
	return $result;
}
	

class ShippingRule {
	var $plugin = Null;
	var $rulestring = '';
	var $name = '';
	var $ruletype = '';
	var $evaluated = False;
	var $match = False;
	var $value = Null;
	
	var $shipping = 0;
	var $conditions = array();
	var $countries = array();
	var $tax_id = 0;
	var $includes_tax = 0;
	
	function __construct ($plugin, $rule, $countries, $tax_id) {
		if (is_array($countries)) {
			$this->countries = $countries;
		} elseif (!empty($countries)) {
			$this->countries[0] = $countries;
		}
		$this->tax_id = $tax_id;
		$this->rulestring = $rule;
		$this->parseRule($rule);
		$this->plugin=$plugin;
	}
	
	protected function parseRule($rule) {
		$ruleparts=explode(';', $rule);
		foreach ($ruleparts as $p) {
			$this->parseRulePart($p);
		}
	}
	
	protected function handleAssignment ($var, $value, $rulepart) {
		switch (strtolower($var)) {
			case 'name':            $this->name = $value; break;
			case 'shipping':        $this->shipping = $value; $this->includes_tax = False; $this->ruletype='shipping'; break;
			case 'shippingwithtax': $this->shipping = $value; $this->includes_tax = True; $this->ruletype='shipping'; break;
			case 'variable':        // Variable=... is the same as Definition=...
			case 'definition':      $this->name = strtolower($value); $this->ruletype = 'definition'; break;
			case 'value':           $this->shipping = $value; $this->ruletype = 'definition'; break; // definition values are also stored in the shipping member!
			case 'extrashippingcharge': $this->shipping = $value; $this->ruletype = 'modifiers_add'; break; // modifiers are also stored in the shipping member!
			case 'extrashippingmultiplier': $this->shipping = $value; $this->ruletype = 'modifiers_multiply'; break; // modifiers are also stored in the shipping member!
			case 'comment':         break; // Completely ignore all comments!
			case 'condition':       $this->conditions[] = $value; break;
			default:                JFactory::getApplication()->enqueueMessage(JText::sprintf('VMSHIPMENT_RULES_UNKNOWN_VARIABLE', $var, $rulepart), 'error');
		}
	}
	
	protected function tokenize_expression ($expression) {
		// First, extract all strings, delimited by quotes, then all text operators 
		// (OR, AND, in; but make sure we don't capture parts of words, so we need to 
		// use lookbehind/lookahead patterns to exclude OR following another letter 
		// or followed by another letter) and then all arithmetic operators
		$re = '/\s*("[^"]*"|\'[^\']*\'|<=|=>|>=|=<|<>|!=|==|<|=|>)\s*/i';
		$atoms = preg_split($re, $expression, -1, PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY);
		// JFactory::getApplication()->enqueueMessage("TOKENIZING '$expression' returns: <pre>".print_r($atoms,1)."</pre>", 'error');
		return $atoms;
	}
	
	protected function parseRulePart($rulepart) {
		/* In the basic version, we only split at the comparison operators and assume each term on the LHS and RHS is one variable or constant */
		/* In the advanced version, all conditions and costs can be given as a full mathematical expression */
		/* Both versions create an expression tree, which can be easily evaluated in evaluateTerm */
		$rulepart = trim($rulepart);
		if (empty($rulepart)) return;

		
		// Special-case the name assignment, where we don't want to interpret the value as an arithmetic expression!
		if (preg_match('/^\s*(name|variable|definition)\s*=\s*(["\']?)(.*)\2\s*$/i', $rulepart, $matches)) {
			$this->handleAssignment ($matches[1], $matches[3], $rulepart);
			return;
		}

		// Split at all operators:
		$atoms = $this->tokenize_expression ($rulepart);
		
		/* TODO: Starting from here, the advanced plugin is different! */
		$operators = array('<', '<=', '=', '>', '>=', '=>', '=<', '<>', '!=', '==');
		if (count($atoms)==1) {
			$this->shipping = $this->parseShippingTerm($atoms[0]);
			$this->ruletype = 'shipping';
		} elseif ($atoms[1]=='=') {
			$this->handleAssignment ($atoms[0], $atoms[2], $rulepart);
		} else {
			// Conditions, need at least three atoms!
			while (count($atoms)>1) {
				if (in_array ($atoms[1], $operators)) {
					$this->conditions[] = array($atoms[1], $this->parseShippingTerm($atoms[0]), $this->parseShippingTerm($atoms[2]));
					array_shift($atoms);
					array_shift($atoms);
				} else {
					JFactory::getApplication()->enqueueMessage(JText::sprintf('VMSHIPMENT_RULES_UNKNOWN_OPERATOR', $atoms[1], $rulepart), 'error');
					$atoms = array();
				}
			}
		}
	}

	protected function parseShippingTerm($expr) {
		/* In the advanced version, shipping cost can be given as a full mathematical expression */
		// If the shipping term starts with a double quote, it is a string, so don't turn it into lowercase.
		// All other expressions need to be turned into lowercase, because variable names are case-insensitive!
		if (substr($expr, 0, 1) === '"') {
			return $expr;
		} else {
			return strtolower($expr);
		}
	}
	
	protected function evaluateComparison ($terms, $vals) {
		while (count($terms)>2) {
			$res = false;
			switch ($terms[1]) {
				case '<':  $res = ($terms[0] < $terms[2]);  break;
				case '<=':
				case '=<': $res = ($terms[0] <= $terms[2]); break;
				case '==': $res = is_equal($terms[0], $terms[2]); break;
				case '!=':
				case '<>': $res = ($terms[0] != $terms[2]); break;
				case '>=':
				case '=>': $res = ($terms[0] >= $terms[2]); break;
				case '>':  $res = ($terms[0] >  $terms[2]);  break;
				case '~':
					$l=min(strlen($terms[0]), strlen($terms[2]));
					$res = (strncmp ($terms[0], $terms[2], $l) == 0);
					break;
				default:
					JFactory::getApplication()->enqueueMessage(JText::sprintf('VMSHIPMENT_RULES_UNKNOWN_OPERATOR', $terms[1], $this->rulestring), 'error');
					$res = false;
			}

			if ($res==false) return false;
			// Remove the first operand and the operator from the comparison:
			array_shift($terms);
			array_shift($terms);
		}
		if (count($terms)>1) {
			// We do not have the correct number of terms for chained comparisons, i.e. two terms leftover instead of one!
			JFactory::getApplication()->enqueueMessage(JText::sprintf('VMSHIPMENT_RULES_EVALUATE_UNKNOWN_ERROR', $this->rulestring), 'error');
			return false;
		}
		// All conditions were fulfilled, so we can return true
		return true;
	}
	
	protected function evaluateListFunction ($function, $args) {
		# First make sure that all arguments are actually lists:
		$allarrays = True;
		foreach ($args as $a) {
			$allarrays = $allarrays && is_array($a);
		}
		if (!$allarrays) {
			JFactory::getApplication()->enqueueMessage(JText::sprintf('VMSHIPMENT_RULES_EVALUATE_LISTFUNCTION_ARGS', $function, $this->rulestring), 'error');
			return false;
			
		}
		switch ($function) {
			case "length":		return count($args[0]); break;
			case "union": 
			case "join":		return call_user_func_array( "array_merge" , $args); break;
			case "complement":	return call_user_func_array( "array_diff" , $args); break;
			case "intersection":	return call_user_func_array( "array_intersect" , $args); break;
			case "issubset":	# Remove all of superset's elements to see if anything else is left: 
						return !array_diff($args[0], $args[1]); break;
			case "contains":	# Remove all of superset's elements to see if anything else is left: 
						# Notice the different argument order compared to issubset!
						return !array_diff($args[1], $args[0]); break;
			case "list_equal":	return array_unique($args[0])==array_unique($args[1]); break;
			default: 
				JFactory::getApplication()->enqueueMessage(JText::sprintf('VMSHIPMENT_RULES_EVALUATE_LISTFUNCTION_UNKNOWN', $function, $this->rulestring), 'error');
				return false;
		}
	}
	
	protected function evaluateListContainmentFunction ($function, $args) {
		# First make sure that the first argument is a list:
		if (!is_array($args[0])) {
			JFactory::getApplication()->enqueueMessage(JText::sprintf('VMSHIPMENT_RULES_EVALUATE_LISTFUNCTION_CONTAIN_ARGS', $function, $this->rulestring), 'error');
			return false;
		}
		// Extract the array from the args, the $args varialbe will now only contain the elements to be checked:
		$array = array_shift($args);
		switch ($function) {
			case "contains_any": // return true if one of the $args is in the $array
					foreach ($args as $a) { 
						if (in_array($a, $array)) 
							return true; 
					}
					return false;
			
			case "contains_all": // return false if one of the $args is NOT in the $array
					foreach ($args as $a) { 
						if (!in_array($a, $array)) 
							return false; 
					}
					return true;
			case "contains_only": // return false if one of the $array elements is NOT in $args
					foreach ($array as $a) {
						if (!in_array($a, $args))
							return false;
					}
					return true;
			case "contains_none": // return false if one of the $args IS in the $array
					foreach ($args as $a) {
						if (in_array($a, $array))
							return false;
					}
					return true;
			default: 
				JFactory::getApplication()->enqueueMessage(JText::sprintf('VMSHIPMENT_RULES_EVALUATE_LISTFUNCTION_UNKNOWN', $function, $this->rulestring), 'error');
				return false;
		}
	}
	
	/** Evaluate the given expression $expr only for the products that match the filter given by the scoping 
	 * function and the corresponding conditions */
	protected function evaluateScoping($expr, $scoping, $conditionvals, $vals, $products, $cartvals_callback) {
// JFactory::getApplication()->enqueueMessage("<pre>Scoping, begin, scoping=$scoping, expression=".print_r($expr,1).", conditionvals=".print_r($conditionvals, 1)."</pre>", 'error');
		if (count($conditionvals)<1)
			return $this->evaluateTerm($expr, $vals, $products, $cartvals_callback);

		$filterkeys = array( 
			"evaluate_for_categories" =>    'categories',
			"evaluate_for_products" =>      'skus',
			"evaluate_for_skus" =>          'skus',
			"evaluate_for_vendors" =>       'vendors',
			"evaluate_for_manufacturers" => 'manufacturers',
		);
		
		$conditions = array();
		if (isset($filterkeys[$scoping])) 
			$conditions[$filterkeys[$scoping]] = $conditionvals;

		// Pass the conditions to the parent plugin class to filter the current list of products:
		$filteredproducts = filterProducts($products, $conditions);
		// We have been handed a callback function to calculate the cartvals for the filtered list of products, so use it:
		$filteredvals = $cartvals_callback($filteredproducts);
		return $this->evaluateTerm ($expr, $filteredvals, $filteredproducts, $cartvals_callback);
	}

	protected function evaluateFunction ($function, $args) {
		$func = strtolower($function);
		// Check if we have a custom function definition and use that if so.
		// This is done first to allow plugins to override even built-in functions!
		if (isset($this->plugin->custom_functions[$func])) {
			vmDebug("Evaluating custom function $function, defined by a plugin");
			return call_user_func($this->plugin->custom_functions[$func], $args, $this);
		}

		// Functions with no argument:
		if (count($args) == 0) {
			$dt = getdate();
			switch ($func) {
				case "second": return $dt['seconds']; break;
				case "minute": return $dt['minutes']; break;
				case "hour":   return $dt['hours']; break;
				case "day":    return $dt['mday']; break;
				case "weekday":return $dt['wday']; break;
				case "month":  return $dt['mon']; break;
				case "year":   return $dt['year']; break;
				case "yearday":return $dt['yday']; break;
			}
		}
		// Functions with exactly one argument:
		if (count($args) == 1) {
			switch ($func) {
				case "round": return round($args[0]); break;
				case "ceil":  return ceil ($args[0]); break;
				case "floor": return floor($args[0]); break;
				case "abs":   return abs($args[0]); break;
				case "not":   return !$args[0]; break;
				case "print_r": return print_r($args[0],1); break; 
			}
		}
		if (count($args) == 2) {
			switch ($func) {
				case "digit": return substr($args[0], $args[1]-1, 1); break;
				case "round": return round($args[0]/$args[1])*$args[1]; break;
				case "ceil":  return ceil($args[0]/$args[1])*$args[1]; break;
				case "floor": return floor($args[0]/$args[1])*$args[1]; break;
			}
		}
		if (count($args) == 3) {
			switch ($func) {
				case "substring": return substr($args[0], $args[1]-1, $args[2]); break;
			}
		}
		// Functions with variable number of args
		switch ($func) {
			case "max": 
					return max($args);
			case "min": 
					return min($args);
			case "list": 
			case "array": 
					return $args;
			// List functions:
		    case "length":
		    case "complement":
		    case "issubset":
		    case "contains":
		    case "union":
		    case "join":
		    case "intersection":
		    case "list_equal":
					return $this->evaluateListFunction ($func, $args);
			case "contains_any": 
			case "contains_all":
			case "contains_only":
			case "contains_none":
					return $this->evaluateListContainmentFunction($func, $args);
			
		}
		
		// None of the built-in function 
		// No known function matches => print an error, return 0
		JFactory::getApplication()->enqueueMessage(JText::sprintf('VMSHIPMENT_RULES_EVALUATE_UNKNOWN_FUNCTION', $function, $this->rulestring), 'error');
		return 0;
	}

	protected function evaluateVariable ($expr, $vals) {
		$varname = strtolower($expr);
		if (array_key_exists(strtolower($expr), $vals)) {
			return $vals[strtolower($expr)];
		} elseif ($varname=='noshipping') {
			return $varname;
		} elseif ($varname=='values') {
			return $vals;
		} elseif ($varname=='values_debug') {
			return print_r($vals,1);
		} else {
			JFactory::getApplication()->enqueueMessage(JText::sprintf('VMSHIPMENT_RULES_EVALUATE_UNKNOWN_VALUE', $expr, $this->rulestring), 'error');
			return null;
		}
	}

	protected function evaluateTerm ($expr, $vals, $products, $cartvals_callback) {
		// The scoping functions need to be handled differently, because they first need to adjust the cart variables to the filtered product list
		// before evaluating its first argument. So even though parsing the rules handles scoping functions like any other function, their 
		// evaluation is fundamentally different and is special-cased here:
		$scoping_functions = array("evaluate_for_categories", "evaluate_for_products", "evaluate_for_skus", "evaluate_for_vendors", "evaluate_for_manufacturers");
		$is_scoping = is_array($expr) && ($expr[0]=="FUNCTION") && (count($expr)>1) && in_array($expr[1], $scoping_functions);

		if (is_null($expr)) {
			return $expr;
		} elseif (is_numeric ($expr)) {
			return $expr;
		} elseif (is_string ($expr)) {
			// Explicit strings are delimited by '...' or "..."
			if (($expr[0]=='\'' || $expr[0]=='"') && ($expr[0]==substr($expr,-1)) ) {
				return substr($expr,1,-1);
			} else {
				return $this->evaluateVariable($expr, $vals);
			}
		} elseif ($is_scoping) {
			$op = array_shift($expr); // ignore the "FUNCTION"
			$func = array_shift($expr); // The scoping function name
			$expression = array_shift($expr); // The expression to be evaluated
			// the remaining $expr list now contains the conditions. Evaluate them one by one:
			$conditions = array();
			foreach ($expr as $e) {
				$conditions[] = $this->evaluateTerm($e, $vals, $products, $cartvals_callback);
			}
			return $this->evaluateScoping ($expression, $func, $conditions, $vals, $products, $cartvals_callback);
			
		} elseif (is_array($expr)) {
			// Operator
			$op = array_shift($expr);
			$args = array();
			// First evaluate all operands and only after that apply the function / operator to the already evaluated arguments
			$evaluate = true;
			if ($op == "FUNCTION") {
				$evaluate = false;
			}
			foreach ($expr as $e) {
				$term = $evaluate ? ($this->evaluateTerm($e, $vals, $products, $cartvals_callback)) : $e;
				if ($op == 'COMPARISON') {
					// For comparisons, we only evaluate every other term (the operators are NOT evaluated!)
					// The data format for comparisons is: array('COMPARISON', $operand1, '<', $operand2, '<=', ....)
					$evaluate = !$evaluate;
				}
				if ($op == "FUNCTION") {
					$evaluate = true;
				}
				if (is_null($term)) return null;
				$args[] = $term;
			}
			$res = false;
			// Finally apply the operaton to the evaluated argument values:
			switch ($op) {
				// Logical operators:
				case 'OR':  foreach ($args as $a) { $res = ($res || $a); }; break;
				case '&&':
				case 'AND':  $res = true; foreach ($args as $a) { $res = ($res && $a); }; break;
				case 'IN': $res = in_array($args[0], $args[1]);  break;
				
				// Comparisons:
				case '<':
				case '<=':
				case '=<':
				case '==':
				case '!=':
				case '<>':
				case '>=':
				case '=>':
				case '>':
				case '~':
					$res = $this->evaluateComparison(array($args[0], $op, $args[1]), $vals); break;
				case 'COMPARISON':
					$res = $this->evaluateComparison($args, $vals); break;
				
				// Unary operators:
				case '.-': $res = -$args[0]; break;
				case '.+': $res = $args[0]; break;
				
				// Binary operators
				case "+":  $res = ($args[0] +  $args[1]); break;
				case "-":  $res = ($args[0] -  $args[1]); break;
				case "*":  $res = ($args[0] *  $args[1]); break;
				case "/":  $res = ($args[0] /  $args[1]); break;
				case "%":  $res = (fmod($args[0],  $args[1])); break;
				case "^":  $res = ($args[0] ^  $args[1]); break;
				
				// Functions:
				case "FUNCTION": $func = array_shift($args); $res = $this->evaluateFunction($func, $args); break;
				
				default:   $res = false;
			}
			
// 			JFactory::getApplication()->enqueueMessage("<pre>Result of ".print_r($expr,1)." is $res.</pre>", 'error');
			return $res;
		} else {
			// Neither string nor numeric, nor operator...
			JFactory::getApplication()->enqueueMessage(JText::sprintf('VMSHIPMENT_RULES_EVALUATE_UNKNOWN_VALUE', $expr, $this->rulestring), 'error');
			return null;
		}
	}

	protected function calculateShipping ($vals, $products, $cartvals_callback) {
		return $this->evaluateTerm($this->shipping, $vals, $products, $cartvals_callback);
	}

	protected function evaluateRule (&$vals, $products, $cartvals_callback) {
		if ($this->evaluated) 
			return; // Already evaluated

		$this->evaluated = True;
		$this->match = False; // Default, set it to True below if all conditions match...
		// First, check the country, if any conditions are given:
		if (count ($this->countries) > 0 && !in_array ($vals['countryid'], $this->countries)) {
// 			vmdebug('Rule::matches: Country check failed: countryid='.print_r($vals['countryid'],1).', countries are: '.print_r($this->countries,1).'...');
			return;
		}

		foreach ($this->conditions as $c) {
			// All conditions have to match!
			$ret = $this->evaluateTerm($c, $vals, $products, $cartvals_callback);

			if (is_null($ret) || (!$ret)) {
				return;
			}
		}
		// All conditions match
		$this->match = True;
		// Calculate the value (i.e. shipping cost or modifier)
		$this->value = $this->calculateShipping($vals, $products, $cartvals_callback);
		// Evaluate the rule name as a translatable string with variables inserted:
		// Replace all {variable} tags in the name by the variables from $vals
		$matches=array();
		$name=JText::_($this->name);
		preg_match_all('/{([A-Za-z0-9_]+)}/', $name, $matches);
		
		foreach ($matches[1] as $m) {
			$val = $this->evaluateVariable($m, $vals);
			if ($val !== null) {
				$name = str_replace("{".$m."}", $val, $name);
			}
		}
		$this->rulename = $name;
	}

	function matches(&$vals, $products, $cartvals_callback) {
		$this->evaluateRule($vals, $products, $cartvals_callback);
		return $this->match;
	}

	function getType() {
		return $this->ruletype;
	}

	function getRuleName() {
		if (!$this->evaluated)
			vmDebug('WARNING: getRuleName called without prior evaluation of the rule, e.g. by calling rule->matches(...)');
		return $this->rulename;
	}
	
	function getValue() {
		if (!$this->evaluated)
			vmDebug('WARNING: getValue called without prior evaluation of the rule, e.g. by calling rule->matches(...)');
		return $this->value;
	}
	function getShippingCosts() {
		return $this->getValue();
	}
	
	function isNoShipping() {
		// NoShipping is set, so if the rule matches, this method should not offer any shipping at all
		return (is_string($this->shipping) && (strtolower($this->shipping)=="noshipping"));
	}

}

// No closing tag
