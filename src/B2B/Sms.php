<?php

namespace Stytch\B2B;

use Stytch\Shared\Client;

class Sms
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send an SMS OTP to a member's phone number.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function send(array $data): array
    {
        return $this->client->post('/v1/b2b/otps/sms/send', $data);
    }

    /**
     * Authenticate an SMS OTP code.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function authenticate(array $data): array
    {
        return $this->client->post('/v1/b2b/otps/sms/authenticate', $data);
    }
}
