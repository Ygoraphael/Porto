<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ponto extends CI_Controller {

    function __construct() {
        parent::__construct();
       
    }

    //(Entrada Serviço/Saída Serviço) e (Començar Tarefa/Fechar Tarefa)
    function index() {
		$this->load->helper('url');	
		$this->load->model('user_model', 'user');
        $this->load->model('dossier_model', 'dossier');
        $this->load->model('nci_model', 'nci');	
        $_SESSION['token_temp'] = bin2hex(openssl_random_pseudo_bytes(16));
		$u_ncidefParams = array();
		$u_ncidef = $this->nci->getU_ncidef( $u_ncidefParams );
        $data = array();
        $data["u_ncidef"] = $u_ncidef[0];
		if($data["u_ncidef"]['iniciar_tarefas'] == 1){	
			if( $data["u_ncidef"]['tarefastipo'] == 0 ){
			
				$_SESSION['tarefa'] = "ponto/tarefa_dytable";

			}elseif( $data["u_ncidef"]['tarefastipo'] == 1 ){

				$_SESSION['tarefa'] = "ponto/tarefa_tabela";

			}elseif( $data["u_ncidef"]['tarefastipo'] == 2 ){

				$_SESSION['tarefa'] = "ponto/tarefa_dossier/all";
				
			}elseif( $data["u_ncidef"]['tarefastipo'] == 3){
				
				$_SESSION['tarefa'] = "ponto/tarefas_artigos";
			}
		}else{
			$_SESSION['tarefa'] = "ponto/tarefa";
		}
			$this->load->view('ponto/ponto');
    }

    public function entrada() {

        $this->load->library('form_validation');
        $this->load->model('Ponto_model');
        $this->load->helper('url');

        $_SESSION['token_temp'] = '';
        $this->form_validation->set_rules('cod_trabalhador', 'Cod_Cartón', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('ponto/entrada');
        } else {
            if ($this->input->post('cod_trabalhador')) {

                $cod_trabalhador = $this->input->post('cod_trabalhador');
                $result = $this->Ponto_model->search_in($cod_trabalhador);

                if ($result) {
                    $data = array();
                    $this->cronometro(base_url() . "ponto", 2);
                    $data['trabalhador'] = $result;
                    $this->load->view('ponto/error_in', $data);
                } else {
                    $data = array();
                    $result = $this->Ponto_model->dados_tl($cod_trabalhador);
                    $data['trabalhador'] = $result;
                    $this->cronometro(base_url() . "ponto", 2);
                    $rest = $this->Ponto_model->save_in($data);
                    $this->load->view('ponto/welcome', $data);
                }
            } else {
                redirect("ponto/entrada");
            }
        }
    }

    public function saida() {

        $this->load->library('form_validation');
        $this->load->model('Ponto_model');
        $this->load->helper('url');

        $this->form_validation->set_rules('cod_trabalhador', 'Cod_Cartón', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('ponto/saida');
        } else {

            if ($this->input->post('cod_trabalhador')) {

                $cod_trabalhador = $this->input->post('cod_trabalhador');
                $result = $this->Ponto_model->search_out($cod_trabalhador);

                if (!$result) {
                    $data = array();
                    $this->cronometro(base_url() . "ponto", 2);
                    $result2 = $this->Ponto_model->dados_tl($cod_trabalhador);
                    $data['trabalhador'] = $result2;
                    $this->load->view('ponto/error_out', $data);
                } else {

                    $result2 = $this->Ponto_model->tarefa_out($cod_trabalhador);

                    if ($result2) {
                        $data = array();
                        $this->cronometro(base_url() . "ponto", 2);
                        $result2 = $this->Ponto_model->dados_tl($cod_trabalhador);
                        $data['trabalhador'] = $result2;
                        $this->load->view('ponto/error_out2', $data);
                    } else {
                        $result = $this->Ponto_model->dados_tl($cod_trabalhador);
                        $data = array();
                        $data['trabalhador'] = $result;
                        $this->cronometro(base_url() . "ponto", 2);
                        $rest = $this->Ponto_model->save_out($data);
                        $this->load->view('ponto/goodbye', $data);
                    }
                }
            } else {
                redirect("ponto/saida");
            }
        }
    }

    public function tarefa() {

        $this->load->library('form_validation');
        $this->load->model('Ponto_model');
        $this->load->helper('url');

        $this->form_validation->set_rules('cod_trabalhador', 'Cod_Cartón', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('ponto/tarefa');
        } else {
            if ($this->input->post('cod_trabalhador')) {

                $cod_trabalhador = $this->input->post('cod_trabalhador');
                $result = $this->Ponto_model->search_in($cod_trabalhador);

                if (!$result) {
                    $data = array();
                    $result = $this->Ponto_model->dados_tl($cod_trabalhador);
                    $this->cronometro(base_url() . "ponto", 2);
                    $data['trabalhador'] = $result;
                    $this->load->view('ponto/error_in_tarefa', $data);
                } else {

                    //Se tiver entrada deve ser verificado se tem uma tarefa aberta
                    $result = $this->Ponto_model->search_tarefa($cod_trabalhador);

                    if ($result) {
                        $data = array();
                        $this->cronometro(base_url() . "ponto", 2);

                        $result2 = $this->Ponto_model->dados_tl($cod_trabalhador);
                        $data['trabalhador'] = $result2;
                        $this->load->view('ponto/error_in_tarefa2', $data);
                    } else {
                        $data = array();
                        $result = $this->Ponto_model->dados_tl($cod_trabalhador);
                        $data['trabalhador'] = $result;
                        $this->cronometro(base_url() . "ponto", 2);
                        $rest = $this->Ponto_model->save_in_tarefa($data);
                        $this->load->view('ponto/wellcome_tarefa', $data);
                    }
                }
            } else {
                redirect("ponto/tarefa");
            }
        }
    }

	public function tarefa_dytable(){
       $this->load->model('Ponto_model');
       $this->load->helper('url');
		
        $data = array();
        $result = $this->Ponto_model->get_dytable();
		 if ($result) {
            $data['campos'] = $result;
			$this->cronometro(base_url() . "ponto", 60);
            $this->load->view('ponto/tarefas_dytable', $data);
        } else {
            $this->load->view('ponto/tarefas_dytable', $data);
        }
    }
	
	public function tarefa_tabela(){
       $this->load->model('Ponto_model');
       $this->load->helper('url');
		
        $data = array();
        $result = $this->Ponto_model->get_produtos_tabela();
		 if ($result) {
            $data['designs'] = $result;
			$this->cronometro(base_url() . "ponto", 60);
            $this->load->view('ponto/tarefas_tabela', $data);
        } else {
            $this->load->view('ponto/tarefas_tabela', $data);
        }
    }
	
	public function tarefa_dossier(){
		$this->load->model('Ponto_model');
		$this->load->helper('url');
		$data = array();	
		$filter = $this->uri->segment(3);
		$data['filter'] = $filter;
		if( $filter == 'all' ){
			$filters = '';
		}else{
			$filters = $_GET['d'];
		}
        $result = $this->Ponto_model->get_produtos_dossier($filters);
		
		 if ($result) {
            $data['designs'] = $result;
			$this->cronometro(base_url() . "ponto", 60);
            $this->load->view('ponto/tarefas_dossier', $data);
        } else {
			$data['designs'] = '';
            $this->load->view('ponto/tarefas_dossier', $data);
        }
	}
	
	public function tarefas_artigos(){
		$this->load->library('form_validation');
		$this->load->model('Ponto_model');
		$this->load->helper('url');
		$data = array();
		$result = $this->Ponto_model->get_familias();

		if ($result) {
			$data['familias'] = $result;

			$temp = $resp = $this->Ponto_model->get_cart();
			$data['temp'] = $temp;

			$this->load->view('ponto/tarefas_artigos', $data);
		} else {
			$this->load->view('ponto/tarefas_artigos', $data);
		}
	}
	
	  public function tarefas_artigos_produtos() {

        $this->load->library('form_validation');
        $this->load->model('Ponto_model');
        $this->load->helper('url');
        $ref = $this->uri->segment(3);
        $result = $this->Ponto_model->get_familia_produtos($ref);
        $data = array();

        if ($result) {
            $data['produtos'] = $result;

            $temp = $resp = $this->Ponto_model->get_cart();
            $data['temp'] = $temp;

            $this->load->view('ponto/tarefas_artigos_produtos', $data);
        } else {
            $this->load->view('ponto/ponto', $data);
        }
    }
	
	

	public function registo_tarefasDytable(){
		$this->load->library('form_validation');
		$this->load->model('Ponto_model');
		$this->load->helper('url');
		$data = array();
		$dytablestamp = $this->uri->segment(3);
		$this->form_validation->set_rules('cod_trabalhador', 'Cod_Cartón', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('ponto/tarefa_popup');
		}else{
			if ($this->input->post('cod_trabalhador')) {
				$cod_trabalhador = $this->input->post('cod_trabalhador');
				$result = $this->Ponto_model->search_in($cod_trabalhador);
				if (!$result) {
					$data = array();
					$result = $this->Ponto_model->dados_tl($cod_trabalhador);
					$data['trabalhador'] = $result;
					$this->load->view('ponto/error_in_tarefa_modal', $data);
				} else {
					$result = $this->Ponto_model->search_tarefa($cod_trabalhador);
					
					if (!empty($result)) {
					$result2 = $this->Ponto_model->dados_tl($cod_trabalhador);
					$data['trabalhador'] = $result2;
					$this->load->view('ponto/error_in_tarefa_dytable', $data);
					}else{
					$cod_trabalhador = $this->input->post('cod_trabalhador');
					$result = $this->Ponto_model->dados_tl($cod_trabalhador);
					foreach($result as $resp){
						$nome = $resp['username'];
					}
					$this->Ponto_model->registo_tarefas($nome,$dytablestamp,$cod_trabalhador);
					$data['trabalhador'] = $result;			
					$this->load->view('ponto/wellcome_tarefa_dytable', $data);	
					}
				}	
			}
		}

	}
	
	public function registo_tarefasTabela(){
		$this->load->library('form_validation');
		$this->load->model('Ponto_model');
		$this->load->helper('url');
		$data = array();
		$produtostamp = $this->uri->segment(3);
		$this->form_validation->set_rules('cod_trabalhador', 'Cod_Cartón', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('ponto/tarefa_popup');
		}else{
			if ($this->input->post('cod_trabalhador')) {
				$cod_trabalhador = $this->input->post('cod_trabalhador');
				$result = $this->Ponto_model->search_in($cod_trabalhador);
				if (!$result) {
					$data = array();
					$result = $this->Ponto_model->dados_tl($cod_trabalhador);
					$data['trabalhador'] = $result;
					$this->load->view('ponto/error_in_tarefa_modal', $data);
				} else {
					$result = $this->Ponto_model->search_tarefa($cod_trabalhador);
					if ($result) {
					$result2 = $this->Ponto_model->dados_tl($cod_trabalhador);
					$data['trabalhador'] = $result2;
					$this->load->view('ponto/error_in_tarefa_dytable', $data);
					}else{
					$cod_trabalhador = $this->input->post('cod_trabalhador');
					$result = $this->Ponto_model->dados_tl($cod_trabalhador);
					foreach($result as $resp){
						$nome = $resp['username'];
					}
					$this->Ponto_model->registo_tarefas($nome,$produtostamp,$cod_trabalhador);
					$data['trabalhador'] = $result;			
					$this->load->view('ponto/wellcome_tarefa_dytable', $data);	
					}
				}	
			}
		}
	}
	
	public function registo_tarefasDossier(){
		$this->load->library('form_validation');
		$this->load->model('Ponto_model');
		$this->load->helper('url');
		$data = array();
		$bistamp = $this->uri->segment(3);
		$this->form_validation->set_rules('cod_trabalhador', 'Cod_Cartón', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('ponto/tarefa_popup');
		}else{
			if ($this->input->post('cod_trabalhador')) {
				$cod_trabalhador = $this->input->post('cod_trabalhador');
				$result = $this->Ponto_model->search_in($cod_trabalhador);
				if (!$result) {
					$data = array();
					$result = $this->Ponto_model->dados_tl($cod_trabalhador);
					$data['trabalhador'] = $result;
					$this->load->view('ponto/error_in_tarefa_modal', $data);
				} else {	
					$result = $this->Ponto_model->search_tarefa($cod_trabalhador);
					if ($result) {
					$result2 = $this->Ponto_model->dados_tl($cod_trabalhador);
					$data['trabalhador'] = $result2;
					$this->load->view('ponto/error_in_tarefa_dytable', $data);
					}else{
					$cod_trabalhador = $this->input->post('cod_trabalhador');
					$result = $this->Ponto_model->dados_tl($cod_trabalhador);
					foreach($result as $resp){
						$nome = $resp['username'];
					}
					
					$this->Ponto_model->registo_tarefas($nome,$bistamp,$cod_trabalhador);
					$data['trabalhador'] = $result;			
					$this->load->view('ponto/wellcome_tarefa_dytable', $data);	
					}
				}	
			}
		}
	}
	
    public function familias() {
		$this->load->library('form_validation');
		$this->load->model('Ponto_model');
		$this->load->helper('url');
        $this->load->model('dossier_model', 'dossier');
        $this->load->model('nci_model', 'nci');	
		$u_ncidefParams = array();
		$u_ncidef = $this->nci->getU_ncidef( $u_ncidefParams );
        $data = array();
        $data["u_ncidef"] = $u_ncidef[0];

		if($data["u_ncidef"]['iniciar_tarefas'] == 1){	
			if( $data["u_ncidef"]['tarefa_registo_stipo'] == 0 ){

				$this->form_validation->set_rules('cod_trabalhador', 'Cod_Cartón', 'required');
				$this->form_validation->set_error_delimiters('<p class="error">', '</p>');

				if ($this->form_validation->run() == FALSE) {
					$this->load->view('ponto/entrada');
				}else{
					if ($this->input->post('cod_trabalhador')) {
						$cod_trabalhador = $this->input->post('cod_trabalhador');
					    $result = $this->Ponto_model->search_in($cod_trabalhador);
						if (!$result) {
							$data = array();
							$result = $this->Ponto_model->dados_tl($cod_trabalhador);
							$this->cronometro(base_url() . "ponto", 2);
							$data['trabalhador'] = $result;
							$this->load->view('ponto/error_in_tarefa_modal_fecharTarefa', $data);
						} else {	
							$result = $this->Ponto_model->get_tarefas($cod_trabalhador);
							$trabalhador = $this->Ponto_model->dados_tl($cod_trabalhador);
							$data['trabalhador'] = $trabalhador;
							$temp = $resp = $this->Ponto_model->get_cart();
							$data['temp'] = $temp;
							if($result){
								$data['produtos'] = $result;
								if( $data["u_ncidef"]['tarefastipo'] == 0 ){
									$this->load->view('ponto/produto_dytable', $data);
								}elseif( $data["u_ncidef"]['tarefastipo'] == 1 ){
									$this->load->view('ponto/produto_tabela', $data);
								}elseif( $data["u_ncidef"]['tarefastipo'] == 2 ){
									$this->load->view('ponto/produto_dossier', $data);
								}else{
									$this->load->view('ponto/produto_artigos', $data);
								}	
							}else{
							$this->cronometro(base_url() . "ponto", 2);	
							$this->load->view('ponto/no_tarefa_dytable', $data);
							}
						}
					}
				}
			}else{
				
				$this->form_validation->set_rules('cod_trabalhador', 'Cod_Cartón', 'required');
				$this->form_validation->set_error_delimiters('<p class="error">', '</p>');

				if ($this->form_validation->run() == FALSE) {
					$this->load->view('ponto/entrada');
				}else{
					if ($this->input->post('cod_trabalhador')) {
					$cod_trabalhador = $this->input->post('cod_trabalhador');
					$result = $this->Ponto_model->search_in($cod_trabalhador);
						if (!$result) {
							$data = array();
							$result = $this->Ponto_model->dados_tl($cod_trabalhador);
							$this->cronometro(base_url() . "ponto", 2);
							$data['trabalhador'] = $result;
							$this->load->view('ponto/error_in_tarefa_modal_fecharTarefa', $data);
						} else {						
							$result = $this->Ponto_model->get_tarefas($cod_trabalhador);
							$temp = $resp = $this->Ponto_model->get_cart();
							$data['temp'] = $temp;
							$trabalhador = $this->Ponto_model->dados_tl($cod_trabalhador);
							$data['trabalhador'] = $trabalhador;
							if($result){
								$data['produtos'] = $result;
								if( $data["u_ncidef"]['tarefastipo'] == 0 ){
									$this->load->view('ponto/produto_dytable', $data);
								}elseif( $data["u_ncidef"]['tarefastipo'] == 1 ){
									$this->load->view('ponto/produto_tabela', $data);
								}elseif( $data["u_ncidef"]['tarefastipo'] == 2 ){
									$this->load->view('ponto/produto_dossier', $data);
								}else{
									$this->load->view('ponto/produto_artigos', $data);
								}
							}else{ 
							$this->cronometro(base_url() . "ponto", 2);
								$this->load->view('ponto/no_tarefa_dytable', $data);
							}
						}
					}
				}	

			}

		}else{		
			$data = array();
			$result = $this->Ponto_model->get_familias();

			if ($result) {
				$data['familias'] = $result;

				$temp = $resp = $this->Ponto_model->get_cart();
				$data['temp'] = $temp;

				$this->load->view('ponto/familias', $data);
			} else {
				$this->load->view('ponto/familias', $data);
			}
		}
    }

    public function familia() {

        $this->load->library('form_validation');
        $this->load->model('Ponto_model');
        $this->load->helper('url');
        $ref = $this->uri->segment(3);
        $result = $this->Ponto_model->get_familia_produtos($ref);
        $data = array();

        if ($result) {
            $data['produtos'] = $result;

            $temp = $resp = $this->Ponto_model->get_cart();
            $data['temp'] = $temp;

            $this->load->view('ponto/familia', $data);
        } else {
            $this->load->view('ponto/ponto', $data);
        }
    }

    public function add_product() {
        $this->load->model('Ponto_model');
        $this->load->helper('url');
        $qtt = $_POST['qtt'];
        $ststamp = $_POST['ststamp'];
        $stfamistamp = $_POST['stfamistamp'];
        $this->Ponto_model->add_product_cart($ststamp, $qtt);
    }
	
	// Fechar tarefa (modo artigos)
    public function add_product2() {
        $this->load->model('Ponto_model');
        $this->load->helper('url');
		$qtt = $_POST['qtt'];
		$ststamp = $_POST['ststamp'];
		$stfamistamp = $_POST['stfamistamp'];	
        $this->Ponto_model->add_product_cart2($ststamp, $qtt);
  
    }
	
	public function product_dytable() {
        $this->load->model('Ponto_model');
		$u_codcart = $_POST['u_codcart'];
		$dytablestamp = $_POST['dytablestamp'];
		$this->cronometro(base_url() . "ponto", 2);
        $result = $this->Ponto_model->update_product($u_codcart, $dytablestamp);
		if($result){
			$name = $this->Ponto_model->dados_tl($u_codcart);
			$data3['name']=$name;
			$this->load->view('ponto/sv_tarefa_others', $data3);
		}
    }
	
	public function product_tabela() {
        $this->load->model('Ponto_model');
		$u_codcart = $_POST['u_codcart'];
		$produtostamp = $_POST['produtostamp'];
		$this->cronometro(base_url() . "ponto", 2);
        $result = $this->Ponto_model->update_product($u_codcart, $produtostamp);
		if($result){
			$name = $this->Ponto_model->dados_tl($u_codcart);
			$data3['name']=$name;
			$this->load->view('ponto/sv_tarefa_others', $data3);
		}
    }
	
	
	public function product_dossier(){
		$this->load->model('Ponto_model');
		$u_codcart = $_POST['u_codcart'];
		$bistamp = $_POST['bistamp'];
		$this->cronometro(base_url() . "ponto", 2);
        $result = $this->Ponto_model->update_product($u_codcart, $bistamp);
		if($result){
			$name = $this->Ponto_model->dados_tl($u_codcart);
			$data3['name']=$name;
			$this->load->view('ponto/sv_tarefa_others', $data3);
		}
    }	
	
    public function cronometro($url, $segundos) {

        if (!$segundos) {
            $segundos = 0;
        }
        echo '<meta http-equiv="refresh" content="' . $segundos . '; url=' . $url . '" />';
    }

	// Ao sair de "Fechar Tarefa"
    public function delete_tmp_tarefa() {
        $tmp = $this->uri->segment(3);
        $this->load->model('Ponto_model');
        $this->Ponto_model->delete_tmp_tarefa($tmp);

        redirect('ponto');
    }

	//apagar tarefas desde "familia e familias = cart"
    public function delete_tmp_tarefa2() {
        $ref = $this->uri->segment(3);
        $this->load->model('Ponto_model');
        $this->Ponto_model->delete_tmp_tarefa2($ref);
        redirect('ponto/familias');
    }

	// Apagar tarefas tmp desde Carrinha
    public function delete_tmp_tarefa3() {
        $ref = $this->uri->segment(3);
        $this->load->model('Ponto_model');
        $this->Ponto_model->delete_tmp_tarefa2($ref);
        redirect('ponto/cart');
	}
	
	//apagar tarefas desde "Tarefas_artigos e Tarefas_artigos_productos = cart_artigos"
	public function delete_tmp_tarefa4(){
		$ref = $this->uri->segment(3);
	    $this->load->model('Ponto_model');
        $this->Ponto_model->delete_tmp_tarefa2($ref);
		redirect('ponto/tarefas_artigos');
	}
	
	// Apagar tarefas tmp desde Carrinha_artigos
	public function delete_tmp_tarefa5(){
		$ref = $this->uri->segment(3);
	    $this->load->model('Ponto_model');
        $this->Ponto_model->delete_tmp_tarefa2($ref);
        
		redirect('ponto/cart_artigos');
	}
	
	//apagar tarefas desde "Fechar Tarefas_artigos e Tarefas_artigos_productos = cart_artigos"
	public function delete_tmp_tarefa6(){
	    $this->load->model('Ponto_model');
		$ref = $this->uri->segment(3);
        $result = $this->Ponto_model->delete_tmp_tarefa2($ref);
		
		if ( $result ){
			$this->response['valor']= TRUE;
			echo json_encode($this->response);
		}

    }

    public function cart() {
        $this->load->model('Ponto_model');
        $data = array();

        $temp = $resp = $this->Ponto_model->get_cart();
        if ($temp) {

            $data['temp'] = $temp;
            $this->load->view('ponto/carrinha', $data);
        } else {
            $this->load->view('ponto/no_tarefa', $data);
        }
    }
	
	//Comenzar Tarefa (modo Artigos)
	public function cart_artigos(){
	    $this->load->model('Ponto_model');
		$data = array();

		$temp = $resp = $this->Ponto_model->get_cart();
		if($temp){
			
			$data['temp'] = $temp;
			$this->load->view('ponto/carrinha_artigos', $data);
		}else{
           $this->load->view('ponto/no_tarefa', $data);
		}
	}

	//Fechar Tarefa (modo Artigos)
	public function cat_artigos(){
	    $this->load->model('Ponto_model');
		$data = array();
		$count_prod = $_SESSION['count_temp'];
		$cod_trabalhador = $_SESSION['cod_trabalhador_temp'];

		$temp = $resp = $this->Ponto_model->get_cart();
		if($temp){
			
			$data['count_prod'] = $count_prod;
			$data['cod_trabalhador'] = $cod_trabalhador;
			$data['temp'] = $temp;
			$this->load->view('ponto/carrinha_fechar_artigos', $data);
		}else{
           $this->load->view('ponto/no_tarefa', $data);
		}
	}

    public function popup_qtt() {
        $data = array();
        $stfamistamp = $this->uri->segment(3);
        $ststamp = $this->uri->segment(4);
        $data['stfamistamp'] = $stfamistamp;
        $data['ststamp'] = $ststamp;
        $this->load->view('ponto/popup_qtt', $data);
    }

	public function artigos_qtt(){
		$data = array();
		$tarefastamp = $this->uri->segment(3);
		$ststamp = $this->uri->segment(4);
		$qtt = $this->uri->segment(5);
		$data['tarefastamp'] = $tarefastamp;
		$data['ststamp'] = $ststamp;
		$data['qtt'] = (int)$qtt;
		$this->load->view('ponto/artigos_qtt', $data);
	}
		
    public function save_tarefa() {

        $this->load->library('form_validation');
        $this->load->model('Ponto_model');
        $this->load->helper('url');
        $this->load->model('dossier_model', 'dossier');
        $this->load->model('nci_model', 'nci');	
		$u_ncidefParams = array();
		$u_ncidef = $this->nci->getU_ncidef( $u_ncidefParams );
        $data = array();
        $data["u_ncidef"] = $u_ncidef[0];

		if($data["u_ncidef"]['iniciar_tarefas'] == 1){	
			if( $data["u_ncidef"]['tarefa_registo_stipo'] == 0 ){
					
				$data = array();
				$data3 = array();
				$this->form_validation->set_rules('cod_trabalhador', 'Cod_Cartón', 'required');
				$this->form_validation->set_error_delimiters('<p class="error">', '</p>');

				if ($this->form_validation->run() == FALSE) {
					$this->load->view('ponto/tarefa_popup');
				} else {
					if ($this->input->post('cod_trabalhador')) {

						$cod_trabalhador = $this->input->post('cod_trabalhador');
						$result = $this->Ponto_model->search_in($cod_trabalhador);
						
						if (!$result) {
							$data = array();
							$result = $this->Ponto_model->dados_tl($cod_trabalhador);
							$data['trabalhador'] = $result;
							$this->load->view('ponto/error_in_tarefa_modal', $data);
						} else {
							$result = $this->Ponto_model->search_tarefa($cod_trabalhador);

							if (empty($result)) {
								$temp = $resp = $this->Ponto_model->get_cart();
								$data2=$temp;
								$result2 = $this->Ponto_model->dados_tl($cod_trabalhador);
								$this->Ponto_model->update_tarefa_dossier($result2,$data2);
								$data3['name']=$result2;
								$tmp = $_SESSION['token_temp'];
								$this->Ponto_model->delete_tmp_tarefa($tmp);
								$this->load->view('ponto/sv_tarefa', $data3);					
							}else {
								$result = $this->Ponto_model->dados_tl($cod_trabalhador);
								$data['trabalhador'] = $result;
								$tmp = $_SESSION['token_temp'];
								$this->Ponto_model->delete_tmp_tarefa($tmp);
								$this->load->view('ponto/error_in_tarefa3', $data);
							}
						}	
					}
				}
			}else{
				$data = array();
				$data3 = array();
				$this->form_validation->set_rules('cod_trabalhador', 'Cod_Cartón', 'required');
				$this->form_validation->set_error_delimiters('<p class="error">', '</p>');

				if ($this->form_validation->run() == FALSE) {
					$this->load->view('ponto/tarefa_popup');
				}else{
					if ($this->input->post('cod_trabalhador')) {

						$cod_trabalhador = $this->input->post('cod_trabalhador');
						$result = $this->Ponto_model->search_in($cod_trabalhador);
						
						if (!$result) {
							$data = array();
							$result = $this->Ponto_model->dados_tl($cod_trabalhador);
							$data['trabalhador'] = $result;
							$this->load->view('ponto/error_in_tarefa_modal', $data);
						} else {
							$result = $this->Ponto_model->search_tarefa($cod_trabalhador);

							if (empty($result)) {
								$temp = $resp = $this->Ponto_model->get_cart();
								$data2=$temp;
								$name = $this->Ponto_model->update_tarefa_tabela($cod_trabalhador,$data2);
								$data3['name']=$name;
								$tmp = $_SESSION['token_temp'];
								$this->Ponto_model->delete_tmp_tarefa($tmp);
								$this->load->view('ponto/sv_tarefa', $data3);					
							}else{
								$result = $this->Ponto_model->dados_tl($cod_trabalhador);
								$data['trabalhador'] = $result;
								$tmp = $_SESSION['token_temp'];
								$this->Ponto_model->delete_tmp_tarefa($tmp);
								$this->load->view('ponto/error_in_tarefa_dytable', $data);
							}
						}	
					}
				}
			}
		
		}else{			
			$data = array();
			$data3 = array();
			$this->form_validation->set_rules('cod_trabalhador', 'Cod_Cartón', 'required');
			$this->form_validation->set_error_delimiters('<p class="error">', '</p>');

			if ($this->form_validation->run() == FALSE) {
				$this->load->view('ponto/tarefa_popup');
			}else{
				if ($this->input->post('cod_trabalhador')) {

					$cod_trabalhador = $this->input->post('cod_trabalhador');
					$result = $this->Ponto_model->search_tarefa($cod_trabalhador);

					if ($result) {
						foreach($result as $resp){
							$data['trabalhador']=$resp;
						}
						$temp = $resp = $this->Ponto_model->get_cart();
						$data2 = $temp;
						$name = $this->Ponto_model->update_tmp_produtos($data,$data2);
						$data3['name']=$name;
						$tmp = $_SESSION['token_temp'];
						$this->Ponto_model->delete_tmp_tarefa($tmp);
						$this->load->view('ponto/sv_tarefa', $data3);					
					}else {
						$result = $this->Ponto_model->dados_tl($cod_trabalhador);
						$data['trabalhador'] = $result;
						$tmp = $_SESSION['token_temp'];
						$this->Ponto_model->delete_tmp_tarefa($tmp);
						$this->load->view('ponto/error_in_tarefa3', $data);
					}
				}else{
					redirect("ponto/no_tarefa");
				}
			}
		}	
	}
		
	public function save_fechar_tarefa(){
		$this->load->library('form_validation');
        $this->load->model('Ponto_model');
        $this->load->helper('url');
        $this->load->model('dossier_model', 'dossier');
        $this->load->model('nci_model', 'nci');	
		$u_ncidefParams = array();
		$u_ncidef = $this->nci->getU_ncidef( $u_ncidefParams );
        $data = array();
        $data["u_ncidef"] = $u_ncidef[0];

		if($data["u_ncidef"]['iniciar_tarefas'] == 1){	
			if( $data["u_ncidef"]['tarefa_registo_stipo'] == 0 ){
				
				$data2 = array();
				$data3 = array();
				$status = $_POST['status']; 
				$cod_trabalhador = $_POST['cod_trabalhador'];
				$result = $this->Ponto_model->search_tarefa($cod_trabalhador);
				foreach($result as $resp){
					$data2['trabalhador']=$resp;
				}
				$tarefas = $resp = $this->Ponto_model->get_cart();
				if( $status == 0 ){
				$name = $this->Ponto_model->fechar_tarefa_artigos_todas($data2,$tarefas);
				$data3['name']=$name;
				$tmp = $_SESSION['token_temp'];
				$this->Ponto_model->delete_tmp_tarefa($tmp);
				} else {					
				$name = $this->Ponto_model->fechar_tarefa_artigos_parte($data2,$tarefas);
				$data3['name']=$name;
				$tmp = $_SESSION['token_temp'];
				$this->Ponto_model->delete_tmp_tarefa($tmp);
                }
            } else {
				$data2 = array();
				$data3 = array();
				$status = $_POST['status']; 
				$cod_trabalhador = $_POST['cod_trabalhador'];
				$result = $this->Ponto_model->search_tarefa($cod_trabalhador);
				foreach($result as $resp){
					$data2['trabalhador']=$resp;
				}
				$tarefas = $resp = $this->Ponto_model->get_cart();
				if( $status == 0 ){
					
				$name = $this->Ponto_model->fechar_tarefa_artigos_todas($data2,$tarefas);
				$data3['name']=$name;
				$tmp = $_SESSION['token_temp'];
				$this->Ponto_model->delete_tmp_tarefa($tmp);
				$this->cronometro(base_url() . "ponto", 2);
				$this->load->view('ponto/sv_tarefa', $data3);
				} else {
					
				$name = $this->Ponto_model->fechar_tarefa_artigos_parte($data2,$tarefas);
				$data3['name']=$name;
				$tmp = $_SESSION['token_temp'];
				$this->Ponto_model->delete_tmp_tarefa($tmp);
				$this->cronometro(base_url() . "ponto", 2);
				$this->load->view('ponto/sv_tarefa', $data3);
				}
			}
		}		
	}

	public function sv_tarefa_dossier(){
		$this->load->library('form_validation');
        $this->load->model('Ponto_model');
        $this->load->helper('url');
		$valor = $this->uri->segment(3);
		if ( $valor == 0 ){
			redirect('ponto/sv_tarefa_dossier_complete');
		}else{
			redirect('ponto/sv_tarefa_dossier_part');
		}
		
	}

	public function sv_tarefa_dossier_complete(){
		$this->load->library('form_validation');
        $this->load->model('Ponto_model');
        $this->load->helper('url');
		$cod_trabalhador = $_SESSION['cod_trabalhador_temp'];
		$data = array();
		$data['name'] = $this->Ponto_model->dados_tl($cod_trabalhador);
		$this->load->view('ponto/sv_tarefa_dossier_complete', $data);
	}
	
	public function sv_tarefa_dossier_part(){
		$this->load->library('form_validation');
        $this->load->model('Ponto_model');
        $this->load->helper('url');
		$cod_trabalhador= $_SESSION['cod_trabalhador_temp'];
		$data = array();
		$data['name'] = $this->Ponto_model->dados_tl($cod_trabalhador);
		$this->load->view('ponto/sv_tarefa_dossier_part', $data);
	}
}


