<?php

namespace Stytch\B2C;

use Stytch\Shared\Client;

class TOTPs
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
    public function create(array $data): array
    {
        return $this->client->post('/v1/totps', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function authenticate(array $data): array
    {
        return $this->client->post('/v1/totps/authenticate', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function recover(array $data): array
    {
        return $this->client->post('/v1/totps/recover', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function recoveryCodes(array $data): array
    {
        return $this->client->post('/v1/totps/recovery_codes', $data);
    }
}
