// Toggle password visibility for register page
function togglePassword() {
    const input = document.getElementById('password');
    const button = input.parentElement.querySelector('.toggle-password');
    const icon = button.querySelector('i');
    const text = button.querySelector('span');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
        text.textContent = 'Show';
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
        text.textContent = 'Hide';
    }
}

// Toggle password visibility for login page
function togglePasswordLogin() {
    const input = document.getElementById('login-password');
    const button = input.parentElement.querySelector('.toggle-password');
    const icon = button.querySelector('i');
    const text = button.querySelector('span');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
        text.textContent = 'Show';
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
        text.textContent = 'Hide';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // KHÔNG chặn submit nữa; form sẽ gửi thật về PHP
    console.log('[adminbtl] script.js loaded (demo submit disabled)');
    return;
});

