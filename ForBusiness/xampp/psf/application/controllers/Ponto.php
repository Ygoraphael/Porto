<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ponto extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Ponto_model');
        $this->load->model('nci_model', 'nci');
    }

    //(Entrada Servico/Saida Servico) e (Comecar Tarefa/Fechar Tarefa)
    function index() {
        $this->load->helper('url');
        $this->load->model('user_model', 'user');

        $data = array();
        $_SESSION['token_temp'] = bin2hex(openssl_random_pseudo_bytes(16));
        $data["u_ncidef"] = $this->nci->getU_ncidef(array())[0];

        //escolhe tarefa ao iniciar tarefa
        if ($data["u_ncidef"]['iniciar_tarefas'] == 1) {
            $data['inittarefa'] = "ponto/tarefas";
            $data['endtarefa'] = "ponto/tarefa";
        }
        //escolhe tarefa ao finalizar tarefa
        else {
            $data['inittarefa'] = "ponto/tarefa";
            $data['endtarefa'] = "ponto/tarefas";
        }

        $this->load->view('ponto/ponto', $data);
    }

    //ponto entrada ao servico
    public function entrada() {
        $this->load->library('form_validation');
        $this->load->model('Ponto_model');
        $this->load->helper('url');
        $data = array();

        $_SESSION['token_temp'] = '';
        $this->form_validation->set_rules('cod_trabalhador', 'Cod_Cartón', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        $data["u_ncidef"] = $this->nci->getU_ncidef(array())[0];
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('ponto/entrada', $data);
        } else {
            $this->cronometro(base_url() . "ponto", 2);
            
            //Verifica o preenchimento do código do trabalhador
            if ($this->input->post('cod_trabalhador')) {

                $cod_trabalhador = $this->input->post('cod_trabalhador');
                $data['trabalhador'] = $this->Ponto_model->dados_tl($cod_trabalhador);
                $ultimo_registo_ponto = $this->Ponto_model->search_in($cod_trabalhador);
               
                
                if(!$data['trabalhador']){
                    
                    $this->load->view('ponto/error/erro_nao_existe_trabalhador', $data);
                    
                }else{
                    
                    //verifica se existe uma entrada ao serviço
                    if (count($ultimo_registo_ponto) && $ultimo_registo_ponto[0]["litem"] == "ENTRADA") {
                        $data["entrada"] = $ultimo_registo_ponto;
                        $this->load->view('ponto/error/erro_tem_entrada', $data);
                    } else {
                        $this->Ponto_model->save_ponto("ENTRADA", $data);
                        $this->load->view('ponto/success/welcome', $data);
                    }
                }
                
                
            } else {
                redirect("ponto/entrada");
            }
        }
    }

    //ponto saida do servico
    public function saida() {

        $this->load->library('form_validation');
        $this->load->model('Ponto_model');
        $this->load->helper('url');

        $this->form_validation->set_rules('cod_trabalhador', 'Cod_Cartón', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        $data = array();
        $data["u_ncidef"] = $this->nci->getU_ncidef(array())[0];
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('ponto/saida', $data);
        }
        //cartao inserido
        else {
            $this->cronometro(base_url() . "ponto", 2);
            if ($this->input->post('cod_trabalhador')) {

                $cod_trabalhador = $this->input->post('cod_trabalhador');
                $data['trabalhador'] = $this->Ponto_model->dados_tl($cod_trabalhador);
                $ultimo_registo_ponto = $this->Ponto_model->search_in($cod_trabalhador);

                if(!$data['trabalhador']){
                    
                    $this->load->view('ponto/error/erro_nao_existe_trabalhador', $data);
                    
                }else{
                    
                    // Verifica se existe entrada ao serviço
                    if (!count($ultimo_registo_ponto) || (count($ultimo_registo_ponto) && $ultimo_registo_ponto[0]["litem"] == "SAIDA")) {
                        $result2 = $this->Ponto_model->dados_tl($cod_trabalhador);
                        $data['trabalhador'] = $result2;
                        $this->load->view('ponto/error/erro_nao_existe_entrada', $data);
                    } else {

                        //Verifica se existe uma tarefa a decorrer. Se for esse o caso,
                        //não será permitido sair.
                        $existe_tarefa = $this->Ponto_model->search_tarefa($cod_trabalhador);
                        if ($existe_tarefa) {
                            $this->load->view('ponto/error/erro_existe_tarefa_ativa', $data);
                        }
                        //nao existe tarefa ativa portanto pode sair
                        else {
                            $this->Ponto_model->save_ponto("SAIDA", $data);
                            $this->load->view('ponto/success/goodbye', $data);
                        }
                    } 
                }     
            } else {
                redirect("ponto/saida");
            }
        }
    }

    //registo de tarefa
    public function tarefa() {
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->form_validation->set_rules('cod_trabalhador', 'Cod_Cartón', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        $data = array();
        $data["u_ncidef"] = $this->nci->getU_ncidef(array())[0];

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('ponto/tarefa', $data);
        }
        //codigo cartao enviado
        else {
            //se codigo enviado corretamente
            if ($this->input->post('cod_trabalhador')) {
                $cod_trabalhador = $this->input->post('cod_trabalhador');
                $data['trabalhador'] = $this->Ponto_model->dados_tl($cod_trabalhador);

                if(!$data['trabalhador']){
                    $this->cronometro(base_url() . "ponto/tarefa", 2);
                    $this->load->view('ponto/error/erro_nao_existe_trabalhador', $data);
                    
                }else{
                    
                    //se escolher tarefa ao iniciar tarefa
                    if ($data["u_ncidef"]['iniciar_tarefas'] == 1) {
                        //aqui esta a fechar tarefa com tarefas previamente selecionadas
                        //tarefas cabecalho em aberto para este funcionario
                        $tarefasFuncionario = $this->Ponto_model->search_tarefa($cod_trabalhador);

                        // verifica se existem tarefas em aberto
                        if (!count($tarefasFuncionario)) {
                            $this->cronometro(base_url() . "ponto/tarefas", 2);
                            $this->load->view('ponto/error/erro_tem_adicionar_tarefa_ao_iniciar', $data);
                        } else {
                            $cart = array();

                            //Escolha do método de gravação dos registos
                            switch ($data["u_ncidef"]['tarefa_registo_stipo']) {
                                //guardar em dossier
                                //se tipo de registo -> 0 = dossier / 1 = tabela
                                case 0:
                                    $this->Ponto_model->update_tarefa_dossier($cod_trabalhador, $cart);
                                    break;
                                //guardar em tabela
                                case 1:
                                    $this->Ponto_model->update_tarefa_tabela($cod_trabalhador, $cart);
                                    break;
                            }
                            $this->cronometro(base_url() . "ponto", 2);
                            $this->load->view('ponto/success/inserted_task_ao_iniciar', $data);
                        }
                    }
                    //se escolher tarefa ao finalizar tarefa
                    else {
                        $this->cronometro(base_url() . "ponto", 2);
                        //aqui esta a iniciar tarefa sem tarefas
                        $result = $this->Ponto_model->search_in($cod_trabalhador);

                        //se nao existir entrada ponto de funcionario associado a este codigo
                        if (!count($result) || (count($result) && $result[0]["litem"] == "SAIDA")) {
                            $this->load->view('ponto/error/erro_sem_entrada', $data);
                        }
                        //se existir entrada ponto de funcionario associado a este codigo
                        else {
                            //Se tiver entrada deve ser verificado se tem uma tarefa aberta
                            $result = $this->Ponto_model->search_tarefa($cod_trabalhador);

                            //como existe tarefa em aberto, nao pode abrir outra
                            if ($result) {
                                $this->load->view('ponto/error/erro_tem_tarefa_aberta', $data);
                            }
                            //abre tarefa
                            else {
                                $this->Ponto_model->save_in_tarefa($data);
                                $this->load->view('ponto/welcome_tarefa', $data);
                            }
                        }
                    }
                    
                }
            } else {
                redirect("ponto/tarefa");
            }
        }
    }

    //fechar tarefa em tabela
    public function registo_tarefasTabela() {
        $this->load->library('form_validation');
        $this->load->model('Ponto_model');
        $this->load->helper('url');
        $data = array();
        $produtostamp = $this->uri->segment(3);
        $this->form_validation->set_rules('cod_trabalhador', 'Cod_Cartón', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('ponto/tarefa_popup');
        } else {
            //Verificação da existência de um trabalhador com o código inserido
            if ($this->input->post('cod_trabalhador')) {
                $cod_trabalhador = $this->input->post('cod_trabalhador');
                $result = $this->Ponto_model->search_in($cod_trabalhador);
                if (!$result) {
                    $data = array();
                    $result = $this->Ponto_model->dados_tl($cod_trabalhador);
                    $data['trabalhador'] = $result;
                    $this->load->view('ponto/error_in_tarefa_modal', $data);
                } else {
                    //Verificação da existência de tarefas com o código de trabalhador inserido
                    $result = $this->Ponto_model->search_tarefa($cod_trabalhador);
                    if ($result) {
                        $result2 = $this->Ponto_model->dados_tl($cod_trabalhador);
                        $data['trabalhador'] = $result2;
                        $this->load->view('ponto/error_in_tarefa_dytable', $data);
                    } else {
                        //Registo de uma tarefa associada ao código do trabalhador em questão
                        $cod_trabalhador = $this->input->post('cod_trabalhador');
                        $result = $this->Ponto_model->dados_tl($cod_trabalhador);
                        foreach ($result as $resp) {
                            $nome = $resp['username'];
                        }
                        $this->Ponto_model->registo_tarefas($nome, $produtostamp, $cod_trabalhador);
                        $data['trabalhador'] = $result;
                        $this->load->view('ponto/welcome_tarefa_dytable', $data);
                    }
                }
            }
        }
    }

    //fechar tarefa em dossier
    public function registo_tarefasDossier() {
        $this->load->library('form_validation');
        $this->load->model('Ponto_model');
        $this->load->helper('url');
        $data = array();
        $bistamp = $this->uri->segment(3);
        $this->form_validation->set_rules('cod_trabalhador', 'Cod_Cartón', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('ponto/tarefa_popup');
        } else {
            //Verificação da existência de um trabalhador com o código inserido
            if ($this->input->post('cod_trabalhador')) {
                $cod_trabalhador = $this->input->post('cod_trabalhador');
                $result = $this->Ponto_model->search_in($cod_trabalhador);
                if (!$result) {
                    $data = array();
                    $result = $this->Ponto_model->dados_tl($cod_trabalhador);
                    $data['trabalhador'] = $result;
                    $this->load->view('ponto/error_in_tarefa_modal', $data);
                } else {
                    //Verificação da existência de tarefas com o código de trabalhador inserido
                    $result = $this->Ponto_model->search_tarefa($cod_trabalhador);
                    if ($result) {
                        $result2 = $this->Ponto_model->dados_tl($cod_trabalhador);
                        $data['trabalhador'] = $result2;
                        $this->load->view('ponto/error_in_tarefa_dytable', $data);
                    } else {
                        //Registo de uma tarefa associada ao código do trabalhador em questão
                        $cod_trabalhador = $this->input->post('cod_trabalhador');
                        $result = $this->Ponto_model->dados_tl($cod_trabalhador);
                        foreach ($result as $resp) {
                            $nome = $resp['username'];
                        }
                        $this->Ponto_model->registo_tarefas($nome, $bistamp, $cod_trabalhador);
                        $data['trabalhador'] = $result;
                        $this->load->view('ponto/welcome_tarefa_dytable', $data);
                    }
                }
            }
        }
    }

    //fechar tarefa em dytable
    public function registo_tarefasDytable() {
        $this->load->library('form_validation');
        $this->load->model('Ponto_model');
        $this->load->helper('url');
        $data = array();
        $dytablestamp = $this->uri->segment(3);
        $this->form_validation->set_rules('cod_trabalhador', 'Cod_Cartón', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('ponto/tarefa_popup');
        } else {
            //Verificação da existência de um trabalhador com o código inserido
            if ($this->input->post('cod_trabalhador')) {
                $cod_trabalhador = $this->input->post('cod_trabalhador');
                $result = $this->Ponto_model->search_in($cod_trabalhador);
                if (!$result) {
                    $data = array();
                    $result = $this->Ponto_model->dados_tl($cod_trabalhador);
                    $data['trabalhador'] = $result;
                    $this->load->view('ponto/error_in_tarefa_modal', $data);
                } else {
                    //Verificação da existência de tarefas com o código de trabalhador inserido
                    $result = $this->Ponto_model->search_tarefa($cod_trabalhador);
                    if (!empty($result)) {
                        $result2 = $this->Ponto_model->dados_tl($cod_trabalhador);
                        $data['trabalhador'] = $result2;
                        $this->load->view('ponto/error_in_tarefa_dytable', $data);
                    } else {
                        //Registo de uma tarefa associada ao código do trabalhador em questão
                        $cod_trabalhador = $this->input->post('cod_trabalhador');
                        $result = $this->Ponto_model->dados_tl($cod_trabalhador);
                        foreach ($result as $resp) {
                            $nome = $resp['username'];
                        }
                        $this->Ponto_model->registo_tarefas($nome, $dytablestamp, $cod_trabalhador);
                        $data['trabalhador'] = $result;
                        $this->load->view('ponto/welcome_tarefa_dytable', $data);
                    }
                }
            }
        }
    }

    //listagem de tarefas atraves de tabela especifica
    public function tarefa_tabela() {
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

    //listagem de tarefas atraves de dossier interno
    public function tarefa_dossier() {
        $this->load->model('Ponto_model');
        $this->load->helper('url');
        $data = array();
        $filter = $this->uri->segment(3);
        $data['filter'] = $filter;
        if ($filter == 'all') {
            $filters = '';
        } else {
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

    //listagem de tarefas
    public function tarefas() {
        $this->load->library('form_validation');
        $this->load->helper('url');
        $data = array();

        $data["u_ncidef"] = $this->nci->getU_ncidef(array())[0];

        switch ($data["u_ncidef"]['tarefastipo']) {
            //listagem dytable
            case 0:

                $data['items'] = $this->Ponto_model->get_dytable();
                $data['subitems'] = array();
                $data['goback'] = "";
                break;
            //listagem tabela
            case 1:

                $data['items'] = $this->Ponto_model->get_produtos_tabela();
                $data['subitems'] = array();
                $data['goback'] = "";
                break;
            //listagem dossier
            case 2:
   
                $data['items'] = $this->Ponto_model->get_produtos_dossier();
                $data['subitems'] = array();
                $data['goback'] = "";
                break;
            //listagem artigos
            case 3:
                //familias
                if ($this->uri->segment(3, 0) === 0) {
      
                    $data['items'] = $this->Ponto_model->get_familias();
                    $data['subitems'] = array();
                    $data['goback'] = "";
                }
                //artigos de familias
                else {

                    $ref = $this->uri->segment(3);
                    $data['items'] = array();
                    $data['subitems'] = $this->Ponto_model->get_familia_produtos($ref);
                    $data['goback'] = "tarefas";
                }
                break;
        }

        $data['cart'] = $this->Ponto_model->get_cart();
        $this->load->view('ponto/listagem/tarefas', $data);
    }

    //fechar tarefas
    public function fechar_tarefa() {
        $data = array();
        $data['cod_trabalhador'] = $_SESSION['cod_trabalhador_temp'];
        $data['cart'] = $this->Ponto_model->get_cart();

        if ($cart) {
            $this->load->view('ponto/confirm_cart', $data);
        } else {
            $this->load->view('ponto/error/no_tasks', $data);
        }
    }

    //enviar cart
    public function send_cart() {
        $data = array();
        $data["u_ncidef"] = $this->nci->getU_ncidef(array())[0];
        $cart = $this->Ponto_model->get_cart();
        if ($cart) {
            $data['cart'] = $cart;    
            $this->load->view('ponto/cart/confirm_cart', $data);
        } else {
            $this->load->view('ponto/error/no_tasks', $data);
        }
    }

    //Função de término de uma tarefa
    public function save_tarefa() {
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('dossier_model', 'dossier');
        $this->load->model('nci_model', 'nci');

        $curToken = $_SESSION['token_temp'];
        $data = array();

        //configuracoes plataforma
        $data["u_ncidef"] = $this->nci->getU_ncidef(array())[0];

        $this->form_validation->set_rules('cod_trabalhador', 'Cod_Cartón', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        //se form nao valido
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('ponto/tarefa_popup', $data);
        }
        //se form valido
        else {
            //Registo e finalização de tarefas
            if ($this->input->post('cod_trabalhador')) {
                $cod_trabalhador = $this->input->post('cod_trabalhador');
                $data['trabalhador'] = $this->Ponto_model->dados_tl($cod_trabalhador);
                
                if(!$data['trabalhador']){
                    
                    $this->load->view('ponto/error/erro_nao_existe_trabalhador_ao_iniciar', $data);
                    
                }else{
                    
                    //se escolher tarefa ao iniciar tarefa
                    if ($data["u_ncidef"]['iniciar_tarefas'] == 1) {

                        //procurar por entrada ao servico
                        $result = $this->Ponto_model->search_in($cod_trabalhador);

                        //se nao existir entrada ponto de funcionario associado a este codigo
                        if (!count($result) || (count($result) && $result[0]["litem"] == "SAIDA")) {
                            $this->load->view('ponto/error/erro_sem_entrada_ao_iniciar', $data);
                        }

                        //se existir entrada ponto de funcionario associado a este codigo
                        else {

                            //tarefas cabecalho em aberto para este funcionario
                            $tarefasFuncionario = $this->Ponto_model->search_tarefa($cod_trabalhador);
                            if (count($tarefasFuncionario)) {
                                $this->Ponto_model->delete_tmp_tarefa($curToken);
                                $this->load->view('ponto/error/erro_tarefa_aberta_ao_iniciar', $data);
                            } else {

                                //tarefas escolhidas (linhas)
                                $cart = $this->Ponto_model->get_cart();

                                //se tipo de registo -> 0 = dossier / 1 = tabela
                                switch ($data["u_ncidef"]['tarefa_registo_stipo']) {

                                    //guardar em dossier
                                    case 0:
                                        $this->Ponto_model->update_tarefa_dossier($cod_trabalhador, $cart);
                                        break;
                                    //guardar em tabela
                                    case 1:
                                        $this->Ponto_model->update_tarefa_tabela($cod_trabalhador, $cart);
                                        break;
                                }
                                $this->Ponto_model->delete_tmp_tarefa($curToken);
                                $this->load->view('ponto/success/welcome_tarefa_ao_iniciar', $data);
                            }
                        }
                    }
                    //se escolher tarefa ao fechar tarefa
                    else {
                        //tarefas cabecalho em aberto para este funcionario
                        $tarefasFuncionario = $this->Ponto_model->search_tarefa($cod_trabalhador);

                        if (count($tarefasFuncionario)) {
                            //tarefas escolhidas (linhas)
                            $cart = $this->Ponto_model->get_cart();

                            //se tipo de registo -> 0 = dossier / 1 = tabela
                            switch ($data["u_ncidef"]['tarefa_registo_stipo']) {
                                //guardar em dossier
                                case 0:
                                    $this->Ponto_model->update_tarefa_dossier($cod_trabalhador, $cart);
                                    break;
                                //guardar em tabela
                                case 1:
                                    $this->Ponto_model->update_tarefa_tabela($cod_trabalhador, $cart);
                                    break;
                            }
                            $this->Ponto_model->delete_tmp_tarefa($curToken);
                            $this->load->view('ponto/success/inserted_task', $data);
                        } else {
                            $this->Ponto_model->delete_tmp_tarefa($curToken);
                            $this->load->view('ponto/error/erro_tem_adicionar_tarefa', $data);
                        }
                    } 
                    
                }
                
                
            } else {
                redirect("ponto/error/no_tasks");
            }
        }
    }
    
    //Função que redireciona a página atual para uma página alvo,
    //após x segundos.
    public function cronometro($url, $segundos) {
        if (!$segundos) {
            $segundos = 0;
        }
        echo '<meta http-equiv="refresh" content="' . $segundos . '; url=' . $url . '" />';
    }

    //apagar dados de cart
    public function delete_tmp_tarefa() {
        $tmp = $this->uri->segment(3);
        $this->load->model('Ponto_model');
        $this->Ponto_model->delete_tmp_tarefa($tmp);
    }

    //apagar dados de cart com filtro de referencia
    public function delete_tmp_tarefa_stamp() {
        $stamp = $this->uri->segment(3);
        $this->load->model('Ponto_model');
        $this->Ponto_model->delete_tmp_tarefa_stamp($stamp);
        redirect($_SERVER['HTTP_REFERER']);
    }

    //Adição de um produto às tarefas realizadas
    public function add_product() {
        $this->load->model('Ponto_model');
        $this->load->helper('url');
        $qtt = $_POST['qtt'];
        $ststamp = $_POST['ststamp'];
        $this->Ponto_model->add_product_cart($ststamp, $qtt);
    }

    //Adição de quantidades num determinado produto
    public function popup_qtt() {
        $data = array();
        $ststamp = $this->uri->segment(3);
        $data['ststamp'] = $ststamp;
        $this->load->view('ponto/popup_qtt', $data);
    }

}
