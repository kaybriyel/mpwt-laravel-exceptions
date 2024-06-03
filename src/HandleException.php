<?php

namespace MPWT\Exceptions;

use MPWT\Exceptions\Contracts\CanHandleException;
use MPWT\Exceptions\Handler;
use Symfony\Component\HttpFoundation\Response;

trait HandleException
{
    use CanHandleException;
    
    /** {@inheritdoc} */
    public static function handleException(\Throwable $th): Response
    {
        return (new Handler(app()))->handle($th);
    }
}
