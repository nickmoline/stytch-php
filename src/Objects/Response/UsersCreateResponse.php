<?php

namespace Stytch\Objects\Response;

use Stytch\Objects\User;

class UsersCreateResponse extends Response
{
    public function __construct(
        string $request_id,
        int $status_code,
        public string $user_id,
        public ?User $user = null,
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
            user: isset($data['user']) ? User::fromArray($data['user']) : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = parent::toArray();
        $data['user_id'] = $this->user_id;

        if ($this->user) {
            $data['user'] = $this->user->toArray();
        }

        return $data;
    }
}
