<?php

namespace Stytch\Objects\Response;

class M2MAuthenticateTokenResponse extends Response
{
    public string $client_id;
    /** @var array<string> */
    public array $scopes;
    /** @var array<string, mixed> */
    public array $custom_claims;

    /**
     * @param array<string> $scopes
     * @param array<string, mixed> $custom_claims
     */
    public function __construct(
        string $request_id,
        int $status_code,
        string $client_id,
        array $scopes,
        array $custom_claims,
    ) {
        parent::__construct($request_id, $status_code);
        $this->client_id = $client_id;
        $this->scopes = $scopes;
        $this->custom_claims = $custom_claims;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['request_id'],
            $data['status_code'],
            $data['client_id'],
            $data['scopes'],
            $data['custom_claims'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'client_id' => $this->client_id,
            'scopes' => $this->scopes,
            'custom_claims' => $this->custom_claims,
        ]);
    }
}
