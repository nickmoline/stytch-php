<?php

namespace Stytch\Objects\Response;

abstract class Response
{
    public function __construct(
        public string $request_id,
        public int $status_code,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    abstract public static function fromArray(array $data): self;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'request_id' => $this->request_id,
            'status_code' => $this->status_code,
        ];
    }
}
