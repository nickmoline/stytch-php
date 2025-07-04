<?php

namespace Stytch\B2C;

use Stytch\Shared\Client;

class OTPs
{
    protected Client $client;
    public OTPsSms $sms;
    public OTPsWhatsapp $whatsapp;
    public OTPsEmail $email;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->sms = new OTPsSms($client);
        $this->whatsapp = new OTPsWhatsapp($client);
        $this->email = new OTPsEmail($client);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function authenticate(array $data): array
    {
        return $this->client->post('/v1/otps/authenticate', $data);
    }
}
