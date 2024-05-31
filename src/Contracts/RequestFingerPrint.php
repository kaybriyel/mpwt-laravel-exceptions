<?php

namespace MPWT\Exceptions\Contracts;

use Illuminate\Http\Request;

interface RequestFingerPrint
{

    /**
     * Generate request unique identfier
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return string|false
     *
     */
    public function unique(Request $request): string;

    /**
     * Convert request to array
     * 
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return array
     */
    public function convertToArray(Request $request): array;
}
