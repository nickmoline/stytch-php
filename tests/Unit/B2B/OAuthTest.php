<?php

namespace Stytch\Tests\B2B;

use PHPUnit\Framework\TestCase;
use Stytch\B2B\OAuth;
use Stytch\Shared\Client;

class OAuthTest extends TestCase
{
    public function testAuthenticateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/b2b/oauth/authenticate', ['organization_id' => 'org123', 'oauth_token' => 'token123'])
            ->willReturn(['authenticated' => true]);

        $oauth = new OAuth($mock);
        $result = $oauth->authenticate(['organization_id' => 'org123', 'oauth_token' => 'token123']);
        $this->assertSame(['authenticated' => true], $result);
    }
}
