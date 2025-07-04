<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Stytch\B2B\OAuthProviders;
use Stytch\Shared\Client;

class OAuthProvidersTest extends TestCase
{
    /**
     * @param callable $assertion
     * @param array<string, mixed> $response
     */
    private function getMockClient(callable $assertion, array $response = []): Client
    {
        $mock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['get'])
            ->getMock();
        $mock->method('get')
            ->willReturnCallback(function (...$args) use ($assertion, $response) {
                $assertion(...$args);
                return $response;
            });
        return $mock;
    }

    public function testGoogle(): void
    {
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/b2b/organizations/members/oauth_providers/google', $url);
        }, ['ok' => true]);
        $api = new OAuthProviders($client);
        $api->google([]);
    }

    public function testMicrosoft(): void
    {
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/b2b/organizations/members/oauth_providers/microsoft', $url);
        }, ['ok' => true]);
        $api = new OAuthProviders($client);
        $api->microsoft([]);
    }

    public function testGithub(): void
    {
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/b2b/organizations/members/oauth_providers/github', $url);
        }, ['ok' => true]);
        $api = new OAuthProviders($client);
        $api->github([]);
    }

    public function testHubspot(): void
    {
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/b2b/organizations/members/oauth_providers/hubspot', $url);
        }, ['ok' => true]);
        $api = new OAuthProviders($client);
        $api->hubspot([]);
    }

    public function testSlack(): void
    {
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/b2b/organizations/members/oauth_providers/slack', $url);
        }, ['ok' => true]);
        $api = new OAuthProviders($client);
        $api->slack([]);
    }
}
