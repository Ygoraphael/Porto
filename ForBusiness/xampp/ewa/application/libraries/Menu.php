<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu {

    protected $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->library(array('session'));
    }

    public function GetMenusInPosition($position) {
        $query = $this->CI->db->query('SELECT * FROM menu where position = ' . $this->CI->db->escape($position));
        foreach ($query->result_array() as $row) {
            $this->RenderMenu($row);
        }
    }

    public function RenderMenu($row) {
        if ($row["type"] == 1) {
            if ($row["toggle"] == 1) {
                echo '<nav class="navbar navbar-inverse navbar-static-top" style="background:#1b2a33; border:0;">';
                echo '	
					<div class="container">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar3">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
					';
                if (trim($row["logo"]) <> '') {
                    echo '<a class="navbar-brand" href="' . base_url() . trim($row["url"]) . '"><img src="' . base_url() . trim($row["logo"]) . '" alt="' . trim($row["title"]) . '" rel="' . trim($row["title"]) . '"></a>';
                }
                echo '
						</div>
						<div id="navbar3" class="navbar-collapse collapse">
							<ul class="nav navbar-nav navbar-right">
						';

                $query = $this->CI->db->query("SELECT * FROM menu_item where menu_id = " . $this->CI->db->escape($row["id"]) . " and parent = 0 order by lorder");
                foreach ($query->result_array() as $row2) {
                    if (trim($row2["type"]) == "language") {
                        //language
                        $query3 = $this->CI->db->query("SELECT language, code FROM u_lang order by language");
                        if (sizeof($query3->result_array()) > 0) {
                            echo $this->RenderMenuItemLanguage($row2, $query3->result_array());
                        }
                    } else if ($row2["type"] == "currency") {
                        //currency
                        $query4 = $this->CI->db->query("SELECT type_currency, i, ch FROM currency order by type_currency");
                        if (sizeof($query4->result_array()) > 0) {
                            echo $this->RenderMenuItemCurrency($row2, $query4->result_array());
                        }
                    } else {
                        //User_data
                        $query = $this->CI->db->query("SELECT * FROM menu_item where menu_id = " . $this->CI->db->escape($row["id"]) . " and parent = " . $row2["id"] . " order by lorder");
                        if (sizeof($query->result_array()) > 0) {
                            echo $this->RenderMenuItemDropdown($row2, $query->result_array());
                        } else {
                            echo $this->RenderMenuItem($row2, 1);
                        }
                    }
                }
                echo '
							</ul>
						</div>
						<!--/.nav-collapse -->
					</div>
					<!--/.container-fluid -->
				</nav>
				';
            } else {
                
            }
        } else if ($row["type"] == 2) {
            if ($row["toggle"] == 0) {

                $query = $this->CI->db->query("SELECT * FROM menu_item where menu_id = " . $this->CI->db->escape($row["id"]) . " and parent = 0 order by lorder");
                foreach ($query->result_array() as $row2) {
                    $query = $this->CI->db->query("SELECT * FROM menu_item where menu_id = " . $this->CI->db->escape($row["id"]) . " and parent = " . $row2["id"] . " order by lorder");
                    echo $this->RenderMenuItem($row2, 2);
                }
            } else {
                
            }
        }
    }

    public function RenderMenuItem($row, $render_type) {
        if ($render_type == 1) {
            if ($row["logged_only"] == "0" || ( $row["logged_only"] == "1" && $this->CI->session->userdata('logged_in') )) {
                if ($row["type"] == "url") {
                    return '<li><a href="' . base_url() . $row["url"] . '">' . $row["text"] . '</a></li>';
                } else if ($row["type"] == "login_popup" && !$this->CI->session->userdata('logged_in')) {
                    return '<li><a data-toggle="modal" href="' . base_url() . 'login_popup" data-target="#myModal">' . $row["text"] . '</a></li>';
                } else if ($row["type"] == "user_data") {
                    return '<li><a href="' . base_url() . $row["url"] . '">' . $_SESSION[$row["text"]] . '</a></li>';
                }
                if ($row["type"] == "tank") {
                    return '<li><a href="' . $row["url"] . '">' . $row["text"] . '</a></li>';
                }
            }
        } else if ($render_type == 2) {
            if ($row["logged_only"] == "0" || ( $row["logged_only"] == "1" && $this->CI->session->userdata('logged_in') )) {
                if ($row["type"] == "url") {
                    return '<h4><a href="' . base_url() . $row["url"] . '">' . $row["text"] . '</a></h4>';
                } else if ($row["type"] == "login_popup" && !$this->CI->session->userdata('logged_in')) {
                    return '<h4><a data-toggle="modal" href="' . base_url() . 'login_popup" data-target="#myModal">' . $row["text"] . '</a></h4>';
                } else if ($row["type"] == "user_data") {
                    return '<h4><a href="' . base_url() . $row["url"] . '">' . $_SESSION[$row["text"]] . '</a></h4>';
                }
            }
        }
    }

    public function RenderMenuItemDropdown($row2, $result) {
        if ($row2["logged_only"] == "0" || ( $row2["logged_only"] == "1" && $this->CI->session->userdata('logged_in') )) {
            echo '<li class="dropdown">';
            if ($row2["type"] == "user_data") {
                echo '<a href="' . base_url() . $row2["url"] . '" class="dropdown-toggle" data-toggle="dropdown">' . $_SESSION[$row2["text"]] . ' <b class="caret"></b></a>';
            } else {
                echo '<a href="' . base_url() . $row2["url"] . '" class="dropdown-toggle" data-toggle="dropdown">' . $row2["text"] . ' <b class="caret"></b></a>';
            }

            echo '<ul class="dropdown-menu">';
            foreach ($result as $row3) {
                echo $this->RenderMenuItem($row3, 1);
            }
            echo '</ul>
				</li>';
        }
    }

    public function RenderMenuItemLanguage($row2, $result) {
        if ($row2["logged_only"] == "0" || ( $row2["logged_only"] == "1" && $result != '' )) {
            echo '<li class="dropdown">';
            if ($row2["type"] == "language") {
                echo '<a class="btn btn-secondary dropdown-toggle" style="text-align:left" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >' . $_SESSION["language"] . '<b class="caret"></b></a>';
            }
            echo '<ul class="dropdown-menu" language_drop>';
            if ($row2["type"] == "language") {
                foreach ($result as $lang) {
                    echo '<li onclick="set_language(\'' . $lang["language"] . '\', \'' . $lang["code"] . '\');" role="presentation");">';
                    echo '<a role="menuitem" tabindex="-1" href="#" >' . '<img style="max-height:20px" src="' . base_url() . 'img/flags/' . $lang["language"] . '.png" /> ' . $lang["language"] . ' </a>';
                }
            }
            echo '</li></ul>
				</li>';
        }
    }

    public function RenderMenuItemCurrency($row2, $result) {
        if ($row2["logged_only"] == "0" || ( $row2["logged_only"] == "1" && $result != '' )) {
            echo '<li class="dropdown">';
            if ($row2["type"] == "currency") {
                echo '<a class="btn btn-secondary dropdown-toggle" style="text-align:left" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><i style="font-size:15px" class="fa">' . $_SESSION["i"] . '</i> ' . $_SESSION["ch"] . '<b class="caret"></b></a>';
            }
            echo '<ul class="dropdown-menu" language_drop>';
            if ($row2["type"] == "currency") {
                foreach ($result as $currenc) {
                    echo '<li onclick="set_currency(\'' . $currenc["type_currency"] . '\', \'' . $currenc["i"] . '\', \'' . $currenc["ch"] . '\');" role="presentation");">';
                    echo '<a role="menuitem3" tabindex="-1" href="#" >' . '<i class="fa">' . $currenc["i"] . '</i> ' . $currenc["type_currency"] . ' </a>';
                }
            }
            echo '</li></ul>
				</li>';
        }
    }

}
