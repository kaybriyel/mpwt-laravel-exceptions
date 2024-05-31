<?php

namespace MPWT\Exceptions\Contracts;

abstract class ReportIdentifier
{
    /**
     * @var id report id
     */

    public $id;

    /**
     * @var string app name
     */
    public $appName;


    /**
     * @var string error class
     */
    public $errorClass;

    /**
     * @var string error file
     */
    public $errorFile;

    /**
     * @var string error message
     */
    public $errorMessage;

    /**
     * @var int error code
     */
    public $errorCode;

    /**
     * @var string route name
     */
    public $routeName;

    /**
     * @var string finger print
     */
    public $fingerPrint;

    /**
     * @var string full url
     */
    public $fullUrl;

    /**
     * @var bool has app finger print
     */
    public $hasAppFingerPrint;

    /**
     * Get full filename
     * 
     * @return string
     */
    public abstract function getFullFileName() : string;

    /**
     * Get directory
     * 
     * @return string
     */
    public abstract function getDirectoryName() : string;
}
