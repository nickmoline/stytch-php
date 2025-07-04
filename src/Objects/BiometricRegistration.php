<?php

namespace Stytch\Objects;

class BiometricRegistration
{
    public function __construct(
        public string $biometric_registration_id,
        public bool $verified,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            biometric_registration_id: $data['biometric_registration_id'],
            verified: $data['verified'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'biometric_registration_id' => $this->biometric_registration_id,
            'verified' => $this->verified,
        ];
    }
}
