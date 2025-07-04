<?php

namespace Stytch\Objects;

class UsersName
{
    public function __construct(
        public ?string $first_name = null,
        public ?string $middle_name = null,
        public ?string $last_name = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            first_name: $data['first_name'] ?? null,
            middle_name: $data['middle_name'] ?? null,
            last_name: $data['last_name'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [];

        if ($this->first_name) {
            $data['first_name'] = $this->first_name;
        }
        if ($this->middle_name) {
            $data['middle_name'] = $this->middle_name;
        }
        if ($this->last_name) {
            $data['last_name'] = $this->last_name;
        }

        return $data;
    }
}
