<?php

namespace MPWT\Exceptions;

use MPWT\Exceptions\Contracts\ReportIdentifier as ContractsReportIdentifier;

class ReportIdentifier extends ContractsReportIdentifier
{

    function __construct(
        string $app_name,
        string $route_name,
        string $error_class,
        string $error_file,
        string $error_message,
        int $error_code,
        string $finger_print,
        string $full_url,
        bool $has_app_finger_print
    )
    {
        $this->id               = hash('crc32', $finger_print);
        $this->app_name         = $app_name;
        $this->route_name       = $route_name;
        $this->error_class      = $error_class;
        $this->error_file       = $error_file;
        $this->error_message    = $error_message;
        $this->error_code       = $error_code;
        $this->finger_print     = $finger_print;
        $this->full_url         = $full_url;
        $this->has_app_finger_print = $has_app_finger_print;
    }
}