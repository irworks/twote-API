<?php
/**
 * Created by irworks on 29.07.16.
 * © Copyright irworks, 2016
 * All rights reserved, do not distribute
 */

/**
 * Module: Example config
 * File: v2/config.example.php
 * Depends: [NONE]
 */

/**
 *  |----------------------------------------------|
 *  |                                              |
 *  |                twote API v2                  |
 *  |     ~ Rename this file to config.php ~       |
 *  |                                              |
 *  |----------------------------------------------|
 */


/* MySQL Settings */
define('MYSQL_HOST',     'localhost');
define('MYSQL_USERNAME', '?????????');
define('MYSQL_PASSWORD', '?????????');
define('MYSQL_DB',       '?????????');

/* API Settings */
define('DEFAULT_LANG', 'en');
define('SESSION_KEY',  'sess_person');
define('REQUEST_TIMEOUT', 20);
define('SESSION_LIFETIME', 60 * 60 * 24 * 365);
define('LANG_CACHE_FILE', 'language.cache.php');
define('BASE_URL',     'https://t.?????.tld');
?>