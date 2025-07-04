<?php

namespace Stytch\Objects\Response;

class M2MClient
{
    public string $client_id;
    public string $client_name;
    public string $client_description;
    public string $status;
    /** @var array<string> */
    public array $scopes;
    public string $client_secret_last_four;
    /** @var array<string, mixed>|null */
    public ?array $trusted_metadata;
    public ?string $next_client_secret_last_four;
    public ?string $client_secret;
    public ?string $next_client_secret;

    /**
     * @param array<string> $scopes
     * @param array<string, mixed>|null $trusted_metadata
     */
    public function __construct(
        string $client_id,
        string $client_name,
        string $client_description,
        string $status,
        array $scopes,
        string $client_secret_last_four,
        ?array $trusted_metadata = null,
        ?string $next_client_secret_last_four = null,
        ?string $client_secret = null,
        ?string $next_client_secret = null,
    ) {
        $this->client_id = $client_id;
        $this->client_name = $client_name;
        $this->client_description = $client_description;
        $this->status = $status;
        $this->scopes = $scopes;
        $this->client_secret_last_four = $client_secret_last_four;
        $this->trusted_metadata = $trusted_metadata;
        $this->next_client_secret_last_four = $next_client_secret_last_four;
        $this->client_secret = $client_secret;
        $this->next_client_secret = $next_client_secret;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['client_id'],
            $data['client_name'],
            $data['client_description'],
            $data['status'],
            $data['scopes'],
            $data['client_secret_last_four'],
            $data['trusted_metadata'] ?? null,
            $data['next_client_secret_last_four'] ?? null,
            $data['client_secret'] ?? null,
            $data['next_client_secret'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $array = [
            'client_id' => $this->client_id,
            'client_name' => $this->client_name,
            'client_description' => $this->client_description,
            'status' => $this->status,
            'scopes' => $this->scopes,
            'client_secret_last_four' => $this->client_secret_last_four,
        ];

        if ($this->trusted_metadata !== null) {
            $array['trusted_metadata'] = $this->trusted_metadata;
        }
        if ($this->next_client_secret_last_four !== null) {
            $array['next_client_secret_last_four'] = $this->next_client_secret_last_four;
        }
        if ($this->client_secret !== null) {
            $array['client_secret'] = $this->client_secret;
        }
        if ($this->next_client_secret !== null) {
            $array['next_client_secret'] = $this->next_client_secret;
        }

        return $array;
    }
}
