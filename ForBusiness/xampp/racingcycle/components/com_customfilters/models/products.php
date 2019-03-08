<?php
/**
 *
 * Customfilters products model
 *
 * @package		customfilters
 * @author		Sakis Terz
 * @link		http://breakdesigns.net
 * @copyright	Copyright (c) 2010 - 2014 breakdesigns.net. All rights reserved.
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *				customfilters is free software. This version may have been modified
 *				pursuant to the GNU General Public License, and as distributed
 *				it includes or is derivative of works licensed under the GNU
 *				General Public License or other free or open source software
 *				licenses.
 * @version $Id: products.php 2014-06-02 14:08:00Z sakis $
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');
jimport( 'joomla.application.module.helper' );

require_once(JPATH_VM_ADMIN . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'product.php');

class CustomfiltersModelProducts extends VirtueMartModelProduct{
	private $published_cf;
	public $total;
	public $vmCurrencyHelper;
	protected $_currencyConverter;
	protected $componentparams;
	protected $menuparams;
	protected $moduleparams;
	public $vmVersion;

	/**
	 * The class constructor
	 * @since	1.0
	 * @author	Sakis Terz
	 */
	public function __construct($config = array()){
		$module=cftools::getModule();
		$this->menuparams=cftools::getMenuparams();
		$this->moduleparams=cftools::getModuleparams();
		$this->componentparams  = cftools::getComponentparams();
		$this->cfinputs=CfInput::getInputs($module);
		$this->vmVersion=VmConfig::getInstalledVersion();
		parent::__construct($config);
	}




	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return	void
	 * @since	1.0
	 */
	protected function populateState($ordering = 'ordering', $direction = 'ASC')
	{
		$app = JFactory::getApplication();
		$jinput=$app->input;
		$view = $jinput->get('view','products','cmd');
		//$config = JFactory::getConfig();

		//check multi-language
		$plugin =& JPluginHelper::getPlugin('system', 'languagefilter');
		$this->setState('langPlugin', $plugin);

		// List state information
		$default_limit=!empty($this->menuparams)?$this->menuparams->get('pagination_default_value','24'):VmConfig::get ('list_limit', 20);
		$limit = $app->getUserStateFromRequest('com_customfilters.products.limit', 'limit', $default_limit,'int');
		$limitstart = $jinput->get('limitstart', 0,'uint');

		//First setup the variables for filtering
		$filter_order = $jinput->get('orderby',$this->filter_order,'string');
		//maybe it is missing in older versions

		$this->filter_order_Dir= strtoupper($jinput->get('order', VmConfig::get('prd_brws_orderby_dir', 'ASC'),'cmd'));

		//sanitize Direction in case of invalid input
		if($this->filter_order_Dir!='ASC' && $this->filter_order_Dir!='DESC'){
			$this->filter_order_Dir ='ASC';
		}



		//echo $limit,$limitstart;
		$this->setState('list.limitstart', $limitstart);
		$this->setState('list.limit', $limit);
		$this->setState('filter_order', $filter_order);
		$this->setState('filter_order_Dir', $this->filter_order_Dir);
	}



	/**
	 * Method to get a list of products.
	 * Overriddes the the function defined in the com_virtuemart/models/product.php.
	 *
	 * @author	Sakis Terz
	 * @return	mixed	An array of data items on success, false on failure.
	 * @since	1.0
	 */
	public function getProductListing($group = false, $nbrReturnProducts = false, $withCalc = true, $onlyPublished = true, $single = false){
		$front = true;
		$user = JFactory::getUser();
		if (!($user->authorise('core.admin','com_virtuemart') or $user->authorise('core.manage','com_virtuemart'))) {
			$onlyPublished = true;
			if ($show_prices=VmConfig::get('show_prices',1) == '0'){
				$withCalc = false;
			}
		}

		//get the published custom filters
		$this->published_cf=cftools::getCustomFilters($this->moduleparams);
		$ids = $this->sortSearchListQuery($onlyPublished,$vmcat=false,$group,$nbrReturnProducts);
		$products = $this->getProducts($ids, $front, $withCalc, $onlyPublished,$single);
		return $products;
	}

	/**
	 *
	 * Returns the product ids after running the filtering sql queries
	 * Overriddes the function defined in the com_virtuemart/models/product.php.
	 * @param 	boolen	$onlyPublished only the published products
	 * @param 	string	$group	indicates some predefined groups
	 * @param 	Int $nbrReturnProducts
	 * @since	1.0
	 * @todo	Avoid joins if only 1 filter is selected. Just get the product id from it's table
	 */
	function sortSearchListQuery($onlyPublished=true,$vmcats=false,$group=false,$nbrReturnProducts=false){
		if($this->moduleparams->get('cf_profiler',0))$profiler=JProfiler::getInstance('application');
		if($this->moduleparams->get('cf_profiler',0))$profiler->mark('start');
		$vmCompatibility=VmCompatibility::getInstance();
		$app = JFactory::getApplication() ;
		$jinput=$app->input;
		$db=JFactory::getDbo();
		$query=$db->getQuery(true);
		$where=array();
		$where_product_ids=array();
		//joins initialization
		$join_prodcat=false;
		$join_prodlang=false;
		$joinCategory=false;
		$join_prodmnf=false;
		$joinMf=false;
		$joinPrice=false;
		$joinChildren=false;
		$joinShopper=false;

		//create the JRegistry with the module's params
		$resetType=$this->moduleparams->get('reset_results',0);

		if($jinput->get('reset',0,'int')==1 && $resetType==0 && empty($vm_categories))return;

		$query->select('DISTINCT SQL_CALC_FOUND_ROWS p.virtuemart_product_id');
		$query->from('#__virtuemart_products AS p');


		//stock control
		$stock=$jinput->get('virtuemart_stock',array(2),'array');
		if($stock[0]==1)$in_stock=true;
		else $in_stock=false;

		//----generate categories filter query---//
		if(isset($this->cfinputs['virtuemart_category_id'])){
			$vm_categories=$this->cfinputs['virtuemart_category_id'];
			$vm_categories=array_filter($vm_categories);
			if(count($vm_categories)>0 && isset($vm_categories[0])){
				JArrayHelper::toInteger($vm_categories);
				if(count($vm_categories)>0){
					$join_prodcat=true;
					$where[]=' pc.virtuemart_category_id IN ('.implode(',',$vm_categories).')';
				}
			}
		}


		//----generate manufacturers filter query---//
		if(isset($this->cfinputs['virtuemart_manufacturer_id']))$vm_manufacturers=$this->cfinputs['virtuemart_manufacturer_id'];

		if(isset($vm_manufacturers[0])){
			//set the selected manufs
			$join_prodmnf=true;
			$where[]=' p_m.virtuemart_manufacturer_id IN ('.implode(',',$vm_manufacturers).')';
		}


		//----generate price filter query---//
		if(isset($this->cfinputs['price'][0]))$price_from=$this->cfinputs['price'][0];
		if(isset($this->cfinputs['price'][1]))$price_to=$this->cfinputs['price'][1];

		if(!empty($price_from) || !empty($price_to)){
			$productIdsByPrice=$this->getProductIdsByPrice();
			if(!empty($productIdsByPrice)){
				$where_product_ids[]=$productIdsByPrice;
			}else if(is_array($productIdsByPrice))return;
		}


		//-----generate Custom fields filter---//
		//get the published filters
		$customFilters=$this->published_cf;
		$cfilter_found=false;

		if(!empty($customFilters)){
			foreach($customFilters as $cf){
				$cf_name='custom_f_'.$cf->custom_id;
				if($cf->disp_type!=5 && $cf->disp_type!=6 && $cf->disp_type!=8){//if not range
					if(isset($this->cfinputs[$cf_name]))$selected_cf=$this->cfinputs[$cf_name];
					else continue;

					//set the selected cfs
					$cfilter_found=true;
					$custom_search=array();

					//not plugin
					if($cf->field_type!='E'){
						$product_customvalues_table='`#__virtuemart_product_customfields`';
						foreach($selected_cf as $cf_val){
							$cf_value=cftools::cfHex2bin($cf_val);
							if(isset($cf_value))$custom_search[] ="(".$cf_name.'.'.$vmCompatibility->getColumnName('custom_value').' = '.$db->quote( $cf_value, true ).' AND '.$cf_name.'.'.$vmCompatibility->getColumnName('virtuemart_custom_id').'='.(int)$cf->custom_id.")";
						}
						if(!empty($custom_search))$where[] = " (".implode(' OR ', $custom_search ).") ";
					}else
					//plugin
					{
						//if the plugin has not declared the necessary params go to the next selected vars
						if(empty($cf->pluginparams))continue;
						//get vars from plugins
						$product_customvalues_table=$cf->pluginparams->product_customvalues_table;
						$sel_field=$cf->pluginparams->filter_by_field;
						$filter_data_type=$cf->pluginparams->filter_data_type;
						$cf_values=cftools::hex2binArray($selected_cf);

						//string escape and quote each value
						if($filter_data_type=='string'){
							foreach($cf_values as $cf_val){
								if(isset($cf_val))$custom_search[] =$cf_name.'.'.$sel_field.' = '.$db->quote( $cf_val, true );
							}

							if(count($custom_search)>0){
								if($cf->pluginparams->product_customvalues_table==$cf->pluginparams->customvalues_table)$where[]='(('.implode(' OR ',$custom_search).") AND {$cf_name}.virtuemart_custom_id=".(int)$cf->custom_id.")";
								else $where[]='('.implode(' OR ',$custom_search).")";
							}
						}else{//if not string
							if(!empty($cf_values))$where[] =$cf_name.'.'.$sel_field.' IN ('.implode(',',$cf_values).')';
						}
					}

					$query->innerJoin($product_customvalues_table.' AS '.$cf_name.' ON '.$cf_name.'.virtuemart_product_id=p.virtuemart_product_id');

				}else {//range
					$productIdsByCF=$this->getProductIdsByCfRange($cf);
					if(!empty($productIdsByCF))	$where_product_ids[]=$productIdsByCF;
					else if(is_array($productIdsByCF))return;//there is range set but no product found
				}
			}
		}


		//find the common product ids between all the varriables/intersection
		if(!empty($where_product_ids)){
			$common_prod_ids=$this->intersectProductIds($where_product_ids);
			if(!empty($common_prod_ids)){
				$where[]=' p.virtuemart_product_id IN ('.implode(',',$common_prod_ids).')';
			}else return;//no product found
		}

		//display products in specific shoppers
		$virtuemart_shoppergroup_ids =cftools::getUserShopperGroups();

		if(is_array($virtuemart_shoppergroup_ids) && $this->componentparams->get('products_multiple_shoppers',0)){
			$where[] .= '(s.`virtuemart_shoppergroup_id` IN (' . implode(',',$virtuemart_shoppergroup_ids). ') OR' . ' (s.`virtuemart_shoppergroup_id`) IS NULL )';
			$joinShopper = true;
		}

		//--general--//
		if($onlyPublished){
			$where[] = ' `p`.`published`=1';
		}

		if(!VmConfig::get('use_as_catalog',0) || $in_stock) {
			if (VmConfig::get('stockhandle','none')=='disableit_children') {
				$where[] = ' (p.`product_in_stock` - p.`product_ordered` >0 OR children.`product_in_stock` - children.`product_ordered` >0) ';
				$joinChildren = true;
			} else if (VmConfig::get('stockhandle','none')=='disableit') {
				$where[] = 'p.`product_in_stock` - p.`product_ordered` >0';
			}
		}

		//only parents
		if($this->menuparams->get('display_child_products',0)==0){
			$where[] = 'p.product_parent_id=0';
		}


		//ordering
		$groupBy = '';
		$filter_order=$this->getState('filter_order');

		// special  orders case
		switch ($this->getState('filter_order')) {
			case 'product_name':
				$orderBy='l.product_name';
				$join_prodlang=true;
				break;
			case 'product_special':
				$where[] = ' p.`product_special`="1" '; // TODO Change  to  a  individual button
				$orderBy = 'RAND()';
				break;
			case 'category_name':
				$orderBy = 'c.`category_name`';
				$join_prodcat=true;
				$joinCategory = true ;
				break;
			case 'category_description':
				$orderBy = 'c.`category_description`';
				$join_prodcat=true;
				$joinCategory = true ;
				break;
			case 'mf_name':
				$orderBy = 'm.`mf_name`';
				$join_prodmnf=true;
				$joinMf = true ;
				break;
			case 'pc.ordering':
				$orderBy = 'pc.`ordering`';
				$join_prodcat=true;
				$joinCategory = true ;
				break;
			case 'ordering': //VM versions lower to 2.0.14 use that
				$orderBy = 'pc.`ordering`';
				$join_prodcat=true;
				$joinCategory = true ;
				break;
			case 'product_price':
				$orderBy = 'pp.`product_price`';
				$joinPrice = true ;
				break;
			case  'created_on':
				$orderBy = 'p.`created_on`';
				break;
			default ;
			if(!empty($filter_order)){
				$orderBy = $this->getState('filter_order');
			} else {
				$this->setState('filter_order_Dir','');
				$orderBy='';
			}
			break;
		}

		//set the joins
		$query->innerJoin('#__virtuemart_products_'.VMLANG.' AS l ON p.virtuemart_product_id=l.virtuemart_product_id');
		if($join_prodcat)$query->innerJoin('#__virtuemart_product_categories AS pc ON pc.virtuemart_product_id=p.virtuemart_product_id');
		if($joinCategory)$query->leftJoin('#__virtuemart_categories_'.VMLANG.' as c ON c.`virtuemart_category_id` = pc.`virtuemart_category_id`');
		if($joinShopper){
			$query->leftJoin('`#__virtuemart_product_shoppergroups` ON p.`virtuemart_product_id` = `#__virtuemart_product_shoppergroups`.`virtuemart_product_id`');
			$query->leftJoin('`#__virtuemart_shoppergroups` as s ON s.`virtuemart_shoppergroup_id` = `#__virtuemart_product_shoppergroups`.`virtuemart_shoppergroup_id`');
		}

		if($join_prodmnf)$query->innerJoin('#__virtuemart_product_manufacturers  AS p_m ON p_m.virtuemart_product_id=p.virtuemart_product_id');
		if($joinMf)$query->leftJoin('#__virtuemart_manufacturers_'.VMLANG.' as m ON m.`virtuemart_manufacturer_id` = p_m.`virtuemart_manufacturer_id`');

		if($joinPrice)$query->leftJoin('`#__virtuemart_product_prices` as pp ON p.`virtuemart_product_id` = pp.`virtuemart_product_id` ');

		if ($joinChildren) $query->leftJoin('`#__virtuemart_products` children ON p.`virtuemart_product_id` = children.`product_parent_id`');
			
		// List state information
		$limit =$this->getState('list.limit',5);
		$limitstart=$this->getState('list.limitstart',0);

		$query->order($db->escape($orderBy.' '.$this->getState('filter_order_Dir')));
		if(count($where)>0)$query->where(implode(' AND ', $where));
		$db->setQuery($query,$limitstart,$limit);
		//print_r((string)$query);

		$db->query();

		$product_ids =$db->loadColumn();
		//$this->total=$this->_getListCount($query);
		$db->setQuery('SELECT FOUND_ROWS()');
		$this->total=$db->loadResult();
		$db->query(true);
		$app->setUserState("com_customfilters.product_ids",$product_ids);
		if($this->moduleparams->get('cf_profiler',0))$profiler->mark('after filtering');
		//print_r($product_ids);
		return $product_ids;

		return ;
	}


	/**
	 *Get the product ids from all the used range filters
	 *@return	array - the product ids
	 *@since	1.6.1
	 *@author	Sakis Terz
	 */
	function getProductIdsFromRanges(){
		if(isset($this->cfinputs['price'][0]))$price_from=$this->cfinputs['price'][0];
		if(isset($this->cfinputs['price'][1]))$price_to=$this->cfinputs['price'][1];

		if(!empty($price_from) || !empty($price_to)){
			$productIdsByPrice=$this->getProductIdsByPrice();
			if(!empty($productIdsByPrice)){
				$where_product_ids[]=$productIdsByPrice;
			}
			//price set but no product found
			else if(is_array($productIdsByPrice))return;
		}


		$customFilters=cftools::getCustomFilters($this->moduleparams);
		$cfilter_found=false;

		if(!empty($customFilters)){
			foreach($customFilters as $cf){
				$cf_name='custom_f_'.$cf->custom_id;
				if($cf->disp_type==5 || $cf->disp_type==6 || $cf->disp_type==8){//if is range
					$productIdsByCF=$this->getProductIdsByCfRange($cf);
					if(!empty($productIdsByCF))	$where_product_ids[]=$productIdsByCF;
					else if(is_array($productIdsByCF))return;//there is range set but no product found
				}
			}
		}
		if(!empty($where_product_ids))$common_prod_ids=$this->intersectProductIds($where_product_ids);
	}


	/**
	 * Intersects the product ids and returns only the common between the used filters
	 *
	 * @param 	array $where_product_ids	- contains the product ids of every used filter
	 * @return	array	the common product ids
	 */
	function intersectProductIds($where_product_ids){
		//find the common product ids between all the varriables/intersection
		if(!empty($where_product_ids)){
			$ar_counter=count($where_product_ids);
			$where_product_ids_ar=$where_product_ids[0];

			$common_prod_ids=array();
			if($ar_counter==1) $common_prod_ids=$where_product_ids[0];
			else{
				for($m=1; $m<$ar_counter; $m++){
					foreach($where_product_ids[$m] as $id){
						if(in_array($id, $where_product_ids_ar))$common_prod_ids[]=$id;
						else $where_product_ids_ar[]=$id;
					}
				}
			}
			if(!empty($common_prod_ids)){
				$app = JFactory::getApplication() ;
				$jinput=$app->input;
				$jinput->set('where_productIds',$common_prod_ids);
				return $common_prod_ids;
			}
		}
		return;
	}

	/**
	 * Returns the product ids based only on the custom filters range
	 * These ids can be used both by the component and the module
	 * in the component's filtering and the module's get active functionalities accordingly
	 * @author Sakis Terz
	 * @since 1.6.1
	 */
	function getProductIdsByCfRange($cf){
		$vmCompatibility=VmCompatibility::getInstance();
		$japplication=JFactory::getApplication();
		$jinput=$japplication->input;
		$var_name='custom_f_'.$cf->custom_id;
		$product_ids=array();
		$custom_from=0;
		$custom_to=0;

		if(isset($this->cfinputs[$var_name][0]) && $this->cfinputs[$var_name][0]>0)$custom_from=$this->cfinputs[$var_name][0];
		if(isset($this->cfinputs[$var_name][1]) && $this->cfinputs[$var_name][1]>0)$custom_to=$this->cfinputs[$var_name][1];


		if($custom_from || $custom_to){
			$db=$this->_db;
			$query=$db->getQuery(true);

			if($cf->field_type!='E'){//not plugin
				$select_field='virtuemart_product_id';
				$from_table='#__virtuemart_product_customfields AS pc';
				$where_field='pc.'.$vmCompatibility->getColumnName('custom_value');
			}
			else{//plugin
				if(empty($cf->pluginparams))return;
				$select_field='virtuemart_product_id';
				$from_table=$cf->pluginparams->product_customvalues_table;
				$customvalues_table=$cf->pluginparams->customvalues_table;
				$data_type='int';


				if($customvalues_table!=$from_table){
					$from_table=$from_table.' AS pc';
					$where_field='c.'.$cf->pluginparams->customvalue_value_field;
					$filter_by_field=$cf->pluginparams->filter_by_field;
					$query->innerJoin("$customvalues_table c ON c.{$filter_by_field}=pc.{$filter_by_field}");
				}else{
					$where_field=$cf->pluginparams->customvalue_value_field;
				}
			}

			$query->select($select_field);
			$query->from($from_table);


			if($custom_from && empty($custom_to)){
				if($cf->disp_type==8){
					$converted_date_from=cftools::getFormatedDate($custom_from);
					$query->where("STR_TO_DATE($where_field,'%Y-%m-%d')>=".$db->quote($converted_date_from));
				}
				else $query->where("$where_field>=$custom_from");
			}
			else if (empty($custom_from) && $custom_to){
				if($cf->disp_type==8){
					$converted_date_to=cftools::getFormatedDate($custom_to);
					$query->where("STR_TO_DATE($where_field,'%Y-%m-%d')<=".$db->quote($converted_date_to));
				}
				else $query->where("$where_field<=$custom_to");
			}
			else{
				if($cf->disp_type==8){
					$converted_date_from=cftools::getFormatedDate($custom_from);
					$converted_date_to=cftools::getFormatedDate($custom_to);

					$query->where("STR_TO_DATE($where_field,'%Y-%m-%d') BETWEEN ".$db->quote($converted_date_from)." AND ".$db->quote($converted_date_to));
				}
				else {
					$query->where("$where_field BETWEEN $custom_from AND $custom_to");
				}
			}
			$query->where($vmCompatibility->getColumnName('virtuemart_custom_id').'='.$cf->custom_id);
			$db->setQuery($query);
			$product_ids=$db->loadColumn();
		} else return null; //there are no ranges set
		return $product_ids;
	}

	/**
	 * Returns the product ids based only on the price filter
	 * These ids can be used both by the component and the module
	 * in the component's filtering and the module's get active functionalities accordingly
	 * @author Sakis Terz
	 * @since 1.4.0
	 */
	function getProductIdsByPrice(){
		$japplication=JFactory::getApplication();
		$jinput=$japplication->input;
		$where=array();
		$where_or=array();
		$price_from=0;
		$price_to=0;

		if(isset($this->cfinputs['price'][0]))$price_from=$this->cfinputs['price'][0];
		if(isset($this->cfinputs['price'][1]))$price_to=$this->cfinputs['price'][1];
		$join_product_categories=false;
		$join_product_manufacturers=false;

		if(!empty($price_from) || !empty($price_to)){

			//create a currency object which will be used later
			if(!class_exists('CurrencyDisplay'))require_once(JPATH_VM_ADMIN.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'currencydisplay.php');
			$this->vmCurrencyHelper=CurrencyDisplay::getInstance();

			//having them activated the query is faster. So they are activated by default
			//prices per shopper
			$prices_per_shopper=true;
			//prices per quantities
			$prices_per_quantities=true;

			/*Multiple Currencies*/
			$multiple_cur=$this->componentparams->get('products_multiple_currencies',0);
			if($multiple_cur){
				/* Check if the currencies are stored in the session from previous search
				 * Otherwise retreive them running a db query
				 */
				$session = JFactory::getSession();
				$used_currencies=$session->get('cf_product_currencies',array());
				//$used_currencies[]=144;
				if(empty($used_currencies))$used_currencies=cftools::getProductCurrencies();
			}


			/* Get the vendor's currency and the site's currency*/
			$vendor_currency=cftools::getVendorCurrency();
			$vendor_currency_details=cftools::getCurrencyInfo($vendor_currency['vendor_currency']);
			$virtuemart_currency_id=$jinput->get('virtuemart_currency_id',$vendor_currency['vendor_currency'],'int');
			$currency_id=$japplication->getUserStateFromRequest( "virtuemart_currency_id", 'virtuemart_currency_id',$virtuemart_currency_id);


			/* Global Tax */
			$globaltax=cftools::getCurrentTax();
			$calc_rules=cftools::getCalcRules();
			$ruleGroupsPerSelection=$this->createCalcRuleGroups($calc_rules);
			/* Create the SQL queries*/

			/* If there is only 1 currency to the product prices*/
			if(empty($used_currencies) || (count($used_currencies)==1 && $used_currencies[0]==$vendor_currency['vendor_currency'])){
				//first convert it to vendor's currency and substract the tax
				if(!empty($price_from)){
					$price_from_converted=$this->vmCurrencyHelper->convertCurrencyTo($currency_id,$price_from);
					$ruleGroupsPerSelection=$this->subtractCalcRules($price_from_converted,$ruleGroupsPerSelection,$key='price_from');
				}
				if(!empty($price_to)){
					$price_to_converted=$this->vmCurrencyHelper->convertCurrencyTo($currency_id,$price_to);
					$ruleGroupsPerSelection=$this->subtractCalcRules($price_to_converted,$ruleGroupsPerSelection, $key='price_to');
				}

				//remove the global from the keys as i am using the category ids later in the query;
				$categories_of_rules=array_keys($ruleGroupsPerSelection);
				$global_index=array_search('global', $categories_of_rules);
				if($global_index!==false)unset($categories_of_rules[$global_index]);

				//print_r($ruleGroupsPerSelection);
				foreach ($ruleGroupsPerSelection as $key=>$calc_group){
					$where_cat='';
					$where_manuf='';

					if(!empty($price_from_converted)){
						$price_from_calcRules_converted=round($calc_group['price_from'],$vendor_currency_details->currency_decimal_place);
					}
					if(!empty($price_to_converted)){
						$price_to_calcRules_converted=round($calc_group['price_to'],$vendor_currency_details->currency_decimal_place);
					}

					//only when the selected categories are more than the cal rule categories. Otherwise it can be used for all the returned products
					if(!empty($key) && $key!='global'){
						if(strpos($key, ',')!==false){
							$categries_query='pc.virtuemart_category_id IN('.implode(',', $calc->categories).')';
						}else $categries_query='pc.virtuemart_category_id='.$key;

						$join_product_categories=true;
						$where_cat='AND '.$categries_query;
					}
					//global query should not have the categories which have rules
					else if(!empty($categories_of_rules)){
						$categries_query='pc.virtuemart_category_id NOT IN('.implode(',', $categories_of_rules).')';
						$join_product_categories=true;
						$where_cat='AND '.$categries_query;
					}

					if(!empty($price_from) && empty($price_to)){
						$where_or[]=" (((pp.`product_price` >=$price_from_calcRules_converted AND (ISNULL(pp.override) OR pp.override=0)) OR (pp.`product_override_price` >=$price_from_converted AND pp.override=1) OR (pp.`product_override_price` >= $price_from_calcRules_converted AND pp.override=-1)) $where_cat $where_manuf)";
					}
					else if(!empty($price_from) && !empty($price_to) && $price_from<=$price_to){
						$where_or[]=" ((
						(pp.`product_price` BETWEEN $price_from_calcRules_converted AND $price_to_calcRules_converted AND (ISNULL(pp.override) OR pp.override=0))
						OR (pp.`product_override_price` BETWEEN $price_from_converted AND $price_to_converted AND pp.override=1)
						OR (pp.`product_override_price` BETWEEN $price_from_calcRules_converted AND $price_to_calcRules_converted AND pp.override=-1)) $where_cat $where_manuf )";
					}
					else if(!empty($price_to) && empty($price_from)){
						$where_or[]=" (((pp.`product_price` <= $price_to_calcRules_converted AND (ISNULL(pp.override) OR pp.override=0)) OR (pp.`product_override_price` <= $price_to_converted AND pp.override=1) OR (pp.`product_override_price` <= $price_to_calcRules_converted AND pp.override=-1)) $where_cat $where_manuf)";
					}
				}
				//only for the vendor's currency
				$where[]="pp.product_currency=".$vendor_currency['vendor_currency'];
			}

			//multiple currencies in product prices
			else if(!empty($used_currencies)){
				//create the currency converter object
				if(empty($this->_currencyConverter))$this->getCurrencyConverter();
				$shop_currency_code=cftools::getCurrencyCode($currency_id);

				if(!empty($price_from)){
					$price_from=$this->vmCurrencyHelper->convertCurrencyTo($currency_id,$price_from);
					$ruleGroupsPerSelection=$this->subtractCalcRules($price_from,$ruleGroupsPerSelection,$key='price_from');
				}
				if(!empty($price_to)){
					$price_to=$this->vmCurrencyHelper->convertCurrencyTo($currency_id,$price_to);
					$ruleGroupsPerSelection=$this->subtractCalcRules($price_to,$ruleGroupsPerSelection, $key='price_to');
				}

				//remove the global from the keys as i am using the category ids later in the query;
				$categories_of_rules=array_keys($ruleGroupsPerSelection);
				$global_index=array_search('global', $categories_of_rules);
				if($global_index!==false)unset($categories_of_rules[$global_index]);


				foreach ($used_currencies as $cur){

					foreach ($ruleGroupsPerSelection as $key=>$calc_group){
						$where_cat='';
						$where_manuf='';
						//convert the entered price in all the available currencies
						$cur_code=cftools::getCurrencyCode($cur);
						if(!empty($price_from)){
							$price_from_converted=round($this->_currencyConverter->convert($price_from,$shop_currency_code,$cur_code),$vendor_currency_details->currency_decimal_place);
							if(!empty($calc_group['price_from']) && $calc_group['price_from']!=$price_from_converted)$price_from_calcRules_converted=round($this->_currencyConverter->convert($calc_group['price_from'],$shop_currency_code,$cur_code),$vendor_currency_details->currency_decimal_place);
							else $price_from_calcRules_converted=$price_from_converted;
						}
						if(!empty($price_to)){
							$price_to_converted=round($this->_currencyConverter->convert($price_to,$shop_currency_code,$cur_code),$vendor_currency_details->currency_decimal_place);
							if(!empty($calc_group['price_to']) && $calc_group['price_to']!=$price_to_converted)$price_to_calcRules_converted=round($this->_currencyConverter->convert($calc_group['price_to'],$shop_currency_code,$cur_code),$vendor_currency_details->currency_decimal_place);
							else $price_to_calcRules_converted=$price_to_converted;
						}

						//only when the selected categories are more than the cal rule categories. Otherwise it can be used for all the returned products
						if(!empty($key) && $key!='global'){
							if(strpos($key, ',')!==false){
								$categries_query='pc.virtuemart_category_id IN('.implode(',', $calc->categories).')';
							}else $categries_query='pc.virtuemart_category_id='.$key;

							$join_product_categories=true;
							$where_cat='AND '.$categries_query;
						}
						//global query should not have the categories which have rules
						else if(!empty($categories_of_rules)){
							$categries_query='pc.virtuemart_category_id NOT IN('.implode(',', $categories_of_rules).')';
							$join_product_categories=true;
							$where_cat='AND '.$categries_query;
						}


						if(!empty($price_from) && empty($price_to)){
							$where_or[]=" ((
							(pp.`product_price` >=$price_from_calcRules_converted AND (ISNULL(pp.override) OR pp.override=0))
							OR (pp.`product_override_price` >=$price_from_converted AND pp.override=1)
							OR (pp.`product_override_price` >=$price_from_calcRules_converted AND pp.override=-1))
							AND pp.product_currency=$cur  $where_cat)";
						}
						else if(!empty($price_from) && !empty($price_to)){
							$where_or[]=" ((
							(pp.`product_price` BETWEEN $price_from_calcRules_converted AND $price_to_calcRules_converted AND (ISNULL(pp.override) OR pp.override=0))
							OR (pp.`product_override_price` BETWEEN $price_from_converted AND $price_to_converted AND pp.override=1)
							OR (pp.`product_override_price` BETWEEN $price_from_calcRules_converted AND $price_to_calcRules_converted AND pp.override=-1))
							AND pp.product_currency=$cur $where_cat)";
						}
						if(!empty($price_to) && empty($price_from)){
							$where_or[]=" ((
							(pp.`product_price` <=$price_to_calcRules_converted AND (ISNULL(pp.override) OR pp.override=0))
							OR (pp.`product_override_price` <=$price_to_converted AND pp.override=1)
							OR (pp.`product_override_price` <=$price_to_calcRules_converted AND pp.override=-1))
							AND pp.product_currency=$cur $where_cat)";
						}
					}
				}

			}

			$db=JFactory::getDbo();
			$query=$db->getQuery(true);
			$query->select('pp.virtuemart_product_id');
			$query->from('#__virtuemart_product_prices AS pp');
			$query->innerJoin('#__virtuemart_products_'.VMLANG.' AS l ON pp.virtuemart_product_id=l.virtuemart_product_id');
			if($join_product_categories)$query->leftJoin('#__virtuemart_product_categories AS pc ON pp.virtuemart_product_id=pc.virtuemart_product_id');
			if($join_product_manufacturers)$query->leftJoin('#__virtuemart_manufacturers AS pm ON pp.virtuemart_product_id=pm.virtuemart_product_id');

			//prices per shopper
			if($prices_per_shopper){
				if(!class_exists('VirtueMartModelUser')) require(JPATH_VM_ADMINISTRATOR.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'user.php');
				$usermodel = new VirtueMartModelUser;
				$currentVMuser = $usermodel->getUser();
				$virtuemart_shoppergroup_ids =  (array)$currentVMuser->shopper_groups;
				if($currentVMuser->virtuemart_user_id>0){
					JArrayHelper::toInteger($virtuemart_shoppergroup_ids);
					if(!empty($virtuemart_shoppergroup_ids)  && is_array($virtuemart_shoppergroup_ids))
					$whereShopper = 'pp.`virtuemart_shoppergroup_id` IN('.implode(',', $virtuemart_shoppergroup_ids).')';
					//prices for all shopppers
					$whereShopper.= ' OR (ISNULL(pp.`virtuemart_shoppergroup_id`) OR pp.`virtuemart_shoppergroup_id`=0)';
					$whereShopper='('.$whereShopper.')';
				}
				//no shopper
				else $whereShopper= '(ISNULL(pp.`virtuemart_shoppergroup_id`) OR pp.`virtuemart_shoppergroup_id`=0)';
				$where[]=$whereShopper;
			}

			//prices per quantity ranges, its should always refer to 1 quantity i.e. 0 or 1
			if($prices_per_quantities){
				$where[] .='(pp.`price_quantity_start`=0 OR pp.`price_quantity_start`=1)';
			}
			if(!empty($where_or))$where[]='('.implode(' OR ', $where_or).')';

			if(!empty($where)){
				$where_str=implode(' AND ',$where);
				$query->where($where_str);
			}

			//print_r((string)$query);
			$db->setQuery($query);
			$result=$db->loadColumn();
			//print_r($result);

			//set the product ids in the jinput so it will be used by the module for the getActiveOptions Functionalitity
			$jinput->set('productIdsByPrice',$result);

			return $result;
		}
		return;
	}

	/**
	 * Creates culc rule groups based on some criteria (e.g. categories)
	 * Each group has all the calc rules which are applied to this group of products
	 * @since 	1.9.5
	 * @param 	array $rules
	 * @return	array
	 */
	public function createCalcRuleGroups($rules){
		$cfinput=CfInput::getInputs();
		$rulesGroup=array();
		$categories=array();
		$manufacturers=array();
		if(isset($cfinput['virtuemart_category_id']))$categories=$cfinput['virtuemart_category_id'];
		if(isset($cfinput['virtuemart_manufacturer_id']))$manufacturers=$cfinput['virtuemart_manufacturer_id'];
		$counter=count($rules);
		$i=0;
		$group=array();
		$found=array();

		for($i=0; $i<$counter; $i++){
			$r=$rules[$i];
			if(!empty($r->virtuemart_category_id)){
				if(!isset($group[$r->virtuemart_category_id]))$group[$r->virtuemart_category_id]=array();

				if(!isset($group[$r->virtuemart_category_id][$r->virtuemart_calc_id])){
					$group[$r->virtuemart_category_id][$r->virtuemart_calc_id]=$r;
					$found[]=$r->virtuemart_calc_id;
				}
			}
		}

		//now create an array for those that don't have matches
		$global['global']=array();
		foreach ($rules as $rl){
			if(empty($rl->virtuemart_category_id))$global['global'][$rl->virtuemart_calc_id]=$rl;
		}

		/*
		 * now check if the existing groups are global.
		 * The groups are global if there are groups that cover all the selected categories and have exactly the same calc rules.
		 * In other words all the categories use the same rules
		 */

		$diiference=false;
		$no_of_groups=count($group);
		if($no_of_groups>0){
			$tmp_group=array_values($group);
			//print_r($tmp_group);

			//possibly global.Check if all contain the same calc rules
			if($no_of_groups==count($categories)){
				for ($i=0; $i<$no_of_groups; $i++){
					$calc_rule_ids=array_keys($tmp_group[$i]);
					for ($j=$no_of_groups-1; $j>$i; $j--){
						$calc_rule_ids2=array_keys($tmp_group[$j]);
						$difference=array_diff($calc_rule_ids, $calc_rule_ids2);
						if($diiference)break 2;
					}
				}

				if($diiference==false){
					//just the 1st group and the global. The 1st is the same with the others
					$groups['global']=array_merge($global['global'],$tmp_group[0]);
				}else{
					$group['global']=$global['global'];
					$groups=$group;
				}
			}else{
				$group['global']=$global['global'];
				$groups=$group;
			}
		}else $groups=$global;

		//print_r($groups);
		//order them by the type
		$new_groups=array();
		foreach ($groups as $key=>$gr){
			if(!isset($new_groups[$key]))$new_groups[$key]=array();
			foreach ($gr as $rule){
				if(!isset($new_groups[$key][$rule->calc_kind]))$new_groups[$key][$rule->calc_kind]=array();
				$new_groups[$key][$rule->calc_kind][]=$rule;
			}
		}
		//print_r($new_groups);
		return $new_groups;
	}


	/**
	 * Find the base price by substracting a set of calc rules
	 * The execution order is the following "Marge","DBTax","Tax","VatTax","DATax". in our case it should be reversed
	 * @param float $price
	 * @param array $calc_groups
	 */
	function subtractCalcRules($price, $calc_groups,$price_key='price' ){

		if(isset($calc_groups['global'])){
			$global_rule=$calc_groups['global'];
		}

		foreach($calc_groups as $key=>&$calc_gr){
			$group_price=$price;

			if(isset($calc_gr['DATax']))$group_price=$this->subtractCalcRulesByCalcType($group_price,$calc_gr['DATax']);
			if(isset($global_rule['DATax']) && $key!='global')$group_price=$this->subtractCalcRulesByCalcType($group_price,$global_rule['DATax']);

			if(isset($calc_gr['VatTax']))$group_price=$this->subtractCalcRulesByCalcType($group_price,$calc_gr['VatTax']);
			if(isset($global_rule['VatTax']) && $key!='global')$group_price=$this->subtractCalcRulesByCalcType($group_price,$global_rule['VatTax']);

			if(isset($calc_gr['Tax']))$group_price=$this->subtractCalcRulesByCalcType($group_price,$calc_gr['Tax']);
			if(isset($global_rule['Tax']) && $key!='global')$group_price=$this->subtractCalcRulesByCalcType($group_price,$global_rule['Tax']);

			if(isset($calc_gr['DBTax']))$group_price=$this->subtractCalcRulesByCalcType($group_price,$calc_gr['DBTax']);
			if(isset($global_rule['DBTax']) && $key!='global')$group_price=$this->subtractCalcRulesByCalcType($group_price,$global_rule['DBTax']);

			if(isset($calc_gr['Marge']))$group_price=$this->subtractCalcRulesByCalcType($group_price,$calc_gr['Marge']);
			if(isset($global_rule['Marge']) && $key!='global')$group_price=$this->subtractCalcRulesByCalcType($group_price,$global_rule['Marge']);

			$calc_gr[$price_key]=$group_price;
		}
		//print_r($calc_groups);
		return $calc_groups;
	}

	/**
	 * Gets a group of cacl rules and subtract them from the price
	 *
	 * @param float $price
	 * @param object $calc_group
	 * @since 1.9.5
	 */
	function subtractCalcRulesByCalcType($price, $calc_group){
		foreach($calc_group as $calc){
			$price=$this->subtractCalcRule($price,$calc);
		}

		return $price;
	}

	/**
	 * Substract calculation rules from the price to get the base price
	 * @param float $price - The price from which we will subtract the calc rule
	 * @param objecr $calc - The calc rule object
	 */
	function subtractCalcRule($price, $calc ){
		$value=$calc->calc_value;
		$mathop=$calc->calc_value_mathop;
		$currency=$calc->calc_currency;

		if($value!=0){
			$coreMathOp = array('+','-','+%','-%');
			if(in_array($mathop,$coreMathOp)){
				$sign = substr($mathop, 0, 1);
			}
			if (strlen($mathop) == 2) {
				$cmd = substr($mathop, 1, 2);
				//revert
				if ($cmd == '%') {
					$calculated = $price /(1 +  (100.0 / $value));
				}
			} else if (strlen($mathop) == 1){
				//then its a price and needs to be in the correct currency
				$calculated = $this->vmCurrencyHelper->convertCurrencyTo($currency, $value);
			}

			if($sign=='+'){
				return $price-=$calculated;
			}else if($sign=='-'){
				return $price+=$calculated;
			}else return $price;
		}else return $price;
	}



	/**
	 * Get the currency converter
	 * @author	Sakis Terz
	 * @since	1.4.0
	 */
	public function getCurrencyConverter(){
		$converterFile  = VmConfig::get('currency_converter_module');

		/*Get the currency plugin*/
		if (file_exists( JPATH_VM_ADMINISTRATOR.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'currency_converter'.DIRECTORY_SEPARATOR.$converterFile )) {
			$module_filename=substr($converterFile, 0, -4);
			require_once(JPATH_VM_ADMINISTRATOR.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'currency_converter'.DIRECTORY_SEPARATOR.$converterFile);
			if( class_exists( $module_filename )) {
				$this->_currencyConverter = new $module_filename();
			}
		} else {

			if(!class_exists('convertECB')) require(JPATH_VM_ADMINISTRATOR.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'currency_converter'.DIRECTORY_SEPARATOR.'convertECB.php');
			$this->_currencyConverter = new convertECB();
		}
	}



	/**
	 * Get the Order By Select List
	 * Overrides the function originaly written by Kohl Patrick (Virtuemart project)
	 *
	 * @author 	Sakis Terz
	 * @access	public
	 * @param 	int	The category id
	 * @return 	string	the orderBy HTML List
	 **/
	function getOrderByList($virtuemart_category_id=false) {
		$app = JFactory::getApplication() ;
		$jinput=$app->input;
		//in 2.6.0 a lot lang keys where modified
		$changed_langKey=version_compare($this->vmVersion, '2.6.0','ge');

		//load the virtuemart language files
		if(method_exists('VmConfig', 'loadJLang'))VmConfig::loadJLang('com_virtuemart',true);
		else{
			$language=JFactory::getLanguage();
			$language->load('com_virtuemart');
		}

		$orderTxt ='';
		$orderByLinks='';
		$first_optLink='';

		$default_orderBy=$this->filter_order;
		$orderby = $jinput->get('orderby',$default_orderBy,'string');

		if($changed_langKey)$orderDirTxt=JText::_('COM_VIRTUEMART_'.$this->getState('filter_order_Dir'));
		else $orderDirTxt=JText::_('COM_VIRTUEMART_SEARCH_ORDER_'.$this->getState('filter_order_Dir'));


		/* order by link list*/
		$fields = VmConfig::get('browse_orderby_fields');

		if(!in_array($default_orderBy, $fields))$fields[]=$default_orderBy;

		if (count($fields)>0) {
			foreach ($fields as $field) {
				if ($field != $orderby) $selected=false; //indicates if this is the current option
				else $selected=true;

				//remove the dot from the string in order to use it as lang string
				$dotps = strrpos($field, '.');
				if($dotps){
					$prefix = substr($field, 0,$dotps+1);
					$fieldWithoutPrefix = substr($field, $dotps+1);
				} else {
					$prefix = '';
					$fieldWithoutPrefix = $field;
				}
				$text = $changed_langKey?JText::_('COM_VIRTUEMART_'.strtoupper($fieldWithoutPrefix)):JText::_('COM_VIRTUEMART_SEARCH_ORDER_'.strtoupper($fieldWithoutPrefix));
				$link = $this->getOrderURI($field,$selected,$this->getState('filter_order_Dir'));
				if(!$selected)$orderByLinks .='<div><a title="'.$text.'" href="'.$link.'">'.$text.'</a></div>';
				else $first_optLink='<div class="activeOrder"><a title="'.$text.'" href="'.$link.'">'.$text.' '.$orderDirTxt.'</a></div>';
			}
		}

		//format the final html
		$orderByHtml='<div class="orderlist">'.$orderByLinks.'</div>';

		$orderHtml ='
		<div class="orderlistcontainer">
			<div class="title">'.JText::_('COM_VIRTUEMART_ORDERBY').'</div>'
			.$first_optLink
			.$orderByHtml
			.'</div>';

			//in case of ajax we want the script to be triggered after the results loading
			$orderHtml .="
			<script type=\"text/javascript\">
		jQuery('.orderlistcontainer').hover(
		function() { jQuery(this).find('.orderlist').stop().show()},
		function() { jQuery(this).find('.orderlist').stop().hide()});
		</script>";

			return array('orderby'=>$orderHtml, 'manufacturer'=>'');
	}


	/**
	 * Creates the href in which each "order by" option should point to
	 * @author	Sakis Terz
	 * @return	String	The URL
	 * @since 	1.0
	 */
	private function getOrderURI($orderBy,$selected=false,$orderDir='ASC'){

		$u=JFactory::getURI();
		$q_array=JRequest::get();

		/*store only the necessary variables
		 because the query maybe is a query of another component with unwanted vars*/
		$final_array=array();

		$final_array['option']='com_customfilters';
		$final_array['view']='products';
		if(isset($q_array['virtuemart_category_id'])) $final_array['virtuemart_category_id']=$q_array['virtuemart_category_id'];
		if(isset($q_array['virtuemart_manufacturer_id'])) $final_array['virtuemart_manufacturer_id']=$q_array['virtuemart_manufacturer_id'];
		if(isset($q_array['price_from'])) $final_array['price_from']=$q_array['price_from'];
		if(isset($q_array['price_to'])) $final_array['price_to']=$q_array['price_to'];
		if(isset($q_array['Itemid'])) $final_array['Itemid']=$q_array['Itemid'];
		//custom filters
		$cust_flt=$this->published_cf;
		$var_name='';

		if(!empty($cust_flt)){
			foreach($cust_flt as $cf) {
				$var_name='custom_f_'.$cf->custom_id;
				if(isset($q_array[$var_name])) $final_array[$var_name]=$q_array[$var_name];
			}
		}

		//add order by var in the query
		$final_array['orderby']=$orderBy;
		//if selected add the order Direction
		if($selected and $orderDir=='ASC')$final_array['order']='DESC';
		else $final_array['order']='ASC';


		$query=$u->buildQuery($final_array);
		$uri='index.php?'.$query;
		return JRoute::_($uri);
	}

	/**
	 * Loads the pagination
	 *
	 * @author 	Sakis Terz
	 * @since	1.0
	 */
	public function getPagination($total=0,$limitStart=0,$limit=0) {

		if ($this->_pagination == null) {
			require_once JPATH_COMPONENT.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'cfpagination.php';

			$limit = $this->getState('list.limit');
			$limitstart=$this->getState('list.limitstart',0);
			$this->_pagination = new cfPagination($this->total , $limitstart, $limit );
		}
		// 		vmdebug('my pagination',$this->_pagination);
		return $this->_pagination;
	}
}