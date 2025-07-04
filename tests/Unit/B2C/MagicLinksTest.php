<?php

namespace Stytch\Tests\B2C;

use PHPUnit\Framework\TestCase;
use Stytch\B2C\MagicLinks;
use Stytch\B2C\MagicLinksEmail;
use Stytch\Shared\Client;

class MagicLinksTest extends TestCase
{
    public function testAuthenticateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/magic_links/authenticate', ['token' => 'token123'])
            ->willReturn(['authenticated' => true]);

        $magicLinks = new MagicLinks($mock);
        $result = $magicLinks->authenticate(['token' => 'token123']);
        $this->assertEquals(['authenticated' => true], $result);
    }

    public function testCreateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/magic_links', ['email' => 'user@example.com'])
            ->willReturn(['created' => true]);

        $magicLinks = new MagicLinks($mock);
        $result = $magicLinks->create(['email' => 'user@example.com']);
        $this->assertEquals(['created' => true], $result);
    }

    public function testEmailLoginOrCreateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/magic_links/email/login_or_create', ['email' => 'user@example.com'])
            ->willReturn(['sent' => true]);

        $email = new MagicLinksEmail($mock);
        $result = $email->loginOrCreate(['email' => 'user@example.com']);
        $this->assertEquals(['sent' => true], $result);
    }

    public function testEmailInviteCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/magic_links/email/invite', ['email' => 'user@example.com'])
            ->willReturn(['invited' => true]);

        $email = new MagicLinksEmail($mock);
        $result = $email->invite(['email' => 'user@example.com']);
        $this->assertEquals(['invited' => true], $result);
    }

    public function testEmailRevokeInviteCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/magic_links/email/revoke_invite', ['email' => 'user@example.com'])
            ->willReturn(['revoked' => true]);

        $email = new MagicLinksEmail($mock);
        $result = $email->revokeInvite(['email' => 'user@example.com']);
        $this->assertEquals(['revoked' => true], $result);
    }
}
