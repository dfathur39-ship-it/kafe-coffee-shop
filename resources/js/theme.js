const STORAGE_KEY = 'kafe-theme';

export function getTheme() {
    return localStorage.getItem(STORAGE_KEY) || 'light';
}

export function applyTheme(theme) {
    document.documentElement.classList.toggle('dark', theme === 'dark');
    syncToggleIcons(theme);
}

export function setTheme(theme) {
    localStorage.setItem(STORAGE_KEY, theme);
    applyTheme(theme);
}

function syncToggleIcons(theme) {
    document.querySelectorAll('[data-theme-icon-light]').forEach((el) => {
        el.classList.toggle('hidden', theme === 'dark');
    });
    document.querySelectorAll('[data-theme-icon-dark]').forEach((el) => {
        el.classList.toggle('hidden', theme === 'light');
    });
}

export function initTheme() {
    applyTheme(getTheme());

    document.querySelectorAll('[data-theme-toggle]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const next = document.documentElement.classList.contains('dark') ? 'light' : 'dark';
            setTheme(next);
        });
    });
}
