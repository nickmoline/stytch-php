<?php

namespace Stytch\Tests;

use Stytch\Stytch;
use Stytch\B2B\Client as B2BClient;
use PHPUnit\Framework\TestCase;

class BasicTest extends TestCase
{

    public function testClientConfiguration(): void
    {
        $stytch = new Stytch([
            'project_id' => 'project-test-123',
            'secret' => 'secret-test-456',
            'timeout' => 300,
        ]);

        $b2b = $stytch->b2b();
        $this->assertEquals('project-test-123', $b2b->getProjectId());
        $this->assertEquals('https://test.stytch.com/', $b2b->getBaseURL());
    }

    public function testLiveEnvironmentDetection(): void
    {
        $stytch = new Stytch([
            'project_id' => 'project-live-123',
            'secret' => 'secret-live-456',
        ]);

        $b2b = $stytch->b2b();
        $this->assertEquals('https://api.stytch.com/', $b2b->getBaseURL());
    }
}
