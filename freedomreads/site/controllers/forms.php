<?php

function get_all_neon_crm_form_ids() {
    $apiKey = '5f7fa8c821ae2c7533e497ffe1a3ea41'; // 네온 CRM API 키
    $orgID =  '87-3023665';
    $apiEndpoint = "https://api.neoncrm.com/neonws/services/api/forms/list?orgId={$orgId}"; // 실제 네온 CRM 폼 목록 엔드포인트

    // cURL을 사용하여 API에 요청을 보냅니다.
    $ch = curl_init($apiEndpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode($apiKey)
    ));
    $response = curl_exec($ch);
    curl_close($ch);

    // API 응답을 JSON으로 디코딩하여 배열로 변환합니다.
    $formList = json_decode($response, true);

    return $formList;
}

return function ($kirby, $site, $page) {
    $formList = get_all_neon_crm_form_ids();

    return compact('formList');
};
   
    