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
    protected $deviceType;
    protected $appVersion;
    protected $apiVersion;
    protected $bundleIdentifier;
}