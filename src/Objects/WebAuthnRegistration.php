<?php

namespace Stytch\Objects;

class WebAuthnRegistration
{
    public function __construct(
        public string $webauthn_registration_id,
        public string $domain,
        public string $user_agent,
        public bool $verified,
        public string $authenticator_type,
        public string $name,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            webauthn_registration_id: $data['webauthn_registration_id'],
            domain: $data['domain'],
            user_agent: $data['user_agent'],
            verified: $data['verified'],
            authenticator_type: $data['authenticator_type'],
            name: $data['name'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'webauthn_registration_id' => $this->webauthn_registration_id,
            'domain' => $this->domain,
            'user_agent' => $this->user_agent,
            'verified' => $this->verified,
            'authenticator_type' => $this->authenticator_type,
            'name' => $this->name,
        ];
    }
}
