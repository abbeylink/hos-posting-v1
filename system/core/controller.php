<?php

@ini_set("memory_limit", "9999M");
@ini_set("max_input_time", 0);
@ini_set("max_execution_time", 0);

class controller {

    public $id, $db,$auth, $nom,$pst, $session, $chk;

    function __construct() {

        date_default_timezone_set('Africa/Lagos');
        header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        header('Pragma: no-cache');
        header('Expires: 0');

        $this->id['id']= url::get('q');
        $this->db = new model_query();
        $this->session = new session();
        $this->chk = new installer();
       

    }


}
