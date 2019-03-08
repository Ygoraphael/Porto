<?php
/**
 * Simple Import
 *
 * @package Simple Import
 * @author Joe Harwell - iMarketing Solutions LLC
 * @link http://virtuemartjoomla.com
 * @copyright Copyright (C) 2012 Joe Harwell - iMarketing Solutions LLC
 * @version: 2.1.1 2012-8-5
 */
 
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
 
class SimpleimportViewImportdata extends JView
{
	private $db;	
	private	$product_id, 
		$product_parent_sku,
		$product_sku,
		$product_price,
		$product_s_desc,
		$product_desc,
		$file_url_thumb,
		$file_url,
		$product_weight,
		$product_weight_uom,
		$product_length,
		$product_width,
		$product_height,
		$product_lwh_uom,
		$product_special,
		$product_name,
		$category_name,
		$mf_name,
		$related_products,
		$variant_type,
		$variant_value;	
	private $error_list = array();
	
	function display($tpl = null)
    {
		$debug = 0;
        parent::display($tpl);
		$document = &JFactory::getDocument();
		$this->db =& JFactory::getDBO();
		$product_html_code = "";
		
		$params = JComponentHelper::getParams('com_languages');
		$lang = $params->get('site', 'en-GB');//use default joomla
		$lang = strtolower(strtr($lang,'-','_'));
		
		$TheFileName = $_FILES["file"]["tmp_name"];
		$fh = fopen($TheFileName, 'r');
		if (!$fh){
			array_push($this->error_list, "File Could Not Be Opened<br />");
		}
		$Headers = fgetcsv($fh);
		if (!$Headers){
			array_push($this->error_list, "Problem Reading Headers<br />");
		}
		$i = 0;
		foreach ($Headers as $value){
			$value = strtolower($value);
			switch ($value){
				case "product_id":
					$this->product_id = $i;
					break;
				case "product_parent_sku":
					$this->product_parent_sku = $i;
					break;
				case "product_sku":
					$this->product_sku = $i;
					break;
				case "product_price":
					$this->product_price = $i;
					break;
				case "product_s_desc":
					$this->product_s_desc = $i;
					break;
				case "product_desc":
					$this->product_desc = $i;
					break;
				case "file_url_thumb":
					$this->file_url_thumb = $i;
					break;
				case "file_url":
					$this->file_url = $i;
					break;
				case "product_weight":
					$this->product_weight = $i;
					break;
				case "product_weight_uom":
					$this->product_weight_uom = $i;
					break;
				case "product_length":
					$this->product_length = $i;
					break;
				case "product_width":
					$this->product_width = $i;
					break;
				case "product_height":
					$this->product_height = $i;
					break;
				case "product_lwh_uom":
					$this->product_lwh_uom = $i;
					break;
				case "product_special":
					$this->product_special = $i;
					break;
				case "product_name":
					$this->product_name = $i;
					break;
				case "category_name":
					$this->category_name = $i;
					break;
				case "mf_name":
					$this->mf_name = $i;
					break;
				case "related_products":
					$this->related_products = $i;
					break;
				case "variant_type":
					$this->variant_type = $i;
					break;
				case "variant_value":
					$this->variant_value = $i;
					break;
			}
		
			$i++;
		}
		$related_list = array();
		$master_related_list = array();
		$product_count = 1;
		while($theData = fgetcsv($fh)){
		
			$theData[$this->product_name] = $this->db->getEscaped(html_entity_decode(str_replace('&trade;', chr(153), $theData[$this->product_name]),ENT_QUOTES));
			$theData[$this->product_s_desc] = $this->db->getEscaped(html_entity_decode(str_replace('&trade;', chr(153), $theData[$this->product_s_desc]),ENT_QUOTES));
			$theData[$this->product_desc] = $this->db->getEscaped($theData[$this->product_desc]);
			$theData[$this->category_name] = $this->db->getEscaped($theData[$this->category_name]);
			
			if($product_count <= 11){
				$product_html_code = '
			<div style="margin-left:auto; margin-right:auto; width:800px; border:1px solid #CCC; margin-top:1px; margin-bottom:2px; padding:5px;">
				<img style="float:right; margin:10px; border:1px solid #999;" src="/images/stories/virtuemart/product/'.$theData[$this->file_url_thumb].'" />
				<h3>'.$theData[$this->product_name].'</h3>
				<p>
				'.$theData[$this->product_sku].' - $ '. $theData[$this->product_price] .' 
				</p>
				<p class="product_s_description">'.$theData[$this->product_s_desc].'</p>
				<p class="product_description">'.$theData[$this->product_desc].'</p>
				<p calss="category_name">'.$theData[$this->category_name].'</p>
				<div style="clear:both;"></div>
			</div>	
				';
				echo $product_html_code;
			}
			$product_count++;
			
			//Check to see if there is a parent.  If there is, then I need to handle it...
			if ($theData[$this->product_sku] != $theData[$this->product_parent_sku]){
				$q = "SELECT virtuemart_product_id FROM `#__virtuemart_products` WHERE product_sku = '".$theData[$this->product_parent_sku]."'";
				//echo "Query:".$q;
				$this->db->setQuery($q);
				
				if($result = $this->db->loadResult()){
					$parent_id = $result;
				} else {
					$parent_id = SimpleimportViewImportdata::CreateParent($theData, $product_count);
				}
				$is_parent = 1;
			} else {
				$parent_id = (integer)0;	
				$is_parent = 0;
			}
			if ($theData[$this->product_id] == ""){
				$insert = 1;
				$q = "INSERT INTO `#__virtuemart_products` (product_parent_id,
															   product_sku,
															   product_weight,
															   product_weight_uom,
															   product_length,
															   product_width,
															   product_height,
															   product_lwh_uom,
															   product_special,
															   product_in_stock,
															   low_stock_notification,
															   product_params,
															   published) 
													   VALUES ($parent_id,
															   '".$theData[$this->product_sku]."',
															   ".$theData[$this->product_weight].",
															   '".$theData[$this->product_weight_uom]."',
															   ".$theData[$this->product_length].",
															   ".$theData[$this->product_width].",
															   ".$theData[$this->product_height].",
															   '".$theData[$this->product_lwh_uom]."',
															   '".$theData[$this->product_special]."',
															   0,
															   0,
															   'min_order_level=d:0;|max_order_level=d:0;|',
															   1)";
			} else {
				$insert = 0;
				$q = "UPDATE `#__virtuemart_products` SET
						product_sku = '".$theData[$this->product_sku]."',
						product_weight = ".$theData[$this->product_weight].",
						product_weight_uom = '".$theData[$this->product_weight_uom]."',
						product_length = ".$theData[$this->product_length].",
						product_width = ".$theData[$this->product_width].",
						product_height = ".$theData[$this->product_height].",
						product_lwh_uom = '".$theData[$this->product_lwh_uom]."',
						product_special = '".$theData[$this->product_special]."'
					 WHERE
						product_id = ".$theData[$product_id];
			}
			$this->db->setQuery($q);
			$result = $this->db->query();
			if (!$result) {
				$error =  "Error on Line " . $product_count . "<br />";
				array_push($this->error_list, $error);
				$error = $q . "<br />";
				array_push($this->error_list, $error);
				$error = "Main " . $theData[$this->product_name] . ":" . $theData[$this->product_s_desc] . "<br />";
				array_push($this->error_list, $error);
				$error = $this->db->getErrorMsg();
				array_push($this->error_list, $error);
				//die('<p class="alert"><h1>Invalid Data</h1></p>');
			}
			
			if ($insert){
				$virtuemart_product_id = $this->db->insertid();
			}else{
				$virtuemart_product_id = $theData[$this->product_id];		
			}
			if($debug){
				echo "Product ID: $virtuemart_product_id";	
			}
			
			if ($is_parent){
				$q = "INSERT INTO `#__virtuemart_products_$lang` (virtuemart_product_id,
																	 product_s_desc,
																	 product_desc,
																	 product_name,
																	 metadesc,
																	 metakey,
																	 customtitle,
																	 slug)
															 VALUES ($virtuemart_product_id,
																	 '".$theData[$this->product_s_desc]."',
																	 '".$theData[$this->product_desc]."',
															'".$theData[$this->variant_value]. " - " .$theData[$this->product_name]."',
																	 '".$theData[$this->metadesc]."',
																	 '".$theData[$this->metakey]."',
																	 '".$theData[$this->customtitle]."',
																	 '".$theData[$this->product_sku]."')";	
			}else{
				$q = "INSERT INTO `#__virtuemart_products_$lang` (virtuemart_product_id,
																	 product_s_desc,
																	 product_desc,
																	 product_name,
																	 metadesc,
																	 metakey,
																	 customtitle,
																	 slug)
															 VALUES ($virtuemart_product_id,
																	 '".$theData[$this->product_s_desc]."',
																	 '".$theData[$this->product_desc]."',
																	 '".$theData[$this->product_name]."',
																	 '".$theData[$this->metadesc]."',
																	 '".$theData[$this->metakey]."',
																	 '".$theData[$this->customtitle]."',
																	 '".$theData[$this->product_sku]."')";	
			}
			$this->db->setQuery($q);
			$result = $this->db->query();
			if (!$result) {
				$error =  "Error on Line " . $product_count . "<br />";
				array_push($this->error_list, $error);
				$error = $q . "<br />";
				array_push($this->error_list, $error);
				$error = $this->db->getErrorMsg();
				array_push($this->error_list, $error);
				//die('<p class="alert"><h1>Invalid Data</h1></p>');
			}
			
			
			$q = "INSERT INTO `#__virtuemart_medias`
								(file_description,
								 file_url,
								 file_url_thumb,
								 file_title,
								 file_meta,
								 file_type,
								 file_mimetype)
						 VALUES ('".$theData[$this->product_s_desc]."',
								 '".$theData[$this->file_url]."',
								 '".$theData[$this->file_url_thumb]."',
								 '".$theData[$this->product_name]."',
								 '".$theData[$this->product_s_desc]."',
								 'product',
								 'image/jpeg')";
			$this->db->setQuery($q);
			$result = $this->db->query();
			if (!$result) {
				$error =  "Error on Line " . $product_count . "<br />";
				array_push($this->error_list, $error);
				$error = $q . "<br />";
				//echo $q . "<br />";
				array_push($this->error_list, $error);
				$error = $this->db->getErrorMsg();
				array_push($this->error_list, $error);
				//die('<p class="alert"><h1>Invalid Data</h1></p>');
			}								 
			$virtuemart_media_id = $this->db->insertid();			
			$q = "INSERT INTO `#__virtuemart_product_medias`
								(virtuemart_product_id,
								 virtuemart_media_id)
						 VALUES ($virtuemart_product_id,
								 $virtuemart_media_id)";
			$this->db->setQuery($q);
			$result = $this->db->query();
			if (!$result) {
				$error =  "Error on Line " . $product_count . "<br />";
				array_push($this->error_list, $error);
				$error = $q . "<br />";
				array_push($this->error_list, $error);
				$error = $this->db->getErrorMsg();
				array_push($this->error_list, $error);
				//die('<p class="alert"><h1>Invalid Data</h1></p>');
			}								 
			
			
			
			
			$q = "INSERT INTO `#__virtuemart_product_prices` (virtuemart_product_id,
																 product_price)
														 VALUES ($virtuemart_product_id,
																 ".$theData[$this->product_price].")";
			$this->db->setQuery($q);
			$result = $this->db->query();
			if (!$result) {
				$error =  "Error on Line " . $product_count . "<br />";
				array_push($this->error_list, $error);
				$error = $q . "<br />";
				array_push($this->error_list, $error);
				$error = $this->db->getErrorMsg();
				array_push($this->error_list, $error);
				//die('<p class="alert"><h1>Invalid Data</h1></p>');
			}

//Start of Categories..  If this is a child.. then don't assign to category.
	if ($theData[$this->product_sku] == $theData[$this->product_parent_sku]){

			$categories = explode(";", $theData[$this->category_name]);
			foreach ($categories as $value){
				$parent_child = explode("/", $value);
				$next = 0;
				$category_parent_id = 0;
				
				//Check for existing parent.. We don't want parents with the same name. Nor children of same parent w same name.
				$q = "SELECT virtuemart_category_id FROM `#__virtuemart_categories_$lang` WHERE category_name = '$parent_child[0]'";
				$this->db->setQuery($q);
				if($result = $this->db->loadResult()){
					//A parent with this name alrady exists.  So Now Check the childs name.
					$parent = $result;
					if($debug){
						echo "Parent $parent_child[0] Exists. Checking Child<br />";	
					}
					if(sizeof($parent_child) > 1){
						$i = 1;
						for($i=1; $i<sizeof($parent_child); $i++){
							$q = "SELECT x.category_child_id FROM `#__virtuemart_category_categories` as x
								  JOIN `#__virtuemart_categories_$lang` as c ON c.virtuemart_category_id = x.category_child_id
								  WHERE x.category_parent_id = $parent AND c.category_name = '$parent_child[$i]'";
							$this->db->setQuery($q);
							if($debug){
								echo "Child Check Query: $q<br /><br />";	
							}
							if($result = $this->db->loadResult()){
								$parent = $result;	
								if($debug){
									echo "Child $parent_child[$i] Exists.<br />";	
								}
											
							}else{
								$q = "INSERT INTO `#__virtuemart_categories` (category_layout,
																			  category_product_layout,
																			  products_per_row,
																			  limit_list_start,
																			  limit_list_step,
																			  limit_list_max,
																			  limit_list_initial,
																			  published,
																			  ordering,
																			  category_template,
																			  virtuemart_vendor_id)
																	  VALUES ('default',
																	  		  'default',
																			   3,
																			   0,
																			   20,
																			   0,
																			   20,
																			   1,
																			   0,
																			   '0',
																			   1)";
								$this->db->setQuery($q);
								$result = $this->db->query();
								if (!$result) {
									$error =  "Error on Line " . $product_count . "<br />";
									array_push($this->error_list, $error);
									$error = $q . "<br />";
									array_push($this->error_list, $error);
									$error = $this->db->getErrorMsg();
									array_push($this->error_list, $error);
									//die('<p class="alert"><h1>Invalid Data</h1></p>');
								}
								$child = $this->db->insertid();
								$slug = "$parent_child[$i]-$child";		
								$q = "INSERT INTO `#__virtuemart_categories_$lang` 
											 (virtuemart_category_id,
											  category_name,
											  slug) 
									  VALUES ($child,
											  '$parent_child[$i]',
											  '$slug')";
								$this->db->setQuery($q);
								$result = $this->db->query();
								if (!$result) {
									$error =  "Error on Line " . $product_count . "<br />";
									array_push($this->error_list, $error);
									$error = $q . "<br />";
									array_push($this->error_list, $error);
									$error = $this->db->getErrorMsg();
									array_push($this->error_list, $error);
									//die('<p class="alert"><h1>Invalid Data</h1></p>');
								}
								$q = "INSERT INTO `#__virtuemart_category_categories`
											 (category_parent_id,
											  category_child_id)
									  VALUES ($parent,
											  $child)";
								$this->db->setQuery($q);
								$result = $this->db->query();
								if (!$result) {
									$error =  "Error on Line " . $product_count . "<br />";
									array_push($this->error_list, $error);
									$error = $q . "<br />";
									array_push($this->error_list, $error);
									$error = $this->db->getErrorMsg();
									array_push($this->error_list, $error);
									//die('<p class="alert"><h1>Invalid Data</h1></p>');
								}
								if($debug){
									echo "Inserted Child Category $child:$parent_child[$i] - Parent:$parent<br />";	
								}
								$parent = $child;
							}
						}
					}
				}else{
					//No parent exists, so insert it.
					if($debug){
						echo "** NO PARENT EXISTS<br />";	
					}
					$q = "INSERT INTO `#__virtuemart_categories` (category_layout,
																  category_product_layout,
																  products_per_row,
																  limit_list_start,
																  limit_list_step,
																  limit_list_max,
																  limit_list_initial,
																  published,
																  ordering,
																  category_template,
																  virtuemart_vendor_id)
														  VALUES ('default',
																  'default',
																   3,
																   0,
																   20,
																   0,
																   20,
																   1,
																   0,
																   '0',
																   1)";
					$this->db->setQuery($q);
					$result = $this->db->query();
					if (!$result) {
						$error =  "Error on Line " . $product_count . "<br />";
						array_push($this->error_list, $error);
						$error = $q . "<br />";
						array_push($this->error_list, $error);
						$error = $this->db->getErrorMsg();
						array_push($this->error_list, $error);
						//die('<p class="alert"><h1>Invalid Data</h1></p>');
					}
					$parent = $this->db->insertid();
					$slug = "$parent_child[0]-$child";		
					$q = "INSERT INTO `#__virtuemart_categories_$lang` 
								 (virtuemart_category_id,
								  category_name,
								  slug) 
						  VALUES ($parent,
								  '$parent_child[0]',
								  '$slug')";
					$this->db->setQuery($q);
					$result = $this->db->query();
					if (!$result) {
						$error =  "Error on Line " . $product_count . "<br />";
						array_push($this->error_list, $error);
						$error = $q . "<br />";
						array_push($this->error_list, $error);
						$error = $this->db->getErrorMsg();
						array_push($this->error_list, $error);
						//die('<p class="alert"><h1>Invalid Data</h1></p>');
					}
					$q = "INSERT INTO `#__virtuemart_category_categories`
								 (category_parent_id,
								  category_child_id)
						  VALUES (0,
								  $parent)";
					$this->db->setQuery($q);
					$result = $this->db->query();
					if (!$result) {
						$error =  "Error on Line " . $product_count . "<br />";
						array_push($this->error_list, $error);
						$error = $q . "<br />";
						array_push($this->error_list, $error);
						$error = $this->db->getErrorMsg();
						array_push($this->error_list, $error);
						//die('<p class="alert"><h1>Invalid Data</h1></p>');
					}
					if($debug){
						echo "Inserted New Parent $parent:$parent_child[0] <br />";	
					}
					$i = 1;
					for($i=1; $i<sizeof($parent_child); $i++){
						$q = "INSERT INTO `#__virtuemart_categories` (category_layout,
																	  category_product_layout,
																	  products_per_row,
																	  limit_list_start,
																	  limit_list_step,
																	  limit_list_max,
																	  limit_list_initial,
																	  published,
																	  ordering,
																	  category_template,
																	  virtuemart_vendor_id)
															  VALUES ('default',
																	  'default',
																	   3,
																	   0,
																	   20,
																	   0,
																	   20,
																	   1,
																	   0,
																	   '0',
																	   1)";
						$this->db->setQuery($q);
						$result = $this->db->query();
						if (!$result) {
							$error =  "Error on Line " . $product_count . "<br />";
							array_push($this->error_list, $error);
							$error = $q . "<br />";
							array_push($this->error_list, $error);
							$error = $this->db->getErrorMsg();
							array_push($this->error_list, $error);
							//die('<p class="alert"><h1>Invalid Data</h1></p>');
						}
						$child = $this->db->insertid();	
						$slug = "$parent_child[$i]-$child";		
						$q = "INSERT INTO `#__virtuemart_categories_$lang` 
									 (virtuemart_category_id,
									  category_name,
									  slug) 
							  VALUES ($child,
									  '$parent_child[$i]',
									  '$slug')";
						$this->db->setQuery($q);
						$result = $this->db->query();
						if (!$result) {
							$error =  "Error on Line " . $product_count . "<br />";
							array_push($this->error_list, $error);
							$error = $q . "<br />";
							array_push($this->error_list, $error);
							$error = $this->db->getErrorMsg();
							array_push($this->error_list, $error);
							//die('<p class="alert"><h1>Invalid Data</h1></p>');
						}
						$q = "INSERT INTO `#__virtuemart_category_categories`
									 (category_parent_id,
									  category_child_id)
							  VALUES ($parent,
									  $child)";
						$this->db->setQuery($q);
						$result = $this->db->query();
						if (!$result) {
							$error =  "Error on Line " . $product_count . "<br />";
							array_push($this->error_list, $error);
							$error = $q . "<br />";
							array_push($this->error_list, $error);
							$error = $this->db->getErrorMsg();
							array_push($this->error_list, $error);
							//die('<p class="alert"><h1>Invalid Data</h1></p>');
						}
						if($debug){
							echo "Inserting Children $child:$parent_child[$i] - Parent:$parent<br />";	
						}
						$parent = $child;
					}
				}
				
				//Assign the Product to the Category Here
				$q = "INSERT INTO `#__virtuemart_product_categories`
							 (virtuemart_product_id,
							  virtuemart_category_id)
					  VALUES ($virtuemart_product_id,
							  $parent)";
				$this->db->setQuery($q);
				$result = $this->db->query();
				if (!$result) {
					$error =  "Error on Line " . $product_count . "<br />";
					array_push($this->error_list, $error);
					$error = $q . "<br />";
					array_push($this->error_list, $error);
					$error = $this->db->getErrorMsg();
					array_push($this->error_list, $error);
					//die('<p class="alert"><h1>Invalid Data</h1></p>');
				}
				if($debug){
					echo "Inserting Product Category $virtuemart_product_id:$parent<br />";	
				}
			}
	}
			//Insert Manufacturer
			$q = "SELECT virtuemart_manufacturer_id FROM `#__virtuemart_manufacturers_$lang` WHERE mf_name = '".$theData[$this->mf_name]."'";
			$this->db->setQuery($q);
			if($result = $this->db->loadResult()){
				$virtuemart_manufacturer_id = $result;			
			} else {
				$q = "INSERT INTO `#__virtuemart_manufacturers` (hits) VALUES (0)";
				$this->db->setQuery($q);
				$this->db->query();
				$virtuemart_manufacturer_id = $this->db->insertid();	
				$slug = $theData[$this->mf_name]. "-$virtuemart_manufacturer_id";					
				$q = "INSERT INTO `#__virtuemart_manufacturers_$lang` (virtuemart_manufacturer_id,
																	   mf_name,
																	   slug) 
															   VALUES ($virtuemart_manufacturer_id,
															   		   '".$theData[$this->mf_name]."',
																	   '$slug')";
				$this->db->setQuery($q);
				$this->db->query();
			}
			$q = "INSERT INTO `#__virtuemart_product_manufacturers` 
							(virtuemart_manufacturer_id,
							 virtuemart_product_id)
					VALUES ($virtuemart_manufacturer_id,
							$virtuemart_product_id)";
			$this->db->setQuery($q);
			$result = $this->db->query();
			if (!$result) {
				$error =  "Error on Line " . $product_count . "<br />";
				array_push($this->error_list, $error);
				$error = $q . "<br />";
				array_push($this->error_list, $error);
				$error = $this->db->getErrorMsg();
				array_push($this->error_list, $error);
				//die('<p class="alert"><h1>Invalid Data</h1></p>');
			}

			//Related Products - Just build the reference for now, then process after complete file has been read
			if ($theData[$this->related_products] != ""){
				$related_product_list = explode(";",$theData[$this->related_products]);
				foreach ($related_product_list as $value){
					array_push($related_list,$value);
				}
				$master_related_list[$virtuemart_product_id] = $related_list;
			}
			
			if ($theData[$this->variant_type] != ""){
				if($theData[$this->product_sku] != $theData[$this->product_parent_sku]){
					$q = "SELECT virtuemart_custom_id FROM `#__virtuemart_customs` 
					      WHERE field_type = 'A' AND 
						  custom_title = '".$theData[$this->variant_type]."'";
					$this->db->setQuery($q);
					if($result = $this->db->loadResult()){
						$virtuemart_custom_id = $result;	
						$q = "UPDATE `#__virtuemart_customs` SET field_type='A' WHERE virtuemart_custom_id=$virtuemart_custom_id";
						$this->db->setQuery($q);
						$result = $this->db->query();
						if (!$result) {
							$error =  "Error on Line " . $product_count . "<br />";
							array_push($this->error_list, $error);
							$error = $q . "<br />";
							array_push($this->error_list, $error);
							$error = $this->db->getErrorMsg();
							array_push($this->error_list, $error);
							//die('<p class="alert"><h1>Invalid Data</h1></p>');
						}
					} else {
						$q = "INSERT INTO `#__virtuemart_customs` (custom_title, field_type) 
									   VALUES ('".$theData[$this->variant_type]."', 'A')";
						$this->db->setQuery($q);
						$result = $this->db->query();
						if (!$result) {
							$error =  "Error on Line " . $product_count . "<br />";
							array_push($this->error_list, $error);
							$error = $q . "<br />";
							array_push($this->error_list, $error);
							$error = $this->db->getErrorMsg();
							array_push($this->error_list, $error);
							//die('<p class="alert"><h1>Invalid Data</h1></p>');
						}
						$virtuemart_custom_id = $this->db->insertid();						
					}
					
					// only do this once per parent
					$q = "SELECT virtuemart_customfield_id FROM `#__virtuemart_product_customfields`
					      WHERE virtuemart_product_id = $parent_id AND
						        custom_value = 'product_name' AND 
						        virtuemart_custom_id = $virtuemart_custom_id";
					$this->db->setQuery($q);
					if(!$result = $this->db->loadResult()){
						$q = "INSERT INTO `#__virtuemart_product_customfields` (virtuemart_product_id,
																				custom_value,
																				virtuemart_custom_id)
																		VALUES ($parent_id,
																				'product_name',
																				$virtuemart_custom_id)";
						$this->db->setQuery($q);
						$result = $this->db->query();
						if (!$result) {
							$error =  "Error on Line " . $product_count . "<br />";
							array_push($this->error_list, $error);
							$error = $q . "<br />";
							array_push($this->error_list, $error);
							$error = $this->db->getErrorMsg();
							array_push($this->error_list, $error);
							//die('<p class="alert"><h1>Invalid Data</h1></p>');
						}
					}
				}
			}
		}
		
		$related = "";
		foreach ($master_related_list as $key => $value){
			foreach ($value as $value2){
				$q = "SELECT virtuemart_product_id FROM `#__virtuemart_products` WHERE product_sku = '$value2'";
				$this->db->setQuery($q);
				if($result = $this->db->loadResult()){		
					$q = "INSERT INTO `#__virtuemart_product_customfields` (virtuemart_product_id,
																			virtuemart_custom_id,
																			custom_value)
																	VALUES ($key,1,'$result')";
					$this->db->setQuery($q);
					$result = $this->db->query();
					if (!$result) {
						$error =  "Error on Line " . $product_count . "<br />";
						array_push($this->error_list, $error);
						$error = $q . "<br />";
						array_push($this->error_list, $error);
						$error = $this->db->getErrorMsg();
						array_push($this->error_list, $error);
						//die('<p class="alert"><h1>Invalid Data</h1></p>');
					}
				}
			}
		}
		
		$html_code = '<div class="import-summary"><h1 style="text-align:center">Import Summary</h1>
					  <div style="font-size:18px; width:400px; margin-left:auto; margin-right:auto;">'.$product_count.' Products Imported
					  </div></div>';

		if (sizeof($this->error_list) > 0){
			$html_code .= '<div><h1 style="text-align:center">Error List</h1>';
			foreach ($this->error_list as $value){
				$html_code .= $value;
			}
			$html_code .= '</div>';
		}
							  
		echo $html_code;
		

}  //End of Display Function
	
//Function for Parent	
function CreateParent($Data, $product_count){
	
		$params = JComponentHelper::getParams('com_languages');
		$lang = $params->get('site', 'en-GB');//use default joomla
		$lang = strtolower(strtr($lang,'-','_'));
	
			if ($Data[$this->product_id] == ""){
				$insert = 1;
				$q = "INSERT INTO `#__virtuemart_products` (product_parent_id,
															   product_sku,
															   product_weight,
															   product_weight_uom,
															   product_length,
															   product_width,
															   product_height,
															   product_lwh_uom,
															   product_special,
															   product_in_stock,
															   low_stock_notification,
															   product_params,
															   published) 
													   VALUES (0,
															   '".$Data[$this->product_parent_sku]."',
															   ".$Data[$this->product_weight].",
															   '".$Data[$this->product_weight_uom]."',
															   ".$Data[$this->product_length].",
															   ".$Data[$this->product_width].",
															   ".$Data[$this->product_height].",
															   '".$Data[$this->product_lwh_uom]."',
															   '".$Data[$this->product_special]."',
															   0,
															   0,
															   'min_order_level=d:0;|max_order_level=d:0;|',
															   1)";
			} else {
				$insert = 0;
				$q = "UPDATE `#__virtuemart_products` SET
						product_sku = '".$Data[$this->product_parent_sku]."',
						product_weight = ".$Data[$this->product_weight].",
						product_weight_uom = '".$Data[$this->product_weight_uom]."',
						product_length = ".$Data[$this->product_length].",
						product_width = ".$Data[$this->product_width].",
						product_height = ".$Data[$this->product_height].",
						product_lwh_uom = '".$Data[$this->product_lwh_uom]."',
						product_special = '".$Data[$this->product_special]."'
					 WHERE
						product_id = ".$Data[$product_id];
			}
			
			//need to check if the query fails or not...  product_id may not exist even if it's listed in the csv file
			$this->db->setQuery($q);
			$result = $this->db->query();
			if (!$result) {
				$error =  "Error on Line " . $product_count . " - Creating Parent<br />";
				array_push($this->error_list, $error);
				$error = $q . "<br />";
				array_push($this->error_list, $error);
				$error = $this->db->getErrorMsg();
				array_push($this->error_list, $error);
				//die('<p class="alert"><h1>Invalid Data</h1></p>');
			}
			
			if ($insert){
				$virtuemart_product_id = $this->db->insertid; //mysqli_insert_id();	
			}else{
				$virtuemart_product_id = $Data[$this->product_id];		
			}
			
			$q = "INSERT INTO `#__virtuemart_products_$lang` (virtuemart_product_id,
																 product_s_desc,
																 product_desc,
																 product_name,
																 metadesc,
																 metakey,
																 customtitle,
																 slug)
														 VALUES ($virtuemart_product_id,
																 '".$Data[$this->product_s_desc]."',
																 '".$Data[$this->product_desc]."',
																 '".$Data[$this->product_name]."',
																 '".$Data[$this->metadesc]."',
																 '".$Data[$this->metakey]."',
																 '".$Data[$this->customtitle]."',
																 '".$Data[$this->product_parent_sku]."')";	
			$this->db->setQuery($q);
			$result = $this->db->query();
			if (!$result) {
				$error =  "Error on Line " . $product_count . " - Creating Parent<br />";
				echo $error;
				array_push($this->error_list, $error);
				$error = $q . "<br />";
				echo $error;
				array_push($this->error_list, $error);
				$error = $this->db->getErrorMsg();
				echo $error;
				array_push($this->error_list, $error);
				//die('<p class="alert"><h1>Invalid Data</h1></p>');
			}
			
			$q = "INSERT INTO `#__virtuemart_medias`
								(file_description,
								 file_url,
								 file_url_thumb,
								 file_title,
								 file_meta,
								 file_type,
								 file_mimetype)
						 VALUES ('".$Data[$this->product_s_desc]."',
								 '".$Data[$this->file_url]."',
								 '".$Data[$this->file_url_thumb]."',
								 '".$Data[$this->product_name]."',
								 '".$Data[$this->product_s_desc]."',
								 'product',
								 'image/jpeg')";
			$this->db->setQuery($q);
			$result = $this->db->query();
			if (!$result) {
				$error =  "Error on Line " . $product_count . "<br />";
				array_push($this->error_list, $error);
				$error = $q . "<br />";
				//echo $q . "<br />";
				array_push($this->error_list, $error);
				$error = $this->db->getErrorMsg();
				array_push($this->error_list, $error);
				//die('<p class="alert"><h1>Invalid Data</h1></p>');
			}								 
			$virtuemart_media_id = $this->db->insertid();			
			$q = "INSERT INTO `#__virtuemart_product_medias`
								(virtuemart_product_id,
								 virtuemart_media_id)
						 VALUES ($virtuemart_product_id,
								 $virtuemart_media_id)";
			$this->db->setQuery($q);
			$result = $this->db->query();
			if (!$result) {
				$error =  "Error on Line " . $product_count . "<br />";
				array_push($this->error_list, $error);
				$error = $q . "<br />";
				array_push($this->error_list, $error);
				$error = $this->db->getErrorMsg();
				array_push($this->error_list, $error);
				//die('<p class="alert"><h1>Invalid Data</h1></p>');
			}								 
			
			
			
			
			
			$q = "INSERT INTO `#__virtuemart_product_prices` (virtuemart_product_id,
																 product_price)
														 VALUES ($virtuemart_product_id,
																 ".$Data[$this->product_price].")";
			$this->db->setQuery($q);
			$result = $this->db->query();
			if (!$result) {
				$error =  "Error on Line " . $product_count . " - Creating Parent<br />";
				array_push($this->error_list, $error);
				$error = $q . "<br />";
				array_push($this->error_list, $error);
				$error = $this->db->getErrorMsg() . "<br />";
				array_push($this->error_list, $error);
				//die('<p class="alert"><h1>Invalid Data</h1></p>');
			}
			
			$categories = explode(";", $Data[$this->category_name]);
			foreach ($categories as $value){
				$parent_child = explode("/", $value);
				$next = 0;
				$category_parent_id = 0;
				
				//Check for existing parent.. We don't want parents with the same name. Nor children of same parent w same name.
				$q = "SELECT virtuemart_category_id FROM `#__virtuemart_categories_$lang` WHERE category_name = '$parent_child[0]'";
				$this->db->setQuery($q);
				if($result = $this->db->loadResult()){
					//A parent with this name alrady exists.  So Now Check the childs name.
					$parent = $result;
					if(sizeof($parent_child) > 1){
						$i = 1;
						for($i=1; $i<sizeof($parent_child); $i++){
							$q = "SELECT x.category_child_id FROM `#__virtuemart_category_categories` as x
								  JOIN `#__virtuemart_categories_$lang` as c ON c.virtuemart_category_id = x.category_child_id
								  WHERE x.category_parent_id = $parent AND c.category_name = '$parent_child[$i]'";
							$this->db->setQuery($q);
							if($result = $this->db->loadResult()){
								$parent = $result;				
							}else{
								$q = "INSERT INTO `#__virtuemart_categories` (category_layout,
																			  category_product_layout,
																			  products_per_row,
																			  limit_list_start,
																			  limit_list_step,
																			  limit_list_max,
																			  limit_list_initial,
																			  published,
																			  ordering,
																			  category_template,
																			  virtuemart_vendor_id)
																	  VALUES ('default',
																	  		  'default',
																			   3,
																			   0,
																			   20,
																			   0,
																			   20,
																			   1,
																			   0,
																			   '0',
																			   1)";
								$this->db->setQuery($q);
								$result = $this->db->query();
								if (!$result) {
									$error =  "Error on Line " . $product_count . " - Creating Parent<br />";
									array_push($this->error_list, $error);
									$error = $q . "<br />";
									array_push($this->error_list, $error);
									$error = $this->db->getErrorMsg();
									array_push($this->error_list, $error);
									//die('<p class="alert"><h1>Invalid Data</h1></p>');
								}
								$child = $this->db->insertid();		
								$slug = "$parent_child[$i]-$child";		
								$q = "INSERT INTO `#__virtuemart_categories_$lang` 
											 (virtuemart_category_id,
											  category_name,
											  slug) 
									  VALUES ($child,
											  '$parent_child[$i]',
											  '$slug')";
								$this->db->setQuery($q);
								$result = $this->db->query();
								if (!$result) {
									$error =  "Error on Line " . $product_count . " - Creating Parent<br />";
									array_push($this->error_list, $error);
									$error = $q . "<br />";
									array_push($this->error_list, $error);
									$error = $this->db->getErrorMsg();
									array_push($this->error_list, $error);
									//die('<p class="alert"><h1>Invalid Data</h1></p>');
								}
								$q = "INSERT INTO `#__virtuemart_category_categories`
											 (category_parent_id,
											  category_child_id)
									  VALUES ($parent,
											  $child)";
								$this->db->setQuery($q);
								$result = $this->db->query();
								if (!$result) {
									$error =  "Error on Line " . $product_count . " - Creating Parent<br />";
									array_push($this->error_list, $error);
									$error = $q . "<br />";
									array_push($this->error_list, $error);
									$error = $this->db->getErrorMsg();
									array_push($this->error_list, $error);
									//die('<p class="alert"><h1>Invalid Data</h1></p>');
								}
								$parent = $child;
							}
						}
					}
				}else{
					//No parent exists, so insert it.
					$q = "INSERT INTO `#__virtuemart_categories` (category_layout,
																  category_product_layout,
																  products_per_row,
																  limit_list_start,
																  limit_list_step,
																  limit_list_max,
																  limit_list_initial,
																  published,
																  ordering,
																  category_template,
																  virtuemart_vendor_id)
														  VALUES ('default',
																  'default',
																   3,
																   0,
																   20,
																   0,
																   20,
																   1,
																   0,
																   '0',
																   1)";
						
					$this->db->setQuery($q);
					$result = $this->db->query();
					if (!$result) {
						$error =  "Error on Line " . $product_count . " - Creating Parent<br />";
						array_push($this->error_list, $error);
						$error = $q . "<br />";
						array_push($this->error_list, $error);
						$error = $this->db->getErrorMsg();
						array_push($this->error_list, $error);
						//die('<p class="alert"><h1>Invalid Data</h1></p>');
					}
					$parent = $this->db->insertid();						
					$slug = "$parent_child[0]-$child";		
					$q = "INSERT INTO `#__virtuemart_categories_$lang` 
								 (virtuemart_category_id,
								  category_name,
								  slug) 
						  VALUES ($parent,
								  '$parent_child[0]',
								  '$slug')";
					$this->db->setQuery($q);
					$result = $this->db->query();
					if (!$result) {
						$error =  "Error on Line " . $product_count . " - Creating Parent<br />";
						array_push($this->error_list, $error);
						$error = $q . "<br />";
						array_push($this->error_list, $error);
						$error = $this->db->getErrorMsg();
						array_push($this->error_list, $error);
						//die('<p class="alert"><h1>Invalid Data</h1></p>');
					}
					$q = "INSERT INTO `#__virtuemart_category_categories`
								 (category_parent_id,
								  category_child_id)
						  VALUES (0,
								  $parent)";
					$this->db->setQuery($q);
					$result = $this->db->query();
					if (!$result) {
						$error =  "Error on Line " . $product_count . " - Creating Parent<br />";
						array_push($this->error_list, $error);
						$error = $q . "<br />";
						array_push($this->error_list, $error);
						$error = $this->db->getErrorMsg();
						array_push($this->error_list, $error);
						//die('<p class="alert"><h1>Invalid Data</h1></p>');
					}

					$i = 1;
					for($i=1; $i<sizeof($parent_child); $i++){
						$q = "INSERT INTO `#__virtuemart_categories` (category_layout,
																	  category_product_layout,
																	  products_per_row,
																	  limit_list_start,
																	  limit_list_step,
																	  limit_list_max,
																	  limit_list_initial,
																	  published,
																	  ordering,
																	  category_template,
																	  virtuemart_vendor_id)
															  VALUES ('default',
																	  'default',
																	   3,
																	   0,
																	   20,
																	   0,
																	   20,
																	   1,
																	   0,
																	   '0',
																	   1)";
						$this->db->setQuery($q);
						$result = $this->db->query();
						if (!$result) {
							$error =  "Error on Line " . $product_count . " - Creating Parent<br />";
							array_push($this->error_list, $error);
							$error = $q . "<br />";
							array_push($this->error_list, $error);
							$error = $this->db->getErrorMsg();
							array_push($this->error_list, $error);
							//die('<p class="alert"><h1>Invalid Data</h1></p>');
						}
						$child = $this->db->insertid();
						$slug = "$parent_child[$i]-$child";		
						$q = "INSERT INTO `#__virtuemart_categories_$lang` 
									 (virtuemart_category_id,
									  category_name,
									  slug) 
							  VALUES ($child,
									  '$parent_child[$i]',
									  '$slug')";
						$this->db->setQuery($q);
						$result = $this->db->query();
						if (!$result) {
							$error =  "Error on Line " . $product_count . " - Creating Parent<br />";
							array_push($this->error_list, $error);
							$error = $q . "<br />";
							array_push($this->error_list, $error);
							$error = $this->db->getErrorMsg();
							array_push($this->error_list, $error);
							//die('<p class="alert"><h1>Invalid Data</h1></p>');
						}
						$q = "INSERT INTO `#__virtuemart_category_categories`
									 (category_parent_id,
									  category_child_id)
							  VALUES ($parent,
									  $child)";
						$this->db->setQuery($q);
						$result = $this->db->query();
						if (!$result) {
							$error =  "Error on Line " . $product_count . " - Creating Parent<br />";
							array_push($this->error_list, $error);
							$error = $q . "<br />";
							array_push($this->error_list, $error);
							$error = $this->db->getErrorMsg();
							array_push($this->error_list, $error);
							//die('<p class="alert"><h1>Invalid Data</h1></p>');
						}
						$parent = $child;
					}
				}
				
				//Assign the Product to the Category Here
				$q = "INSERT INTO `#__virtuemart_product_categories`
							 (virtuemart_product_id,
							  virtuemart_category_id)
					  VALUES ($virtuemart_product_id,
							  $parent)";
				$this->db->setQuery($q);
				$result = $this->db->query();
				if (!$result) {
					$error =  "Error on Line " . $product_count . " - Creating Parent<br />";
					array_push($this->error_list, $error);
					$error = $q . "<br />";
					array_push($this->error_list, $error);
					$error = $this->db->getErrorMsg();
					array_push($this->error_list, $error);
					//die('<p class="alert"><h1>Invalid Data</h1></p>');
				}
			}
		
			//Insert Manufacturer
			$q = "SELECT virtuemart_manufacturer_id FROM `#__virtuemart_manufacturers_$lang` WHERE mf_name = '".$Data[$this->mf_name]."'";
			$this->db->setQuery($q);
			if($result = $this->db->loadResult()){
				$virtuemart_manufacturer_id = $result;			
			} else {
				$q = "INSERT INTO `#__virtuemart_manufacturers` (hits) VALUES (0)";
				$this->db->setQuery($q);
				$this->db->query();
				$virtuemart_manufacturer_id = $this->db->insertid();
				$slug = $Data[$this->mf_name]. "-$virtuemart_manufacturer_id";					
				$q = "INSERT INTO `#__virtuemart_manufacturers_$lang` (virtuemart_manufacturer_id,
																	   mf_name,
																	   slug) 
															   VALUES ($virtuemart_manufacturer_id,
															   		   '".$Data[$this->mf_name]."',
																	   '$slug')";
				$this->db->setQuery($q);
				$result = $this->db->query();
				if (!$result) {
					$error =  "Error on Line " . $product_count . " - Creating Parent<br />";
					array_push($this->error_list, $error);
					$error = $q . "<br />";
					array_push($this->error_list, $error);
					$error = $this->db->getErrorMsg();
					array_push($this->error_list, $error);
					//die('<p class="alert"><h1>Invalid Data</h1></p>');
				}
			}
			$q = "INSERT INTO `#__virtuemart_product_manufacturers` 
							(virtuemart_manufacturer_id,
							 virtuemart_product_id)
					VALUES ($virtuemart_manufacturer_id,
							$virtuemart_product_id)";
			$this->db->setQuery($q);
			$result = $this->db->query();
			if (!$result) {
				$error =  "Error on Line " . $product_count . " - Creating Parent<br />";
				array_push($this->error_list, $error);
				$error = $q . "<br />";
				array_push($this->error_list, $error);
				$error = $this->db->getErrorMsg();
				array_push($this->error_list, $error);
				//die('<p class="alert"><h1>Invalid Data</h1></p>');
			}
		
			//Related Products - Just build the reference for now, then process after complete file has been read
			if ($Data[$this->related_products] != ""){
				$related_product_list = explode(";",$Data[$this->related_products]);
				$related_list = array();
				foreach ($related_product_list as $value){
					array_push($related_list,$value);
				}
				global $master_related_list;
				$master_related_list[$virtuemart_product_id] = $related_list;
			}
/*			
			if ($Data[$this->variant_type] != ""){
				$q = "SELECT virtuemart_custom_id FROM `#__virtuemart_customs` WHERE custom_title = '".$Data[$this->variant_type]."'";
				$this->db->setQuery($q);
				if (!$result = $this->db->loadResult()){				
					$q = "INSERT INTO `#__virtuemart_customs` (custom_title, field_type) 
													   VALUES ('".$Data[$this->variant_type]."', 'A')";
					$this->db->setQuery($q);
					$this->db->query();
				}
			}
*/
			return $virtuemart_product_id;	
		}
}
