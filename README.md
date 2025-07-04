# Stytch PHP Library

Unofficial PHP SDK for Stytch based on the Official [Stytch Node.js Library](https://github.com/stytchauth/stytch-node).

## Installation

```bash
composer require nickmoline/stytch-php
```

## Requirements

- PHP 8.2 or higher
- Guzzle HTTP Client
- PSR-7 compatible HTTP messages

## Usage

You can find your API credentials in the [Stytch Dashboard](https://stytch.com/dashboard/api-keys).

### Basic Setup

```php
<?php

use Stytch\Stytch;

$stytch = new Stytch([
    'project_id' => 'project-live-c60c0abe-c25a-4472-a9ed-320c6667d317',
    'secret' => 'secret-live-80JASucyk7z_G8Z-7dVwZVGXL5NT_qGAQ2I=',
]);
```

### B2B Features

This library currently supports the following B2B features:

- [x] Organizations
- [x] Magic Links
- [x] Sessions
- [x] Discovery
- [x] Impersonation
- [x] OAuth
- [x] OTPs (SMS & Email)
- [x] Passwords
- [x] RBAC
- [x] Recovery Codes
- [x] SCIM
- [x] SSO
- [x] TOTPs
- [x] IDP

### B2C Features

This library currently supports the following B2C features:

- [x] Users
- [x] Magic Links (Email)
- [x] Sessions
- [x] OAuth
- [x] OTPs (SMS, Email, WhatsApp)
- [x] Passwords
- [x] TOTPs
- [x] WebAuthn
- [x] Crypto Wallets
- [x] Fraud Detection
- [x] Project Management
- [x] Impersonation
- [x] IDP
- [x] M2M
- [x] Attributes

### Object-Based Responses

The library returns proper PHP objects instead of raw arrays, providing better type safety and IDE support. All responses include a `request_id` and `status_code` for debugging purposes.

**Note:** B2B responses return structured objects, while B2C responses return arrays. This difference reflects the underlying API structure.

#### B2B Response Format (Object-based)
```php
$response = $stytch->b2b()->organizations->get('org_id');
$organization = $response->organization; // Object
echo $organization->organization_name; // Property access
echo $response->request_id; // Debug info
```

#### B2C Response Format (Array-based)
```php
$response = $stytch->b2c()->users->get('user_id');
echo $response['user_id']; // Array access
echo $response['emails'][0]['email']; // Nested array access
```

### B2B Examples

#### Create an Organization

```php
$response = $stytch->b2b()->organizations->create([
    'organization_name' => 'Acme Co',
    'organization_slug' => 'acme-co',
    'email_allowed_domains' => ['acme.co'],
]);

// Access the organization object
$organization = $response->organization;
echo $organization->organization_name; // "Acme Co"
echo $organization->organization_id; // "org_1234567890abcdef"
echo $response->request_id; // For debugging
```

#### Get an Organization

```php
$response = $stytch->b2b()->organizations->get('org_1234567890abcdef');

$organization = $response->organization;
echo $organization->organization_name;
echo $organization->organization_slug;
echo $organization->email_allowed_domains[0]; // Access array properties
```

#### Update an Organization

```php
$response = $stytch->b2b()->organizations->update('org_1234567890abcdef', [
    'organization_name' => 'Acme Corporation',
    'email_allowed_domains' => ['acme.co', 'acmecorp.com'],
]);

$organization = $response->organization;
echo $organization->organization_name; // "Acme Corporation"
```

#### Delete an Organization

```php
$result = $stytch->b2b()->organizations->delete('org_1234567890abcdef');
```

#### Search Organizations

```php
$response = $stytch->b2b()->organizations->search([
    'limit' => 10,
    'query' => [
        'operator' => 'AND',
        'operands' => [
            [
                'filter_name' => 'organization_name_fuzzy',
                'filter_value' => 'Acme'
            ]
        ]
    ]
]);

// Access the organizations array
$organizations = $response->organizations;
foreach ($organizations as $org) {
    echo $org->organization_name;
    echo $org->organization_id;
}

// Access metadata
echo $response->results_metadata['total'];
```

#### Send Magic Link for Login/Signup

```php
$result = $stytch->b2b()->magicLinks->loginOrSignup([
    'organization_id' => 'org_1234567890abcdef',
    'email_address' => 'admin@acme.co',
]);
```

#### Authenticate Magic Link

```php
$response = $stytch->b2b()->magicLinks->authenticate([
    'token' => 'DOYoip3rvIMMW5lgItikFK-Ak1CfMsgjuiCyI7uuU94=',
]);

// Access session and member information
echo $response->session_token;
echo $response->session_jwt;
echo $response->member->email_address;
echo $response->organization->organization_name;
echo $response->member_authenticated; // boolean
```

#### Authenticate Session

```php
$response = $stytch->b2b()->sessions->authenticate([
    'session_token' => 'session_token_here',
]);

echo $response->session_token;
echo $response->session_jwt;
echo $response->member->member_id;
echo $response->organization->organization_id;

// Access session details
$session = $response->member_session;
echo $session->member_session_id;
echo $session->expires_at;
echo $session->roles[0]; // Access roles array
```

#### Get Session

```php
$session = $stytch->b2b()->sessions->get('session_1234567890abcdef');
```

#### Revoke Session

```php
$result = $stytch->b2b()->sessions->revoke('session_1234567890abcdef');
```

#### Password Authentication

```php
$response = $stytch->b2b()->passwords->authenticate([
    'organization_id' => 'org_1234567890abcdef',
    'email_address' => 'admin@acme.co',
    'password' => 'user_password',
]);

echo $response->member_id;
echo $response->organization_id;
echo $response->session_token;
echo $response->member_authenticated;
echo $response->member->email_address;
```

#### Password Strength Check

```php
$response = $stytch->b2b()->passwords->strengthCheck([
    'password' => 'user_password',
    'email_address' => 'admin@acme.co',
]);

echo $response->valid_password; // boolean
echo $response->score; // integer
echo $response->breached_password; // boolean
echo $response->strength_policy;
```

#### OAuth Authentication

```php
$result = $stytch->b2b()->oauth->authenticate([
    'oauth_token' => 'oauth_token_here',
]);
```

#### Send SMS OTP

```php
$result = $stytch->b2b()->otps->sms->send([
    'organization_id' => 'org_1234567890abcdef',
    'member_id' => 'member_1234567890abcdef',
]);
```

#### Authenticate SMS OTP

```php
$result = $stytch->b2b()->otps->sms->authenticate([
    'organization_id' => 'org_1234567890abcdef',
    'member_id' => 'member_1234567890abcdef',
    'code' => '123456',
]);
```

#### Send Email OTP

```php
$result = $stytch->b2b()->otps->email->send([
    'organization_id' => 'org_1234567890abcdef',
    'member_id' => 'member_1234567890abcdef',
]);
```

#### Authenticate Email OTP

```php
$result = $stytch->b2b()->otps->email->authenticate([
    'organization_id' => 'org_1234567890abcdef',
    'member_id' => 'member_1234567890abcdef',
    'code' => '123456',
]);
```

#### Create TOTP

```php
$result = $stytch->b2b()->totps->create([
    'organization_id' => 'org_1234567890abcdef',
    'member_id' => 'member_1234567890abcdef',
]);
```

#### Authenticate TOTP

```php
$result = $stytch->b2b()->totps->authenticate([
    'organization_id' => 'org_1234567890abcdef',
    'member_id' => 'member_1234567890abcdef',
    'code' => '123456',
]);
```

#### Get Recovery Codes

```php
$result = $stytch->b2b()->recoveryCodes->get([
    'organization_id' => 'org_1234567890abcdef',
    'member_id' => 'member_1234567890abcdef',
]);
```

#### Recover with Recovery Code

```php
$result = $stytch->b2b()->recoveryCodes->recover([
    'organization_id' => 'org_1234567890abcdef',
    'member_id' => 'member_1234567890abcdef',
    'recovery_code' => 'recovery_code_here',
]);
```

#### Discovery - List Organizations

```php
$result = $stytch->b2b()->discovery->organizations->list([
    'intermediate_session_token' => 'token_here',
]);
```

#### Discovery - Create Organization

```php
$result = $stytch->b2b()->discovery->organizations->create([
    'intermediate_session_token' => 'token_here',
    'organization_name' => 'New Organization',
]);
```

#### Discovery - Get Organization

```php
$result = $stytch->b2b()->discovery->organizations->get([
    'intermediate_session_token' => 'token_here',
    'organization_id' => 'org_1234567890abcdef',
]);
```

#### Discovery - Update Organization

```php
$result = $stytch->b2b()->discovery->organizations->update([
    'intermediate_session_token' => 'token_here',
    'organization_id' => 'org_1234567890abcdef',
    'organization_name' => 'Updated Organization Name',
]);
```

#### Discovery - Delete Organization

```php
$result = $stytch->b2b()->discovery->organizations->delete([
    'intermediate_session_token' => 'token_here',
    'organization_id' => 'org_1234567890abcdef',
]);
```

#### SSO Authentication

```php
$result = $stytch->b2b()->sso->authenticate([
    'sso_token' => 'sso_token_here',
]);
```

#### Get SSO Connections

```php
$result = $stytch->b2b()->sso->getConnections([
    'organization_id' => 'org_1234567890abcdef',
]);
```

#### Delete SSO Connection

```php
$result = $stytch->b2b()->sso->deleteConnection([
    'organization_id' => 'org_1234567890abcdef',
    'connection_id' => 'connection_1234567890abcdef',
]);
```

#### SCIM Connection Management

```php
// Create SCIM connection
$result = $stytch->b2b()->scim->connection->create([
    'organization_id' => 'org_1234567890abcdef',
    'display_name' => 'SCIM Connection',
    'base_url' => 'https://example.com/scim',
    'bearer_token' => 'token_here',
]);

// Get SCIM connection
$result = $stytch->b2b()->scim->connection->get([
    'organization_id' => 'org_1234567890abcdef',
    'connection_id' => 'connection_1234567890abcdef',
]);
```

#### IDP Token Introspection

```php
$result = $stytch->b2b()->idp->introspectToken([
    'token' => 'token_here',
    'client_id' => 'client_id_here',
]);
```

#### IDP - Get Token

```php
$result = $stytch->b2b()->idp->getToken([
    'token' => 'token_here',
]);
```

#### Impersonation - Authenticate

```php
$result = $stytch->b2b()->impersonation->authenticate([
    'impersonation_token' => 'impersonation_token_here',
]);
```

#### RBAC Policy

```php
$result = $stytch->b2b()->rbac->policy();
```

#### RBAC - Get Policy

```php
$result = $stytch->b2b()->rbac->policy();
```

#### RBAC - Get Role

```php
$result = $stytch->b2b()->rbac->getRole([
    'organization_id' => 'org_1234567890abcdef',
    'role_id' => 'role_1234567890abcdef',
]);
```

#### RBAC - List Roles

```php
$result = $stytch->b2b()->rbac->listRoles([
    'organization_id' => 'org_1234567890abcdef',
]);
```

### B2C Examples

#### Create a User

```php
$response = $stytch->b2c()->users->create([
    'email' => 'user@example.com',
    'name' => [
        'first_name' => 'John',
        'last_name' => 'Doe'
    ]
]);

echo $response['user_id'];
echo $response['email_id'];
echo $response['status'];
```

#### Get a User

```php
$response = $stytch->b2c()->users->get('user_1234567890abcdef');

$user = $response;
echo $user['user_id'];
echo $user['emails'][0]['email'];
echo $user['status'];
```

#### Search Users

```php
$response = $stytch->b2c()->users->search([
    'limit' => 10,
    'query' => [
        'operator' => 'AND',
        'operands' => [
            [
                'filter_name' => 'email_address',
                'filter_value' => ['user@example.com']
            ]
        ]
    ]
]);

foreach ($response['results'] as $user) {
    echo $user['user_id'];
    echo $user['emails'][0]['email'];
}
```

#### Send Magic Link Email

```php
$result = $stytch->b2c()->magicLinks->email->loginOrCreate([
    'email' => 'user@example.com',
    'login_magic_link_url' => 'https://example.com/authenticate',
    'signup_magic_link_url' => 'https://example.com/authenticate',
]);
```

#### Authenticate Magic Link

```php
$response = $stytch->b2c()->magicLinks->authenticate([
    'token' => 'DOYoip3rvIMMW5lgItikFK-Ak1CfMsgjuiCyI7uuU94=',
]);

echo $response['user_id'];
echo $response['session_token'];
echo $response['session_jwt'];
echo $response['user']['emails'][0]['email'];
```

#### Password Authentication

```php
$response = $stytch->b2c()->passwords->authenticate([
    'email' => 'user@example.com',
    'password' => 'user_password',
]);

echo $response['user_id'];
echo $response['session_token'];
echo $response['session_jwt'];
```

#### Create User with Password

```php
$response = $stytch->b2c()->passwords->create([
    'email' => 'user@example.com',
    'password' => 'secure_password',
    'name' => [
        'first_name' => 'John',
        'last_name' => 'Doe'
    ]
]);

echo $response['user_id'];
echo $response['session_token'];
```

#### Send SMS OTP

```php
$result = $stytch->b2c()->otps->sms->send([
    'phone_number' => '+1234567890',
]);
```

#### Authenticate SMS OTP

```php
$result = $stytch->b2c()->otps->authenticate([
    'method_id' => 'phone_id_here',
    'code' => '123456',
]);
```

#### Send Email OTP

```php
$result = $stytch->b2c()->otps->email->send([
    'email' => 'user@example.com',
]);
```

#### Create TOTP

```php
$result = $stytch->b2c()->totps->create([
    'user_id' => 'user_1234567890abcdef',
]);
```

#### Authenticate TOTP

```php
$result = $stytch->b2c()->totps->authenticate([
    'user_id' => 'user_1234567890abcdef',
    'totp_id' => 'totp_1234567890abcdef',
    'code' => '123456',
]);
```

#### WebAuthn Registration

```php
$result = $stytch->b2c()->webauthn->registerStart([
    'user_id' => 'user_1234567890abcdef',
    'domain' => 'example.com',
]);
```

#### WebAuthn Authentication

```php
$result = $stytch->b2c()->webauthn->authenticateStart([
    'user_id' => 'user_1234567890abcdef',
]);
```

#### OAuth Start

```php
$result = $stytch->b2c()->oauth->start([
    'provider' => 'google',
    'login_redirect_url' => 'https://example.com/authenticate',
    'signup_redirect_url' => 'https://example.com/authenticate',
]);
```

#### OAuth Authenticate

```php
$result = $stytch->b2c()->oauth->authenticate([
    'token' => 'oauth_token_here',
]);
```

#### Session Management

```php
// Authenticate session
$response = $stytch->b2c()->sessions->authenticate([
    'session_token' => 'session_token_here',
]);

// Get user sessions
$sessions = $stytch->b2c()->sessions->get([
    'user_id' => 'user_1234567890abcdef',
]);

// Revoke session
$result = $stytch->b2c()->sessions->revoke([
    'session_id' => 'session_1234567890abcdef',
]);
```

#### Crypto Wallet Authentication

```php
$result = $stytch->b2c()->cryptoWallets->authenticateStart([
    'user_id' => 'user_1234567890abcdef',
    'crypto_wallet_type' => 'ethereum',
    'crypto_wallet_address' => '0x1234567890abcdef',
]);
```

#### Fraud Detection

```php
$result = $stytch->b2c()->fraud->signal([
    'user_id' => 'user_1234567890abcdef',
    'event_type' => 'login',
    'ip_address' => '192.168.1.1',
    'user_agent' => 'Mozilla/5.0...',
]);
```

#### M2M (Machine-to-Machine) Authentication

```php
// Create M2M client
$response = $stytch->b2c()->m2m->clients->create([
    'client_name' => 'My M2M Client',
    'client_description' => 'Client for automated API access',
    'scopes' => ['read:users', 'write:data'],
]);

// Get M2M client
$client = $stytch->b2c()->m2m->clients->get('client_1234567890abcdef');

// Search M2M clients
$clients = $stytch->b2c()->m2m->clients->search([
    'limit' => 10,
]);

// Authenticate M2M token
$response = $stytch->b2c()->m2m->authenticate([
    'access_token' => 'm2m_token_here',
]);

// Authenticate with claims
$response = $stytch->b2c()->m2m->authenticateWithClaims([
    'access_token' => 'm2m_token_here',
]);
```

#### User Attributes

```php
// Get user attributes
$attributes = $stytch->b2c()->attribute->get([
    'user_id' => 'user_1234567890abcdef',
]);

// Set user attributes
$result = $stytch->b2c()->attribute->set([
    'user_id' => 'user_1234567890abcdef',
    'attributes' => [
        'preferences' => ['theme' => 'dark', 'language' => 'en'],
        'profile' => ['bio' => 'Software developer'],
    ],
]);
```

#### Project Management

```php
// Get project information
$project = $stytch->b2c()->project->get();

// Update project settings
$result = $stytch->b2c()->project->update([
    'project_name' => 'Updated Project Name',
    'trusted_metadata' => ['environment' => 'production'],
]);
```

#### WhatsApp OTP

```php
// Send WhatsApp OTP
$result = $stytch->b2c()->otps->whatsapp->send([
    'phone_number' => '+1234567890',
]);

// Authenticate WhatsApp OTP
$result = $stytch->b2c()->otps->whatsapp->authenticate([
    'method_id' => 'phone_id_here',
    'code' => '123456',
]);
```

## Error Handling

The library throws specific exceptions for different types of errors:

### StytchRequestException
For API errors with detailed error information:

```php
try {
    $organization = $stytch->b2b()->organizations->get('invalid-id');
} catch (Stytch\Shared\Errors\StytchRequestException $e) {
    echo 'Error Type: ' . $e->getErrorType();
    echo 'Error Message: ' . $e->getErrorMessage();
    echo 'Request ID: ' . $e->getRequestId();
    echo 'Status Code: ' . $e->getStatusCode();
    echo 'Error URL: ' . $e->getErrorUrl();
    
    // Check specific error types
    if ($e->isOrganizationNotFound()) {
        echo 'Organization not found';
    } elseif ($e->isAuthenticationError()) {
        echo 'Authentication failed';
    } elseif ($e->isValidationError()) {
        echo 'Validation error';
    }
}
```

### Specific Exception Types
The library provides specific exceptions for common errors:

```php
try {
    $member = $stytch->b2b()->members->get('invalid-member-id');
} catch (Stytch\Shared\Errors\MemberNotFoundException $e) {
    echo 'Member not found: ' . $e->getMessage();
} catch (Stytch\Shared\Errors\OrganizationNotFoundException $e) {
    echo 'Organization not found: ' . $e->getMessage();
} catch (Stytch\Shared\Errors\RateLimitException $e) {
    echo 'Rate limit exceeded: ' . $e->getMessage();
}
```

### Network and Connection Errors
For network-related errors:

```php
try {
    $response = $stytch->b2b()->organizations->get('org_id');
} catch (\RuntimeException $e) {
    echo 'Network error: ' . $e->getMessage();
} catch (\InvalidArgumentException $e) {
    echo 'Invalid argument: ' . $e->getMessage();
}
```

## Configuration Options

| Option | Type | Required | Description |
|--------|------|----------|-------------|
| `project_id` | string | Yes | Your Stytch project ID |
| `secret` | string | Yes | Your Stytch secret key |
| `env` | string | No | Environment (auto-detected from project_id) |
| `timeout` | int | No | Request timeout in seconds (default: 600) |
| `custom_base_url` | string | No | Custom base URL for requests |

### Environment Configuration

The library automatically detects the environment based on your project ID:

```php
// Test environment (project-test-*)
$stytch = new Stytch([
    'project_id' => 'project-test-1234567890abcdef',
    'secret' => 'secret-test-1234567890abcdef',
]);
// Uses: https://test.stytch.com/

// Live environment (project-live-*)
$stytch = new Stytch([
    'project_id' => 'project-live-1234567890abcdef',
    'secret' => 'secret-live-1234567890abcdef',
]);
// Uses: https://api.stytch.com/
```

### Custom Configuration

```php
// Custom timeout and base URL
$stytch = new Stytch([
    'project_id' => 'project-test-1234567890abcdef',
    'secret' => 'secret-test-1234567890abcdef',
    'timeout' => 300, // 5 minutes
    'custom_base_url' => 'https://custom-api.example.com',
]);
```

## Development

This is an unofficial library and is not affiliated with Stytch. It's based on the official Node.js library but adapted for PHP with Guzzle HTTP client and PSR-7 compatibility.

## License

MIT License
