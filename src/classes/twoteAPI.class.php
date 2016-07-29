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

    /**
     * /account endpoint - calls to /account/verb
     * @return array
     * @throws \Exception
     */
    public function account() {
        $person = new BaseModel();

        switch($this->verb){
            case 'login':
                $person = Person::login(new Person($this->request), $this->db);
                break;
            case 'show':
                $person = Person::show(new Person($_SESSION[SESSION_KEY]), $this->db);
                break;
            case 'save':
                $person = Person::save(new Person($this->request), $this->db);
                break;
            case 'logout':
                $person = Person::logout();
                break;
            default:
                $person->setCode(404);
                $person->setMessage('error.person.unknown_verb');
                break;
        }

        $this->person = $person;
        return $person->toArray();
    }

}