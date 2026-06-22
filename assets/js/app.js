// EduERP — Main JavaScript

// Sidebar toggle
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
}

// Modal functions
function openModal(id) {
    const m = document.getElementById(id);
    if (m) { m.classList.add('open'); document.body.style.overflow = 'hidden'; }
}
function closeModal(id) {
    const m = document.getElementById(id);
    if (m) { m.classList.remove('open'); document.body.style.overflow = ''; }
}

// Close modal on overlay click
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-overlay')) {
        e.target.classList.remove('open');
        document.body.style.overflow = '';
    }
});

// Toast notification
function showToast(msg) {
    let t = document.querySelector('.toast');
    if (!t) {
        t = document.createElement('div');
        t.className = 'toast';
        t.innerHTML = '<i class="fas fa-circle-check"></i><span></span>';
        document.body.appendChild(t);
    }
    t.querySelector('span').textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 3500);
}

// Animate KPI numbers on load
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.kpi-val').forEach(el => {
        const raw = el.textContent.trim();
        const num = parseFloat(raw.replace(/[^0-9.]/g,''));
        const suffix = raw.replace(/[0-9.]/g,'');
        if (!isNaN(num) && num > 0) {
            let cur = 0;
            const step = num / 40;
            const iv = setInterval(() => {
                cur = Math.min(cur + step, num);
                el.textContent = (Number.isInteger(num) ? Math.round(cur) : cur.toFixed(1)) + suffix;
                if (cur >= num) clearInterval(iv);
            }, 20);
        }
    });

    // Stagger fade-in for cards
    document.querySelectorAll('.kpi-card, .dash-card, .table-card, .day-card, .role-card, .ie-card').forEach((el, i) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(16px)';
        setTimeout(() => {
            el.style.transition = 'opacity .4s ease, transform .4s ease';
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, i * 60);
    });
});

// Active nav link
document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', function() {
        document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
        this.classList.add('active');
    });
});

// Keyboard: Escape closes modal
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay.open').forEach(m => {
            m.classList.remove('open');
            document.body.style.overflow = '';
        });
    }
});
