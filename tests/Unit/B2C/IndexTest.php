<?php

namespace Stytch\Tests\B2C;

use PHPUnit\Framework\TestCase;
use Stytch\Stytch;
use Stytch\Shared\Envs;

class IndexTest extends TestCase
{
    public function testPreConfiguredEnvironmentBaseUrls(): void
    {
        $this->assertEquals('https://test.stytch.com/', Envs::TEST);
        $this->assertEquals('https://api.stytch.com/', Envs::LIVE);
    }

    public function testConfiguringATestClient(): void
    {
        $client = new Stytch([
            'project_id' => 'project-test-00000000-0000-4000-8000-000000000000',
            'secret' => 'secret-test-11111111-1111-4111-8111-111111111111',
            'env' => Envs::TEST,
        ]);

        $this->assertEquals('project-test-00000000-0000-4000-8000-000000000000', $client->b2c()->getProjectId());
    }

    public function testConfiguringALiveClient(): void
    {
        $client = new Stytch([
            'project_id' => 'project-test-00000000-0000-4000-8000-000000000000',
            'secret' => 'secret-test-11111111-1111-4111-8111-111111111111',
            'env' => Envs::LIVE,
        ]);

        $this->assertEquals('project-test-00000000-0000-4000-8000-000000000000', $client->b2c()->getProjectId());
    }
}
