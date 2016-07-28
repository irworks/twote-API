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
require_once '../models/baseModel.object.php';
require_once '../models/person.object.php';

use twoteAPI\Models\BaseModel;
use twoteAPI\Models\Person;

class TwoteAPI extends API
{

    public function __construct($request, $origin, $htmlHeaders, $db, $lang) {
        parent::__contruct($request);
    }

    public function account() {
        if(empty($this->verb)){
            throw new \Exception('method_unsupported');
        }

        $person = new BaseModel();

        switch($this->verb){
            case 'login':
                $person = Person::login($this->request, $this->db, $this->header);
                break;
            case 'logout':
                $person = Person::logout($this->db, $this->header);
                break;
        }
        if ($person == null) {
            throw new \Exception('user_unknown');
        }
        $this->person = $person;

        return $person->toArray();
    }

}