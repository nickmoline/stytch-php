<?php

namespace Stytch\Tests\B2B;

use PHPUnit\Framework\TestCase;
use Stytch\B2B\SCIM;
use Stytch\B2B\Connection;
use Stytch\Shared\Client;

class SCIMTest extends TestCase
{
    public function testConnectionCreateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/b2b/scim/connections', ['organization_id' => 'org123', 'display_name' => 'Test Connection'])
            ->willReturn(['created' => true]);

        $connection = new Connection($mock);
        $result = $connection->create(['organization_id' => 'org123', 'display_name' => 'Test Connection']);
        $this->assertSame(['created' => true], $result);
    }

    public function testConnectionGetCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('get')
            ->with('/v1/b2b/scim/connections', ['organization_id' => 'org123', 'connection_id' => 'conn123'])
            ->willReturn(['connection' => []]);

        $connection = new Connection($mock);
        $result = $connection->get(['organization_id' => 'org123', 'connection_id' => 'conn123']);
        $this->assertSame(['connection' => []], $result);
    }

    public function testConnectionUpdateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('put')
            ->with('/v1/b2b/scim/connections', ['organization_id' => 'org123', 'connection_id' => 'conn123', 'display_name' => 'Updated'])
            ->willReturn(['updated' => true]);

        $connection = new Connection($mock);
        $result = $connection->update(['organization_id' => 'org123', 'connection_id' => 'conn123', 'display_name' => 'Updated']);
        $this->assertSame(['updated' => true], $result);
    }

    public function testConnectionDeleteCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('delete')
            ->with('/v1/b2b/scim/connections', ['organization_id' => 'org123', 'connection_id' => 'conn123'])
            ->willReturn(['deleted' => true]);

        $connection = new Connection($mock);
        $result = $connection->delete(['organization_id' => 'org123', 'connection_id' => 'conn123']);
        $this->assertSame(['deleted' => true], $result);
    }
}
