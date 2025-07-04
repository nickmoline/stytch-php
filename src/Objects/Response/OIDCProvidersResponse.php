<?php

namespace Stytch\Objects\Response;

class OIDCProvidersResponse extends Response
{
    /** @var array<string, mixed> */
    public array $registrations;

    /**
     * @param array<string, mixed> $registrations
     */
    public function __construct(
        string $request_id,
        int $status_code,
        array $registrations,
    ) {
        parent::__construct($request_id, $status_code);
        $this->registrations = $registrations;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            request_id: $data['request_id'],
            status_code: $data['status_code'],
            registrations: $data['registrations'] ?? [],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'registrations' => $this->registrations,
        ]);
    }
}
