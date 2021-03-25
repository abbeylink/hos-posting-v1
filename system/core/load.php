<?php

class load {
    
    static function view($viewfile,$extview=array()){
        extract($extview);
        $check= explode(",", $viewfile);
        if(!isset($check[1])){
            $viewfile.='.php';
            //$viewfiles= str_replace('::','/', $viewfile);
            require_once  $GLOBALS['config']['path']['app']."views/{$viewfile}"; 
        }
    }
}
