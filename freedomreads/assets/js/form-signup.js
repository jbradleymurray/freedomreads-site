
const signupData = {};
const signupResults = {
	'responses' : {},
	'error' : ''
};

document.addEventListener('DOMContentLoaded', function() {
	setupSignup();
});

function setupSignup(){
	const forms = document.querySelectorAll('[id^="signup-form-"]');//get this from submission

	// console.log(`📝 Found ${forms.length} signup forms`);

	forms.forEach((form, index) => {
		// console.log(`🧾 Attaching handler to form #${index + 1}:`, form);

	const message = form.querySelector('.message');

	form.addEventListener('submit', function(event) {
		event.preventDefault();
		let honeypot = document.getElementById('emailTextField');
		if( honeypot.value.length ){
			return false;
		}else{
			submitSignup( form );
		}		
	});

	const emailField = form.querySelector('.signup_emailfield');

	emailField.addEventListener('input', function(){
		document.querySelectorAll('.signup_emailconfirm').forEach( el=>{
				el.innerText = this.value;
		});
	});
});
}


function submitSignup( form ) {
	const postParams = new URLSearchParams({
		target: 'signup'
	});
	const postUrl = `/proxy.php?${postParams}`;
	const submissionData = new FormData( form );
	
	fetch(postUrl, {
		method: 'POST',
		body: submissionData
	})
	.then(async response => {
		if (!response.ok) {
			throw new Error('Network response was not ok');
		}
		let json = await response.json();
		// console.log('Final response:', json);

		if (json.httpcode === 200) {
			form.dataset.status = 'success';
		
			// ✅ Check if warning exists
			if (json.warning) {
				const unsubEl = form.querySelector('.message-unsubscribed');
				if (unsubEl) {
					unsubEl.style.display = 'block';
				}
				form.querySelector('.message-success').style.display = 'none';
				form.querySelector('.message-errors').style.display = 'none';
		
				// console.log('⚠️ Unsubscribe warning:', json.warning);
			} else {
				form.querySelector('.message-success').style.display = 'block';
				form.querySelector('.message-errors').style.display = 'none';
				form.querySelector('.message-unsubscribed').style.display = 'none';
			}
		} else {
			form.dataset.status = 'error';
			form.querySelector('.message-success').style.display = 'none';
			form.querySelector('.message-unsubscribed').style.display = 'none';
			form.querySelector('.message-errors').style.display = 'block';
		}	
	})
	.catch(error => {
		console.error('Error:', error);
		form.dataset.status = 'error';
	});
}
