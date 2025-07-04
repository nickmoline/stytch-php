<?php

namespace Stytch\Tests\B2B;

use PHPUnit\Framework\TestCase;
use Stytch\B2B\TOTPs;
use Stytch\Shared\Client;

class TOTPsTest extends TestCase
{
    public function testCreateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/b2b/totps/create', ['organization_id' => 'org123', 'member_id' => 'mem123'])
            ->willReturn(['created' => true]);

        $totps = new TOTPs($mock);
        $result = $totps->create(['organization_id' => 'org123', 'member_id' => 'mem123']);
        $this->assertSame(['created' => true], $result);
    }

    public function testAuthenticateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/b2b/totps/authenticate', ['organization_id' => 'org123', 'member_id' => 'mem123', 'code' => '123456'])
            ->willReturn(['authenticated' => true]);

        $totps = new TOTPs($mock);
        $result = $totps->authenticate(['organization_id' => 'org123', 'member_id' => 'mem123', 'code' => '123456']);
        $this->assertSame(['authenticated' => true], $result);
    }

    public function testMigrateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/b2b/totps/migrate', ['organization_id' => 'org123', 'member_id' => 'mem123', 'totp_secret' => 'secret123'])
            ->willReturn(['migrated' => true]);

        $totps = new TOTPs($mock);
        $result = $totps->migrate(['organization_id' => 'org123', 'member_id' => 'mem123', 'totp_secret' => 'secret123']);
        $this->assertSame(['migrated' => true], $result);
    }
}
