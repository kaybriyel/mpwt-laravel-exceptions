<?php

namespace MPWT\Exceptions;

use MPWT\Exceptions\Contracts\CanNotify;
use MPWT\Exceptions\Contracts\NotifyChannel;

trait Notifiable
{
    use CanNotify;
    
    /** {@inheritdoc} */
    public function notify(NotifyChannel $channel, array $form, bool $withAttachment = false): ?string
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
        // prepare channel
        $url    = "https://api.telegram.org/$token";

        $channel = new class extends NotifyChannel
        {
            public function prepareForm(array $form): string
            {
                return '--form ' . implode(' --form ', $form);
            }

            public function sendAttachment(string $form)
            {
                return `curl --location '$this->url/sendDocument' $form`;
            }

            public function sendMessage(string $form)
            {
                return `curl --location '$this->url/sendMessage' $form`;
            }
        };

        $channel->url = $url;
        return $channel;
    }
}
