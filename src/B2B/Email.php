<?php

namespace Stytch\B2B;

use Stytch\Shared\Client;

class Email
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send an email OTP to a member's email address.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function send(array $data): array
    {
        return $this->client->post('/v1/b2b/otps/email/send', $data);
    }

    /**
     * Authenticate an email OTP code.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function authenticate(array $data): array
    {
        return $this->client->post('/v1/b2b/otps/email/authenticate', $data);
    }
}
