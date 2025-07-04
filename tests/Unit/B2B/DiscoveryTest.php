<?php

namespace Stytch\Tests\B2B;

use PHPUnit\Framework\TestCase;
use Stytch\B2B\Discovery;
use Stytch\B2B\DiscoveryOrganizations;
use Stytch\Shared\Client;

class DiscoveryTest extends TestCase
{
    public function testOrganizationsCreateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/b2b/discovery/organizations/create', ['email_address' => 'test@example.com'])
            ->willReturn(['created' => true]);

        $organizations = new DiscoveryOrganizations($mock);
        $result = $organizations->create(['email_address' => 'test@example.com']);
        $this->assertSame(['created' => true], $result);
    }

    public function testOrganizationsListCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/b2b/discovery/organizations/list', ['email_address' => 'test@example.com'])
            ->willReturn(['organizations' => []]);

        $organizations = new DiscoveryOrganizations($mock);
        $result = $organizations->list(['email_address' => 'test@example.com']);
        $this->assertSame(['organizations' => []], $result);
    }
}
