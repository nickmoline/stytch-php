<?php

namespace Stytch\B2B;

use Stytch\Objects\Response\MagicLinkResponse;
use Stytch\Shared\Client;

class MagicLinks
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send a magic link for login or signup.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function loginOrSignup(array $data): array
    {
        return $this->client->post('/v1/b2b/magic_links/login_or_signup', $data);
    }

    /**
     * Send a magic link for login only
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function login(array $data): array
    {
        return $this->client->post('/v1/b2b/magic_links/email/login', $data);
    }

    /**
     * Send a magic link for signup only
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function signup(array $data): array
    {
        return $this->client->post('/v1/b2b/magic_links/email/signup', $data);
    }

    /**
     * Authenticate a magic link token.
     *
     * @param array<string, mixed> $data
     * @return MagicLinkResponse
     */
    public function authenticate(array $data): MagicLinkResponse
    {
        $response = $this->client->post('/v1/b2b/magic_links/authenticate', $data);
        return MagicLinkResponse::fromArray($response);
    }
}
