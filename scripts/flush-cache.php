<?php
/**
 * Created by irworks on 31.07.16.
 * © Copyright irworks, 2016
 * All rights reserved, do not distribute
 */

/**
 * Module: Maintenance scripts
 * File: v2/flush-cache.php
 * Depends: config.php
 */
require_once 'script-header.php';

echo "Cache will now be flushed..." . PHP_EOL . PHP_EOL;

if(file_exists(CACHE_DIR)) {
    foreach (scandir(CACHE_DIR) as $file) {
        if($file === '.' || $file === '..') {
            continue;
        }
        
        unlink(__DIR__ . "/" . $file);
        echo "- Deleted \"" . $file . "\"" . PHP_EOL;
    }
}

echo PHP_EOL . "Cache was flushed! See you around.";

?>