<?php

namespace Stytch\Tests\B2C;

use PHPUnit\Framework\TestCase;
use Stytch\B2C\CryptoWallets;
use Stytch\Shared\Client;

class CryptoWalletsTest extends TestCase
{
    private CryptoWallets $cryptoWallets;
    /** @var Client|\PHPUnit\Framework\MockObject\MockObject */
    private $mockClient;

    protected function setUp(): void
    {
        $this->mockClient = $this->createMock(Client::class);
        $this->cryptoWallets = new CryptoWallets($this->mockClient);
    }

    public function testAuthenticateStart(): void
    {
        $expectedData = [
            'crypto_wallet_address' => '0x1234567890123456789012345678901234567890',
            'crypto_wallet_type' => 'ethereum',
        ];

        $mockResponse = [
            'request_id' => 'request-id-test-55555555-5555-4555-8555-555555555555',
            'status_code' => 200,
            'user_id' => 'user-test-d5a3b680-e8a3-40c0-b815-ab79986666d0',
            'user_created' => false,
        ];

        $this->mockClient
            ->expects($this->once())
            ->method('post')
            ->with('/v1/crypto_wallets/authenticate/start', $expectedData)
            ->willReturn($mockResponse);

        $result = $this->cryptoWallets->authenticateStart($expectedData);

        $this->assertEquals($mockResponse, $result);
    }

    public function testAuthenticate(): void
    {
        $expectedData = [
            'crypto_wallet_address' => '0x1234567890123456789012345678901234567890',
            'crypto_wallet_type' => 'ethereum',
            'signature' => 'signature',
        ];

        $mockResponse = [
            'request_id' => 'request-id-test-55555555-5555-4555-8555-555555555555',
            'user_id' => 'user-test-d5a3b680-e8a3-40c0-b815-ab79986666d0',
            'status_code' => 200,
        ];

        $this->mockClient
            ->expects($this->once())
            ->method('post')
            ->with('/v1/crypto_wallets/authenticate', $expectedData)
            ->willReturn($mockResponse);

        $result = $this->cryptoWallets->authenticate($expectedData);

        $this->assertEquals($mockResponse, $result);
    }
}
