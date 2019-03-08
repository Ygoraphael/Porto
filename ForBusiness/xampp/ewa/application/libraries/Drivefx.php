<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drivefx {
	
	protected $CI;
	protected $urlBase;
	protected $usernameLogin;
	protected $passwordLogin;
	protected $appTypeLogin;
	protected $companyLogin;
	
	protected $ch;
	protected $response;
	
	protected $ndoc;
	protected $nmdoc;
	
	protected $no;
	protected $ref;
	
	protected $ftstamp;
	protected $fno;
	
	protected $repstamp;
	
	public $error;
	
	public function __construct()
    {
		$this->CI =& get_instance();
		$this->CI->load->library(array('mssql'));
    }
	
	public function get_saft( $ano, $datai, $dataf, $cae ) {
		if (curl_error($this->ch)) {
		} else if(empty($this->response)){
		} else if(isset($this->response['messages'][0]['messageCodeLocale'])){
		} else {
			/*******************************************************************
			*            Called webservice that export to excel file           *
			********************************************************************/
			$url = $this->urlBase."REST/UtilitariosWS/getSaft";
			
			// Create map with request parameters
			$params =  array('getSaftVO' => '{  "ChangedFields":{},
												"isLazyLoaded":false,
												"localeFields":[],
												"logInfo":"",
												"Operation":0,
												"ousrdata":"1900-01-01T00:00:00.000Z",
												"ousrhora":"",
												"ousrinis":"",
												"revisionNumber":0,
												"syshist":false,
												"userFields":{},
												"usrdata":"1900-01-01T00:00:00.000Z",
												"usrhora":"",
												"usrinis":"",
												"ano":"'.$ano.'",
												"cae":"'.$cae.'",
												"datafim":"'.$dataf.'T00:00:00.000Z",
												"datafimparcial":"1900-01-01T00:00:00.000Z",
												"dataini":"'.$datai.'T00:00:00.000Z",
												"datainiparcial":"1900-01-01T00:00:00.000Z",
												"email":"",
												"flstamp":"",
												"guias":false,
												"portaria":2,
												"sendToEmail":false,
												"simplificado":true,
												"taxentity":"Global",
												"mes":""}'
							);		

			// Build Http query using params
			$query = http_build_query ($params);

			curl_setopt($this->ch, CURLOPT_URL, $url);
			curl_setopt($this->ch, CURLOPT_POST, false);
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, $params);
			$this->response = curl_exec($this->ch);   
					
			// send response as JSON
			$this->response = json_decode($this->response, true); 

			if (curl_error($this->ch)) {
			} else if(empty($this->response)){
			} else if(isset($this->response['messages'][0]['messageCodeLocale'])){
				$this->error .= "<h3>" . $this->response['messages'][0]['messageCodeLocale'] . "</h3>"; 
			} else {  		
				
				//Download XML
				$urlDownloadPdf = $this->urlBase.'cxml.aspx';

				// Create map with request parameters
				$params =  array('fileName' => explode("ExportedFiles/",$this->response['scalarResult']['stringResult'])[1],
								 'downloadName' => explode("ExportedFiles/",$this->response['scalarResult']['stringResult'])[1]
								);		

				// Build Http query using params
				$query = http_build_query ($params);

				curl_setopt($this->ch, CURLOPT_URL, $urlDownloadPdf);
				curl_setopt($this->ch, CURLOPT_POST, true);
				curl_setopt($this->ch, CURLOPT_POSTFIELDS, $params);
				$this->response2 = curl_exec($this->ch);   

				if (curl_error($this->ch)) {
				} else {
					
					//Download XML file
					header('Content-Type: text/xml');
					header("Content-disposition: attachment; filename=".rawurlencode(explode("ExportedFiles/",$this->response['scalarResult']['stringResult'])[1]));
					echo $this->response2;
				}
			}	
		}
	}
	
	public function set_credentials( $url, $username, $pw, $key, $company ) {
		$this->urlBase = $url;
		$this->usernameLogin = $username;
		$this->passwordLogin = $pw;
		$this->appTypeLogin  = $key;
		$this->companyLogin  = $company;
		$this->error = "";
	}
	
	public function envia_email( $dados_email ) {
		if (curl_error($this->ch)) {
		} else if(empty($this->response)){
		} else if(isset($this->response['messages'][0]['messageCodeLocale'])){
		} else {  
			if( trim($dados_email['email']) != '' ){

				/*******************************************************************
				*       Called webservice that create PDF with report enabled      *
				********************************************************************/						
				$url = $this->urlBase."REST/reportws/print";
				
				// Create map with request parameters				
				$params =  array ('options' => '{"docId":'.$this->ndoc.',
														"emailConfig":
														{"bcc":"",
														"body":"'.trim($dados_email['body']).'",
														"cc":"",
														"isBodyHtml":true,
														"sendFrom":"'.trim($dados_email['from']).'",
														"sendTo":"'.trim($dados_email['email']).'",
														"sendToMyself":false,
														"subject":"'.trim($dados_email['subject']).'"},
														"generateOnly":false,
														"isPreview":false,
														"outputType":2,
														"printerId":"",
														"records":[{"docId":'.$this->ndoc.',
														"entityType":"Ft",
														"stamp":"'.$this->ftstamp.'"}],
														"reportStamp":"'.$this->repstamp.'",
														"sendToType":0,"serie":0}');
				
				// Build Http query using params
				$query = http_build_query ($params);

				curl_setopt($this->ch, CURLOPT_URL, $url);
				curl_setopt($this->ch, CURLOPT_POST, false);
				curl_setopt($this->ch, CURLOPT_POSTFIELDS, $params);
				$this->response = curl_exec($this->ch);    				
						
				// send response as JSON
				$this->response = json_decode($this->response, true); 

				if (curl_error($this->ch)) {
				} else if(empty($this->response)){
				} else if(isset($this->response['messages'][0]['messageCodeLocale'])){
					if( $this->response['messages'][0]['messageCodeLocale'] == "Email enviado com sucesso" ) {
						return 1;
					}
					else {
						$this->error .= $this->response['messages'][0]['messageCodeLocale'];
					}
				} else {  
					return 1;
				}
			}
		}
		return 0;
	}
	
	public function get_fatura( $data_lines, $data_client ) {
		$data_client2 = $data_client;
		$this->CI->mssql->utf8_encode_deep( $data_client2 );
		$data_client = $data_client2;
		
		if (curl_error($this->ch)) {
			$this->error .= $this->ch; 
		} else if(empty($this->response)){
		} else if(isset($this->response['messages'][0]['messageCodeLocale'])){
			$this->error .= "Error in login. Please verify your username, password, applicationType and company.";
		} else {
			/************************************************************************
		 	*           Called webservice that obtain a new instance of FT          *
		 	*************************************************************************/			
			$url = $this->urlBase."REST/FtWS/getNewInstance"; 
			
			// Create map with request parameters
			$params =  array ('ndos' => $this->ndoc);			
			// Build Http query using params
			$query = http_build_query ($params);

			curl_setopt($this->ch, CURLOPT_URL, $url);
			curl_setopt($this->ch, CURLOPT_POST, false);
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, $params);
			$this->response = curl_exec($this->ch);      
					
			// send response as JSON
			$this->response = json_decode($this->response, true); 

			if (curl_error($this->ch)) {
				$this->error .= $this->ch; 
			} else if(empty($this->response)){
			} else if(isset($this->response['messages'][0]['messageCodeLocale'])){
				$this->error .= $this->response['messages'][0]['messageCodeLocale'];
			} else {      
				$linha_num = 0;
				foreach( $data_lines as $linha ) {
					/******************************************************************************
					*                      Add new line to the invoice document                   *
					*******************************************************************************/
					$newLine = '{ "actqtt2":false,		
								"amostra":false,				
								"armazem":0,				
								"articleAutoCreationCode":0,		
								"avencano":0,				
								"avencastamp":"",			
								"bistamp":"",			
								"ccstamp":"",				
								"cliref":"",				
								"codigo":"",				
								"codmotiseimp":"",			
								"componente":false,			
								"compound":false,			
								"cpoc":0,				
								"davencaft":"1900-01-01 00:00:00Z",		
								"desc2":0,				
								"desc3":0,				
								"desc4":0,				
								"desc5":0,				
								"desc6":0,				
								"desconto":"' . $linha["desconto"] . '",			
								"design":"' . $linha["design"] . '",		
								"ecusto":0,				
								"elucro":0,				
								"emargem":0,			
								"epv":' . $linha["epv"] . ',		
								"etiliquido":0,			
								"ettiva":0,				
								"evalcomissao":0,		
								"facturaFt":false,		
								"familia":"",			
								"fechabo":false,		
								"firefs":[],		
								"fistamp":"",		
								"ftstamp":"' . $this->response['result'][0]['ftstamp'] . '",		
								"iva":' . $linha["taxaiva"] . ',			
								"ivadata":"1900-01-01 00:00:00Z",		
								"ivaincl":true,				
								"ivarec":0,				
								"litem":"",				
								"litem2":"",			
								"lordem":0,				
								"lrecno":"",			
								"maxQttRefund":0,		
								"miseimpstamp":"",		
								"motiseimp":"",			
								"nvol":0,				
								"ofistamp":"",			
								"ofnstamp":"",			
								"oftstamp":"",			
								"oref":"",			
								"originalMaxQttRefund":0,		
								"pbuni":0,			
								"pluni":0,				
								"pvmoeda":0,	
								"qtt":' . $linha["qtt"] . ',		
								"rdata":"1900-01-01 00:00:00Z",		
								"rdstamp":"",		
								"ref":"' . $linha["ref"] . '",
								"stns":true,			
								"sujirs":false,			
								"tabiva":' . $linha["tabiva"] . ',				
								"tmoeda":0,				
								"tnvol":0,				
								"tpbrut":0,				
								"tpliq":0,				
								"treestamp":"",			
								"tvol":0,				
								"unidade":"",			
								"usr1":"",				
								"usr2":"",		
								"vuni":0
							}';				
					
					//Add line to FtVO
					$this->response['result'][0]['fis'][$linha_num] = json_decode($newLine);
					$linha_num++;
				}
				
				//Associate client to FT
				$this->response['result'][0]['no'] = $this->no;	

				$urlFt = $this->urlBase."REST/FtWS/actEntity";

				// Create map with request parameters
				$paramsFt =  array ('entity' => json_encode($this->response['result'][0]),
									'code' => 0, 
									'newValue' => json_encode([]));
				// Build Http query using params
				$queryFt = http_build_query($paramsFt);
				curl_setopt($this->ch, CURLOPT_URL, $urlFt);
				curl_setopt($this->ch, CURLOPT_POST, false);
				curl_setopt($this->ch, CURLOPT_POSTFIELDS, $queryFt);
				
				$this->response = curl_exec($this->ch);
				// send response as JSON
				$this->response = json_decode($this->response, true);    

				if (curl_error($this->ch)) {
					$this->error .= $this->ch; 
				} else if(empty($this->response)){
				} else if(isset($this->response['messages'][0]['messageCodeLocale'])){
					$this->error .= $this->response['messages'][0]['messageCodeLocale'];
				} else {  
					//Eliminate financial discount of client
					$this->response['result'][0]['efinv'] = 0;  
					$this->response['result'][0]['fin'] = 0;

					/****************************************************************************************************
					*     Called webservice that update all data in invoice document based on discounts, client, etc    *
					*****************************************************************************************************/
					
					$urlFt = $this->urlBase."REST/FtWS/actEntity";

					// Create map with request parameters
					$paramsFt =  array ('entity' => json_encode($this->response['result'][0]),
										'code' => 0, 
										'newValue' => json_encode([]));
					// Build Http query using params
					$queryFt = http_build_query($paramsFt);
					curl_setopt($this->ch, CURLOPT_URL, $urlFt);
					curl_setopt($this->ch, CURLOPT_POST, false);
					curl_setopt($this->ch, CURLOPT_POSTFIELDS, $queryFt);
					
					$this->response = curl_exec($this->ch);
					// send response as JSON
					$this->response = json_decode($this->response, true);    

					if (curl_error($this->ch)) {
						$this->error .= $this->ch; 
					} else if(empty($this->response)){
					} else if(isset($this->response['messages'][0]['messageCodeLocale'])){
						$this->error .= $this->response['messages'][0]['messageCodeLocale'];
					} else { 
						$this->response['result'][0]['nome'] = $data_client["nome"];
						$this->response['result'][0]['ncont'] = $data_client["ncont"];
						$this->response['result'][0]['morada'] = $data_client["morada"];
						$this->response['result'][0]['codpost'] = $data_client["codpost"];
						$this->response['result'][0]['local'] = $data_client["local"];
						$this->response['result'][0]['email'] = $data_client["email"];
						
						/*******************************************************************
						*                   Called webservice that save FT                 *
						********************************************************************/							
						$url = $this->urlBase."REST/FtWS/Save";
						
						// Create map with request parameters
						$params =  array(  'itemVO' => json_encode($this->response['result'][0]),
											'runWarningRules' => 'false'
										); 
						
						// Build Http query using params
						$query = http_build_query ($params); 

						curl_setopt($this->ch, CURLOPT_URL, $url);
						curl_setopt($this->ch, CURLOPT_POST, false);
						curl_setopt($this->ch, CURLOPT_POSTFIELDS, $params);
						$this->response = curl_exec($this->ch);
						// send response as JSON
						$this->response = json_decode($this->response, true);  

						if (curl_error($this->ch)) {
							$this->error .= $this->ch; 
						} else if(empty($this->response)){
						} else if(isset($this->response['messages'][0]['messageCodeLocale'])){
							$this->error .= "<h3>Error in creation of FT in Drive FX</h3>";
						} else {
							//Enable to sign Document
							if($this->response['result'][0]['draftRecord'] == 1){
								$this->ftstamp = $this->response['result'][0]['ftstamp'];

								/*******************************************************************
								*                 Called webservice that sign document             *
								********************************************************************/									
								$url = $this->urlBase."REST/FtWS/signDocument";
								
								// Create map with request parameters
								$params =  array ('ftstamp' => $this->ftstamp);	
								// Build Http query using params
								$query = http_build_query ($params);

								curl_setopt($this->ch, CURLOPT_URL, $url);
								curl_setopt($this->ch, CURLOPT_POST, false);
								curl_setopt($this->ch, CURLOPT_POSTFIELDS, $params);
								$this->response = curl_exec($this->ch);      
								// send response as JSON
								$this->response = json_decode($this->response, true); 

								if (curl_error($this->ch)) {
									$this->error .= $this->ch; 
								} else if(empty($this->response)){ 
								} else if(isset($this->response['messages'][0]['messageCodeLocale'])){
									$this->error .= $this->response['messages'][0]['messageCodeLocale'];
								} else {
									$this->fno = $this->response['result'][0]['fno'];
									return $this->fno;
								}
							}
						}
					}
				}
			}
		}
		return 0;
	}
	
	public function set_report() {
		if (curl_error($this->ch)) {
		} else if(empty($this->response)){
		} else if(isset($this->response['messages'][0]['messageCodeLocale'])){
			$this->error .= "Error in login. Please verify your username, password, applicationType and company.";
		} else {
			/*******************************************************************
			*     Called webservice that get layout of report to create PDF    *
			********************************************************************/										
			$url = $this->urlBase."REST/reportws/getReportsForPrint";
			
			// Create map with request parameters
			$params =  array ('entityname' => 'ft',
								'numdoc' => $this->ndoc);
			// Build Http query using params
			$query = http_build_query ($params);

			curl_setopt($this->ch, CURLOPT_URL, $url);
			curl_setopt($this->ch, CURLOPT_POST, false);
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, $params);
			$this->response = curl_exec($this->ch);      
			// send response as JSON
			$this->response = json_decode($this->response, true); 

			if (curl_error($this->ch)) {
			} else if(empty($this->response)){            
			} else if(isset($this->response['messages'][0]['messageCodeLocale'])){              
			} else {
				//Verify if exists template configurated and select the first
				$i = 0;
				$count = count($this->response['result']);
				while ($i < $count) {
					foreach ($this->response['result'][$i] as $key => $value){
						if($key == 'enabled' && $value == 1){
							$this->repstamp = $this->response['result'][$i]['repstamp'];
							break;
						}	
					}
					++$i;
				}
			}
		}
	}
	
	public function get_td(  ) {
		if (curl_error($this->ch)) {
		} else if(empty($this->response)){
		} else if(isset($this->response['messages'][0]['messageCodeLocale'])){
			$this->error .= "Error in login. Please verify your username, password, applicationType and company.";
		} else {
			/*******************************************************************
		 	* Called webservice that obtain all invoice documents (FT, FS, FR) *
		 	********************************************************************/
			$url = $this->urlBase."REST/SearchWS/QueryAsEntities";
			
			// Create map with request parameters
			$params =  array('itemQuery' => '{"groupByItems":[],
												"lazyLoaded":false,
												"joinEntities":[],
												"orderByItems":[],
												"SelectItems":[],
												"entityName":"Td",
												"filterItems":[{
																"comparison":0,
																"filterItem":"inactivo",
																"valueItem":"0",
																"groupItem":1,
																"checkNull":false,
																"skipCheckType":false,
																"type":"Number"
															}]}'
							);		
			// Build Http query using params
			$query = http_build_query ($params);

			curl_setopt($this->ch, CURLOPT_URL, $url);
			curl_setopt($this->ch, CURLOPT_POST, false);
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, $params);
			$this->response = curl_exec($this->ch);      
					
			// send response as JSON
			$this->response = json_decode($this->response, true); 

			if (curl_error($this->ch)) {
			} else if(empty($this->response)){
			} else if(isset($this->response['messages'][0]['messageCodeLocale'])){
				$this->error .= "Error: " . $this->response['messages'][0]['messageCodeLocale'] . "<br><br>";
			} else {
				foreach ($this->response['result'] as $key => $value){
					if( $value['tiposaft'] == 'FR' ) {
						$this->ndoc = $value['ndoc'];
						$this->nmdoc = $value['nmdoc'];
						break;
					}
				}
				// log_message("ERROR", print_r($this->ndoc, true) );
				// log_message("ERROR", print_r($this->nmdoc, true) );
			}
		}
	}
	
	public function get_client() {
		if (curl_error($this->ch)) {
		} else if(empty($this->response)){      
		} else if(isset($this->response['messages'][0]['messageCodeLocale'])){ 
			$this->error .= "Error in login. Please verify your username, password, applicationType and company.";
		} else {
			/************************************************************************
		 	*        Called webservice that find if client already exists           *
		 	*************************************************************************/
			$url = $this->urlBase."REST/SearchWS/QueryAsEntities";
			
			// Create map with request parameters
			$params =  array('itemQuery' => '{"groupByItems":[],
												"lazyLoaded":false,
												"joinEntities":[],
												"orderByItems":[],
												"SelectItems":[],
												"entityName":"Cl",
												"filterItems":[{
																"comparison":0,
																"filterItem":"no",
																"valueItem":"2",
																"groupItem":1,
																"checkNull":false,
																"skipCheckType":false,
																"type":"Number"
															  }]}'
							);		
			// Build Http query using params
			$query = http_build_query ($params);

			curl_setopt($this->ch, CURLOPT_URL, $url);
			curl_setopt($this->ch, CURLOPT_POST, false);
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, $params);
			$this->response = curl_exec($this->ch);      
					
			// send response as JSON
			$this->response = json_decode($this->response, true); 

			if (curl_error($this->ch)) {
			} else if(empty($this->response)){
			} else if(isset($this->response['messages'][0]['messageCodeLocale'])){
			} else {  
				//Verify if client exists
				if(is_array($this->response['result']) && !empty($this->response['result'][0])){
					$this->no = $this->response['result'][0]['no'];
				} else {
					/************************************************************************
		 			*        Called webservice that obtain a new instance of client         *
		 			*************************************************************************/					
					$url = $this->urlBase."REST/ClWS/getNewInstance";
					
					// Create map with request parameters
					$params =  array ('ndos' => 0);			
					// Build Http query using params
					$query = http_build_query ($params);

					curl_setopt($this->ch, CURLOPT_URL, $url);
					curl_setopt($this->ch, CURLOPT_POST, false);
					curl_setopt($this->ch, CURLOPT_POSTFIELDS, $params);
					$this->response = curl_exec($this->ch);      
							
					// send response as JSON
					$this->response = json_decode($this->response, true); 

					if (curl_error($this->ch)) {
					} else if(empty($this->response)){
					} else if(isset($this->response['messages'][0]['messageCodeLocale'])){
					} else {    
						//Change name and email of client
						$this->response['result'][0]['nome'] = 'Consumidor Final';
						$this->response['result'][0]['email'] = '';
						$this->response['result'][0]['ncont'] = '';
						$this->response['result'][0]['clivd'] = true;
						$this->response['result'][0]['no'] = 2;

						/************************************************************************
		 				*                    Called webservice that save client                 *
		 				*************************************************************************/						
						$url = $this->urlBase."REST/ClWS/Save";
						
						// Create map with request parameters
						$params =  array(  'itemVO' => json_encode($this->response['result'][0]),
											'runWarningRules' => 'false'
										); 
						
						// Build Http query using params
						$query = http_build_query ($params);

						curl_setopt($this->ch, CURLOPT_URL, $url);
						curl_setopt($this->ch, CURLOPT_POST, false);
						curl_setopt($this->ch, CURLOPT_POSTFIELDS, $params);
						$this->response = curl_exec($this->ch);
						// send response as JSON
						$this->response = json_decode($this->response, true);  

						if (curl_error($this->ch)) {
							$this->no = 0;
						} else if(empty($this->response)){
							$this->no = 0;
						} else if(isset($this->response['messages'][0]['messageCodeLocale'])){
							$this->error .= "Error: " . $this->response['messages'][0]['messageCodeLocale'];
							$this->no = 0;
						} else {  
							$this->no = $this->response['result'][0]['no'];
						}
					}
				}
			}
		}
	}
	
	public function get_product( $referencia, $designacao ) {
		if (curl_error($this->ch)) {
		} else if(empty($this->response)){      
		} else if(isset($this->response['messages'][0]['messageCodeLocale'])){      
			$this->error .= "Error in login. Please verify your username, password, applicationType and company.";
		} else {
			/***********************************************************************
		 	*        Called webservice that find  if product already exists        *
		 	************************************************************************/			
			$url = $this->urlBase."REST/SearchWS/QueryAsEntities";
			
			// Create map with request parameters
			$params =  array('itemQuery' => '{"groupByItems":[],
												"lazyLoaded":false,
												"joinEntities":[],
												"orderByItems":[],
												"SelectItems":[],
												"entityName":"St",
												"filterItems":[{
																"comparison":0,
																"filterItem":"ref",
																"valueItem":"'.trim($referencia).'",
																"groupItem":1,
																"checkNull":false,
																"skipCheckType":false,
																"type":"Number"
															}]}'
							);		
			// Build Http query using params
			$query = http_build_query ($params);

			curl_setopt($this->ch, CURLOPT_URL, $url);
			curl_setopt($this->ch, CURLOPT_POST, false);
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, $params);
			$this->response = curl_exec($this->ch);      
					
			// send response as JSON
			$this->response = json_decode($this->response, true); 

			if (curl_error($this->ch)) {
			} else if(empty($this->response)){
			} else if(isset($this->response['messages'][0]['messageCodeLocale'])){
			} else {  
				//Verify if product exists
				if(is_array($this->response['result']) && !empty($this->response['result'][0])){
					$this->ref = $this->response['result'][0]['ref'];
				} else {
					/************************************************************************
		 			*        Called webservice that obtain a new instance of product        *
		 			*************************************************************************/					
					$url = $this->urlBase."REST/StWS/getNewInstance";
					
					// Create map with request parameters
					$params =  array ('ndos' => 0);			
					// Build Http query using params
					$query = http_build_query ($params);

					curl_setopt($this->ch, CURLOPT_URL, $url);
					curl_setopt($this->ch, CURLOPT_POST, false);
					curl_setopt($this->ch, CURLOPT_POSTFIELDS, $params);
					$this->response = curl_exec($this->ch);      
							
					// send response as JSON
					$this->response = json_decode($this->response, true); 

					if (curl_error($this->ch)) {
					} else if(empty($this->response)){
					} else if(isset($this->response['messages'][0]['messageCodeLocale'])){
					} else {    
						$this->response['result'][0]['ref'] = $referencia; //reference of product
						$this->response['result'][0]['design'] = $designacao; //name of product
						$this->response['result'][0]['stock'] = '0';   //stock of product
						$this->response['result'][0]['epv1'] = '0.00';    //retail price 1
						$this->response['result'][0]['iva1incl'] = true;  //tax rate included
						$this->response['result'][0]['inactivo'] = false; //active
						$this->response['result'][0]['stns'] = true; //service

						/************************************************************************
		 				*                   Called webservice that save product                 *
		 				*************************************************************************/						
						$url = $this->urlBase."REST/StWS/Save";
						
						// Create map with request parameters
						$params =  array(  'itemVO' => json_encode($this->response['result'][0]),
											'runWarningRules' => 'false'
										); 
						
						// Build Http query using params
						$query = http_build_query ($params);

						curl_setopt($this->ch, CURLOPT_URL, $url);
						curl_setopt($this->ch, CURLOPT_POST, false);
						curl_setopt($this->ch, CURLOPT_POSTFIELDS, $params);
						$this->response = curl_exec($this->ch);
						// send response as JSON
						$this->response = json_decode($this->response, true); 

						if (curl_error($this->ch)) {
							$this->ref = '';
						} else if(empty($this->response)){
							$this->ref = '';
						} else if(isset($this->response['messages'][0]['messageCodeLocale'])){
							$this->error .= "Error: " . $this->response['messages'][0]['messageCodeLocale'];
							$this->ref = '';
						} else {  
							$this->ref = $this->response['result'][0]['ref'];
						}	
					}
				}
			}
		}
	}
	
	public function logout() {
		$url = $this->urlBase."REST/UserLoginWS/userLogout";
		curl_setopt($this->ch, CURLOPT_URL, $url);
		curl_setopt($this->ch, CURLOPT_POST, false);
		$this->response = curl_exec($this->ch);
	}
	
	public function login() {
		$url = $this->urlBase."REST/UserLoginWS/userLoginCompany";
		$params = array('userCode' => $this->usernameLogin, 
						'password' => $this->passwordLogin, 
						'applicationType' => $this->appTypeLogin,
						'company' => $this->companyLogin
						);
		$query = http_build_query ($params);
		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_URL, $url);
		curl_setopt($this->ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
		curl_setopt($this->ch, CURLOPT_POST, true);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $query);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->ch, CURLOPT_COOKIESESSION, true);
		curl_setopt($this->ch, CURLOPT_COOKIEJAR, ''); 
		curl_setopt($this->ch, CURLOPT_COOKIEFILE, '');  
		$this->response = curl_exec($this->ch);
		$this->response = json_decode($this->response, true);
	}
	
	
	
}