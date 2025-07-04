<?php

namespace Stytch\Shared\Errors;

use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class StytchRequestException extends RequestException
{
    protected ?string $errorType = null;
    protected ?string $errorMessage = null;
    protected ?string $requestId = null;
    protected ?string $errorUrl = null;
    protected ?int $statusCode = null;
    /** @var array<string, mixed>|null */
    protected ?array $errorData;

    /**
     * @param array<string, mixed>|null $errorData
     */
    public function __construct(
        string $message = '',
        ?RequestInterface $request = null,
        ?ResponseInterface $response = null,
        ?\Throwable $previous = null,
        ?array $errorData = null,
    ) {
        if ($request === null) {
            // Use a dummy request if none provided
            $request = new \GuzzleHttp\Psr7\Request('GET', '/');
        }
        parent::__construct($message, $request, $response, $previous);
        $this->errorData = $errorData;

        // Extract Stytch-specific error information
        $this->errorType = $errorData['error_type'] ?? null;
        $this->errorMessage = $errorData['error_message'] ?? null;
        $this->requestId = $errorData['request_id'] ?? null;
        $this->errorUrl = $errorData['error_url'] ?? null;
        $this->statusCode = $errorData['status_code'] ?? ($response ? $response->getStatusCode() : null);
    }

    public function getErrorType(): ?string
    {
        return $this->errorType;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    public function getRequestId(): ?string
    {
        return $this->requestId;
    }

    public function getErrorUrl(): ?string
    {
        return $this->errorUrl;
    }

    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    public function isOrganizationNotFound(): bool
    {
        return $this->errorType === 'organization_not_found' ||
               $this->statusCode === 404 && str_contains($this->errorMessage ?? '', 'organization');
    }

    public function isMemberNotFound(): bool
    {
        return $this->errorType === 'member_not_found' ||
               $this->statusCode === 404 && str_contains($this->errorMessage ?? '', 'member');
    }

    public function isUserNotFound(): bool
    {
        return $this->errorType === 'user_not_found' ||
               $this->statusCode === 404 && str_contains($this->errorMessage ?? '', 'user');
    }

    public function isSessionNotFound(): bool
    {
        return $this->errorType === 'session_not_found' ||
               $this->statusCode === 404 && str_contains($this->errorMessage ?? '', 'session');
    }

    public function isInvalidToken(): bool
    {
        return $this->errorType === 'invalid_token' ||
               $this->statusCode === 401 && str_contains($this->errorMessage ?? '', 'token');
    }

    public function isRateLimited(): bool
    {
        return $this->statusCode === 429;
    }

    public function isAuthenticationError(): bool
    {
        return $this->statusCode === 401;
    }

    public function isAuthorizationError(): bool
    {
        return $this->statusCode === 403;
    }

    public function isValidationError(): bool
    {
        return $this->statusCode === 400;
    }

    public function isServerError(): bool
    {
        return $this->statusCode >= 500;
    }
}
