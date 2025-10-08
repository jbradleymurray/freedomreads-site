<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if (empty($_SESSION['nonce'])) {
  $_SESSION['nonce'] = bin2hex(random_bytes(16));
}
$nonce = $_SESSION['nonce'];
// var_dump($_SESSION['nonce']);

?>
<?php
$form_id = isset($form_id) ? $form_id : 'default-form-id';
?>
<?php $signup = $site->index()->find('newsletter-signup'); ?>

<?php if (str_starts_with($form_id, 'block-')): ?>
  <!-- Skip headline for block-based form -->
<?php else: ?>
  <h3><?= $signup->headcopy() ?></h3>
<?php endif ?>


<form id="signup-form-<?= $form_id; ?>" method="POST" data-status=""> 
<input type="hidden" name="nonce" value="<?= $nonce ?>">
<input type="hidden" name="form_id" value="<?= $form_id ?>">

	<fieldset class="grid-form">
    <div class="field span3 required">
      <!-- <label for="firstName">First Name</label> -->
      <input type="text" id="firstName" name="firstName" placeholder="First Name" required>  
    </div>
    <div class="field span3 required">
      <!-- <label for="firstName">Last Name</label> -->
      <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>
    </div>
    <div class="field required">
      <!-- <label for="firstName">Email</label> -->
      <input class="signup_emailfield" type="email" id="email" name="email" placeholder="Email" required>
    </div>

    <div aria-hidden="true" class="inputTextField">
      <input type="text" id="emailTextField" name="inputTextField" tabindex="-1" value="" autocomplete="off">
    </div>
    <div class="field">
      <button type="submit" class="btn-nofill"  id="subscribe-<?= $form_id; ?>">Subscribe</button>
    </div>
	</fieldset>
  <div class="message">
  	<p class="message-success"><?= $signup->messagesuccess()->kirbytextinline() ?> <span class="signup_emailconfirm"></span>. </p> 
    <p class="message-errors"><?= $signup->messageerror()->kirbytextinline() ?></p>
    <p class="message-unsubscribed"><?= $signup->messageunsubscribed()->kirbytextinline() ?></p>
  </div>
  <figcaption class="caption">
    <?= $signup->messageprivacy()->kirbytext() ?>
  </figcaption>
</form>
<!-- <script>
  document.addEventListener('DOMContentLoaded', () => {

    const signupform = document.querySelector('[id^="signup-form-"]');
  if (!signupform) {
    console.warn('Signup form not found');
    return;
  }

  signupform.addEventListener('submit', async function(e) {
    
      e.preventDefault();
      console.log('Form submission triggered ✅');


      const form = e.target;
      const formData = new FormData(form);
      const payload = new URLSearchParams(formData);

      try {
        const res = await fetch('/proxy.php?target=signup', {
          method: 'POST',
          body: payload
        });

        const raw = await res.text(); //  raw response
        console.log('Raw response:', raw); // ✅ debug
       

        // const data = await res.json();
        // console.log('Full response:', data);
        let data;
        try {
          data = JSON.parse(raw);
          console.log('Parsed response:', data);
        } catch (err) {
          console.error('Failed to parse response:', err);
          return;
        }

        if (typeof data.warning !== 'undefined') {
  console.log('⚠️ Response warning:', data.warning);
}

        if (data.httpcode === 200 || data.account) {
          form.dataset.status = 'success';
          
          // Check if opted out
          if (data.warning) {
            document.querySelector('.message-success').style.display = 'none';
            document.querySelector('.message-errors').style.display = 'none';

            const unsubEl = document.querySelector('.message-unsubscribed');
            if (unsubEl) {
              unsubEl.textContent = data.warning;
              unsubEl.style.display = 'block';
            }

            console.log('Response warning:', data.warning);
          } else {
            document.querySelector('.message-success').style.display = 'block';
            document.querySelector('.message-errors').style.display = 'none';
            document.querySelector('.message-unsubscribed').style.display = 'none';

            document.querySelector('.signup_emailconfirm').textContent = form.email.value;
          }
        } else {
          throw new Error('Signup failed');
        }
      } catch (err) {
        form.dataset.status = 'error';
        document.querySelector('.message-success').style.display = 'none';
        document.querySelector('.message-unsubscribed').style.display = 'none';
        document.querySelector('.message-errors').style.display = 'block';
      }
    });
  });
</script> -->
