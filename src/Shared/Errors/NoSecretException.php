<?php

namespace Stytch\Shared\Errors;

class NoSecretException extends \InvalidArgumentException
{
    public function __construct(string $message = 'Missing "secret" in config')
    {
        parent::__construct($message);
    }
}
