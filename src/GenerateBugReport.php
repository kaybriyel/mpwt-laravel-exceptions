<?php

namespace MPWT\Exceptions;

use Illuminate\Http\Request;
use MPWT\Exceptions\Contracts\ReportIdentifier as ContractsReportIdentifier;
use MPWT\Exceptions\ReportIdentifier;
use MPWT\Utils\Constants\Env;
use MPWT\Utils\Constants\General;
use Throwable;

trait GenerateBugReport
{
    /**
     * Generate report identifer
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $th
     *
     * @return \MPWT\Exceptions\Contracts\ReportIdentifier
     */
    protected function generateIdentifier(Request $request, Throwable $th): ContractsReportIdentifier
    {
        $rdi = new ReportIdentifier;

        $routeName          = $request->route()->getName();
        $hasAppFingerPrint  = app()->offsetExists(General::FINGER_PRINT);
        $appFingerPrint     = $hasAppFingerPrint ? app()->fingerPrint : 0;

        $rdi->id            = crc32($appFingerPrint);
        $rdi->appName       = env(Env::APP_NAME);
        $rdi->routeName     = $routeName ? strtoupper($routeName) : 'YOUR REQUEST';
        $rdi->fingerPrint   = $hasAppFingerPrint ? $appFingerPrint : $this->getFingerPrint($request);
        $rdi->fullUrl       = $request->fullUrl();
        $rdi->errorClass    = relative_path(get_class($th));
        $rdi->errorFile     = relative_path($th->getFile()) . " " . $th->getLine();
        $rdi->errorMessage  = $th->getMessage();
        $rdi->errorCode     = $th->getCode();
        $rdi->hasAppFingerPrint = $hasAppFingerPrint;

        return $rdi;
    }

    /**
     * Convert an exception into HTML content
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $th
     *
     * @return string|false
     *
     * @throws \Throwable
     */
    protected function generateReport(Request $request, Throwable $th): string|bool
    {
        // get configured debug mode
        $originalState = config(General::APP_DEBUG);

        // enable debug mode
        config([General::APP_DEBUG => 1]);

        // get html bug report page content
        $content = $this->toIlluminateResponse(
            $this->convertExceptionToResponse($th),
            $th
        )->prepare($request)
            ->getContent();

        // reset debug mode
        config([General::APP_DEBUG => $originalState]);

        return $content;
    }

    /**
     * Save the generated HTML content
     *
     * @param \MPWT\Exceptions\Contracts\ReportIdentifier $identifier
     * @param string $content
     *
     * @return void
     */
    protected function storeReport(ContractsReportIdentifier $identifier, string $content): void
    {
        // save bug report to storage
        file_put_contents($identifier->getFullFileName(), $content);

        // report will be deleted after notify
    }
}
