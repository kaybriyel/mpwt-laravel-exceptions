<?php

namespace MPWT\Exceptions;

use MPWT\Exceptions\Handler;
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
        return (new Handler(app()))->handle($th);
    }
}
