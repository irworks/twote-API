<?php
/**
 * Created by irworks on 30.07.16.
 * © Copyright irworks, 2016
 * All rights reserved, do not distribute
 */

/**
 * Module: [INSERT]
 * File: v2/httpHeader.php
 * Depends: [NONE]
 */

namespace twoteAPI\Models;
require_once 'baseModel.object.php';

class HTTPHeader extends BaseModel
{
    protected $Devicetype;
    protected $Appversion;
    protected $Apiversion;
    protected $Bundleidentifier;
    protected $Verification;
    protected $Timestamp;
    protected $Language = DEFAULT_LANG;

    /**
     * @return mixed
     */
    public function getDevicetype() {
        return $this->Devicetype;
    }

    /**
     * @return mixed
     */
    public function getAppversion() {
        return $this->Appversion;
    }

    /**
     * @return mixed
     */
    public function getApiversion() {
        return $this->Apiversion;
    }

    /**
     * @return mixed
     */
    public function getBundleidentifier() {
        return $this->Bundleidentifier;
    }

    /**
     * @return mixed
     */
    public function getVerification() {
        return $this->Verification;
    }

    /**
     * @return mixed
     */
    public function getTimestamp() {
        return $this->Timestamp;
    }

    /**
     * @return mixed
     */
    public function getLanguage() {
        return $this->Language;
    }

}