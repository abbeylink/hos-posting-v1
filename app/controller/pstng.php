<?php

/**
 * 
 */
class pstng extends controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        if ($this->chk->isInstalled()) {
            load::view("pstng/index");
        } else {

            url::redirect("setup/requirement");
        }
    }

    function dashboard() {
        if (functions::isLoggedIn()) {
            load::view("pstng/dashboard", $this->id);
        } else {
            url::redirect("/");
        }
    }

    function nominal_roll() {
        if (functions::isLoggedIn()) {
            load::view("pstng/nominal_roll", $this->id);
        } else {

            url::redirect("setup/requirement");
        }
    }

    function proposal() {
        if (functions::isLoggedIn()) {
            load::view("pstng/proposal", $this->id);
        } else {

            url::redirect("setup/requirement");
        }
    }

    function pst() {
        if (functions::isLoggedIn()) {
            load::view("pstng/pst", $this->id);
        } else {

            url::redirect("setup/requirement");
        }
    }

    function process_pstng() {
        if (functions::isLoggedIn()) {
            load::view("pstng/process_pstng", $this->id);
        } else {

            url::redirect("setup/requirement");
        }
    }

    function view_pstng() {
        if (functions::isLoggedIn()) {
            load::view("pstng/view_pstng", $this->id);
        } else {

            url::redirect("setup/requirement");
        }
    }

    function upload() {
        if (functions::isLoggedIn()) {
            load::view("pstng/upload", $this->id);
        } else {

            url::redirect("setup/requirement");
        }
    }

    function report() {
        if (functions::isLoggedIn()) {
            load::view("pstng/report", $this->id);
        } else {

            url::redirect("setup/requirement");
        }
    }

    function profile() {

        $data = functions::get_loginuser_data();

        if (functions::isLoggedIn()) {
            $res['id'] = $this->id['id'];
            $res['first_name'] = $data['first_name'];
            $res['last_name'] = $data['last_name'];
            $res['sex'] = $data['sex'];
            $res['email_address'] = $data['email_address'];
            $res['phone_no'] = $data['phone_no'];
            load::view("pstng/profile", $res);
        } else {
            url::redirect("/");
        }
    }

    /* ------------------------------------------
     * Downloaad Nominal Roll Format
     * ******************************************
     */

    function format_nominal_roll() {
        $field = array('ippis_no', 'full_name', 'mda_location', 'rank', 'sgl', 'sex', 'dob', 'dopa', 'dofa', 'mda_name', 'department', 'cadre', 'phone');
        foreach ($field as $value) {
            $val = strtoupper(str_replace('_', " ", $value));
            $header[$val] = 'string';
        }
        $name = 'Nominal roll format';
        functions::download_format($header, $name);
    }

    /* ------------------------------------------
     * Download Posting History Format
     * ******************************************
     */

    function format_posting_history() {
        $field = $this->db->get_fieldname('posting_data');
        foreach ($field as $value) {
            $val = strtoupper(str_replace('_', " ", $value));
            $header[$val] = 'string';
        }
        $name = 'Posting history format';
        functions::download_format($header, $name);
    }

    function logout() {
        $user = $this->id['id'];
        if (functions::isLoggedIn()) {
            $this->session->_destroy($user);
            url::redirect("/");
        }
    }

}
?>


