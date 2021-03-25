<?php

define('SETUP', true);

class setup extends controller {

    var $chk;

    function __construct() {
        parent::__construct();
        $this->chk = new installer();
    }

    function requirement() {
        if ($this->chk->isInstalled())
            url::redirect("/");
        else
            load::view("setup/requirement");
    }

    function install() {
        if ($this->chk->isInstalled())
            url::redirect("/");
        else
            load::view("setup/install");
    }

    function install_msg() {
        if ($this->chk->isInstalled())
            url::redirect("/");
        else
            load::view("setup/install_msg");
    }

}
