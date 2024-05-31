<?php

namespace MPWT\Exceptions;

use Illuminate\Http\Request;

abstract class RequestFingerPrint
{

    /**
     * Generate request unique identfier
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return string|false
     *
     * @throws \Throwable
     */
    public static function unique(Request $request)
    {
        
        return sha1(json_encode([
            self::captureFull($request)
        ]));
    }

    public static function captureFull(Request $request) : array {
        return [
            'userAgent' => $request->userAgent(),
            'ip'        => $request->ip(),
            'clientIP'  => $request->getClientIp(),
            'timestamp' => $request->server('REQUEST_TIME'),
            'fullUrl'   => $request->fullUrl(),
            'method'    => $request->method(),
            'headers'   => $request->headers->all(),
            'server'    => $request->server(),
            'query'     => $request->query(),
            'request'   => $request->request->all(),
            'content'   => $request->getContent()
        ];
    }
}
