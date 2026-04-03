<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Profil - Data Penjualan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --navy: #1e3a5f; --navy-hover: #2c4f7c; --navy-light: #e8edf3;
            --accent: #e74c3c; --accent-hover: #c0392b;
            --gold: #f39c12; --green: #27ae60;
            --sidebar-width: 240px; --topbar-height: 60px;
        }
        body { font-family: 'Segoe UI', Tahoma, Geneva, sans-serif; background: #f0f2f5; color: #222; }

        /* TOPBAR */
        .topbar {
            position: fixed; top: 0; left: 0; right: 0; height: var(--topbar-height);
            background: var(--navy); color: white; display: flex; align-items: center;
            justify-content: space-between; padding: 0 24px 0 16px; z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .hamburger { background: none; border: none; color: white; cursor: pointer; padding: 6px; border-radius: 6px; display: flex; flex-direction: column; gap: 4px; transition: background 0.2s; }
        .hamburger:hover { background: rgba(255,255,255,0.1); }
        .hamburger span { display: block; width: 20px; height: 2px; background: white; border-radius: 2px; }
        .topbar h1 { font-size: 17px; font-weight: 600; }
        .topbar-right { display: flex; align-items: center; gap: 14px; }
        .topbar-user { display: flex; align-items: center; gap: 10px; }
        .topbar-avatar { width: 34px; height: 34px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.4); flex-shrink: 0; }
        .user-info { text-align: right; }
        .user-info .name { font-weight: 600; font-size: 14px; }
        .user-badge { display: inline-block; font-size: 11px; padding: 2px 8px; border-radius: 10px; margin-top: 2px; }
        .badge-admin { background: var(--gold); color: #7a4c00; }
        .badge-user  { background: var(--green); color: #0f4d24; }
        .btn-logout { background: var(--accent); color: white; border: none; padding: 7px 14px; border-radius: 6px; cursor: pointer; font-size: 13px; transition: background 0.2s; }
        .btn-logout:hover { background: var(--accent-hover); }

        /* SIDEBAR */
        .sidebar {
            position: fixed; top: var(--topbar-height); left: 0; bottom: 0;
            width: var(--sidebar-width); background: white; border-right: 1px solid #dde3ec;
            overflow-y: auto; z-index: 90; transition: transform 0.25s ease; padding: 12px 0 24px;
        }
        .sidebar.collapsed { transform: translateX(calc(-1 * var(--sidebar-width))); }
        .sidebar-section { padding: 16px 14px 4px; font-size: 10px; font-weight: 700; letter-spacing: 1px; color: #aab; text-transform: uppercase; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 14px; color: #4a5568; text-decoration: none; font-size: 13.5px; transition: background 0.15s, color 0.15s; border: none; background: none; width: 100%; text-align: left; cursor: pointer; }
        .nav-item:hover { background: var(--navy-light); color: var(--navy); }
        .nav-item.active { background: var(--navy-light); color: var(--navy); font-weight: 600; border-left: 3px solid var(--navy); }
        .nav-icon { width: 18px; height: 18px; flex-shrink: 0; opacity: 0.75; }
        .nav-item.active .nav-icon, .nav-item:hover .nav-icon { opacity: 1; }
        .nav-badge { margin-left: auto; font-size: 10px; padding: 1px 6px; border-radius: 8px; background: #fff3cd; color: #7a4c00; font-weight: 600; }
        .divider { height: 1px; background: #eef0f4; margin: 8px 14px; }
        .group-header { display: flex; align-items: center; gap: 10px; padding: 10px 14px; color: #4a5568; font-size: 13.5px; cursor: pointer; transition: background 0.15s; user-select: none; }
        .group-header:hover { background: var(--navy-light); color: var(--navy); }
        .chevron { margin-left: auto; width: 14px; height: 14px; transition: transform 0.2s; opacity: 0.5; }
        .group-header.open .chevron { transform: rotate(90deg); }
        .sub-menu { display: none; background: #f8f9fb; }
        .sub-menu.open { display: block; }
        .sub-item { display: flex; align-items: center; gap: 8px; padding: 8px 14px 8px 40px; color: #4a5568; text-decoration: none; font-size: 13px; transition: background 0.15s; }
        .sub-item:hover { background: var(--navy-light); color: var(--navy); }
        .sub-item::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: #cbd5e0; flex-shrink: 0; }

        /* MAIN */
        .main { margin-top: var(--topbar-height); margin-left: var(--sidebar-width); padding: 32px 28px; transition: margin-left 0.25s ease; }
        .main.expanded { margin-left: 0; }

        /* BREADCRUMB */
        .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #6b7280; margin-bottom: 20px; }
        .breadcrumb a { color: var(--navy); text-decoration: none; }
        .breadcrumb a:hover { text-decoration: underline; }

        /* ALERT */
        .alert-success { background: #d4edda; color: #155724; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
        .alert-error   { background: #f8d7da; color: #721c24; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }

        /* PROFILE LAYOUT */
        .profile-layout {
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 24px;
            align-items: start;
        }

        /* FOTO CARD (kiri) */
        .foto-card {
            background: white; border-radius: 12px; padding: 28px 20px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.07); border: 1px solid #eef0f4;
            text-align: center;
        }
        .foto-wrapper {
            width: 120px; height: 120px; border-radius: 50%;
            margin: 0 auto 16px; position: relative; cursor: pointer;
            overflow: hidden; border: 3px solid var(--navy-light);
            transition: border-color 0.2s;
        }
        .foto-wrapper:hover { border-color: var(--navy); }
        .foto-wrapper img {
            width: 100%; height: 100%; object-fit: cover;
        }
        .foto-overlay {
            position: absolute; inset: 0; background: rgba(30,58,95,0.55);
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            opacity: 0; transition: opacity 0.2s; color: white; font-size: 12px; gap: 4px;
        }
        .foto-wrapper:hover .foto-overlay { opacity: 1; }
        .foto-overlay svg { width: 22px; height: 22px; }
        .foto-name { font-size: 16px; font-weight: 700; color: var(--navy); margin-bottom: 4px; }
        .foto-role {
            display: inline-block; font-size: 12px; padding: 3px 10px; border-radius: 10px; margin-bottom: 16px;
        }
        .foto-email { font-size: 12.5px; color: #6b7280; word-break: break-all; margin-bottom: 20px; }
        .foto-hint { font-size: 11px; color: #a0aec0; margin-top: 8px; }
        .btn-upload {
            width: 100%; background: var(--navy-light); color: var(--navy);
            border: 1px dashed var(--navy); padding: 9px; border-radius: 8px;
            font-size: 13px; font-weight: 600; cursor: pointer; transition: background 0.2s;
        }
        .btn-upload:hover { background: #d4dce8; }

        /* FORM CARD (kanan) */
        .form-card { background: white; border-radius: 12px; padding: 28px 28px; box-shadow: 0 1px 4px rgba(0,0,0,0.07); border: 1px solid #eef0f4; }
        .form-section-title { font-size: 15px; font-weight: 600; color: var(--navy); margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid #f0f0f0; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
        .form-row.full { grid-template-columns: 1fr; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group label { font-size: 13px; font-weight: 600; color: #374151; }
        .form-group input {
            padding: 9px 12px; border: 1px solid #d1d5db; border-radius: 8px;
            font-size: 13.5px; outline: none; font-family: inherit; transition: border-color 0.15s;
        }
        .form-group input:focus { border-color: var(--navy); }
        .form-group input:disabled { background: #f9fafb; color: #9ca3af; cursor: not-allowed; }
        .error-msg { font-size: 12px; color: #dc2626; }
        .form-hint { font-size: 11px; color: #9ca3af; }

        .section-divider { border: none; border-top: 1px solid #f0f0f0; margin: 20px 0; }

        .form-actions { display: flex; gap: 12px; margin-top: 20px; }
        .btn-submit { background: var(--navy); color: white; border: none; padding: 10px 24px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: background 0.2s; }
        .btn-submit:hover { background: var(--navy-hover); }

        @media (max-width: 900px) {
            .profile-layout { grid-template-columns: 1fr; }
            .foto-card { max-width: 320px; margin: 0 auto; }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(calc(-1 * var(--sidebar-width))); }
            .main { margin-left: 0; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

{{-- TOPBAR --}}
<nav class="topbar">
    <div class="topbar-left">
        <button class="hamburger" onclick="toggleSidebar()"><span></span><span></span><span></span></button>
        <h1>SIM Lab</h1>
    </div>
    <div class="topbar-right">
        <div class="topbar-user">
            <div class="user-info">
                <div class="name">{{ Auth::user()->name }}</div>
                <div class="user-badge {{ Auth::user()->isAdmin() ? 'badge-admin' : 'badge-user' }}">
                    {{ Auth::user()->isAdmin() ? 'Admin' : 'User' }}
                </div>
            </div>
            @if(Auth::user()->foto)
                <img src="{{ asset('storage/foto/' . Auth::user()->foto) }}" class="topbar-avatar" alt="Foto">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=2c4f7c&color=fff&size=34" class="topbar-avatar" alt="Foto">
            @endif
        </div>
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </div>
</nav>

{{-- SIDEBAR --}}
<aside class="sidebar" id="sidebar">
    <div class="sidebar-section">Menu Utama</div>
    <a href="/dashboard" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
            <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
        </svg>Dashboard
    </a>
    <a href="/barang" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
        </svg>Data Barang
    </a>
    <a href="/pinjam" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
            <polyline points="12 6 12 12 16 14"/>
        </svg>Pinjam Barang
    </a>
    <div class="divider"></div>
    <div class="sidebar-section">Master Data</div>
    <div class="group-header" id="masterHeader" onclick="toggleGroup()">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/>
            <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>
        </svg>
        Master Data
        <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polyline points="9 18 15 12 9 6"/>
        </svg>
    </div>
    <div class="sub-menu" id="masterMenu">
        <a href="/master/kategori" class="sub-item">Kategori Barang</a>
        <a href="/master/satuan" class="sub-item">Satuan</a>
        <a href="/master/lokasi" class="sub-item">Lokasi</a>
    </div>
    <div class="divider"></div>
    <div class="sidebar-section">Akun</div>
    <a href="/profile" class="nav-item active">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
        </svg>Kelola Profile
    </a>
    @if(Auth::user()->isAdmin())
    <div class="divider"></div>
    <div class="sidebar-section">Admin</div>
    <a href="/barang/create" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>Input Barang <span class="nav-badge">Admin</span>
    </a>
    <a href="/admin/opname" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
        </svg>Opname Barang <span class="nav-badge">Admin</span>
    </a>
    <a href="/admin/users" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>Kelola User <span class="nav-badge">Admin</span>
    </a>
    @endif
</aside>

{{-- MAIN --}}
<main class="main" id="main">

    <div class="breadcrumb">
        <a href="/dashboard">Dashboard</a> / <span>Kelola Profil</span>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    <div class="profile-layout">

        {{-- KIRI: Foto Profil --}}
        <div class="foto-card">
            <form method="POST" action="/profile/foto" enctype="multipart/form-data" id="fotoForm">
                @csrf
                @method('PUT')
                <div class="foto-wrapper" onclick="document.getElementById('fotoInput').click()">
                    @if(Auth::user()->foto)
                        <img src="{{ asset('storage/foto/' . Auth::user()->foto) }}" alt="Foto Profil" id="fotoPreview">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1e3a5f&color=fff&size=120" alt="Foto Profil" id="fotoPreview">
                    @endif
                    <div class="foto-overlay">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                            <circle cx="12" cy="13" r="4"/>
                        </svg>
                        Ganti Foto
                    </div>
                </div>
                <input type="file" id="fotoInput" name="foto" accept="image/*" style="display:none" onchange="previewFoto(this)">

                <div class="foto-name">{{ Auth::user()->name }}</div>
                <div class="foto-role {{ Auth::user()->isAdmin() ? 'badge-admin' : 'badge-user' }}" style="display:inline-block;font-size:12px;padding:3px 10px;border-radius:10px;margin-bottom:16px;">
                    {{ Auth::user()->isAdmin() ? 'Admin' : 'User' }}
                </div>
                <div class="foto-email">{{ Auth::user()->email }}</div>

                <button type="submit" class="btn-upload" id="btnSaveFoto" style="display:none">
                    Simpan Foto
                </button>
                <p class="foto-hint">Klik foto untuk mengganti.<br>Format: JPG, PNG. Maks 2MB.</p>
            </form>
        </div>

        {{-- KANAN: Form Data Diri & Password --}}
        <div>
            {{-- Form Data Diri --}}
            <div class="form-card" style="margin-bottom:24px;">
                <div class="form-section-title">Data Diri</div>
                <form method="POST" action="/profile">
                    @csrf
                    @method('PUT')

                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" placeholder="Nama lengkap">
                            @error('name') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" placeholder="Email">
                            @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-row full">
                        <div class="form-group">
                            <label>Role</label>
                            <input type="text" value="{{ Auth::user()->isAdmin() ? 'Admin' : 'User' }}" disabled>
                            <span class="form-hint">Role tidak dapat diubah sendiri.</span>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

            {{-- Form Ganti Password --}}
            <div class="form-card">
                <div class="form-section-title">Ganti Password</div>
                <form method="POST" action="/profile/password">
                    @csrf
                    @method('PUT')

                    <div class="form-row full">
                        <div class="form-group">
                            <label>Password Lama</label>
                            <input type="password" name="current_password" placeholder="Masukkan password lama">
                            @error('current_password') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password" name="password" placeholder="Min. 6 karakter">
                            @error('password') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit">Ganti Password</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</main>

@vite(['resources/js/app.js'])
<script>
    function previewFoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('fotoPreview').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
            document.getElementById('btnSaveFoto').style.display = 'block';
        }
    }
</script>

</body>
</html>
