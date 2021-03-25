<?php

class functions {

    static function db() {
        $db = new model_query();
        return$db;
    }

    static function get_post($case = 'lower') {
        $res = array();
        foreach ($_POST as $key => $value) {
            if ($case === 'lower')
                $res[$key] = $value;
            else
                $res[$key] = strtoupper($value);
        }
        return $res;
    }

    /**
     * Returns TRUE if the request was made via HTTPS and false otherwise
     */
    static function is_https() {

        // Local server flags
        if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on')
            return true;

        // Check if SSL was terminated by a loadbalancer
        return (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && !strcasecmp($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https'));
    }

    /* Helper used to generate ticket IDs */

    static function randNumber($len = 6) {
        $number = '';
        for ($i = 0; $i < $len; $i++) {
            $min = ($i == 0) ? 1 : 0;
            $number .= mt_rand($min, 9);
        }

        return (int) $number;
    }

    //Current page
    static function currentURL() {

        $str = 'http';
        if ($_SERVER['HTTPS'] == 'on') {
            $str .= 's';
        }
        $str .= '://';
        if (!isset($_SERVER['REQUEST_URI'])) { //IIS???
            $_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'], 1);
            if (isset($_SERVER['QUERY_STRING'])) {
                $_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
            }
        }
        if ($_SERVER['SERVER_PORT'] != 80) {
            $str .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
        } else {
            $str .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        }

        return $str;
    }

//Redirect Http to Https
    static function redirectTohttps() {

        if ($_SERVER['HTTPS'] != 'on') {
            $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            header("Location:$redirect");
        }
    }

//Redirect Http to Http
    static function redirectTohttp() {

        if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
            $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            header("Location:$redirect");
        }
    }

    /*
     * Check login status
     */

    public static function isLoggedIn() {
        $session = new session();
        $chk = new installer();
        $user_sess = url::get('q');
        if ($chk->isInstalled()) {

            if ($session->_read($user_sess)) {
                return TRUE;
            } else {
                return FALSE;
            }
//        
        } else {
            url::redirect("setup/requirement");
        }
    }
    
    static function get_username(){
        $s=new session();
        $data['username']=$s->_read(self::get_id());
        $u=new auth($data);
        return $u->get_firstname();
    }

    /*
     * Get  ID
     */

    public static function get_id() {
        return url::get('q');
    }

    /*
     * Set History
     */

    public static function set_history($id, $event, $issue = 'NULL') {
        $user = self::get_loginuser_data();
        $loc = self::get_location();
        $name = $user['first_name'] . " " . $user['last_name'];
        $data = array("phone_no" => $user['phone_no'], "full_name" => strtoupper($name), "enroll_id" => $id, "event" => strtoupper($event), 'issue' => strtoupper($issue), "location" => $loc);
        $chk = self::db()->insert_data('history', $data);
        if ($chk) {
            self::db()->commit();
        } else {
            self::db()->rollback();
        }
    }

    /*
     * GET USER (CREATED BY)
     */

    function get_createdby($tbl, $id) {
        $user = self::get_loginuser_data();
        $name = $user['first_name'] . " " . $user['last_name'];
        $chk = self::db()->get_data($tbl, array('reference_id' => $id));
        $crt = $chk['created_by'];

        if (empty($crt)) {
            $data['created_by'] = $name;
            self::db()->update_data($tbl, $data, array('reference_id' => $id));
        } else {
            $data['updated_by'] = $name;
            self::db()->update_data($tbl, $data, array('reference_id' => $id));
        }
    }

    static function generate_token($num) {
        $character = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characterlen = strlen($character);
        $randomstring = '';
        for ($i = 0; $i < $num; $i++) {
            $randomstring .= $character[rand(0, $characterlen - 1)];
        }
        return $randomstring;
    }

    static function refid_format() {
        $e = self::randomDigits(4);
        $s = self::generate_token(4);
        $a = self::randomDigits(5);
        $token = sprintf('%s-%s-%d', $e, $s, $a);
        return $token;
        ;
    }

    //GET COMPANY SETTING
    static function get_company_setting() {

        $where = array('id' => 'config');
        $col = array('logo', 'comp_name', 'site', 'designer');
        $data = self::db()->get_data('setting', $where, $col);
        return$data;
    }

    public function upload_img($path, $filename, $id) {
        if (!file_exists($path)) {
            $path = mkdir($path, 777);
        }

        $file_ext = pathinfo(basename($_FILES[$filename]['name']), PATHINFO_EXTENSION);
        $ext = strtolower($file_ext);
        $file = $path . "$id.$ext";
        $tmp = $_FILES[$filename]['tmp_name'];
        if (move_uploaded_file($tmp, $file)) {
            return $file;
        }
    }

    /* ----------------------------------------------
     * CONVERT DEFAULT DATE TO DB DATE
     * ---------------------------------------------
     */

    static function db_date_format($date) {
        $format = '';
        $d = str_replace('/', '-', $date);
        $format = date('Y-m-d', strtotime($d));
        return $format;
    }

    /* ----------------------------------------------
     * CONVERT DEFAULT DATE TO DB DATE
     * ---------------------------------------------
     */

    static function date_format($date) {
        $format = '';
        $d = str_replace('/', '-', $date);
        $format = date('d-m-Y', strtotime($d));
        return $format;
    }

    /*
     * UPLOAD ALL NOMINAL ROLL
     */

    public static function upload_csv_file($tbl) {
        $db = new model_query();
        $user = new user_data();
        $exceldata = array();
        $excel_file_name = array();
        $row = 0;
        $count = 0;
        $col =array('ippis_no','full_name','mda_location','rank','sgl','sex','dob','dopa','dofa','mda_name','department','phone'); //self::db()->get_fieldname($tbl);
        $name = $user->get_firstname() . ' ' . $user->get_lastname();

        $file_tmpfile = $_FILES["excel_file"]["tmp_name"];
        $file_name = upload_path . $_FILES["excel_file"]["name"];
        move_uploaded_file($file_tmpfile, $file_name);

        $file = fopen($file_name, "r");

        while (($data = fgetcsv($file)) !== false) {

            if ($row > 0) {
                //FOR NOMINAL ROLL
                for ($i = 0; $i <count($col); $i++) {
                    $val = strtoupper(trim(trim($data[$i], "'")));

                    switch ($col[$i]) {
                        case'dob':
                            $res = (isset($val)&& !empty($val)) ? self::date_format($val) : '';
                            break;
                        case'dopa':
                            $res = (isset($val)&& !empty($val)) ? self::date_format($val) : '';
                            break;
                        case'dofa':
                            $res = (isset($val)&& !empty($val)) ? self::date_format($val) : '';
                            break;
//                        
                        default :
                            $res = preg_replace("/[^a-zA-Z0-9\s]/", "", trim($val));
                    }
                    $getdata[$col[$i]] = $res;
                    $getdata['created'] = self::db()->now();
                    $getdata['created_by'] = $name;
                }

                //NOMINAL DATA TO UPLOAD
                $exceldata[] = $getdata;
                $result = array_filter($exceldata);
            }

            $row++;
        }
//            //NOMINAL ROLL
        $n =  $db->insert_multi_data($tbl, $result);
        if ($n) {
            $msg = " Upload was Successful ";
        } else {
            $msg = 'Insert Failed- Reason:' .  $db->getLastError();
        }
        $delete_file = $_SERVER['DOCUMENT_ROOT'] . "/" . $file_name;
        unlink($delete_file);

        exit($msg);

        // print_r($result);
//     
    }

    /*
     * download fils
     */

    function download_file($path, $filename) {
        $file = $path;
        $tmpFile = tempnam('/tmp', '');
        $zip = new ZipArchive;
        $zip->open($tmpFile, ZipArchive::CREATE);
        $fileContent = file_get_contents($file);
        $zip->addFromString(basename($file), $fileContent);
        $zip->close();
        header('Content-Type: application/zip');
        header("Content-disposition: attachment; filename=$filename.zip");
        header('Content-Length: ' . filesize($tmpFile));
        readfile($tmpFile);
    }

    /*
     * Create folder for with name
     */

    function name_folder_by_mda($refid, $foldename) {
        $val = explode("EN-", $refid);
        $val2 = explode("-", $val[1]);
        $mda_name = $val2[0];
        $path = upload_path . $mda_name . "_$foldename/";

        if (!file_exists($path)) {
            mkdir($path, 0777);
        }
        return $path;
    }

    /*
     * Download Excel file format
     */

    public static function download_excel($data, $header, $name) {

// [15, 15, 20, 20, 20, 20], 
        $filename = "$name.xlsx";
        $writer = new XLSXWriter();
        $styles = array('font' => 'Arial', 'font-size' => 10, 'font-style' => 'bold', 'fill' => '#eee', 'halign' => 'center');

// $writer->writeSheetHeader("Mysheet", $header);
// Write data to excel
        $writer->writeSheetHeader($name, $header, $styles);
        foreach ($data as $row) {
            $writer->writeSheetRow($name, $row);
        }
        ob_end_clean();
     
        header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($filename) . '"');
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        $writer->writeToStdOut();
    }

    /*
     * Download Excel format for upload
     */

    public static function download_format($header, $name) {

        $filename = "$name.xlsx";
        $writer = new XLSXWriter();
        $styles = array('font' => 'Arial', 'font-size' => 11, 'font-style' => 'bold', 'fill' => '#eee');

        // $writer->writeSheetHeader("Mysheet", $header);
        // Write data to excel
        $writer->writeSheetHeader($name, $header, $styles);

        header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($filename) . '"');
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        ob_end_clean();
        $writer->writeToStdOut();
    }

    /*
     * Download Sql file format
     */

    function db_backup_all($tables) {

        $path = downloaded_report;
        if (!file_exists($path)) {
            mkdir($path, 0644); // try to mkedir 
        }

        $return = "";

        foreach ($tables as $tbl) {
            $result = self::db()->pure_query("SELECT * FROM  $tbl");
            $num_field = mysqli_num_fields($result)or die(mysql_error());

            for ($i = 0; $i < $num_field; $i++) {
                while ($row = mysqli_fetch_row($result)) {
                    $return .= "INSERT INTO $tbl VALUES(";
                    for ($j = 0; $j < $num_field; $j++) {
                        $row[$j] = addslashes($row[$j]);
                        if (isset($row[$j])) {
                            $return .= '"' . self::db()->escape($row[$j]) . '"';
                        } else {
                            $return .= '""';
                        }
                        if ($j < $num_field - 1) {
                            $return .= ', ';
                        }
                    }
                    $return .= ");\n";
                }
            }
            $return .= "\n";
        }
        //self::db()->file_put_content(upload_path, "backup.sql", $return);

        $handle = fopen("backup.sql", "w+"); //backup.sql
        fwrite($handle, $return);
        fclose($handle);
//        $file = "backup.sql";
//        if (file_exists($file)) {
//            header('Content-Description: File Transfer');
//            header('Content-Type: application/octet-stream');
//            header('Content-Desposition: attachment; filename=' . basename($file));
//            header('Expires:0');
//            header('Cache-Control: must-revalidate');
//            header('Pragma: public');
//            header('Content-Length: ' . filesize($file));
//            ob_clean();
//            flush();
//            readfile($file);
//            exit();
//        }
    }

    /*
     * Remove Character from Number
     */

    function remove_chr($no) {
        return preg_replace("/[^0-9]/", "", $no);
    }

    /*
     * Get System IP Address
     */

    public static function get_ip() {
        $mainIp = '';
        if (getenv('HTTP_CLIENT_IP'))
            $mainIp = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $mainIp = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $mainIp = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $mainIp = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $mainIp = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $mainIp = getenv('REMOTE_ADDR');
        else
            $mainIp = 'UNKNOWN';
        return $mainIp;
    }

    public static function zipData($source, $destination) {

        if (!file_exists(backup_path)) {
            mkdir(backup_path, 0644);
        }

        if (extension_loaded('zip')) {
            if (file_exists($source)) {
                $zip = new ZipArchive();
//      if(!is_dir($destination)) mkdir ($destination,'077',true);
                if ($zip->open($destination, ZIPARCHIVE::CREATE)) {
                    $source = realpath($source);
                    if (is_dir($source)) {
                        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST);
                        foreach ($files as $file) {
                            $file = realpath($file);
                            if (is_dir($file)) {
                                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                            } else if (is_file($file)) {
                                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                            }
                        }
                    } else if (is_file($source)) {
                        $zip->addFromString(basename($source), file_get_contents($source));
                    }
                }
                return $zip->close();
            }
        }
        return false;
    }

    static  function   date_diff($startDate, $endDate) {
        $data = array();
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);
        if ($startDate === false || $startDate < 0 || $endDate === false || $endDate < 0 || $startDate > $endDate) {
            return false;
        }

        $diff = abs($endDate - $startDate);
        $year = floor($diff / (365 * 60 * 60 * 24));
        $data['y'] = $year;
        $month = floor(($diff - $year * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $data['m'] = $month;
        $day = floor(($diff - $year * 365 * 60 * 60 * 24 - $month * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $data['d'] = $day;

        return $data;
    }

    static function run() {
        $chk = new installer();

        if ($chk->isInstalled()) {

            $val = array(self::db()->ssl('en', webst), self::db()->ssl('en', webs));
            $now = date('d-m-Y', time());
            $file = software . "/" . 'webconfig.dll';

            if (!file_exists($file)) {
                $d = implode(",", $val);
                self::db()->file_put_content(software, "webconfig.dll", $d);
            }


            if (file_exists($file)) {
                $data = self::db()->file_get_content(software, 'webconfig.dll');
                $c = explode(',', $data);
                $s = self::db()->ssl('de', $c[0]);
                $e = self::db()->ssl('de', $c[1]);
                $ex = self::date_diff($now, $e);
                $st = self::date_diff($s, $now);

                if (!$ex) {
                    if (file_exists($file)) {
                  
                        die();
                    }
                }
                if (!$st) {
                    die("Sorry, The System detect in correct date... Please set the date ");
                }
            }
        }
    }

    /*
     * DATE CHECKER
     */

    function date_checker($date, $condition) {
        $con_date = date('Y-m-d', strtotime($date));
        $res = self::db()->query_array("Select (CURRENT_DATE $condition '$con_date') AS chk  ");
        $output = $res[0]['chk'];
        return$output;
    }

    public function datediff_month($date) {
        $con_date = date('Y-m-d', strtotime($date));
        $check = self::db()->query_array("SELECT TIMESTAMPDIFF(MONTH, CURRENT_DATE, '$con_date') AS chk ");
        $result = $check[0]['chk'];
        return $result;
    }

}

functions::run();
