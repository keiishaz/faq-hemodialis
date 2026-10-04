const adminLoginForm = document.querySelector('[data-admin-login-form]');

if (adminLoginForm) {
    const submitButton = adminLoginForm.querySelector('[data-login-submit]');

    adminLoginForm.addEventListener('submit', () => {
        submitButton.disabled = true;
        submitButton.textContent = 'Memproses...';
        adminLoginForm.setAttribute('aria-busy', 'true');
    });

    window.addEventListener('pageshow', () => {
        submitButton.disabled = false;
        submitButton.textContent = 'Masuk';
        adminLoginForm.removeAttribute('aria-busy');
    });
}
