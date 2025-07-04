<?php

namespace Stytch\B2C;

use Stytch\Shared\Client;

class OTPsSms
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function send(array $data): array
    {
        return $this->client->post('/v1/otps/sms/send', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function loginOrCreate(array $data): array
    {
        return $this->client->post('/v1/otps/sms/login_or_create', $data);
    }
}
