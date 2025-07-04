<?php

namespace Stytch\Tests\Unit\B2B;

use PHPUnit\Framework\TestCase;
use Stytch\B2B\ConnectedApps;
use Stytch\Shared\Client;

class ConnectedAppsTest extends TestCase
{
    /**
     * @param callable $assertion
     * @param array<string, mixed> $response
     */
    private function getMockClient(callable $assertion, array $response = []): Client
    {
        $mock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['post'])
            ->getMock();
        $mock->method('post')
            ->willReturnCallback(function (...$args) use ($assertion, $response) {
                $assertion(...$args);
                return $response;
            });
        return $mock;
    }

    public function testRevoke(): void
    {
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/b2b/organizations/members/connected_apps/revoke', $url);
        }, ['revoked' => true]);
        $api = new ConnectedApps($client);
        $api->revoke([]);
    }
}
