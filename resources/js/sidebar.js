let sidebarOpen = true;

window.toggleSidebar = function () {
    document.getElementById('sidebar').classList.toggle('collapsed', sidebarOpen);
    document.getElementById('main').classList.toggle('expanded', sidebarOpen);
    sidebarOpen = !sidebarOpen;
};

window.toggleGroup = function () {
    document.getElementById('masterHeader').classList.toggle('open');
    document.getElementById('masterMenu').classList.toggle('open');
};

// ── LOGOUT MODAL ──────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {

    // Inject modal HTML ke body
    const modal = document.createElement('div');
    modal.id = 'logoutModal';
    modal.innerHTML = `
        <div class="lm-backdrop"></div>
        <div class="lm-box">
            <div class="lm-icon">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#e74c3c" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
            </div>
            <h3 class="lm-title">Konfirmasi Logout</h3>
            <p class="lm-desc">Apakah Anda yakin ingin keluar dari sistem?</p>
            <div class="lm-actions">
                <button class="lm-btn-cancel" id="logoutCancel">Batal</button>
                <button class="lm-btn-confirm" id="logoutConfirm">Ya, Logout</button>
            </div>
        </div>
    `;

    // Inject CSS modal
    const style = document.createElement('style');
    style.textContent = `
        #logoutModal { display: none; position: fixed; inset: 0; z-index: 9999; align-items: center; justify-content: center; }
        #logoutModal.show { display: flex; }
        .lm-backdrop { position: absolute; inset: 0; background: rgba(0,0,0,0.45); backdrop-filter: blur(2px); }
        .lm-box {
            position: relative; background: white; border-radius: 16px;
            padding: 36px 32px 28px; width: 100%; max-width: 380px;
            text-align: center; box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            animation: lm-pop 0.2s ease;
        }
        @keyframes lm-pop { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        .lm-icon { margin-bottom: 16px; }
        .lm-title { font-size: 18px; font-weight: 700; color: #1e3a5f; margin-bottom: 8px; }
        .lm-desc { font-size: 14px; color: #6b7280; margin-bottom: 28px; line-height: 1.5; }
        .lm-actions { display: flex; gap: 12px; justify-content: center; }
        .lm-btn-cancel {
            padding: 10px 28px; border-radius: 8px; font-size: 14px; font-weight: 600;
            border: 1px solid #d1d5db; background: white; color: #374151; cursor: pointer;
        }
        .lm-btn-cancel:hover { background: #f9fafb; }
        .lm-btn-confirm {
            padding: 10px 28px; border-radius: 8px; font-size: 14px; font-weight: 600;
            border: none; background: #e74c3c; color: white; cursor: pointer;
        }
        .lm-btn-confirm:hover { background: #c0392b; }
    `;
    document.head.appendChild(style);
    document.body.appendChild(modal);

    // Cegat semua tombol logout
    document.querySelectorAll('.btn-logout').forEach(function (btn) {
        btn.type = 'button'; // cegah form submit langsung
        btn.addEventListener('click', function () {
            modal.classList.add('show');
        });
    });

    // Batal
    document.getElementById('logoutCancel').addEventListener('click', function () {
        modal.classList.remove('show');
    });

    // Backdrop click = batal
    modal.querySelector('.lm-backdrop').addEventListener('click', function () {
        modal.classList.remove('show');
    });

    // Konfirmasi → submit form logout
    document.getElementById('logoutConfirm').addEventListener('click', function () {
        const form = document.querySelector('form[action="/logout"]');
        if (form) form.submit();
    });
});
