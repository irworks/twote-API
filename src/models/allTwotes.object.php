<?php
/**
 * Created by irworks on 30.07.16.
 * © Copyright irworks, 2016
 * All rights reserved, do not distribute
 */

/**
 * Module: [INSERT]
 * File: v2/allTwotes.object.php
 * Depends: [NONE]
 */

namespace twoteAPI\Models;
use twoteAPI\Classes\DB;

require_once 'baseModel.object.php';
require_once 'twote.object.php';

class AllTwotes extends BaseModel
{

    protected $twotes;

    /**
     * Selects all twotes for a user from the database.
     * @param $user_id
     * @param DB $db
     * @return object|\stdClass
     * @throws \Exception
     */
    public static function showAllForUser($user_id, DB $db) {
        $response = array();

        $query = "
                SELECT twote_id, content, dateTime, id_user
                    FROM twotes
                WHERE id_user = " . $db->cl($user_id);

        $result = $db->query($query);
        while($result && $dbTwote = $result->fetch_object(Twote::class)) {
            $response[] = $dbTwote;
        }

        $returnVal = new AllTwotes();
        $returnVal->setTwotes($response);

        return $returnVal;
    }

    /**
     * @return mixed
     */
    public function getTwotes() {
        return $this->twotes;
    }

    /**
     * @param mixed $twotes
     */
    public function setTwotes($twotes) {
        $this->twotes = $twotes;
    }



}