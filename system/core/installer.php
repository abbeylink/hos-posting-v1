<?php

class installer {

    var $db;
    //Mimimum requirements
    var $prereq = array('php' => '5.4',
        'mysql' => '5.0');

    function getPHPVersion() {
        return $this->prereq['php'];
    }

    function getMySQLVersion() {
        return $this->prereq['mysql'];
    }

    function check_php() {
        return (version_compare(PHP_VERSION, $this->getPHPVersion()) >= 0);
    }

    function check_mysql() {
        return (extension_loaded('mysqli'));
    }

    function check_mysql_version() {
        return (version_compare(db_version(), $this->getMySQLVersion()) >= 0);
    }

    function check_prereq() {
        return ($this->check_php() && $this->check_mysql());
    }

    function get_rec() {
        $cm = extension_loaded('mysqli') ? 'module loaded' : 'missing!';
        $mysql = "(MySQLi extension for PHP);?> &mdash; <small><b>$cm</b></small>";
        $cp = sprintf('%s or greater', '<span class="ltr">PHP v5.4</span>');
        $php = $cp . '&mdash; <small class="ltr">(<b>' . PHP_VERSION . "</b>)</small>;";
        $res[$mysql] = $this->check_mysql() ? 'yes' : 'no';
        $res[$php] = $this->check_php() ? 'yes' : 'no';

        return$res;
    }

    function get_server_requirement() {

        $result = [];

        $result['Gdlib Extension'] = extension_loaded('gd') ? 'yes' : 'no';
        $result['PHP IMAP Extension &mdash; <em>Required for mail fetching</em>'] = extension_loaded('imap') ? 'yes' : 'no';
        $result['PHP XML Extension (for XML API)'] = extension_loaded('xml') ? 'yes' : 'no';
        $result['PHP XML-DOM Extension (for HTML email processing)'] = extension_loaded('dom') ? 'yes' : 'no';
        $result['PHP JSON Extension (faster performance)'] = extension_loaded('json') ? 'yes' : 'no';
        $result['Phar Extension &mdash; Recommended for plugins and language packs'] = extension_loaded('phar') ? 'yes' : 'no';
        $result['Mbstring Extension &mdash; Recommended for all installations'] = extension_loaded('mbstring') ? 'yes' : 'no';
        $result['Intl Extension &mdash; Recommended for improved localization'] = extension_loaded('intl') ? 'yes' : 'no';
        $result['APCu Extension &mdash; (faster performance)'] = extension_loaded('apcu') ? 'yes' : 'no';
        $result['Zend OPcache Extension &mdash; (faster performance)'] = extension_loaded('Zend OPcache') ? 'yes' : 'no';
//        $result[''] = extension_loaded('') ? 'yes' : 'no';
        return $result;
    }

    public function isInstalled() {
        $installed = $GLOBALS['config']['installed'];
        if (!file_exists(CONFIG_FILE_PATH)) {
            return false;
        }

        if (!$installed) {
            return false;
        }

        return true;
    }

    /*
     * Verify MYSQL connection
     */

    public function verifyConnection() {

        $con_var = functions::get_post();
        // print_r($con_var);
        $this->db = new mysqli($con_var['host'], $con_var['user'], $con_var['pass']);

//        if (!$this->db) {
//            return false;
//        }

        if ($this->db->connect_error) {
            return false;
        }

        return true;
    }

    /*
     * Generate Configuration file
     */

    public function generateConfigFile() {
        $date = date('d-m-Y', time());
        if (!file_exists(INSTALLFILE)) {
            mkdir(INSTALLFILE, 0777);
        }
        $post = functions::get_post();

        $dbname = trim(strtolower($post['db_name']));
        $dbname = str_replace(' ', '_', $dbname);

        $data = ['host' => $post['host'], 'user' => $post['user'], 'pass' => $post['pass'],
            'db_name' => $dbname, 'installed' => true, 'created' => $date];
        $output = "<?php\n";
        foreach ($data as $key => $value) {
            if ($key === 'user' || $key === 'pass') {
                $value = $this->crypto($value);
            }
            $output .= "\$GLOBALS['config']['$key']='" . $value . "';\n";
        }
        $output .= "?>\n";

        $write = @file_put_contents(CONFIG_FILE_PATH, $output);

        if ($write) {
            return true;
        }

        return false;
    }

    public function load_sql() {
        $vl = functions::get_post();
        $con = new mysqli($vl['host'], $vl['user'], $vl['pass']);
        $dbname = trim(strtolower($vl['db_name']));
        $dbname = str_replace(' ', '_', $dbname);
        $con->query("DROP DATABASE IF EXISTS $dbname");
        $sql = "CREATE DATABASE IF NOT EXISTS $dbname
                DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;";
        $con->query($sql);
        $con->select_db($dbname);
        //create databse table
        $content = @file_get_contents(SQL_DUMP_FILE_CREATE);
        $sql = explode(";", $content);
        foreach ($sql as $query) {
            $con->query($query);
        }

        $this->save_system_data();
    }

    function save_system_data() {

        $date = date('Y-m-d H:i:s', time());
        $data = functions::get_post();
        $con = new mysqli($data['host'], $data['user'], $data['pass'], $data['db_name'], 3306);
        $date = $date;
        $logo = ROOT_FOLDER .DIRECTORY_SEPARATOR.'upload/logo/hos.png';
        $cmp = $data['company_name'];
        $f = $data['first_name'];
        $l = $data['last_name'];
        $u = $data['username'];
        $p = sha1($data['password']);
        $em = $data['admin_email'];

        $query = "INSERT INTO setting(id,comp_name,logo,designer,site,date_created)
                 VALUES ('config', '$cmp','$logo','Afaavalon int Ltd','www.afaavalon.com','$date')";
        $con->query($query);
        $query2 = "INSERT INTO user_login (first_name,last_name,username,password,email_address,isadmin,change_pwd,created_by,date_created)
                VALUES ('$f','$l','$u','$p','$em',1,1,'System','$date')";
        $con->query($query2);
        
        //Config
        $val = array($this->crypto( webst), $this->crypto(webs));
        $now = date('d-m-Y', time());
        $file = software . "/" . 'webconfig.dll';
        if (!file_exists($file)) {
            $d = implode(",", $val);
            $db=new model_query();
            $db->file_put_content(software, "webconfig.dll", $d);
        }
    }

    function crypto($string) {
        $output = '';
        $encrypt_method = 'AES-256-CBC';
        $secret_key = 'eaiYYKTysia2lnHiw0N0vx7t7a3kEJVLfbTKoQIx5o=';
        $secret_iv = 'eaiYYKTysia2lnHiw0N0';
        $key = hash('sha256', $secret_key);
        $initialize_vector = substr(hash('sha256', $secret_iv), 0, 16);

        if ($string !== '') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $initialize_vector);
            $output = base64_encode($output);
        }

        return $output;
    }

}
