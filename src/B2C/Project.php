<?php

namespace Stytch\B2C;

use Stytch\Shared\Client;

class Project
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return array<string, mixed>
     */
    public function get(): array
    {
        return $this->client->get('/v1/project');
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function update(array $data): array
    {
        return $this->client->put('/v1/project', $data);
    }
}
