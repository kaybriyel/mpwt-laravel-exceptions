<?php

namespace MPWT\Exceptions;

use Illuminate\Http\Request;
use MPWT\Exceptions\Contracts\CanGenerateBugReport;
use MPWT\Exceptions\Contracts\ReportIdentifier as ContractsReportIdentifier;
use MPWT\Exceptions\ReportIdentifier;
use MPWT\Utils\Constants\Env;
use MPWT\Utils\Constants\General;

trait GenerateBugReport
{
    use CanGenerateBugReport;
    
    /** {@inheritdoc} */
    protected function generateIdentifier(Request $request, \Throwable $th): ContractsReportIdentifier
    {
        $routeName          = $request->route()->getName();
        $hasAppFingerPrint  = app()->offsetExists(General::FINGER_PRINT);
        $appFingerPrint     = $hasAppFingerPrint ? app()->fingerPrint : 0;
        
        $rdi = new ReportIdentifier();
        $rdi->setId(crc32($appFingerPrint));
        $rdi->setAppName(env(Env::APP_NAME));
        $rdi->setRouteName($routeName ? strtoupper($routeName) : 'YOUR REQUEST');
        $rdi->setFingerPrint($hasAppFingerPrint ? $appFingerPrint : $rdi->getFingerPrint($request));
        $rdi->setFullUrl($request->fullUrl());
        $rdi->setErrorClass(relative_path(get_class($th)));
        $rdi->setErrorFile(relative_path($th->getFile()) . " " . $th->getLine());
        $rdi->setErrorMessage($th->getMessage());
        $rdi->setErrorCode($th->getCode());
        $rdi->setHasAppFingerPrint($hasAppFingerPrint);

        return $rdi;
    }

    /** {@inheritdoc} */
    protected function generateReport(Request $request, \Throwable $th): ?string
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

    /** {@inheritdoc} */
    protected function storeReport(ContractsReportIdentifier $identifier, string $content): void
    {
        // save bug report to storage
        file_put_contents($identifier->getFullFileName(), $content);

        // report will be deleted after notify
    }
}
