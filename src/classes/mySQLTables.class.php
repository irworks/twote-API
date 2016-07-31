<?php
/**
 * Created by irworks on 31.07.16.
 * © Copyright irworks, 2016
 * All rights reserved, do not distribute
 */

/**
 * Module: A list of the MySQL tables
 * File: v2/mySQLTables.class.php
 * Depends: [NONE]
 */

namespace twoteAPI\classes;


class MySQLTables
{
    /**
     * @var $USERS - The table in which all accounts will be stored.
     */
    public $USERS = 'users';

    /**
     * @var $USERS - The table in which all twotes will be stored.
     */
    public $TWOTES = 'twotes';

    /**
     * @var $USERS - The table in which the translation strings will be stored.
     */
    public $LANGUAGE = 'language';
}