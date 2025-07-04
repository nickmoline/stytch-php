<?php

namespace Stytch\B2B;

use Stytch\Shared\Client;

class OAuthProviders
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get Google OAuth provider information for a member.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function google(array $data): array
    {
        return $this->client->get('/v1/b2b/organizations/members/oauth_providers/google', $data);
    }

    /**
     * Get Microsoft OAuth provider information for a member.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function microsoft(array $data): array
    {
        return $this->client->get('/v1/b2b/organizations/members/oauth_providers/microsoft', $data);
    }

    /**
     * Get GitHub OAuth provider information for a member.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function github(array $data): array
    {
        return $this->client->get('/v1/b2b/organizations/members/oauth_providers/github', $data);
    }

    /**
     * Get HubSpot OAuth provider information for a member.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function hubspot(array $data): array
    {
        return $this->client->get('/v1/b2b/organizations/members/oauth_providers/hubspot', $data);
    }

    /**
     * Get Slack OAuth provider information for a member.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function slack(array $data): array
    {
        return $this->client->get('/v1/b2b/organizations/members/oauth_providers/slack', $data);
    }
}
