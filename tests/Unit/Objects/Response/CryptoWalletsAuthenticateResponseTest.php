<?php

namespace Stytch\Tests\Unit\Objects\Response;

use PHPUnit\Framework\TestCase;
use Stytch\Objects\Response\CryptoWalletsAuthenticateResponse;
use Stytch\Objects\User;

class CryptoWalletsAuthenticateResponseTest extends TestCase
{
    public function testConstructor(): void
    {
        $response = new CryptoWalletsAuthenticateResponse(
            'test_request_id',
            200,
            'user_123',
            'session_token_456',
            'session_jwt_789'
        );

        $this->assertEquals('test_request_id', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('user_123', $response->user_id);
        $this->assertEquals('session_token_456', $response->session_token);
        $this->assertEquals('session_jwt_789', $response->session_jwt);
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
        $response = new CryptoWalletsAuthenticateResponse(
            'test_request_id',
            200,
            'user_123',
            'session_token_456',
            'session_jwt_789',
            $user
        );

        $this->assertEquals('test_request_id', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('user_123', $response->user_id);
        $this->assertEquals('session_token_456', $response->session_token);
        $this->assertEquals('session_jwt_789', $response->session_jwt);
        $this->assertSame($user, $response->user);
    }

    public function testFromArray(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'user_id' => 'user_123',
            'session_token' => 'session_token_456',
            'session_jwt' => 'session_jwt_789',
        ];

        $response = CryptoWalletsAuthenticateResponse::fromArray($data);

        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('user_123', $response->user_id);
        $this->assertEquals('session_token_456', $response->session_token);
        $this->assertEquals('session_jwt_789', $response->session_jwt);
        $this->assertNull($response->user);
    }

    public function testFromArrayWithUser(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'user_id' => 'user_123',
            'session_token' => 'session_token_456',
            'session_jwt' => 'session_jwt_789',
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

        $response = CryptoWalletsAuthenticateResponse::fromArray($data);

        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('user_123', $response->user_id);
        $this->assertEquals('session_token_456', $response->session_token);
        $this->assertEquals('session_jwt_789', $response->session_jwt);
        $this->assertInstanceOf(User::class, $response->user);
        $this->assertEquals('user_123', $response->user->user_id);
    }

    public function testToArray(): void
    {
        $response = new CryptoWalletsAuthenticateResponse(
            'test_request_id',
            200,
            'user_123',
            'session_token_456',
            'session_jwt_789'
        );

        $array = $response->toArray();

        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 200,
            'user_id' => 'user_123',
            'session_token' => 'session_token_456',
            'session_jwt' => 'session_jwt_789',
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
        $response = new CryptoWalletsAuthenticateResponse(
            'test_request_id',
            200,
            'user_123',
            'session_token_456',
            'session_jwt_789',
            $user
        );

        $array = $response->toArray();

        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 200,
            'user_id' => 'user_123',
            'session_token' => 'session_token_456',
            'session_jwt' => 'session_jwt_789',
            'user' => $user->toArray(),
        ], $array);
    }

    public function testRoundTripConversion(): void
    {
        $originalData = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'user_id' => 'user_123',
            'session_token' => 'session_token_456',
            'session_jwt' => 'session_jwt_789',
        ];

        $response = CryptoWalletsAuthenticateResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        $this->assertEquals($originalData, $convertedData);
    }

    public function testRoundTripConversionWithUser(): void
    {
        $originalData = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'user_id' => 'user_123',
            'session_token' => 'session_token_456',
            'session_jwt' => 'session_jwt_789',
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

        $response = CryptoWalletsAuthenticateResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        $this->assertEquals($originalData, $convertedData);
    }
}
