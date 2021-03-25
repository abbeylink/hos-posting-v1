<?php

class auth extends controller {

    var $table;
    var $data = array();
    var $msg, $id;

    function __construct($datas) {
        parent::__construct();
        $this->table = 'user_login';
        $this->data = $datas;
        $this->msg = array();
        $this->id = url::get('q');
    }

    function table() {
        return$this->table;
    }

    function get_user_data() {
        $user = $this->db->get_data($this->table, $this->data);
        return$user;
    }

    function get_firstname() {
        $res = $this->get_user_data();
        return $res['first_name'];
    }

    function get_lastname() {
        $res = $this->get_user_data();
        return $res['last_name'];
    }

    function get_username() {
        $res = $this->get_user_data();
        return $res['username'];
    }

    function get_email() {
        $res = $this->get_user_data();
        return $res['email_address'];
    }

    function get_sec_question() {
        $res = $this->get_user_data();
        return $res['question'];
    }

    function get_answer() {
        $res = $this->get_user_data();
        return $res['answer'];
    }

    function get_isactive() {
        $res = $this->get_user_data();
        return $res['isactive'];
    }

    function get_isadmin() {
        $res = $this->get_user_data();
        return $res['isadmin'];
    }

    function get_isuser() {
        $res = $this->get_user_data();
        return $res['isuser'];
    }

    function get_change_pwd() {
        $res = $this->get_user_data();
        return $res['change_pwd'];
    }

    function role() {
        $res = '';
        if ($this->get_isadmin())
            $res = "admin";
        elseif ($this->get_isuser())
            $res = "staff";

        return$res;
    }

    function get_url() {
        $res = '';
//        $role = $this->role();
//        if ($role === 'admin')
//            $res = '/admin/';
//        else
        $res = '/pstng/';
        return$res;
    }

    function get_lastlogin() {
        $res = $this->get_user_data();
        return $res['last_login'];
    }

    function set_lastlogin() {
        $this->db->update_data($this->table, array('last_login' => $this->db->now()), array('username' => $this->get_username()));
    }

    function get_id() {
        $user = $this->get_username();
        $id = sha1($user);
        $ip = functions::get_ip();
        $this->session->_write($id, $user, $this->role(), $ip);
        return$id;
    }

    function get_auth() {
        $res = ($this->db->validate($this->table, $this->data)) ? true : FALSE;
        return$res;
    }

    function auth_user_cre() {
        $msg = array();
        $id = $this->get_id();
        $role = $this->role();
        $url = $this->get_url();
        if ($this->get_auth()) {
            //$this->set_lastlogin();
            switch ($role) {

                case'admin':
                    if ($this->get_change_pwd()) {
                        // $msg = $url."profile?q=$id";
                        $msg = $url . "dashboard?q=$id";
                    } else {
                        $msg = $url . "dashboard?q=$id";
                    }
                    break;
                case'staff':
                    if ($this->get_change_pwd()) {
                        // $msg = $url."profile?q=$id";
                        $msg = $url . "dashboard?q=$id";
                    } else {
                        $msg = $url . "dashboard?q=$id";
                    }
            }
        } else {
            $msg = 'Invalid';
        }

        return$msg;
    }
    
    
    
     /* ----------------------------------------------
     * GET USER PROFILES
     * -----------------------------------------
     */
//
//    function update_profile() {
//
//        $data = $this->com->get_form_data();
//        $pwd = sha1($data['c_pwd']);
//        $update['password'] = sha1($data['n_pwd']);
//        $update['first_name'] = $data['first_name'];
//        $update['last_name'] = $data['last_name'];
//        $update['phone_no'] = $data['phone_no'];
//        $update['email_address'] = $data['email_address'];
//        $update['sex'] = $data['sex'];
//        $update['change_pwd'] = 0;
//
//        $chk = $this->db->validate('user_login', array('password' => $pwd, 'phone_no' => $data['phone_no']));
//        if ($chk) {
//            $this->db->update_data('user_login', $update, array('phone_no' => $data['phone_no']));
//            echo'Update was Successful';
//        } else {
//            echo 'Invalid Password' . $pwd;
//        }
//    }
//
//    /*
//     * Create Password
//     */
//
//    function create_password() {
//        $data = $this->db->get_data('user_login', array('role' => 'Admin'));
//        $loc = $data['location'];
//        $username = url::post('username');
//        $password = sha1(url::post('password'));
//        $this->db->update_data("user_login", array("password" => $password, 'location' => $loc), array("phone_no" => $username));
//        echo 'Successful! Your Password has been Created';
//    }

}
