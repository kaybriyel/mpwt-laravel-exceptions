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
    public $app_name;


    /**
     * @var string error class
     */
    public $error_class;

    /**
     * @var string error file
     */
    public $error_file;

    /**
     * @var string error message
     */
    public $error_message;

    /**
     * @var int error code
     */
    public $error_code;

    /**
     * @var string route name
     */
    public $route_name;

    /**
     * @var string finger print
     */
    public $finger_print;

    /**
     * @var string full url
     */
    public $full_url;

    /**
     * @var bool has_app_finger_print
     */
    public $has_app_finger_print;

}
