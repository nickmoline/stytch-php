<?php

namespace Stytch\Tests\Unit\Objects\Response;

use PHPUnit\Framework\TestCase;
use Stytch\Objects\Response\TOTPsCreateResponse;
use Stytch\Objects\User;

class TOTPsCreateResponseTest extends TestCase
{
    public function testConstructor(): void
    {
        $response = new TOTPsCreateResponse(
            'test_request_id',
            200,
            'user_123',
            'totp_456',
            'secret_789',
            'qr_code_abc'
        );

        $this->assertEquals('test_request_id', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('user_123', $response->user_id);
        $this->assertEquals('totp_456', $response->totp_id);
        $this->assertEquals('secret_789', $response->secret);
        $this->assertEquals('qr_code_abc', $response->qr_code);
        $this->assertNull($response->user);
    }

    public function testConstructorWithUser(): void
    {
        $user = User::fromArray([
            'user_id' => 'user_123',
            'emails' => [
                [
                    'email_id' => 'email_123',
                    'email' => 'test@example.com',
                    'verified' => true,
                ],
            ],
            'status' => 'active',
            'phone_numbers' => [],
            'webauthn_registrations' => [],
            'providers' => [],
            'totps' => [],
            'crypto_wallets' => [],
            'biometric_registrations' => [],
            'is_locked' => false,
        ]);
        $response = new TOTPsCreateResponse(
            'test_request_id',
            200,
            'user_123',
            'totp_456',
            'secret_789',
            'qr_code_abc',
            $user
        );

        $this->assertEquals('test_request_id', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('user_123', $response->user_id);
        $this->assertEquals('totp_456', $response->totp_id);
        $this->assertEquals('secret_789', $response->secret);
        $this->assertEquals('qr_code_abc', $response->qr_code);
        $this->assertSame($user, $response->user);
    }

    public function testFromArray(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'user_id' => 'user_123',
            'totp_id' => 'totp_456',
            'secret' => 'secret_789',
            'qr_code' => 'qr_code_abc',
        ];

        $response = TOTPsCreateResponse::fromArray($data);

        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('user_123', $response->user_id);
        $this->assertEquals('totp_456', $response->totp_id);
        $this->assertEquals('secret_789', $response->secret);
        $this->assertEquals('qr_code_abc', $response->qr_code);
        $this->assertNull($response->user);
    }

    public function testFromArrayWithUser(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'user_id' => 'user_123',
            'totp_id' => 'totp_456',
            'secret' => 'secret_789',
            'qr_code' => 'qr_code_abc',
            'user' => [
                'user_id' => 'user_123',
                'emails' => [
                    [
                        'email_id' => 'email_123',
                        'email' => 'test@example.com',
                        'verified' => true,
                    ],
                ],
                'status' => 'active',
                'phone_numbers' => [],
                'webauthn_registrations' => [],
                'providers' => [],
                'totps' => [],
                'crypto_wallets' => [],
                'biometric_registrations' => [],
                'is_locked' => false,
            ],
        ];

        $response = TOTPsCreateResponse::fromArray($data);

        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('user_123', $response->user_id);
        $this->assertEquals('totp_456', $response->totp_id);
        $this->assertEquals('secret_789', $response->secret);
        $this->assertEquals('qr_code_abc', $response->qr_code);
        $this->assertInstanceOf(User::class, $response->user);
        $this->assertEquals('user_123', $response->user->user_id);
    }

    public function testToArray(): void
    {
        $response = new TOTPsCreateResponse(
            'test_request_id',
            200,
            'user_123',
            'totp_456',
            'secret_789',
            'qr_code_abc'
        );

        $array = $response->toArray();

        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 200,
            'user_id' => 'user_123',
            'totp_id' => 'totp_456',
            'secret' => 'secret_789',
            'qr_code' => 'qr_code_abc',
        ], $array);
    }

    public function testToArrayWithUser(): void
    {
        $user = User::fromArray([
            'user_id' => 'user_123',
            'emails' => [
                [
                    'email_id' => 'email_123',
                    'email' => 'test@example.com',
                    'verified' => true,
                ],
            ],
            'status' => 'active',
            'phone_numbers' => [],
            'webauthn_registrations' => [],
            'providers' => [],
            'totps' => [],
            'crypto_wallets' => [],
            'biometric_registrations' => [],
            'is_locked' => false,
        ]);
        $response = new TOTPsCreateResponse(
            'test_request_id',
            200,
            'user_123',
            'totp_456',
            'secret_789',
            'qr_code_abc',
            $user
        );

        $array = $response->toArray();

        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 200,
            'user_id' => 'user_123',
            'totp_id' => 'totp_456',
            'secret' => 'secret_789',
            'qr_code' => 'qr_code_abc',
            'user' => $user->toArray(),
        ], $array);
    }

    public function testRoundTripConversion(): void
    {
        $originalData = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'user_id' => 'user_123',
            'totp_id' => 'totp_456',
            'secret' => 'secret_789',
            'qr_code' => 'qr_code_abc',
        ];

        $response = TOTPsCreateResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        $this->assertEquals($originalData, $convertedData);
    }

    public function testRoundTripConversionWithUser(): void
    {
        $originalData = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'user_id' => 'user_123',
            'totp_id' => 'totp_456',
            'secret' => 'secret_789',
            'qr_code' => 'qr_code_abc',
            'user' => [
                'user_id' => 'user_123',
                'emails' => [
                    [
                        'email_id' => 'email_123',
                        'email' => 'test@example.com',
                        'verified' => true,
                    ],
                ],
                'status' => 'active',
                'phone_numbers' => [],
                'webauthn_registrations' => [],
                'providers' => [],
                'totps' => [],
                'crypto_wallets' => [],
                'biometric_registrations' => [],
                'is_locked' => false,
            ],
        ];

        $response = TOTPsCreateResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        // Compare only the fields present in the original data for user
        foreach ($originalData['user'] as $field => $value) {
            $this->assertArrayHasKey($field, $convertedData['user']);
            $this->assertEquals($value, $convertedData['user'][$field]);
        }
        // Compare the rest of the fields
        foreach ($originalData as $key => $value) {
            if ($key !== 'user') {
                $this->assertEquals($value, $convertedData[$key]);
            }
        }
    }
}
