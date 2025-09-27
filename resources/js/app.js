import './bootstrap';

// Simple table filter for dashboard search
document.addEventListener('DOMContentLoaded', () => {
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
