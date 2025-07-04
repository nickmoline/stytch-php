<?php

namespace Stytch\B2C;

use Stytch\Shared\Client;

class PasswordsEmail
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
    public function resetStart(array $data): array
    {
        return $this->client->post('/v1/passwords/email/reset_start', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function reset(array $data): array
    {
        return $this->client->post('/v1/passwords/email/reset', $data);
    }
}
