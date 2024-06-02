<?php

namespace MPWT\Exceptions;

use Illuminate\Support\Facades\Storage;
use MPWT\Exceptions\Contracts\ReportIdentifier as ContractsReportIdentifier;
use MPWT\Utils\Constants\Env;

class ReportIdentifier extends ContractsReportIdentifier implements Env
{
    public const DEFAULT_DIR        = 'exception-reports';
    public const DEFAULT_STORAGE    = 'local';

    public function getFullFileName(): string
    {
        $dir = $this->getDirectoryName();
        return storage_path("$dir/$this->id.html");
    }

    public function getDirectoryName(): string
    {
        $storage    = Storage::disk(env(static::EXCEPTION_REPORT_STORAGE, static::DEFAULT_STORAGE));
        $folder     = env(static::EXCEPTION_REPORT_DIR, static::DEFAULT_DIR);

        if (!$storage->exists($folder)) {
            $storage->makeDirectory($folder);
        }

        return "app/$folder";
    }
}
