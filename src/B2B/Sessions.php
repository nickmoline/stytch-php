<?php

namespace Stytch\B2B;

use Stytch\Objects\Response\SessionResponse;
use Stytch\Shared\Client;

class Sessions
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Authenticate a session.
     *
     * @param array<string, mixed> $data
     * @return SessionResponse
     */
    public function authenticate(array $data): SessionResponse
    {
        $response = $this->client->post('/v1/b2b/sessions/authenticate', $data);
        return SessionResponse::fromArray($response);
    }

    /**
     * Get a session.
     *
     * @param string $sessionId
     * @return array<string, mixed>
     */
    public function get(string $sessionId): array
    {
        return $this->client->get("/v1/b2b/sessions/{$sessionId}");
    }

    /**
     * Revoke a session.
     *
     * @param string $sessionId
     * @return array<string, mixed>
     */
    public function revoke(string $sessionId): array
    {
        return $this->client->delete("/v1/b2b/sessions/{$sessionId}");
    }

    /**
     * Exchange a session
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function exchange(array $data): array
    {
        return $this->client->post('/v1/b2b/sessions/exchange', $data);
    }

    /**
     * Get JWKS for session verification
     *
     * @return array<string, mixed>
     */
    public function getJWKS(): array
    {
        return $this->client->get('/v1/b2b/sessions/jwks/' . $this->client->getProjectId());
    }
}
