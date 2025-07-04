<?php

namespace Stytch\Objects\Response;

use Stytch\Objects\Organization;

class OrganizationsResponse extends Response
{
    /**
     * @param array<Organization> $organizations
     * @param array<string, mixed> $results_metadata
     */
    public function __construct(
        string $request_id,
        int $status_code,
        /** @var array<Organization> */
        public array $organizations,
        /** @var array<string, mixed> */
        public array $results_metadata,
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
            organizations: array_map(fn($org) => Organization::fromArray($org), $data['organizations'] ?? []),
            results_metadata: $data['results_metadata'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'organizations' => array_map(fn($org) => $org->toArray(), $this->organizations),
            'results_metadata' => $this->results_metadata,
        ]);
    }
}
