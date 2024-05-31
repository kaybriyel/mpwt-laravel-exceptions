<?php

namespace MPWT\Exceptions\Traits;

use Illuminate\Http\Request;
use MPWT\Exceptions\RequestFingerPrint;

trait HasRequestFingerPrint
{

    /**
     * Generate request unique identfier
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return string|false
     *
     */
    public function getFingerPrint(Request $request)
    {
        $generator = new RequestFingerPrint;
        return $generator->unique($request);
    }

}