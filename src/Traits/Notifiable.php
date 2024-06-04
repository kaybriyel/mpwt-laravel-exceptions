<?php

namespace MPWT\Exceptions\Traits;

use MPWT\Exceptions\Contracts\Traits\CanNotify;
use MPWT\Exceptions\Contracts\Traits\NotifyChannel as ContractsNotifyChannel;

trait Notifiable
{
    use CanNotify;
    
    /** {@inheritdoc} */
    public function notify(ContractsNotifyChannel $channel, array $form, bool $withAttachment = false): ?string
    {
        $form = $channel->prepareForm($form);
        return match ($withAttachment) {
            true    => $channel->sendAttachment($form),
            default => $channel->sendMessage($form)
        };
    }

    /** {@inheritdoc} */
    public function channel(string $name, string $token): NotifyChannel
    {
        return match ($name) {
            'telegram'  => $this->telegram($token),
            default     => $this->telegram($token)
        };
    }

    /** {@inheritdoc} */
    private function telegram(string $token)
    {
        return new NotifyChannel("https://api.telegram.org/$token");
    }
}
