<?php

namespace Stytch\Shared;

use Stytch\Shared\Errors\StytchRequestException;
use Stytch\Shared\Errors\StytchExceptionFactory;
use Stytch\Shared\Errors\RequestError;
use Stytch\Shared\Errors\NoProjectIdException;
use Stytch\Shared\Errors\NoSecretException;
use Stytch\Shared\Errors\InvalidBaseUrlException;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Client
{
    protected HttpClient $httpClient;
    protected string $baseURL;
    protected string $projectId;
    protected string $secret;
    /** @var array<string, string> */
    protected array $headers;
    protected int $timeout;

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(array $config)
    {
        if (empty($config['project_id'])) {
            throw new NoProjectIdException();
        }

        if (empty($config['secret'])) {
            throw new NoSecretException();
        }

        $this->projectId = $config['project_id'];
        $this->secret = $config['secret'];
        $this->timeout = $config['timeout'] ?? 600; // 10 minutes default

        // Determine environment
        $env = $this->determineEnvironment($config['project_id']);

        // Validate custom_base_url is using HTTPS
        if (isset($config['custom_base_url'])) {
            if (!str_starts_with($config['custom_base_url'], 'https://')) {
                throw new InvalidBaseUrlException();
            }
            $baseURL = $config['custom_base_url'];
        } else {
            $baseURL = $env;
        }

        $this->baseURL = rtrim($baseURL, '/') . '/';

        // Set up headers
        $this->headers = [
            'Content-Type' => 'application/json',
            'User-Agent' => 'Stytch PHP v1.0.0',
            'Authorization' => 'Basic ' . Base64::encode($this->projectId . ':' . $this->secret),
        ];

        // Create HTTP client
        $this->httpClient = new HttpClient([
            'timeout' => $this->timeout,
            'headers' => $this->headers,
        ]);
    }

    protected function determineEnvironment(string $projectId): string
    {
        if (str_starts_with($projectId, 'project-live-')) {
            return 'https://api.stytch.com';
        }
        return 'https://test.stytch.com';
    }

    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed>|null $data
     * @return array<string, mixed>
     */
    protected function request(string $method, string $url, array $params = [], ?array $data = null): array
    {
        $uri = new Uri($this->baseURL . ltrim($url, '/'));

        // Add query parameters
        if (!empty($params)) {
            $query = [];
            foreach ($params as $key => $value) {
                if ($value !== null) {
                    $query[$key] = (string) $value;
                }
            }
            $uri = $uri->withQuery(http_build_query($query));
        }

        $headers = $this->headers;
        $body = null;

        if ($data !== null) {
            $body = json_encode($data);
            if ($body === false) {
                throw new \InvalidArgumentException('Invalid JSON data');
            }
        }

        $request = new Request($method, $uri, $headers, $body);

        try {
            $response = $this->httpClient->send($request);
            return $this->handleResponse($response);
        } catch (RequestException $e) {
            throw $this->handleRequestException($e);
        }
    }

    /**
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    public function get(string $url, array $params = []): array
    {
        return $this->request('GET', $url, $params);
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    public function post(string $url, array $data = [], array $params = []): array
    {
        return $this->request('POST', $url, $params, $data);
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    public function put(string $url, array $data = [], array $params = []): array
    {
        return $this->request('PUT', $url, $params, $data);
    }

    /**
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    public function delete(string $url, array $params = []): array
    {
        return $this->request('DELETE', $url, $params);
    }

    /**
     * @return array<string, mixed>
     */
    protected function handleResponse(ResponseInterface $response): array
    {
        $body = $response->getBody()->getContents();
        $data = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RequestError('Unable to parse JSON response from server: ' . json_last_error_msg(), []);
        }

        if ($response->getStatusCode() >= 400) {
            // Use the new exception factory to create Stytch-specific exceptions
            throw StytchExceptionFactory::createException($data, null, $response);
        }

        return $data;
    }

    protected function handleRequestException(RequestException $e): \Exception
    {
        if ($e->hasResponse()) {
            $response = $e->getResponse();
            if ($response !== null) {
                $body = $response->getBody()->getContents();
                $data = json_decode($body, true);

                if (json_last_error() === JSON_ERROR_NONE && isset($data['error_message'])) {
                    // Use the new exception factory to create Stytch-specific exceptions
                    return StytchExceptionFactory::createException($data, $e->getRequest(), $response);
                }
            }
        }

        // For non-JSON responses or network errors, wrap in a generic StytchRequestException
        return new StytchRequestException(
            'Request failed: ' . $e->getMessage(),
            $e->getRequest(),
            $e->getResponse(),
            $e,
        );
    }

    public function getProjectId(): string
    {
        return $this->projectId;
    }

    public function getBaseURL(): string
    {
        return $this->baseURL;
    }
}
