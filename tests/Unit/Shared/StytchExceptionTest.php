<?php

namespace Stytch\Tests\Shared;

use PHPUnit\Framework\TestCase;
use Stytch\Shared\Errors\StytchExceptionFactory;
use Stytch\Shared\Errors\StytchRequestException;
use Stytch\Shared\Errors\OrganizationNotFoundException;
use Stytch\Shared\Errors\MemberNotFoundException;
use Stytch\Shared\Errors\UserNotFoundException;
use Stytch\Shared\Errors\SessionNotFoundException;
use Stytch\Shared\Errors\InvalidTokenException;
use Stytch\Shared\Errors\RateLimitException;
use Stytch\Shared\Errors\AuthenticationException;
use Stytch\Shared\Errors\AuthorizationException;
use Stytch\Shared\Errors\ValidationException;
use Stytch\Shared\Errors\ResourceNotFoundException;
use Stytch\Shared\Errors\ServerException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class StytchExceptionTest extends TestCase
{
    public function testCreatesOrganizationNotFoundException(): void
    {
        $errorData = [
            'status_code' => 404,
            'error_type' => 'organization_not_found',
            'error_message' => 'Organization not found',
            'request_id' => 'req_test_123',
            'error_url' => 'https://stytch.com/docs/errors/404',
        ];

        $exception = StytchExceptionFactory::createException($errorData);

        $this->assertInstanceOf(OrganizationNotFoundException::class, $exception);
        $this->assertEquals('Organization not found (Request ID: req_test_123)', $exception->getMessage());
        $this->assertEquals('organization_not_found', $exception->getErrorType());
        $this->assertEquals('Organization not found', $exception->getErrorMessage());
        $this->assertEquals('req_test_123', $exception->getRequestId());
        $this->assertEquals('https://stytch.com/docs/errors/404', $exception->getErrorUrl());
        $this->assertEquals(404, $exception->getStatusCode());
        $this->assertTrue($exception->isOrganizationNotFound());
    }

    public function testCreatesMemberNotFoundException(): void
    {
        $errorData = [
            'status_code' => 404,
            'error_type' => 'member_not_found',
            'error_message' => 'Member not found',
            'request_id' => 'req_test_456',
            'error_url' => 'https://stytch.com/docs/errors/404',
        ];

        $exception = StytchExceptionFactory::createException($errorData);

        $this->assertInstanceOf(MemberNotFoundException::class, $exception);
        $this->assertTrue($exception->isMemberNotFound());
    }

    public function testCreatesUserNotFoundException(): void
    {
        $errorData = [
            'status_code' => 404,
            'error_type' => 'user_not_found',
            'error_message' => 'User not found',
            'request_id' => 'req_test_789',
            'error_url' => 'https://stytch.com/docs/errors/404',
        ];

        $exception = StytchExceptionFactory::createException($errorData);

        $this->assertInstanceOf(UserNotFoundException::class, $exception);
        $this->assertTrue($exception->isUserNotFound());
    }

    public function testCreatesSessionNotFoundException(): void
    {
        $errorData = [
            'status_code' => 404,
            'error_type' => 'session_not_found',
            'error_message' => 'Session not found',
            'request_id' => 'req_test_101',
            'error_url' => 'https://stytch.com/docs/errors/404',
        ];

        $exception = StytchExceptionFactory::createException($errorData);

        $this->assertInstanceOf(SessionNotFoundException::class, $exception);
        $this->assertTrue($exception->isSessionNotFound());
    }

    public function testCreatesInvalidTokenException(): void
    {
        $errorData = [
            'status_code' => 401,
            'error_type' => 'invalid_token',
            'error_message' => 'Token is invalid',
            'request_id' => 'req_test_202',
            'error_url' => 'https://stytch.com/docs/errors/401',
        ];

        $exception = StytchExceptionFactory::createException($errorData);

        $this->assertInstanceOf(InvalidTokenException::class, $exception);
        $this->assertTrue($exception->isInvalidToken());
    }

    public function testCreatesRateLimitException(): void
    {
        $errorData = [
            'status_code' => 429,
            'error_type' => 'rate_limit_exceeded',
            'error_message' => 'Rate limit exceeded',
            'request_id' => 'req_test_303',
            'error_url' => 'https://stytch.com/docs/errors/429',
        ];

        $exception = StytchExceptionFactory::createException($errorData);

        $this->assertInstanceOf(RateLimitException::class, $exception);
        $this->assertTrue($exception->isRateLimited());
    }

    public function testCreatesAuthenticationException(): void
    {
        $errorData = [
            'status_code' => 401,
            'error_type' => 'authentication_failed',
            'error_message' => 'Authentication failed',
            'request_id' => 'req_test_404',
            'error_url' => 'https://stytch.com/docs/errors/401',
        ];

        $exception = StytchExceptionFactory::createException($errorData);

        $this->assertInstanceOf(AuthenticationException::class, $exception);
        $this->assertTrue($exception->isAuthenticationError());
    }

    public function testCreatesAuthorizationException(): void
    {
        $errorData = [
            'status_code' => 403,
            'error_type' => 'insufficient_permissions',
            'error_message' => 'Insufficient permissions',
            'request_id' => 'req_test_505',
            'error_url' => 'https://stytch.com/docs/errors/403',
        ];

        $exception = StytchExceptionFactory::createException($errorData);

        $this->assertInstanceOf(AuthorizationException::class, $exception);
        $this->assertTrue($exception->isAuthorizationError());
    }

    public function testCreatesValidationException(): void
    {
        $errorData = [
            'status_code' => 400,
            'error_type' => 'validation_error',
            'error_message' => 'Validation error',
            'request_id' => 'req_test_606',
            'error_url' => 'https://stytch.com/docs/errors/400',
        ];

        $exception = StytchExceptionFactory::createException($errorData);

        $this->assertInstanceOf(ValidationException::class, $exception);
        $this->assertTrue($exception->isValidationError());
    }

    public function testCreatesServerException(): void
    {
        $errorData = [
            'status_code' => 500,
            'error_type' => 'server_error',
            'error_message' => 'Internal server error',
            'request_id' => 'req_test_707',
            'error_url' => 'https://stytch.com/docs/errors/500',
        ];

        $exception = StytchExceptionFactory::createException($errorData);

        $this->assertInstanceOf(ServerException::class, $exception);
        $this->assertTrue($exception->isServerError());
    }

    public function testFallbackToStatusCodeBasedExceptions(): void
    {
        // Test 404 without specific error_type
        $errorData = [
            'status_code' => 404,
            'error_message' => 'Organization not found',
            'request_id' => 'req_test_808',
            'error_url' => 'https://stytch.com/docs/errors/404',
        ];

        $exception = StytchExceptionFactory::createException($errorData);
        $this->assertInstanceOf(OrganizationNotFoundException::class, $exception);

        // Test 404 with generic message
        $errorData = [
            'status_code' => 404,
            'error_message' => 'Resource not found',
            'request_id' => 'req_test_909',
            'error_url' => 'https://stytch.com/docs/errors/404',
        ];

        $exception = StytchExceptionFactory::createException($errorData);
        $this->assertInstanceOf(ResourceNotFoundException::class, $exception);
    }

    public function testHandlesMissingErrorFields(): void
    {
        $errorData = [
            'error_message' => 'Some error occurred',
        ];

        $exception = StytchExceptionFactory::createException($errorData);

        $this->assertEquals('Some error occurred', $exception->getMessage());
        $this->assertNull($exception->getErrorType());
        $this->assertNull($exception->getRequestId());
        $this->assertNull($exception->getErrorUrl());
        $this->assertNull($exception->getStatusCode());
    }

    public function testExceptionWithRequestAndResponse(): void
    {
        $request = new Request('GET', 'https://api.stytch.com/v1/test');
        $response = new Response(404);

        $errorData = [
            'status_code' => 404,
            'error_type' => 'organization_not_found',
            'error_message' => 'Organization not found',
        ];

        $exception = StytchExceptionFactory::createException($errorData, $request, $response);

        $this->assertInstanceOf(OrganizationNotFoundException::class, $exception);
        $this->assertSame($request, $exception->getRequest());
        $this->assertSame($response, $exception->getResponse());
    }
}
