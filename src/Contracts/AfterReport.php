<?php

namespace MPWT\Exceptions\Contracts;

trait AfterReport
{
    private static $teminate_callbacks = [];

    public abstract function addTerminateCallbacks(callable $callback);

    protected abstract function callTerminateCallbacks();
}