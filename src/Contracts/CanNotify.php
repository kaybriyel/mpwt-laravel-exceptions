<?php

namespace MPWT\Exceptions\Contracts;

use Throwable;

trait CanNotify
{
    /**
     * Send notification to channel
     *
     * @param \MPWT\Exceptions\Contracts\NotifyChannel $channel
     */
    abstract public function notify(NotifyChannel $channel, array $form): ?string;
}
