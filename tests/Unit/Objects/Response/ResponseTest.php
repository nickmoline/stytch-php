<?php

namespace Stytch\Tests\Unit\Objects\Response;

use PHPUnit\Framework\TestCase;
use Stytch\Objects\Response\Response;

class DummyResponse extends Response
{
    public static function fromArray(array $data): self
    {
        return new self(
            $data['request_id'] ?? '',
            $data['status_code'] ?? 0,
        );
    }
}

class ResponseTest extends TestCase
{
    public function testConstructorAndToArray(): void
    {
        $response = new DummyResponse('test_request_id', 200);
        $this->assertEquals('test_request_id', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 200,
        ], $response->toArray());
    }

    public function testFromArray(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 404,
        ];
        $response = DummyResponse::fromArray($data);
        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(404, $response->status_code);
        $this->assertEquals($data, $response->toArray());
    }

    public function testFromArrayWithMissingFields(): void
    {
        $data = [];
        $response = DummyResponse::fromArray($data);
        $this->assertEquals('', $response->request_id);
        $this->assertEquals(0, $response->status_code);
        $this->assertEquals([
            'request_id' => '',
            'status_code' => 0,
        ], $response->toArray());
    }
}
