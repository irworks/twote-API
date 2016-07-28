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
require_once 'baseModel.object.php';

class Person extends BaseModel
{
    private $username;
    private $password;
    private $email;
    private $language;

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
    
    
}