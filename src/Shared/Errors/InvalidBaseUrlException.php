<?php

namespace Stytch\Shared\Errors;

class InvalidBaseUrlException extends \InvalidArgumentException
{
    public function __construct(string $message = 'custom_base_url must use HTTPS scheme')
    {
        parent::__construct($message);
    }
}
