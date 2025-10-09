<?php
// 세션이 시작되어 있지 않은 경우에만 시작
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // 세션 초기화
}

// 세션 변수가 없는 경우에 대한 예외 처리
$nonce = isset($_SESSION['nonce']) ? $_SESSION['nonce'] : '';

$message = ''; // 메시지 초기화
$message_type = ''; // 메시지 타입 초기화

// var_dump($_SESSION['nonce']);

?>
<!--donation form starts-->
<div class="donation-form">
    <ul class="donation-steps">
        <li class="current">Select Amount</li>
        <li>Your Information</li>
        <li>Payment Details</li>
    </ul>
    <form id="neon-donate" method="POST" action="">
        <div class="step-1">
            <p>Choose the amount of your tax-deductible Credit Card  or ACH/E-Check Donation.</p>
            <div id="donation-type-group">
                <div class="donation-type">
                    <label class="once"><input type="radio" name="donation-type" value="1" checked>Donate Once</label>
                </div>
                <div class="donation-type recurring">
                    <label class="recurring"><input type="radio" name="donation-type" value="2">Donate Monthly</label>
                </div>
            </div>
            <div id="amount-group">
                <label class="btn-nofill"><input type="radio" name="amount" value="50">$50</label>
                <label class="btn-nofill"><input type="radio" name="amount" value="250">$250</label>
                <label class="btn-nofill"><input type="radio" name="amount" value="1000">$1,000</label>
                <label class="btn-nofill"><input type="radio" name="amount" value="10000">$10,000</label>
                <label class="text"><input name="other-amount" type="text" id="other-amount" placeholder="Other amount"></label>
            </div>
            <div id="amount-group-recurring" class="hide">
                <label class="btn-nofill"><input type="radio" name="amount" value="10">$10</label>
                <label class="btn-nofill"><input type="radio" name="amount" value="50">$50</label>
                <label class="btn-nofill"><input type="radio" name="amount" value="1000">$100</label>
                <label class="btn-nofill"><input type="radio" name="amount" value="10000">$500</label>
                <label class="text"><input name="other-amount" type="text" id="other-amount-recurring" placeholder="Other amount"></label>
            </div>
            <div class="donation-options">
                <label class="checkbox"><input type="checkbox" name="memory" id="memory-checkbox"><span>Dedicate my gift in honor or in memory of someone</span></label>
                <div id="memory">
                    <div class="memory-type">
                        <label class="radio"><input type="radio" name="memory-type" value="1" checked><span>Honor</span></label>
                        <label class="radio"><input type="radio" name="memory-type" value="2"><span>Memory</span></label>
                    </div>
                    <label class="memory-name"><span>Tribute Name</span><input name="memory-name" type="text"></label>
                    <label class="checkbox"><input type="checkbox" name="acknowledgment"><span>I would like to send an acknowledgment for this tribute.</span></label>
                </div>
                <label class="checkbox"><input type="checkbox" name="anonymous"><span>Make my gift anonymous</span></label>
            </div>
        </div>
        <div class="step-2">
            <label class="col-2"><span>First Name</span><input id="first-name-donate" name="firstName" type="text" required></label>
            <label class="col-2"><span>Last Name</span><input id="last-name-donate" name="lastName" type="text" required></label>
            <label class="checkbox company"><input type="checkbox" name="work"><span>Submit as a company or organization</span></label>
            <label><span>Company Name</span><input name="company" type="text"></label>
            <label><span>Email</span><input id="email-donate" name="email" type="email" required></label>
            <label class="checkbox opt-out"><input type="checkbox" checked name="opt-out" id="opt-out-checkbox"><span>I agree to receiving newsletters</span></label>
            <label><span>Phone</span><input name="phone" type="text" required></label>
            <label><span>Address Line 1</span><input name="address-1" type="text" required></label>
            <label><span>Address Line 2</span><input name="address-2" type="text"></label>
            <label class="col-2"><span>City</span><input name="city" type="text" required></label>
            <label class="col-2"><span>State/Province</span><input name="state" type="text" required></label>
            <label class="col-2"><span>Zip/Postal Code</span><input name="zip" type="text" required></label>
            <label class="col-2"><span>Country</span><input name="country" type="text" required></label>
        </div>
        <div class="step-3">
            <div id="payment-type-group">
                <div class="payment-type">
                    <label class="card"><input type="radio" name="payment-type" value="1" checked>Card</label>
                </div>
                <div class="payment-type ach">
                    <label class="ach"><input type="radio" name="payment-type" value="2">ACH</label>
                </div>
            </div>
            <div id="payment-type-card">
                <label><span>Card Number</span><input id="cardNumber" name="cardNumber" type="text" required></label>
                <label class="col-1"><span>Expiration Month</span><input id="expirationMonth" name="expirationMonth" type="text" placeholder="MM" required></label>
                <label class="col-1"><span>Expiration Year</span><input id="expirationYear" name="expirationYear" type="text" placeholder="YY" required></label>
                <label class="col-1"><span>CVV</span><input id="cvv" name="cvv" type="text" placeholder="CVV" required></label>
                <label class="col-2"><span>Card Holder First Name</span><input id="cardHolderFirst" name="cardHolderFirst" type="text" required></label>
                <label class="col-2"><span>Card Holder Last Name</span><input id="cardHolderLast" name="cardHolderLast" type="text" required></label>
            </div>
            <div id="payment-type-ach">
                <label class="col-2"><span>Bank Account Holder's First Name</span><input id="BankdHolderFirst" type="text"></label>
                <label class="col-2"><span>Bank Account Holder's Last Name</span><input id="BankHolderLast" type="text"></label>
                <label><span>Bank Account Holder's Email</span><input id="BankHolderemail" type="email"></label>
                <label>Bank Account Type
                    <select name="accountType" id="accountType">
                        <option value="checking">Checking</option>
                        <option value="saving">Saving</option>
                    </select>
                </label>
                <label class="col-1">Expiration Month <input id="expirationMonth" type="text"></label>
                <label class="col-1">Expiration Year <input id="expirationYear" type="text"></label>
                <label class="col-1">CVV <input id="cvv" type="text"></label>
            </div>
        </div>
        <input type="hidden" name="jsToken" id="jsToken">
        <input type="hidden" name="amount" id="amount">
        <button type="submit" class="btn btn-page">Donate</button>
        <div class="message">
            <?php if ($message): ?>
                <span class="<?php echo $message_type; ?>"><?php echo $message; ?></span>
            <?php endif; ?>
        </div>
        <div class="step-4">
            <h2>$<span class="DonateAmount"></span></h2>
            <h2>Thank you for supporting  Freedom Reads!</h2>
            <p><span class="ConstituentFirstName"></span>, your gift today will help people in prison confront what prison does to the spirit and imagine new possibilities for themselves. A receipt was sent to your email address at <span class="ConstituentEmail"></span>.</p>
        </div>
    </form>
</div>

<!-- <script nonce="<?= htmlentities($nonce) ?>">

document.addEventListener('DOMContentLoaded', function() {
   
});
</script> -->
<!--donation form ends-->
