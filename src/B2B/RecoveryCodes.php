<?php

namespace Stytch\B2B;

use Stytch\Shared\Client;

class RecoveryCodes
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get recovery codes for a member.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function get(array $data): array
    {
        return $this->client->get('/v1/b2b/recovery_codes', $data);
    }

    /**
     * Recover using a recovery code to complete MFA flow.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function recover(array $data): array
    {
        return $this->client->post('/v1/b2b/recovery_codes/recover', $data);
    }

    /**
     * Rotate recovery codes for a member.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function rotate(array $data): array
    {
        return $this->client->post('/v1/b2b/recovery_codes/rotate', $data);
    }
}
