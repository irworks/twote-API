<?php
/**
 * Created by irworks on 28.07.16.
 * © Copyright irworks, 2016
 * All rights reserved, do not distribute
 */

/**
 * Module: DB-Models
 * File: v2/person.object.php
 * Depends: BaseModel
 */

namespace twoteAPI\Models;
use twoteAPI\Classes\DB;

require_once 'baseModel.object.php';

class Person extends BaseModel
{
    protected $user_id;
    protected $username;
    protected $password;
    protected $changePassword;
    protected $email;
    protected $language;
    
    private $salt;
    private $activated;

    /**
     * @param Person $person
     * @param DB $db
     * @return null|object|\stdClass
     * @throws \Exception
     */
    public static function login(Person $person, DB $db) {

        $dbPerson = null;
        
        $query = "
            SELECT user_id, username, password, salt, activated
			  FROM " . $db->getTables()->USERS . "
			WHERE username = LOWER(" . $db->cl($person->getUsername()) . ")";

        $result = $db->query($query);
        if($result && $dbPerson = $result->fetch_object(get_class())) {

            if(!$dbPerson->isActivated()) {
                throw new \Exception('error.person.not_activated', 1001);
            }else{
                $hash = self::getPasswordHash($person->getPassword(), $dbPerson->getSalt());

                if($hash === $dbPerson->getPassword()) {
                    ini_set('session.gc_maxlifetime', 2678400);

                    session_regenerate_id();
                    $_SESSION[SESSION_KEY] = $dbPerson->toArray();
                    session_write_close();

                    return $dbPerson;
                }else{
                    throw new \Exception('error.person.wrong_credentials', 1002);
                }
            }

         } else {
            throw new \Exception('error.person.not_found', 1003);
        }
    }

    /**
     * @param $personID
     * @param Person $person
     * @param DB $db
     * @return null|object|\stdClass
     * @throws \Exception
     */
    public static function save($personID, Person $person, DB $db) {
        $dbPerson = null;

        $currentPerson = new Person($_SESSION[SESSION_KEY]);
        if($currentPerson->getUserId() <= 0 || $currentPerson->getUserId() != $personID) {
            throw new \Exception('error.person.update_not_authorized', 1005);
        }

        $query = "
            UPDATE " . $db->getTables()->USERS . " SET 
              email    = " . $db->cl($person->getEmail()) . ",
              language = " . $db->cl($person->getLanguage());

        if(!empty($person->getNewPassword()) && !empty($person->getPassword()) && $currentPerson->getPassword() === self::getPasswordHash($person->getPassword(), self::getSaltForUserID($personID, $db))) {
            $query .= ', password = ' . $db->cl(self::getPasswordHash($person->Password, self::getSaltForUserID($personID, $db)));
        }

        $query .= " WHERE user_id = " . $db->cl($personID);

        $result = $db->query($query);
        if($result) {
            return self::show($person, $db);
        } else {
            throw new \Exception('error.person.update_failed', 1004);
        }
    }

    /**
     * logout a user - destroys its session
     */
    public static function logout() {
        session_destroy();

        $baseModel = new BaseModel();
        $baseModel->message = 'success.person_logout';
        return $baseModel;
    }

    public static function show(Person $person, DB $db) {
        $query = "
            SELECT user_id, username, email, language
			  FROM " . $db->getTables()->USERS . "
			WHERE user_id = " . $db->cl($person->getUserId()) . " AND activated = 1";

        $result = $db->query($query);
        if($person->getUserId() > 0 && $result && $dbPerson = $result->fetch_object(get_class())) {
            return $dbPerson;
        } else {
            throw new \Exception('error.person.not_found', 1003);
        }

    }

    private static function getPasswordHash($password = '', $salt = '') {
        return hash('sha256', $salt . hash('sha256', $password));
    }

    private static function getSaltForUserID($user_id, DB $db) {
        $query = "
            SELECT salt
			  FROM " . $db->getTables()->USERS . "
			WHERE user_id = " . $db->cl($user_id);
        $result = $db->query($query);

        if($result) {
            return $result->fetch_row()['salt'];
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getLanguage() {
        return $this->language;
    }

    /**
     * @return mixed
     */
    public function getSalt() {
        return $this->salt;
    }

    /**
     * @return mixed
     */
    public function isActivated() {
        return $this->activated;
    }

    /**
     * @return mixed
     */
    public function getUserId() {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getNewPassword() {
        return $this->changePassword;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    

}