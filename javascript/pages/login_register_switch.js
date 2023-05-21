const { func } = require("prop-types");

const form = document.querySelector('form');
const h2 = document.querySelector('h2'); 
const emailInput = document.querySelector('[name=email]');
const nameInput = document.querySelector('[name=name]');
const usernameInput = document.querySelector('[name=username]');
const passwordInput = document.querySelector('[name=password]');
const confirmPasswordInput = document.querySelector('[name=confirm-password]');
const submitButton = document.querySelector('[type=submit]');
const requirements_list = document.querySelector('[class=requirements-todo-list');
const match_passwords = document.querySelector('[class=match-passwords]');
const paragraph = document.querySelector('p');
var state = 0;
const switchState = document.getElementById('switch-state');
emailInput.required = false;
nameInput.required = false;
usernameInput.required = true;
passwordInput.required = true;
confirmPasswordInput.required = false;
const password_min_length_icon = document.getElementById('password_min_length_icon');
const password_lowercase_icon = document.getElementById('password_lowercase_icon');
const password_uppercase_icon = document.getElementById('password_uppercase_icon');
const password_number_icon = document.getElementById('password_number_icon');
const password_special_icon = document.getElementById('password_special_icon');

window.onload = function() {
  let popup = document.getElementById('wrong-credentials');
  popup.style.display = "none";
}

switchState.addEventListener('click', () => {
    switch (state) {
        case 0:
            state = 1;
            form.setAttribute('action', '../actions/action_sign_up.php');
            form.onsubmit = matchPassword;
            if (requirements_list.hasAttribute('hidden') === false) requirements_list.toggleAttribute('hidden');  
            h2.textContent = "Register";
            emailInput.toggleAttribute('hidden');
            nameInput.toggleAttribute('hidden');
            confirmPasswordInput.toggleAttribute('hidden');
            emailInput.required = true;
            emailInput.value = "";
            nameInput.required = true;
            nameInput.value = "";
            usernameInput.required = true;
            usernameInput.value = "";
            passwordInput.required = true;
            passwordInput.value = "";
            confirmPasswordInput.required = true;
            confirmPasswordInput.value = "";
            submitButton.textContent = "Register";
            paragraph.textContent = "Already have an account?";
            switchState.textContent = "Login";
            break;
        case 1:
            state = 0;
            form.setAttribute('action', '../actions/action_login.php');
            form.onsubmit = null;
            if (requirements_list.hasAttribute('hidden') === false) requirements_list.toggleAttribute('hidden');  
            h2.textContent = "Login";
            emailInput.toggleAttribute('hidden');
            nameInput.toggleAttribute('hidden');
            confirmPasswordInput.toggleAttribute('hidden');
            emailInput.required = false;
            nameInput.required = false;
            usernameInput.required = true;
            usernameInput.value = "";
            passwordInput.required = true;
            passwordInput.value = "";
            confirmPasswordInput.required = false;
            submitButton.textContent = "Login";
            paragraph.textContent = "Don't have an account yet?";
            switchState.textContent = "Register";
            break;
    }
});


function incrementSeconds(seconds){
  seconds += 1;
  return seconds;
}

function matchPassword() {  
    var pw1 = document.getElementById("password").value;  
    var pw2 = document.getElementById("confirm-password").value;
    if(pw1 !== pw2)  
    {   
      //alert("Passwords do not match");
      return false;
    } else {  
      return true;
    }  
  }

  passwordInput.addEventListener('input', () => {
    if (state === 1){

      if (passwordInput.value.length == 0){
        requirements_list.toggleAttribute('hidden');
      }
      else if (requirements_list.getAttribute('hidden') == false && passwordInput.value.length > 0){
        requirements_list.toggleAttribute('hidden');
      }
  

      if (passwordInput.value.length >= 8){
        password_min_length_icon.className = "fa-solid fa-check";
      }
      else{
        if (password_min_length_icon.className == "fa-solid fa-check"){
          password_min_length_icon.className = "fa fa-info-circle";
        }
      }

      if (passwordInput.value.match(/[a-z]/)){
        password_lowercase_icon.className = "fa-solid fa-check";
      }
      else{
        if(password_lowercase_icon.className == "fa-solid fa-check"){
          password_lowercase_icon.className = "fa fa-info-circle";
        }
      }
      if (passwordInput.value.match(/[A-Z]/)){
        password_uppercase_icon.className = "fa-solid fa-check";
      }
      else{
        if(password_uppercase_icon.className == "fa-solid fa-check"){
          password_uppercase_icon.className = "fa fa-info-circle";
        }
      }
      if (passwordInput.value.match(/[0-9]/)){
        password_number_icon.className = "fa-solid fa-check";
      }
      else{
        if(password_number_icon.className == "fa-solid fa-check"){
          password_number_icon.className = "fa fa-info-circle";
        }
      }
      if (passwordInput.value.match(/[!@#$%^&*]/)){
        password_special_icon.className = "fa-solid fa-check";
      }
      else{
        if(password_special_icon.className == "fa-solid fa-check"){
          password_special_icon.className = "fa fa-info-circle";
        }
      }

      if (passwordInput.value.length > 8 && passwordInput.value.match(/[a-z]/) && passwordInput.value.match(/[A-Z]/) && passwordInput.value.match(/[0-9]/) && passwordInput.value.match(/[!@#$%^&*]/)){
        submitButton.toggleAttribute('disabled');
      }
      else{
        if (submitButton.hasAttribute('disabled') == false){
          submitButton.toggleAttribute('disabled');
        }
      }

    }

  });

  confirmPasswordInput.addEventListener('input', () => {
    if (state === 1){
      if (confirmPasswordInput.value.length == 0){
        match_passwords.toggleAttribute('hidden');
      }
      else if (match_passwords.getAttribute('hidden') == false && confirmPasswordInput.value.length > 0){
        match_passwords.toggleAttribute('hidden');
      }
      if (passwordInput.value === confirmPasswordInput.value){
        submitButton.toggleAttribute('disabled');
        match_passwords.toggleAttribute('hidden');
      }
      else{
        if (submitButton.hasAttribute('disabled') == false){
          submitButton.toggleAttribute('disabled');
        }
      }
    }
  });

