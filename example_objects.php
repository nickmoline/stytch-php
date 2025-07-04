<?php

require_once 'vendor/autoload.php';

use Stytch\Stytch;

// Initialize the Stytch client
$stytch = new Stytch([
    'project_id' => 'project-live-c60c0abe-c25a-4472-a9ed-320c6667d317',
    'secret' => 'secret-live-80JASucyk7z_G8Z-7dVwZVGXL5NT_qGAQ2I=',
]);

echo "=== Stytch PHP SDK Object-Based Example ===\n\n";

// Example 1: Create an organization
echo "1. Creating an organization...\n";
try {
    $response = $stytch->b2b()->organizations->create([
        'organization_name' => 'Acme Corporation',
        'organization_slug' => 'acme-corp',
        'email_allowed_domains' => ['acme.com'],
    ]);

    echo "   ✓ Organization created successfully!\n";
    echo "   - ID: {$response->organization->organization_id}\n";
    echo "   - Name: {$response->organization->organization_name}\n";
    echo "   - Slug: {$response->organization->organization_slug}\n";
    echo "   - Request ID: {$response->request_id}\n";
    echo "   - Status Code: {$response->status_code}\n\n";

    $orgId = $response->organization->organization_id;

} catch (Exception $e) {
    echo "   ✗ Error creating organization: " . $e->getMessage() . "\n\n";
    exit(1);
}

// Example 2: Get the organization
echo "2. Getting organization details...\n";
try {
    $response = $stytch->b2b()->organizations->get($orgId);

    echo "   ✓ Organization retrieved successfully!\n";
    echo "   - Name: {$response->organization->organization_name}\n";
    echo "   - Email domains: " . implode(', ', $response->organization->email_allowed_domains) . "\n";
    echo "   - Auth methods: {$response->organization->auth_methods}\n";
    echo "   - MFA policy: {$response->organization->mfa_policy}\n";
    echo "   - Created at: {$response->organization->created_at}\n\n";

} catch (Exception $e) {
    echo "   ✗ Error getting organization: " . $e->getMessage() . "\n\n";
}

// Example 3: Search organizations
echo "3. Searching organizations...\n";
try {
    $response = $stytch->b2b()->organizations->search([
        'limit' => 5,
        'query' => [
            'operator' => 'AND',
            'operands' => [
                [
                    'filter_name' => 'organization_name_fuzzy',
                    'filter_value' => 'Acme',
                ],
            ],
        ],
    ]);

    echo "   ✓ Search completed successfully!\n";
    echo "   - Total organizations found: {$response->results_metadata['total']}\n";
    echo "   - Organizations returned: " . count($response->organizations) . "\n";

    foreach ($response->organizations as $org) {
        echo "     * {$org->organization_name} ({$org->organization_id})\n";
    }
    echo "\n";

} catch (Exception $e) {
    echo "   ✗ Error searching organizations: " . $e->getMessage() . "\n\n";
}

// Example 4: Password strength check
echo "4. Checking password strength...\n";
try {
    $response = $stytch->b2b()->passwords->strengthCheck([
        'password' => 'weakpassword123',
        'email_address' => 'test@acme.com',
    ]);

    echo "   ✓ Password strength check completed!\n";
    echo "   - Valid password: " . ($response->valid_password ? 'Yes' : 'No') . "\n";
    echo "   - Score: {$response->score}\n";
    echo "   - Breached password: " . ($response->breached_password ? 'Yes' : 'No') . "\n";
    echo "   - Strength policy: {$response->strength_policy}\n";
    echo "   - Request ID: {$response->request_id}\n\n";

} catch (Exception $e) {
    echo "   ✗ Error checking password strength: " . $e->getMessage() . "\n\n";
}

echo "=== Example completed successfully! ===\n";
echo "\nKey benefits of the object-based approach:\n";
echo "- Type safety and IDE autocomplete\n";
echo "- Clear property access (e.g., \$response->organization->name)\n";
echo "- Consistent response structure across all endpoints\n";
echo "- Built-in debugging with request_id and status_code\n";
echo "- Easy serialization with toArray() methods\n";
