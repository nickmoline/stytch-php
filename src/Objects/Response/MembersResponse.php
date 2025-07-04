<?php

namespace Stytch\Objects\Response;

use Stytch\Objects\Organization;

class MembersResponse extends Response
{
    /** @var array<Member> */
    public array $members;
    /** @var array<string, mixed> */
    public array $results_metadata;
    /** @var array<string, Organization> */
    public array $organizations;

    /**
     * @param array<Member> $members
     * @param array<string, mixed> $results_metadata
     * @param array<string, Organization> $organizations
     */
    public function __construct(
        string $request_id,
        int $status_code,
        array $members,
        array $results_metadata,
        array $organizations,
    ) {
        parent::__construct($request_id, $status_code);
        $this->members = $members;
        $this->results_metadata = $results_metadata;
        $this->organizations = $organizations;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $members = array_map(
            fn($member) => Member::fromArray($member),
            $data['members'],
        );

        $organizations = [];
        foreach ($data['organizations'] as $orgId => $orgData) {
            $organizations[$orgId] = Organization::fromArray($orgData);
        }

        return new self(
            $data['request_id'],
            $data['status_code'],
            $members,
            $data['results_metadata'],
            $organizations,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $organizationsArray = [];
        foreach ($this->organizations as $orgId => $org) {
            $organizationsArray[$orgId] = $org->toArray();
        }

        return array_merge(parent::toArray(), [
            'members' => array_map(fn($member) => $member->toArray(), $this->members),
            'results_metadata' => $this->results_metadata,
            'organizations' => $organizationsArray,
        ]);
    }
}
