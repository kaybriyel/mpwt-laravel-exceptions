<?php

namespace MPWT\Exceptions\Contracts\Traits;

abstract class NotifyChannel
{
    /** @var string $url */
    protected $url;
 
    public function __construct(string $url) {
        $this->url = $url;
    }
    
    /** Prepare form */
    abstract public function prepareForm(array $form): string;

    /** Send message with attachment */
    abstract public function sendAttachment(string $form): ?string;

    /** Send plain message */
    abstract public function sendMessage(string $form): ?string;
}
