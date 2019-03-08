<?php
/**
 * Handles all the inputs coming from the module
 * @package	customfilters
 * @author 	Sakis Terz
 * @since	1.9.5
 * @copyright	Copyright (C) 2010 - 2014 breakdesigns.net . All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
require_once JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_customfilters'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'tools.php';


Class CfInput{
	//all the inputs are stored here
	protected static $cfInputs=array();
	protected static $cfInputsPerFilter=array();

	/**
	 * The function is used to get and filter all the inputs coming from the module
	 * @since 1.9.5
	 * @todo Check if the filter is published for custom filters
	 */
	private function buildInputs($module){
		$jinput=JFactory::getApplication()->input;
		$filter=JFilterInput::getInstance();
		$module_id=$module->id;
		$moduleparams=cftools::getModuleparams($module);
		$selected_flt=array();
		$rangeVars=array();

		//use virtuemart variables
		$component=$jinput->get('option','','cmd');
		$use_vm_vars=$moduleparams->get('use_virtuemart_pages_vars');
		if($use_vm_vars && $component=='com_virtuemart') $use_vm_vars=true;
		else $use_vm_vars=false;

		//--categories--
		if($use_vm_vars==true || $component=='com_customfilters'){
			$vm_cat_array=$jinput->get('virtuemart_category_id',array(),'array');
			$vm_cat_array=array_filter($vm_cat_array);
			if($vm_cat_array)JArrayHelper::toInteger($vm_cat_array);
			if(count($vm_cat_array)>0){
				$selected_flt['virtuemart_category_id']=$vm_cat_array;
			}
		}

		//else $this->selected_flt['virtuemart_category_id']=array();

		//--manufs--
		if($use_vm_vars==true || $component=='com_customfilters'){
			$vm_mnf_array=$jinput->get('virtuemart_manufacturer_id',array(),'array');
			$vm_mnf_array=array_filter($vm_mnf_array);
			if($vm_mnf_array)JArrayHelper::toInteger($vm_mnf_array);
			if(count($vm_mnf_array)>0){
				$selected_flt['virtuemart_manufacturer_id']=$vm_mnf_array;
			}
		}

		//--prices--
		if($component=='com_customfilters'){
			$var_name='price';
			$price_from=$jinput->get($var_name.'_from',0,'float');
			$price_to=$jinput->get($var_name.'_to',0,'float');

			//price from should be lower or equal to price to
			if((!empty($price_from) && empty($price_to)) || (!empty($price_from) && !empty($price_to) && $price_from<=$price_to)){
				$rangeVars[]=$var_name;
				$selected_flt['price'][0]=$price_from;
			}
			//price to should be higher or equal to price from
			if((!empty($price_to) && empty($price_from)) || (!empty($price_to) && !empty($price_from) && $price_to>=$price_from)){
				if(!in_array($var_name, $rangeVars))$rangeVars[]=$var_name;
				$selected_flt['price'][1]=$price_to;
			}
		}

		//--custom filters--

		/*check if the custom filters should be displayed,
		 *if not do not include it in the selected filters
		 *even if it exists in the GET var
		 */
		$disp_cf=$moduleparams->get('custom_flt_published');
		//$disp_cf=ModCfilteringOptions::getDisplayControl($flt_sfx='custom_flt',$selected_flt, $moduleparams);

		if($disp_cf){
			$published_cf=cftools::getCustomFilters($moduleparams);
			$var_name='';
			foreach($published_cf as $cf) {

				if($use_vm_vars==true || $component=='com_customfilters'){
					$var_name='custom_f_'.$cf->custom_id;
					if($cf->disp_type!=5 && $cf->disp_type!=6 && $cf->disp_type!=8){
						$custom_array=$jinput->get($var_name,array(),'array');
						$c_array=array();//array_filter($custom_array);
						$data_type='cmd';
						//filter as cmd
						foreach($custom_array as $cf_el){
							if(!empty($cf_el)){
								if(isset($cf->pluginparams->filter_data_type)){//if plugin get the correct data type
									if($cf->pluginparams->filter_data_type=='int' 
									|| $cf->pluginparams->filter_data_type=='boolean' 
									|| $cf->pluginparams->filter_data_type=='bool')$data_type='int';
									else if($cf->pluginparams->filter_data_type=='float')$data_type='float';//sanitize the float numbers
								}								
								$result=$filter->clean($cf_el, $data_type);								
								if($result)$c_array[]=$result;
							}
						}
						if(count($c_array)>0){
							$selected_flt[$var_name]=$c_array;
						}
					}
					else {//ranges
						if($cf->disp_type==5 || $cf->disp_type==6)$input_filter='INT';
						else $input_filter='STRING';//date range
						$custom_from=$jinput->get($var_name.'_from',0,$input_filter);
						if($custom_from>0){
							$rangeVars[]=$var_name;
							$selected_flt[$var_name][0]=$custom_from;
						}
						$custom_to=$jinput->get($var_name.'_to',0,$input_filter);
						if($custom_to>0){
							if(!in_array($var_name, $rangeVars))$rangeVars[]=$var_name;
							$selected_flt[$var_name][1]=$custom_to;
						}
					}
				}
				//else $this->selected_flt[$var_name]=array();
			}
		}
		cftools::setRangeVars($rangeVars);
		return $selected_flt;
	}

	/**
	 * Get the inputs
	 *
	 * @param 	int $module_id
	 * @since 	1.9.5
	 * @author 	Sakis Terz
	 */
	public static function getInputs($module=''){
		if(empty($module))$module=cftools::getModule();
		$module_id=$module->id;
		if(!isset(self::$cfInputs[$module_id])){
			$cfinput=new CfInput;
			self::$cfInputs[$module_id]=$cfinput->buildInputs($module);
		}
		return self::$cfInputs[$module_id];
	}

	/**
	 * When the dependency works from top to bottom create an array with the selected options that each filter needs
	 * @param 	object module
	 * @return 	array
	 * @since	1.6.0
	 * @author	Sakis Terz
	 */
	public function getInputsPerFilter($module=''){
		if(empty($module))$module=cftools::getModule();
		$module_id=$module->id;
		if(!isset(self::$cfInputsPerFilter[$module_id])){
			$selected_fl=self::getInputs($module);
			$moduleparams=cftools::getModuleparams($module);			
			$modif_selection=array();
			$filters_order=json_decode(str_replace("'", '"', $moduleparams->get('filterlist','')));
			if(empty($filters_order) || !in_array('virtuemart_category_id', $filters_order))$filters_order=array('virtuemart_category_id','virtuemart_manufacturer_id','product_price','custom_f');
			$filters_order=self::setCustomFiltersToOrder($filters_order,$selected_fl);


			foreach ($filters_order as $flt_key){
				$flt_order=array_search($flt_key, $filters_order);
				$tmp_array=array();
				foreach($selected_fl as $key=>$flt){
					$sel_order=array_search($key, $filters_order);
					if($flt_order>$sel_order && !empty($flt))$tmp_array[$key]=$flt;
					//echo $sel_order,' ',$key,' ',$flt_order ,'<br/>';
				}
				//add the current filter's selections
				if(empty($tmp_array[$flt_key]) && isset($selected_fl[$flt_key]))$tmp_array[$flt_key]=$selected_fl[$flt_key];
				if(!empty($tmp_array))$modif_selection[$flt_key]=$tmp_array;
			}
			$cfInputsPerFilter[$module_id]=$modif_selection;
		}
		return $cfInputsPerFilter[$module_id];
	}


	/**
	 * Reorders the filters ordering array, setting also the existing custom fields in the order
	 * @param	Array	The ordering of the filters
	 * @param	Array	The selected filters
	 * @return	Array
	 * @author	Sakis Terz
	 * @since	1.6.0
	 */
	public function setCustomFiltersToOrder($filters_order,$selected_fl){
		$custom_f_pos=array_search('custom_f', $filters_order);
		if($custom_f_pos===false)return $filters_order;
		$first_portion=array_slice($filters_order,0, $custom_f_pos);
		$second_portion=array_slice($filters_order,$custom_f_pos+1);
		$custom_filters=cftools::getCustomFilters();

		foreach($custom_filters as $key=>$flt){
			$first_portion[]='custom_f_'.$flt->custom_id;
		}
		if(is_array($first_portion) && is_array($second_portion))$filters_order=array_merge($first_portion,$second_portion);

		return $filters_order;
	}

}