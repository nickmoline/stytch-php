<?php

namespace Stytch\Shared;

class MethodOptions
{
    public ?string $session_token = null;
    public ?string $session_jwt = null;

    /**
     * @param array<string, mixed> $options
     */
    public function __construct(array $options = [])
    {
        $this->session_token = $options['session_token'] ?? null;
        $this->session_jwt = $options['session_jwt'] ?? null;
    }

    /**
     * @param array<string, string> $headers
     */
    public static function addAuthorizationHeaders(array &$headers, self $authorization): void
    {
        if ($authorization->session_token) {
            $headers['X-Stytch-Member-Session'] = $authorization->session_token;
        }
        if ($authorization->session_jwt) {
            $headers['X-Stytch-Member-SessionJWT'] = $authorization->session_jwt;
        }
    }
}
