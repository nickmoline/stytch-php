<?php

namespace Stytch\Tests\Unit\Objects\Response;

use PHPUnit\Framework\TestCase;
use Stytch\Objects\Response\ConnectedAppsResponse;

class ConnectedAppsResponseTest extends TestCase
{
    public function testConstructor(): void
    {
        $connectedApps = [
            'app1' => ['id' => 'app_123', 'name' => 'Test App 1'],
            'app2' => ['id' => 'app_456', 'name' => 'Test App 2'],
        ];

        $response = new ConnectedAppsResponse('test_request_id', 200, $connectedApps);

        $this->assertEquals('test_request_id', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals($connectedApps, $response->connected_apps);
    }

    public function testFromArray(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'connected_apps' => [
                'app1' => ['id' => 'app_123', 'name' => 'Test App 1'],
                'app2' => ['id' => 'app_456', 'name' => 'Test App 2'],
            ],
        ];

        $response = ConnectedAppsResponse::fromArray($data);

        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals($data['connected_apps'], $response->connected_apps);
    }

    public function testFromArrayWithMissingConnectedApps(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 200,
        ];

        $response = ConnectedAppsResponse::fromArray($data);

        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals([], $response->connected_apps);
    }

    public function testToArray(): void
    {
        $connectedApps = [
            'app1' => ['id' => 'app_123', 'name' => 'Test App 1'],
            'app2' => ['id' => 'app_456', 'name' => 'Test App 2'],
        ];

        $response = new ConnectedAppsResponse('test_request_id', 200, $connectedApps);
        $array = $response->toArray();

        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 200,
            'connected_apps' => $connectedApps,
        ], $array);
    }

    public function testToArrayWithEmptyConnectedApps(): void
    {
        $response = new ConnectedAppsResponse('test_request_id', 200, []);
        $array = $response->toArray();

        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 200,
            'connected_apps' => [],
        ], $array);
    }

    public function testRoundTripConversion(): void
    {
        $originalData = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'connected_apps' => [
                'app1' => ['id' => 'app_123', 'name' => 'Test App 1'],
                'app2' => ['id' => 'app_456', 'name' => 'Test App 2'],
            ],
        ];

        $response = ConnectedAppsResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        $this->assertEquals($originalData, $convertedData);
    }
}
