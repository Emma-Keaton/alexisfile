function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.querySelector('.toggle-password i');
    
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      toggleIcon.classList.remove('fa-eye-slash');
      toggleIcon.classList.add('fa-eye');
    } else {
      passwordInput.type = 'password';
      toggleIcon.classList.remove('fa-eye');
      toggleIcon.classList.add('fa-eye-slash');
    }
  }
  
  function validateForm() {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    let valid = true;
  
    if (!validateEmail(email)) {
      document.getElementById('email-error').innerText = "Please enter a valid email address.";
      document.getElementById('email-error').style.display = "block";
      valid = false;
    } else {
      document.getElementById('email-error').style.display = "none";
    }
  
    if (password.length < 6) {
      document.getElementById('password-error').innerText = "Password must be at least 6 characters.";
      document.getElementById('password-error').style.display = "block";
      valid = false;
    } else {
      document.getElementById('password-error').style.display = "none";
    }
  
    return valid;
  }
  
  function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
  }
  