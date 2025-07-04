<?php

namespace Stytch\Tests\B2C;

use PHPUnit\Framework\TestCase;
use Stytch\B2C\TOTPs;
use Stytch\Shared\Client;

class TOTPsTest extends TestCase
{
    private TOTPs $totps;
    /** @var Client|\PHPUnit\Framework\MockObject\MockObject */
    private $mockClient;

    protected function setUp(): void
    {
        $this->mockClient = $this->createMock(Client::class);
        $this->totps = new TOTPs($this->mockClient);
    }

    public function testCreate(): void
    {
        $expectedData = [
            'user_id' => 'user-test-d5a3b680-e8a3-40c0-b815-ab79986666d0',
        ];

        $mockResponse = [
            'request_id' => 'request-id-test-55555555-5555-4555-8555-555555555555',
            'user_id' => 'user-test-d5a3b680-e8a3-40c0-b815-ab79986666d0',
            'status_code' => 200,
            'secret' => 'BTGNX5RKJRMQWQFRQKTG34JCF6XDRHZS',
            'qr_code' => 'data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAMgAAADIEAAAAADYoy0BAAAG8ElEQVR8EAAD//7dQP/5Y00bRAAAAAElFTkSuQmCC',
            'recovery_codes' => [
                'ckss-2skx-ebow',
                'spbc-424h-usy0',
                'hi08-n5tk-lns5',
                '1n6i-l5na-8axe',
                'aduj-eufq-w6yy',
                'i4l3-dxyt-urmx',
                'ayyi-utb0-gj0s',
                'lz0m-02bi-psbx',
                'l2qm-zrk1-8ujs',
                'c2qd-k7m4-ifmc',
            ],
        ];

        $this->mockClient
            ->expects($this->once())
            ->method('post')
            ->with('/v1/totps', $expectedData)
            ->willReturn($mockResponse);

        $result = $this->totps->create($expectedData);

        $this->assertEquals($mockResponse, $result);
    }

    public function testCreateWithExpiration(): void
    {
        $expectedData = [
            'user_id' => 'user-test-d5a3b680-e8a3-40c0-b815-ab79986666d0',
            'expiration_minutes' => 10,
        ];

        $mockResponse = [
            'request_id' => 'request-id-test-55555555-5555-4555-8555-555555555555',
            'user_id' => 'user-test-d5a3b680-e8a3-40c0-b815-ab79986666d0',
            'status_code' => 200,
            'secret' => 'BTGNX5RKJRMQWQFRQKTG34JCF6XDRHZS',
            'qr_code' => 'data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAMgAAADIEAAAAADYoy0BAAAG8ElEQVR8EAAD//7dQP/5Y00bRAAAAAElFTkSuQmCC',
            'recovery_codes' => [
                'ckss-2skx-ebow',
                'spbc-424h-usy0',
                'hi08-n5tk-lns5',
                '1n6i-l5na-8axe',
                'aduj-eufq-w6yy',
                'i4l3-dxyt-urmx',
                'ayyi-utb0-gj0s',
                'lz0m-02bi-psbx',
                'l2qm-zrk1-8ujs',
                'c2qd-k7m4-ifmc',
            ],
        ];

        $this->mockClient
            ->expects($this->once())
            ->method('post')
            ->with('/v1/totps', $expectedData)
            ->willReturn($mockResponse);

        $result = $this->totps->create($expectedData);

        $this->assertEquals($mockResponse, $result);
    }

    public function testAuthenticate(): void
    {
        $expectedData = [
            'user_id' => 'user-test-d5a3b680-e8a3-40c0-b815-ab79986666d0',
            'totp_code' => '111111',
        ];

        $mockResponse = [
            'request_id' => 'request-id-test-55555555-5555-4555-8555-555555555555',
            'user_id' => 'user-test-d5a3b680-e8a3-40c0-b815-ab79986666d0',
            'totp_id' => 'totp-test-5c44cc6a-8af7-48d6-8da7-ea821342f5a6',
            'status_code' => 200,
        ];

        $this->mockClient
            ->expects($this->once())
            ->method('post')
            ->with('/v1/totps/authenticate', $expectedData)
            ->willReturn($mockResponse);

        $result = $this->totps->authenticate($expectedData);

        $this->assertEquals($mockResponse, $result);
    }

    public function testAuthenticateWithSession(): void
    {
        $expectedData = [
            'user_id' => 'user-test-d5a3b680-e8a3-40c0-b815-ab79986666d0',
            'totp_code' => '111111',
            'session_token' => 'mZAYn5aLEqKUlZ_Ad9U_fWr38GaAQ1oFAhT8ds245v7Q',
            'session_duration_minutes' => 60,
        ];

        $mockResponse = [
            'request_id' => 'request-id-test-55555555-5555-4555-8555-555555555555',
            'user_id' => 'user-test-d5a3b680-e8a3-40c0-b815-ab79986666d0',
            'totp_id' => 'totp-test-5c44cc6a-8af7-48d6-8da7-ea821342f5a6',
            'session_token' => 'mZAYn5aLEqKUlZ_Ad9U_fWr38GaAQ1oFAhT8ds245v7Q',
            'session' => [
                'started_at' => '2021-08-28T00:41:58.935673Z',
                'user_id' => 'user-test-d5a3b680-e8a3-40c0-b815-ab79986666d0',
            ],
            'status_code' => 200,
        ];

        $this->mockClient
            ->expects($this->once())
            ->method('post')
            ->with('/v1/totps/authenticate', $expectedData)
            ->willReturn($mockResponse);

        $result = $this->totps->authenticate($expectedData);

        $this->assertEquals($mockResponse, $result);
    }

    public function testRecoveryCodes(): void
    {
        $expectedData = [
            'user_id' => 'user-test-d5a3b680-e8a3-40c0-b815-ab79986666d0',
        ];

        $mockResponse = [
            'request_id' => 'request-id-test-55555555-5555-4555-8555-555555555555',
            'user_id' => 'user-test-d5a3b680-e8a3-40c0-b815-ab79986666d0',
            'status_code' => 200,
            'totps' => [
                [
                    'totp_id' => 'totp-test-5c44cc6a-8af7-48d6-8da7-ea821342f5a6',
                    'status' => 'active',
                    'recovery_codes' => [
                        'ckss-2skx-ebow',
                        'spbc-424h-usy0',
                        'hi08-n5tk-lns5',
                        '1n6i-l5na-8axe',
                        'aduj-eufq-w6yy',
                        'i4l3-dxyt-urmx',
                        'ayyi-utb0-gj0s',
                        'lz0m-02bi-psbx',
                        'l2qm-zrk1-8ujs',
                        'c2qd-k7m4-ifmc',
                    ],
                ],
            ],
        ];

        $this->mockClient
            ->expects($this->once())
            ->method('post')
            ->with('/v1/totps/recovery_codes', $expectedData)
            ->willReturn($mockResponse);

        $result = $this->totps->recoveryCodes($expectedData);

        $this->assertEquals($mockResponse, $result);
    }

    public function testRecover(): void
    {
        $expectedData = [
            'user_id' => 'user-test-d5a3b680-e8a3-40c0-b815-ab79986666d0',
            'recovery_code' => '1111-1111-1111',
        ];

        $mockResponse = [
            'request_id' => 'request-id-test-55555555-5555-4555-8555-555555555555',
            'user_id' => 'user-test-d5a3b680-e8a3-40c0-b815-ab79986666d0',
            'totp_id' => 'totp-test-5c44cc6a-8af7-48d6-8da7-ea821342f5a6',
            'status_code' => 200,
        ];

        $this->mockClient
            ->expects($this->once())
            ->method('post')
            ->with('/v1/totps/recover', $expectedData)
            ->willReturn($mockResponse);

        $result = $this->totps->recover($expectedData);

        $this->assertEquals($mockResponse, $result);
    }

    public function testRecoverWithSession(): void
    {
        $expectedData = [
            'user_id' => 'user-test-d5a3b680-e8a3-40c0-b815-ab79986666d0',
            'recovery_code' => '1111-1111-1111',
            'session_token' => 'mZAYn5aLEqKUlZ_Ad9U_fWr38GaAQ1oFAhT8ds245v7Q',
            'session_duration_minutes' => 60,
        ];

        $mockResponse = [
            'request_id' => 'request-id-test-55555555-5555-4555-8555-555555555555',
            'user_id' => 'user-test-d5a3b680-e8a3-40c0-b815-ab79986666d0',
            'totp_id' => 'totp-test-5c44cc6a-8af7-48d6-8da7-ea821342f5a6',
            'session_token' => 'mZAYn5aLEqKUlZ_Ad9U_fWr38GaAQ1oFAhT8ds245v7Q',
            'session' => [
                'started_at' => '2021-08-28T00:41:58.935673Z',
                'user_id' => 'user-test-d5a3b680-e8a3-40c0-b815-ab79986666d0',
            ],
            'status_code' => 200,
        ];

        $this->mockClient
            ->expects($this->once())
            ->method('post')
            ->with('/v1/totps/recover', $expectedData)
            ->willReturn($mockResponse);

        $result = $this->totps->recover($expectedData);

        $this->assertEquals($mockResponse, $result);
    }
}
