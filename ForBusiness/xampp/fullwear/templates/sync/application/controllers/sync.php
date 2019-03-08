<?php

class Sync extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}
	
	public function WriteLog($message)
	{
		$f = fopen("MyLog.txt", "a");
		fwrite($f, date("Y-m-d H:i:s") . " - " . print_r($message,true) . "\n");
		fclose($f);
	}
	
	public function encomendas_mdate() 
	{
		$this->load->model( 'order_model' );
		echo json_encode( array( "mdate" => $this->order_model->get_max_mdate() ) );
	}
	
	public function get_encomenda() 
	{
		$errors = 0;
		$last_order = json_decode( stripcslashes( $_POST['data'] ) );
		$this->load->model( 'order_model' );
		$encomendas = $this->order_model->get( $last_order );
		
		echo json_encode( $encomendas );
	}
	
	public function encomendas_end() 
	{
		$errors = 0;
		$last_order = json_decode( stripcslashes( $_POST['data'] ) );
		$this->load->model( 'order_model' );
		$this->order_model->set_ordered( $last_order );
		
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
	
	public function familias_ini()
	{
		$errors = 0;
		$this->load->model( 'product_model' );
		$this->db->query( "update e506s_virtuemart_categories set phc_clean = 0" );
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
	
	public function familias_end()
	{
		$errors = 0;
		$this->load->model( 'product_model' );
		//desactivar familias inexistentes
		$this->db->query( "update e506s_virtuemart_categories set published = 0 where phc_clean = 0" );
		$this->db->query( "update e506s_virtuemart_categories set published = 1 where phc_clean = 1" );
		
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
	
	public function familias() 
	{
		$errors = 0;
		$categories = json_decode( stripcslashes( $_POST['data'] ) );
		$this->load->model( 'category_model' );

		$fam_ref = array();
		
		foreach ( $categories as $category ) 
		{
			$cat = new $this->category_model();
			$cat = $cat->get( $category->ref );

			if ( $cat->exists == 0) //TRATA-SE DE UMA NOVA FAMILIA
			{
				$cat = new $this->category_model();
			}
			
			$date = new DateTime();
			$cur_date = $date->format('Y-m-d H:i:s');
			
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
			$cat->fields['phc_clean'] = 1;
			$cat->fields['created_on'] = '0000-00-00 00:00:00';
			$cat->fields['created_by'] = 0;
			$cat->fields['modified_on'] = $cur_date;
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
			$cat->fields6['category_name'] = $category->name;
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
					$cat->attach_media(strtolower($category->imagem));
				}
			} 
			else //TRATA-SE DE UMA NOVA FAMILIA
			{ 
				$cat->fields2['slug'] = $this->generateRandomString(5) . $this->slugify( $category->ref ) . $this->generateRandomString(5);
				$cat->fields6['slug'] = $this->generateRandomString(5) . $this->slugify( $category->ref ) . $this->generateRandomString(5);
				
				if ( !$cat->save(true) ) 
				{
					$this->WriteLog( "Falhou Gravar Nova Familia - " . $category->ref );
					$errors++;
				}
				else
				{
					$cat->attach_media(strtolower($category->imagem));
				}
			}
			
			$fam_ref[] = "'".$category->ref."'";
		}
		
		//atribuir relacoes entre familias
		foreach ( $categories as $category ) 
		{
			$par_id = $this->category_model->get_id_by_ref( $category->famipai );
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
		
		// $f = fopen("tiago.txt", "a");
		// fwrite($f, print_r($_POST['data'], true));
		// fclose($f);
		
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
	
	public function artigos_ini()
	{
		$errors = 0;
		$this->load->model( 'product_model' );
		$this->db->query( "update e506s_virtuemart_product_customfields set custom_param = ''" );
		$this->db->query( "update e506s_virtuemart_products set phc_clean = 0" );
		
		$this->db->query( "update e506s_fastseller_product_type_3 set sinc = 0" );
		$this->db->query( "update e506s_fastseller_product_type_4 set sinc = 0" );
		
		$this->db->query( "delete from e506s_filtros" );
		
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
	
	public function artigos_end()
	{
		$errors = 0;
		$this->load->model( 'product_model' );
		//desactivar artigos inexistentes
		$this->db->query( "update e506s_virtuemart_products set published = 0 where phc_clean = 0" );
		$this->db->query( "update e506s_virtuemart_products set published = 1 where phc_clean = 1" );
		
		$this->db->query( "delete from e506s_fastseller_product_type_3 where sinc = 0" );
		$this->db->query( "delete from e506s_fastseller_product_type_4 where sinc = 0" );
		
		$query = $this->db->query( 'delete from e506s_fastseller_product_product_type_xref where product_id not in (select product_id from e506s_fastseller_product_type_4) and product_type_id = 4' );
		$query = $this->db->query( 'select distinct product_id from e506s_fastseller_product_type_4 where product_id not in (select product_id from e506s_fastseller_product_product_type_xref where product_type_id = 4)' );
		
		if( $query->num_rows() > 0 )
		{
			foreach( $query->result_array() as $row ) 
			{
				$str = 'insert into e506s_fastseller_product_product_type_xref (product_id, product_type_id) values ('.$row["product_id"].', 4)';
				$this->db->query( $str );
            }
		}
		
		$query = $this->db->query( 'delete from e506s_fastseller_product_product_type_xref where product_id not in (select product_id from e506s_fastseller_product_type_3) and product_type_id = 3' );
		$query = $this->db->query( 'select distinct product_id from e506s_fastseller_product_type_3 where product_id not in (select product_id from e506s_fastseller_product_product_type_xref where product_type_id = 3)' );
		
		if( $query->num_rows() > 0 )
		{
			foreach( $query->result_array() as $row ) 
			{
				$str = 'insert into e506s_fastseller_product_product_type_xref (product_id, product_type_id) values ('.$row["product_id"].', 3)';
				$this->db->query( $str );
            }
		}
		
		$this->db->query( "insert into e506s_filtros (pt_pt, en_gb, nome) values ('MASCULINO', 'MALE', 'genero')" );
		$this->db->query( "insert into e506s_filtros (pt_pt, en_gb, nome) values ('FEMININO', 'FEMALE', 'genero')" );
		$this->db->query( "insert into e506s_filtros (pt_pt, en_gb, nome) values ('MASCULINO;FEMININO', 'GENDERLESS', 'genero')" );
		
		$this->db->query( "
			update e506s_virtuemart_categories
			set published = 0
			where virtuemart_category_id  not in 
			(
			select distinct virtuemart_category_id 
			from e506s_virtuemart_product_categories A
			inner join e506s_virtuemart_products B on A.virtuemart_product_id = B.virtuemart_product_id
			where B.published = 1
			)
		" );
		
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
		$art_ref = array();
		//$query = $this->db->query( "update e506s_virtuemart_product_customfields set custom_param = ''" );

		// $f = fopen("tiago.txt", "a");
		// fwrite($f, print_r($_POST['data'], true));
		// fclose($f);
		
		foreach ( $products as $product ) 
		{
			$prod_par = new $this->product_model();
			$pieces = explode("|||", $product->ref);
			$ref_parent = $pieces[0]."|||".$pieces[1];
			$prod_par = $prod_par->get_parent( $ref_parent );

			if ( $prod_par->exists == 0) //TRATA-SE DE UM NOVO ARTIGO
			{
				$prod_par = new $this->product_model();
			}
			
			$date = new DateTime();
			$cur_date = $date->format('Y-m-d H:i:s');
			
			//tabela virtuemart_products
			$prod_par->fields['product_sku'] = $ref_parent;
			$prod_par->fields['virtuemart_vendor_id'] = 1;
			$prod_par->fields['product_parent_id'] = 0;
			$prod_par->fields['product_in_stock'] = 0;
			$prod_par->fields['product_weight_uom'] = "KG";
			$prod_par->fields['phc_clean'] = 1;
			$prod_par->fields['created_on'] = $cur_date;
			$prod_par->fields['created_by'] = 0;
			$prod_par->fields['modified_on'] = $cur_date;
			$prod_par->fields['modified_by'] = 0;
			$prod_par->fields['locked_on'] = '0000-00-00 00:00:00';
			$prod_par->fields['locked_by'] = 0;
			$prod_par->fields['phc_ref'] = $ref_parent;
			$prod_par->fields['desconto'] = $product->desconto;
			$prod_par->fields['novidade'] = $product->novidade;
			$prod_par->fields['destaque'] = $product->destaque;
			
			$prod_par->fields['antibact'] = $product->antibact;
			$prod_par->fields['aqueci'] = $product->aqueci;
			$prod_par->fields['carbono'] = $product->carbono;
			$prod_par->fields['confort'] = $product->confort;
			$prod_par->fields['cortaven'] = $product->cortaven;
			$prod_par->fields['dryclim'] = $product->dryclim;
			$prod_par->fields['drystorm'] = $product->drystorm;
			$prod_par->fields['elastic'] = $product->elastic;
			$prod_par->fields['flatlock'] = $product->flatlock;
			$prod_par->fields['fresc'] = $product->fresc;
			$prod_par->fields['frio'] = $product->frio;
			$prod_par->fields['ikk'] = $product->ikk;
			$prod_par->fields['imperme'] = $product->imperme;
			$prod_par->fields['multicam'] = $product->multicam;
			$prod_par->fields['reflet'] = $product->reflet;
			$prod_par->fields['respir'] = $product->respir;
			$prod_par->fields['silico'] = $product->silico;
			$prod_par->fields['termoreg'] = $product->termoreg;
			
			$prod_par->fields['imgtam'] = $product->u_imgtam;
			
			$image_source = "images/stories/virtuemart/product/";
			
			//pt-pt
			$prod_par->fields2['product_s_desc'] = $product->descricao_pt;
			$prod_par->fields2['product_desc'] = $product->descricao_pt;
			// if(trim($product->u_imgdctec) != '')
			// {
				// $prod_par->fields2['product_desc'] .= "<br><br><img src='/".$image_source.trim(strtolower($product->u_imgdctec))."' />";
			// }
			$prod_par->fields2['product_name'] = $product->design;
			$prod_par->fields2['metadesc'] = '';
			$prod_par->fields2['metakey'] = '';
			$prod_par->fields2['customtitle'] = '';
			
			//en-gb
			$prod_par->fields7['product_s_desc'] = $product->descricao_uk;
			$prod_par->fields7['product_desc'] = $product->descricao_uk;
			// if(trim($product->u_imgdctec) != '')
			// {
				// $prod_par->fields7['product_desc'] .= "<br><br><img src='/".$image_source.trim(strtolower($product->u_imgdctec))."' />";
			// }
			$prod_par->fields7['product_name'] = $product->design;
			$prod_par->fields7['metadesc'] = '';
			$prod_par->fields7['metakey'] = '';
			$prod_par->fields7['customtitle'] = '';
			
			$prod_par->fields3['virtuemart_category_id'] = $this->category_model->get_id_by_ref( $product->familia );
			$prod_par->fields3['ordering'] = 0;			
			
			if ( $prod_par->exists == 1 ) 
			{
				if ( !$prod_par->save() ) 
				{
					$this->WriteLog( "Falhou Gravar Update Artigo - " . $ref_parent );
					$errors++;
				}
				else
				{
					$prod_par->attach_price(strtoupper($product->epv2 - ($product->epv2*($product->desconto/100))));
					$prod_par->attach_media(trim(strtolower($product->imagem1)), 0);
					$prod_par->attach_media(trim(strtolower($product->imagem2)), 1);
					$prod_par->attach_media(trim(strtolower($product->imagem3)), 2);
					$prod_par->attach_media(trim(strtolower($product->imagem4)), 3);
				}
			} 
			else //TRATA-SE DE UM NOVO ARTIGO
			{ 
				$prod_par->fields2['slug'] = $this->slugify( $product->ref ) . "-" . $this->slugify( $product->design );
				$prod_par->fields7['slug'] = $this->slugify( $product->ref ) . "-" . $this->slugify( $product->design );
				
				if ( !$prod_par->save(true) ) 
				{
					$this->WriteLog( "Falhou Gravar Novo Artigo - " . $ref_parent );
					$errors++;
				}
				else
				{
					$prod_par->attach_price(strtoupper($product->epv2 - ($product->epv2*($product->desconto/100))));
					$prod_par->attach_media(trim(strtolower($product->imagem1)), 0);
					$prod_par->attach_media(trim(strtolower($product->imagem2)), 1);
					$prod_par->attach_media(trim(strtolower($product->imagem3)), 2);
					$prod_par->attach_media(trim(strtolower($product->imagem4)), 3);
				}
			}
			
			$prod_par = new $this->product_model();
			$prod_par = $prod_par->get_parent( $ref_parent );
			
			//modalidade,genero,linha,categoria
			$prod_par->fields9['product_id'] = $prod_par->fields['virtuemart_product_id'];
			$prod_par->fields9['sinc'] = 1;
			$prod_par->fields9['Modalidade'] = mb_strtoupper($product->modalidade);
			
			$prod_par->fields11['pt_pt'] = mb_strtoupper($product->modalidade);
			$prod_par->fields11['en_gb'] = mb_strtoupper($product->modalidade_uk);
			$prod_par->fields11['nome'] = "modalidade";
			
			$prod_par->fields12['pt_pt'] = mb_strtoupper($product->categoria);
			$prod_par->fields12['en_gb'] = mb_strtoupper($product->design_uk);
			$prod_par->fields12['nome'] = "categoria";
			
			if( mb_strtoupper($product->genero) == "UNISSEXO" or mb_strtoupper($product->genero) == "UNISEXO" or mb_strtoupper($product->genero) == "UNISEX" or mb_strtoupper($product->genero) == "GENDERLESS") {
				$prod_par->fields9['Genero'] = "MASCULINO;FEMININO";
			}
			else {
				$prod_par->fields9['Genero'] = mb_strtoupper($product->genero);
			}
			$prod_par->fields9['Linha'] = mb_strtoupper($product->linha);
			$prod_par->fields9['Categoria'] = mb_strtoupper($product->categoria);
			$prod_par->save_ggl1();
			$prod_par->save_modalidade();
			$prod_par->save_categoria();
			
			//cor, tamanho
			$prod_par->fields10['Cor'] = $product->ref;
			$prod_par->save_ggl2();
			
			//filho
			
			$pieces = explode("|||", $product->ref);
			$ref_parent = $pieces[0]."|||".$pieces[1];
			$grelha = explode("|||", $product->ref);
			$tam_cor = $grelha[2]."|||".$grelha[3];
			$tam_cor2 = $grelha[2]."-".$grelha[3];
			$prod = new $this->product_model();
			$prod = $prod->get( $product->ref );

			if ( $prod->exists == 0) //TRATA-SE DE UM NOVO ARTIGO
			{
				$prod = new $this->product_model();
			}
			
			$date = new DateTime();
			$cur_date = $date->format('Y-m-d H:i:s');
			
			//tabela virtuemart_products
			$prod->fields['product_sku'] = $product->ref;
			$prod->fields['virtuemart_vendor_id'] = 1;
			$prod->fields['product_parent_id'] = 0;
			$prod->fields['product_in_stock'] = $product->stock;
			$prod->fields['product_weight_uom'] = "KG";
			$prod->fields['phc_clean'] = 1;
			$prod->fields['created_on'] = $cur_date;
			$prod->fields['created_by'] = 0;
			$prod->fields['modified_on'] = $cur_date;
			$prod->fields['modified_by'] = 0;
			$prod->fields['locked_on'] = '0000-00-00 00:00:00';
			$prod->fields['locked_by'] = 0;
			$prod->fields['product_parent_id'] = $prod_par->fields['virtuemart_product_id'];
			$prod->fields['desconto'] = $product->desconto;
			$prod->fields['novidade'] = $product->novidade;
			$prod->fields['destaque'] = $product->destaque;
			
			$image_source = "images/stories/virtuemart/product/";
			
			//pt-pt
			$prod->fields2['product_s_desc'] = $product->descricao_pt;
			$prod->fields2['product_desc'] = $product->descricao_pt;
			// if(trim($product->u_imgdctec) != '')
			// {
				// $prod->fields2['product_desc'] .= "<br><br><img src='/".$image_source.trim(strtolower($product->u_imgdctec))."' />";
			// }
			$prod->fields2['product_name'] = $product->design;
			$prod->fields2['metadesc'] = '';
			$prod->fields2['metakey'] = '';
			$prod->fields2['customtitle'] = '';
			
			//en-gb
			$prod->fields7['product_s_desc'] = $product->descricao_uk;
			$prod->fields7['product_desc'] = $product->descricao_uk;
			// if(trim($product->u_imgdctec) != '')
			// {
				// $prod->fields7['product_desc'] .= "<br><br><img src='/".$image_source.trim(strtolower($product->u_imgdctec))."' />";
			// }
			$prod->fields7['product_name'] = $product->design;
			$prod->fields7['metadesc'] = '';
			$prod->fields7['metakey'] = '';
			$prod->fields7['customtitle'] = '';
			
			$prod->fields3['virtuemart_category_id'] = $this->category_model->get_id_by_ref( $product->familia );
			$prod->fields3['ordering'] = 0;
			
			$prod->fields8['virtuemart_custom_id'] = 7;
			$prod->fields8['virtuemart_product_id'] = $prod_par->fields['virtuemart_product_id'];
			$prod->fields8['custom_value'] = 'stockable';
			$prod->fields8['custom_price'] = 0;
			$prod->fields8['published'] = 1;
			$prod->fields8['custom_param'] = $tam_cor;
			
			if ( $prod->exists == 1 ) 
			{
				if ( !$prod->save() ) 
				{
					$this->WriteLog( "Falhou Gravar Update Familia - " . $product->ref );
					$errors++;
				}
				else
				{
					$prod->attach_price(strtoupper($product->epv2 - ($product->epv2*($product->desconto/100))));
					// $prod->attach_media(trim(strtolower($product->imgqlook)));
				}
			} 
			else //TRATA-SE DE UM NOVO ARTIGO
			{ 
				$prod->fields2['slug'] = $this->slugify( $product->ref ) . "-" . $this->slugify( $product->design ) . "-" . $this->slugify( $tam_cor2 );
				$prod->fields7['slug'] = $this->slugify( $product->ref ) . "-" . $this->slugify( $product->design ) . "-" . $this->slugify( $tam_cor2 );
				
				if ( !$prod->save(true) ) 
				{
					$this->WriteLog( "Falhou Gravar Novo Artigo - " . $product->ref );
					$errors++;
				}
				else
				{
					$prod->attach_price(strtoupper($product->epv2 - ($product->epv2*($product->desconto/100))));
					// $prod->attach_media(trim(strtolower($product->imgqlook)));
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