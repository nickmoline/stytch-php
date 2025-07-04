<?php

namespace Stytch\Objects\Response;

use Stytch\Objects\User;

class TOTPsCreateResponse extends Response
{
    public function __construct(
        string $request_id,
        int $status_code,
        public string $user_id,
        public string $totp_id,
        public string $secret,
        public string $qr_code,
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
            totp_id: $data['totp_id'],
            secret: $data['secret'],
            qr_code: $data['qr_code'],
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
        $data['totp_id'] = $this->totp_id;
        $data['secret'] = $this->secret;
        $data['qr_code'] = $this->qr_code;

        if ($this->user) {
            $data['user'] = $this->user->toArray();
        }

        return $data;
    }
}
