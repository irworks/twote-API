<?php
/**
 * Created by irworks on 31.07.16.
 * © Copyright irworks, 2016
 * All rights reserved, do not distribute
 */

/**
 * Module: Maintenance
 * File: v2/script-header.php
 * Depends: config
 */

if(php_sapi_name() !== 'cli') {
    echo 'This should only be run from the command line (cronjob).';
    exit();
}

if(file_exists(__DIR__ . '/../config.php')) {
    require_once __DIR__ . '/../config.php';
}else{
    echo 'Config not set. Please create ' . __DIR__ . '/../config.php';
    exit();
}

echo' |----------------------------------------------|\n';
echo' |                                              |\n';
echo '|                twote API v2                  |\n';
echo '|           ~ Maintenance tools ~              |\n';
echo '|                                              |\n';
echo '|----------------------------------------------|\n\n';


?>