<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang - Sistem Informasi Manajemen Laboratorium</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --navy: #1e3a5f; --navy-hover: #2c4f7c; --navy-light: #e8edf3;
            --accent: #e74c3c; --accent-hover: #c0392b;
            --gold: #f39c12; --green: #27ae60;
            --sidebar-width: 240px; --topbar-height: 60px;
        }
        body { font-family: 'Segoe UI', Tahoma, Geneva, sans-serif; background: #f0f2f5; color: #222; }
        .topbar {
            position: fixed; top: 0; left: 0; right: 0; height: var(--topbar-height);
            background: var(--navy); color: white; display: flex; align-items: center;
            justify-content: space-between; padding: 0 24px 0 16px; z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .hamburger { background: none; border: none; color: white; cursor: pointer; padding: 6px; border-radius: 6px; display: flex; flex-direction: column; gap: 4px; }
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
        .btn-logout { background: var(--accent); color: white; border: none; padding: 7px 14px; border-radius: 6px; cursor: pointer; font-size: 13px; }
        .sidebar {
            position: fixed; top: var(--topbar-height); left: 0; bottom: 0;
            width: var(--sidebar-width); background: white; border-right: 1px solid #dde3ec;
            overflow-y: auto; z-index: 90; transition: transform 0.25s ease; padding: 12px 0 24px;
        }
        .sidebar.collapsed { transform: translateX(calc(-1 * var(--sidebar-width))); }
        .sidebar-section { padding: 16px 14px 4px; font-size: 10px; font-weight: 700; letter-spacing: 1px; color: #aab; text-transform: uppercase; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 14px; color: #4a5568; text-decoration: none; font-size: 13.5px; transition: background 0.15s; border: none; background: none; width: 100%; text-align: left; cursor: pointer; }
        .nav-item:hover { background: var(--navy-light); color: var(--navy); }
        .nav-item.active { background: var(--navy-light); color: var(--navy); font-weight: 600; border-left: 3px solid var(--navy); }
        .nav-icon { width: 18px; height: 18px; flex-shrink: 0; opacity: 0.75; }
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
        .main { margin-top: var(--topbar-height); margin-left: var(--sidebar-width); padding: 32px 28px; transition: margin-left 0.25s ease; }
        .main.expanded { margin-left: 0; }

        /* BREADCRUMB */
        .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #6b7280; margin-bottom: 20px; }
        .breadcrumb a { color: var(--navy); text-decoration: none; }
        .breadcrumb a:hover { text-decoration: underline; }

        /* FORM CARD */
        .form-card { background: white; border-radius: 12px; padding: 28px 32px; max-width: 700px; box-shadow: 0 1px 4px rgba(0,0,0,0.07); border: 1px solid #eef0f4; }
        .form-card-title { font-size: 16px; font-weight: 600; color: var(--navy); margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #f0f0f0; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
        .form-row.full { grid-template-columns: 1fr; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group label { font-size: 13px; font-weight: 600; color: #374151; }
        .form-group input, .form-group select, .form-group textarea {
            padding: 9px 12px; border: 1px solid #d1d5db; border-radius: 8px;
            font-size: 13.5px; outline: none; font-family: inherit; color: #222;
            transition: border-color 0.15s;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: var(--navy); }
        .form-group textarea { resize: vertical; min-height: 80px; }
        .error-msg { font-size: 12px; color: #dc2626; margin-top: 2px; }
        .form-hint { font-size: 11px; color: #9ca3af; margin-top: 2px; }

        .form-actions { display: flex; gap: 12px; margin-top: 24px; padding-top: 20px; border-top: 1px solid #f0f0f0; }
        .btn-submit { background: var(--navy); color: white; border: none; padding: 10px 24px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; }
        .btn-submit:hover { background: var(--navy-hover); }
        .btn-cancel { background: white; color: #6b7280; border: 1px solid #d1d5db; padding: 10px 24px; border-radius: 8px; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center; }
        .btn-cancel:hover { background: #f9fafb; }

        @media (max-width: 600px) { .form-row { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

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
    <a href="/profile" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
        </svg>Kelola Profile
    </a>

    @if(Auth::user()->isAdmin())
    <div class="divider"></div>
    <div class="sidebar-section">Admin</div>
    <a href="/barang/create" class="nav-item active">
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

<main class="main" id="main">
    <div class="breadcrumb">
        <a href="/dashboard">Dashboard</a> /
        <a href="/barang">Data Barang</a> /
        <span>Tambah Barang</span>
    </div>

    <div class="form-card">
        <div class="form-card-title">Tambah Barang Baru</div>

        <form method="POST" action="/barang">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label>Kode Barang <span style="color:#dc2626">*</span></label>
                    <input type="text" name="kode" value="{{ old('kode') }}" placeholder="Contoh: BRG-001">
                    @error('kode') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Nama Barang <span style="color:#dc2626">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama lengkap barang">
                    @error('nama') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Kategori</label>
                    <input type="text" name="kategori" value="{{ old('kategori') }}" placeholder="Contoh: Elektronik, Alat Tulis">
                </div>
                <div class="form-group">
                    <label>Satuan</label>
                    <input type="text" name="satuan" value="{{ old('satuan') }}" placeholder="Contoh: Pcs, Kg, Liter">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Stok Awal <span style="color:#dc2626">*</span></label>
                    <input type="number" name="stok" value="{{ old('stok', 0) }}" min="0">
                    @error('stok') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Stok Minimum</label>
                    <input type="number" name="stok_min" value="{{ old('stok_min', 5) }}" min="0">
                    <span class="form-hint">Batas stok sebelum dianggap menipis</span>
                </div>
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" placeholder="Deskripsi atau keterangan barang (opsional)">{{ old('keterangan') }}</textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Simpan Barang</button>
                <a href="/barang" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</main>

@vite(['resources/js/app.js'])
</body>
</html>
