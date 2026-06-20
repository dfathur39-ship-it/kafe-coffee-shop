import './bootstrap';
import { initTheme } from './theme';
import { initMenuFormPreview } from './menu-form';

document.addEventListener('DOMContentLoaded', () => {
    initTheme();
    initMenuFormPreview();
});
