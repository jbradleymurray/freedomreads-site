<?php
/**
 * Neon CRM Webhook to Meta Conversions API
 *
 * This script receives donation webhooks from Neon CRM and forwards
 * the conversion event to Meta's Conversions API for ad attribution.
 *
 * Endpoint: https://freedomreads.org/webhooks/neon.php
 */

// ============================================
// CONFIGURATION - UPDATE THESE VALUES
// ============================================

$config = [
    'meta_pixel_id'     => 'YOUR_PIXEL_ID_HERE',
    'meta_access_token' => 'YOUR_ACCESS_TOKEN_HERE',
    'meta_api_version'  => 'v21.0',
    'event_source_url'  => 'https://freedomreads.org/donate',
    'debug_mode'        => false,  // Set to true during testing
    'log_file'          => __DIR__ . '/neon-webhook.log'
];

// ============================================
// LOGGING FUNCTION
// ============================================

function logMessage($message, $config) {
    if ($config['debug_mode']) {
        $timestamp = date('Y-m-d H:i:s');
        file_put_contents(
            $config['log_file'],
            "[{$timestamp}] {$message}\n",
            FILE_APPEND
        );
    }
}

// ============================================
// MAIN WEBHOOK HANDLER
// ============================================

// Set response header
header('Content-Type: text/plain');

// Get raw POST body
$rawPayload = file_get_contents('php://input');
logMessage("Received payload: {$rawPayload}", $config);

// Parse JSON payload
$payload = json_decode($rawPayload, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    logMessage("JSON parse error: " . json_last_error_msg(), $config);
    http_response_code(400);
    echo "Invalid JSON";
    exit;
}

// Only process createDonation events
$eventTrigger = $payload['eventTrigger'] ?? '';

if ($eventTrigger !== 'createDonation') {
    logMessage("Ignoring event type: {$eventTrigger}", $config);
    http_response_code(200);
    echo "OK - Event ignored";
    exit;
}

// Extract donation data
$donation = $payload['data']['donation'] ?? [];

if (empty($donation)) {
    logMessage("No donation data in payload", $config);
    http_response_code(200);
    echo "OK - No donation data";
    exit;
}

// Extract relevant fields from Neon webhook
// Note: Field names may vary - check actual Neon webhook payload
$amount = $donation['amount'] ?? 0;
$donorName = $donation['donorName'] ?? '';
$accountId = $donation['accountId'] ?? '';
$donationId = $donation['donationId'] ?? '';

// Neon may send name as single field - split if needed
$nameParts = explode(' ', $donorName, 2);
$firstName = $nameParts[0] ?? '';
$lastName = $nameParts[1] ?? '';

// Email might be in different locations depending on Neon's payload structure
// Check the actual webhook payload and adjust as needed
$email = $donation['email']
    ?? $donation['donorEmail']
    ?? $payload['data']['account']['email']
    ?? '';

logMessage("Processing donation: ID={$donationId}, Amount={$amount}, Email={$email}", $config);

// ============================================
// BUILD META CAPI PAYLOAD
// ============================================

// Hash PII fields (Meta requires SHA256 hashing)
$hashedEmail = !empty($email) ? hash('sha256', strtolower(trim($email))) : null;
$hashedFirstName = !empty($firstName) ? hash('sha256', strtolower(trim($firstName))) : null;
$hashedLastName = !empty($lastName) ? hash('sha256', strtolower(trim($lastName))) : null;

// Build user_data object
$userData = [];
if ($hashedEmail) $userData['em'] = [$hashedEmail];
if ($hashedFirstName) $userData['fn'] = [$hashedFirstName];
if ($hashedLastName) $userData['ln'] = [$hashedLastName];

// Generate unique event ID for potential deduplication
$eventId = 'neon_' . $donationId . '_' . time();

// Build the event payload
$eventData = [
    'data' => [
        [
            'event_name' => 'Donate',  // Standard event for donations
            'event_time' => time(),
            'event_id' => $eventId,
            'action_source' => 'website',
            'event_source_url' => $config['event_source_url'],
            'user_data' => $userData,
            'custom_data' => [
                'value' => floatval($amount),
                'currency' => 'USD',
                'content_name' => 'Donation',
                'content_category' => 'Nonprofit Donation'
            ]
        ]
    ],
    'access_token' => $config['meta_access_token']
];

// Add test_event_code if in debug mode (get this from Meta Events Manager > Test Events)
if ($config['debug_mode']) {
    // Uncomment and add your test code when testing:
    // $eventData['test_event_code'] = 'TEST12345';
}

logMessage("Sending to Meta CAPI: " . json_encode($eventData), $config);

// ============================================
// SEND TO META CONVERSIONS API
// ============================================

$apiUrl = "https://graph.facebook.com/{$config['meta_api_version']}/{$config['meta_pixel_id']}/events";

$ch = curl_init($apiUrl);
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($eventData),
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($curlError) {
    logMessage("cURL error: {$curlError}", $config);
} else {
    logMessage("Meta API response (HTTP {$httpCode}): {$response}", $config);
}

// ============================================
// RESPOND TO NEON
// ============================================

// Always return 200 to Neon so they don't retry
http_response_code(200);
echo "OK";
