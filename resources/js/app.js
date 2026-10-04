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

const publicFaqList = document.querySelector('[data-public-faq-list]');
let resetPublicFaqList = null;

if (publicFaqList) {
    const searchInput = publicFaqList.querySelector('[data-faq-search]');
    const clearButton = publicFaqList.querySelector('[data-search-clear]');
    const emptyClearButton = publicFaqList.querySelector('[data-empty-search-clear]');
    const itemsContainer = publicFaqList.querySelector('[data-faq-items]');
    const noResults = publicFaqList.querySelector('[data-faq-no-results]');
    const items = [...publicFaqList.querySelectorAll('[data-faq-item]')];

    const closeAccordion = (item) => {
        item.querySelector('[data-faq-toggle]').setAttribute('aria-expanded', 'false');
        item.querySelector('[data-faq-panel]').hidden = true;
        item.querySelector('[data-faq-indicator]').textContent = '+';
    };

    const updateSearch = () => {
        const query = searchInput.value.trim().toLowerCase();
        let visibleCount = 0;

        items.forEach((item) => {
            closeAccordion(item);

            const question = item.querySelector('[data-faq-question]').textContent;
            const shortAnswer = item.querySelector('[data-faq-short-answer]').textContent;
            const matches = `${question} ${shortAnswer}`.toLowerCase().includes(query);

            item.hidden = !matches;
            visibleCount += Number(matches);
        });

        clearButton.hidden = query === '' || visibleCount === 0;
        noResults.hidden = visibleCount !== 0;
        itemsContainer.hidden = visibleCount === 0;
    };

    const clearSearch = () => {
        searchInput.value = '';
        updateSearch();
        searchInput.focus();
    };

    resetPublicFaqList = () => {
        searchInput.value = '';
        updateSearch();
    };

    items.forEach((item) => {
        item.querySelector('[data-faq-toggle]').addEventListener('click', () => {
            const toggle = item.querySelector('[data-faq-toggle]');
            const shouldOpen = toggle.getAttribute('aria-expanded') === 'false';

            items.forEach(closeAccordion);

            if (shouldOpen) {
                toggle.setAttribute('aria-expanded', 'true');
                item.querySelector('[data-faq-panel]').hidden = false;
                item.querySelector('[data-faq-indicator]').textContent = '-';
            }
        });
    });

    searchInput.addEventListener('input', updateSearch);
    clearButton.addEventListener('click', clearSearch);
    emptyClearButton.addEventListener('click', clearSearch);
}

const publicPage = document.querySelector('[data-public-page]');

if (publicPage) {
    const idleDuration = 60_000;
    let lastActivityAt = Date.now();
    let timerId = null;
    let listeners = null;
    let isReset = false;
    let ignoreScroll = false;

    const resetPage = () => {
        clearTimeout(timerId);
        timerId = null;

        if (publicPage.dataset.publicPageType !== 'list') {
            window.location.replace(publicPage.dataset.publicIndexUrl);
            return;
        }

        isReset = true;
        ignoreScroll = true;
        resetPublicFaqList?.();
        publicPage.querySelectorAll('dialog[open]').forEach((dialog) => dialog.close());

        if (publicPage.contains(document.activeElement)) {
            document.activeElement.blur();
        }

        window.scrollTo(0, 0);
    };

    const checkIdle = () => {
        if (isReset) {
            return;
        }

        const remaining = idleDuration - (Date.now() - lastActivityAt);

        if (remaining <= 0) {
            resetPage();
            return;
        }

        clearTimeout(timerId);
        timerId = setTimeout(checkIdle, remaining);
    };

    const recordActivity = () => {
        isReset = false;
        ignoreScroll = false;
        lastActivityAt = Date.now();
        checkIdle();
    };

    const recordScroll = () => {
        if (!ignoreScroll) {
            recordActivity();
        }
    };

    const startListening = () => {
        if (listeners) {
            return;
        }

        listeners = new AbortController();
        const options = { signal: listeners.signal };

        window.addEventListener('pointerdown', recordActivity, options);
        window.addEventListener('input', recordActivity, options);
        window.addEventListener('keydown', recordActivity, options);
        window.addEventListener('wheel', recordActivity, { ...options, passive: true });
        document.addEventListener('scroll', recordScroll, { ...options, capture: true, passive: true });
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden) {
                checkIdle();
            }
        }, options);

        checkIdle();
    };

    window.addEventListener('pagehide', () => {
        listeners?.abort();
        listeners = null;
        clearTimeout(timerId);
        timerId = null;
    });

    window.addEventListener('pageshow', () => {
        startListening();

        if (!document.hidden) {
            checkIdle();
        }
    });

    startListening();
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

const reorderList = document.querySelector('[data-reorder-list][data-reorder-url]');

if (reorderList) {
    const handles = [...reorderList.querySelectorAll('[data-sort-handle]')];
    const feedback = document.querySelector('[data-reorder-feedback]');
    const reloadButton = document.querySelector('[data-reorder-reload]');
    let saving = false;
    let drag = null;

    const items = () => [...reorderList.querySelectorAll('[data-sort-item]')];
    const currentIds = () => items().map((item) => Number(item.dataset.sortId));

    const restoreOrder = (ids) => {
        const byId = new Map(items().map((item) => [Number(item.dataset.sortId), item]));
        ids.forEach((id) => reorderList.appendChild(byId.get(id)));
    };

    const setSaving = (value) => {
        saving = value;
        reorderList.setAttribute('aria-busy', String(value));
        handles.forEach((handle) => { handle.disabled = value; });
    };

    const saveOrder = async (previousIds) => {
        const ids = currentIds();
        if (ids.every((id, index) => id === previousIds[index])) {
            return;
        }

        setSaving(true);
        feedback.textContent = 'Menyimpan urutan...';
        reloadButton.hidden = true;

        try {
            const response = await fetch(reorderList.dataset.reorderUrl, {
                method: 'PUT',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': reorderList.dataset.reorderToken,
                },
                body: JSON.stringify({ ids, snapshot: reorderList.dataset.reorderSnapshot }),
            });

            if (response.status === 401 || response.status === 419) {
                window.location.assign(reorderList.dataset.loginUrl);
                return;
            }

            if (!response.ok) {
                if (response.status === 409) {
                    throw new Error('Daftar FAQ berubah. Muat ulang sebelum mengurutkan.');
                }

                throw new Error('Urutan gagal disimpan. Posisi dikembalikan.');
            }

            const result = await response.json();
            reorderList.dataset.reorderSnapshot = result.snapshot;
            feedback.textContent = 'Urutan FAQ tersimpan.';
        } catch (error) {
            restoreOrder(previousIds);
            feedback.textContent = error.message;
            reloadButton.hidden = false;
        } finally {
            setSaving(false);
        }
    };

    reloadButton.addEventListener('click', () => window.location.reload());

    handles.forEach((handle) => {
        const item = handle.closest('[data-sort-item]');

        handle.addEventListener('keydown', (event) => {
            if (saving || !['ArrowUp', 'ArrowDown'].includes(event.key)) {
                return;
            }

            event.preventDefault();
            const neighbor = event.key === 'ArrowUp' ? item.previousElementSibling : item.nextElementSibling;
            if (!neighbor) {
                return;
            }

            const previousIds = currentIds();
            reorderList.insertBefore(item, event.key === 'ArrowUp' ? neighbor : neighbor.nextElementSibling);
            saveOrder(previousIds);
        });

        handle.addEventListener('pointerdown', (event) => {
            if (saving || event.button !== 0 || !event.isPrimary) {
                return;
            }

            handle.focus();
            handle.setPointerCapture(event.pointerId);
            drag = { item, target: null, after: false, previousIds: currentIds() };
            item.classList.add('is-dragging');
            event.preventDefault();
        });

        handle.addEventListener('pointermove', (event) => {
            if (!drag || !handle.hasPointerCapture(event.pointerId)) {
                return;
            }

            const target = document.elementFromPoint(event.clientX, event.clientY)?.closest('[data-sort-item]');
            items().forEach((candidate) => candidate.classList.remove('is-drop-target'));

            if (target && target !== item && reorderList.contains(target)) {
                drag.target = target;
                drag.after = event.clientY >= target.getBoundingClientRect().top + target.getBoundingClientRect().height / 2;
                target.classList.add('is-drop-target');
            } else {
                drag.target = null;
            }
        });

        const endDrag = (commit) => {
            if (!drag) {
                return;
            }

            const { target, after, previousIds } = drag;
            item.classList.remove('is-dragging');
            items().forEach((candidate) => candidate.classList.remove('is-drop-target'));
            drag = null;

            if (commit && target) {
                reorderList.insertBefore(item, after ? target.nextElementSibling : target);
                saveOrder(previousIds);
            }
        };

        handle.addEventListener('pointerup', () => endDrag(true));
        handle.addEventListener('pointercancel', () => endDrag(false));
    });
}
