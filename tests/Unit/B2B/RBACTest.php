<?php

namespace Stytch\Tests\B2B;

use PHPUnit\Framework\TestCase;
use Stytch\B2B\RBAC;
use Stytch\Shared\Client;

class RBACTest extends TestCase
{
    public function testPolicyCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('get')
            ->with('/v1/b2b/rbac/policy')
            ->willReturn(['policy' => []]);

        $rbac = new RBAC($mock);
        $result = $rbac->policy();
        $this->assertSame(['policy' => []], $result);
    }
}
