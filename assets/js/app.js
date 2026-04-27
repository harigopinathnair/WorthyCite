/**
 * Worthycite — Main JavaScript
 */

document.addEventListener('DOMContentLoaded', () => {
    initScrollAnimations();
    initMobileMenu();
    initFlashMessages();
    initDeleteConfirms();
    initTabs();
    initCharts();
});

// --- Scroll Animations ---
function initScrollAnimations() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.05 });

    document.querySelectorAll('.scroll-reveal').forEach((el) => {
        // Immediately reveal elements already in viewport on load
        const rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight && rect.bottom > 0) {
            el.classList.add('is-visible');
        } else {
            observer.observe(el);
        }
    });
}

// --- Mobile Menu ---
function initMobileMenu() {
    const toggle = document.querySelector('.mobile-toggle');
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.mobile-overlay');

    if (!toggle || !sidebar) return;

    toggle.addEventListener('click', () => {
        sidebar.classList.toggle('open');
        overlay?.classList.toggle('show');
    });

    overlay?.addEventListener('click', () => {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
    });
}

// --- Flash Messages ---
function initFlashMessages() {
    document.querySelectorAll('.flash-message').forEach(flash => {
        setTimeout(() => {
            flash.style.opacity = '0';
            flash.style.transform = 'translateY(-10px)';
            setTimeout(() => flash.remove(), 300);
        }, 5000);
    });
}

// --- Delete Confirmations ---
function initDeleteConfirms() {
    document.querySelectorAll('[data-confirm]').forEach(el => {
        el.addEventListener('click', (e) => {
            if (!confirm(el.dataset.confirm || 'Are you sure?')) {
                e.preventDefault();
            }
        });
    });
}

// --- Tabs ---
function initTabs() {
    const tabs = document.querySelectorAll('.tab-link');
    if (!tabs.length) return;

    tabs.forEach(tab => {
        tab.addEventListener('click', (e) => {
            e.preventDefault();
            const target = tab.dataset.tab;

            // Update active states
            document.querySelectorAll('.tab-link').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

            tab.classList.add('active');
            document.getElementById(target)?.classList.add('active');

            // Update URL
            const url = new URL(window.location);
            url.searchParams.set('tab', target);
            history.replaceState(null, '', url);
        });
    });
}

// --- Charts ---
function initCharts() {
    const chartCanvas = document.getElementById('backlinkChart');
    if (!chartCanvas || typeof Chart === 'undefined') return;

    const chartDataEl = document.getElementById('chartData');
    if (!chartDataEl) return;

    try {
        const chartData = JSON.parse(chartDataEl.textContent);

        const labels = chartData.map(d => {
            const [year, month] = d.month.split('-');
            const date = new Date(year, month - 1);
            return date.toLocaleDateString('en-US', { month: 'short', year: '2-digit' });
        });

        new Chart(chartCanvas, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Total',
                        data: chartData.map(d => d.total),
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2,
                        pointRadius: 4,
                        pointBackgroundColor: '#6366f1'
                    },
                    {
                        label: 'Active',
                        data: chartData.map(d => d.active),
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2,
                        pointRadius: 4,
                        pointBackgroundColor: '#10b981'
                    },
                    {
                        label: 'Lost',
                        data: chartData.map(d => d.lost),
                        borderColor: '#f43f5e',
                        backgroundColor: 'rgba(244, 63, 94, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2,
                        pointRadius: 4,
                        pointBackgroundColor: '#f43f5e'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: '#94a3b8',
                            font: { family: 'Inter', size: 12 },
                            padding: 16,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(99, 102, 241, 0.08)' },
                        ticks: { color: '#64748b', font: { family: 'Inter', size: 11 } }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(99, 102, 241, 0.08)' },
                        ticks: {
                            color: '#64748b',
                            font: { family: 'Inter', size: 11 },
                            stepSize: 1
                        }
                    }
                }
            }
        });
    } catch (e) {
        console.error('Chart init error:', e);
    }
}

// --- Mark Alert Read (AJAX) ---
function markAlertRead(alertId, csrf) {
    fetch(`${APP_URL}/alerts/${alertId}/read`, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: new URLSearchParams({ csrf_token: csrf })
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const item = document.querySelector(`[data-alert-id="${alertId}"]`);
                if (item) {
                    item.classList.remove('unread');
                    const badge = document.querySelector('.nav-badge');
                    if (badge) {
                        const count = parseInt(badge.textContent) - 1;
                        if (count <= 0) badge.remove();
                        else badge.textContent = count;
                    }
                }
            }
        });
}
