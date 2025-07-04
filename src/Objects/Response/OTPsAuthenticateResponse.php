<?php

namespace Stytch\Objects\Response;

use Stytch\Objects\User;

class OTPsAuthenticateResponse extends Response
{
    public function __construct(
        string $request_id,
        int $status_code,
        public string $user_id,
        public string $session_token,
        public string $session_jwt,
        public ?User $user = null,
    ) {
        parent::__construct($request_id, $status_code);
    }

    public static function fromArray(array $data): self
    {
        return new self(
            request_id: $data['request_id'],
            status_code: $data['status_code'],
            user_id: $data['user_id'],
            session_token: $data['session_token'],
            session_jwt: $data['session_jwt'],
            user: isset($data['user']) ? User::fromArray($data['user']) : null,
        );
    }

    public function toArray(): array
    {
        $data = parent::toArray();
        $data['user_id'] = $this->user_id;
        $data['session_token'] = $this->session_token;
        $data['session_jwt'] = $this->session_jwt;

        if ($this->user) {
            $data['user'] = $this->user->toArray();
        }

        return $data;
    }
}
