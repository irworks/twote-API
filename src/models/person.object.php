<?php
/**
 * Created by irworks on 28.07.16.
 * © Copyright irworks, 2016
 * All rights reserved, do not distribute
 */

/**
 * Module: [INSERT]
 * File: v2/person.object.php
 * Depends: [NONE]
 */

namespace twoteAPI\Models;
use twoteAPI\Classes\DB;

require_once 'baseModel.object.php';

class Person extends BaseModel
{
    protected $username;
    protected $password;
    protected $email;
    protected $language;
    
    private $salt;
    private $activated;

    public static function login(Person $person, DB $db) {

        $dbPerson = null;
        
        $query = "
            SELECT user_id, username, password, salt, activated
			  FROM users
			WHERE username = LOWER(" . $db->cl($person->getUsername()) . ")";

        $result = $db->query($query);
        if($result && $dbPerson = $result->fetch_object(get_class())) {

            if(!$dbPerson->isActivated()) {
                throw new \Exception('error.person.not_activated', 1001);
            }else{
                $hash = hash('sha256', $dbPerson->getSalt() . hash('sha256', $person->getPassword()));

                if($hash === $dbPerson->getPassword()) {
                    ini_set('session.gc_maxlifetime', 2678400);

                    session_regenerate_id();
                    $_SESSION[SESSION_KEY] = $dbPerson;
                    session_write_close();

                    return $dbPerson;
                }else{
                    throw new \Exception('error.person.wrong_credentials', 1002);
                }
            }

         } else {
            throw new \Exception('error.person.not_found: ' . $query, 1003);
        }
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

}