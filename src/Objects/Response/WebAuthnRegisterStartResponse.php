<?php

namespace Stytch\Objects\Response;

class WebAuthnRegisterStartResponse extends Response
{
    public function __construct(
        string $request_id,
        int $status_code,
        public string $user_id,
        public string $public_key_credential_creation_options,
        public string $user_id_base64,
    ) {
        parent::__construct($request_id, $status_code);
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            request_id: $data['request_id'],
            status_code: $data['status_code'],
            user_id: $data['user_id'],
            public_key_credential_creation_options: $data['public_key_credential_creation_options'],
            user_id_base64: $data['user_id_base64'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = parent::toArray();
        $data['user_id'] = $this->user_id;
        $data['public_key_credential_creation_options'] = $this->public_key_credential_creation_options;
        $data['user_id_base64'] = $this->user_id_base64;

        return $data;
    }
}
