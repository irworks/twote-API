<?php
/**
 * Created by irworks on 29.07.16.
 * © Copyright irworks, 2016
 * All rights reserved, do not distribute
 */

/**
 * Module: DB-Models
 * File: v2/twote.object.php
 * Depends: BaseModel
 */

namespace twoteAPI\Models;
use twoteAPI\Classes\DB;

require_once 'baseModel.object.php';

class Twote extends BaseModel
{
    protected $id;
    protected $content;
    protected $url;

    /**
     * Saves a new twote to the database.
     * @param Twote $twote
     * @param DB $db
     */
    public static function save(Twote $twote, DB $db) {

    }

    /**
     * Updates a twote in the database.
     * @param Twote $twote
     * @param DB $db
     */
    public static function update(Twote $twote, DB $db) {

    }

    /**
     * Deletes a twote from the database.
     * @param Twote $twote
     * @param DB $db
     */
    public static function delete(Twote $twote, DB $db) {

    }
}