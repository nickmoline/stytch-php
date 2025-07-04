<?php

namespace Stytch\Objects\Response;

class PasswordStrengthResponse extends Response
{
    public function __construct(
        string $request_id,
        int $status_code,
        public bool $valid_password,
        public int $score,
        public bool $breached_password,
        public string $strength_policy,
        public bool $breach_detection_on_create,
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
            valid_password: $data['valid_password'],
            score: $data['score'],
            breached_password: $data['breached_password'],
            strength_policy: $data['strength_policy'],
            breach_detection_on_create: $data['breach_detection_on_create'] ?? false,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'valid_password' => $this->valid_password,
            'score' => $this->score,
            'breached_password' => $this->breached_password,
            'strength_policy' => $this->strength_policy,
            'breach_detection_on_create' => $this->breach_detection_on_create,
        ]);
    }
}
