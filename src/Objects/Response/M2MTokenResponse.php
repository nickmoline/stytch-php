<?php

namespace Stytch\Objects\Response;

class M2MTokenResponse extends Response
{
    public string $access_token;
    public string $token_type;
    public int $expires_in;

    public function __construct(
        string $request_id,
        int $status_code,
        string $access_token,
        string $token_type,
        int $expires_in,
    ) {
        parent::__construct($request_id, $status_code);
        $this->access_token = $access_token;
        $this->token_type = $token_type;
        $this->expires_in = $expires_in;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            request_id: $data['request_id'],
            status_code: $data['status_code'],
            access_token: $data['access_token'],
            token_type: $data['token_type'],
            expires_in: $data['expires_in'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'access_token' => $this->access_token,
            'token_type' => $this->token_type,
            'expires_in' => $this->expires_in,
        ]);
    }
}
