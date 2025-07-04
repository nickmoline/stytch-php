<?php

namespace Stytch\Shared\Errors;

class RequestError extends \RuntimeException
{
    /** @var array<string, mixed> */
    public array $request;

    /**
     * @param array<string, mixed> $request
     */
    public function __construct(string $message, array $request)
    {
        parent::__construct($message);
        $this->request = $request;
    }
}
