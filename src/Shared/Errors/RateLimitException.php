<?php

namespace Stytch\Shared\Errors;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RateLimitException extends StytchRequestException
{
    /**
     * @param array<string, mixed> $errorData
     */
    public function __construct(
        string $message = 'Rate limit exceeded',
        ?RequestInterface $request = null,
        ?ResponseInterface $response = null,
        ?\Throwable $previous = null,
        array $errorData = [],
    ) {
        parent::__construct($message, $request, $response, $previous, $errorData);
    }
}
