<?php

namespace MPWT\Exceptions\Contracts;

use Illuminate\Foundation\Exceptions\Handler as ExceptionsHandler;
use Illuminate\Http\Request;
use MPWT\Exceptions\Contracts\Traits\CanGenerateBugReport;
use MPWT\Exceptions\Contracts\Traits\CanNotifyBugReport;
use MPWT\Http\Traits\CanExecuteAfterResponse;
use MPWT\Http\Traits\HasRequestFingerPrint;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\HttpFoundation\Response;

abstract class Handler extends ExceptionsHandler
{
    use HasRequestFingerPrint, CanExecuteAfterResponse, CanGenerateBugReport, CanNotifyBugReport;

    /**
     * Handle exception
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $th
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    abstract public function handle(\Throwable $th): Response;

    /**
     * Handle exception after response
     * @param \MPWT\Exceptions\Contracts\ReportIdentifier $identifier
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $th
     *
     * @return void
     */
    abstract protected function handleAfterResponse(ReportIdentifier $identifier, Request $request, \Throwable $th): void;

    /**
     * Response short meaningful message
     *
     * @param \MPWT\Exceptions\Contracts\ReportIdentifier $identifier
     * @return \Symfony\Component\HttpFoundation\Response
     */
    abstract protected function reasonableResponse(ReportIdentifier $identifier): Response;

    /**
     * Create exception handler instance
     *
     * @return \MPWT\Exceptions\Contracts\Handler
     */
    public static function create(): static
    {
        return app(static::class);
    }

    /**
     * Handle exception
     *
     * @param \Throwable $th
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public static function handleException(\Throwable $th): Response
    {
        $th = $th instanceof \Error ? new FatalThrowableError($th) : $th;
        return static::create()->handle($th);
    }
}
