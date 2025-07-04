<?php

namespace Stytch\Tests\B2C;

use PHPUnit\Framework\TestCase;
use Stytch\B2C\WebAuthn;
use Stytch\Shared\Client;

class WebAuthnTest extends TestCase
{
    public function testRegisterStartCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/webauthn/register/start', ['user_id' => 'user123', 'domain' => 'example.com'])
            ->willReturn(['started' => true]);

        $webauthn = new WebAuthn($mock);
        $result = $webauthn->registerStart(['user_id' => 'user123', 'domain' => 'example.com']);
        $this->assertEquals(['started' => true], $result);
    }

    public function testRegisterCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/webauthn/register', ['user_id' => 'user123', 'public_key_credential' => 'credential123'])
            ->willReturn(['registered' => true]);

        $webauthn = new WebAuthn($mock);
        $result = $webauthn->register(['user_id' => 'user123', 'public_key_credential' => 'credential123']);
        $this->assertEquals(['registered' => true], $result);
    }

    public function testAuthenticateStartCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/webauthn/authenticate/start', ['user_id' => 'user123'])
            ->willReturn(['started' => true]);

        $webauthn = new WebAuthn($mock);
        $result = $webauthn->authenticateStart(['user_id' => 'user123']);
        $this->assertEquals(['started' => true], $result);
    }

    public function testAuthenticateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/webauthn/authenticate', ['user_id' => 'user123', 'public_key_credential' => 'credential123'])
            ->willReturn(['authenticated' => true]);

        $webauthn = new WebAuthn($mock);
        $result = $webauthn->authenticate(['user_id' => 'user123', 'public_key_credential' => 'credential123']);
        $this->assertEquals(['authenticated' => true], $result);
    }

    public function testUpdateStartCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/webauthn/update/start', ['user_id' => 'user123'])
            ->willReturn(['started' => true]);

        $webauthn = new WebAuthn($mock);
        $result = $webauthn->updateStart(['user_id' => 'user123']);
        $this->assertEquals(['started' => true], $result);
    }

    public function testUpdateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/webauthn/update', ['user_id' => 'user123', 'public_key_credential' => 'credential123'])
            ->willReturn(['updated' => true]);

        $webauthn = new WebAuthn($mock);
        $result = $webauthn->update(['user_id' => 'user123', 'public_key_credential' => 'credential123']);
        $this->assertEquals(['updated' => true], $result);
    }
}
