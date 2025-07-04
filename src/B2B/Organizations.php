<?php

namespace Stytch\B2B;

use Stytch\Objects\Response\Organization;
use Stytch\Objects\Response\OrganizationResponse;
use Stytch\Objects\Response\OrganizationsResponse;
use Stytch\Shared\Client;

class Organizations
{
    protected Client $client;
    public Members $members;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->members = new Members($client);
    }

    /**
     * Create an organization.
     *
     * @param array<string, mixed> $data
     * @return OrganizationResponse
     */
    public function create(array $data): OrganizationResponse
    {
        $response = $this->client->post('/v1/b2b/organizations', $data);
        return OrganizationResponse::fromArray($response);
    }

    /**
     * Get an organization by ID or slug.
     *
     * @param string $organizationId
     * @return OrganizationResponse
     */
    public function get(string $organizationId): OrganizationResponse
    {
        $response = $this->client->get("/v1/b2b/organizations/{$organizationId}");
        return OrganizationResponse::fromArray($response);
    }

    /**
     * Update an organization.
     *
     * @param string $organizationId
     * @param array<string, mixed> $data
     * @return OrganizationResponse
     */
    public function update(string $organizationId, array $data): OrganizationResponse
    {
        $response = $this->client->put("/v1/b2b/organizations/{$organizationId}", $data);
        return OrganizationResponse::fromArray($response);
    }

    /**
     * Delete an organization.
     *
     * @param string $organizationId
     * @return array<string, mixed>
     */
    public function delete(string $organizationId): array
    {
        return $this->client->delete("/v1/b2b/organizations/{$organizationId}");
    }

    /**
     * Search organizations.
     *
     * @param array<string, mixed> $data
     * @return OrganizationsResponse
     */
    public function search(array $data): OrganizationsResponse
    {
        $response = $this->client->post('/v1/b2b/organizations/search', $data);
        return OrganizationsResponse::fromArray($response);
    }

    /**
     * Get organization metrics
     *
     * @param string $organizationId
     * @return array<string, mixed>
     */
    public function metrics(string $organizationId): array
    {
        return $this->client->get("/v1/b2b/organizations/{$organizationId}/metrics");
    }

    /**
     * Get connected apps for an organization
     *
     * @param string $organizationId
     * @return array<string, mixed>
     */
    public function connectedApps(string $organizationId): array
    {
        return $this->client->get("/v1/b2b/organizations/{$organizationId}/connected_apps");
    }

    /**
     * Get a specific connected app for an organization
     *
     * @param string $organizationId
     * @param string $connectedAppId
     * @return array<string, mixed>
     */
    public function getConnectedApp(string $organizationId, string $connectedAppId): array
    {
        return $this->client->get("/v1/b2b/organizations/{$organizationId}/connected_apps/{$connectedAppId}");
    }
}
