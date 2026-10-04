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

const faqForm = document.querySelector('[data-faq-form]');

if (faqForm) {
    const editor = faqForm.querySelector('[data-faq-editor]');
    const editorInput = faqForm.querySelector('[data-editor-input]');
    const submitButton = faqForm.querySelector('[data-faq-submit]');
    const initialValues = new FormData(faqForm);
    let submitted = false;

    editor.addEventListener('focus', () => {
        document.execCommand('defaultParagraphSeparator', false, 'p');
    });

    const syncEditor = () => {
        editorInput.value = editor.innerHTML;
    };

    const hasChanges = () => {
        syncEditor();
        const currentValues = new FormData(faqForm);

        for (const [key, value] of currentValues) {
            if (value !== initialValues.get(key)) {
                return true;
            }
        }

        return false;
    };

    faqForm.querySelectorAll('[data-editor-command]').forEach((button) => {
        button.addEventListener('mousedown', (event) => event.preventDefault());
        button.addEventListener('click', () => {
            editor.focus();
            document.execCommand(button.dataset.editorCommand, false);
            syncEditor();
        });
    });

    const linkButton = faqForm.querySelector('[data-editor-link]');
    linkButton.addEventListener('mousedown', (event) => event.preventDefault());
    linkButton.addEventListener('click', () => {
        const selection = window.getSelection();
        if (!selection || selection.isCollapsed || !editor.contains(selection.anchorNode)) {
            editor.focus();
            return;
        }

        const address = window.prompt('Masukkan alamat tautan http, https, atau tel:');
        if (address && /^(https?:\/\/|tel:)/i.test(address.trim())) {
            document.execCommand('createLink', false, address.trim());
            syncEditor();
        }
    });

    editor.addEventListener('paste', (event) => {
        event.preventDefault();
        document.execCommand('insertText', false, event.clipboardData.getData('text/plain'));
    });

    faqForm.addEventListener('submit', () => {
        syncEditor();
        submitted = true;
        submitButton.disabled = true;
        submitButton.textContent = 'Menyimpan...';
        faqForm.setAttribute('aria-busy', 'true');
    });

    faqForm.querySelector('[data-faq-cancel]').addEventListener('click', (event) => {
        if (hasChanges()) {
            if (!window.confirm('Perubahan belum disimpan. Kembali ke daftar FAQ?')) {
                event.preventDefault();
                return;
            }

            submitted = true;
        }
    });

    window.addEventListener('beforeunload', (event) => {
        if (!submitted && hasChanges()) {
            event.preventDefault();
        }
    });

    window.addEventListener('pageshow', () => {
        submitted = false;
        submitButton.disabled = false;
        submitButton.textContent = 'Simpan FAQ';
        faqForm.removeAttribute('aria-busy');
    });
}

const deleteDialog = document.querySelector('[data-delete-dialog]');

if (deleteDialog) {
    document.querySelectorAll('[data-delete-open]').forEach((button) => {
        button.addEventListener('click', () => {
            deleteDialog.querySelector('[data-delete-name]').textContent = button.dataset.deleteQuestion;
            deleteDialog.querySelector('[data-delete-form]').action = button.dataset.deleteAction;
            deleteDialog.showModal();
        });
    });

    deleteDialog.querySelector('[data-delete-cancel]').addEventListener('click', () => deleteDialog.close());
}
