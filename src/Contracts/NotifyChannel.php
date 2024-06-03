<?php

namespace MPWT\Exceptions\Contracts;

abstract class NotifyChannel
{
    /** @var string $url */
    public $url;
    
    abstract public function prepareForm(array $form): string;
    abstract public function sendAttachment(string $form);
    abstract public function sendMessage(string $form);
}
