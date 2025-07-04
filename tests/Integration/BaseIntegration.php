<?php

namespace Stytch\Tests\Integration;

use Exception;
use PHPUnit\Framework\TestCase;
use Stytch\Stytch;

abstract class BaseIntegration extends TestCase
{
    protected function shouldRunIntegrationTests(): bool
    {
        return (bool) getenv('RUN_INTEGRATION_TESTS');
    }

    protected function getEnv(string $name, ?string $default = null): ?string
    {
        $val = getenv($name);
        if (!$val && $default !== null) {
            return $default;
        }
        if (!$val) {
            return null;
        }
        return (string) $val;
    }

    protected function getRequiredEnv(string $name): string
    {
        $val = $this->getEnv($name);
        if (!$val) {
            throw new Exception("Missing required environment variable: {$name}");
        }
        return $val;
    }

    protected function invalidCredentialsStytch(): Stytch
    {
        $config = [
            'project_id' => 'test-project-id',
            'secret' => 'test-secret-key',
            'env' => 'test',
        ];
        return new Stytch($config);
    }

    protected function validCredentialsStytch(): Stytch
    {
        $config = [
            'project_id' => $this->getRequiredEnv('STYTCH_PROJECT_ID'),
            'secret' => $this->getRequiredEnv('STYTCH_SECRET'),
            'env' => 'test',
        ];
        if ($this->getEnv('STYTCH_API_URL')) {
            $config['custom_base_url'] = $this->getEnv('STYTCH_API_URL');
        }
        return new Stytch($config);
    }
}
