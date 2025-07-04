<?php

namespace Stytch\Objects;

class UsersPhoneNumber
{
    public function __construct(
        public string $phone_id,
        public string $phone_number,
        public bool $verified,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            phone_id: $data['phone_id'],
            phone_number: $data['phone_number'],
            verified: $data['verified'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'phone_id' => $this->phone_id,
            'phone_number' => $this->phone_number,
            'verified' => $this->verified,
        ];
    }
}
