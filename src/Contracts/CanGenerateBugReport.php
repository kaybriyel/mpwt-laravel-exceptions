<?php

namespace MPWT\Exceptions\Contracts;

use Illuminate\Http\Request;

trait CanGenerateBugReport
{
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
    abstract protected function generateReport(Request $request, \Throwable $th): ?string;

    /**
     * Generate report identifer
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $th
     *
     * @return \MPWT\Exceptions\Contracts\ReportIdentifier
     */
    abstract protected function generateIdentifier(Request $request, \Throwable $th): ReportIdentifier;

    /**
     * Save the generated HTML content
     *
     * @param \MPWT\Exceptions\Contracts\ReportIdentifier $identifier
     * @param string $content
     *
     * @return void
     */
    abstract protected function storeReport(ReportIdentifier $identifier, string $content): void;
}
