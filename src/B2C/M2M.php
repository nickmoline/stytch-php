<?php

namespace Stytch\B2C;

use Stytch\Objects\Response\M2MTokenResponse;
use Stytch\Objects\Response\M2MAuthenticateTokenResponse;
use Stytch\Shared\Client;

class M2M
{
    protected Client $client;
    public M2MClients $clients;
    public M2MClientSecrets $secrets;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->clients = new M2MClients($client);
        $this->secrets = new M2MClientSecrets($client);
    }

    /**
     * Authenticate an M2M client.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function authenticate(array $data): array
    {
        return $this->client->post('/v1/m2m/authenticate', $data);
    }

    /**
     * Authenticate an M2M client with claims.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function authenticateWithClaims(array $data): array
    {
        return $this->client->post('/v1/m2m/authenticate_with_claims', $data);
    }

    /**
     * Get an access token for an M2M client.
     *
     * @param array<string, mixed> $data
     * @return M2MTokenResponse
     */
    public function token(array $data): M2MTokenResponse
    {
        $response = $this->client->post('/v1/m2m/token', $data);
        return M2MTokenResponse::fromArray($response);
    }

    /**
     * Authenticate an M2M access token.
     *
     * @param array<string, mixed> $data
     * @return M2MAuthenticateTokenResponse
     */
    public function authenticateToken(array $data): M2MAuthenticateTokenResponse
    {
        $response = $this->client->post('/v1/m2m/authenticate_token', $data);
        return M2MAuthenticateTokenResponse::fromArray($response);
    }
}
