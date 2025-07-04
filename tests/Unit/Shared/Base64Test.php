<?php

namespace Stytch\Tests\Shared;

use PHPUnit\Framework\TestCase;
use Stytch\Shared\Base64;

class Base64Test extends TestCase
{
    public function testEncodesProjectIdAndSecret(): void
    {
        $project_id = 'project-live-c60c0abe-c25a-4472-a9ed-320c6667d317';
        $secret = 'secret-live-80JASucyk7z_G8Z-7dVwZVGXL5NT_qGAQ2I=';
        $header = $project_id . ':' . $secret;

        $expected = base64_encode($header);
        $encoded = Base64::encode($header);

        $this->assertEquals($expected, $encoded);
    }

    public function testEncodesVarietyOfInputs(): void
    {
        for ($i = 0; $i < 50; $i++) {
            $inputs = [
                bin2hex(random_bytes(10)),
                bin2hex(random_bytes(10)),
                base64_encode(random_bytes(10)),
                base64_encode(random_bytes(10)),
                substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 10)), 0, 20),
            ];
            foreach ($inputs as $input) {
                $expected = base64_encode($input);
                $encoded = Base64::encode($input);
                $this->assertEquals($expected, $encoded);
            }
        }
    }

    public function testThrowsOnUnicodeInput(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Base64 encoded unicode is not supported. Cannot encode 😅');
        Base64::encode('😅');
    }
}
