<?php

class Sync extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function clean_db() 
	{
		$this->load->model( 'maintenance_model' );
		$this->maintenance_model->clean_db();
		echo 'Done';
	}	
	
	public function clientes_mdate() 
	{
		$this->load->model( 'customer_model' );
		echo json_encode( array( "mdate" => $this->customer_model->get_max_mdate() ) );
	}
	
	public function artigos_mdate() 
	{
		$this->load->model( 'product_model' );
		echo json_encode( array( "mdate" => $this->product_model->get_max_mdate() ) );
	}
	
	public function encomendas_mdate() 
	{
		$this->load->model( 'order_model' );
		echo json_encode( array( "mdate" => $this->order_model->get_max_mdate() ) );
	}
	
	public function familias_mdate() 
	{
		$this->load->model( 'category_model' );
		echo json_encode( array( "mdate" => $this->category_model->get_max_mdate() ) );
	}
	
	public function WriteLog($message)
	{
		$f = fopen("MyLog.txt", "a");
		fwrite($f, date("Y-m-d H:i:s") . " - " . print_r($message,true) . "\n");
		fclose($f);
	}
	
	public function get_encomenda() 
	{
		$errors = 0;
		$last_order = json_decode( stripcslashes( $_POST['data'] ) );
		$this->load->model( 'order_model' );
		$encomendas = $this->order_model->get( $last_order );

		echo json_encode( $encomendas );
	}
	
	public function estadoencomenda() 
	{
		$errors = 0;
		$orders = json_decode( stripcslashes( $_POST['data'] ) );
		$this->load->model( 'order_model' );

		foreach ( $orders as $order ) 
		{
			$ord = $this->order_model->get_order( $order->obrano );
			
			$ord->fields['order_status'] = $this->order_model->getorderstatus( $order->estado );
			$ord->fields['modified_on'] = $order->datamodificacao;
			
			if ( !$ord->save() ) 
			{
				$this->WriteLog( "Falhou Atualizar Estado Encomenda - " . $order->obrano );
				$errors++;
			}
		}

		if ( $errors > 0 ) 
		{
			$response = array( "success" => false );
		} 
		else 
		{
			$response = array( "success" => true );
		}

		echo json_encode( $response );
	}
	
	public function clientes() 
	{
		$errors = 0;
		$customers = json_decode( stripcslashes( $_POST['data'] ) );
		$this->load->model( 'customer_model' );

		foreach ( $customers as $customer ) 
		{
			$cust = $this->customer_model->get( $customer->no );

			if ( $cust->exists == 0) //TRATA-SE DE UM NOVO UTILIZADOR
			{
				$cust = new $this->customer_model();
			} 
			
			//tabela users
			$cust->jFields['name'] = $customer->name;
			$cust->jFields['username'] = $customer->username;
			$cust->jFields['email'] = $customer->email;
			$cust->jFields['password'] = $this->customer_model->criar_password(trim($customer->password));
			$cust->jFields['usertype'] = 'deprecated';
			$cust->jFields['block'] = 0;
			$cust->jFields['sendEmail'] = 1;
			$cust->jFields['registerDate'] = $customer->cdate;
			$cust->jFields['activation'] = 0;
			$cust->jFields['params'] = '{}';
			$cust->jFields['lastResetTime'] = '0000-00-00 00:00:00';
			$cust->jFields['resetCount'] = 0;
			$cust->jFields['phc_no'] = $customer->no;
			
			//tabela vmusers
			$cust->fields['virtuemart_vendor_id'] = 0;
			$cust->fields['user_is_vendor'] = 0;
			$cust->fields['perms'] = 'shopper';
			$cust->fields['virtuemart_paymentmethod_id'] = 0;
			$cust->fields['virtuemart_shipmentmethod_id'] = 0;
			$cust->fields['agreed'] = 0;
			$cust->fields['created_on'] = $customer->cdate;
			$cust->fields['created_by'] = 0;
			$cust->fields['modified_on'] = $customer->mdate;
			$cust->fields['modified_by'] = 0;
			$cust->fields['locked_on'] = '0000-00-00 00:00:00';
			$cust->fields['locked_by'] = 0;
			
			//tabela userinfos
			$cust->fields2['address_type'] = 'BT';
			$cust->fields2['address_type_name'] = '';
			$cust->fields2['name'] = $customer->name;
			$cust->fields2['company'] = $customer->name;
			$cust->fields2['title'] = 'Mr';
			$cust->fields2['last_name'] = '';
			$cust->fields2['first_name'] = $customer->name;
			$cust->fields2['middle_name'] = '';
			$cust->fields2['phone_1'] = $customer->phone;
			$cust->fields2['phone_2'] = '';
			$cust->fields2['fax'] = $customer->fax;
			$cust->fields2['address_1'] = $customer->address;
			$cust->fields2['address_2'] = '';
			$cust->fields2['city'] = $customer->city;
			$cust->fields2['virtuemart_state_id'] = 0;
			
			$cust->fields2['virtuemart_country_id'] = $cust->getcountry($customer->country);

			//$cust->fields2['virtuemart_country_id'] = 171;	//Portugal 
			
			$cust->fields2['zip'] = $customer->zip;
			$cust->fields2['agreed'] = 0;
			$cust->fields2['created_on'] = $customer->cdate;
			$cust->fields2['created_by'] = 0;
			$cust->fields2['modified_on'] = $customer->mdate;
			$cust->fields2['modified_by'] = 0;
			$cust->fields2['locked_on'] = '0000-00-00 00:00:00';
			$cust->fields2['locked_by'] = 0;
			
			//tabela vmusers_shoppergroups
			$cust->fields3['virtuemart_shoppergroup_id'] = $customer->shoppergroup;
			
			//tabela user_usergroups_map
			$cust->fields4['group_id'] = 2;
			
			if ( $cust->exists == 1 ) 
			{
				if( !$customer->locked ) //para apagar
				{
					if ( !$cust->delete() ) 
					{
						$this->WriteLog( "Falhou Apagar Utilizador - " . $customer->no );
						$errors++;
					}
				}
				else //update
				{
					if ( !$cust->save() ) 
					{
						$this->WriteLog( "Falhou Gravar Update Utilizador - " . $customer->no );
						$errors++;
					}
				}
			} 
			else //TRATA-SE DE UM NOVO UTILIZADOR
			{ 
				if( $customer->locked )
				{
					if ( !$cust->save(true) ) 
					{
						$this->WriteLog( "Falhou Gravar Novo Utilizador - " . $customer->no );
						$errors++;
					}
				}
			}
		}

		if ( $errors > 0 ) 
		{
			$response = array( "success" => false );
		} 
		else 
		{
			$response = array( "success" => true );
		}

		echo json_encode( $response );
	}
	
	function generateRandomString($length = 10) 
	{
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) 
		{
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	
	public function slugify( $text )
	{ 
		// replace non letter or digits by -
		$text = preg_replace('~[^\\pL\d]+~u', '-', $text);

		// trim
		$text = trim($text, '-');

		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		// lowercase
		$text = strtolower($text);

		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

		if (empty($text))
		{
		return 'n-a';
		}

		return $text;
	}
	
	public function familias() 
	{
		$errors = 0;
	
		$categories = json_decode( stripcslashes( $_POST['data'] ) );
		
		$this->load->model( 'category_model' );	
		
		foreach ( $categories as $category ) 
		{
			$cat = $this->category_model->get( $category->ref );

			if ( $cat->exists == 0) //TRATA-SE DE UMA NOVA FAMILIA
			{
				$cat = new $this->category_model();
			}
			
			//tabela virtuemart_categories
			$cat->fields['virtuemart_vendor_id'] = 1;
			$cat->fields['category_template'] = 0;
			$cat->fields['category_layout'] = 0;
			$cat->fields['category_product_layout'] = 0;
			$cat->fields['products_per_row'] = 0;
			$cat->fields['limit_list_step'] = 0;
			$cat->fields['limit_list_initial'] = 0;
			$cat->fields['hits'] = 0;
			$cat->fields['metarobot'] = '';
			$cat->fields['metaauthor'] = '';
			$cat->fields['ordering'] = 0;
			$cat->fields['shared'] = 0;
			$cat->fields['published'] = $category->u_pubfami;
			$cat->fields['created_on'] = '0000-00-00 00:00:00';
			$cat->fields['created_by'] = 0;
			$cat->fields['modified_on'] = $category->usrdata;
			$cat->fields['modified_by'] = 0;
			$cat->fields['locked_on'] = '0000-00-00 00:00:00';
			$cat->fields['locked_by'] = 0;
			$cat->fields['phc_ref'] = $category->ref;
			
			//tabela virtuemart_categories_pt_pt
			$cat->fields2['category_name'] = $category->name;
			$cat->fields2['category_description'] = '';
			$cat->fields2['metadesc'] = '';
			$cat->fields2['metakey'] = '';
			$cat->fields2['customtitle'] = '';
			
			//tabela virtuemart_categories_en_gb
			$cat->fields6['category_name'] = $category->design2;
			$cat->fields6['category_description'] = '';
			$cat->fields6['metadesc'] = '';
			$cat->fields6['metakey'] = '';
			$cat->fields6['customtitle'] = '';
			
			if ( $cat->exists == 1 ) 
			{
				if ( !$cat->save() ) 
				{
					$this->WriteLog( "Falhou Gravar Update Familia - " . $category->ref );
					$errors++;
				}
				else
				{
					$cat->attach_media(strtolower($category->u_logofami));
				}
			} 
			else //TRATA-SE DE UMA NOVA FAMILIA
			{ 
				$cat->fields2['slug'] = $this->slugify( $category->ref . '_' . $category->name );
				$cat->fields6['slug'] = $this->slugify( $category->ref . '_' . $category->name );
				
				if ( !$cat->save(true) ) 
				{
					$this->WriteLog( "Falhou Gravar Nova Familia - " . $category->ref );
					$errors++;
				}
				else
				{
					$cat->attach_media(strtolower($category->u_logofami));
				}
			}			
		}
		
		if ( $errors > 0 ) 
		{
			$response = array( "success" => false );
		} 
		else 
		{
			$response = array( "success" => true );
		}

		echo json_encode( $response );
	}
	
	public function familiasrel() 
	{
		$errors = 0;
		
		$categories = json_decode( stripcslashes( $_POST['data'] ) );
		
		$this->load->model( 'category_model' );
		
		//atribuir relacoes entre familias
		foreach ( $categories as $category ) 
		{
			$par_id = $this->category_model->get_id_by_ref( $category->famipai, $category->ref );
			$cat = $this->category_model->get( $category->ref );
			if ( $cat->exists == 1 ) 
			{
				//tabela virtuemart_category_categories
				$cat->fields3['category_parent_id'] = $par_id;
				$cat->fields3['category_child_id'] = $cat->fields["virtuemart_category_id"];
				$cat->fields3['ordering'] = 0;
				
				if ( !$cat->save_relations() ) 
				{
					$this->WriteLog( "Falhou Gravar Relacao Familia - " . $cat->fields["virtuemart_category_id"] );
					$errors++;
				}
			}
		}
		
		if ( $errors > 0 ) 
		{
			$response = array( "success" => false );
		} 
		else 
		{
			$response = array( "success" => true );
		}

		echo json_encode( $response );
	}
	
	public function artigos() 
	{
		$errors = 0;
		$products = json_decode( stripcslashes( $_POST['data'] ) );
		$this->load->model( 'product_model' );
		$this->load->model( 'category_model' );


		if( count($products) ) {
    		foreach ( $products as $product ) 
    		{
    
                
    			$prod = $this->product_model->get( $product->ref );
    
    			if ( $prod->exists == 0) //TRATA-SE DE UM NOVO ARTIGO
    			{
    				$prod = new $this->product_model();
    			}
    			
    			//tabela virtuemart_categories
    			$prod->fields['product_sku'] = $product->ref;
    			$prod->fields['product_sku_for'] = $product->ref_for;
    			$prod->fields['virtuemart_vendor_id'] = 1;
    			$prod->fields['product_parent_id'] = 0;
    			$prod->fields['product_in_stock'] = $product->stock;
    			$prod->fields['low_stock_notification'] = $product->stock_min;
    			$prod->fields['baixr'] = $product->baixr;
    			$prod->fields['product_weight'] = $product->pbruto;
    			$prod->fields['product_weight_uom'] = "G";
                if ($product->inactivo === '0') {
                    $prod->fields['published'] = $product->u_pubsite;
                } else {
                    $prod->fields['published'] = '0';
                }
    			$prod->fields['created_on'] = $product->ousrdata;
    			$prod->fields['created_by'] = 0;
    			$prod->fields['modified_on'] = substr($product->usrdata, 0, 10) . " " . $product->usrhora;
                //error_log($prod->fields['modified_on']);
                $prod->fields['modified_by'] = 0;
    			$prod->fields['locked_on'] = '0000-00-00 00:00:00';
    			$prod->fields['locked_by'] = 0;
    			
    			$prod->fields['iva1incl'] = $product->epv1_ivaincl;
    			$prod->fields['iva2incl'] = $product->epv2_ivaincl;
    			$prod->fields['iva3incl'] = $product->epv3_ivaincl;
    			$prod->fields['iva4incl'] = $product->epv4_ivaincl;
    			$prod->fields['iva5incl'] = $product->epv5_ivaincl;
    			$prod->fields['marca'] = $product->marca;
    			$prod->fields['modelo'] = $product->modelo;
    			$prod->fields['product_unit'] = $product->unidade;
    			$prod->fields['ref_alternativa'] = $product->ref_alternativa;
    			
    			$prod->fields['url1'] = $product->url;
    			$prod->fields['url2'] = $product->sup_tec;
    			$prod->fields['url3'] = $product->montagem;
    			$prod->fields['url4'] = $product->fabricante;
    			
    			$image_source = "images/stories/virtuemart/product/";
    			
    			//pt-pt
                $prod->fields2['product_s_desc'] = $product->design;
    			$prod->fields2['product_desc'] = $product->u_descst;
    			if(trim($product->u_imgdctec) != '')
    			{
                    switch (strtolower( pathinfo($product->u_imgdctec, PATHINFO_EXTENSION) )) {
                        case "gif":
                        case "jpg":
                        case "jpeg":
                        case "png":
                            $prod->fields2['product_desc'] .= "<img class=\"imgtec\" src='/".$image_source.trim(strtolower($product->u_imgdctec))."' />";
                        break;
                        case "pdf":
                            $prod->fields2['product_desc'] .=
                                //'<object data="'.$image_source.trim(strtolower($product->u_imgdctec)).'" type="application/pdf" width="100%" height="500px"> '.
                                '<iframe src="http://docs.google.com/gview?url='.urlencode('http://google.pt/'.$image_source.trim(strtolower($product->u_imgdctec))).'&embedded=true" style="width:100%; height:500px;" frameborder="0"></iframe>'.
                                //'Detalhes <a href="'.$image_source.trim(strtolower($product->u_imgdctec)).'">PDF</a>' .
                                //'</object>'
                            '';
                        break;
                    }
    			}
    			$prod->fields2['product_name'] = $product->design;
    			$prod->fields2['metadesc'] = '';
    			$prod->fields2['metakey'] = '';
    			$prod->fields2['customtitle'] = '';
    			
    			//en-gb
                $prod->fields7['product_s_desc'] = $product->langdes1;
    			$prod->fields7['product_desc'] = $product->u_descst2;
    			if(trim($product->u_imgdctec) != '')
    			{
                    switch (strtolower( pathinfo($product->u_imgdctec, PATHINFO_EXTENSION) )) {
                        case "gif":
                        case "jpg":
                        case "jpeg":
                        case "png":
                            $prod->fields7['product_desc'] .= "<img class=\"imgtec\" src='/".$image_source.trim(strtolower($product->u_imgdctec))."' />";
                            break;
                        case "pdf":
                            $prod->fields7['product_desc'] .=
                                //'<object data="'.$image_source.trim(strtolower($product->u_imgdctec)).'" type="application/pdf" width="100%" height="500px"> '.
                                '<iframe src="http://docs.google.com/gview?url='.urlencode('http://google.pt/'.$image_source.trim(strtolower($product->u_imgdctec))).'&embedded=true" style="width:100%; height:500px;" frameborder="0"></iframe>'.
                                //'Details <a href="'.$image_source.trim(strtolower($product->u_imgdctec)).'">PDF</a>' .
                                //'</object>'
                                '';
                            break;
                    }
    			}
    			$prod->fields7['product_name'] = $product->langdes1;
    			$prod->fields7['metadesc'] = '';
    			$prod->fields7['metakey'] = '';
    			$prod->fields7['customtitle'] = '';
    			
    			//familias
    			$familiasmulti = explode(";;", $product->familia);
    			
    			$prod->fields3['virtuemart_category_id'] = $this->category_model->get_id_by_ref( $familiasmulti[0] );
    			$prod->fields3['ordering'] = 0;
    			
    			$prod->fields8['virtuemart_category_id'] = $this->category_model->get_id_by_ref( $familiasmulti[1] );
    			$prod->fields8['ordering'] = 1;
    			
    			if( intval($product->u_mospr) == 0 )
    				$product->epv1 = 0;
    			
    			if ( $prod->exists == 1 ) 
    			{
    				if ( !$prod->save() ) 
    				{
    					$this->WriteLog( "Falhou Gravar Update Familia - " . $product->ref );
    					$errors++;
    				}
    				else
    				{
    					$prod->attach_price( $product->epv1_ivaincl ? strtoupper($product->epv1/1.23) : strtoupper($product->epv1), 1);
    					$prod->attach_price( $product->epv2_ivaincl ? strtoupper($product->epv2/1.23) : strtoupper($product->epv2), 2);
    					$prod->attach_price( $product->epv3_ivaincl ? strtoupper($product->epv3/1.23) : strtoupper($product->epv3), 3);
    					$prod->attach_price( $product->epv4_ivaincl ? strtoupper($product->epv4/1.23) : strtoupper($product->epv4), 4);
    					$prod->attach_price( $product->epv5_ivaincl ? strtoupper($product->epv5/1.23) : strtoupper($product->epv5), 5);
    
    					$prod->attach_media(trim(strtolower($product->imgqlook)), 0);
    					$prod->attach_media(trim(strtolower($product->imagem2)), 1);
    					$prod->attach_media(trim(strtolower($product->imagem3)), 2);
    					$prod->attach_media(trim(strtolower($product->imagem4)), 3);
    				}
    			} 
    			else //TRATA-SE DE UM NOVO ARTIGO
    			{ 
    				$prod->fields2['slug'] = $this->slugify( $product->ref . '_' . $product->design );
    				$prod->fields7['slug'] = $this->slugify( $product->ref . '_' . $product->design );
    				
    				if ( !$prod->save(true) ) 
    				{
    					$this->WriteLog( "Falhou Gravar Novo Artigo - " . $product->ref );
    					$errors++;
    				}
    				else
    				{
    					$prod->attach_price( $product->epv1_ivaincl ? strtoupper($product->epv1/1.23) : strtoupper($product->epv1), 1);
    					$prod->attach_price( $product->epv2_ivaincl ? strtoupper($product->epv2/1.23) : strtoupper($product->epv2), 2);
    					$prod->attach_price( $product->epv3_ivaincl ? strtoupper($product->epv3/1.23) : strtoupper($product->epv3), 3);
    					$prod->attach_price( $product->epv4_ivaincl ? strtoupper($product->epv4/1.23) : strtoupper($product->epv4), 4);
    					$prod->attach_price( $product->epv5_ivaincl ? strtoupper($product->epv5/1.23) : strtoupper($product->epv5), 5);
    					
    					$prod->attach_media(trim(strtolower($product->imgqlook)), 0);
    					$prod->attach_media(trim(strtolower($product->imagem2)), 1);
    					$prod->attach_media(trim(strtolower($product->imagem3)), 2);
    					$prod->attach_media(trim(strtolower($product->imagem4)), 3);
    				}
    			}	
    		}
		}
		else {
		    $f = fopen("tiago.txt", "a");
    		fwrite($f, print_r(stripcslashes( $_POST['data'] ), true) . "\n");
    		fclose($f);
		}
	
		if ( $errors > 0 ) 
		{
			$response = array( "success" => false );
		} 
		else 
		{
			$response = array( "success" => true );
		}

		echo json_encode( $response );
	}
	
	public function descontos() 
	{
		$errors = 0;
		$discounts = json_decode( stripcslashes( $_POST['data'] ) );
		$this->load->model( 'shoppergroup_model' );
		
		foreach ( $discounts as $discount ) 
		{
			$disc = $this->shoppergroup_model->get( $discount->cliente );

			if ( $disc->exists == 0) //TRATA-SE DE UM NOVO SHOPPERGROUP
			{
				$disc = new $this->shoppergroup_model();
			}
			
			//tabela virtuemart_shoppergroups
			$disc->fields['virtuemart_vendor_id'] = 1;
			$disc->fields['shopper_group_name'] = $discount->cliente;
			$disc->fields['shopper_group_desc'] = "Cliente num " . $discount->cliente;
			$disc->fields['custom_price_display'] = 0;
			$disc->fields['default'] = 0;
			$disc->fields['ordering'] = 0;
			$disc->fields['shared'] = 0;
			$disc->fields['published'] = 1;
			$disc->fields['created_on'] = '0000-00-00 00:00:00';
			$disc->fields['created_by'] = 0;
			$disc->fields['modified_on'] = '0000-00-00 00:00:00';
			$disc->fields['modified_by'] = 0;
			$disc->fields['locked_on'] = '0000-00-00 00:00:00';
			$disc->fields['locked_by'] = 0;
				
			//tabela virtuemart_product_prices
			$disc->fields2["override"] = 0;
			$disc->fields2["product_override_price"] = 0;
			$disc->fields2["product_tax_id"] = 0;
			$disc->fields2["product_discount_id"] = 0;
			$disc->fields2["product_currency"] = 47;
			$disc->fields2['created_on'] = '0000-00-00 00:00:00';
			$disc->fields2['created_by'] = 0;
			$disc->fields2['modified_on'] = '0000-00-00 00:00:00';
			$disc->fields2['modified_by'] = 0;
			$disc->fields2['locked_on'] = '0000-00-00 00:00:00';
			$disc->fields2['locked_by'] = 0;
				
			if ( $disc->exists == 1 ) 
			{
				$disc->attach_price(strtoupper($discount->artigo), $disc->fields['virtuemart_shoppergroup_id'], $discount->desconto);
			} 
			else //TRATA-SE DE UM NOVO SHOPPERGROUP
			{ 				
				$shoppg_id = $disc->save(true);
				
				if ( !$shoppg_id ) 
				{
					$this->WriteLog( "Falhou Gravar Novo Shoppergroup - " . $discount->cliente );
					$errors++;
				}
				else
				{
					$disc->attach_price( strtoupper($discount->artigo), $shoppg_id, $discount->desconto);
					$disc->attach_shopper_group( $shoppg_id, $discount->cliente);
				}
			}	
		}
		
		if ( $errors > 0 ) 
		{
			$response = array( "success" => false );
		} 
		else 
		{
			$response = array( "success" => true );
		}

		echo json_encode( $response );
	}
}