<?php

namespace Stytch\Tests\B2B;

use PHPUnit\Framework\TestCase;
use Stytch\B2B\Email;
use Stytch\Shared\Client;

class EmailTest extends TestCase
{
    public function testSendCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/b2b/otps/email/send', ['organization_id' => 'org123', 'member_id' => 'mem123'])
            ->willReturn(['sent' => true]);

        $email = new Email($mock);
        $result = $email->send(['organization_id' => 'org123', 'member_id' => 'mem123']);
        $this->assertSame(['sent' => true], $result);
    }

    public function testAuthenticateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/b2b/otps/email/authenticate', ['organization_id' => 'org123', 'member_id' => 'mem123', 'code' => '123456'])
            ->willReturn(['authenticated' => true]);

        $email = new Email($mock);
        $result = $email->authenticate(['organization_id' => 'org123', 'member_id' => 'mem123', 'code' => '123456']);
        $this->assertSame(['authenticated' => true], $result);
    }
}
