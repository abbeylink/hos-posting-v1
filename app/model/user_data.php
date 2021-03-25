<?php

class user_data extends auth {

    var $id;

    function __construct() {

        parent::__construct($datas = null);
        $this->id = url::get('q');
        $this->data['username'] = $this->session->_read($this->id);
    }

    function get_user_data() {
        $user = $this->db->get_data($this->table, $this->data);
        return$user;
    }

    function get_id() {
        return$this->id;
    }

   function checker() {
        $id = $this->get_id();
        $role = $this->role();
        $uri = $this->get_url();
        if ($this->get_change_pwd()) {
            $res = "/pstng/dashboard?q=$id";
            url::redirect($res);
        }
    }
    
    

}