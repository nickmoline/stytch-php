<?php

namespace Stytch\B2B;

use Stytch\Objects\Response\Member;
use Stytch\Objects\Response\MemberResponse;
use Stytch\Objects\Response\MembersResponse;
use Stytch\Objects\Response\ConnectedAppsResponse;
use Stytch\Objects\Response\OIDCProvidersResponse;
use Stytch\Shared\Client;

class Members
{
    protected Client $client;
    public OAuthProviders $oauthProviders;
    public ConnectedApps $connectedApps;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->oauthProviders = new OAuthProviders($client);
        $this->connectedApps = new ConnectedApps($client);
    }

    /**
     * Create a member in an organization.
     *
     * @param array<string, mixed> $data
     * @return MemberResponse
     */
    public function create(array $data): MemberResponse
    {
        $response = $this->client->post('/v1/b2b/organizations/members', $data);
        return MemberResponse::fromArray($response);
    }

    /**
     * Get a member by ID or email.
     *
     * @param array<string, mixed> $data
     * @return MemberResponse
     */
    public function get(array $data): MemberResponse
    {
        $response = $this->client->get('/v1/b2b/organizations/members', $data);
        return MemberResponse::fromArray($response);
    }

    /**
     * Update a member.
     *
     * @param array<string, mixed> $data
     * @return MemberResponse
     */
    public function update(array $data): MemberResponse
    {
        $response = $this->client->put('/v1/b2b/organizations/members', $data);
        return MemberResponse::fromArray($response);
    }

    /**
     * Delete a member.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function delete(array $data): array
    {
        return $this->client->delete('/v1/b2b/organizations/members', $data);
    }

    /**
     * Search members.
     *
     * @param array<string, mixed> $data
     * @return MembersResponse
     */
    public function search(array $data): MembersResponse
    {
        $response = $this->client->post('/v1/b2b/organizations/members/search', $data);
        return MembersResponse::fromArray($response);
    }

    /**
     * Reactivate a member.
     *
     * @param array<string, mixed> $data
     * @return MemberResponse
     */
    public function reactivate(array $data): MemberResponse
    {
        $response = $this->client->post('/v1/b2b/organizations/members/reactivate', $data);
        return MemberResponse::fromArray($response);
    }

    /**
     * Delete a member's MFA phone number.
     *
     * @param array<string, mixed> $data
     * @return MemberResponse
     */
    public function deleteMFAPhoneNumber(array $data): MemberResponse
    {
        $response = $this->client->delete('/v1/b2b/organizations/members/mfa_phone_number', $data);
        return MemberResponse::fromArray($response);
    }

    /**
     * Delete a member's TOTP.
     *
     * @param array<string, mixed> $data
     * @return MemberResponse
     */
    public function deleteTOTP(array $data): MemberResponse
    {
        $response = $this->client->delete('/v1/b2b/organizations/members/totp', $data);
        return MemberResponse::fromArray($response);
    }

    /**
     * Delete a member's password.
     *
     * @param array<string, mixed> $data
     * @return MemberResponse
     */
    public function deletePassword(array $data): MemberResponse
    {
        $response = $this->client->delete('/v1/b2b/organizations/members/passwords', $data);
        return MemberResponse::fromArray($response);
    }

    /**
     * Dangerously get a member (including deleted).
     *
     * @param array<string, mixed> $data
     * @return MemberResponse
     */
    public function dangerouslyGet(array $data): MemberResponse
    {
        $response = $this->client->get('/v1/b2b/organizations/members/dangerously_get', $data);
        return MemberResponse::fromArray($response);
    }

    /**
     * Get OIDC providers for a member.
     *
     * @param array<string, mixed> $data
     * @return OIDCProvidersResponse
     */
    public function oidcProviders(array $data): OIDCProvidersResponse
    {
        $response = $this->client->get('/v1/b2b/organizations/members/oidc_providers', $data);
        return OIDCProvidersResponse::fromArray($response);
    }

    /**
     * Unlink a retired email from a member.
     *
     * @param array<string, mixed> $data
     * @return MemberResponse
     */
    public function unlinkRetiredEmail(array $data): MemberResponse
    {
        $response = $this->client->post('/v1/b2b/organizations/members/unlink_retired_email', $data);
        return MemberResponse::fromArray($response);
    }

    /**
     * Get connected apps for a member.
     *
     * @param array<string, mixed> $data
     * @return ConnectedAppsResponse
     */
    public function getConnectedApps(array $data): ConnectedAppsResponse
    {
        $response = $this->client->get('/v1/b2b/organizations/members/connected_apps', $data);
        return ConnectedAppsResponse::fromArray($response);
    }
}
