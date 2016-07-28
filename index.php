<?php
/**
 * Created by irworks on 28.07.16.
 * © Copyright irworks, 2016
 * All rights reserved, do not distribute
 */

/**
 * Module: Application startpoint
 * File: v2/index.php
 * Depends: config
 */

require_once 'src/classes/twoteAPI.class.php';
require_once 'src/classes/db.class.php';

use twoteAPI\Classes\DB;
use twoteAPI\Classes\TwoteAPI;

$headers = apache_request_headers();

$db = new DB(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DB);
$db->set_charset("utf8");

try {
    $API       = new TwoteAPI($_REQUEST['request'], $_SERVER['HTTP_ORIGIN'], $headers, $db, DEFAULT_LANG);
    $apiOutput = $API->processAPI();
} catch (\Exception $e) {
    $apiOutput = json_encode(array(
        'message' => $e->getMessage(),
        'code'    => $e->getCode()
    ));
}

/* Output the data */
echo($apiOutput);
?>
