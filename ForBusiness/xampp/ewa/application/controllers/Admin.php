<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('translation');
        $this->load->library('template');
        $this->template->set_template('admin/template_admin');
        $this->load->model('user_model');

        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
            
        } else {
            $data['returnTo'] = 'admin';
            $this->session->set_flashdata('data', $data);
            redirect('login');
        }
    }

    public function index() {
        $this->template->frontpage = "false";

        $data['pagina'] = "";

        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
            $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
            if ($data['user']["is_admin"] == '1') {
                $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
                $data['title'] = 'HOME';
                $data['buttons'] = '0';
                $this->template->content->view('admin/admin', $data);
                $this->template->publish();
            } else {
                redirect('/admin/denied');
            }
        }
    }

    public function pages() {
        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
            $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
            if ($data['user']["is_admin"] == '1') {
                $this->template->frontpage = "false";
                $this->load->model('admin_model');
                $data['title'] = 'PAGES';
                $data['pagina'] = "";
                $data["pages"] = $this->admin_model->get_page();
                $data['buttons'] = '2';
                $data['url'] = 'admin/editpages';
                $this->template->content->view('admin/listpages', $data);
                $this->template->publish();
            } else {
                redirect('/admin/denied');
            }
        }
    }

    public function metatags() {
        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
            $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
            if ($data['user']["is_admin"] == '1') {
                $this->template->frontpage = "false";
                $this->load->model('admin_model');
                $data['title'] = 'Meta Tags';
                $data['pagina'] = "";
                $data["pages"] = $this->admin_model->getMeta_tags();
                $data['url'] = 'admin/metatagnew';
                $data['buttons'] = '2';
                $this->template->content->view('admin/metatags', $data);
                $this->template->publish();
            } else {
                redirect('/admin/denied');
            }
        }
    }

    public function metatagnew() {
        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
            $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
            if ($data['user']["is_admin"] == '1') {
                $this->template->frontpage = "false";
                $this->load->model('admin_model');
                $id_post = $this->input->post('id');
                $id_error = $this->input->post('error');
                $texterror1 = $this->input->post('text1');
                $texterror2 = $this->input->post('text2');
                if ($id_error == 1) {
                    $data["error"] = '<script> document.getElementById("debug_message").innerHTML=\'<div role="alert" class="alert alert-success alert-dismissible"><button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="s7-close"></span></button><span class="icon s7-check"></span><strong>' . $texterror1 . '</strong>' . $texterror2 . '</div>\';</script>';
                } elseif ($id_error == 2) {
                    $data["error"] = '<script> document.getElementById("debug_message").innerHTML=\'<div role="alert" class="alert alert-danger alert-dismissible"><button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="s7-close"></span></button><span class="icon s7-close-circle"></span><strong>' . $texterror1 . '</strong>' . $texterror2 . '</div>\';</script>';
                }

                $data['title'] = 'SEO';

                if ($id_post == "") {
                    $id_post = 0;
                    $data['pagina'] = " - NEW METATAG";
                    $data['buttons'] = '3';
                } else {
                    $data["tag_byid"] = $this->admin_model->getMeta_tag_id($id_post);
                    $data['pagina'] = "-" . $data["tag_byid"]->name;
                    $data['buttons'] = '1';
                    $data['url'] = 'admin/metatags';
                }
                $data['id_post'] = $id_post;
                $this->template->content->view('admin/metatags/metatag', $data);
                $this->template->publish();
            } else {
                redirect('/admin/denied');
            }
        }
    }

    public function denied() {
        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
            $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
            if ($data['user']["is_admin"] == '0') {
                $this->template->frontpage = "false";
                $data['title'] = 'DENIED';
                $data['pagina'] = "";
                $data['buttons'] = '0';
                $this->template->content->view('admin/admin_denied', $data);
                $this->template->publish();
            }
        }
    }

    public function ajax() {
        $this->load->model('user_model');
        $this->load->model('admin_model');

        $sefurl = $this->uri->segment(3);
        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
            //$data['user'] = $this->user_model->get_backoffice_user($_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"]);

            switch ($sefurl) {
                case 'delete_pages':
                    $data['id'] = $this->input->post('id');
                    $data['table'] = "pages";
                    $data['variable'] = "id";
                    $this->admin_model->delete_data($data);
                    break;

                case 'delete_menucat':
                    $data['id'] = $this->input->post('id');
                    $data['table'] = "menu";
                    $data['variable'] = "id";
                    $this->admin_model->delete_data($data);
                    break;
                case 'delete_user':
                    $data['id'] = $this->input->post('id');
                    $data['table'] = "users";
                    $data['variable'] = "id";
                    $this->admin_model->delete_data($data);
                    break;
                case 'delete_menuitem':
                    $data['id'] = $this->input->post('id');
                    $data['table'] = "menu_item";
                    $data['variable'] = "id";
                    $this->admin_model->delete_data($data);
                    break;
                case 'delete_plugins':
                    $data['id'] = $this->input->post('id');
                    $data['table'] = "plugin";
                    $data['variable'] = "id";
                    $this->admin_model->delete_data($data);
                    break;
                case 'delete_translations':
                    $data['id'] = $this->input->post('id');
                    $data['table'] = "u_translate";
                    $data['variable'] = "keyvalue";
                    $this->admin_model->delete_data($data);
                    break;
                case 'delete_metatag':
                    $data['id'] = $this->input->post('id');
                    $data['table'] = "seo_meta_tags";
                    $data['variable'] = "id";
                    $this->admin_model->delete_data($data);
                    break;
                case 'translations2':
                    $lang = $this->input->post('lang');
                    //log_message('ERROR', print_r($lang,TRUE));
                    echo json_encode($this->translation_model->get_translations2($lang));
                    break;

                default:
                    echo 'Nothing to do';
                    break;
            }
        }
    }

    public function translations() {
        $this->load->model('translation_model');

        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
            $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);

            if ($data['user']["is_admin"] == '1') {
                $this->template->frontpage = "false";
                $language = "English";

                $data["translations"] = $this->translation_model->get_translations2($language);
                $data['title'] = 'Translations';
                $data['pagina'] = "";
                $data['buttons'] = '2';
                $data['url'] = 'admin/edit_translations';
                $data["comboboxlanguages"] = $this->translation_model->get_languages();

                $this->template->content->view('admin/listtranslations', $data);
                $this->template->publish();
            } else {
                redirect('/admin/denied');
            }
        }
    }

    public function users() {
        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
            $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
            if ($data['user']["is_admin"] == '1') {
                $this->template->frontpage = "false";
                $this->load->model('admin_model');
                $data['title'] = 'USERS';
                $data['pagina'] = "";
                $data["users"] = $this->admin_model->get_users();
                $data['buttons'] = '2';
                $data['url'] = 'admin/editusers';
                $this->template->content->view('admin/listusers', $data);
                $this->template->publish();
            } else {
                redirect('/admin/denied');
            }
        }
    }

    public function plugin() {
        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
            $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
            if ($data['user']["is_admin"] == '1') {
                $this->template->frontpage = "false";
                $this->load->model('admin_model');
                $data['title'] = 'PLUGIN';
                $data['pagina'] = "";
                $data["plugins"] = $this->admin_model->get_plugin();
                $data['buttons'] = '2';
                $data['url'] = 'admin/editplugin';
                $this->template->content->view('admin/listplugins', $data);
                $this->template->publish();
            } else {
                redirect('/admin/denied');
            }
        }
    }

    public function menusitem() {
        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
            $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
            if ($data['user']["is_admin"] == '1') {
                $this->template->frontpage = "false";
                $this->load->model('admin_model');
                $data['title'] = 'MENUS ITEM';
                $data['pagina'] = "";
                $data["menus"] = $this->admin_model->get_menus(1);
                $data['buttons'] = '2';
                $data['url'] = 'admin/menusitemnew';
                $this->template->content->view('admin/listmenus', $data);
                $this->template->publish();
            } else {
                redirect('/admin/denied');
            }
        }
    }

    public function menuscategory() {
        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
            $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
            if ($data['user']["is_admin"] == '1') {
                $this->template->frontpage = "false";
                $this->load->model('admin_model');
                $data['title'] = 'MENUS CATEGORY';
                $data['pagina'] = "";
                $data['buttons'] = '2';
                $data['url'] = 'admin/menuscategorynew';
                $data["menus"] = $this->admin_model->get_menus_category();
                $this->template->content->view('admin/listmenuscat', $data);
                $this->template->publish();
            } else {
                redirect('/admin/denied');
            }
        }
    }

    public function order() {
        $this->load->model('admin_model');
        $id = $this->input->post('id');
        $result = $this->admin_model->get_orderitem($id)->result();

        echo json_encode($result);
    }

    public function menu_child() {
        $this->load->model('admin_model');

        $id = $this->input->post('id');
        $result = $this->admin_model->get_menus_child($id)->result();

        echo json_encode($result);
    }

    public function menusitemnew() {
        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
            $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
            if ($data['user']["is_admin"] == '1') {
                $this->template->frontpage = "false";
                $this->load->model('admin_model');
                $id_post = $this->input->post('id');
                $id_error = $this->input->post('error');
                $texterror1 = $this->input->post('text1');
                $texterror2 = $this->input->post('text2');
                if ($id_error == 1) {
                    $data["error"] = '<script> document.getElementById("debug_message").innerHTML=\'<div role="alert" class="alert alert-success alert-dismissible"><button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="s7-close"></span></button><span class="icon s7-check"></span><strong>' . $texterror1 . '</strong>' . $texterror2 . '</div>\';</script>';
                } elseif ($id_error == 2) {
                    $data["error"] = '<script> document.getElementById("debug_message").innerHTML=\'<div role="alert" class="alert alert-danger alert-dismissible"><button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="s7-close"></span></button><span class="icon s7-close-circle"></span><strong>' . $texterror1 . '</strong>' . $texterror2 . '</div>\';</script>';
                }

                $data['title'] = 'MENUS';

                if ($id_post == "") {
                    $id_post = 0;
                    $data['pagina'] = " - NEW ITEM";
                    $data['buttons'] = '3';
                } else {
                    $data["menu_byid"] = $this->admin_model->get_menus_byid($id_post);
                    $data['pagina'] = "-" . $data["menu_byid"]->text;
                    $data['category_id'] = $data["menu_byid"]->id_category;
                    $data['buttons'] = '1';
                    $data['url'] = 'admin/menusitem';
                }

                $data['comboboxparent'] = $this->admin_model->get_menus(0);
                $data['comboboxcategory'] = $this->admin_model->get_menus_category();
                $data['id_post'] = $id_post;

                $this->template->content->view('admin/menus/menus_item', $data);
                $this->template->publish();
            } else {
                redirect('/admin/denied');
            }
        }
    }

    public function menuscategorynew() {
        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
            $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
            if ($data['user']["is_admin"] == '1') {
                $this->template->frontpage = "false";
                $this->load->model('admin_model');
                $id_post = $this->input->post('id');
                $id_error = $this->input->post('error');
                $texterror1 = $this->input->post('text1');
                $texterror2 = $this->input->post('text2');
                if ($id_error == 1) {
                    $data["error"] = '<script> document.getElementById("debug_message").innerHTML=\'<div role="alert" class="alert alert-success alert-dismissible"><button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="s7-close"></span></button><span class="icon s7-check"></span><strong>' . $texterror1 . '</strong>' . $texterror2 . '</div>\';</script>';
                } elseif ($id_error == 2) {
                    $data["error"] = '<script> document.getElementById("debug_message").innerHTML=\'<div role="alert" class="alert alert-danger alert-dismissible"><button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="s7-close"></span></button><span class="icon s7-close-circle"></span><strong>' . $texterror1 . '</strong>' . $texterror2 . '</div>\';</script>';
                }

                $data['title'] = 'MENUS';

                if ($id_post == "") {
                    $id_post = 0;
                    $data['pagina'] = " - NEW CATEGORY";
                    $data['buttons'] = '3';
                } else {
                    $data["menu_byid"] = $this->admin_model->get_menus_bycategory($id_post);
                    $data['pagina'] = "-" . $data["menu_byid"]->title;
                    $data['buttons'] = '1';
                    $data['url'] = 'admin/menuscategory';
                }

                $data['id_post'] = $id_post;

                $this->template->content->view('admin/menus/menus_category', $data);
                $this->template->publish();
            } else {
                redirect('/admin/denied');
            }
        }
    }

    public function editplugin() {
        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
            $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
            if ($data['user']["is_admin"] == '1') {
                $this->template->frontpage = "false";
                $this->load->model('admin_model');
                $id_post = $this->input->post('id');
                $id_error = $this->input->post('error');
                $texterror1 = $this->input->post('text1');
                $texterror2 = $this->input->post('text2');
                if ($id_error == 1) {
                    $data["error"] = '<script> document.getElementById("debug_message").innerHTML=\'<div role="alert" class="alert alert-success alert-dismissible"><button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="s7-close"></span></button><span class="icon s7-check"></span><strong>' . $texterror1 . '</strong>' . $texterror2 . '</div>\';</script>';
                } elseif ($id_error == 2) {
                    $data["error"] = '<script> document.getElementById("debug_message").innerHTML=\'<div role="alert" class="alert alert-danger alert-dismissible"><button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="s7-close"></span></button><span class="icon s7-close-circle"></span><strong>' . $texterror1 . '</strong>' . $texterror2 . '</div>\';</script>';
                }

                $data['title'] = 'PLUGIN';
                $data['pagina'] = "";
                $data['url'] = 'admin/';

                if ($id_post == "") {
                    $id_post = 0;
                    $data['pagina'] = " - NEW PLUGIN";
                    $data['buttons'] = '3';
                } else {
                    $data["plugin"] = $this->admin_model->get_plugin_byid($id_post);
                    $data["pluginspage"] = $this->admin_model->get_plugin_pages($id_post);
                    $data['pagina'] = "-" . $data["plugin"]->title;
                    $data['buttons'] = '1';
                    $data['position_id'] = $data["plugin"]->position;
                    $data['url'] = 'admin/plugin';
                }
                $data['comboboxposition'] = $this->admin_model->get_positions();
                $data['id_post'] = $id_post;
                $this->template->content->view('admin/plugins/editplugins', $data);
                $this->template->publish();
            } else {
                redirect('/admin/denied');
            }
        }
    }

    public function editusers() {

        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
            $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
            if ($data['user']["is_admin"] == '1') {
                $this->template->frontpage = "false";
                $this->load->model('admin_model');
                $id_post = $this->input->post('id');
                $id_error = $this->input->post('error');
                $texterror1 = $this->input->post('text1');
                $texterror2 = $this->input->post('text2');
                if ($id_error == 1) {
                    $data["error"] = '<script> document.getElementById("debug_message").innerHTML=\'<div role="alert" class="alert alert-success alert-dismissible"><button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="s7-close"></span></button><span class="icon s7-check"></span><strong>' . $texterror1 . '</strong>' . $texterror2 . '</div>\';</script>';
                } elseif ($id_error == 2) {
                    $data["error"] = '<script> document.getElementById("debug_message").innerHTML=\'<div role="alert" class="alert alert-danger alert-dismissible"><button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="s7-close"></span></button><span class="icon s7-close-circle"></span><strong>' . $texterror1 . '</strong>' . $texterror2 . '</div>\';</script>';
                }

                $data['title'] = 'USERS';
                $data['pagina'] = "";
                $data['url'] = 'admin/';
                $data['fields'] = $this->admin_model->get_fields()->result();
                if ($id_post == "") {
                    $id_post = 0;
                    $data['pagina'] = " - NEW USER";
                    $data['buttons'] = '3';
                } else {
                    $data["user"] = $this->admin_model->get_users_byid($id_post);
                    $data['pagina'] = "-" . $data["user"]->first_name;
                    $data['buttons'] = '1';
                    $data['url'] = 'admin/users';
                }
                $data['comboboxposition'] = $this->admin_model->get_positions();
                $data['id_post'] = $id_post;
                $this->template->content->view('admin/users/editusers', $data);
                $this->template->publish();
            } else {
                redirect('/admin/denied');
            }
        }
    }

    public function editpages() {
        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
            $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
            if ($data['user']["is_admin"] == '1') {
                $this->template->frontpage = "false";
                $this->load->model('admin_model');
                $id_post = $this->input->post('id');
                $id_error = $this->input->post('error');
                $texterror1 = $this->input->post('text1');
                $texterror2 = $this->input->post('text2');
                if ($id_error == 1) {
                    $data["error"] = '<script> document.getElementById("debug_message").innerHTML=\'<div role="alert" class="alert alert-success alert-dismissible"><button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="s7-close"></span></button><span class="icon s7-check"></span><strong>' . $texterror1 . '</strong>' . $texterror2 . '</div>\';</script>';
                } elseif ($id_error == 2) {
                    $data["error"] = '<script> document.getElementById("debug_message").innerHTML=\'<div role="alert" class="alert alert-danger alert-dismissible"><button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="s7-close"></span></button><span class="icon s7-close-circle"></span><strong>' . $texterror1 . '</strong>' . $texterror2 . '</div>\';</script>';
                }

                $data['title'] = 'PAGES';
                $data['pagina'] = "";
                $data['url'] = 'admin/';

                if ($id_post == "") {
                    $id_post = 0;
                    $data['pagina'] = " - NEW PAGE";
                    $data['buttons'] = '3';
                } else {
                    $data["page"] = $this->admin_model->get_page_byid($id_post);
                    $data['pagina'] = "-" . $data["page"]->title;
                    $data['buttons'] = '1';
                    $data['url'] = 'admin/pages';
                }

                $data['id_post'] = $id_post;
                $this->template->content->view('admin/pages/new_page', $data);
                $this->template->publish();
            } else {
                redirect('/admin/denied');
            }
        }
    }

    public function edit_translations() {
        $this->load->model('translation_model');

        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
            $data['user'] = $this->user_model->get_user($_SESSION["user_id"]);

            if ($data['user']["is_admin"] == '1') {
                $this->template->frontpage = "false";
                $id_post = $this->input->post('id');
                $id_error = $this->input->post('error');
                $texterror1 = $this->input->post('text1');
                $texterror2 = $this->input->post('text2');

                if ($id_error == 1) {
                    $data["error"] = '<script> document.getElementById("debug_message").innerHTML=\'<div  class="alert " ><button type="button" data-dismiss="alert" aria-label="Close" class="close"><span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span></button><span class="icon s7-check"></span><strong>' . $texterror1 . '</strong>' . $texterror2 . '</div>\';</script>';
                } else if ($id_error == 2) {
                    $data["error"] = '<script> document.getElementById("debug_message").innerHTML=\'<div  class="alert warning" ><button type="button" data-dismiss="alert" aria-label="Close" class="close"><span class="closebtn" onclick="this.parentElement.style.display="none";">&times;<span aria-hidden="true" class="s7-close"></span></button><span class="icon s7-close-circle"></span><strong>' . $texterror1 . '</strong>' . $texterror2 . '</div>\';</script>';
                }
                $data['title'] = 'Translation';
                $data['pagina'] = "";
                $data['url'] = 'admin/';

                if ($id_post == "") {
                    $id_post = 0;
                    $data['pagina'] = " - NEW Translation";
                    $data['buttons'] = '3';
                } else {
                    $data["translation"] = $this->translation_model->get_translations_by_id($id_post);
                    foreach ($data["translation"] as $date) {
                        $data["testar"] = $date;
                    }
                    $data['buttons'] = '1';
                    $data['url'] = 'admin/translations';
                }

                $data["comboboxlanguages"] = $this->translation_model->get_languages();

                // log_message('ERROR', print_r($data["comboboxlanguages"],TRUE));

                $data['id_post'] = $id_post;
                $this->template->content->view('admin/translation/new_translation', $data);
                $this->template->publish();
            } else {
                redirect('/admin/denied');
            }
        }
    }

    public function create_item_pages() {
        $this->load->model('admin_model');
        $title = $this->input->post('title');
        $alias = $this->generate_seo_link($title, '-', true);
        $content = $this->input->post('content');

        $result = $this->admin_model->create_page($alias, $title, $content);

        echo $result;
    }

    public function create_plugin() {
        $this->load->model('admin_model');
        $title = $this->input->post('title');
        $url = $this->input->post('url');
        $position = $this->input->post('position');
        $input = $this->input->post('input');

        $result = $this->admin_model->create_plugin($url, $title, $position, $input);

        echo $result;
    }

    public function create_country() {
        $this->load->model('translation_model');
        $country = $this->input->post('country');
        $flag = $this->input->post('flag');
        $code = $this->input->post('code');

        $result = $this->translation_model->create_country($country, $flag, $code);

        echo $result;
    }

    public function create_translation() {
        $this->load->model('translation_model');
        $key = $this->input->post('key');
        $value = $this->input->post('value');
        $language = $this->input->post('language');

        $result = $this->translation_model->create_translation($key, $value, $language);

        echo $result;
    }

    public function create_menu_item() {
        $this->load->model('admin_model');

        $text = $this->input->post('text');
        $url = $this->input->post('url');
        $parent = $this->input->post('parent');
        $category_id = $this->input->post('category_id');
        $logged_only = $this->input->post('logged_only');
        $type = $this->input->post('type');
        $lorder = $this->input->post('lorder');

        $result = $this->admin_model->create_menu_item($text, $url, $parent, $category_id, $logged_only, $type, $lorder);

        echo $result;
    }

    public function create_metatag() {
        $this->load->model('admin_model');

        $name = $this->input->post('name');
        $content = $this->input->post('content');

        $result = $this->admin_model->create_metatag($name, $content);

        echo $result;
    }

    public function create_menu_category() {
        $this->load->model('admin_model');

        $title = $this->input->post('title');
        $url = $this->input->post('url');
        $name = $this->input->post('name');
        $logo = $this->input->post('logo');
        $position = $this->input->post('position');
        $toggle = $this->input->post('toggle');
        $type = $this->input->post('type');

        $result = $this->admin_model->create_menu_category($title, $url, $name, $logo, $position, $toggle, $type);

        echo $result;
    }

    public function update_menu_item() {
        $this->load->model('admin_model');

        $id = $this->input->post('id');
        $text = $this->input->post('text');
        $url = $this->input->post('url');
        $parent = $this->input->post('parent');
        $category_id = $this->input->post('category_id');
        $logged_only = $this->input->post('logged_only');
        $type = $this->input->post('type');
        $lorder = $this->input->post('lorder');

        $result = $this->admin_model->update_menu_item($id, $text, $url, $parent, $category_id, $logged_only, $type, $lorder);

        echo $result;
    }

    public function update_metatag() {
        $this->load->model('admin_model');
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $content = $this->input->post('content');
        $result = $this->admin_model->update_metatag($id, $name, $content);
        echo $result;
    }

    public function create_users() {
        $this->load->model('admin_model');
        $fields = $this->input->post('fields');
        $result = $this->admin_model->create_users($fields);

        echo $result;
    }

    public function update_item_pages() {
        $this->load->model('admin_model');
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $content = $this->input->post('content');

        $result = $this->admin_model->update_item_pages($id, $title, $content);

        echo $result;
    }

    public function update_users() {
        $this->load->model('admin_model');
        $fields = $this->input->post('fields');
        $id = $this->input->post('id');

        $result = $this->admin_model->update_users($id, $fields);

        echo $result;
    }

    public function update_menu_category() {
        $this->load->model('admin_model');

        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $url = $this->input->post('url');
        $name = $this->input->post('name');
        $logo = $this->input->post('logo');
        $position = $this->input->post('position');
        $toggle = $this->input->post('toggle');
        $type = $this->input->post('type');

        $result = $this->admin_model->update_menu_category($id, $title, $url, $name, $logo, $position, $toggle, $type);

        echo $result;
    }

    public function update_translation() {
        $this->load->model('translation_model');
        $u_translatestamp = $this->input->post('u_translatestamp');
        $key = $this->input->post('key');
        $value = $this->input->post('value');
        $language = $this->input->post('language');


        $result = $this->translation_model->update_translation($key, $value, $language, $u_translatestamp);

        echo $result;
    }

    public function update_country() {
        $this->load->model('translation_model');
        $country = $this->input->post('country');
        $flag = $this->input->post('flag');
        $code = $this->input->post('code');

        $result = $this->translation_model->update_country($country, $flag, $code);

        echo $result;
    }

    public function update_plugin() {
        $this->load->model('admin_model');
        $title = $this->input->post('title');
        $url = $this->input->post('url');
        $position = $this->input->post('position');
        $id = $this->input->post('id');
        $input = $this->input->post('input');

        $result = $this->admin_model->update_plugin($id, $url, $title, $position, $input);
        echo $result;
    }

    public function generate_seo_link2() {
        $this->load->model('admin_model');
        $title = $this->input->post('title');
        echo $result = $this->admin_model->get_alias($this->generate_seo_link($title, '-', true));
    }

    public function generate_seo_link($input, $replace = '-', $remove_words = true, $words_array = array()) {
        $words_array = array('a', 'é', 'ou', 'an', 'it', 'is', 'with', 'can', 'of', 'why', 'not');
        $return = trim(preg_replace('/ +/', ' ', preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($input))));
        if ($remove_words) {
            $return = $this->remove_words($return, $replace, $words_array);
        }
        return str_replace(' ', $replace, $return);
    }

    public function remove_words($input, $replace, $words_array = array(), $unique_words = true) {
        $input_array = explode(' ', $input);

        $return = array();
        foreach ($input_array as $word) {
            if (!in_array($word, $words_array) && ($unique_words ? !in_array($word, $return) : true)) {
                $return[] = $word;
            }
        }
        return implode($replace, $return);
    }

}
