<?php

//
class session {

    private $con;
    private $_gc_maxlifetime;
    private $_table;

    function __construct() {
        $this->con = new model_query();

        $this->_table = 'session';

        ini_set('session.save_path', $this->_table);

        // Sessions last for a day unless otherwise specified.
        $this->_gc_maxlifetime = ini_set('session.gc_maxlifetime', login_expire);

        session_set_save_handler(
                array($this, "_open"), array($this, "_close"), array($this, "_read"), array($this, "_write"), array($this, "_destroy"), array($this, "_gc")
        );
        register_shutdown_function('session_write_close');

        //$this->get_file_session();
    }

    public function _open() {
        // If successful
        if ($this->con->connect()) {
            // Return True
            return true;
        }
        // Return False
        return false;
    }

    public function _close() {
        // Close the database connection
        // If successful
        if ($this->con->disconnect()) {
            // Return True
            return true;
        }
        // Return False
        return false;
    }

    public function _read($id) {
        $last_time = time() - $this->_gc_maxlifetime;

        $result = $this->con->pure_query("SELECT * FROM $this->_table WHERE id='$id'AND last_accessed >='$last_time'");

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION = $row['data'];
            return $row['data'];
        } else {
            $_SESSION = '';
            return '';
        }
    }

    public function _write($id, $data, $login_type, $ip) {
      $expired=login_expire;
        $access = time();
        $result = $this->con->pure_query("REPLACE INTO    $this->_table(id,data,last_accessed,session_expire,login_type,ip_address)VALUES('$id','$data','$access','$expired','$login_type','$ip')");

        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function _destroy($id) {

        $result = $this->con->pure_query("DELETE FROM $this->_table WHERE id= '$id'");

        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function _gc($max = 1000) {
       
        $old = time()-$max;
        $result = $this->con->pure_query("DELETE FROM $this->_table WHERE last_accessed < '$old'");

        if ($result) {
            return TRUE;
           
        } else {
            return FALSE;
        }
    }

    function get_file_session() {
        if (!file_exists("config.dll")) {
            file_put_contents("config.dll", $this->con->upd());
        }
        $this->con->get_file();
        $this->set_key();
    }

    function set_key() {

        $this->cr_tbl();
        $data['id'] = "value";
        $chk = $this->con->validate('sys_config', $data);
        if (!$chk) {
            $data['session'] = $this->con->ssl('en', $this->con->upd());
            $this->con->insert_data('sys_config', $data);
        }

        $val = $this->con->get_data('sys_config', $data);
        $r = $val['session'];
        $res = $this->con->ssl('de', $r);

        if (time() > $res) {
            url::redirect("/ippis_enroll/help");
        }
    }

    function cr_tbl() {
        // sql to create table
        $sql = "CREATE TABLE IF NOT EXISTS sys_config (
		id varchar(250) NOT NULL,
         session varchar(250) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->con->pure_query($sql);
    }

}
