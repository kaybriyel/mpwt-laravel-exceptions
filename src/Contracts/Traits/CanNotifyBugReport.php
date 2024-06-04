<?php

namespace MPWT\Exceptions\Contracts\Traits;

use MPWT\Exceptions\Contracts\ReportIdentifier;

trait CanNotifyBugReport
{
    use CanNotify;
    
    /**
     * Notify bug report via channel
     *
     * @param \MPWT\Exceptions\Contracts\ReportIdentifier $identifier
     * @param string $content
     *
     * @return void
     */
    abstract protected function notifyBugReport(ReportIdentifier $identifier): void;
}
