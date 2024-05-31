<?php

namespace MPWT\Exceptions;

use Illuminate\Support\Facades\Storage;
use MPWT\Exceptions\Contracts\ReportIdentifier as ContractsReportIdentifier;

class ReportIdentifier extends ContractsReportIdentifier
{

    function __construct(
        string $appName,
        string $routeName,
        string $errorClass,
        string $errorFile,
        string $errorMessage,
        int $errorCode,
        string $fingerPrint,
        string $fullUrl,
        bool $hasAppFingerPrint
    ) {
        $this->id               = hash('crc32', $fingerPrint);
        $this->appName         = $appName;
        $this->routeName       = $routeName;
        $this->errorClass      = $errorClass;
        $this->errorFile       = $errorFile;
        $this->errorMessage    = $errorMessage;
        $this->errorCode       = $errorCode;
        $this->fingerPrint     = $fingerPrint;
        $this->fullUrl         = $fullUrl;
        $this->hasAppFingerPrint = $hasAppFingerPrint;
    }

    public function getFullFileName(): string
    {
        $dir = $this->getDirectoryName();
        return storage_path("$dir/$this->id.html");
    }

    public function getDirectoryName(): string
    {
        $folder = 'exception-reports';

        if (!Storage::disk('local')->exists($folder)) {
            Storage::disk('local')->makeDirectory($folder);
        }

        return "app/$folder";
    }
}
