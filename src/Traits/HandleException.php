<?php

namespace MPWT\Exceptions\Traits;

use Illuminate\Http\Request;
use MPWT\Exceptions\Handler;
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
        $exceptionHandler = new Handler(app());
        return $exceptionHandler->reportException($request, $th);
    }
}
