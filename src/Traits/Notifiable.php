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
        if ($withAttachment) {
            return $channel->sendAttachment($form);
        }
        return $channel->sendMessage($form);
    }

    /** {@inheritdoc} */
    public function channel(string $name, string $token): NotifyChannel
    {
        if ($name === 'telegram') {
            return $this->telegram($token);
        }
        return $this->telegram($token);
    }

    /** {@inheritdoc} */
    private function telegram(string $token)
    {
        return new NotifyChannel("https://api.telegram.org/$token");
    }
}
