<?php

namespace Stytch\Objects\Response;

use Stytch\Objects\Session;
use Stytch\Objects\Member;
use Stytch\Objects\Organization;

class PasswordResponse extends Response
{
    public function __construct(
        string $request_id,
        int $status_code,
        public string $member_id,
        public string $organization_id,
        public Member $member,
        public Organization $organization,
        public string $session_token,
        public string $session_jwt,
        public string $intermediate_session_token,
        public bool $member_authenticated,
        public ?Session $member_session = null,
    ) {
        parent::__construct($request_id, $status_code);
    }

    public static function fromArray(array $data): self
    {
        return new self(
            request_id: $data['request_id'],
            status_code: $data['status_code'],
            member_id: $data['member_id'],
            organization_id: $data['organization_id'],
            member: Member::fromArray($data['member']),
            organization: Organization::fromArray($data['organization']),
            session_token: $data['session_token'],
            session_jwt: $data['session_jwt'],
            intermediate_session_token: $data['intermediate_session_token'],
            member_authenticated: $data['member_authenticated'],
            member_session: isset($data['member_session']) ? Session::fromArray($data['member_session']) : null,
        );
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'member_id' => $this->member_id,
            'organization_id' => $this->organization_id,
            'member' => $this->member->toArray(),
            'organization' => $this->organization->toArray(),
            'session_token' => $this->session_token,
            'session_jwt' => $this->session_jwt,
            'intermediate_session_token' => $this->intermediate_session_token,
            'member_authenticated' => $this->member_authenticated,
            'member_session' => $this->member_session?->toArray(),
        ]);
    }
}
