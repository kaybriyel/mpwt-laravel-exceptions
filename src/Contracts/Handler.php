<?php

namespace MPWT\Exceptions\Contracts;

use Illuminate\Foundation\Exceptions\Handler as ExceptionsHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

abstract class Handler extends ExceptionsHandler
{

    /**
     * Convert an exception into HTML content and store for later review.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $th
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public abstract function reportException(Request $request, Throwable $th): Response;

    /**
     * Convert an exception into HTML content
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * 
     * @return string|false
     *
     * @throws \Throwable
     */
    protected abstract function generateReport(Request $request, Throwable $th);


    /**
     * Generate report identifer
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * 
     * @return \MPWT\Exceptions\Contracts\ReportIdentifier
     */
    protected abstract function generateIdentifier(Request $request, Throwable $th): ReportIdentifier;


    /**
     * Save the generated HTML content
     * 
     * @param \MPWT\Exceptions\Contracts\ReportIdentifier $identifier
     * @param string $content
     * 
     * @return void
     */
    protected abstract function storeReport(ReportIdentifier $identifier, string $content): void;

    /**
     * Notify bug report via channel
     * 
     * @param \MPWT\Exceptions\Contracts\ReportIdentifier $identifier
     * @param string $content
     * 
     * @return void
     */
    protected abstract function notify(ReportIdentifier $identifier): void;
}
