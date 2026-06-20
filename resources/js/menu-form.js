export function initMenuFormPreview() {
    const input = document.getElementById('foto-menu');
    const preview = document.getElementById('foto-preview');
    const placeholder = document.getElementById('foto-placeholder');

    if (!input || !preview) {
        return;
    }

    input.addEventListener('change', (e) => {
        const file = e.target.files?.[0];

        if (!file) {
            return;
        }

        if (!file.type.startsWith('image/')) {
            alert('File harus berupa gambar (JPG, PNG, WebP).');
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = (ev) => {
            preview.src = ev.target.result;
            preview.classList.remove('hidden');
            placeholder?.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    });
}
