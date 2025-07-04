<?php

namespace Stytch\B2C;

use Stytch\Shared\Client;

class Attribute
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $user_id
     * @param string $attribute_name
     * @return array<string, mixed>
     */
    public function get(string $user_id, string $attribute_name): array
    {
        return $this->client->get("/v1/users/{$user_id}/attributes/{$attribute_name}");
    }

    /**
     * @param string $user_id
     * @param string $attribute_name
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function put(string $user_id, string $attribute_name, array $data): array
    {
        return $this->client->put("/v1/users/{$user_id}/attributes/{$attribute_name}", $data);
    }

    /**
     * @param string $user_id
     * @param string $attribute_name
     * @return array<string, mixed>
     */
    public function delete(string $user_id, string $attribute_name): array
    {
        return $this->client->delete("/v1/users/{$user_id}/attributes/{$attribute_name}");
    }
}
