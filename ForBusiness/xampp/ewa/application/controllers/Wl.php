<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Wl extends CI_Controller {

    private $agencia = false;
    private $operador;
    private $products_ag;

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('checkout_model');
        $this->load->library('mssql');
        $this->load->library('pagination');
        $this->load->library('pdf3');
        $this->load->helper('cookie');
        $this->load->library('urlparameters');
    }

    public function index() {
        $this->load->model('wl_model');

        $data = array();

        $data["op"] = $this->uri->segment(2);
        $data["op"] = ctype_digit($data["op"]) ? intval($data["op"]) : '';
        $data["control"] = $this->uri->segment(3);

        if ($data["op"] != '' && $data["control"] == '') {

            $this->wl_model->set_wl_var($data, $data["op"]);

            if ($data["op_existe"] == 1) {
                $agent = "";
                if (isset($_SESSION["user_id"])) {
                    if ($_SESSION['type'] == "agent") {
                        $agent = $_SESSION["user_id"];
                    }
                }

                $data["products"] = $this->wl_model->get_products_top($data["op"], 1, $agent);

                foreach ($data["products"] as $key => $csm) {
                    $lastminute = $this->wl_model->get_lastminute_product($data["products"][$key]["bostamp"]);
                    if (sizeof($lastminute) > 0) {
                        if (substr($lastminute[0]['formula'], 1, 8) == "%") {
                            $formula = substr($lastminute[0]['formula'], 0, 1) . number_format($lastminute[0]['value'], 2) . substr($lastminute[0]['formula'], 1, 8);
                        } else {
                            $formula = substr($lastminute[0]['formula'], 0, 1) . number_format($lastminute[0]['value'], 2) . "€";
                        }

                        $data["products"][$key]["lastminute"] = "1";
                        $data["products"][$key]["lastminute_formula"] = $formula;
                    } else {
                        $data["products"][$key]["lastminute"] = "0";
                    }
                }

                $data['pcateg'] = $this->wl_model->get_category($data["op"], 1, $agent);
                $data['topdest'] = $this->wl_model->get_topdest($data["op"], 1, $agent);

                $data['white_label'] = $this->wl_model->get_wl_data($data["op"]);
                $this->template->content->view('wl_main_page', $data);
                $this->template->publish();
            }
        } else if ($data["op"] != '' && $data["control"] != '') {

            $this->wl_model->set_wl_var($data, $data["op"]);
            if ($data["op_existe"] == 1) {
                switch ($data["control"]) {
                    case 'product':
                        $this->wlop_product($data["op"]);
                        break;
                    case 'checkout':
                        $this->wlop_checkout($data["op"]);
                        break;
                    case 'login':
                        $this->wlop_login($data["op"]);
                        break;
                    case 'log_in':
                        $this->wlop_log_in($data["op"]);
                        break;
                    case 'log_in_private':
                        $this->wlop_log_in_private($data["op"]);
                        break;
                    case 'logout':
                        $this->wlop_logout($data["op"]);
                        break;
                    case 'login_fb':
                        $this->wlop_login_fb($data["op"]);
                        break;
                    case 'checkout_confirm':
                        $this->wlop_checkout_confirm($data["op"]);
                        break;
                    case 'checkout_accepted':
                        $this->wlop_checkout_accepted($data["op"]);
                        break;
                    case 'checkout_confirm_tpa_cash':
                        $this->wlop_checkout_confirm_tpa_cash($data["op"]);
                        break;
                    case 'checkout_confirm_agent':
                        $this->wlop_checkout_confirm_agent($data["op"]);
                        break;
                    case 'checkout_success':
                        $this->wlop_checkout_success($data["op"]);
                        break;
                    case 'register':
                        $this->wlop_register($data["op"]);
                        break;
                    case 'account':
                        $this->wlop_account($data["op"]);
                        break;
                    case 'account_orders':
                        $this->wlop_account_orders($data["op"]);
                        break;
                    case 'account_order':
                        $this->wlop_account_order($data["op"]);
                        break;
                    case 'account_updateaccount':
                        $this->wlop_updateaccount($data["op"]);
                        break;
                    case 'listing':
                        if (isset($_SESSION["user_id"])) {
                            if ($_SESSION['type'] == "agent") {
                                $this->wlop_listing($data["op"], $_SESSION["user_id"]);
                            } else {
                                $this->wlop_listing($data["op"]);
                            }
                        } else {
                            $this->wlop_listing($data["op"]);
                        }
                        break;
                    case 'pdf':
                        $this->pdf();
                        break;
                    case 'print_cart':
                        $this->wlop_printcart($data["op"]);
                        break;
                    case 'security-policy':
                        $this->wlop_security_policy($data["op"]);
                        break;
                    case 'terms-and-conditions':
                        $this->wlop_terms_conditions($data["op"]);
                        break;
                    case 'paypal_processement':
                        $this->wlop_paypal_processement($data["op"]);
                        break;
                    case 'paypal_accepted':
                        $this->wlop_paypal_accepted($data["op"]);
                        break;
                }
            }
        }
    }

    public function wlop_security_policy($op) {
        $this->load->model('user_model');
        $this->load->model('wl_model');
        $data["op"] = $op;

        if ($data["op"] != '') {
            $this->wl_model->set_wl_var($data, $data["op"]);

            $this->template->content->view('wl_security_policy', $data);
            $this->template->publish();
        }
    }

    public function wlop_terms_conditions($op) {
        $this->load->model('user_model');
        $this->load->model('wl_model');
        $data["op"] = $op;

        if ($data["op"] != '') {
            $this->wl_model->set_wl_var($data, $data["op"]);

            $this->template->content->view('wl_terms_conditions', $data);
            $this->template->publish();
        }
    }

    private function listing_products() {
        $this->set_op_agencia();
        if ($this->agencia) {
            $this->load->model('wl_model');
            $this->wl_model->agencia = true;
            return $this->unique_multidim_array($this->wl_model->get_all_products(), 'u_name');
        }
    }

    function unique_multidim_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        $this->products_ag = $temp_array;
    }

    private function get_all_products($op) {
        $products_ob = $this->wl_model->get_all_bo_products_operador($op);
        if ($products_ob) {
            foreach ($products_ob as $bo) {
                $products[] = $this->wl_model->getProducts_of_operador($bo['bostamp']);
            }
            return $products;
        }
    }

    public function wlop_listing($op, $agent = "") {
        $this->load->model('wl_model');
        $data = array();
        $config = array();
        $data["op"] = $op;
        $this->operador = (object) $this->wl_model->get_operator_data($op);
        $this->listing_products();
        $data["control"] = $this->uri->segment(3);

        $this->wl_model->set_wl_var($data, $data["op"]);
        if ($data["op_existe"] == 1) {

            $data["filters"] = $this->wl_model->get_filters($data["op"], $this->input->get(NULL, TRUE));

            $parame = $this->urlparameters->ArrayUrlToString($this->input->get(NULL, TRUE));

            $products = $this->agencia == true ? $this->products_ag : $this->wl_model->get_products_listing($data["op"], $data["filters"], "", "", 1, $agent);
            $products_op = $this->get_all_products($data["op"]);

            $products = !empty($products_op) ? $this->get_all_products($data["op"]) : $this->get_all_products($data["op"]);

            $bostamps = array();
            foreach ($products as $productsl) {

                $bostamp = $productsl['bostamp'];
                $bostamps[] = $bostamp;
            }

            $data["filters"] = $this->wl_model->get_filters($data["op"], $this->input->get(NULL, TRUE), $bostamps);


            $config["base_url"] = base_url() . "wl/" . $data["op"] . "/listing";
            $config["suffix"] = $parame;
            $config["total_rows"] = sizeof($products);

            if (isset($_GET['per_page'])) {
                $config["per_page"] = $_GET['per_page'];
            } else {
                $config["per_page"] = 5;
            }

            $data["per_page"] = $config["per_page"];
            $config["uri_segment"] = 4;
            $config["filters"] = $this->input->get(NULL, TRUE);
            $config['full_tag_open'] = '<div ><ul class="pagination">';
            $config['full_tag_close'] = '</ul></div><!--pagination-->';

            $config['first_link'] = '&laquo; First';
            $config['first_tag_open'] = '<li class="prev page">';
            $config['first_tag_close'] = '</li>';

            $config['last_link'] = 'Last &raquo;';
            $config['last_tag_open'] = '<li class="next page">';
            $config['last_tag_close'] = '</li>';

            $config['next_link'] = 'Next &rarr;';
            $config['next_tag_open'] = '<li class="next page">';
            $config['next_tag_close'] = '</li>';

            $config['prev_link'] = '&larr; Previous';
            $config['prev_tag_open'] = '<li class="prev page">';
            $config['prev_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li class="active"><a href="">';
            $config['cur_tag_close'] = '</a></li>';

            $config['num_tag_open'] = '<li class="page">';
            $config['num_tag_close'] = '</li>';

            if ($data["paginationactive"] == 1) {
                if ($data["paginationdefaultnum"] != 0) {
                    $data["per_page"] = $data["paginationdefaultnum"];
                    $config["per_page"] = $data["paginationdefaultnum"];
                }
                $this->pagination->initialize($config);
            } else {
                $data["per_page"] = $config["total_rows"];
                $config["per_page"] = $config["total_rows"];
            }

            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

            $data["links"] = $this->pagination->create_links();
            $data["products"] = $products;
            $data["u_lastminute"] = $this->wl_model->get_lastminute_products($data["op"], $data["filters"], 1);
            $data['white_label'] = $this->wl_model->get_wl_data($data["op"]);

            $products_ar = array();

            foreach ($data["u_lastminute"] as $row) {
                $prod_found = 0;
                foreach ($products_ar as $row2) {
                    if ($row2["bostamp"] == $row["bostamp"]) {
                        $prod_found++;
                    }
                }
                if ($prod_found == 0) {
                    $products_ar[] = $row;
                }
            }

            foreach ($data["products"] as $row) {
                $prod_found = 0;
                foreach ($products_ar as $row2) {
                    if ($row2["bostamp"] == $row["bostamp"]) {
                        $prod_found++;
                    }
                }
                if ($prod_found == 0) {
                    $products_ar[] = $row;
                }
            }

            foreach ($products_ar as $key => $csm) {
                $lastminute = $this->wl_model->get_lastminute_product($products_ar[$key]["bostamp"]);
                if (sizeof($lastminute) > 0) {
                    if (substr($lastminute[0]['formula'], 1, 8) == "%") {
                        $formula = substr($lastminute[0]['formula'], 0, 1) . number_format($lastminute[0]['value'], 2) . substr($lastminute[0]['formula'], 1, 8);
                    } else {
                        $formula = substr($lastminute[0]['formula'], 0, 1) . number_format($lastminute[0]['value'], 2) . "€";
                    }

                    $products_ar[$key]["lastminute"] = "1";
                    $products_ar[$key]["lastminute_formula"] = $formula;
                } else {
                    $products_ar[$key]["lastminute"] = "0";
                }
            }

            if (is_numeric($config["per_page"])) {
                $data["products_ar"] = array_slice($products_ar, $page, $config["per_page"]);
            } else {
                $data["products_ar"] = array_slice($products_ar, $page, sizeof($products_ar));
            }

            $this->template->content->view('wl_operator_products', $data);
            $this->template->publish();
        }
    }

    public function wlop_account($op) {
        $this->load->model('user_model');
        $this->load->model('wl_model');
        $data["op"] = $op;

        if ($data["op"] != '') {
            $this->wl_model->set_wl_var($data, $data["op"]);
            //qual os items do menu

            if ($_SESSION['type'] == 'agent') {
                $data['user'] = array('user_id' => $_SESSION["user_id"]);
            } else {
                $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
            }

            $this->template->content->view('wl_account_menu', $data);
            $this->template->content->view('wl_account', $data);
            $this->template->publish();
        }
    }

    public function wlop_account_orders($op) {
        $this->load->model('checkout_model');
        $this->load->model('user_model');
        $this->load->model('wl_model');
        $data["op"] = $op;

        if ($data["op"] != '') {
            $this->wl_model->set_wl_var($data, $data["op"]);
            //qual os items do menu

            if ($_SESSION['type'] == 'agent') {
                $data['user'] = array('user_id' => $_SESSION["user_id"]);
            } else {
                $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
            }
            $data['orders'] = $this->checkout_model->wl_get_orders($_SESSION["user_id"], $op);

            $this->template->content->view('wl_account_menu', $data);
            $this->template->content->view('wl_account_orders', $data);
            $this->template->publish();
        }
    }

    public function wlop_account_order($op) {
        $this->load->model('checkout_model');
        $this->load->model('user_model');
        $this->load->model('wl_model');
        $data["op"] = $op;

        if ($data["op"] != '') {
            $this->wl_model->set_wl_var($data, $data["op"]);
            //qual os items do menu
            $data['bostamp'] = $this->uri->segment(4);
            if ($_SESSION['type'] == 'agent') {
                $data['user'] = array('user_id' => $_SESSION["user_id"]);
            } else {
                $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
            }
            $data['order'] = $this->checkout_model->wl_get_order($data['bostamp']);
            $data['order'] = $data['order'][0];
            $data['order_bi'] = $this->checkout_model->wl_get_order_bi($data['bostamp']);
            $this->template->content->view('wl_account_menu', $data);
            $this->template->content->view('wl_account_order', $data);
            $this->template->publish();
        }
    }

    public function wlop_updateaccount($op) {
        $this->load->model('user_model');
        $data = new stdClass();

        if ($this->user_model->update_user($_SESSION["user_id"], $this->input->post())) {
            $data->success = 1;
        } else {
            $data->error = "Your request can't be completed right now. Please try again later.";
            $data->success = 0;
        }

        echo json_encode($data);
    }

    public function wlop_printcart($op) {
        $this->load->model('wl_model');
        $this->load->model('checkout_model');
        $this->load->model('user_model');
        $this->load->model('calendar_model');

        $data["op"] = $op;

        if ($data["op"] != '') {

            $this->wl_model->set_wl_var($data, $data["op"]);
            $anon_cookie = get_cookie('EWA_WL_' . $op);

            if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
                if (!is_null($anon_cookie)) {
                    $tmp = $this->checkout_model->get_cart_cookie($anon_cookie);
                }

                if (null !== $this->input->post('reservation_session')) {
                    $tmp['reservation_type'] = $this->input->post('reservation_type');
                    $tmp['reservation_data'] = $this->input->post('reservation_data');
                    $tmp['reservation_date'] = $this->input->post('reservation_date');
                    $tmp['reservation_session'] = $this->input->post('reservation_session');
                    $tmp['reservation_bostamp'] = $this->input->post('reservation_bostamp');
                    $tmp['reservation_room'] = $this->input->post('reservation_room');
                    $tmp['reservation_pickup'] = $this->input->post('reservation_pickup');
                    $tmp['reservation_language'] = $this->input->post('reservation_language');
                    $tmp['PaymentMethods'] = $this->checkout_model->getPaymentMethods();
                    $tmp['checkout_cart'] = $this->checkout_model->get_cart($tmp['reservation_type'], $tmp['reservation_data'], $tmp['reservation_date'], $tmp['reservation_session'], $tmp['reservation_bostamp']);
                    $tmp['returnTo'] = base_url() . 'wl/' . $data["op"] . '/checkout/';
                    $tmp['product'] = $this->wl_model->get_product_data_stamp($tmp['reservation_bostamp'], 1);
                    $tmp['taxasiva'] = $this->wl_model->get_iva();
                    $tmp['taxes'] = $this->wl_model->get_product_taxes($tmp['reservation_bostamp']);
                }

                if ($_SESSION['type'] == 'agent') {
                    $tmp['user'] = array('user_id' => $_SESSION["user_id"]);
                } else {
                    $tmp['user'] = $this->user_model->get_user($_SESSION["user_id"]);
                }

                if (isset($tmp['voucher']["code"])) {
                    $tmp['voucher'] = $this->calendar_model->voucher_validation($tmp['reservation_bostamp'], $tmp['voucher']["code"]);
                }

                $id = $this->checkout_model->set_cart_cookie($tmp, $anon_cookie);
                $cookie = array(
                    'name' => 'EWA_WL_' . $op,
                    'value' => $id,
                    'expire' => '360',
                    'path' => '/'
                );
                set_cookie($cookie);

                $data = array_merge($data, $tmp);
                echo $this->template->partial->view('wl_cart', $data, $overwrite = true);
            }
        }
    }

    private function set_op_agencia() {
        if ($this->operador->u_agencia > 0) {
            $this->agencia = true;
        }
    }

    public function wlop_product($op) {
        $this->load->model('wl_model');
        $data["op"] = $op;
        $data["prod"] = $this->uri->segment(4);
        if ($data["op"] != '' && $data["prod"] != '') {
            $this->wl_model->set_wl_var($data, $data["op"]);
            //qual os items do menu
            $this->operador = (object) $this->wl_model->get_operator_data($op);
            $this->set_op_agencia();
            $data["product"] = !$this->agencia ? $this->wl_model->get_product_data($data["op"], $data["prod"], 1) : $this->wl_model->get_product_data_agencia($data["prod"], 1);
            $data["product_img"] = $this->wl_model->get_product_img($data["prod"], 1);
            $data["tickets"] = $this->wl_model->get_product_tickets($data["prod"], 1);
            $data["seats"] = $this->wl_model->get_product_seats($data["prod"], 1);
            $data["extras"] = $this->wl_model->get_product_extras($data["prod"], 1);
            $data['related_products'] = $this->wl_model->get_related_products_mssql($data['product'][0]["bostamp"]);
            $data['white_label'] = $this->wl_model->get_wl_data($data["op"]);
            $data['pickups'] = $this->wl_model->get_ppickups_mssql_product($data['product'][0]["bostamp"]);
            $data['planguages'] = $this->wl_model->get_product_languages($data['product'][0]["bostamp"]);
            $data["categories"] = $this->wl_model->get_product_categories($data["prod"]);

            foreach ($data["related_products"] as $key => $csm) {
                $lastminute = $this->wl_model->get_lastminute_product($data["related_products"][$key]["bostamp"]);
                if (sizeof($lastminute) > 0) {
                    if (substr($lastminute[0]['formula'], 1, 8) == "%") {
                        $formula = substr($lastminute[0]['formula'], 0, 1) . number_format($lastminute[0]['value'], 2) . substr($lastminute[0]['formula'], 1, 8);
                    } else {
                        $formula = substr($lastminute[0]['formula'], 0, 1) . number_format($lastminute[0]['value'], 2) . "€";
                    }

                    $data["related_products"][$key]["lastminute"] = "1";
                    $data["related_products"][$key]["lastminute_formula"] = $formula;
                } else {
                    $data["related_products"][$key]["lastminute"] = "0";
                }
            }

            if (sizeof($data["product"])) {
                $data["row"] = $data["product"][0];

                $this->template->content->view('wl_operator_product', $data);
                $this->template->publish();
            }
        }
    }

    public function wlop_checkout($op) {
        $this->load->model('wl_model');
        $this->load->model('checkout_model');
        $this->load->model('user_model');
        $this->load->model('calendar_model');
        $this->load->model('product_model');
        $this->load->library('email');

        $data["op"] = $op;

        if ($data["op"] != '') {

            $this->wl_model->set_wl_var($data, $data["op"]);
            //qual os items do menu

            $anon_cookie = get_cookie('EWA_WL_' . $op);

            if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
                // temos login efetuado portanto temos que continuar a compra
                // verificar se temos cookie ativa. se tivermos cookie, então viemos de um login anónimo
                // temos de carregar a cookie para a cart
                if (!is_null($anon_cookie)) {
                    $tmp = $this->checkout_model->get_cart_cookie($anon_cookie);
                }

                if (null !== $this->input->post('reservation_session')) {
                    $tmp['reservation_type'] = $this->input->post('reservation_type');
                    $tmp['reservation_data'] = $this->input->post('reservation_data');
                    $tmp['reservation_date'] = $this->input->post('reservation_date');
                    $tmp['reservation_session'] = $this->input->post('reservation_session');
                    $tmp['reservation_bostamp'] = $this->input->post('reservation_bostamp');
                    $tmp['reservation_room'] = $this->input->post('reservation_room');
                    $tmp['reservation_pickup'] = $this->input->post('reservation_pickup');
                    $tmp['reservation_language'] = $this->input->post('reservation_language');
                    $tmp['PaymentMethods'] = $this->checkout_model->getPaymentMethods();
                    $tmp['checkout_cart'] = $this->checkout_model->get_cart($tmp['reservation_type'], $tmp['reservation_data'], $tmp['reservation_date'], $tmp['reservation_session'], $tmp['reservation_bostamp']);
                    $tmp['returnTo'] = base_url() . 'wl/' . $data["op"] . '/checkout/';
                    $tmp['voucher'] = array();
                    $tmp['lastminute_taxes'] = array();
                }

                if (!isset($tmp['reservation_bostamp'])) {
                    $tmp['reservation_type'] = "";
                    $tmp['reservation_data'] = "";
                    $tmp['reservation_date'] = "";
                    $tmp['reservation_session'] = "";
                    $tmp['reservation_bostamp'] = "";
                    $tmp['reservation_room'] = "";
                    $tmp['reservation_pickup'] = "";
                    $tmp['reservation_language'] = "";
                    $tmp['PaymentMethods'] = $this->checkout_model->getPaymentMethods();
                    $tmp['checkout_cart'] = array();
                    $tmp['returnTo'] = base_url() . 'wl/' . $data["op"] . '/';
                    $tmp['product'] = array();
                    $tmp['taxasiva'] = array();
                    $tmp['taxes'] = array();
                    $tmp['voucher'] = array();
                    $tmp['lastminute_taxes'] = array();
                } else {
                    $tmp['product'] = $this->wl_model->get_product_data_stamp($tmp['reservation_bostamp'], 1);
                    $tmp['taxasiva'] = $this->wl_model->get_iva();
                    $tmp['taxes'] = $this->wl_model->get_product_taxes($tmp['reservation_bostamp']);
                    $tmp['lastminute_taxes'] = $this->wl_model->get_lastminute_taxes($tmp['reservation_bostamp']);
                }

                if ($_SESSION['type'] == 'agent') {
                    $tmp['user'] = array('user_id' => $_SESSION["user_id"]);
                } else {
                    $tmp['user'] = $this->user_model->get_user($_SESSION["user_id"]);
                }

                $tmp['origin'] = 'WHITELABEL';
                $tmp["client_type"] = $_SESSION["type"];

                if (isset($tmp['voucher']["code"])) {
                    $tmp['voucher'] = $this->calendar_model->voucher_validation($tmp['reservation_bostamp'], $tmp['voucher']["code"]);
                } else {
                    $tmp['voucher'] = array();
                }

                if ($_SESSION['type'] == 'agent') {
                    $tmp["agent_product_percentage_parcial"] = $this->wl_model->get_agent_product_percentage_parcial($_SESSION['user_id'], $tmp['reservation_bostamp']);
                    $tmp['agent_plafond'] = $this->checkout_model->getAgentPlafond($_SESSION["user_id"], $op);
                    $tmp['onepage_checkout'] = $this->checkout_model->get_ifonepage($_SESSION["user_id"], $op);
                    $tmp['agent_max_plafond'] = $this->checkout_model->getAgentMaxPlafond($_SESSION["user_id"], $op);
                    $tmp['agent_sell_limit'] = $this->checkout_model->getAgentSellLimit($_SESSION["user_id"], $op);

                    $op_email = $this->checkout_model->getOperatorEmail($op);
                    $op_email_sent = $this->checkout_model->getPlafondEmailSent($_SESSION["user_id"], $op);

                    //envia email operador se agente passou plafond
                    if ($tmp['agent_plafond'] <= $tmp['agent_max_plafond'] * 0.2 && $tmp['agent_max_plafond'] > 0 && trim($op_email) != "" && !$op_email_sent) {
                        $email = $op_email;
                        $subject = "Agent plafond reaching limit";
                        $message = "<b>Agent ID</b>: " . $_SESSION["user_id"] . "<br>";
                        $message .= "<b>Agent Name</b>: " . $_SESSION["username"] . "<br>";
                        $message .= "<b>Max Plafond</b>: " . number_format($tmp['agent_max_plafond'], 2, '.', '') . "<br>";
                        $message .= "<b>Current Plafond</b>: " . number_format($tmp['agent_plafond'], 2, '.', '') . "<br>";

                        $this->email->from('info@soft4booking.com', 'SOFT4BOOKING');
                        $this->email->to($email);
                        $this->email->subject($subject);
                        $this->email->message($message);
                        $this->email->send();

                        $this->checkout_model->setPlafondEmailSent($_SESSION["user_id"], $op, 1);
                    }
                } else {
                    $tmp["agent_product_percentage_parcial"] = 0;
                    $tmp['agent_plafond'] = 0;
                    $tmp['onepage_checkout'] = array();
                    $tmp['agent_max_plafond'] = 0;
                    $tmp['onepage_checkout'] = array();
                    $tmp['agent_sell_limit'] = 0;
                }

                $id = $this->checkout_model->set_cart_cookie($tmp, $anon_cookie);
                $cookie = array(
                    'name' => 'EWA_WL_' . $op,
                    'value' => $id,
                    'expire' => '360',
                    'path' => '/'
                );
                set_cookie($cookie);

                $data = array_merge($data, $tmp);

                if (!isset($tmp['onepage_checkout'])) {
                    foreach ($tmp['onepage_checkout'] as $value) {
                        if ($value['onepage_checkout'] != 0) {
                            $this->template->content->view('wl_onepage_checkout', $data);
                            $this->template->publish();
                        } else {

                            $this->template->content->view('wl_checkout', $data);
                            $this->template->publish();
                        }
                    }
                } else {
                    $this->template->content->view('wl_checkout', $data);
                    $this->template->publish();
                }
            } else {
                // nao temos login efetuado portanto temos de ir para pagina de login
                // temos no entanto que guardar a compra numa cookie para posterior carregamento
                // post existe portanto é uma nova compra
                if (null !== $this->input->post('reservation_session')) {
                    $tmp['reservation_type'] = $this->input->post('reservation_type');
                    $tmp['reservation_data'] = $this->input->post('reservation_data');
                    $tmp['reservation_date'] = $this->input->post('reservation_date');
                    $tmp['reservation_session'] = $this->input->post('reservation_session');
                    $tmp['reservation_bostamp'] = $this->input->post('reservation_bostamp');
                    $tmp['reservation_room'] = $this->input->post('reservation_room');
                    $tmp['reservation_pickup'] = $this->input->post('reservation_pickup');
                    $tmp['reservation_language'] = $this->input->post('reservation_language');
                    $tmp['PaymentMethods'] = $this->checkout_model->getPaymentMethods();
                    $tmp['checkout_cart'] = $this->checkout_model->get_cart($tmp['reservation_type'], $tmp['reservation_data'], $tmp['reservation_date'], $tmp['reservation_session'], $tmp['reservation_bostamp']);
                    $tmp['returnTo'] = base_url() . 'wl/' . $data["op"] . '/checkout/';
                    $tmp['product'] = $this->wl_model->get_product_data_stamp($tmp['reservation_bostamp'], 1);
                    $tmp['taxasiva'] = $this->wl_model->get_iva();
                    $tmp['taxes'] = $this->wl_model->get_product_taxes($tmp['reservation_bostamp']);
                    $id = $this->checkout_model->set_cart_cookie($tmp, $anon_cookie);
                    $cookie = array(
                        'name' => 'EWA_WL_' . $op,
                        'value' => $id,
                        'expire' => '360',
                        'path' => '/'
                    );
                    set_cookie($cookie);
                }
                //login or register
                redirect('wl/' . $data["op"] . '/login/');
            }
        }
    }

    public function wlop_checkout_confirm($op) {
        $this->load->model('wl_model');
        $this->load->model('checkout_model');
        $this->load->model('user_model');
        $this->load->model('phc_model');
        $data["op"] = $op;
        if ($data["op"] != '') {
            $this->wl_model->set_wl_var($data, $data["op"]);
            //qual os items do menu			
            $anon_cookie = get_cookie('EWA_WL_' . $op);
            $PaymentMethod = $this->input->post("PaymentType");
            $PaymentData = $this->input->post();
            $this->mssql->utf8_encode_deep($PaymentData);

            if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
                if (!is_null($anon_cookie)) {
                    $tmp = $this->checkout_model->get_cart_cookie($anon_cookie);
                }
                //checkout
                if ($_SESSION['type'] == 'agent') {
                    $tmp['user'] = array('user_id' => $_SESSION["user_id"]);
                } else {
                    $tmp['user'] = $this->user_model->get_user($_SESSION["user_id"]);
                }

                $tmp["PaymentData"] = $PaymentData;

                $data = array_merge($data, $tmp);
                $this->mssql->utf8_encode_deep($data);
                $order_id = $this->checkout_model->save_tmp_order($data, $_SESSION["user_id"]);
                //SHA-OUT IN: Pson3200+-+-Ypal734489#+				
                //calculo total ini------------------------
                //calculo total - variaveis
                $checkout_cart = $data["checkout_cart"];
                $lastminute_taxes = $data["lastminute_taxes"];
                $taxes = $data["taxes"];
                $voucher = $data["voucher"];
                $other_taxes = 0;
                $cart_total = 0;
                $subtotal = 0;
                $voucher_value = 0;
                //calculo total - last minute
                if (sizeof($lastminute_taxes) > 0) {
                    foreach ($lastminute_taxes as $lastminute_tax) {
                        foreach ($checkout_cart as &$cart_prod) {
                            if ($lastminute_tax["formula"] == "-%") {
                                $cart_prod["unit_price"] = $cart_prod["unit_price"] * ( 1 - ($lastminute_tax["value"] / 100) );
                            } else if ($lastminute_tax["formula"] == "-v") {
                                $cart_prod["unit_price"] = $cart_prod["unit_price"] - $lastminute_tax["value"];
                            }
                        }
                    }
                }
                //calculo total - subtotal
                foreach ($checkout_cart as $linha) {
                    $subtotal += ( floatval($linha["qtt"]) * floatval($linha["unit_price"]) );
                }
                //calculo total - voucher
                if (isset($voucher["code"]) && $voucher["code"] != '') {
                    switch ($voucher["formula"]) {
                        case '- %':
                            $voucher_value -= $subtotal * floatval($voucher["value"]) / 100;
                            break;
                        case '- V':
                            $voucher_value -= floatval($voucher["value"]);
                            break;
                    }
                }
                //calculo total - taxas
                foreach ($taxes as $tax) {
                    $cur_tax_value = 0;
                    switch ($tax["formula"]) {
                        case '+%':
                            $cur_tax_value += ($subtotal + $voucher_value) * floatval($tax["value"]) / 100;
                            break;
                        case '+v':
                            $cur_tax_value += floatval($tax["value"]);
                            break;
                    }
                    $other_taxes += $cur_tax_value;
                }
                //calculo total
                $cart_total = $subtotal + $other_taxes + $voucher_value;
                //calculo total end------------------------
                switch ($PaymentMethod) {
                    //Visa, Mastercard
                    case 1:
                    //Visa Electron
                    case 3:
                        $data["passData"] = array(
                            "PSPID" => "EUROPEANWORLD",
                            "ORDERID" => $order_id,
                            "AMOUNT" => round($cart_total, 2) * 100,
                            "CURRENCY" => "EUR",
                            'ACCEPTURL' => base_url() . 'wl/' . $op . '/checkout_accepted/',
                            'DECLINEURL' => base_url() . 'wl/' . $op . '/checkout_declined/',
                            'EXCEPTIONURL' => base_url() . 'wl/' . $op . '/checkout_exception/',
                            'CANCELURL' => base_url() . 'wl/' . $op . '/checkout_canceled/'
                        );
                        $shasign = $this->checkout_model->get_sha256($data["passData"], 'ojTOb*HMg5v9kmx.E}8');
                        $data["passData"]["SHASIGN"] = $shasign;
                        $data["url"] = 'https://secure.ogone.com/ncol/test/orderstandard_utf8.asp';
                        $this->load->view('wl_checkout_creditcardpayment', $data);
                        break;
                    //paypal
                    case 6:
                        //paypal
                        $this->wlop_paypal_payment($op, $order_id);
                        break;
                }
            } else {
                //login or register
                $tmp['returnTo'] = base_url() . 'wl/' . $op . '/checkout';
                $id = $this->checkout_model->set_cart_cookie($tmp, $anon_cookie);
                $cookie = array(
                    'name' => 'EWA_WL_' . $op,
                    'value' => $id,
                    'expire' => '360',
                    'path' => '/'
                );
                set_cookie($cookie);
                redirect(base_url() . 'wl/' . $op . '/login');
            }
        }
    }

    public function wlop_paypal_processement($op) {
        // read the post from PayPal system and add 'cmd'
        $req = 'cmd=_notify-validate';
        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i', '${1}%0D%0A${3}', $value); // IPN fix
            $req .= "&$key=$value";
        }

        $item_number = $_POST['item_number'];

        // post back to PayPal system to validate

        $header = "POST /cgi-bin/webscr HTTP/1.1\r\n";
        $header .= "Host: www.sandbox.paypal.com\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

        $fp = fsockopen('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

        if (!$fp) {
            // HTTP ERROR
        } else {
            fputs($fp, $header . $req);
            while (!feof($fp)) {
                $res = fgets($fp, 1024);
                if (strcmp(trim($res), "VERIFIED") == 0) {
                    // Used for debugging
                    // mail('user@domain.com', 'PAYPAL POST - VERIFIED RESPONSE', print_r($post, true));
                    // PAYMENT VALIDATED & VERIFIED!
                    $data = $this->checkout_model->get_tmp_data($item_number);
                    //create encomenda PHC				
                    $existe_order = $this->checkout_model->exist_tmp_data($item_number);

                    if ($existe_order) {
                        $this->checkout_model->delete_tmp_data2($data);
                        $sql_status = $this->phc_model->create_order($data);
                    } else {
                        // Payment made but data has been changed
                        // E-mail admin or alert user
                    }
                } else if (strcmp(trim($res), "INVALID") == 0) {
                    // PAYMENT INVALID & INVESTIGATE MANUALY!
                    // E-mail admin or alert user
                    // Used for debugging
                    //@mail("user@domain.com", "PAYPAL DEBUGGING", "Invalid Response<br />data = <pre>".print_r($post, true)."</pre>");
                }
            }
            fclose($fp);
        }
    }

    public function wlop_paypal_accepted($op) {
        $id = $_GET['id'];
        $user_id = $_GET['id_user'];
        $user_type = $_GET['type_user'];
        $status = 6;
        $data = $this->checkout_model->get_tmp_data($id);
        $data["payment"] = $status;

        if (isset($user_id) && $user_id > 0) {
            //checkout
            $data['origin'] = 'WHITELABEL';
            $data["client_type"] = $user_type;
            if ($data["client_type"] == 'agent') {
                $data['user'] = array('user_id' => $_SESSION["user_id"]);
            } else {
                $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
            }

            $data['bostamp2'] = "";
            $this->template->content->view('wl_checkout_completed', $data, $op);
        }
        $this->template->publish();
    }

    public function wlop_paypal_payment($op, $order_id) {
        $data["op"] = $op;
        // PayPal settings
        $paypal_email = 'julio.ribeiro@globalfragments.com';
        $return_url = base_url() . "wl/" . $op . "/paypal_accepted?id=" . $order_id . "&id_user=" . $_SESSION["user_id"] . "&type_user=" . $_SESSION["type"];
        $cancel_url = '';
        $notify_url = base_url() . "wl/" . $op . "/paypal_processement";
        //buscar item_number
        //atraves do item_number, obter valor
        $order_data = $this->checkout_model->get_tmp_data($order_id);

        //calculo total ini------------------------
        //calculo total - variaveis
        $checkout_cart = $order_data["checkout_cart"];
        $lastminute_taxes = $order_data["lastminute_taxes"];
        $taxes = $order_data["taxes"];
        $voucher = $order_data["voucher"];
        $other_taxes = 0;
        $cart_total = 0;
        $subtotal = 0;
        $voucher_value = 0;

        //calculo total - last minute
        if (sizeof($lastminute_taxes) > 0) {
            foreach ($lastminute_taxes as $lastminute_tax) {
                foreach ($checkout_cart as &$cart_prod) {
                    if ($lastminute_tax["formula"] == "-%") {
                        $cart_prod["unit_price"] = $cart_prod["unit_price"] * ( 1 - ($lastminute_tax["value"] / 100) );
                    } else if ($lastminute_tax["formula"] == "-v") {
                        $cart_prod["unit_price"] = $cart_prod["unit_price"] - $lastminute_tax["value"];
                    }
                }
            }
        }

        //calculo total - subtotal
        foreach ($checkout_cart as $linha) {
            $subtotal += ( floatval($linha["qtt"]) * floatval($linha["unit_price"]) );
        }

        //calculo total - voucher
        if (isset($voucher["code"]) && $voucher["code"] != '') {
            switch ($voucher["formula"]) {
                case '- %':
                    $voucher_value -= $subtotal * floatval($voucher["value"]) / 100;
                    break;
                case '- V':
                    $voucher_value -= floatval($voucher["value"]);
                    break;
            }
        }

        //calculo total - taxas
        foreach ($taxes as $tax) {
            $cur_tax_value = 0;
            switch ($tax["formula"]) {
                case '+%':
                    $cur_tax_value += ($subtotal + $voucher_value) * floatval($tax["value"]) / 100;
                    break;
                case '+v':
                    $cur_tax_value += floatval($tax["value"]);
                    break;
            }
            $other_taxes += $cur_tax_value;
        }

        //calculo total
        $cart_total = $subtotal + $other_taxes + $voucher_value;
        //calculo total end------------------------

        $item_name = $order_id;
        $item_amount = $cart_total;

        $querystring = '';

        $querystring .= "?business=" . urlencode($paypal_email) . "&";
        $querystring .= "item_name=" . urlencode($item_name) . "&";
        $querystring .= "lc=" . urlencode('PT') . "&";
        $querystring .= "currency_code=" . urlencode('EUR') . "&";
        $querystring .= "bn=" . urlencode("PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest") . "&";
        $querystring .= "amount=" . urlencode($item_amount) . "&";

        $querystring .= "cmd=" . urlencode(stripslashes("_xclick")) . "&";
        $querystring .= "no_note=" . urlencode(stripslashes("1")) . "&";
        $querystring .= "first_name=" . urlencode(stripslashes("")) . "&";
        $querystring .= "last_name=" . urlencode(stripslashes("")) . "&";
        $querystring .= "payer_email=" . urlencode(stripslashes("")) . "&";
        $querystring .= "item_number=" . urlencode(stripslashes("")) . "&";

        //loop for posted values and append to querystring
        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $querystring .= "$key=$value&";
        }

        // Append paypal return addresses
        $querystring .= "return=" . urlencode(stripslashes($return_url)) . "&";
        $querystring .= "cancel_return=" . urlencode(stripslashes($cancel_url)) . "&";
        $querystring .= "notify_url=" . urlencode($notify_url);

        // Append querystring with custom field
        //$querystring .= "&custom=".USERID;
        // Redirect to paypal IPN
        header('location:https://www.sandbox.paypal.com/cgi-bin/webscr' . $querystring);
        exit();
    }

    public function wlop_checkout_confirm_tpa_cash($op) {
        $this->load->model('wl_model');
        $this->load->model('checkout_model');
        $this->load->model('user_model');
        $this->load->model('phc_model');

        $data["op"] = $op;
        $PaymentData = $this->input->post();
        $anon_cookie = get_cookie('EWA_WL_' . $op);

        if ($data["op"] != '') {
            $this->wl_model->set_wl_var($data, $data["op"]);
            //qual os items do menu

            if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {

                if (!is_null($anon_cookie)) {
                    $tmp = $this->checkout_model->get_cart_cookie($anon_cookie);
                }
                $this->mssql->utf8_encode_deep($PaymentData);
                $tmp['PaymentData'] = $PaymentData;
                if ($_SESSION['type'] == 'agent') {
                    $tmp['user'] = array('user_id' => $_SESSION["user_id"]);
                } else {
                    $tmp['user'] = $this->user_model->get_user($_SESSION["user_id"]);
                }
                //create encomenda PHC
                $tmp['origin'] = 'WHITELABEL';
                $tmp["client_type"] = $_SESSION["type"];

                $id = $this->checkout_model->set_cart_cookie($tmp, $anon_cookie);
                $cookie = array(
                    'name' => 'EWA_WL_' . $op,
                    'value' => $id,
                    'expire' => '360',
                    'path' => '/'
                );
                set_cookie($cookie);

                $data = array_merge($data, $tmp);

                $sql_status = $this->phc_model->create_order($data);

                if ($sql_status[0]) {
                    $data['bostamp2'] = $sql_status[1];
                    $this->session->set_flashdata('data', $data);
                    $this->template->content->view('wl_checkout_completed', $data, $op);
                } else {
                    $this->session->set_flashdata('data', $data);
                    $this->template->content->view('wl_checkout_incompleted', $data);
                }
            }

            $this->template->publish();
        }
    }

    public function wlop_checkout_confirm_agent($op) {
        $this->load->model('wl_model');
        $this->load->model('checkout_model');
        $this->load->model('user_model');
        $this->load->model('phc_model');

        $data["op"] = $op;
        $PaymentMethod = $this->input->post("PaymentType");
        if ($data["op"] != '') {
            $this->wl_model->set_wl_var($data, $data["op"]);
            //qual os items do menu

            $anon_cookie = get_cookie('EWA_WL_' . $op);
            $PaymentData = $this->input->post();
            $this->mssql->utf8_encode_deep($PaymentData);

            if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
                //checkout

                if (!is_null($anon_cookie)) {
                    $tmp = $this->checkout_model->get_cart_cookie($anon_cookie);
                }

                $tmp['PaymentData'] = $PaymentData;
                if ($_SESSION['type'] == 'agent') {
                    $tmp['user'] = array('user_id' => $_SESSION["user_id"]);
                } else {
                    $tmp['user'] = $this->user_model->get_user($_SESSION["user_id"]);
                }

                $id = $this->checkout_model->set_cart_cookie($tmp, $anon_cookie);
                $cookie = array(
                    'name' => 'EWA_WL_' . $op,
                    'value' => $id,
                    'expire' => '360',
                    'path' => '/'
                );
                set_cookie($cookie);

                $data = array_merge($data, $tmp);

                $order_id = $this->checkout_model->save_tmp_order($data, $_SESSION["user_id"]);

                //SHA-OUT IN: Pson3200+-+-Ypal734489#+
                //calculo total ini------------------------
                //calculo total - variaveis
                $checkout_cart = $data["checkout_cart"];
                $lastminute_taxes = $data["lastminute_taxes"];
                $taxes = $data["taxes"];
                $voucher = $data["voucher"];
                $other_taxes = 0;
                $cart_total = 0;
                $subtotal = 0;
                $voucher_value = 0;

                //calculo total - last minute
                if (sizeof($lastminute_taxes) > 0) {
                    foreach ($lastminute_taxes as $lastminute_tax) {
                        foreach ($checkout_cart as &$cart_prod) {
                            if ($lastminute_tax["formula"] == "-%") {
                                $cart_prod["unit_price"] = $cart_prod["unit_price"] * ( 1 - ($lastminute_tax["value"] / 100) );
                            } else if ($lastminute_tax["formula"] == "-v") {
                                $cart_prod["unit_price"] = $cart_prod["unit_price"] - $lastminute_tax["value"];
                            }
                        }
                    }
                }

                //calculo total - subtotal
                foreach ($checkout_cart as $linha) {
                    $subtotal += ( floatval($linha["qtt"]) * floatval($linha["unit_price"]) );
                }

                //calculo total - voucher
                if (isset($voucher["code"]) && $voucher["code"] != '') {
                    switch ($voucher["formula"]) {
                        case '- %':
                            $voucher_value -= $subtotal * floatval($voucher["value"]) / 100;
                            break;
                        case '- V':
                            $voucher_value -= floatval($voucher["value"]);
                            break;
                    }
                }

                //calculo total - taxas
                foreach ($taxes as $tax) {
                    $cur_tax_value = 0;
                    switch ($tax["formula"]) {
                        case '+%':
                            $cur_tax_value += ($subtotal + $voucher_value) * floatval($tax["value"]) / 100;
                            break;
                        case '+v':
                            $cur_tax_value += floatval($tax["value"]);
                            break;
                    }
                    $other_taxes += $cur_tax_value;
                }

                //calculo total
                $cart_total = $subtotal + $other_taxes + $voucher_value;

                //calculo total end------------------------
                switch ($PaymentMethod) {
                    //Visa, Mastercard
                    case 1:
                    //Visa Electron
                    case 3:
                        $data["passData"] = array(
                            "PSPID" => "EUROPEANWORLD",
                            "ORDERID" => $order_id,
                            "AMOUNT" => round($cart_total, 2) * 100,
                            "CURRENCY" => "EUR",
                            'ACCEPTURL' => base_url() . 'wl/' . $op . '/checkout_accepted/',
                            'DECLINEURL' => base_url() . 'wl/' . $op . '/checkout_declined/',
                            'EXCEPTIONURL' => base_url() . 'wl/' . $op . '/checkout_exception/',
                            'CANCELURL' => base_url() . 'wl/' . $op . '/checkout_canceled/'
                        );

                        $shasign = $this->checkout_model->get_sha256($data["passData"], 'ojTOb*HMg5v9kmx.E}8');
                        $data["passData"]["SHASIGN"] = $shasign;
                        $data["url"] = 'https://secure.ogone.com/ncol/test/orderstandard_utf8.asp';
                        $this->load->view('wl_checkout_creditcardpayment', $data);
                        break;
                    case 6:
                        //paypal
                        $this->wlop_paypal_payment($op, $order_id);
                        break;
                }
            } else {
                //login or register
                $tmp['returnTo'] = base_url() . 'wl/' . $op . '/checkout';
                $id = $this->checkout_model->set_cart_cookie($tmp, $anon_cookie);

                $cookie = array(
                    'name' => 'EWA_WL_' . $op,
                    'value' => $id,
                    'expire' => '360',
                    'path' => '/'
                );
                set_cookie($cookie);

                redirect(base_url() . 'wl/' . $op . '/login');
            }
        }
    }

    public function wlop_checkout_accepted($op) {

        $this->load->model('wl_model');
        $this->load->model('checkout_model');
        $this->load->model('user_model');
        $this->load->model('phc_model');

        $anon_cookie = get_cookie('EWA_WL_' . $op);

        if (!is_null($anon_cookie)) {
            $data = $this->checkout_model->get_cart_cookie($anon_cookie);
        }

        $data["op"] = $op;

        if ($data["op"] != '') {
            $this->wl_model->set_wl_var($data, $data["op"]);
            //qual os items do menu

            $get = $this->input->get();
            $result = $this->checkout_model->get_sha256($get, 'cK=Rc6WvEVNCq8\9w(O');

            $data['origin'] = 'WHITELABEL';
            $data["client_type"] = $_SESSION["type"];
            if ($_SESSION['type'] == 'agent') {
                $data['user'] = array('user_id' => $_SESSION["user_id"]);
            } else {
                $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
            }

            $id = $this->checkout_model->set_cart_cookie($data, $anon_cookie);
            $cookie = array(
                'name' => 'EWA_WL_' . $op,
                'value' => $id,
                'expire' => '360',
                'path' => '/'
            );
            // delete_cookie('EWA_WL_'.$op); 
            // verificar se foi realmente enviado pela Ingenico
            if ($get["SHASIGN"] != $result) {
                //contact Merchant
                $this->template->content->view('wl_checkout_incompleted', $data);
            } else {
                $data = array_merge($data, $this->checkout_model->get_tmp_data($get["orderID"]));
                $data["payment"] = $get;

                if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
                    //checkout
                    if ($_SESSION['type'] == 'agent') {
                        $data['user'] = array('user_id' => $_SESSION["user_id"]);
                    } else {
                        $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
                    }
                    //create encomenda PHC	
                    $data['origin'] = 'WHITELABEL';
                    $data["client_type"] = $_SESSION["type"];

                    $existe_order = $this->checkout_model->exist_tmp_data($get["orderID"]);

                    if ($existe_order) {
                        $sql_status = $this->phc_model->create_order($data);
                        $this->checkout_model->delete_tmp_data($data);
                    } else {
                        $sql_status = 1;
                    }

                    if ($sql_status[0]) {
                        $data['bostamp2'] = $sql_status[1];
                        $this->template->content->view('wl_checkout_completed', $data, $op);
                    } else {
                        $this->template->content->view('wl_checkout_incompleted', $data);
                    }
                }
            }

            $this->template->publish();
        }
    }

    public function wlop_checkout_success($op) {

        $this->load->model('wl_model');
        $this->load->model('checkout_model');
        $this->load->model('user_model');
        $this->load->model('phc_model');

        $anon_cookie = get_cookie('EWA_WL_' . $op);

        if (!is_null($anon_cookie)) {
            $data = $this->checkout_model->get_cart_cookie($anon_cookie);
        }

        $data["op"] = $op;

        if ($data["op"] != '') {
            $this->wl_model->set_wl_var($data, $data["op"]);
            //qual os items do menu
            $data['origin'] = 'WHITELABEL';
            $data["client_type"] = $_SESSION["type"];
            if ($_SESSION['type'] == 'agent') {
                $data['user'] = array('user_id' => $_SESSION["user_id"]);
            } else {
                $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
            }

            $id = $this->checkout_model->set_cart_cookie($data, $anon_cookie);
            $cookie = array(
                'name' => 'EWA_WL_' . $op,
                'value' => $id,
                'expire' => '360',
                'path' => '/'
            );
            delete_cookie('EWA_WL_' . $op);

            $this->template->content->view('wl_checkout_completed', $data, $op);
            $this->template->publish();
        }
    }

    public function wlop_login($op) {
        $this->load->model('wl_model');
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->model('user_model');
        parse_str($_SERVER['QUERY_STRING'], $_REQUEST);
        $this->config->load("facebook", TRUE);
        $config = $this->config->item('facebook');
        $this->load->library('Facebook', $config);

        $data["op"] = $op;

        if ($op != '') {
            $this->wl_model->set_wl_var($data, $data["op"]);
            //qual os items do menu

            $userId = $this->facebook->getUser();

            $data['url_register_fb'] = "";

            $data['postRed'] = empty($this->input->post('postRed')) ? '' : '+&postRed=' . $this->input->post('postRed');
            $data['postDt'] = empty($this->input->post('postDt')) ? '' : '+&postDt=' . $this->input->post('postDt');

            if ($userId == 0) {
                $data['url_register_fb'] = $this->facebook->getLoginUrl(array('scope' => 'email'), base_url() . 'wl/' . $op . '/register_fb');
                $data['url_login_fb'] = $this->facebook->getLoginUrl(array('scope' => 'email'), base_url() . 'wl/' . $op . '/login_fb');
            } else {
                $data['url_register_fb'] = '';
                $data['url_login_fb'] = '';
            }

            $anon_cookie = $this->input->cookie('EWA_WL_' . $op);

            if (!is_null($anon_cookie)) {
                $tmp = $this->checkout_model->get_cart_cookie($anon_cookie);
                $data['returnTo'] = $tmp["returnTo"];
            }

            if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
                //redirect
                if ($_SESSION['type'] == 'agent') {
                    $data['user'] = array('user_id' => $_SESSION["user_id"]);
                } else {
                    $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
                }
                if (isset($data['returnTo']) && $data['returnTo'] != '') {
                    redirect($data['returnTo']);
                } else {
                    redirect(base_url() . 'wl/' . $op);
                }
            } else {
                //login or register
                $this->session->set_flashdata('data', $data);
                $this->template->content->view('wl_login', $data);
                $this->template->publish();
            }
        }
    }

    public function wlop_register_fb($op) {
        $this->load->model('wl_model');
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->model('user_model');
        parse_str($_SERVER['QUERY_STRING'], $_REQUEST);
        $this->config->load("facebook", TRUE);
        $config = $this->config->item('facebook');
        $this->load->library('Facebook', $config);
        $userId = $this->facebook->getUser();

        // If user is not yet authenticated, the id will be zero
        if ($userId == 0) {
            $data->error = '';
            $data->redirect_page_error = 'Unknown error';
            $data->redirect_page_success = '';
            $data->success = 0;
        } else {
            // Get user's data and print it
            $user = $this->facebook->api('/me?fields=id,first_name,last_name,email,gender,location,birthday');

            if (!$this->user_model->check_email_exist($user["email"])) {
                $this->user_model->create_user($user["email"], 'H`%`H)sz@Mh^Y?,jmX"t?>qJBCfeXE~f:Q\eu{-3=K(a<7fL}N.xZuL', 1, $user);
            }

            $user_id = $this->user_model->get_user_id_from_email($user["email"]);
            $user = $this->user_model->get_user($user_id);

            // set session user datas
            $_SESSION['user_id'] = (int) $user->id;
            $_SESSION['email'] = (string) $user->email;
            $_SESSION['type'] = 'client';
            $_SESSION['logged_in'] = (bool) true;
            $_SESSION['is_confirmed'] = (bool) $user->is_confirmed;
            $_SESSION['is_admin'] = (bool) $user->is_admin;

            redirect(base_url() . 'wl/' . $op);
        }
    }

    public function wlop_login_fb($op) {
        $this->load->model('wl_model');
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->model('user_model');
        parse_str($_SERVER['QUERY_STRING'], $_REQUEST);
        $this->config->load("facebook", TRUE);
        $config = $this->config->item('facebook');
        $this->load->library('Facebook', $config);
        $userId = $this->facebook->getUser();

        // If user is not yet authenticated, the id will be zero
        if ($userId == 0) {
            $data->error = '';
            $data->redirect_page_error = 'Unknown error';
            $data->redirect_page_success = '';
            $data->success = 0;
        } else {
            // Get user's data and print it
            $user = $this->facebook->api('/me?fields=id,name,email');

            if ($this->user_model->resolve_user_login_facebook($user["email"])) {
                $user_id = $this->user_model->get_user_id_from_email($user["email"]);
                $user = $this->user_model->get_user($user_id);

                // set session user datas
                $_SESSION['user_id'] = (int) $user->id;
                $_SESSION['email'] = (string) $user->email;
                $_SESSION['type'] = 'client';
                $_SESSION['logged_in'] = (bool) true;
                $_SESSION['is_confirmed'] = (bool) $user->is_confirmed;
                $_SESSION['is_admin'] = (bool) $user->is_admin;
            }

            $data = $this->session->flashdata('data');
            $this->session->set_flashdata('data', $data);

            if (isset($data['returnTo']) && $data['returnTo'] != '') {
                redirect($data['returnTo']);
            } else {
                redirect(base_url() . 'wl/' . $op);
            }
        }
    }

    public function wlop_register($op) {
        $this->load->model('wl_model');
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->model('user_model');
        // create the data object
        $data = new stdClass();

        // load form helper and validation library
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set validation rules
        $this->form_validation->set_rules('reg-email', 'Email', 'trim|required|valid_email|is_unique[users.email]', array('is_unique' => 'This email already exists. Please choose another one.'));
        $this->form_validation->set_rules('reg-password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('reg-cpassword', 'Confirm Password', 'trim|required|min_length[6]|matches[reg-password]');

        if ($this->form_validation->run() === false) {
            // validation not ok, send validation errors to the view
            $data->error = validation_errors();
            $data->redirect_page_error = '';
            $data->redirect_page_success = '';
            $data->success = 0;
        } else {

            // set variables from the form
            $email = $this->input->post('reg-email');
            $password = $this->input->post('reg-password');

            if ($this->user_model->create_user($email, $password, 0)) {
                // user creation ok
                $data->error = '';
                $data->redirect_page_error = '';
                $data->redirect_page_success = '';
                $data->success = 1;

                $user_id = $this->user_model->get_user_id_from_email($email);
                $user = $this->user_model->get_user($user_id);

                // set session user datas
                $_SESSION['user_id'] = (int) $user->id;
                $_SESSION['type'] = 'client';
                $_SESSION['email'] = (string) $user->email;
                $_SESSION['logged_in'] = (bool) true;
                $_SESSION['is_confirmed'] = (bool) $user->is_confirmed;
                $_SESSION['is_admin'] = (bool) $user->is_admin;
            } else {
                // user creation failed, this should never happen
                $data->error = 'There was a problem creating your new account. Please try again.';
                $data->redirect_page_error = '';
                $data->redirect_page_success = '';
                $data->success = 0;
            }
        }
        echo json_encode($data);
    }

    public function wlop_log_in($op) {
        $this->load->model('wl_model');
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->model('user_model');

        $data = new stdClass();
        $data_tmp = $this->session->flashdata('data');
        $this->session->set_flashdata('data', $data_tmp);

        // load form helper and validation library
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set validation rules
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        //Validation Recaptcha
        $recaptcha = $_POST['g-recaptcha-response'];
        //log_message("ERROR",print_r($recaptcha,TRUE));
        if ($recaptcha) {
            $secret = "6LcU7iMUAAAAAHnVRYvEE5SZzzesOh6vl2felU9x";
            $ip = $_SERVER['REMOTE_ADDR'];
            //log_message("ERROR",print_r($ip,TRUE));
            $var = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $recaptcha . "&remopteip=" . $ip);
            $get_resGoogle = json_decode($var, TRUE);
            if ($get_resGoogle['success']) { //log_message("ERROR",print_r($get_resGoogle,TRUE));
            } else {
                $this->form_validation->set_rules('recaptcha', 'recaptcha', 'required');
            }
        } else {
            $this->form_validation->set_rules('recaptcha', 'recaptcha', 'required');
        }

        if ($this->form_validation->run() == false) {
            // validation not ok, send validation errors to the view
            $data->error = validation_errors();
            $data->redirect_page_error = '';
            $data->redirect_page_success = '';
            $data->success = 0;
        } else {
            // set variables from the form
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            if ($this->user_model->resolve_user_login($email, $password)) {

                $user_id = $this->user_model->get_user_id_from_email($email);
                $user = $this->user_model->get_user($user_id);

                // set session user datas
                $_SESSION['user_id'] = (int) $user["id"];
                $_SESSION['type'] = 'client';
                $_SESSION['email'] = (string) $user["email"];
                $_SESSION['logged_in'] = (bool) true;
                $_SESSION['is_confirmed'] = (bool) $user["is_confirmed"];
                $_SESSION['is_admin'] = (bool) $user["is_admin"];

                // user login ok
                $data->error = '';
                $data->redirect_page_error = '';
                if (isset($data_tmp['returnTo']) && $data_tmp['returnTo'] != '')
                    $data->redirect_page_success = $data_tmp['returnTo'];
                else
                    $data->redirect_page_success = '';
                $data->success = 1;
            }
            else {
                // login failed
                $data->error = 'Wrong username or password.';
                $data->redirect_page_error = '';
                $data->redirect_page_success = '';
                $data->success = 0;
            }
        }

        echo json_encode($data);
    }

    public function wlop_log_in_private($op) {
        $this->load->model('wl_model');
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->model('user_model');

        $data = new stdClass();
        $data_tmp = $this->session->flashdata('data');
        $this->session->set_flashdata('data', $data_tmp);

        // load form helper and validation library
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set validation rules
        $this->form_validation->set_rules('agent_id', 'Agent ID', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        //Validation Recaptcha
        $recaptcha = $_POST['g-recaptcha-response'];
        //log_message("ERROR",print_r($recaptcha,TRUE));
        if ($recaptcha) {
            $secret = "6LcU7iMUAAAAAHnVRYvEE5SZzzesOh6vl2felU9x";
            $ip = $_SERVER['REMOTE_ADDR'];
            //log_message("ERROR",print_r($ip,TRUE));
            $var = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $recaptcha . "&remopteip=" . $ip);
            $get_resGoogle = json_decode($var, TRUE);
            if ($get_resGoogle['success']) { //log_message("ERROR",print_r($get_resGoogle,TRUE));
            } else {
                $this->form_validation->set_rules('recaptcha', 'recaptcha', 'required');
            }
        } else {
            $this->form_validation->set_rules('recaptcha', 'recaptcha', 'required');
        }

        if ($this->form_validation->run() == false) {
            // validation not ok, send validation errors to the view
            $data->error = validation_errors();
            $data->redirect_page_error = '';
            $data->redirect_page_success = '';
            $data->success = 0;
        } else {
            // set variables from the form
            $agent_id = ctype_digit($this->input->post('agent_id')) ? intval($this->input->post('agent_id')) : 0;
            $password = $this->input->post('password');

            if ($this->user_model->resolve_user_login_agent($agent_id, $password)) {

                $agent = $this->user_model->get_agent($agent_id, $op);

                // set session agent datas
                $_SESSION['user_id'] = (int) $agent["no"];
                $_SESSION['type'] = 'agent';
                $_SESSION['email'] = (string) $agent["email"];
                $_SESSION['logged_in'] = (bool) true;
                $_SESSION['is_confirmed'] = 1;
                $_SESSION['is_admin'] = 0;
                $_SESSION['username'] = (string) $agent["nome"];

                // agent login ok
                $data->error = '';
                $data->redirect_page_error = '';
                if (isset($data_tmp['returnTo']) && $data_tmp['returnTo'] != '')
                    $data->redirect_page_success = $data_tmp['returnTo'];
                else
                    $data->redirect_page_success = '';
                $data->success = 1;
            }
            else {
                // login failed
                $data->error = 'Wrong username or password.';
                $data->redirect_page_error = '';
                $data->redirect_page_success = '';
                $data->success = 0;
            }
        }

        echo json_encode($data);
    }

    public function wlop_logout($op) {
        $this->load->model('wl_model');
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->model('user_model');
        // create the data object
        $data = new stdClass();

        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            // remove session datas
            foreach ($_SESSION as $key => $value) {
                unset($_SESSION[$key]);
            }
            // user logout ok
            redirect(base_url() . 'wl/' . $op);
        } else {
            // there user was not logged in, we cannot logged him out,
            // redirect him to site root
            redirect(base_url() . 'wl/' . $op);
        }
    }

    public function pdf() {
        $this->load->library(array('Mssql'));
        $bostamp = $this->uri->segment(4);
        $this->pdf = new Pdf3();

        $query = "
			select 
				bi.bistamp, bi.qtt
			from bi 
				inner join bo on bi.bostamp = bo.bostamp
			where
				bi.bostamp = '" . trim($bostamp) . "' and
				bi.ref not like 'TAX'
		";

        $product = $this->mssql->mssql__select($query);

        foreach ($product as $producto) {
            $bit = $producto['bistamp'];

            $this->pdf->setbostamp($bit);
            if ($producto['qtt'] > 1) {
                for ($i = 1; $i <= $producto['qtt']; $i++) {
                    $this->pdf->AddPage();
                }
            } else {
                $this->pdf->AddPage();
            }
        }
        $this->pdf->AliasNbPages();
        $this->pdf->SetTitle("Ticket");
        $this->pdf->Output("Tickets.pdf", 'D');
    }

}

?>