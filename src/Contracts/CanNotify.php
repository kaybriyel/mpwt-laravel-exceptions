<?php

namespace MPWT\Exceptions\Contracts;

trait CanNotify
{
    /**
     * Send notification to channel
     *
     * @param \MPWT\Exceptions\Contracts\NotifyChannel $channel
     */
    abstract public function notify(NotifyChannel $channel, array $form, bool $withAttachment = false): ?string;

    /**
     * Get channel for sending message
     *
     * @param string $name channel name
     *
     * @param string $token
     *
     * @return NotifyChannel
     */
    abstract public function channel(string $name, string $token): NotifyChannel;
}
