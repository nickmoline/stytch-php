<?php

namespace Stytch\Tests\Unit\Objects\Response;

use PHPUnit\Framework\TestCase;
use Stytch\Objects\Response\WebAuthnRegisterStartResponse;

class WebAuthnRegisterStartResponseTest extends TestCase
{
    public function testConstructor(): void
    {
        $response = new WebAuthnRegisterStartResponse(
            'test_request_id',
            200,
            'user_123',
            'pkcco_abc',
            'user_id_b64_xyz'
        );

        $this->assertEquals('test_request_id', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('user_123', $response->user_id);
        $this->assertEquals('pkcco_abc', $response->public_key_credential_creation_options);
        $this->assertEquals('user_id_b64_xyz', $response->user_id_base64);
    }

    public function testFromArray(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'user_id' => 'user_123',
            'public_key_credential_creation_options' => 'pkcco_abc',
            'user_id_base64' => 'user_id_b64_xyz',
        ];

        $response = WebAuthnRegisterStartResponse::fromArray($data);

        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('user_123', $response->user_id);
        $this->assertEquals('pkcco_abc', $response->public_key_credential_creation_options);
        $this->assertEquals('user_id_b64_xyz', $response->user_id_base64);
    }

    public function testToArray(): void
    {
        $response = new WebAuthnRegisterStartResponse(
            'test_request_id',
            200,
            'user_123',
            'pkcco_abc',
            'user_id_b64_xyz'
        );

        $array = $response->toArray();

        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 200,
            'user_id' => 'user_123',
            'public_key_credential_creation_options' => 'pkcco_abc',
            'user_id_base64' => 'user_id_b64_xyz',
        ], $array);
    }

    public function testRoundTripConversion(): void
    {
        $originalData = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'user_id' => 'user_123',
            'public_key_credential_creation_options' => 'pkcco_abc',
            'user_id_base64' => 'user_id_b64_xyz',
        ];

        $response = WebAuthnRegisterStartResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        $this->assertEquals($originalData, $convertedData);
    }
}
