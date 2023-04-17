const hide_sign_in = document.getElementById('hide_sign_in');
const hide_sign_up = document.getElementById('hide_sign_up');

hide_sign_in.addEventListener('click', () => {
    const signInForm = document.getElementById('sign_in_form');
    signInForm.classList.add('hide');
    const signUpForm = document.getElementById('sign_up_form');
    signUpForm.classList.remove('hide');
});

hide_sign_up.addEventListener('click', () => {
    const signInForm = document.getElementById('sign_in_form');
    signInForm.classList.remove('hide');
    const signUpForm = document.getElementById('sign_up_form');
    signUpForm.classList.add('hide');
});