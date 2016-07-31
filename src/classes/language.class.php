<?php
/**
 * Created by irworks on 31.07.16.
 * © Copyright irworks, 2016
 * All rights reserved, do not distribute
 */

/**
 * Module: Language Controller
 * File: v2/language.class.php
 * Depends: DB
 */

namespace twoteAPI\Classes;


class Language
{
    private $db;
    private $lang;

    function __construct(DB $db, $lang = DEFAULT_LANG) {
        $this->db   = $db;
        $this->lang = $lang;

        $this->generateLanguageCache();
    }

    /**
     * Gets a localized string.
     * @param string $key
     * @param $lang
     * @return string
     */
    public function get($key = '', $lang = null) {
        $LANG_ARRAY = LanguageCache::$LANG_ARRAY;
        $lang       = isset($lang)       ? $lang       : $this->lang;

        if(key_exists($key, $LANG_ARRAY)) {
            return $LANG_ARRAY[$key][$lang];
        }else{
            return $key;
        }
    }

    /**
     * Generate a php array cache of the language table.
     */
    private function generateLanguageCache() {
        if(file_exists(LANG_CACHE_FILE)) {
            require_once LANG_CACHE_FILE;
            return;
        }

        if(!file_exists(CACHE_DIR)) {
            mkdir(CACHE_DIR);
        }

        $output = "<?php" . PHP_EOL;
        $output .= '/**' .PHP_EOL;
        $output .= ' * This class is code generated. To flush the cache, delete it.' . PHP_EOL;
        $output .= ' * This file was generated at: ' . date("Y-m-d H:i:s") . PHP_EOL;
        $output .= '*/' . PHP_EOL . PHP_EOL;
        $output .= 'namespace twoteAPI\Classes;' . PHP_EOL . PHP_EOL . PHP_EOL;
        $output .= 'class LanguageCache {' . PHP_EOL;

        $output .= "    public static \$LANG_ARRAY = array(" . PHP_EOL;

        //I am sorry for using SELECT *, but i don't want to be harding value_en, value_de etc.
        $query = "SELECT * FROM " . $this->db->getTables()->LANGUAGE;
        $result = $this->db->query($query);

        while ($result && $row = $result->fetch_assoc()) {
            $output .= "        '" . $row['lang_key'] . "' => array(" . PHP_EOL;

            foreach ($row as $key => $value) {
                if(strpos($key, 'value_') !== false) {
                    $output .= "            '" . str_replace('value_', '', $key) . "' => '" . $value . "'," . PHP_EOL;
                }
            }

            $output .= '        ), ' . PHP_EOL . PHP_EOL;
        }

        $output .= "    );" . PHP_EOL;
        $output .= "}" . PHP_EOL;
        $output .= PHP_EOL . '?>';
        file_put_contents(LANG_CACHE_FILE, $output);

        require_once LANG_CACHE_FILE;
    }

}