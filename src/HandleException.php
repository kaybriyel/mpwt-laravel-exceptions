<?php

namespace MPWT\Exceptions;

use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Throwable;

trait HandleException
{
    /**
     * Handle exception
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $th
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public static function handleException(Request $request, Throwable $th)
    {
        $exceptionHandler = app(Handler::class);
        return $exceptionHandler->reportException($request, $th);
    }
}
