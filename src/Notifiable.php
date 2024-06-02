<?php

namespace MPWT\Exceptions;

use MPWT\Exceptions\Contracts\NotifyChannel;

trait Notifiable
{
    /**
     * Send notification to channel
     *
     * @param \MPWT\Exceptions\Contracts\NotifyChannel $channel
     */
    public function notify(NotifyChannel $channel, array $form): ?string
    {
        $form = $channel->prepareForm($form);
        return match ($channel->withAttachment) {
            true    => $channel->sendAttachment($form),
            default => $channel->sendMessage($form)
        };
    }

    /**
     * Get channel for sending message
     *
     * @param string $name channel name
     *
     * @param string $token
     *
     * @return NotifyChannel
     */
    public function channel(string $name, string $token): NotifyChannel
    {
        return match ($name) {
            'telegram'  => $this->telegram($token),
            default     => $this->telegram($token)
        };
    }

    /**
     * Telegram channel
     *
     * @param string $token
     */
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
