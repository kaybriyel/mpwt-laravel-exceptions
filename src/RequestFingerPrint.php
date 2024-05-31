<?php

namespace MPWT\Exceptions;

use Illuminate\Http\Request;
use MPWT\Exceptions\Contracts\RequestFingerPrint as ContractsRequestFingerPrint;

class RequestFingerPrint implements ContractsRequestFingerPrint
{

    public function unique(Request $request): string
    {
        return sha1(json_encode([
            $this->convertToArray($request)
        ]));
    }

    public function convertToArray(Request $request): array
    {
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
