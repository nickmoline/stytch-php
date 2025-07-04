<?php

namespace Stytch\Tests\B2B;

use PHPUnit\Framework\TestCase;
use Stytch\B2B\RecoveryCodes;
use Stytch\Shared\Client;

class RecoveryCodesTest extends TestCase
{
    public function testGetCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('get')
            ->with('/v1/b2b/recovery_codes', ['organization_id' => 'org123', 'member_id' => 'mem123'])
            ->willReturn(['recovery_codes' => []]);

        $recoveryCodes = new RecoveryCodes($mock);
        $result = $recoveryCodes->get(['organization_id' => 'org123', 'member_id' => 'mem123']);
        $this->assertSame(['recovery_codes' => []], $result);
    }

    public function testRecoverCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/b2b/recovery_codes/recover', ['organization_id' => 'org123', 'member_id' => 'mem123', 'recovery_code' => 'code123'])
            ->willReturn(['recovered' => true]);

        $recoveryCodes = new RecoveryCodes($mock);
        $result = $recoveryCodes->recover(['organization_id' => 'org123', 'member_id' => 'mem123', 'recovery_code' => 'code123']);
        $this->assertSame(['recovered' => true], $result);
    }

    public function testRotateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/b2b/recovery_codes/rotate', ['organization_id' => 'org123', 'member_id' => 'mem123'])
            ->willReturn(['rotated' => true]);

        $recoveryCodes = new RecoveryCodes($mock);
        $result = $recoveryCodes->rotate(['organization_id' => 'org123', 'member_id' => 'mem123']);
        $this->assertSame(['rotated' => true], $result);
    }
}
