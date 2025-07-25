<?php

namespace Stytch\B2C;

use Stytch\Shared\Client;

class CryptoWallets
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
    public function authenticateStart(array $data): array
    {
        return $this->client->post('/v1/crypto_wallets/authenticate/start', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function authenticate(array $data): array
    {
        return $this->client->post('/v1/crypto_wallets/authenticate', $data);
    }
}
