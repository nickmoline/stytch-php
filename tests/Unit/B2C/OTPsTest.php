<?php

namespace Stytch\Tests\B2C;

use PHPUnit\Framework\TestCase;
use Stytch\B2C\OTPs;
use Stytch\B2C\OTPsSms;
use Stytch\B2C\OTPsEmail;
use Stytch\B2C\OTPsWhatsapp;
use Stytch\Shared\Client;

class OTPsTest extends TestCase
{
    public function testAuthenticateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/otps/authenticate', ['method_id' => 'id', 'code' => '123456'])
            ->willReturn(['ok' => true]);

        $otps = new OTPs($mock);
        $result = $otps->authenticate(['method_id' => 'id', 'code' => '123456']);
        $this->assertEquals(['ok' => true], $result);
    }

    public function testSmsSendCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/otps/sms/send', ['phone_number' => '+1234567890'])
            ->willReturn(['sent' => true]);

        $sms = new OTPsSms($mock);
        $result = $sms->send(['phone_number' => '+1234567890']);
        $this->assertEquals(['sent' => true], $result);
    }

    public function testEmailSendCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/otps/email/send', ['email' => 'user@example.com'])
            ->willReturn(['sent' => true]);

        $email = new OTPsEmail($mock);
        $result = $email->send(['email' => 'user@example.com']);
        $this->assertEquals(['sent' => true], $result);
    }

    public function testWhatsappSendCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/otps/whatsapp/send', ['phone_number' => '+1234567890'])
            ->willReturn(['sent' => true]);

        $whatsapp = new OTPsWhatsapp($mock);
        $result = $whatsapp->send(['phone_number' => '+1234567890']);
        $this->assertEquals(['sent' => true], $result);
    }
}
