<?php

/**
 * This Sofware is designed by Afaavalon, 
 * You do not have any permission to make any changes.
 * Any changes made may cause the application to malfunction.
 * * Copyright (c) 2018, Afaavalon LTD
 */
$file_path = dirname(__FILE__) . DIRECTORY_SEPARATOR;

$path = explode('htdocs' . DIRECTORY_SEPARATOR, dirname(__FILE__) . DIRECTORY_SEPARATOR);

define('ROOT_FOLDER', $path[1]);
global $file_path;
/*
 * ---------------------------------------------------------------
 * SYSTEM FOLDER NAME
 * ---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" folder.
 * Include the path if the folder is not in the same directory
 * as this file.
 */
$system_path = $file_path . "system" . DIRECTORY_SEPARATOR;
$GLOBALS['config']['path']['system'] = $system_path;

define('SYSTEMPATH', $system_path);

define('COREPATH', SYSTEMPATH . "core" . DIRECTORY_SEPARATOR);

define('LIBPATH', SYSTEMPATH . "lib" . DIRECTORY_SEPARATOR);

define('INSTALLFILE', LIBPATH . 'configfile' . DIRECTORY_SEPARATOR);


/*
 * ---------------------------------------------------------------
 * APPLICATION FOLDER NAME
 * ---------------------------------------------------------------
 *
 * If you want this front controller to use a different "application"
 * folder than the default one you can set its name here. The folder
 * can also be renamed or relocated anywhere on your server. If
 * you do, use a full server path.
 */
$app_folder = $file_path . "app/";
$GLOBALS['config']['path']['app'] = $app_folder;
define('APPPATH', $app_folder);

define('SQLFILE', APPPATH . 'views/setup/core/');



/*
 * ---------------------------------------------------------------
 * LOAD FILES
 * ---------------------------------------------------------------
 */
require_once COREPATH . "setting.php";



new router();
?>