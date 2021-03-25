<?php

class url {

    static function part($number) {
        $uri = explode("?", $_SERVER["REQUEST_URI"]);
        $parts = explode("/", $uri[0]);
        if ($parts[1] == $GLOBALS["config"]["index"]) {
            $number++;
        }
        return (isset($parts[$number])) ? $parts[$number] : false;
    }

    static function post($key) {
        return (isset($_POST[$key])) ? ($_POST[$key]) : false;
    }

    static function get($key) {
        return (isset($_GET[$key])) ? urldecode($_GET[$key]) : false;
    }

    static function request($key) {
        if (url::get($key)) {
            return url::get($key);
        } else if (url::post($key)) {
            return url::post($key);
        } else {
            return false;
        }
    }

    public static function redirect($url) {
        
         setcookie('userid', NULL);
        // echo "<script>window.location = '$url';</script>";
        header("location:" . $url);
    }

}

?>