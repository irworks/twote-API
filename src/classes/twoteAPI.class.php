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
require_once __DIR__ . '/../models/twote.object.php';
require_once __DIR__ . '/../models/allTwotes.object.php';
require_once __DIR__ . '/../models/httpHeader.php';

use twoteAPI\Models\BaseModel;
use twoteAPI\Models\Person;
use twoteAPI\Models\Twote;
use twoteAPI\Models\AllTwotes;

use twoteAPI\Models\HTTPHeader;

class TwoteAPI extends API
{
    private $db;
    private $person;
    private $lang;

    public function __construct($request, $htmlHeaders, $db) {
        parent::__construct($request);

        $this->db       = $db;
        $this->header   = new HTTPHeader($htmlHeaders);
        $this->lang     = $this->header->getLanguage();
        
        $this->verifyRequest();
        $this->generateLanguageCache();
    }
    
    protected function verifyRequest() {
        $currentTimestamp = time();
        
        if($currentTimestamp - ($this->getHeader()->getTimestamp()) > REQUEST_TIMEOUT) {
            throw new \Exception('error.general.bad_request', 9901);
        }

        if(isset($this->rawInput)) {
            if(md5($this->getHeader()->getTimestamp() . md5($this->rawInput)) !== $this->getHeader()->getVerification()) {
                throw new \Exception('error.general.bad_request', 9902);
            }
        }
    } 

    /**
     * /account endpoint - calls to /account/verb
     * @return array
     * @throws \Exception
     */
    public function account() {
        $person = new BaseModel();

        switch ($this->method) {
            case 'GET':
                $person = Person::show(new Person($_SESSION[SESSION_KEY]), $this->db);
                break;

            case 'PUT':
                $person = Person::save($this->verb, new Person($this->file), $this->db);
                break;
            
            case 'POST':
                switch($this->verb){
                    case 'login':
                        $person = Person::login(new Person($this->request), $this->db);
                        break;
                    case 'logout':
                        $person = Person::logout();
                        break;
                    default:
                        $person->setCode(404);
                        $person->setMessage('error.person.unknown_verb');
                        break;
                }
                break;
        }

        $this->person = $person;
        return $person->toArray();
    }

    /**
     * /twote endpoint
     * @return array
     */
    public function twote() {
        $twote  = new BaseModel();
        $person = new Person($_SESSION[SESSION_KEY]);
        
        switch ($this->method) {
            case 'GET':
                switch ($this->verb) {
                    case 'all':
                        $twote = AllTwotes::showAllForUser($person->getUserId(), $this->db);
                        break;
                    default:
                        $twote = Twote::show($this->verb, $this->db);
                        break;
                }
                break;
            case 'POST':
                $twote = Twote::save(new Twote($this->request), $person, $this->db);
                break;
            case 'PUT':
                $twote = Twote::update($this->verb, new Twote($this->file), $person, $this->db);
                break;
            case 'DELETE':
                $twote = Twote::delete($this->verb, $person, $this->db);
                break;
        }
        
        return $twote->toArray();
    }

    private function generateLanguageCache() {
        if(file_exists(LANG_CACHE_FILE)) {
            return;
        }

        if(!file_exists(CACHE_DIR)) {
            mkdir(CACHE_DIR);
        }

        $output = "<?php" . PHP_EOL;
            $output .= "\$LANG_ARRAY = array(" . PHP_EOL;
        
        //TODO: make this more dynamic
        $query = "SELECT lang_key, value_en, value_de FROM language";
        $result = $this->db->query($query);

        while ($result && $row = $result->fetch_assoc($result)) {
            $output .= "'" . $row['key'] . "' => array(" . PHP_EOL;
                $output .= "'en' => '" . $row['value_en'] . "'," . PHP_EOL;
                $output .= "'de' => '" . $row['value_de'] . PHP_EOL;
            $output .= '), ';
        }

            $output .= ");" . PHP_EOL;
        $output .= PHP_EOL . '?>';
        file_put_contents(LANG_CACHE_FILE, $output);
    }

}