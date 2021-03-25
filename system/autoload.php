<?php

spl_autoload_register(function ($class_name) {

    $app_path = $GLOBALS['config']['path']['app'];
    $system_path = $GLOBALS['config']['path']['system'];

    if (file_exists("{$app_path}controller/{$class_name}.php")) {
        require_once "{$app_path}controller/{$class_name}.php";
    } elseif (file_exists("{$app_path}model/{$class_name}.php")) {
        require_once "{$app_path}model/{$class_name}.php";
    } elseif (file_exists("{$system_path}core/{$class_name}.php")) {
        require_once "{$system_path}core/{$class_name}.php";
    } elseif (file_exists("{$system_path}lib/{$class_name}.php")) {
        require_once "{$system_path}lib/{$class_name}.php";
    } elseif (file_exists("{$system_path}lib/phpmailer/{$class_name}.php")) {
        require_once "{$system_path}lib/phpmailer/{$class_name}.php";
    }
});
