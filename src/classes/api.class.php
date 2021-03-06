<?php
/**
 * Created by irworks on 28.07.16.
 * © Copyright irworks, 2016
 * All rights reserved, do not distribute
 */

/**
 * Module: General API base class
 * @link http://coreymaynard.com/blog/creating-a-restful-api-with-php/
 * File: v2/api.class.php
 * Depends: [NONE]
 */

namespace twoteAPI\Classes;


abstract class API
{
    protected $request;

    /**
     * Property: method
     * The HTTP method this request was made in, either GET, POST, PUT or DELETE
     */
    protected $method = '';

    /**
     * Property: endpoint
     * The Model requested in the URI. eg: /files
     */
    protected $endpoint = '';

    /**
     * Property: verb
     * An optional additional descriptor about the endpoint, used for things that can
     * not be handled by the basic methods. eg: /files/process
     */
    protected $verb = '';

    /**
     * Property: args
     * Any additional URI components after the endpoint and verb have been removed, in our
     * case, an integer ID for the resource. eg: /<endpoint>/<verb>/<arg0>/<arg1>
     * or /<endpoint>/<arg0>
     */
    protected $args = Array();

    /**
     * Property: file
     * Stores the input of the PUT request
     */
    protected $file = Null;

    protected $header;
    protected $rawInput;

    /**
     * Constructor: __construct
     * Allow for CORS, assemble and pre-process the data
     * @param $request
     * @throws \Exception
     */
    public function __construct($request) {
        if(defined('API_TESTING')){
            // this is a php unit test, no init from global data required,
            // since all configuration will happen directly on the tested classes
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
            header('Access-Control-Max-Age: 1728000');
            exit;
        }

        $this->args = explode('/', rtrim($request, '/'));
        $this->endpoint = array_shift($this->args);
        if (array_key_exists(0, $this->args)) {
            $this->verb = array_shift($this->args);
        }

        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                throw new \Exception("unexpected_header");
            }
        }

        switch($this->method) {
            case 'POST':
                $this->rawInput = file_get_contents("php://input");
                $this->request  = $this->_cleanInputs(json_decode($this->rawInput, true));
                break;
            case 'DELETE':
            case 'GET':
                $this->request  = $this->_cleanInputs($_GET);
                break;
            case 'PUT':
                $this->rawInput = file_get_contents("php://input");
                $this->request  = $this->_cleanInputs($_GET);
                $this->file     = $this->_cleanInputs(json_decode($this->rawInput, true));
                break;
            default:
                $this->_response('invalid_method', 405);
                break;
        }
    }

    public function processAPI() {
        if (method_exists($this, $this->endpoint)) {
            /* requesting to the function */
            return $this->_response($this->{$this->endpoint}($this->args));
        }
        return $this->_response("No Endpoint: $this->endpoint", 404);
    }

    private function _response($data, $status = 200) {
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
        return json_encode($this->postProcessData($data));
    }

    protected function postProcessData($data) {
        return $data;
    }

    private function _cleanInputs($data) {
        $clean_input = Array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->_cleanInputs($v);
            }
        } else {
            $clean_input = trim(strip_tags($data));
        }
        return $clean_input;
    }

    private function _requestStatus($code) {
        $status = array(
            200 => 'OK',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($status[$code])?$status[$code]:$status[500];
    }

    public function setMethod($method){
        if(defined('API_TESTING')){
            $this->method = $method;
        }
    }

    public function setVerb($verb){
        if(defined('API_TESTING')){
            $this->verb = $verb;
        }
    }

    public function setRequest($request){
        if(defined('API_TESTING')){
            $this->request = $request;
        }
    }


    /**
     * @return array|string
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return mixed
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @return mixed
     */
    public function getVerb()
    {
        return $this->verb;
    }

    /**
     * @return mixed
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * @return mixed
     */
    public function getHeader()
    {
        return $this->header;
    }
}

?>