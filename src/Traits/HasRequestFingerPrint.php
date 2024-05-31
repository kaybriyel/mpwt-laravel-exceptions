<?php

namespace MPWT\Exceptions\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

    /**
     * Set finger print on app
     * 
     * @return void
     */
    public function setAppFingerPrint(Request $request)
    {
        if (app()->offsetExists('finger_print')) return;

        $finger_print = $this->getFingerPrint($request);

        app()->finger_print = $finger_print;

        Log::withContext([
            'context_id' => $finger_print
        ]);
    }
}
