<?php

namespace Stytch\Tests\B2B;

use PHPUnit\Framework\TestCase;
use Stytch\B2B\IDP;
use Stytch\Shared\Client;

class IDPTest extends TestCase
{
    public function testIntrospectTokenCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/b2b/idp/introspect_token', ['token' => 'token123'])
            ->willReturn(['introspected' => true]);

        $idp = new IDP($mock);
        $result = $idp->introspectToken(['token' => 'token123']);
        $this->assertSame(['introspected' => true], $result);
    }
}
