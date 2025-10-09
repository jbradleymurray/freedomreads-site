<?php
session_start();
$nonce = $_SESSION['nonce'];  // 세션에서 nonce 가져오기

require __DIR__ . '/../controllers/donate.php';

function login_neon_crm($apiKey, $orgID) {
    $loginEndpoint = "https://api.neoncrm.com/neonws/services/api/common/login";
    $url = $loginEndpoint . '?login.apiKey=' . urlencode($apiKey) . '&login.orgid=' . urlencode($orgID);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($response === false) {
        $error_msg = curl_error($ch);
        error_log('CURL error: ' . $error_msg);
        curl_close($ch);
        return null;
    }

    $response_data = json_decode($response, true);
    curl_close($ch);

    error_log('HTTP status code: ' . $http_code);
    error_log('Response: ' . json_encode($response_data));

    if (!isset($response_data['loginResponse']['userSessionId'])) {
        error_log('Session ID not found in response: ' . json_encode($response_data));
        return null;
    }

    return $response_data['loginResponse']['userSessionId'];
}

function create_neon_crm_account($userSessionId, $accountData) {
    $endpoint = 'https://api.neoncrm.com/neonws/services/api/account/createIndividualAccount';
    $queryParams = array(
        'responseType' => 'json',
        'userSessionId' => $userSessionId,
        'individualAccount.primaryContact.firstName' => $accountData['firstName'],
        'individualAccount.primaryContact.lastName' => $accountData['lastName'],
        'individualAccount.primaryContact.email1' => $accountData['email']
    );

    $url = $endpoint . '?' . http_build_query($queryParams);

    error_log('Account creation URL: ' . $url);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($response === false) {
        $error_msg = curl_error($ch);
        error_log('CURL error: ' . $error_msg);
        curl_close($ch);
        return null;
    }

    $response_data = json_decode($response, true);
    curl_close($ch);

    error_log('Account creation HTTP status code: ' . $http_code);
    error_log('Account creation response: ' . json_encode($response_data));

    if (!isset($response_data['createIndividualAccountResponse'])) {
        error_log('No createIndividualAccountResponse key found in response: ' . json_encode($response_data));
        return null;
    }

    if (!isset($response_data['createIndividualAccountResponse']['accountId'])) {
        error_log('Account ID not found in createIndividualAccountResponse: ' . json_encode($response_data['createIndividualAccountResponse']));
        return null;
    }

    return $response_data['createIndividualAccountResponse']['accountId'];
}

function create_neon_crm_donation($userSessionId, $accountId, $donationData) {
    $endpoint = 'https://api.neoncrm.com/neonws/services/api/donation/createDonation';
    $queryParams = array(
        'responseType' => 'json',
        'userSessionId' => $userSessionId,
        'donation.accountId' => $accountId,
        'donation.amount' => $donationData['amount'],
        'Payment.amount' => $donationData['amount'],
        'donation.date' => $donationData['date'],
        'Payment.tenderType.id' => $donationData['tenderTypeId'],
        'Payment.creditCardOnlinePayment.cardNumber' => $donationData['cardNumber'],
        'Payment.creditCardOnlinePayment.expirationMonth' => $donationData['expirationMonth'],
        'Payment.creditCardOnlinePayment.expirationYear' => $donationData['expirationYear'],
        'Payment.creditCardOnlinePayment.cardType.name' => $donationData['cardTypeName'],
        'Payment.creditCardOnlinePayment.CVV2' => $donationData['cvv'],
        'Payment.creditCardOnlinePayment.cardHolder' => $donationData['cardHolder']
    );

    $url = $endpoint . '?' . http_build_query($queryParams);

    error_log('Donation creation URL: ' . $url);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($response === false) {
        $error_msg = curl_error($ch);
        error_log('CURL error: ' . $error_msg);
        curl_close($ch);
        return null;
    }

    $response_data = json_decode($response, true);
    curl_close($ch);

    error_log('Donation creation HTTP status code: ' . $http_code);
    error_log('Donation creation response: ' . json_encode($response_data));

    if ($http_code != 200) {
        error_log('Failed to create donation: ' . json_encode($response_data));
        return null;
    }

    if (!isset($response_data['createDonation'])) {
        error_log('No createDonation key found in response: ' . json_encode($response_data));
        return null;
    }

    return $response_data['createDonation'];
}

$userSessionId = login_neon_crm($apiKey, $orgID);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    if ($amount === 'other') {
        $amount = $_POST['otherAmount'];
    }

    $jsToken = $_POST['jsToken'];

    $formData = array(
        'firstName' => $_POST['firstName'] ?? '',
        'lastName' => $_POST['lastName'] ?? '',
        'email' => $_POST['email'] ?? '',
        'amount' => $amount ?? '0',
        'date' => date('Y-m-d'),
        'tenderTypeId' => '4',
        'cardNumber' => $jsToken ?? '',
        'expirationMonth' => $_POST['expirationMonth'] ?? '',
        'expirationYear' => $_POST['expirationYear'] ?? '',
        'cardTypeName' => $_POST['cardTypeName'] ?? '',
        'cvv' => $_POST['cvv'] ?? '',
        'cardHolder' => ($_POST['cardHolderFirst'] ?? '') . ' ' . ($_POST['cardHolderLast'] ?? '')
    );

    error_log('Form Data: ' . json_encode($formData));

    // Check for essential data before proceeding
    if (empty($formData['firstName']) || empty($formData['lastName']) || empty($formData['email']) || empty($formData['amount']) || empty($formData['cardNumber'])) {
        error_log('Essential form data is missing.');
        $_SESSION['message'] = 'Some required fields are missing. Please fill out all required fields.';
        $_SESSION['message_type'] = 'error';
    } else {
        $accountId = create_neon_crm_account($userSessionId, $formData);

        if ($accountId) {
            error_log('Account ID: ' . $accountId);
            $donationData = array(
                'amount' => $formData['amount'],
                'date' => $formData['date'],
                'tenderTypeId' => $formData['tenderTypeId'],
                'cardNumber' => $formData['cardNumber'],
                'expirationMonth' => $formData['expirationMonth'],
                'expirationYear' => $formData['expirationYear'],
                'cardTypeName' => $formData['cardTypeName'],
                'cvv' => $formData['cvv'],
                'cardHolder' => $formData['cardHolder']
            );

            $donationResponse = create_neon_crm_donation($userSessionId, $accountId, $donationData);

            error_log('Donation Response: ' . json_encode($donationResponse));
            if ($donationResponse) {
                if (isset($donationResponse['transaction']['transactionStatus'])) {
                    if ($donationResponse['transaction']['transactionStatus'] === 'DECLINED') {
                        $_SESSION['message'] = 'Donation declined. Please check your payment details.';
                        $_SESSION['message_type'] = 'error';
                    } else {
                        $_SESSION['message'] = 'Donation created successfully!';
                        $_SESSION['message_type'] = 'success';
                    }
                } else {
                    error_log('Transaction status not found in donation response: ' . json_encode($donationResponse));
                    $_SESSION['message'] = 'Failed to create donation.';
                    $_SESSION['message_type'] = 'error';
                }
            } else {
                error_log('Donation response is null.');
                $_SESSION['message'] = 'Failed to create donation.';
                $_SESSION['message_type'] = 'error';
            }
        } else {
            $_SESSION['message'] = 'Failed to create or retrieve account.';
            $_SESSION['message_type'] = 'error';
        }
    }

    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit();
}

$message = '';
$message_type = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>
<?php snippet('header') ?>
 <!-- 스크립트에 Nonce 추가 -->
<script src="https://cdn.sbx.neononepay.com/3.0/neonpay.js" nonce="<?= $nonce ?>"></script>
<script nonce="<?= $nonce ?>">
    // 스크립트 로드 확인
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM fully loaded and parsed');
        console.log('Neonpay script loaded:', typeof Neonpay !== 'undefined');
    });
</script> 
<main>
    <?php snippet('hero') ?>
    <?php snippet('page-intro', ['landing' => false]) ?>
    <section class="content">
        <div class="blocks grid">
            <?php snippet('form-donate') ?>
            <div class="donation-description sidebar">
                <?= $page->blocks()->toBlocks() ?>
            </div> 
        </div>
    </section>
</main>
<?= js([
		'assets/js/form-donate.js',
		'@auto'
	]) ?>
<?php snippet('footer') ?>
