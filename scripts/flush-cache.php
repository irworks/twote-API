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

echo 'Cache will now be flushed... \n\n';

if(file_exists(CACHE_DIR)) {
    foreach (scandir(CACHE_DIR) as $file) {
        unlink($file);
        echo '- Deleted "' . $file . '" \n';
    }
}

echo '\nCache was flushed! See you around.';

?>