<?php
/**
 /**
 * The helper class which contains the functionality for fetching and creating the filter's options
 * @package	customfilters
 * @author 	Sakis Terz
 * @copyright	Copyright (C) 2010 - 2014 breakdesigns.net . All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
jimport('joomla.filter.filteroutput');

class ModCfilteringOptions{
	private $langPlugin=false;
	private $product_ids;
	public $selected_flt;
	private $shopperGroups=array();
	public $input;
	public $fltSuffix=array(
	'virtuemart_category_id'=>'category_flt',
	'virtuemart_manufacturer_id'=>'manuf_flt',
	'price'=>'price_flt',
	'custom_f'=>'custom_flt');

	private $moduleparams;
	protected static $_publishedCustomFilters=array();

	/**
	 * Constructor
	 * Enter description here ...
	 * @param object $params - the module params
	 * @param object $module - the module object
	 */
	function __construct($params,$module){
		$app = JFactory::getApplication() ;
		$this->moduleparams=$params;
		$this->componentparams  = cftools::getComponentparams();
		$this->menuparams=cftools::getMenuparams();
		$this->customFltActive=cftools::getCustomFilters($this->moduleparams);
		$jinput=$app->input;
		$this->input=$jinput;
		$this->selected_flt=CfInput::getInputs($module);
		$this->shopperGroups=cftools::getUserShopperGroups();
		$option=$jinput->get('option','','cmd');
		//in cf pages get the returned product ids
		if($option=='com_customfilters'){
			$this->product_ids=$app->getUserState("com_customfilters.product_ids");
		}else $this->product_ids=array();

		$dependency_dir=$params->get('dependency_direction','all');
		if(count($this->selected_flt)>0 && $dependency_dir=='t-b')$this->selected_fl_per_flt=CfInput::getInputsPerFilter($module);

	}



	/**
	 *
	 * Proxy function to get the options of specific filters
	 * @param 	string $var_name
	 * @param 	string $custom_field_type - used only for custom fields
	 * @return	array - the options
	 */
	public function getOptions($var_name,$custom_filter=null){
		$options=array();
		if(strpos($var_name, 'custom_f_')!==false)$var_type='custom_f';
		else $var_type=$var_name;

		switch($var_type){
			case 'virtuemart_category_id':
				$options=$this->getCategories();
				break;
			case 'virtuemart_manufacturer_id':
				$options=$this->getManufacturers();
				break;
			case 'custom_f':
				$options=$this->getCustomOptions($custom_filter);
				break;
		}
		return $options;
	}

	/**
	 *
	 * Proxy function to build the queries of the various filters
	 * @param	object	a db query object
	 * @param 	string 	$var_name
	 * @param 	string 	$custom_field_type - used only for custom fields
	 * @return	object 	a db query object
	 * @since	1.5.0
	 */
	public function buildQuery($query,$var_name,$customFilter,$part=false){
		$options=array();
		if(!empty($customFilter))$var_type='custom_f';
		else $var_type=$var_name;

		switch($var_type){
			case 'virtuemart_category_id':
				$query=$this->buildCategoriesQuery($query,$part);
				break;
			case 'virtuemart_manufacturer_id':
				$query=$this->buildManufQuery($query,$part);
				break;
			case 'custom_f':
				$query=$this->buildCustomFltQuery($query,$customFilter,$part);
				break;
			default:
				$query=$query;
				break;
		}
		return $query;
	}


	/**
	 * Set the languagefilter plugin state
	 * @param boolean $isEnabled
	 */
	public function setLanguageSwitch($isEnabled=false){
		$this->langPlugin=$isEnabled;
	}



	/**
	 * Get the active options of a current filter using dependencies from the selections in other filters
	 *
	 * @author	Sakis Terz
	 * @since	1.0
	 * @param	string	$field The var's name
	 * @param	object	$customfilter Used only for custom filters.The current custom filter
	 * @param	boolean	$joinFieldData indicates if there will be join with other queries, built by the buildQuery functions.
	 * Join is not necessary when the display type is "disabled" as only the active options are used
	 * @return 	mixed	array when there are results - true if there are no other filters selected. So all are active
	 */
	function getActiveOptions($field,$customfilter,$joinFieldData=false){
		$vmCompatibility=VmCompatibility::getInstance();

		//if the dependency works from top to bottom, get the selected filters as stored in the "selected_fl_per_flt"
		if(isset($this->selected_fl_per_flt)){
			if(isset($this->selected_fl_per_flt[$field]))$selected_flt=$this->selected_fl_per_flt[$field];
			else $selected_flt=array();
		}
		else $selected_flt=$this->selected_flt;


		$api=JFactory::getApplication();
		$db=JFactory::getDbo();
		$query=$db->getQuery(true);
		$query=$this->buildQuery($query,$field,$customfilter,true);


		$is_customfield=strpos($field, 'custom_f_');
		/* ids generated in the component and should be included in the query
		 * Storing them to the component we avoid duplicate work and the sql query becomes lighter*/
		$where_productIds=$this->input->get('where_productIds',array(),'array');
		$activeOptions=array();

		//the keys used in some arrays
		if($is_customfield!==false)$field_key='custom_f';
		else $field_key=$field;

		$innerJoins=array();
		$leftJoins=array();
		$where=array();
		$where_str='';
		$i=0;

		//the table names which are retreived by the $field var which is used as key
		$table_db_flds['virtuemart_category_id']='#__virtuemart_product_categories';
		$table_db_flds['virtuemart_manufacturer_id']='#__virtuemart_product_manufacturers';
		$table_db_flds[$vmCompatibility->getColumnName('virtuemart_custom_id')]='#__virtuemart_product_customfields';

		//if the field is a cucstomfield use that as the table name
		if($is_customfield!==false){
			$table_db_flds[$field]='cfp';
		}

		//iterate through the selected variables and join the relevant tables
		foreach($selected_flt as $key=>$ar_value){
			$wherecf=array();

			/*
			 * the query should run only if there are options selected in the filters
			 * other than the one we get as field param in that function
			 */
			if(count($ar_value)>0){
				if($key!=$field){

					/*
					 * if the key of the selected filters array is a customfield there are other rules
					 * This because the custom filers are stored in various arrays. Use a generated by the module name
					 * and also because they are stored as varchars in the db and we cannot use where in
					 */
					if(strpos($key, 'custom_f_')!==false){

						//get the filter id
						preg_match('/[0-9]+/', $key,$mathces);
						$custFltObj=$this->customFltActive[(int)$mathces[0]];
						//check if its range
						if($custFltObj->disp_type!=5 && $custFltObj->disp_type!=6 && $custFltObj->disp_type!=8){
							//print_r($custFltObj);
							//not plugin
							if($custFltObj->field_type!='E'){
								$table_db_flds[$key]='#__virtuemart_product_customfields';
								$sel_field=$vmCompatibility->getColumnName('custom_value');
								$ar_value=cftools::hex2binArray($ar_value);

								foreach($ar_value as $av){
									$wherecf[]="{$key}.{$sel_field} =". $db->quote($av);
								}

								if(count($wherecf)>0)$where[]="((".implode(' OR ',$wherecf).") AND {$key}.".$vmCompatibility->getColumnName('virtuemart_custom_id')."=".(int)$mathces[0].")";
								$innerJoins[]="$table_db_flds[$key] AS $key ON {$table_db_flds[$field]}.virtuemart_product_id={$key}.virtuemart_product_id";

							}else{
								//if the plugin has not declared the necessary params go to the next selected var
								if(empty($custFltObj->pluginparams))continue;
								//get vars from plugins
								$curSelectionTable=$custFltObj->pluginparams->product_customvalues_table;
								$sel_field=$custFltObj->pluginparams->filter_by_field;
								$filter_data_type=$custFltObj->pluginparams->filter_data_type;
								$wherecf=array();
								$ar_value=cftools::hex2binArray($ar_value);

								//if its string we need to escape and quote each value
								if($filter_data_type=='string'){
									foreach($ar_value as $av){
										$wherecf[]="{$key}.{$sel_field} =". $db->quote($av);
									}

									if(count($wherecf)>0){
										if($custFltObj->pluginparams->product_customvalues_table==$custFltObj->pluginparams->customvalues_table)$where[]='(('.implode(' OR ',$wherecf).") AND {$key}.$vmCompatibility->getColumnName('virtuemart_custom_id')=".(int)$mathces[0].")";
										else $where[]='('.implode(' OR ',$wherecf).")";
									}
								}else{
									//if they are in different tables we can use where in which is faster also we should sanitize the vars
									if($filter_data_type=='int' || $filter_data_type=='boolean' || $filter_data_type=='bool')JArrayHelper::toInteger($ar_value);
									else if($filter_data_type=='float'){//sanitize the float numbers
										foreach($ar_value as &$av){
											$av=(float)$av;
										}
									}else continue;// if none of the above continue
									if(!empty($ar_value))$where[]="{$key}.{$sel_field} IN(".implode(',',$ar_value).")";
								}

								$innerJoins[]="$curSelectionTable AS $key ON {$table_db_flds[$field]}.virtuemart_product_id={$key}.virtuemart_product_id";
							}
						}
					}
					//other filters than customfilters but not product_price
					else if($key!='price'){
						$sel_field=$key;
						$where[]="{$table_db_flds[$key]}.{$sel_field} IN (".implode(' ,',$ar_value).")";
						$innerJoins[]="$table_db_flds[$key] ON {$table_db_flds[$field]}.virtuemart_product_id={$table_db_flds[$key]}.virtuemart_product_id";
					}

				}
			}
		}

		//product ids that come from the component
		if(!empty($where_productIds)){
			$where[]="{$table_db_flds[$field]}.virtuemart_product_id IN(".implode(',', $where_productIds).")";
		}

		if($where){

			//generate some db vars
			if($is_customfield!==false)
			{
				preg_match('/[0-9]+/', $field,$mathcess);
				if($customfilter->field_type!='E'){//not plugin
					$from_alias='cfp';
					$from='#__virtuemart_product_customfields AS '.$from_alias;
					$sqlfield='custom_value';
					$where[]='cfp.'.$vmCompatibility->getColumnName('virtuemart_custom_id','virtuemart_product_customfields').'='.(int)$mathcess[0];
				}
				//is plugin and has params
				else if(isset($customfilter->pluginparams)){
					$from_alias='cfp';
					$from=$customfilter->pluginparams->customvalues_table.' AS '.$from_alias='cf';
					$sqlfield=$customfilter->pluginparams->filter_by_field;
					$where[]='cf.virtuemart_custom_id='.(int)$mathcess[0];
				}

			}else {
				$sqlfield=$field;
				$from=$table_db_flds[$field];
				$from_alias=$from;
			}



			$query->where(implode(' AND ',$where));
			if(count($innerJoins)>0)$query->innerJoin(implode(' INNER JOIN ', $innerJoins));
			if(count($leftJoins)>0)$query->leftJoin(implode(' LEFT JOIN ', $leftJoins));

			//if($field=='custom_f_3')print_r((string)$query);
			//$api->enqueueMessage((string)$query);
			$db->setQuery($query);
			$activeOpt=$db->loadObjectList();

			/*
			 * If $joinFieldData is true all the data are included in the $activeOpt
			 * so we have to handle them accordingly e.g. Create category levels or encode cf values
			 */
			if($joinFieldData){
				if($field=='virtuemart_category_id' && !empty($activeOpt)){
					//$results=$this->createCatLevels($activeOpt);
					//$activeOpt=$results['options'];
				}
				else if($is_customfield!==false && !empty($activeOpt)){
					$sort_by='name';
					if(($customfilter->is_list && !empty($customfilter->custom_value)) || $customfilter->field_type=='E')$sort_by='default_values';
					$activeOpt=$this->encodeOptions($activeOpt);
					if($sort_by=='name')$this->sort_by($sort_by,$activeOpt);
				}
			}else{
				//convert to hexademical if custom filters
				if($is_customfield!==false){
					$activeOptions=array();
					if(is_array($activeOpt)){
						$activeOpt=$this->encodeOptions($activeOpt);
					}
				}
			}
			if(!empty($activeOpt))$activeOptions=cftools::arrayFromValList($activeOpt);
		}//else $activeOptions=true;
		//echo $field;
		return $activeOptions;
	}




	/**
	 * get the categories
	 * @param	Array	Contains the ids of the categories we want to display
	 * @param	String
	 * @author 	Sakis Terz
	 * @since 	1.0
	 */
	function getCategories(){
		$caching=false;
		$cahche_id='';
		$results=array();
		$displayCounterSetting=$this->moduleparams->get('category_flt_display_counter_results',1);
		$on_category_reset_others=$this->moduleparams->get('category_flt_onchange_reset_filters','1');

		//if the category tree is always the same and has no countering then get a cached version
		if(!$displayCounterSetting && $on_category_reset_others==true){
			$caching=true;
			$disp_vm_cat=$this->moduleparams->get('category_flt_disp_vm_cat','');
			$excluded_vm_cat=$this->moduleparams->get('category_flt_exclude_vm_cat','');
			$display_empty_opt=$this->moduleparams->get('category_flt_disable_empty_filters','1');
			$cahche_id=serialize($disp_vm_cat.$disp_vm_cat.$display_empty_opt);

			$cache = JFactory::getCache('com_customfilters_cats','');
			$cache->setCaching(true);
			$cache->setLifeTime(60);
			$results = $cache->get($cahche_id);
		}

		//runs when the cache is inactive or it returns nothing
		if(empty($results)){
			$db=JFactory::getDbo();
			$query=$db->getQuery(true);
			$query=$this->buildCategoriesQuery($query);
			//print_r((string)$query);
			$db->setQuery($query);
			$result=$db->loadObjectList();
			$results=$this->createCatLevels($result);
			if($caching)$cache->store($results,$cahche_id);
		}
		//print_r($result);

		return $results;
	}

	/**
	 * Build the query for the Categories
	 *
	 * @author	Sakis Terz
	 * @since	1.5.0
	 * @param	object The db query Object
	 * @return 	object The db query Object
	 */
	function buildCategoriesQuery($query,$part=false){
		$where=array();
		$where_str='';
		$innerJoin=array();
		$innerJoin_str='';
		$join_products=false;
		//if there are selections per filter
		if(isset($this->selected_fl_per_flt)){
			if(isset($this->selected_fl_per_flt['virtuemart_category_id']))$selected_flt=$this->selected_fl_per_flt['virtuemart_category_id'];
			else $selected_flt=array();
		}
		else $selected_flt=$this->selected_flt;

		//params
		$disp_vm_cat=$this->moduleparams->get('category_flt_disp_vm_cat','');
		$display_empty_opt=$this->moduleparams->get('category_flt_disable_empty_filters','1');

		//convert to array to sanitize data
		if(!empty($disp_vm_cat)){
			$cat_ids_ar=explode(',',$disp_vm_cat);
			JArrayHelper::toInteger($cat_ids_ar);
		}else $cat_ids_ar=array();

		//excluded categories
		$excluded_vm_cat=$this->moduleparams->get('category_flt_exclude_vm_cat','');
		//convert to array to sanitize data
		if(!empty($excluded_vm_cat)){
			$excluded_ids_ar=explode(',',$excluded_vm_cat);
			if(is_array($excluded_ids_ar))JArrayHelper::toInteger($excluded_ids_ar);
		}else $excluded_ids_ar=array();

		$cat_disp_order=$this->moduleparams->get('categories_disp_order');

		//counter
		$suffix=$this->fltSuffix['virtuemart_category_id'];
		$displayCounterSetting=$this->moduleparams->get($suffix.'_display_counter_results',1);
		$on_category_reset_others=$this->moduleparams->get('category_flt_onchange_reset_filters','1');

		/*
		 count results only when
		 the $displayCounterSetting is active and it is a part query (getActiveOptions)
		 or when all options are active (display type setting)
		 or the $displayCounterSetting is active and there is no selection
		 or when the $displayCounterSetting is active and the only selection is a category

		 //we don't want in any case to run the count both in the getActiveOptions and here
		 */
		if($displayCounterSetting){
			if($this->langPlugin)$table='plang';
			else $table='#__virtuemart_product_categories';
			//if display child products count them too. Otherwise only the parent products
			if($this->menuparams->get('display_child_products',0)==1)$query->select("COUNT($table.virtuemart_product_id) AS counter");
			else $query->select("SUM(CASE WHEN p.product_parent_id=0 THEN 1 ELSE 0 END) AS counter");
		}

		//if not part join the category products and the products_lang in case of multi-language site
		if($displayCounterSetting || $part){
			//get the parents if exist.Parents should be always displayed, otherwise the tree will be incomprehensive
			$parents_sql='';
			if(!isset($db))$db=JFactory::getDbo();
			$myQuery=$db->getQuery(true);
			$myQuery->select('DISTINCT cx.category_parent_id');
			$myQuery->from('#__virtuemart_category_categories AS cx');
			$myQuery->innerJoin('#__virtuemart_categories AS c ON cx.category_parent_id=c.virtuemart_category_id');
			$myQuery->where('cx.category_parent_id>0 AND c.published=1');
			$db->setQuery($myQuery);
			$parents=$db->loadColumn();
			if(!empty($parents)){
				$parents=implode(',',$parents);
				$parents_sql=" OR vc.virtuemart_category_id IN($parents)";
				
			}

			$query->leftJoin("#__virtuemart_product_categories ON langt.virtuemart_category_id=#__virtuemart_product_categories.virtuemart_category_id");
			if($this->langPlugin){
				$query->leftJoin("`#__virtuemart_products_".JLANGPRFX."` AS plang ON #__virtuemart_product_categories.virtuemart_product_id = plang.`virtuemart_product_id`");
			}
			//join the products table to check for unpublished
			//$query->leftJoin("(SELECT `virtuemart_product_id` FROM `#__virtuemart_products`  WHERE published=1)AS p ON #__virtuemart_product_categories.virtuemart_product_id = p.`virtuemart_product_id`");
			$query->leftJoin("`#__virtuemart_products` AS p ON #__virtuemart_product_categories.virtuemart_product_id = p.`virtuemart_product_id`");
			//$where[]="(p.published=1 $parents_sql)";

			if(!VmConfig::get('use_as_catalog',0)) {
				if (VmConfig::get('stockhandle','none')=='disableit_children') {
					$where[] = '((p.published=1 AND (p.`product_in_stock` - p.`product_ordered` >0 OR children.`product_in_stock` - children.`product_ordered` >0))'.$parents_sql.')';
					$query->leftJoin('`#__virtuemart_products` AS children ON p.`virtuemart_product_id` = children.`product_parent_id`');
				} else if (VmConfig::get('stockhandle','none')=='disableit') {
					$where[] = '((p.published=1 AND(p.`product_in_stock` - p.`product_ordered` >0))'.$parents_sql.')';
				}else $where[]="(p.published=1 $parents_sql)";
			}else $where[]="(p.published=1 $parents_sql)";


			//use of shopper groups
			if(count($this->shopperGroups)>0 && $this->componentparams->get('products_multiple_shoppers',0)){				
						
				$query->leftJoin("(SELECT #__virtuemart_product_categories.virtuemart_product_id,
					CASE WHEN (s.`virtuemart_shoppergroup_id` IN(".implode(',', $this->shopperGroups).") OR  (s.`virtuemart_shoppergroup_id`) IS NULL) THEN 1 ELSE 0 END AS `virtuemart_shoppergroup_id`  
					FROM `#__virtuemart_product_shoppergroups` AS s 
					RIGHT JOIN #__virtuemart_product_categories ON #__virtuemart_product_categories.virtuemart_product_id =s.virtuemart_product_id
					WHERE 
					(s.`virtuemart_shoppergroup_id` IN(".implode(',', $this->shopperGroups).") OR  (s.`virtuemart_shoppergroup_id`) IS NULL)
					GROUP BY #__virtuemart_product_categories.virtuemart_product_id
					) AS sp 
					ON  #__virtuemart_product_categories.virtuemart_product_id=sp.virtuemart_product_id");
					
				$where[]="(sp.virtuemart_shoppergroup_id=1 $parents_sql)";
					
			}
			$query->group('cx.category_child_id');
		}
			

		$innerJoin[]="#__virtuemart_category_categories AS cx ON cx.category_child_id=langt.virtuemart_category_id ";

		//where
		$cat_ids=implode(',',$cat_ids_ar);
		if (!empty($cat_ids)){
			$where[]="langt.virtuemart_category_id IN(".$cat_ids.")";
		}

		$excluded_cat_ids=implode(',',$excluded_ids_ar);
		if (!empty($excluded_cat_ids)){
			$where[]="langt.virtuemart_category_id NOT IN(".$excluded_cat_ids.")";
		}

		//define the categories order by and some other vars
		switch ($cat_disp_order){
			case 'ordering':
				$orderBy='vc.ordering, name';
				$fields='';
				break;
			case 'names':
				$orderBy='name';
				$fields='';
				break;
			case 'tree':
				$orderBy='cx.category_parent_id,vc.ordering';
				$fields=',cx.category_parent_id ,cx.category_child_id';
				break;
		}

		//published only
		$innerJoin[]="#__virtuemart_categories AS vc ON vc.virtuemart_category_id=langt.virtuemart_category_id";
		$where[]='vc.published=1';


		if(count($innerJoin)>0)$query->innerJoin(implode(" INNER JOIN ",$innerJoin));
		if(count($where)>0)$query->where(implode(" AND ",$where));

		//format the final query
		$query->select("langt.category_name AS name, langt.virtuemart_category_id AS id $fields");
		$query->from( "#__virtuemart_categories_".JLANGPRFX." AS langt");
		$query->order($orderBy);
		//print_r((string)$query);
		return $query;
	}

	/**
	 *
	 * Set categories to levels and order them appropriately
	 * @param 	array $categArray
	 * @return	array	The categories
	 * @since	1.0
	 */
	function createCatLevels($categArray){
		if(empty($categArray)) return;
		$maxLevel=0;
		$disp_vm_cat=$this->moduleparams->get('category_flt_disp_vm_cat','');
		$category_flt_disp_type=$this->moduleparams->get('category_flt_disp_type','1');

		//convert to array to sanitize data
		if(!empty($disp_vm_cat)){
			$cat_ids_ar=explode(',',trim($disp_vm_cat));
			JArrayHelper::toInteger($cat_ids_ar);
		}

		//excluded categories
		$excluded_vm_cat=$this->moduleparams->get('category_flt_exclude_vm_cat','');
		//convert to array to sanitize data
		if(!empty($excluded_vm_cat)){
			$excluded_ids_ar=explode(',',$excluded_vm_cat);
			if(is_array($excluded_ids_ar))JArrayHelper::toInteger($excluded_ids_ar);
		}else $excluded_ids_ar=array();

		$cat_disp_order=$this->moduleparams->get('categories_disp_order');

		if(empty($cat_ids_ar) && $cat_disp_order=='tree'){//create the tree

			$results=$this->orderVMcats($categArray,$excluded_ids_ar);
			if(empty($results))return;
			$levels=$this->getVmCatLevels($results);

			//add the spaces
			foreach($results as $key=>&$cat){
				$cat->level=$levels[$key];
				$cat->name=htmlspecialchars($cat->name);
				if($levels[$key]>$maxLevel)$maxLevel=$levels[$key];
				//add the blanks only when drop-down lists
				if($category_flt_disp_type==1){
					for($i=0; $i<$levels[$key]; $i++){
						$cat->name='&nbsp;&nbsp;'.$cat->name;	//add the blanks
					}
				}
			}
		}else {
			//when no tree
			//the returned array should be assoc with key the cat id
			foreach($categArray as $cat){
				$cat->name=htmlspecialchars($cat->name);
				$results[$cat->id]=$cat;
			}
		}

		$finalArray['options']=$results;
		$finalArray['maxLevel']=$maxLevel;
		//print_r($results);
		return $finalArray;
	}


	//create spaces according to the categories hierarhy
	function getVmCatLevels($results){
		if(!$results)return;
		$blank=0;
		$blanks=array();
		$blanks[0]=0;

		foreach($results as $res){
			if($blanks[$res->category_parent_id]>0)$blanks[$res->category_child_id]=$blanks[$res->category_parent_id];
			else $blanks[$res->category_child_id]=0;
			$blanks[$res->category_child_id]+=1;
		}

		//set the levels - removing them by 1 (1st should be zero)
		foreach($blanks as &$bl){
			$bl-=1;
		}
		return $blanks;
	}

	//order the categories
	function orderVMcats(&$categoryArr,$excluded_categ) {
		// Copy the Array into an Array with auto_incrementing Indexes

		$categCount=count($categoryArr);
		if($categCount>0){
			for($i=0; $i<$categCount; $i++){
				$resultsKey[$categoryArr[$i]->category_child_id]=$categoryArr[$i];
			}
			$key = array_keys($resultsKey); // Array of category table primary keys
			$nrows = $size = sizeOf($key); // Category count

			// Order the Category Array and build a Tree of it
			$id_list = array();
			$row_list = array();
			$depth_list = array();

			$children = array();
			$parent_ids = array();
			$parent_ids_hash = array();

			//Build an array of category references
			$category_temp = array();
			for ($i=0; $i<$size; $i++)
			{
				$category_tmp[$i] = &$resultsKey[$key[$i]];
				$parent_ids[$i] = $category_tmp[$i]->category_parent_id;

				if($category_tmp[$i]->category_parent_id == 0 || in_array($category_tmp[$i]->category_parent_id, $excluded_categ))
				{
					array_push($id_list,$category_tmp[$i]->category_child_id);
					array_push($row_list,$i);
					array_push($depth_list,0);
				}

				$parent_id = $parent_ids[$i];

				if (isset($parent_ids_hash[$parent_id]))
				{
					$parent_ids_hash[$parent_id][$i] = $parent_id;

				}
				else
				{
					$parent_ids_hash[$parent_id] = array($i => $parent_id);

				}
			}
			$loop_count = 0;
			$watch = array(); // Hash to store children
			while(count($id_list) < $nrows) {
				if( $loop_count > $nrows )break;
				$id_temp = array();
				$row_temp = array();

				for($i = 0 ; $i < count($id_list) ; $i++) {
					$id = $id_list[$i];
					$row = $row_list[$i];
					if (isset($parent_ids_hash[$id]) && $id>0){$resultsKey[$id]->isparent=true;}
					array_push($id_temp,$id);
					array_push($row_temp,$row);

					if (isset($parent_ids_hash[$id]))
					{	$children = $parent_ids_hash[$id];
					foreach($children as $key => $value) {
						if( !isset($watch[$id][$category_tmp[$key]->category_child_id])) {
							$watch[$id][$category_tmp[$key]->category_child_id] = 1;
							$category_tmp[$key]->isparent=false;
							array_push($id_temp,$category_tmp[$key]->category_child_id);
							array_push($row_temp,$key);
						}
					}
					}
				}
				$id_list = $id_temp;
				$row_list = $row_temp;
				$loop_count++;
			}
			$orderedArray=array();
			for($i=0; $i<count($resultsKey); $i++){
				if(isset($id_list[$i]) && isset($resultsKey[$id_list[$i]])){
					$parent_id=$resultsKey[$id_list[$i]]->category_parent_id;

					if($parent_id==0){
						//if(!empty($resultsKey[$id_list[$i]]->isparent))$resultsKey[$id_list[$i]]->cat_tree=$parent_id.'-'.$resultsKey[$id_list[$i]]->category_child_id;
						//else
						$resultsKey[$id_list[$i]]->cat_tree=$parent_id;
					}
					else {
						if(isset($resultsKey[$parent_id]->cat_tree))$parent_tree=$resultsKey[$parent_id]->cat_tree;
						else $parent_tree='0';

						//if(!empty($resultsKey[$id_list[$i]]->isparent))$parent_tree.='-'.$parent_id.'-'.$resultsKey[$id_list[$i]]->category_child_id;
						//else
						$parent_tree.='-'.$parent_id;
						$resultsKey[$id_list[$i]]->cat_tree=$parent_tree;
					}
					$orderedArray[$id_list[$i]]=$resultsKey[$id_list[$i]];
				}
			}
			return $orderedArray;
		}return;
	}

	/**
	 * Gets the options for the manufacturers
	 *
	 * @author	Sakis Terz
	 * @since	1.0
	 * @return 	array	A list of objects with the available options
	 */
	function getManufacturers(){
		$db=JFactory::getDbo();
		$query=$db->getQuery(true);
		$query=$this->buildManufQuery($query);
		$db->setQuery($query);
		//print_r((string)$query);
		$manufs=cftools::arrayFromValList($db->loadObjectList());
		return $manufs;
	}

	/**
	 * Build the query for the manufacturers
	 *
	 * @author	Sakis Terz
	 * @since	1.5.0
	 * @param	$query object The db query Object
	 * @param	$part Boolean	Indicates if this is a query part or the whole query
	 * @return 	object The db query Object
	 */
	function buildManufQuery($query, $part=false){
		$suffix=$this->fltSuffix['virtuemart_manufacturer_id'];
		$displayCounterSetting=$this->moduleparams->get($suffix.'_display_counter_results',1);
		$display_type=$this->moduleparams->get($suffix.'_disp_type',1);
		$query->innerJoin("#__virtuemart_manufacturers AS vm ON vm.virtuemart_manufacturer_id=langt.virtuemart_manufacturer_id");
		//use the media only if image link
		if($display_type==7)$query->leftJoin("#__virtuemart_manufacturer_medias AS manuf_med ON vm.virtuemart_manufacturer_id=manuf_med.virtuemart_manufacturer_id");
		$display_empty_opt=$this->moduleparams->get('manuf_flt_disable_empty_filters','1');
		//if there are selections per filter
		if(isset($this->selected_fl_per_flt)){
			if(isset($this->selected_fl_per_flt['virtuemart_manufacturer_id']))$selected_flt=$this->selected_fl_per_flt['virtuemart_manufacturer_id'];
			else $selected_flt=array();
		}
		else $selected_flt=$this->selected_flt;


		/*
		 count results only when
		 the $displayCounterSetting is active
		 */
		if($displayCounterSetting){
			if($this->langPlugin)$table='plang';
			else $table='#__virtuemart_product_manufacturers';
			//if display child products
			if($this->menuparams->get('display_child_products',0)==1)$query->select("COUNT($table.virtuemart_product_id) AS counter");
			else $query->select("SUM(CASE WHEN p.product_parent_id=0 THEN 1 ELSE 0 END) AS counter");
			$query->group('langt.virtuemart_manufacturer_id');
		}


		if($displayCounterSetting || $part){
			$query->leftJoin("#__virtuemart_product_manufacturers ON langt.virtuemart_manufacturer_id=#__virtuemart_product_manufacturers.virtuemart_manufacturer_id");
			if($this->langPlugin){
				$query->leftJoin("`#__virtuemart_products_".JLANGPRFX."` AS plang ON #__virtuemart_product_manufacturers.virtuemart_product_id = plang.`virtuemart_product_id`");
			}

			//join the products table to check for unpublished
			$query->innerJoin("`#__virtuemart_products` AS p ON #__virtuemart_product_manufacturers.virtuemart_product_id = p.`virtuemart_product_id`");


			//stock control
			if(!VmConfig::get('use_as_catalog',0)) {
				if (VmConfig::get('stockhandle','none')=='disableit_children') {
					$query->where('(p.`product_in_stock` - p.`product_ordered` >0 OR children.`product_in_stock` - children.`product_ordered` >0)');
					$query->leftJoin('`#__virtuemart_products` AS children ON p.`virtuemart_product_id` = children.`product_parent_id`');
				} else if (VmConfig::get('stockhandle','none')=='disableit') {
					$query->where('(p.`product_in_stock` - p.`product_ordered` >0)');
				}
			}
			//use of shopper groups
			if(count($this->shopperGroups)>0 && $this->componentparams->get('products_multiple_shoppers',0)){
				$query->innerJoin("(SELECT #__virtuemart_product_manufacturers.virtuemart_product_id,s.`virtuemart_shoppergroup_id` FROM `#__virtuemart_product_shoppergroups` AS s
					RIGHT JOIN #__virtuemart_product_manufacturers ON #__virtuemart_product_manufacturers.virtuemart_product_id =s.virtuemart_product_id WHERE
					(s.`virtuemart_shoppergroup_id` IN(".implode(',', $this->shopperGroups).") OR (s.`virtuemart_shoppergroup_id`) IS NULL) GROUP BY #__virtuemart_product_manufacturers.virtuemart_product_id) AS sp 
					ON  #__virtuemart_product_manufacturers.virtuemart_product_id=sp.virtuemart_product_id");
			}
			$query->where(" p.published=1");
		}



		$query->select("langt.virtuemart_manufacturer_id AS id, langt.mf_name AS name");
		if($display_type==7)$query->select("manuf_med.virtuemart_media_id AS media_id");
		$query->from("#__virtuemart_manufacturers_".JLANGPRFX." AS langt");
		$query->where("vm.published=1");
		$query->order("name ASC");
		//print_r((string)$query);
		return $query;
	}



	//___CF___//

	/**
	 * Gets the options of a custom filter
	 *
	 * @author	Sakis Terz
	 * @since	1.0
	 * @param	object	The custom filter object
	 * @return 	array	A list of objects with the available options
	 */
	function getCustomOptions($customfilter){
		$db=JFactory::getDbo();
		$query=$db->getQuery(true);
		$query=$this->buildCustomFltQuery($query,$customfilter);

		$db->setQuery($query);
		$options=$db->loadObjectList();
		//if($db->getErrorMsg())JFactory::getApplication()->enqueueMessage($db->getErrorMsg());
		$sort_by='name';
		if($customfilter->is_list && !empty($customfilter->custom_value) || $customfilter->field_type=='E')$sort_by='default_values';
		//print_r($options);
		//print_r((string)$query);

		$opt_array=$this->encodeOptions($options);
		//sort after the translation
		if($sort_by=='name')$this->sort_by($sort_by,$opt_array);//sort alphabetically
		return $opt_array;
	}


	/**
	 * Build the query for the custom options
	 *
	 * @author	Sakis Terz
	 * @since	1.5.0
	 * @param	object The db query Object
	 * @param	int		The virtuemart_custom_id
	 * @param	String	The type of the custom field
	 * @param	Boolean	Indicates if this is a query part or the whole query
	 * @return 	object The db query Object
	 */
	function buildCustomFltQuery($query,$customfilter,$part=false){
		$vmCompatibility=VmCompatibility::getInstance();
		JPluginHelper::importPlugin ('vmcustom');
		$id=$customfilter->custom_id;
		$field_type=$customfilter->field_type;
		$suffix=$this->fltSuffix['custom_f'];
		$displayCounterSetting=$this->moduleparams->get($suffix.'_display_counter_results',0);
		$display_empty_opt=$this->moduleparams->get('custom_flt_disable_empty_filters','1');
		//if there are selections per filter
		if(isset($this->selected_fl_per_flt)){
			if(isset($this->selected_fl_per_flt['custom_f_'.$id]))$selected_flt=$this->selected_fl_per_flt['custom_f_'.$id];
			else $selected_flt=array();
		}
		else $selected_flt=$this->selected_flt;

		//is plugin
		if($field_type=='E'){
			if(!isset($customfilter->pluginparams))return;
			$pluginparams=$customfilter->pluginparams;
			$customvalues_table=$pluginparams->customvalues_table;
			$product_customvalues_table=$pluginparams->product_customvalues_table;
			$filter_by=$pluginparams->filter_by_field;
			$customvalue_value_field=$pluginparams->customvalue_value_field;
			//if the values and the product relationships are in the different tables
			if($product_customvalues_table!=$customvalues_table){
				$query->innerJoin($product_customvalues_table.' AS cfp ON cf.'.$filter_by.'=cfp.'.$filter_by);
			}
		}else{
			$customvalues_table='cfp';
			$product_customvalues_table='#__virtuemart_product_customfields';
			$filter_by=$vmCompatibility->getColumnName('custom_value');
		}

		/*
		 count results only when the $displayCounterSetting is active and there is no selection
		 or when the $displayCounterSetting is active and the only selection is that cf
		 in all other cases the counting will be done within the getActiveOptions function
		 */
		if($displayCounterSetting){
			if($this->langPlugin)$table='plang';
			else $table='cfp';
			$selectType="";

			//if display child products
			if($this->menuparams->get('display_child_products',0)==1)$query->select("COUNT($table.virtuemart_product_id) AS counter");
			else $query->select("SUM(CASE WHEN p.product_parent_id=0 THEN 1 ELSE 0 END) AS counter");			
		}else $selectType="DISTINCT";

		if($displayCounterSetting || $part){

			if($this->langPlugin){
				$query->leftJoin("`#__virtuemart_products_".JLANGPRFX."` AS plang ON cfp.virtuemart_product_id = plang.`virtuemart_product_id`");
			}
			//join the products table to check for unpublished
			$query->innerJoin("`#__virtuemart_products` AS p ON cfp.virtuemart_product_id = p.`virtuemart_product_id`");
			$query->where(" p.published=1");
			$query->group('cfp.'.$filter_by);

			//stock control
			if(!VmConfig::get('use_as_catalog',0)) {
				if (VmConfig::get('stockhandle','none')=='disableit_children') {
					$query->where('(p.`product_in_stock` - p.`product_ordered` >0 OR children.`product_in_stock` - children.`product_ordered` >0)');
					$query->leftJoin('`#__virtuemart_products` AS children ON p.`virtuemart_product_id` = children.`product_parent_id`');
				} else if (VmConfig::get('stockhandle','none')=='disableit') {
					$query->where('(p.`product_in_stock` - p.`product_ordered` >0)');
				}
			}

			//use of shopper groups
			if(count($this->shopperGroups)>0 && $this->componentparams->get('products_multiple_shoppers',0)){
				$query->innerJoin("(SELECT cfp.virtuemart_product_id,s.`virtuemart_shoppergroup_id` FROM `#__virtuemart_product_shoppergroups` AS s
					RIGHT JOIN ".$product_customvalues_table." AS cfp ON cfp.virtuemart_product_id =s.virtuemart_product_id WHERE
					(s.`virtuemart_shoppergroup_id` IN(".implode(',', $this->shopperGroups).") OR (s.`virtuemart_shoppergroup_id`) IS NULL) GROUP BY cfp.virtuemart_product_id) AS sp 
					ON  cfp.virtuemart_product_id=sp.virtuemart_product_id");
			}
			
		}



		//if not plugin
		if($field_type!='E'){
			//when boolean display Yes or No in case of 0 and 1
			if($field_type=='B'){
				$jyes=JText::_('JYES');
				$jno=JText::_('JNO');
				$name_string="(CASE WHEN cfp.".$vmCompatibility->getColumnName('custom_value')."='0' THEN '{$jno}' ELSE '{$jyes}' END) AS name";
			}else $name_string="cfp.".$vmCompatibility->getColumnName('custom_value')." AS name";

			$query->select("$selectType cfp.".$vmCompatibility->getColumnName('custom_value')." AS id,$name_string");
			$query->from('#__virtuemart_product_customfields AS cfp');
			$query->where("(cfp.".$vmCompatibility->getColumnName('custom_value')." IS NOT NULL AND cfp.".$vmCompatibility->getColumnName('custom_value')."!='')");
			if(!$part)$query->where("cfp.".$vmCompatibility->getColumnName('virtuemart_custom_id')."=".$id);
			$order='`name` ASC';

			//if its a list get the list ordering, otherwise alphabetically
			if($customfilter->is_list && !empty($customfilter->custom_value)){
				$is_list=true;
				$defaultValues=explode(';',$customfilter->custom_value);
				if($defaultValues!==false){
					$counter=count($defaultValues);
					$orderfields='';
					for($i=0; $i<$counter; $i++){
						$orderfields.="'$defaultValues[$i]'";
						if($i<$counter-1)$orderfields.=',';
					}
					if(!empty($orderfields))$order='FIELD(cfp.'.$vmCompatibility->getColumnName('custom_value').','.$orderfields.')';
				}
			}
			//print_r((string)$query);
		}
		//plugins should exec that function (plugin hook)
		else{
			$query->select("$selectType cf.$filter_by AS id,$customvalue_value_field AS name");
			$query->from($customvalues_table.' AS cf');
			if(!$part)$query->where("cf.".$vmCompatibility->getColumnName('virtuemart_custom_id')."=$id");
			$order=$pluginparams->sort_by; //change that later
			//print_r((string)$query);
		}
		$query->order("$order");
		return $query;
	}


	/**
	 * Encode the option's value
	 * Options may contain special characters, which will break the url query
	 * So we convert them to hex values
	 * @param	Array	An object array with the options
	 * @return	Array	The object array with the value attribute in hex format
	 * @since	1.0
	 * @author	Sakis Terz
	 */
	function encodeOptions($opt_array){
		if(empty($opt_array))return $opt_array;
		$new_opt_array=array();
		$i=1; //it must be >0. 0 is used for the clear (1st option)
		foreach ($opt_array as $op){
			//$op->id=$jfilter->stringURLSafe($op->id);
			/*$jfilter->cleanText ($op->id);*/
			if(isset($op->name)){
				//only if it can be translated
				preg_match('/^[0-9A-Z_-]+$/i', $op->name, $matches);
				if(!empty($matches[0]))$op->name=JText::_($op->name);
			}
			$op->id=bin2hex(trim($op->id));
			$new_opt_array[$i]=$op;
			$i++;
			//$op->id=bin2hex($op->id);
		}
		return $new_opt_array;
	}

	/**
	 * Sort the options in ascending order
	 * Options may translated in other languages, so they need to be translated
	 * @param	Array	An object array with the options
	 * @return	Array
	 * @since	1.1
	 * @author	Sakis Terz
	 */
	function sort_by($field='name', &$arr, $sorting=SORT_ASC, $case_insensitive=false){
		if(is_array($arr) && (count($arr)>0) ){
			if($case_insensitive==true) $strcmp_fn = "strnatcasecmp";
			else $strcmp_fn = "strnatcmp";

			if($sorting==SORT_ASC){
				$fn = create_function('$a,$b', '
                    if(is_object($a) && is_object($b)){
                        return '.$strcmp_fn.'($a->'.$field.', $b->'.$field.');
                    }else if(is_array($a) && is_array($b)){
                        return '.$strcmp_fn.'($a["'.$field.'"], $b["'.$field.'"]);
                    }else return 0;
                ');
			}else{
				$fn = create_function('$a,$b', '
                    if(is_object($a) && is_object($b)){
                        return '.$strcmp_fn.'($b->'.$field.', $a->'.$field.');
                    }else if(is_array($a) && is_array($b)){
                        return '.$strcmp_fn.'($b["'.$field.'"], $a["'.$field.'"]);
                    }else return 0;
                ');
			}
			usort($arr, $fn);
			//sort correctly - usort removes the array keys
			$arr=cftools::arrayFromValList($arr);
			return true;
		}else{
			return false;
		}
	}


	/**
	 * Control the display rules params for the specified flt to check if a filter should be displayed in the current page
	 * @param	string	The filter name abbreviation
	 * @param	object	The params obj
	 * @return	boolean	True if allow display else false
	 * @author	Sakis Terz
	 * @since	1.0
	 */
	public static function getDisplayControl($flt_sfx, $selected_flt,$params){
		$disp=false;
		$app = JFactory::getApplication() ;
		$jinput=$app->input;

		//those vars sgould be taken from the jinput becuase they may come from other Component than CF (e.g. VM)
		$option=$jinput->get('option','cmd');
		$view=$jinput->get('view','');
		$vm_cat_id=$jinput->get('virtuemart_category_id',0,'array');
		$vm_mnf_id=$jinput->get('virtuemart_manufacturer_id',0,'array');
		$vm_prd_id=$jinput->get('virtuemart_product_id',0,'array');
		$is_published_param=$flt_sfx.'_published';
		$is_published=$params->get($is_published_param);


		//always visible in the cf pages
		if($is_published){
			if($option=='com_customfilters'){
				$disp=true;
			}else if($option=='com_virtuemart'){
				if($view=='category' && !empty($vm_cat_id)){
					$param_name=$flt_sfx.'_vm_category_pages';
				}
				//manufacturer page or the page that comes after selecting a manufacturer (category page)
				else if(($view=='manufacturer' && !empty($vm_mnf_id)) || ($view=='category' && !empty($vm_mnf_id))){
					$param_name=$flt_sfx.'_vm_manuf_pages';
				}
				else if($view=='productdetails' && $vm_prd_id){
					$param_name=$flt_sfx.'_vm_productdetails_pages';
				}
				//other views
				else if(($view!='manufacturer' && $view!='category' && $view!='productdetails') || ($view=='category' && empty($vm_cat_id) && empty($vm_mnf_id))){//other
					$param_name=$flt_sfx.'_vm_other_pages';
				}
				if(isset($param_name))$disp=$params->get($param_name);
			}else{//non virtuemart pages
				$param_name=$flt_sfx.'_non_vm_pages';
				$disp=$params->get($param_name);
			}

			/* for the custom filters there is an extra condition
			 * display only if other filters are selected
			 */

			if($disp){
				if($flt_sfx=='custom_flt')$disp_with_fltrs=$params->get('custom_flt_disp_after','1');
				else if($flt_sfx=='manuf_flt')$disp_with_fltrs=$params->get('manuf_flt_disp_after','1');
				else $disp_with_fltrs=1;

				//the keys of the array that contains the selected options
				$selected_filters_keys=array_keys($selected_flt);
				$selected_filters_keys_str=implode('|',$selected_filters_keys);

				//display always
				if($disp_with_fltrs==1)return true;

				//display only if category is selected
				else if($disp_with_fltrs=='vm_cat'){
					if(isset($selected_flt['virtuemart_category_id']))$disp=true;
					else $disp=false;
				}
				//display only if manuf is selected
				else if($disp_with_fltrs=='vm_manuf'){
					if(isset($selected_flt['virtuemart_manufacturer_id']))$disp=true;
					else $disp=false;
				}

				//display only if a price is selected
				else if($disp_with_fltrs=='price'){
					if(isset($selected_flt['price']))$disp=true;
					else $disp=false;
				}

				//display  if category or manuf is selected
				else if($disp_with_fltrs=='vm_cat_or_vm_manuf'){
					if(isset($selected_flt['virtuemart_category_id'])  || isset($selected_flt['virtuemart_manufacturer_id']))$disp=true;
					else $disp=false;
				}

				//display  if category , a manuf or a price is selected
				else if($disp_with_fltrs=='vm_cat_or_vm_manuf_or_price'){
					if(isset($selected_flt['virtuemart_category_id'])  || isset($selected_flt['virtuemart_manufacturer_id']) || isset($selected_flt['price']))$disp=true;
					else $disp=false;
				}

				//display  if category and manuf is selected
				else if($disp_with_fltrs=='vm_cat_and_vm_manuf'){
					if(isset($selected_flt['virtuemart_category_id']) && isset($selected_flt['virtuemart_manufacturer_id']))$disp=true;
					else $disp=false;
				}
				else if($disp_with_fltrs=='vm_cat_or_customfilter'){
					if(isset($selected_flt['virtuemart_category_id']) || strpos($selected_filters_keys_str, 'custom_f_')!==false)$disp=true;
					else $disp=false;
				}
			}
			return $disp;
		}
		return false;
	}

	/**
	 * Check if a custom filter should be displayed based on the settings of this filter
	 *
	 * @param 	object $cf
	 * @since	1.9.0
	 */
	function displayCustomFilter($cf){
		$cfparams=new JRegistry();
		$cfparams->loadString ($cf->params,'JSON');
		$flt_to_categories=$cfparams->get('filter_category_ids',array());
		//there are categories assigned
		if(!empty($flt_to_categories)){
			if(isset($this->selected_flt['virtuemart_category_id'])){
				$selected_cat=$this->selected_flt['virtuemart_category_id'];
				foreach($selected_cat as $cat){
					if(in_array($cat, $flt_to_categories))return true;
				}
			}
			return false;
		}
		return true;
	}
}