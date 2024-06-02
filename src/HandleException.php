<?php

namespace MPWT\Exceptions;

use Error;
use MPWT\Exceptions\Handler;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\HttpFoundation\Response;
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
    public static function handleException(Throwable $th): Response
    {
        $th = $th instanceof Error ? new FatalThrowableError($th) : $th;
        return (new Handler(app()))->handle($th);
    }
}
