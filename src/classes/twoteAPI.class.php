<?php
/**
 * Created by irworks on 28.07.16.
 * © Copyright irworks, 2016
 * All rights reserved, do not distribute
 */

/**
 * Module: Main API handler
 * File: v2/twoteAPI.class.php
 * Depends: index.php
 */

namespace twoteAPI\Classes;

require_once 'api.class.php';
require_once __DIR__ . '/../models/baseModel.object.php';
require_once __DIR__ . '/../models/person.object.php';

use twoteAPI\Models\BaseModel;
use twoteAPI\Models\Person;

class TwoteAPI extends API
{
    private $db;
    private $person;

    public function __construct($request, $origin, $htmlHeaders, $db, $lang) {
        parent::__construct($request);

        $this->db       = $db;
        $this->header   = $htmlHeaders;
    }
    
    /* verb calls */
    public function account() {
        $person = new BaseModel();

        switch($this->verb){
            case 'login':
                $person = Person::login(new Person($this->request), $this->db);
                break;
            case 'logout':
                //$person = Person::logout($this->db, $this->header);
                break;
            case 'test':
                var_dump($_SESSION[SESSION_KEY]);
                break;
        }

        $this->person = $person;
        return $person->toArray();
    }

}