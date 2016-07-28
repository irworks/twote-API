<?php
/**
 * Created by irworks on 28.07.16.
 * © Copyright irworks, 2016
 * All rights reserved, do not distribute
 */

/**
 * Module: twoteAPI Models, the Base Model
 * File: v2/baseModel.object.php
 * Depends: [NONE]
 */

namespace twoteAPI\Models;


class BaseModel
{
    protected $code;
    protected $message;

    /**
     * BaseModel constructor - Map a key => value array to a class
     * @param array $keyValueArray
     */
    function __construct($keyValueArray = array()) {

        var_dump($keyValueArray);

        foreach ($keyValueArray as $key => $value) {
            foreach (get_class_vars(get_class($this)) as $varKey => $varValue) {
                if($varKey === $key) {
                    $this->$varKey = $value;
                }
            }
        }

    }

    /**
     * Fetches existing class properties and turns them into a php array.
     * @return array
     */
    public function toArray() {
        return get_object_vars($this);
    }
}