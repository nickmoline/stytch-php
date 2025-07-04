<?php

namespace Stytch\Tests\B2B;

use PHPUnit\Framework\TestCase;
use Stytch\B2B\Impersonation;
use Stytch\Shared\Client;

class ImpersonationTest extends TestCase
{
    public function testAuthenticateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/b2b/impersonation/authenticate', ['impersonation_token' => 'token123'])
            ->willReturn(['authenticated' => true]);

        $impersonation = new Impersonation($mock);
        $result = $impersonation->authenticate(['impersonation_token' => 'token123']);
        $this->assertSame(['authenticated' => true], $result);
    }
}
