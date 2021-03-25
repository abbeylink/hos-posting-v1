<?php

class install_ajax extends controller {

    var $installer;

    function __construct() {
        parent::__construct();
        $this->installer = new installer();
    }

    function check_requirement() {
        $res = '';
        if ($this->installer->check_prereq()) {
            $res = "/setup/install";
        } else {
            $res = 'error';
        }

        echo $res;
    }

    function execute() {
        if (!$this->installer->verifyConnection()) {
            $msg = 'Could not connect to the database server. 
                    Please make sure your connection parameters are correct.';
        } else {
            $this->installer->generateConfigFile();
            $this->installer->load_sql();
            @unlink(TEMP_CONFIG_FILE_PATH);
            $msg = 'Successful';
        }
        echo$msg;
    }

}
