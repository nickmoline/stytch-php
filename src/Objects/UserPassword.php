<?php

namespace Stytch\Objects;

class UserPassword
{
    public function __construct(
        public string $password_id,
        public bool $requires_reset,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            password_id: $data['password_id'],
            requires_reset: $data['requires_reset'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'password_id' => $this->password_id,
            'requires_reset' => $this->requires_reset,
        ];
    }
}
