<?php

namespace MPWT\Exceptions\Traits;

use MPWT\Exceptions\AfterRepsponseCallback;

trait HasAfterRepsponseCallback
{
    /**
     * Add callable function to be called in kernel terminate method
     * 
     * @param callable $callback
     * 
     * @return void
     */
    public function addMPWTAfterResponseCallbacks(callable $callback)
    {
        $after_report = new AfterRepsponseCallback;
        $after_report->addAfterResponseCallbacks($callback);
    }

    /**
     * Executes all callbacks
     * 
     * @return void
     */
    public function callMPWTAfterResponseCallbacks()
    {
        $after_report = new AfterRepsponseCallback;
        $after_report->callAfterResponseCallbacks();
    }
}
