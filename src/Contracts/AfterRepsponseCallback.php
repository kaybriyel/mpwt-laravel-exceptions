<?php

namespace MPWT\Exceptions\Contracts;

interface AfterRepsponseCallback
{
    /**
     * Add callable function to be called in kernel terminate method
     * 
     * @param callable $callback
     * 
     * @return void
     */
    public function addAfterResponseCallbacks(callable $callback): void;

    /**
     * Executes all callbacks
     * 
     * @return void
     */
    public function callAfterResponseCallbacks(): void;
}