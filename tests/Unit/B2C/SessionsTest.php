<?php

namespace Stytch\Tests\B2C;

use PHPUnit\Framework\TestCase;
use Stytch\B2C\Sessions;
use Stytch\Shared\Client;

class SessionsTest extends TestCase
{
    public function testGetCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('get')
            ->with('/v1/sessions', ['user_id' => 'user123'])
            ->willReturn(['sessions' => []]);

        $sessions = new Sessions($mock);
        $result = $sessions->get(['user_id' => 'user123']);
        $this->assertEquals(['sessions' => []], $result);
    }

    public function testAuthenticateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/sessions/authenticate', ['session_token' => 'token123'])
            ->willReturn(['authenticated' => true]);

        $sessions = new Sessions($mock);
        $result = $sessions->authenticate(['session_token' => 'token123']);
        $this->assertEquals(['authenticated' => true], $result);
    }

    public function testRevokeCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/sessions/revoke', ['session_id' => 'session123'])
            ->willReturn(['revoked' => true]);

        $sessions = new Sessions($mock);
        $result = $sessions->revoke(['session_id' => 'session123']);
        $this->assertEquals(['revoked' => true], $result);
    }

    public function testMigrateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/sessions/migrate', ['from_session_id' => 'old123', 'to_session_id' => 'new123'])
            ->willReturn(['migrated' => true]);

        $sessions = new Sessions($mock);
        $result = $sessions->migrate(['from_session_id' => 'old123', 'to_session_id' => 'new123']);
        $this->assertEquals(['migrated' => true], $result);
    }

    public function testExchangeAccessTokenCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/sessions/exchange_access_token', ['session_token' => 'token123'])
            ->willReturn(['access_token' => 'access123']);

        $sessions = new Sessions($mock);
        $result = $sessions->exchangeAccessToken(['session_token' => 'token123']);
        $this->assertEquals(['access_token' => 'access123'], $result);
    }

    public function testGetJWKSCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('get')
            ->with('/v1/sessions/jwks', [])
            ->willReturn(['keys' => []]);

        $sessions = new Sessions($mock);
        $result = $sessions->getJWKS([]);
        $this->assertEquals(['keys' => []], $result);
    }

    public function testAuthenticateJwtCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/sessions/authenticate_jwt', ['session_jwt' => 'jwt123'])
            ->willReturn(['authenticated' => true]);

        $sessions = new Sessions($mock);
        $result = $sessions->authenticateJwt(['session_jwt' => 'jwt123']);
        $this->assertEquals(['authenticated' => true], $result);
    }
}
