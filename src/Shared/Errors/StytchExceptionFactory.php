<?php

namespace Stytch\Shared\Errors;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class StytchExceptionFactory
{
    /**
     * Create the appropriate Stytch exception based on error data
     *
     * @param array<string, mixed> $errorData
     */
    public static function createException(array $errorData, ?RequestInterface $request = null, ?ResponseInterface $response = null): StytchRequestException
    {
        $statusCode = $errorData['status_code'] ?? ($response ? $response->getStatusCode() : null);
        $errorType = $errorData['error_type'] ?? null;
        $errorMessage = $errorData['error_message'] ?? 'Unknown error';
        $requestId = $errorData['request_id'] ?? null;
        $errorUrl = $errorData['error_url'] ?? null;

        // Create base message
        $message = $errorMessage;
        if ($requestId) {
            $message .= " (Request ID: {$requestId})";
        }

        // Create request and response objects if not provided
        if (!$request) {
            $request = new Request('GET', 'https://api.stytch.com');
        }
        if (!$response && $statusCode) {
            $response = new Response($statusCode);
        }

        // Create specific exceptions based on error_type and status_code
        switch ($errorType) {
            case 'organization_not_found':
                return new OrganizationNotFoundException($message, $request, $response, null, $errorData);

            case 'member_not_found':
                return new MemberNotFoundException($message, $request, $response, null, $errorData);

            case 'user_not_found':
                return new UserNotFoundException($message, $request, $response, null, $errorData);

            case 'session_not_found':
                return new SessionNotFoundException($message, $request, $response, null, $errorData);

            case 'invalid_token':
            case 'token_expired':
            case 'token_revoked':
                return new InvalidTokenException($message, $request, $response, null, $errorData);

            case 'rate_limit_exceeded':
                return new RateLimitException($message, $request, $response, null, $errorData);

            case 'invalid_credentials':
            case 'authentication_failed':
                return new AuthenticationException($message, $request, $response, null, $errorData);

            case 'insufficient_permissions':
            case 'access_denied':
                return new AuthorizationException($message, $request, $response, null, $errorData);

            case 'validation_error':
            case 'invalid_request':
                return new ValidationException($message, $request, $response, null, $errorData);

            default:
                // Fall back to status code-based exceptions
                return self::createExceptionByStatusCode($statusCode, $message, $request, $response, $errorData);
        }
    }

    /**
     * Create exception based on HTTP status code when error_type is not specific
     *
     * @param array<string, mixed> $errorData
     */
    private static function createExceptionByStatusCode(
        ?int $statusCode,
        string $message,
        ?RequestInterface $request,
        ?ResponseInterface $response,
        array $errorData,
    ): StytchRequestException {
        switch ($statusCode) {
            case 400:
                return new ValidationException($message, $request, $response, null, $errorData);

            case 401:
                return new AuthenticationException($message, $request, $response, null, $errorData);

            case 403:
                return new AuthorizationException($message, $request, $response, null, $errorData);

            case 404:
                // Try to determine what type of resource was not found
                $errorMessage = $errorData['error_message'] ?? '';
                if (stripos($errorMessage, 'organization') !== false) {
                    return new OrganizationNotFoundException($message, $request, $response, null, $errorData);
                }
                if (stripos($errorMessage, 'member') !== false) {
                    return new MemberNotFoundException($message, $request, $response, null, $errorData);
                }
                if (stripos($errorMessage, 'user') !== false) {
                    return new UserNotFoundException($message, $request, $response, null, $errorData);
                }
                if (stripos($errorMessage, 'session') !== false) {
                    return new SessionNotFoundException($message, $request, $response, null, $errorData);
                }
                return new ResourceNotFoundException($message, $request, $response, null, $errorData);

            case 429:
                return new RateLimitException($message, $request, $response, null, $errorData);

            case 500:
            case 502:
            case 503:
            case 504:
                return new ServerException($message, $request, $response, null, $errorData);

            default:
                return new StytchRequestException($message, $request, $response, null, $errorData);
        }
    }
}
