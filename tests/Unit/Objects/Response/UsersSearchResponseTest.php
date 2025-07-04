<?php

namespace Stytch\Tests\Unit\Objects\Response;

use PHPUnit\Framework\TestCase;
use Stytch\Objects\Response\UsersSearchResponse;
use Stytch\Objects\User;

class UsersSearchResponseTest extends TestCase
{
    /**
     * @param string $id
     * @param string $email
     * @return array<string, mixed>
     */
    private function getUserArray($id = 'user_123', $email = 'test@example.com'): array
    {
        return [
            'user_id' => $id,
            'emails' => [
                [
                    'email_id' => 'email_123',
                    'email' => $email,
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
        ];
    }

    public function testConstructorEmpty(): void
    {
        $response = new UsersSearchResponse(
            'test_request_id',
            200,
            [],
            0
        );

        $this->assertEquals('test_request_id', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertIsArray($response->users);
        $this->assertCount(0, $response->users);
        $this->assertEquals(0, $response->total);
    }

    public function testConstructorWithUsers(): void
    {
        $user1 = User::fromArray($this->getUserArray('user_1', 'a@example.com'));
        $user2 = User::fromArray($this->getUserArray('user_2', 'b@example.com'));
        $response = new UsersSearchResponse(
            'test_request_id',
            200,
            [$user1, $user2],
            2
        );

        $this->assertEquals('test_request_id', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertCount(2, $response->users);
        $this->assertSame($user1, $response->users[0]);
        $this->assertSame($user2, $response->users[1]);
        $this->assertEquals(2, $response->total);
    }

    public function testFromArrayEmpty(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'users' => [],
            'total' => 0,
        ];

        $response = UsersSearchResponse::fromArray($data);

        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertIsArray($response->users);
        $this->assertCount(0, $response->users);
        $this->assertEquals(0, $response->total);
    }

    public function testFromArrayWithUsers(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'users' => [
                $this->getUserArray('user_1', 'a@example.com'),
                $this->getUserArray('user_2', 'b@example.com'),
            ],
            'total' => 2,
        ];

        $response = UsersSearchResponse::fromArray($data);

        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertCount(2, $response->users);
        $this->assertInstanceOf(User::class, $response->users[0]);
        $this->assertInstanceOf(User::class, $response->users[1]);
        $this->assertEquals('user_1', $response->users[0]->user_id);
        $this->assertEquals('user_2', $response->users[1]->user_id);
        $this->assertEquals(2, $response->total);
    }

    public function testToArrayEmpty(): void
    {
        $response = new UsersSearchResponse(
            'test_request_id',
            200,
            [],
            0
        );

        $array = $response->toArray();

        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 200,
            'users' => [],
            'total' => 0,
        ], $array);
    }

    public function testToArrayWithUsers(): void
    {
        $user1 = User::fromArray($this->getUserArray('user_1', 'a@example.com'));
        $user2 = User::fromArray($this->getUserArray('user_2', 'b@example.com'));
        $response = new UsersSearchResponse(
            'test_request_id',
            200,
            [$user1, $user2],
            2
        );

        $array = $response->toArray();

        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 200,
            'users' => [
                $user1->toArray(),
                $user2->toArray(),
            ],
            'total' => 2,
        ], $array);
    }

    public function testRoundTripConversionEmpty(): void
    {
        $originalData = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'users' => [],
            'total' => 0,
        ];

        $response = UsersSearchResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        $this->assertEquals($originalData, $convertedData);
    }

    public function testRoundTripConversionWithUsers(): void
    {
        $originalData = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'users' => [
                $this->getUserArray('user_1', 'a@example.com'),
                $this->getUserArray('user_2', 'b@example.com'),
            ],
            'total' => 2,
        ];

        $response = UsersSearchResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        // Compare users
        foreach ($originalData['users'] as $i => $userData) {
            foreach ($userData as $field => $value) {
                $this->assertArrayHasKey($field, $convertedData['users'][$i]);
                $this->assertEquals($value, $convertedData['users'][$i][$field]);
            }
        }
        // Compare the rest of the fields
        $this->assertEquals($originalData['request_id'], $convertedData['request_id']);
        $this->assertEquals($originalData['status_code'], $convertedData['status_code']);
        $this->assertEquals($originalData['total'], $convertedData['total']);
    }
}
