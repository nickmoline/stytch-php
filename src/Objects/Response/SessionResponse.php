<?php

namespace Stytch\Objects\Response;

use Stytch\Objects\Session;
use Stytch\Objects\Member;
use Stytch\Objects\Organization;
use Stytch\Objects\AuthorizationVerdict;

class SessionResponse extends Response
{
    public function __construct(
        string $request_id,
        int $status_code,
        public string $session_token,
        public string $session_jwt,
        public Member $member,
        public Organization $organization,
        public ?Session $member_session = null,
        public ?AuthorizationVerdict $verdict = null,
    ) {
        parent::__construct($request_id, $status_code);
    }

    public static function fromArray(array $data): self
    {
        return new self(
            request_id: $data['request_id'],
            status_code: $data['status_code'],
            session_token: $data['session_token'],
            session_jwt: $data['session_jwt'],
            member: Member::fromArray($data['member']),
            organization: Organization::fromArray($data['organization']),
            member_session: isset($data['member_session']) ? Session::fromArray($data['member_session']) : null,
            verdict: isset($data['verdict']) ? AuthorizationVerdict::fromArray($data['verdict']) : null,
        );
    }

    public function toArray(): array
    {
        $data = parent::toArray();
        $data['session_token'] = $this->session_token;
        $data['session_jwt'] = $this->session_jwt;
        $data['member'] = $this->member->toArray();
        $data['organization'] = $this->organization->toArray();
        $data['member_session'] = $this->member_session?->toArray();

        if ($this->verdict) {
            $data['verdict'] = $this->verdict->toArray();
        }

        return $data;
    }
}
