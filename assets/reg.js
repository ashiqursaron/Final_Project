/*=============== SHOW HIDE PASSWORD LOGIN ===============*/
const passwordAccess = (loginPass, loginEye) =>{
   const input = document.getElementById(loginPass),
         iconEye = document.getElementById(loginEye)

   iconEye.addEventListener('click', () =>{
      input.type === 'password' ? input.type = 'text'
                                      : input.type = 'password'
      iconEye.classList.toggle('ri-eye-fill')
      iconEye.classList.toggle('ri-eye-off-fill')
   })
}
passwordAccess('password','loginPassword')

/*=============== LOGIN FORM VALIDATION ===============*/
const loginForm = document.getElementById('loginForm');
const usernameInput = document.getElementById('username');
const passwordInput = document.getElementById('password');
const loginError = document.getElementById('loginError');

loginForm.addEventListener('submit', function(e) {
   let valid = true;
   loginError.classList.remove('active');
   usernameInput.classList.remove('error');
   passwordInput.classList.remove('error');
   loginError.textContent = '';

   // Check for empty fields
   if (!usernameInput.value.trim()) {
      usernameInput.classList.add('error');
      loginError.textContent = 'Please enter your username.';
      valid = false;
   }
   if (!passwordInput.value.trim()) {
      passwordInput.classList.add('error');
      loginError.textContent = 'Please enter your password.';
      valid = false;
   }
   if (!valid) {
      loginError.classList.add('active');
      e.preventDefault();
      return;
   }

   // Check for correct credentials
   if (usernameInput.value !== 'saron' || passwordInput.value !== 'saron') {
      usernameInput.classList.add('error');
      passwordInput.classList.add('error');
      loginError.textContent = 'Invalid username or password.';
      loginError.classList.add('active');
      e.preventDefault();
      return;
   }

   // If everything is correct, form will submit to login_check.php
});