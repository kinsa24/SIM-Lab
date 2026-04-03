document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('loginForm');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const toggleBtn = document.getElementById('togglePassword');
    const btnLogin = document.getElementById('btnLogin');
    const alert = document.getElementById('alertBox');

    // Toggle show/hide password
    toggleBtn.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        this.innerHTML = type === 'text'
            ? `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-5 0-9-4-9-7s4-7 9-7a9.96 9.96 0 016.072 2.05M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/></svg>`
            : `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>`;
    });

    // Validate email format
    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    // Show field error
    function showError(input, message) {
        input.classList.add('error');
        const errorEl = input.closest('.form-group').querySelector('.error-message');
        if (errorEl) {
            errorEl.textContent = message;
            errorEl.style.display = 'block';
        }
    }

    // Clear field error
    function clearError(input) {
        input.classList.remove('error');
        const errorEl = input.closest('.form-group').querySelector('.error-message');
        if (errorEl) errorEl.style.display = 'none';
    }

    emailInput.addEventListener('input', () => clearError(emailInput));
    passwordInput.addEventListener('input', () => clearError(passwordInput));

    // Form submit
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        let valid = true;
        alert.style.display = 'none';

        if (!emailInput.value.trim()) {
            showError(emailInput, 'Email tidak boleh kosong.');
            valid = false;
        } else if (!isValidEmail(emailInput.value.trim())) {
            showError(emailInput, 'Format email tidak valid.');
            valid = false;
        }

        if (!passwordInput.value.trim()) {
            showError(passwordInput, 'Password tidak boleh kosong.');
            valid = false;
        } else if (passwordInput.value.length < 6) {
            showError(passwordInput, 'Password minimal 6 karakter.');
            valid = false;
        }

        if (!valid) return;

        // Simulate loading
        btnLogin.classList.add('loading');

        setTimeout(() => {
            btnLogin.classList.remove('loading');
            // Submit form ke server
            form.submit();
        }, 1500);
    });

});
