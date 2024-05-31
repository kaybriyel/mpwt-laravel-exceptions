<?php

namespace MPWT\Exceptions\Traits;

use Illuminate\Http\Request;
use MPWT\Exceptions\Handler;
use Throwable;

trait HandleException
{

    /**
     * Create exception handler
     */
    private static function createHandler(): Handler
    {
        return app(Handler::class);
    }

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
        return static::createHandler()->reportException($request, $th);
    }
}
