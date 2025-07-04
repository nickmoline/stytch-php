<?php

namespace Stytch\Objects\Response;

use Stytch\Objects\Organization;

class OrganizationResponse extends Response
{
    public function __construct(
        string $request_id,
        int $status_code,
        public Organization $organization,
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
            organization: Organization::fromArray($data['organization']),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'organization' => $this->organization->toArray(),
        ]);
    }
}
