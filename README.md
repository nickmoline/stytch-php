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

#### Carbon Date Handling

All date and time fields from the Stytch API are automatically converted to [Carbon](https://carbon.nesbot.com/) instances, providing rich date manipulation capabilities:

```php
$response = $stytch->b2b()->organizations->get('org_id');
$organization = $response->organization;

// Access Carbon instances for date fields
$createdAt = $organization->created_at; // Carbon instance
$updatedAt = $organization->updated_at; // Carbon instance

// Use Carbon's rich date manipulation
echo $createdAt->format('Y-m-d H:i:s'); // "2023-01-01 12:00:00"
echo $createdAt->diffForHumans(); // "2 days ago"
echo $createdAt->isToday(); // true/false
echo $createdAt->addDays(7)->format('Y-m-d'); // Add 7 days

// Session expiration handling
$session = $response->member_session;
$expiresAt = $session->expires_at; // Carbon instance
if ($expiresAt->isPast()) {
    echo "Session has expired";
} else {
    echo "Session expires in " . $expiresAt->diffForHumans();
}
```

**Available Carbon date fields:**
- `created_at` - When the resource was created
- `updated_at` - When the resource was last updated
- `expires_at` - When a session or token expires
- `started_at` - When a session started
- `last_accessed_at` - When a session was last accessed
- `lock_created_at` - When a user/member lock was created
- `lock_expires_at` - When a user/member lock expires
- `last_authenticated_at` - When authentication factor was last used
- `bearer_token_expires_at` - When a bearer token expires

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
