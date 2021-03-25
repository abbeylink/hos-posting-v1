<?php

#Error reporting...Good idea to ENABLE error reporting to a file. i.e display_errors should be set to false
$error_reporting = E_ALL & ~E_NOTICE;
if (defined('E_STRICT')) # 5.4.0
    $error_reporting &= ~E_STRICT;
if (defined('E_DEPRECATED')) # 5.3.0
    $error_reporting &= ~(E_DEPRECATED | E_USER_DEPRECATED);
error_reporting($error_reporting); //Respect whatever is set in php.ini (sysadmin knows better??)
#Don't display errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
// -------------------------------------------------------------------------
// 1. GLOBAL SETTINGS
// -------------------------------------------------------------------------
// *** version number of Application
define('APP_VERSION', '1.0.0');

// -------------------------------------------------------------------------
// 2. GENERAL SETTINGS
// -------------------------------------------------------------------------
// *** check for PHP minimum version number (true, false) -
//     checks if a minimum required version of PHP runs on a server
// -------------------------------------------------------------------------
// 3. DATABASE SETTINGS
// -------------------------------------------------------------------------
// *** force database creation
// *** sql dump file - file that includes SQL statements for instalation
define('SQL_DUMP_FILE_CREATE', SQLFILE . 'install-mysql.sql');
//define('SQL_DUMP_FILE_UPDATE', INSTALLFILE . 'update.sql');
//define('SQL_DUMP_FILE_UN_INSTALL', INSTALLFILE . 'un-install.sql');
// -------------------------------------------------------------------------
// 4. CONFIG PARAMETERS
// -------------------------------------------------------------------------
// generate dbconfig value
define('GENERATE_PATH', COREPATH . 'temp_config.php');
// *** config file name - output file with config parameters (database, username etc.)
define('CONFIG_FILE_NAME', 'config.inc.php');
// *** according to directory hierarchy (you may add/remove '../' before CONFIG_FILE_DIRECTORY)
define('CONFIG_FILE_PATH', INSTALLFILE . CONFIG_FILE_NAME);

//Temporary database config
define('TEMP_CONFIG_FILE', 'dbconfig.php');
//Temporary database config Path
define('TEMP_CONFIG_FILE_PATH', COREPATH . TEMP_CONFIG_FILE);




// -------------------------------------------------------------------------
// 6. APPLICATION PARAMETERS
// -------------------------------------------------------------------------
// *** application name
define('APPLICATION_NAME', 'Your Program');
// *** version number of your application 
define('APPLICATION_VERSION', 'v1.0');


// *** license agreement page
define('LICENSE', INSTALLFILE . 'license.txt');

/**
 * ---------------------------------------------------------------
 * SESSION
 * ---------------------------------------------------------------
 */
define('SESSION_TTL', 86400); // Default 24 hours
define('SESSION_TABLE', 'session');
define('TT', time() + 10368000);
define('login_expire', time() + 60 * 60 * 24);

/**
 * ---------------------------------------------------------------
 * SYSTEM CONFIGURATION
 * ---------------------------------------------------------------
 */
$GLOBALS['config']['domain'] = "/";
$GLOBALS['config']['index'] = "index.php";
$GLOBALS['config']['defaults']['controller'] = "pstng";
$GLOBALS['config']['defaults']['method'] = "index";
$GLOBALS['config']['routes'] = array();

//
/* * **************************************************
 * base url means domain e.g wwww.abbeylink.com
 * **************************************************
 */
$domain = $GLOBALS['config']['domain'];
if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
    $uri = 'https://';
} else {
    $uri = 'http://';
}
$uri .= $_SERVER['HTTP_HOST'] . "/";

define("base_url", $uri);

/* * *************************************************
 * Upload folder directory
 * **************************************************
 */
$n = $_SERVER['DOCUMENT_ROOT'];
$a = explode("htdocs", $n);
define('SERVICE', $a[0]); //

//define('upload_path', ROOT_FOLDER . 'upload/');

//For Virtual Host
define('upload_path', base_url . 'upload/');

define('software', SERVICE . 'software/');

define('downloaded_report', 'c:' . DIRECTORY_SEPARATOR . 'downloaded report' . DIRECTORY_SEPARATOR);

/* * **************************************************
 * Asset folder directory
 * ***************************************************
 */
//define('asset', base_url . ROOT_FOLDER . 'asset/');

//For Virtual Host
define('asset', base_url . 'asset/');

//Use Temporary db config if App hasn't been Installed
if (file_exists(CONFIG_FILE_PATH))
    require_once INSTALLFILE . CONFIG_FILE_NAME;
else
    require_once GENERATE_PATH;
/**
 * ---------------------------------------------------------------
 * LOAD FILE
 * ---------------------------------------------------------------
 */
//require_once $GLOBALS['config']['path']['system'] . "core/";
require_once SYSTEMPATH . "autoload.php";
?>
    