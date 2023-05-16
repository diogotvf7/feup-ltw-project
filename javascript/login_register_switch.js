const form = document.querySelector('form');
const h2 = document.querySelector('h2'); 
const emailInput = document.querySelector('[name=email]');
const nameInput = document.querySelector('[name=name]');
const usernameInput = document.querySelector('[name=username]');
const passwordInput = document.querySelector('[name=password]');
const confirmPasswordInput = document.querySelector('[name=confirm-password]');
const submitButton = document.querySelector('[type=submit]');
const paragraph = document.querySelector('p');
var state = 0;
const switchState = document.getElementById('switch-state');
emailInput.required = false;
nameInput.required = false;
usernameInput.required = true;
passwordInput.required = true;
confirmPasswordInput.required = false;

switchState.addEventListener('click', () => {
    switch (state) {
        case 0:
            state = 1;
            form.setAttribute('action', '../actions/action_sign_up.php');
            form.onsubmit = matchPassword;
            h2.textContent = "Register";
            emailInput.toggleAttribute('hidden');
            nameInput.toggleAttribute('hidden');
            confirmPasswordInput.toggleAttribute('hidden');
            emailInput.required = true;
            nameInput.required = true;
            usernameInput.required = true;
            passwordInput.required = true;
            confirmPasswordInput.required = true;
            submitButton.textContent = "Register";
            paragraph.textContent = "Already have an account?";
            switchState.textContent = "Login";
            break;
        case 1:
            state = 0;
            form.setAttribute('action', '../actions/action_login.php');
            form.onsubmit = null;
            h2.textContent = "Login";
            emailInput.toggleAttribute('hidden');
            nameInput.toggleAttribute('hidden');
            confirmPasswordInput.toggleAttribute('hidden');
            emailInput.required = false;
            nameInput.required = false;
            usernameInput.required = true;
            passwordInput.required = true;
            confirmPasswordInput.required = false;
            submitButton.textContent = "Login";
            paragraph.textContent = "Don't have an account yet?";
            switchState.textContent = "Register";
            break;
    }
});


function matchPassword() {  
    var pw1 = document.getElementById("password").value;  
    var pw2 = document.getElementById("confirm-password").value;
    if(pw1 !== pw2)  
    {   
      alert("Passwords do not match");
        return false;
    } else {  
      alert("Passwords match");  
      return true;
    }  
  }

  function validatePassword() {
    const password = document.getElementById("password").value;
    const pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    if (pattern.test(password)) {
      console.log("Valid password");

    } else {
      console.log("Invalid password");
  }
}