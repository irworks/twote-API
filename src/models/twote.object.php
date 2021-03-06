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
    protected $twote_id;
    protected $content;
    protected $url;

    /**
     * Saves a new twote to the database.
     * @param Twote $twote
     * @param Person $person
     * @param DB $db
     * @return Twote
     * @throws \Exception
     */
    public static function save(Twote $twote, Person $person, DB $db) {

        if(empty($person->getUserId())) {
            $person->setUserId(0);
        }

        $query = "
                INSERT INTO " . $db->getTables()->TWOTES . "
                  (twote_id, content, createDateTime, id_user)
                VALUES
                 (" . $db->cl($twote_id = self::getNewTwoteID($db)) . "," . $db->cl($twote->getContent()) . ", NOW(), " . $person->getUserId() . ")";

        if($db->query($query)) {
            $newTwote = new Twote();
            $newTwote->setTwoteId($twote_id);
            $newTwote->setContent($twote->getContent());
            $newTwote->setUrl(BASE_URL . $twote_id);

            return $newTwote;
        }else{
            throw new \Exception('error.twote.save_failed', 2004);
        }
    }

    /**
     * Updates a twote in the database.
     * @param $twote_id
     * @param Twote $twote
     * @param Person $person
     * @param DB $db
     * @return Twote
     * @throws \Exception
     */
    public static function update($twote_id, Twote $twote, Person $person, DB $db) {

        if(empty($person->getUserId())) {
            throw new \Exception('error.twote.update_not_authorized', 2005);
        }

        $query = "
                UPDATE twotes
                  SET
                content = " . $db->cl($twote->getContent()) . "
                  WHERE 
                twote_id = " . $db->cl($twote_id) . "
                  AND
                id_user  = " . $db->cl($person->getUserId());

        if($db->query($query)) {
            $newTwote = new Twote();
            $newTwote->setTwoteId($twote_id);
            $newTwote->setContent($twote->getContent());
            $newTwote->setUrl(BASE_URL . $twote_id);

            return $newTwote;
        }else{
            throw new \Exception('error.twote.update_failed', 2006);
        }

    }

    /**
     * Selects a twote from the database.
     * @param $twote_id
     * @param DB $db
     * @return object|\stdClass
     * @throws \Exception
     */
    public static function show($twote_id, DB $db) {
        $query = "
                SELECT twote_id, content, createDateTime, id_user
                    FROM " . $db->getTables()->TWOTES . "
                WHERE twote_id = " . $db->cl($twote_id);

        $result = $db->query($query);
        if($result && $dbTwote = $result->fetch_object(get_class())) {
            return $dbTwote;
        }else{
            throw new \Exception('error.twote.not_found', 2003);
        }
    }

    /**
     * Deletes a twote from the database.
     * @param $twote_id
     * @param Person $person
     * @param DB $db
     * @return object|\stdClass
     * @throws \Exception
     */
    public static function delete($twote_id, Person $person, DB $db) {
        $query = "
                DELETE
                    FROM " . $db->getTables()->TWOTES . "
                WHERE twote_id = " . $db->cl($twote_id) . "
                    AND
                id_user  = " . $db->cl($person->getUserId());

        $result = $db->query($query);
        if($result) {
            if($db->affected_rows <= 0) {
                throw new \Exception('error.twote.delete_not_authorized', 2007);
            }else{
                return new Twote();
            }
        }else{
            throw new \Exception('error.twote.not_found', 2003);
        }
    }

    private static function getNewTwoteID(DB $db){
        $idIsAvailable = false;

        while(!$idIsAvailable){
            $id = mt_rand(1000000000, 9999999999);
            $idIsAvailable = false;

            $query = "SELECT twote_id FROM " . $db->getTables()->TWOTES . " WHERE twote_id = " . $db->cl($id);
            $result = $db->query($query);

            if($result && $db->affected_rows == 0){
                return $id;
            }elseif (!$result) {
                return -1;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getTwoteId() {
        return $this->twote_id;
    }

    /**
     * @return mixed
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @return mixed
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * @param mixed $twote_id
     */
    public function setTwoteId($twote_id) {
        $this->twote_id = $twote_id;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content) {
        $this->content = $content;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url) {
        $this->url = $url;
    }


    
}