<?php

namespace MPWT\Exceptions\Contracts;

abstract class NotifyChannel
{
    public string $url;
    public bool $withAttachment = false;
    
    abstract public function prepareForm(array $form): string;
    abstract public function sendAttachment(string $form);
    abstract public function sendMessage(string $form);
}
