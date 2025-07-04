<?php

namespace Stytch\Tests\Unit\Objects\Response;

use PHPUnit\Framework\TestCase;
use Stytch\Objects\Response\UsersCreateResponse;
use Stytch\Objects\User;

class UsersCreateResponseTest extends TestCase
{
    public function testConstructor(): void
    {
        $response = new UsersCreateResponse(
            'test_request_id',
            200,
            'user_123'
        );

        $this->assertEquals('test_request_id', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('user_123', $response->user_id);
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
        $response = new UsersCreateResponse(
            'test_request_id',
            200,
            'user_123',
            $user
        );

        $this->assertEquals('test_request_id', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('user_123', $response->user_id);
        $this->assertSame($user, $response->user);
    }

    public function testFromArray(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'user_id' => 'user_123',
        ];

        $response = UsersCreateResponse::fromArray($data);

        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('user_123', $response->user_id);
        $this->assertNull($response->user);
    }

    public function testFromArrayWithUser(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'user_id' => 'user_123',
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

        $response = UsersCreateResponse::fromArray($data);

        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('user_123', $response->user_id);
        $this->assertInstanceOf(User::class, $response->user);
        $this->assertEquals('user_123', $response->user->user_id);
    }

    public function testToArray(): void
    {
        $response = new UsersCreateResponse(
            'test_request_id',
            200,
            'user_123'
        );

        $array = $response->toArray();

        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 200,
            'user_id' => 'user_123',
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
        $response = new UsersCreateResponse(
            'test_request_id',
            200,
            'user_123',
            $user
        );

        $array = $response->toArray();

        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 200,
            'user_id' => 'user_123',
            'user' => $user->toArray(),
        ], $array);
    }

    public function testRoundTripConversion(): void
    {
        $originalData = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'user_id' => 'user_123',
        ];

        $response = UsersCreateResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        $this->assertEquals($originalData, $convertedData);
    }

    public function testRoundTripConversionWithUser(): void
    {
        $originalData = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'user_id' => 'user_123',
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

        $response = UsersCreateResponse::fromArray($originalData);
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
