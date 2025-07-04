<?php

namespace Stytch\Tests\B2C;

use PHPUnit\Framework\TestCase;
use Stytch\B2C\OAuth;
use Stytch\Shared\Client;

class OAuthTest extends TestCase
{
    public function testAttachCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/oauth/attach', ['user_id' => 'user123', 'provider_token' => 'token123'])
            ->willReturn(['attached' => true]);

        $oauth = new OAuth($mock);
        $result = $oauth->attach(['user_id' => 'user123', 'provider_token' => 'token123']);
        $this->assertEquals(['attached' => true], $result);
    }

    public function testAuthenticateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/oauth/authenticate', ['token' => 'token123'])
            ->willReturn(['authenticated' => true]);

        $oauth = new OAuth($mock);
        $result = $oauth->authenticate(['token' => 'token123']);
        $this->assertEquals(['authenticated' => true], $result);
    }

    public function testStartCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/oauth/start', ['provider' => 'google', 'login_redirect_url' => 'https://example.com'])
            ->willReturn(['started' => true]);

        $oauth = new OAuth($mock);
        $result = $oauth->start(['provider' => 'google', 'login_redirect_url' => 'https://example.com']);
        $this->assertEquals(['started' => true], $result);
    }
}
