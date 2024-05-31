<?php

namespace MPWT\Exceptions;

use MPWT\Exceptions\Contracts\AfterReport as ContractsAfterReport;

trait AfterReport
{
    use ContractsAfterReport;

    public function addTerminateCallbacks(callable $callback)
    {
        self::$teminate_callbacks[] = $callback;
    }

    protected function callTerminateCallbacks()
    {
        foreach (self::$teminate_callbacks as $callback) {
            $callback();
        }
    }
}