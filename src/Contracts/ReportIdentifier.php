<?php

namespace MPWT\Exceptions\Contracts;

use MPWT\Exceptions\Contracts\ReportIdentifer\Getter;
use MPWT\Exceptions\Contracts\ReportIdentifer\Setter;

abstract class ReportIdentifier
{
    use Getter, Setter;
    
    /** @var string $id report id */
    public $id;

    /** @var string app name */
    public $appName;

    /** @var string error class */
    public $errorClass;

    /**  @var string error file */
    public $errorFile;

    /** * @var string error message */
    public $errorMessage;

    /** * @var int error code */
    public $errorCode;

    /** * @var string route name */
    public $routeName;

    /** * @var string finger print */
    public $fingerPrint;

    /** * @var string full url */
    public $fullUrl;

    /** * @var bool has app finger print */
    public $hasAppFingerPrint;

    /**
     * Get report full filename
     *
     * @return string
     */
    abstract public function getFullFileName(): string;

    /**
     * Get report directory
     *
     * @return string
     */
    abstract public function getDirectoryName(): string;
}
