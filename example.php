<?php

require_once 'vendor/autoload.php';

use Stytch\Stytch;

// Initialize the Stytch client (the values here are fake, you should use your own)
$stytch = new Stytch([
    'project_id' => 'project-live-c60c0abe-c25a-4472-a9ed-320c6667d317',
    'secret' => 'secret-live-80JASucyk7z_G8Z-7dVwZVGXL5NT_qGAQ2I=',
]);

try {
    // Example: Create an organization
    echo "Creating organization...\n";
    $organization = $stytch->b2b()->organizations->create([
        'organization_name' => 'Example Corp',
        'organization_slug' => 'example-corp',
        'email_allowed_domains' => ['example.com'],
    ]);

    echo "Organization created: " . $organization['organization']['organization_id'] . "\n";

    // Example: Get the organization
    echo "Getting organization...\n";
    $org = $stytch->b2b()->organizations->get($organization['organization']['organization_id']);
    echo "Organization name: " . $org['organization']['organization_name'] . "\n";

    // Example: Send a magic link
    echo "Sending magic link...\n";
    $magicLink = $stytch->b2b()->magicLinks->loginOrSignup([
        'organization_id' => $organization['organization']['organization_id'],
        'email_address' => 'admin@example.com',
    ]);
    echo "Magic link sent to: admin@example.com\n";

    // Example: Search organizations
    echo "Searching organizations...\n";
    $searchResults = $stytch->b2b()->organizations->search([
        'limit' => 5,
    ]);
    echo "Found " . count($searchResults['organizations']) . " organizations\n";

} catch (\RuntimeException $e) {
    echo "Error: " . $e->getMessage() . "\n";
} catch (\Exception $e) {
    echo "Unexpected error: " . $e->getMessage() . "\n";
}
