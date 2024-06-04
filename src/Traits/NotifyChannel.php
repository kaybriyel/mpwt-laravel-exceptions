<?php

namespace MPWT\Exceptions\Traits;

use MPWT\Exceptions\Contracts\Traits\NotifyChannel as TraitsNotifyChannel;

class NotifyChannel extends TraitsNotifyChannel
{
    /** {@inheritdoc} */
    public function prepareForm(array $form): string
    {
        return '--form ' . implode(' --form ', $form);
    }

    /** {@inheritdoc} */
    public function sendAttachment(string $form): ?string
    {
        return `curl --location '$this->url/sendDocument' $form`;
    }

    /** {@inheritdoc} */
    public function sendMessage(string $form): ?string
    {
        return `curl --location '$this->url/sendMessage' $form`;
    }
}
