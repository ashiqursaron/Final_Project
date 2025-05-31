// loginError= document.getElementById("loginError")
/*=============== SHOW HIDE PASSWORD LOGIN ===============*/
const passwordAccess = (loginPass, loginEye) => {
   const input = document.getElementById(loginPass),
         iconEye = document.getElementById(loginEye);

   iconEye.addEventListener('click', () => {
      input.type === 'password' ? input.type = 'text' : input.type = 'password';
      iconEye.classList.toggle('ri-eye-fill');
      iconEye.classList.toggle('ri-eye-off-fill');
   });
};
passwordAccess('password', 'loginPassword');

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
   console.log('Form submitted'); // Debugging log

   // Allow form submission to loginCheck.php for server-side validation
});

// /*=============== LOGIN FORM VALIDATION ===============*/
// const loginForm = document.getElementById('loginForm');
// const usernameInput = document.getElementById('username');
// const passwordInput = document.getElementById('password');
// const loginError = document.getElementById('loginError');

// loginForm.addEventListener('submit', function (e) {
//     e.preventDefault(); // Prevent default form submission

//     loginError.classList.remove('active');
//     usernameInput.classList.remove('error');
//     passwordInput.classList.remove('error');
//     loginError.textContent = '';

//     // Check for empty fields
//     let valid = true;
//     if (!usernameInput.value.trim()) {
//         usernameInput.classList.add('error');
//         loginError.textContent = 'Please enter your username.';
//         valid = false;
//     }
//     if (!passwordInput.value.trim()) {
//         passwordInput.classList.add('error');
//         loginError.textContent = 'Please enter your password.';
//         valid = false;
//     }
//     if (!valid) {
//         loginError.classList.add('active');
//         return;
//     }

//     // Submit the form via AJAX
//     const formData = new FormData(loginForm);
//     fetch('../controller/loginCheck.php', {
//         method: 'POST',
//         body: formData,
//     })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 // Redirect to the appropriate page
//                 window.location.href = data.redirect;
//             } else {
//                 // Show error message
//                 loginError.textContent = data.message;
//                 loginError.classList.add('active');
//             }
//         })
//         .catch(error => {
//             console.error('Error:', error);
//             loginError.textContent = 'An error occurred. Please try again.';
//             loginError.classList.add('active');
//         });
// });