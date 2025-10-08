<?php

$apiKey = "b11ee851421b885275814e1e5b64564f";
$orgID =  "freedomreads";

return function ($kirby) use ($apiKey) {
    $response = [
        'success' => false,
        'message' => ''
    ];

    if ($kirby->request()->is('POST') && get('action') === 'donate') {
        $amount = get('amount');

        log_request(['action' => 'donate', 'amount' => $amount]);

        $result = call_neon($apiKey, $amount);

        log_response($result);

        if ($result) {
            $response['success'] = true;
            $response['message'] = 'Donation successful!';
        } else {
            $response['message'] = 'Failed to process donation. Please try again later.';
        }
    }

    return $response;
};

if (!function_exists('call_neon')) {
    function call_neon($apiKey, $amount) {
        $endpoint = 'https://api.neoncrm.com/neonws/services/api/donation/createDonation';
        $requestData = array(
            'apiKey' => $apiKey,
            'amount' => $amount
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            error_log('cURL error: ' . curl_error($ch));
            curl_close($ch);
            return null;
        }

        curl_close($ch);

        return $response;
    }
}

if (!function_exists('log_request')) {
    function log_request($data) {
        $log_file = 'api_requests.log';
        $log_message = date('Y-m-d H:i:s') . " - API Request: " . json_encode($data) . PHP_EOL;
        file_put_contents($log_file, $log_message, FILE_APPEND | LOCK_EX);
    }
}

if (!function_exists('log_response')) {
    function log_response($response) {
        $log_file = 'api_responses.log';
        $log_message = date('Y-m-d H:i:s') . " - API Response: " . $response . PHP_EOL;
        file_put_contents($log_file, $log_message, FILE_APPEND | LOCK_EX);
    }
}
?>
