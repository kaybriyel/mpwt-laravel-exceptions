<?php

namespace MPWT\Exceptions;

use MPWT\Exceptions\Contracts\AfterRepsponseCallback as ContractsAfterRepsponseCallback;

class AfterRepsponseCallback implements ContractsAfterRepsponseCallback
{

    private static $after_response_callbacks = [];

    public function addAfterResponseCallbacks(callable $callback): void
    {
        self::$after_response_callbacks[] = $callback;
    }

    public function callAfterResponseCallbacks(): void
    {
        foreach (self::$after_response_callbacks as $callback) {
            $callback();
        }
    }
}