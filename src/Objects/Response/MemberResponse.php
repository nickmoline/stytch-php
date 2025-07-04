<?php

namespace Stytch\Objects\Response;

use Stytch\Objects\Organization;

class MemberResponse extends Response
{
    public string $member_id;
    public Member $member;
    public Organization $organization;

    public function __construct(
        string $request_id,
        int $status_code,
        string $member_id,
        Member $member,
        Organization $organization,
    ) {
        parent::__construct($request_id, $status_code);
        $this->member_id = $member_id;
        $this->member = $member;
        $this->organization = $organization;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['request_id'],
            $data['status_code'],
            $data['member_id'],
            Member::fromArray($data['member']),
            Organization::fromArray($data['organization']),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'member_id' => $this->member_id,
            'member' => $this->member->toArray(),
            'organization' => $this->organization->toArray(),
        ]);
    }
}
