<?php

namespace MPWT\Exceptions\Contracts;

use MPWT\Http\Traits\CanExecuteAfterResponse;
use Symfony\Component\HttpFoundation\Response;

trait CanHandleException
{
    use CanExecuteAfterResponse, CanGenerateBugReport, CanNotifyBugReport;

    /**
     * Response short meaningful message
     *
     * @param \MPWT\Exceptions\Contracts\ReportIdentifier $identifier
     * @return \Symfony\Component\HttpFoundation\Response
     */
    abstract protected function reasonableResponse(ReportIdentifier $identifier): Response;
}
