<?php

namespace Stytch\Shared\Errors;

class NoProjectIdException extends \InvalidArgumentException
{
    public function __construct(string $message = 'Missing "project_id" in config')
    {
        parent::__construct($message);
    }
}
