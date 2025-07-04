<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Stytch\B2C\M2MClients;
use Stytch\B2C\M2MClientSecrets;
use Stytch\Objects\Response\M2MClientResponse;
use Stytch\Objects\Response\M2MClientsResponse;
use Stytch\Shared\Client;

class M2MClientsTest extends TestCase
{
    /**
     * @param callable $assertion
     * @param array<string, mixed> $response
     */
    private function getMockClient(callable $assertion, array $response = []): Client
    {
        $mock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['post', 'get', 'put', 'delete'])
            ->getMock();
        $mock->method($this->anything())
            ->willReturnCallback(function (...$args) use ($assertion, $response) {
                $assertion(...$args);
                return $response;
            });
        return $mock;
    }

    public function testCreate(): void
    {
        $expected = ['request_id' => 'req', 'status_code' => 200, 'm2m_client' => ['client_id' => 'id', 'client_name' => 'name', 'client_description' => '', 'status' => 'active', 'scopes' => [], 'client_secret_last_four' => '1234']];
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/m2m/clients', $url);
        }, $expected);
        $api = new M2MClients($client);
        $resp = $api->create([]);
    }

    public function testGet(): void
    {
        $expected = ['request_id' => 'req', 'status_code' => 200, 'm2m_client' => ['client_id' => 'id', 'client_name' => 'name', 'client_description' => '', 'status' => 'active', 'scopes' => [], 'client_secret_last_four' => '1234']];
        $client = $this->getMockClient(function ($url) {
            $this->assertEquals('/v1/m2m/clients/id', $url);
        }, $expected);
        $api = new M2MClients($client);
        $resp = $api->get('id');
    }

    public function testUpdate(): void
    {
        $expected = ['request_id' => 'req', 'status_code' => 200, 'm2m_client' => ['client_id' => 'id', 'client_name' => 'name', 'client_description' => '', 'status' => 'active', 'scopes' => [], 'client_secret_last_four' => '1234']];
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/m2m/clients/id', $url);
        }, $expected);
        $api = new M2MClients($client);
        $resp = $api->update('id', []);
    }

    public function testDelete(): void
    {
        $client = $this->getMockClient(function ($url) {
            $this->assertEquals('/v1/m2m/clients/id', $url);
        }, ['deleted' => true]);
        $api = new M2MClients($client);
        $api->delete('id');
    }

    public function testSearch(): void
    {
        $expected = ['request_id' => 'req', 'status_code' => 200, 'm2m_clients' => [], 'results_metadata' => []];
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/m2m/clients/search', $url);
        }, $expected);
        $api = new M2MClients($client);
        $resp = $api->search([]);
    }

    public function testSecretsRotateStart(): void
    {
        $expected = ['request_id' => 'req', 'status_code' => 200, 'm2m_client' => ['client_id' => 'id', 'client_name' => 'name', 'client_description' => '', 'status' => 'active', 'scopes' => [], 'client_secret_last_four' => '1234']];
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/m2m/clients/id/secrets/rotate/start', $url);
        }, $expected);
        $api = new M2MClientSecrets($client);
        $resp = $api->rotateStart('id');
    }

    public function testSecretsRotate(): void
    {
        $expected = ['request_id' => 'req', 'status_code' => 200, 'm2m_client' => ['client_id' => 'id', 'client_name' => 'name', 'client_description' => '', 'status' => 'active', 'scopes' => [], 'client_secret_last_four' => '1234']];
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/m2m/clients/id/secrets/rotate', $url);
        }, $expected);
        $api = new M2MClientSecrets($client);
        $resp = $api->rotate('id');
    }

    public function testSecretsRotateCancel(): void
    {
        $expected = ['request_id' => 'req', 'status_code' => 200, 'm2m_client' => ['client_id' => 'id', 'client_name' => 'name', 'client_description' => '', 'status' => 'active', 'scopes' => [], 'client_secret_last_four' => '1234']];
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/m2m/clients/id/secrets/rotate/cancel', $url);
        }, $expected);
        $api = new M2MClientSecrets($client);
        $resp = $api->rotateCancel('id');
    }
}
