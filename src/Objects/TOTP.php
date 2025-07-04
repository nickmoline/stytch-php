<?php

namespace Stytch\Objects;

class TOTP
{
    public function __construct(
        public string $totp_id,
        public bool $verified,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            totp_id: $data['totp_id'],
            verified: $data['verified'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'totp_id' => $this->totp_id,
            'verified' => $this->verified,
        ];
    }
}
