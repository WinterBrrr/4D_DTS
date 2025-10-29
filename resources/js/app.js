import './bootstrap';
import Alpine from 'alpinejs';

// Initialize Alpine.js for interactive UI behaviors (x-data, x-show, etc.)
window.Alpine = Alpine;
Alpine.start();

// Simple table filter for dashboard search
document.addEventListener('DOMContentLoaded', () => {
    // Theme toggle
    const toggle = document.getElementById('theme-toggle');
    if (toggle) {
        const updateIcons = () => {
            const isDark = document.documentElement.classList.contains('dark');
            toggle.querySelector('.sun')?.classList.toggle('hidden', isDark);
            toggle.querySelector('.moon')?.classList.toggle('hidden', !isDark);
        };
        updateIcons();
        toggle.addEventListener('click', () => {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateIcons();
        });
    }

    // Replace header brand text ("DTS") with your logo, if available
    try {
        const header = document.querySelector('header.sticky');
        if (header) {
            const brandLink = header.querySelector('a.flex.items-center.space-x-2');
            if (brandLink) {
                // If a logo image exists at /images/logo.png, swap the brand contents
                const testImg = new Image();
                testImg.onload = () => {
                    // Clear existing SVG/text
                    brandLink.innerHTML = '';
                    const img = document.createElement('img');
                    img.src = '/images/logo.png';
                    img.alt = 'DTS Logo';
                    img.width = 32; // adjust size if you want bigger/smaller
                    img.height = 32;
                    img.className = 'rounded-full shadow-sm';
                    brandLink.appendChild(img);
                };
                testImg.onerror = () => { /* leave default brand if logo not found */ };
                testImg.src = '/images/logo.png';
            }

            // Dynamically set favicon to the same logo if link[rel="icon"] exists
            const favicon = document.querySelector('link[rel="icon"]');
            if (favicon) {
                fetch('/images/logo.png', { method: 'HEAD' }).then(res => {
                    if (res.ok) favicon.href = '/images/logo.png';
                }).catch(() => {});
            }
        }
    } catch (_) {}

    const searchInput = document.getElementById('doc-search');
    if (!searchInput) return;

    const table = document.querySelector(searchInput.getAttribute('data-target'));
    if (!table) return;
    const tbody = table.querySelector('tbody');
    if (!tbody) return;

    const filterRows = () => {
        const q = (searchInput.value || '').toLowerCase().trim();
        for (const row of tbody.querySelectorAll('tr')) {
            const text = row.textContent?.toLowerCase() ?? '';
            row.style.display = text.includes(q) ? '' : 'none';
        }
    };

    searchInput.addEventListener('input', filterRows);
});
