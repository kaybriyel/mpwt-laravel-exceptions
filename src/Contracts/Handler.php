<?php

namespace MPWT\Exceptions\Contracts;

use MPWT\Http\Traits\HasRequestFingerPrint;
use Symfony\Component\HttpFoundation\Response;


trait Handler
{
    use CanHandleException, HasRequestFingerPrint;

    /**
     * Handle exception
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $th
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    abstract public static function handleException(\Throwable $th): Response;

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
}
