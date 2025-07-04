<?php

namespace Stytch;

use Stytch\B2B\Client as B2BClient;
use Stytch\B2C\Client as B2CClient;

class Stytch
{
    private B2BClient $b2b;
    private B2CClient $b2c;

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(array $config)
    {
        $this->b2b = new B2BClient($config);
        $this->b2c = new B2CClient($config);
    }

    /**
     * Get the B2B client
     */
    public function b2b(): B2BClient
    {
        return $this->b2b;
    }

    /**
     * Get the B2C client
     */
    public function b2c(): B2CClient
    {
        return $this->b2c;
    }
}
