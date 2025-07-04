<?php

namespace Stytch\Tests\B2B;

use PHPUnit\Framework\TestCase;
use Stytch\B2B\Sms;
use Stytch\Shared\Client;

class SmsTest extends TestCase
{
    public function testSendCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/b2b/otps/sms/send', ['organization_id' => 'org123', 'member_id' => 'mem123'])
            ->willReturn(['sent' => true]);

        $sms = new Sms($mock);
        $result = $sms->send(['organization_id' => 'org123', 'member_id' => 'mem123']);
        $this->assertSame(['sent' => true], $result);
    }

    public function testAuthenticateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/b2b/otps/sms/authenticate', ['organization_id' => 'org123', 'member_id' => 'mem123', 'code' => '123456'])
            ->willReturn(['authenticated' => true]);

        $sms = new Sms($mock);
        $result = $sms->authenticate(['organization_id' => 'org123', 'member_id' => 'mem123', 'code' => '123456']);
        $this->assertSame(['authenticated' => true], $result);
    }
}
