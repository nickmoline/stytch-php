<?php

namespace Stytch\Objects\Response;

use Stytch\Objects\User;

class UsersSearchResponse extends Response
{
    /**
     * @param array<User> $users
     */
    public function __construct(
        string $request_id,
        int $status_code,
        /** @var array<User> */
        public array $users,
        public int $total,
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
            users: array_map(fn($user) => User::fromArray($user), $data['users']),
            total: $data['total'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = parent::toArray();
        $data['users'] = array_map(fn($user) => $user->toArray(), $this->users);
        $data['total'] = $this->total;

        return $data;
    }
}
