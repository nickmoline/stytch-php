<?php

namespace Stytch\Tests\B2B;

use PHPUnit\Framework\TestCase;
use Stytch\B2B\SSO;
use Stytch\Shared\Client;

class SSOTest extends TestCase
{
    public function testAuthenticateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/b2b/sso/authenticate', ['organization_id' => 'org123', 'sso_token' => 'token123'])
            ->willReturn(['authenticated' => true]);

        $sso = new SSO($mock);
        $result = $sso->authenticate(['organization_id' => 'org123', 'sso_token' => 'token123']);
        $this->assertSame(['authenticated' => true], $result);
    }

    public function testGetConnectionsCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('get')
            ->with('/v1/b2b/sso/connections', ['organization_id' => 'org123'])
            ->willReturn(['connections' => []]);

        $sso = new SSO($mock);
        $result = $sso->getConnections(['organization_id' => 'org123']);
        $this->assertSame(['connections' => []], $result);
    }

    public function testDeleteConnectionCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('delete')
            ->with('/v1/b2b/sso/connections', ['organization_id' => 'org123', 'connection_id' => 'conn123'])
            ->willReturn(['deleted' => true]);

        $sso = new SSO($mock);
        $result = $sso->deleteConnection(['organization_id' => 'org123', 'connection_id' => 'conn123']);
        $this->assertSame(['deleted' => true], $result);
    }
}
