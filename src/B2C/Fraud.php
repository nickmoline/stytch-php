<?php

namespace Stytch\B2C;

use Stytch\Shared\Client;

class Fraud
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
    public function signal(array $data): array
    {
        return $this->client->post('/v1/fraud/signal', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function report(array $data): array
    {
        return $this->client->post('/v1/fraud/report', $data);
    }
}
