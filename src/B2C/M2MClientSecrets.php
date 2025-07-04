<?php

namespace Stytch\B2C;

use Stytch\Objects\Response\M2MClientResponse;
use Stytch\Shared\Client;

class M2MClientSecrets
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Start the rotation of an M2M client secret.
     *
     * @param string $clientId
     * @return M2MClientResponse
     */
    public function rotateStart(string $clientId): M2MClientResponse
    {
        $response = $this->client->post("/v1/m2m/clients/{$clientId}/secrets/rotate/start", []);
        return M2MClientResponse::fromArray($response);
    }

    /**
     * Complete the rotation of an M2M client secret.
     *
     * @param string $clientId
     * @return M2MClientResponse
     */
    public function rotate(string $clientId): M2MClientResponse
    {
        $response = $this->client->post("/v1/m2m/clients/{$clientId}/secrets/rotate", []);
        return M2MClientResponse::fromArray($response);
    }

    /**
     * Cancel the rotation of an M2M client secret.
     *
     * @param string $clientId
     * @return M2MClientResponse
     */
    public function rotateCancel(string $clientId): M2MClientResponse
    {
        $response = $this->client->post("/v1/m2m/clients/{$clientId}/secrets/rotate/cancel", []);
        return M2MClientResponse::fromArray($response);
    }
}
