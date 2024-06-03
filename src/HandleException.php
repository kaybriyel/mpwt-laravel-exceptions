<?php

namespace MPWT\Exceptions;

use MPWT\Exceptions\Contracts\CanHandleException;
use MPWT\Exceptions\Handler;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

trait HandleException
{
    use CanHandleException;
    
    /** {@inheritdoc} */
    public static function handleException(Throwable $th): Response
    {
        $th = $th instanceof Error ? new FatalThrowableError($th) : $th;
        return (new Handler(app()))->handle($th);
    }
}
