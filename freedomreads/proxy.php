<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$config = include __DIR__ . '/site/config/config-signup.php';

// Check that file was loaded and keys are present
if (!$config || !isset($config['orgID'], $config['apiKey'])) {
    http_response_code(500);
    echo json_encode([
      'error' => 'Config file not loaded or missing keys',
      'debug' => $config
    ]);
    exit;
}

$orgID = $config['orgID'];
$apiKey = $config['apiKey'];

$credentials = base64_encode($orgID.':'.$apiKey);

// The URL of the API you want to proxy
$api_url = 'https://api.neoncrm.com/v2/';

// Get any query parameters
$params = $_GET;
$method = $_SERVER['REQUEST_METHOD'];

// Get the target URL from the 'url' parameter
$target = isset($params['target']) ? $params['target'] : '';
// Remove custom target from parameter to build clean query with parameters
unset($params['target']);

session_start();
if (!isset($_POST['nonce']) || $_POST['nonce'] !== $_SESSION['nonce']) {
    http_response_code(403);
    echo json_encode(['error' => 'Invalid session.']);
    exit;
}
// Store form data
$submission = $_POST;

// Setup API endpoints
$accounts_endpoint = $api_url . 'accounts';

$account = []; //stores account info
$fees = []; //stores transaction fee info
$response = [];	//final response output 

//general curl call function
function curlCall($url, $category, $requestMethod, $requestData = '') {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $requestMethod);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if ($requestMethod === 'POST' || $requestMethod === 'PATCH') {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Basic ' . $GLOBALS['credentials'],
        'Content-Type: application/json'
    ]);
    $curlResponse = curl_exec($ch);
    if (curl_errno($ch)) {
        $GLOBALS['response']['errors'] = $category . ' cURL error: ' . curl_error($ch);
    } else {
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        http_response_code($http_code); // sets actual HTTP response code
        $GLOBALS['response']['httpcode'] = $http_code; // sets it in JSON response
        $GLOBALS[$category] = json_decode($curlResponse, true);
    }
    curl_close($ch);
}

//process different kinds of requests
if ($target == 'signup') {
    if (empty($submission['inputTextField'])) {
        newsletterSignup($submission);
    }
} else {
    $GLOBALS['response'] = 'Request not supported';
}

// file_put_contents(__DIR__ . '/debug.json', json_encode($GLOBALS['response'], JSON_PRETTY_PRINT));
unset($GLOBALS['response']['debug']);// to  disable debug output:
echo json_encode($GLOBALS['response']);


function newsletterSignup($submission) {
    $GLOBALS['response']['debug']['form_id'] = $submission['form_id'] ?? 'not set';

    checkAccount($submission, 'INDIVIDUAL'); 
    // newsletter accounts are always Individual

    $matchedAccount = null;

    $GLOBALS['response']['debug']['accountCheck_pre'] = [
        'matched' => $matchedAccount,
        'individualAccount' => $GLOBALS['account']['individualAccount'] ?? null,
        'newaccount_individual' => $GLOBALS['newaccount']['individualAccount'] ?? null,
        'newaccount_root' => $GLOBALS['newaccount'] ?? null,
      ];

    // Try to match existing account
if (!empty($GLOBALS['account']['searchResults'])) {
    foreach ($GLOBALS['account']['searchResults'] as $account) {
        $contact = $account['primaryContact'] ?? null;
        if (!$contact) continue;

        $existingEmail = strtolower(trim($contact['email1'] ?? ''));
        $submittedEmail = strtolower(trim($submission['email']));

        if ($existingEmail === $submittedEmail) {
            $matchedAccount = $account;
            $GLOBALS['response']['debug']['matched_email_account_id'] = $account['accountId'];

            // Name overwrite
            $existingFirst = strtolower(trim($contact['firstName'] ?? ''));
            $existingLast = strtolower(trim($contact['lastName'] ?? ''));
            $newFirst = strtolower(trim($submission['firstName']));
            $newLast = strtolower(trim($submission['lastName']));

            $needsNameUpdate = ($existingFirst !== $newFirst || $existingLast !== $newLast);

            $GLOBALS['response']['debug']['name_comparison'] = [
                'existingFirst' => $existingFirst,
                'existingLast' => $existingLast,
                'newFirst' => $newFirst,
                'newLast' => $newLast,
                'needsUpdate' => $needsNameUpdate
            ];

            if ($needsNameUpdate) {
                $GLOBALS['response']['debug']['name_overwrite_triggered'] = true;
                overwriteContactName($account['accountId'], $submission['firstName'], $submission['lastName']);
            } else {
                $GLOBALS['response']['debug']['name_overwrite_triggered'] = false;
            }

            break;
        }
    }
      
    }
  

    // Update or create account
    // if ($matchedAccount) {
    //     $GLOBALS['account']['individualAccount'] = $matchedAccount; // this ensures later logic sees it too
    //     $id = $matchedAccount['accountId'];
    //     updateAccountNewsletterFlag($id, $submission['form_id'] ?? '');
    //     $GLOBALS['response']['debug']['matched'] = $matchedAccount;
    // } else {
    //     createNewAccount('newsletter', $submission, 'INDIVIDUAL');
    //     $GLOBALS['response']['debug']['created'] = 'new account created';
    // }
if ($matchedAccount) {
    // Only update existing — never create
    $id = $matchedAccount['accountId'];
    updateAccountNewsletterFlag($id, $submission['form_id'] ?? '');
} else {
    createNewAccount('newsletter', $submission, 'INDIVIDUAL');
    $GLOBALS['response']['debug']['created'] = 'new account created';
}
   // ✅ Refetch account to verify opt-in status
        $accountId = null;
        if ($matchedAccount) {
            $accountId = $matchedAccount['accountId'];
        } elseif (!empty($GLOBALS['account']['individualAccount']['accountId'])) {
            $accountId = $GLOBALS['account']['individualAccount']['accountId'];
        } elseif (!empty($GLOBALS['newaccount'])) {
            // Try standard nested structure
            if (!empty($GLOBALS['newaccount']['individualAccount']['accountId'])) {
                $accountId = $GLOBALS['newaccount']['individualAccount']['accountId'];
                $GLOBALS['response']['debug']['account_id_fallback_used'] = 'individualAccount.accountId';
            }
            // Try flat structure with 'id' key (Neon's standard new account response)
                elseif (!empty($GLOBALS['newaccount']['id'])) {
                    $accountId = $GLOBALS['newaccount']['id'];
                    $GLOBALS['response']['debug']['account_id_fallback_used'] = 'root.id';
                }
            // Try data-wrapped structure
            elseif (!empty($GLOBALS['newaccount']['data']['individualAccount']['accountId'])) {
                $accountId = $GLOBALS['newaccount']['data']['individualAccount']['accountId'];
                $GLOBALS['response']['debug']['account_id_fallback_used'] = 'data.individualAccount.accountId';
            } else {
                $GLOBALS['response']['debug']['account_id_fallback_used'] = 'not found in newaccount';
            }
        }
        $GLOBALS['response']['debug']['account_id_used'] = $accountId ?? 'not set';


        if ($accountId) {
            $checkURL = $GLOBALS['accounts_endpoint'] . '/' . $accountId;
            curlCall($checkURL, 'accountCheck', 'GET');
           // DEBUG: Log what's actually inside the response
            $GLOBALS['response']['debug']['newaccount_raw'] = $GLOBALS['newaccount'];

            $GLOBALS['response']['debug']['accountCheck_called'] = true;
            $GLOBALS['response']['debug']['optout_flag'] = $GLOBALS['accountCheck']['individualAccount']['email1OptOut'] ?? 'not present';


            $isStillUnsubscribed = $GLOBALS['accountCheck']['individualAccount']['email1OptOut'] ?? null;
            $GLOBALS['response']['debug']['account_id_used'] = $accountId ?? 'not set';
            $GLOBALS['response']['debug']['accountCheck_called'] = isset($accountId);
            $GLOBALS['response']['debug']['optout_flag'] = $isStillUnsubscribed ?? 'not checked';
            $GLOBALS['response']['debug']['warning'] = $GLOBALS['response']['warning'] ?? 'not set';
            $GLOBALS['response']['debug']['account_id_checked'] = $accountId;
            $GLOBALS['response']['debug']['accountCheck_called'] = true;

            $GLOBALS['response']['debug']['accountCheck_response'] = $GLOBALS['accountCheck'];
            $GLOBALS['response']['debug']['accountCheck_optout'] = $isStillUnsubscribed;
            $GLOBALS['response']['debug']['optout_flag'] = $isStillUnsubscribed;

            if ($isStillUnsubscribed === true) {
                $GLOBALS['response']['warning'] = "This person is still unsubscribed...";
                $GLOBALS['response']['debug']['optin_check'] = 'still opted out';
            } else {
                $GLOBALS['response']['debug']['optin_check'] = 'subscribed';
            }
        }
        
        
}

function overwriteContactName($accountId, $firstName, $lastName) {
        $updateURL = $GLOBALS['accounts_endpoint'] . '/' . $accountId;

        $payload = [
            'individualAccount' => [
                'primaryContact' => [
                    'firstName' => $firstName,
                    'lastName' => $lastName
                ]
            ]
        ];
    $GLOBALS['response']['debug']['name_overwrite_payload'] = $payload;

    curlCall($updateURL, 'nameOverwrite', 'PATCH', $payload);
}
function checkAccount($submission, $userType) {
    $searchUrl = $GLOBALS['api_url'] . 'accounts/search';
     $payload = [
        'searchFields' => [
            [
                'field' => 'Email',
                'operator' => 'EQUAL',
                'value' => $submission['email']
            ]
        ],
        'outputFields' => [
            'Account ID',
            'First Name',
            'Last Name',
            'Email 1'
        ]
    ];

    curlCall($searchUrl, 'account', 'POST', $payload);
}

// helper to map form_id to custom campaign option ID
function getCampaignOptionId($form_id) {
    if (trim($form_id) === 'block-marchfourth') {
        return '144'; // March Forth
    }
    return null;
}

function updateAccountNewsletterFlag($id, $form_id) {
    // Custom field IDs
    $newsletterFieldId = '112';  // Newsletter
    $newsletterOptionId = '104'; // Yes
    $campaignFieldId = '135';    // Campaign checkbox group
    $campaignOptionId = null;

    // Match campaign option only if March Forth
    if (trim($form_id) === 'block-marchfourth') {
        $campaignOptionId = '144';
    }

    // Always include newsletter opt-in
    $customFields = [
        [
            'id' => $newsletterFieldId,
            'optionValues' => [['id' => $newsletterOptionId]]
        ],
        [
            'id' => $campaignFieldId,
            'optionValues' => $campaignOptionId ? [['id' => $campaignOptionId]] : []
        ]
    ];

    $updateAccountRequest = [
        'individualAccount' => [
            'email1OptOut' => false,         // ✅ Opt back in
            'source' => ['id' => '3'],       // ✅ Always assign source: Newsletter
            'accountCustomFields' => $customFields
        ]
    ];

    $GLOBALS['response']['debug']['update_payload'] = $updateAccountRequest;
    $GLOBALS['response']['debug']['form_id'] = $form_id;
    $GLOBALS['response']['debug']['campaign_option_id'] = $campaignOptionId ?? 'cleared';

    $updateAccountURL = $GLOBALS['accounts_endpoint'] . '/' . $id;
    curlCall($updateAccountURL, 'account', 'PATCH', $updateAccountRequest);
}


function createNewAccount($source, $submission, $userType) {
    // account custom fields: add newsletter flag has id 112
    //104 is Yes, 105 is No
    $newsletterFlag = ($source == 'newsletter' || isset($submission['newsletter'])) ? '104' : '105';

    $form_id = trim($submission['form_id'] ?? '');
    $campaignFieldId = '135';
    $campaignOptionId = null;

    if ($form_id === 'block-marchfourth') {
        $campaignOptionId = '144'; // March Forth
    }

    // Build custom fields
    $customFields = [
        [
            'id' => '112',
            'optionValues' => [['id' => $newsletterFlag]]
        ]
    ];

    // Add or clear campaign field
    $customFields[] = [
        'id' => $campaignFieldId,
        'optionValues' => $campaignOptionId ? [['id' => $campaignOptionId]] : []
    ];

    // Common base data
    $accountData = [
        'email1OptOut' => false, // ✅ Always opt-in
        'source' => ['id' => '3'], // ✅ Always Newsletter as source
        'accountCustomFields' => $customFields,
        'primaryContact' => [
            'firstName' => $submission['firstName'],
            'lastName' => $submission['lastName'],
            'email1' => $submission['email']
        ],
        'origin' => [
            'originCategory' => 'Website Signup',
            'originDetail' => $form_id
        ]
    ];

    // Add address info if this is a donation form
    if ($source == 'donation') {
        $accountData['primaryContact']['addresses'] = [[
            'isPrimaryAddress' => true,
            'addressLine1' => $submission['addressLine1'],
            'type' => ['id' => $submission['addressType']],
            'addressLine2' => $submission['addressLine2'],
            'city' => $submission['city'],
            'stateProvince' => ['code' => $submission['stateProvince']],
            'zipCode' => $submission['zipCode'],
            'country' => ['id' => $submission['country']],
            'phone1' => $submission['phone1'],
            'phone1Type' => $submission['phone1Type']
        ]];
        $accountData['origin'] = ['originCategory' => 'Donation Form'];
    }

    // Create full request payload
    $newAccountRequest = ($userType === 'INDIVIDUAL')
        ? ['individualAccount' => $accountData]
        : ['companyAccount' => array_merge($accountData, ['name' => $submission['name']])];

    $GLOBALS['response']['debug']['form_id'] = $form_id;
    $GLOBALS['response']['debug']['campaign_option_id'] = $campaignOptionId ?? 'cleared';
    $GLOBALS['response']['debug']['final_account_payload'] = $newAccountRequest;

    $createAccountParams = http_build_query(['userType' => $userType]); 
    $createAccountURL = $GLOBALS['accounts_endpoint'] . '?' . $createAccountParams;

    curlCall($createAccountURL, 'newaccount', 'POST', $newAccountRequest);
    $GLOBALS['response']['debug']['raw_newaccount_response'] = $GLOBALS['newaccount'];

}




///////////////////
// HELPER FUNCTIONS
///////////////////
function formatDate($date) {
    $formattedDate = $date->format('Y-m-d\TH:i:s');
    // Add milliseconds
    $milliseconds = sprintf('%03d', ($date->format('u') / 1000));
    $formattedDate .= '.' . $milliseconds . 'Z';
    return $formattedDate;
}

function getNextDate($date) {
    $nextDate = clone $date;
    $nextDate->modify('+1 month');
    // Check if the resulting month has fewer days than the original date
    if ($nextDate->format('d') != $date->format('d')) {
        // If the days are different (like going from 31st to 1st), adjust to the last day of the new month
        $nextDate->modify('last day of previous month');
    }
    return $nextDate->format('Y-m-d');
}
?>
