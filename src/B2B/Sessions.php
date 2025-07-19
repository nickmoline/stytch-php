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
     * @param string $organization_id
     * @param string $member_id
     * @return array<string, mixed>
     */
    public function get(?string $organization_id, ?string $member_id): array
    {
        $params = [];
        if ($organization_id) {
            $params['organization_id'] = $organization_id;
        }
        if ($member_id) {
            $params['member_id'] = $member_id;
        }
        return $this->client->get("/v1/b2b/sessions", $params);
    }

    /**
     * Revoke a session.
     *
     * @param array contain exactly 1 of session_id, member_id, session_token, or session_jwt
     * @return array<string, mixed>
     */
    public function revoke(array $data): array
    {
        return $this->client->post("/v1/b2b/sessions/revoke", $data);
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
