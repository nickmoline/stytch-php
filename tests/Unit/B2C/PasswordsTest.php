<?php

namespace Stytch\Tests\B2C;

use PHPUnit\Framework\TestCase;
use Stytch\B2C\Passwords;
use Stytch\Shared\Client;

class PasswordsTest extends TestCase
{
    public function testCreateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/passwords', ['email' => 'user@example.com', 'password' => 'pw'])
            ->willReturn(['created' => true]);

        $passwords = new Passwords($mock);
        $result = $passwords->create(['email' => 'user@example.com', 'password' => 'pw']);
        $this->assertEquals(['created' => true], $result);
    }

    public function testAuthenticateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/passwords/authenticate', ['email' => 'user@example.com', 'password' => 'pw'])
            ->willReturn(['authenticated' => true]);

        $passwords = new Passwords($mock);
        $result = $passwords->authenticate(['email' => 'user@example.com', 'password' => 'pw']);
        $this->assertEquals(['authenticated' => true], $result);
    }

    public function testStrengthCheckCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/passwords/strength_check', ['email' => 'user@example.com', 'password' => 'pw'])
            ->willReturn(['score' => 3]);

        $passwords = new Passwords($mock);
        $result = $passwords->strengthCheck(['email' => 'user@example.com', 'password' => 'pw']);
        $this->assertEquals(['score' => 3], $result);
    }

    public function testMigrateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/passwords/migrate', ['email' => 'user@example.com', 'hash_type' => 'bcrypt', 'hash' => 'hash'])
            ->willReturn(['migrated' => true]);

        $passwords = new Passwords($mock);
        $result = $passwords->migrate(['email' => 'user@example.com', 'hash_type' => 'bcrypt', 'hash' => 'hash']);
        $this->assertEquals(['migrated' => true], $result);
    }
}
