<?php

namespace Stytch\B2B;

use Stytch\Shared\Client;

class OTPs
{
    protected Client $client;
    public Sms $sms;
    public Email $email;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->sms = new Sms($client);
        $this->email = new Email($client);
    }
}
