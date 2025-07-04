<?php

namespace Stytch\Objects;

class UsersEmail
{
    public function __construct(
        public string $email_id,
        public string $email,
        public bool $verified,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            email_id: $data['email_id'],
            email: $data['email'],
            verified: $data['verified'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'email_id' => $this->email_id,
            'email' => $this->email,
            'verified' => $this->verified,
        ];
    }
}
