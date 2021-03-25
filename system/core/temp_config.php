<?php

$dbvalue = array ( 'host' => '','user' => '','pass' => '', 'db_name' => '');

$output = "<?php\n";
foreach ($dbvalue as $key => $value) {
    $output .= "\$GLOBALS['config']['$key']='" . $value . "';\n";
}
$output .= "\n";

@file_put_contents(TEMP_CONFIG_FILE_PATH, $output);

require_once TEMP_CONFIG_FILE_PATH;