<?php
/**
 * Created by irworks on 28.07.16.
 * © Copyright irworks, 2016
 * All rights reserved, do not distribute
 */

/**
 * Module: Database
 * File: v2/db.class.php
 * Depends: PHP-mysqli
 */

namespace twoteAPI\Classes;


class DB extends \mysqli
{
    public function cl($input) {

        if ($input === NULL || $input === false) {
            return 'NULL';
        }

        return "'" .  \mysqli::escape_string($input) . "'" ;
    }

    public function clr($input) {
        return "`" .  \mysqli::escape_string($input) . "`" ;
    }

    public function query($input) {
        $out = parent::query($input);

        if(empty($out)){
            error_log('Qurey failed! ' . $this->error);
        }

        while ($this->more_results() && $this->next_result()){
            //free each result.
            $result = $this->use_result();
            if(!empty($result)) $result->free();
        }

        return $out;
    }
    
}