<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Data Penjualan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --navy: #1e3a5f;
            --navy-hover: #2c4f7c;
            --navy-light: #e8edf3;
            --accent: #e74c3c;
            --accent-hover: #c0392b;
            --gold: #f39c12;
            --green: #27ae60;
            --sidebar-width: 240px;
            --topbar-height: 60px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, sans-serif;
            background: #f0f2f5;
            color: #222;
        }

        /* ─── TOPBAR ─── */
        .topbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: var(--topbar-height);
            background: var(--navy);
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px 0 16px;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .hamburger {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 6px;
            border-radius: 6px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            transition: background 0.2s;
        }
        .hamburger:hover { background: rgba(255,255,255,0.1); }
        .hamburger span {
            display: block;
            width: 20px;
            height: 2px;
            background: white;
            border-radius: 2px;
        }

        .topbar h1 {
            font-size: 17px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .topbar-user { display: flex; align-items: center; gap: 10px; }
        .topbar-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            object-fit: cover; border: 2px solid rgba(255,255,255,0.4);
            flex-shrink: 0;
        }
        .user-info { text-align: right; }
        .user-info .name { font-weight: 600; font-size: 14px; }
        .user-badge {
            display: inline-block;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 10px;
            margin-top: 2px;
        }
        .badge-admin { background: var(--gold); color: #7a4c00; }
        .badge-user  { background: var(--green); color: #0f4d24; }

        .btn-logout {
            background: var(--accent);
            color: white;
            border: none;
            padding: 7px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            transition: background 0.2s;
        }
        .btn-logout:hover { background: var(--accent-hover); }

        /* ─── SIDEBAR ─── */
        .sidebar {
            position: fixed;
            top: var(--topbar-height);
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: white;
            border-right: 1px solid #dde3ec;
            overflow-y: auto;
            z-index: 90;
            transition: transform 0.25s ease;
            padding: 12px 0 24px;
        }

        .sidebar.collapsed {
            transform: translateX(calc(-1 * var(--sidebar-width)));
        }

        .sidebar-section {
            padding: 16px 14px 4px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #aab;
            text-transform: uppercase;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            color: #4a5568;
            text-decoration: none;
            font-size: 13.5px;
            border-radius: 0;
            transition: background 0.15s, color 0.15s;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }
        .nav-item:hover { background: var(--navy-light); color: var(--navy); }
        .nav-item.active {
            background: var(--navy-light);
            color: var(--navy);
            font-weight: 600;
            border-left: 3px solid var(--navy);
        }

        .nav-icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            opacity: 0.75;
        }
        .nav-item.active .nav-icon,
        .nav-item:hover .nav-icon { opacity: 1; }

        .nav-badge {
            margin-left: auto;
            font-size: 10px;
            padding: 1px 6px;
            border-radius: 8px;
            background: #fff3cd;
            color: #7a4c00;
            font-weight: 600;
        }

        /* Master Data collapsible group */
        .group-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            color: #4a5568;
            font-size: 13.5px;
            cursor: pointer;
            transition: background 0.15s;
            user-select: none;
        }
        .group-header:hover { background: var(--navy-light); color: var(--navy); }

        .chevron {
            margin-left: auto;
            width: 14px;
            height: 14px;
            transition: transform 0.2s;
            opacity: 0.5;
        }
        .group-header.open .chevron { transform: rotate(90deg); }

        .sub-menu {
            display: none;
            background: #f8f9fb;
        }
        .sub-menu.open { display: block; }

        .sub-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px 8px 40px;
            color: #4a5568;
            text-decoration: none;
            font-size: 13px;
            transition: background 0.15s, color 0.15s;
        }
        .sub-item:hover { background: var(--navy-light); color: var(--navy); }
        .sub-item::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #cbd5e0;
            flex-shrink: 0;
        }

        .divider {
            height: 1px;
            background: #eef0f4;
            margin: 8px 14px;
        }

        /* ─── MAIN CONTENT ─── */
        .main {
            margin-top: var(--topbar-height);
            margin-left: var(--sidebar-width);
            padding: 32px 28px;
            min-height: calc(100vh - var(--topbar-height));
            transition: margin-left 0.25s ease;
        }

        .main.expanded { margin-left: 0; }

        .welcome {
            font-size: 20px;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 6px;
        }

        .welcome-sub {
            font-size: 13px;
            color: #718096;
            margin-bottom: 28px;
        }

        /* ─── STAT CARDS ─── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px 22px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.07);
            border: 1px solid #eef0f4;
        }

        .stat-label {
            font-size: 12px;
            font-weight: 600;
            color: #a0aec0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--navy);
            line-height: 1;
        }

        .stat-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }
        .stat-icon.blue  { background: #dbeafe; }
        .stat-icon.amber { background: #fef3c7; }
        .stat-icon.green { background: #d1fae5; }
        .stat-icon.red   { background: #fee2e2; }

        /* ─── OPNAME ALERT ─── */
        .opname-alert {
            background: white;
            border: 1px solid #fde68a;
            border-left: 4px solid var(--gold);
            border-radius: 10px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
        }
        .opname-alert .alert-title {
            font-size: 13px;
            font-weight: 600;
            color: #92400e;
        }
        .opname-alert .alert-sub {
            font-size: 12px;
            color: #b45309;
            margin-top: 2px;
        }
        .opname-alert a {
            margin-left: auto;
            font-size: 12px;
            color: var(--navy);
            text-decoration: none;
            white-space: nowrap;
            font-weight: 600;
            border: 1px solid var(--navy);
            padding: 5px 12px;
            border-radius: 6px;
        }
        .opname-alert a:hover { background: var(--navy-light); }

        /* ─── QUICK ACCESS ─── */
        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: #a0aec0;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        .quick-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 12px;
        }

        .quick-card {
            background: white;
            border-radius: 10px;
            padding: 16px;
            text-decoration: none;
            color: var(--navy);
            border: 1px solid #eef0f4;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: box-shadow 0.2s, transform 0.15s;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
        .quick-card:hover {
            box-shadow: 0 4px 12px rgba(30,58,95,0.12);
            transform: translateY(-2px);
        }
        .quick-card .qc-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .quick-card .qc-label {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--navy);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(calc(-1 * var(--sidebar-width))); }
            .sidebar.mobile-open { transform: translateX(0); }
            .main { margin-left: 0; }
        }
    </style>
</head>
<body>

{{-- ─── TOPBAR ─── --}}
<nav class="topbar">
    <div class="topbar-left">
        <button class="hamburger" onclick="toggleSidebar()" title="Toggle menu">
            <span></span><span></span><span></span>
        </button>
        <h1>Sistem Inventaris</h1>
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

{{-- ─── SIDEBAR ─── --}}
<aside class="sidebar" id="sidebar">

    <div class="sidebar-section">Menu Utama</div>

    <a href="/dashboard" class="nav-item active">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
            <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
        </svg>
        Dashboard
    </a>

    <a href="/barang" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
        </svg>
        Data Barang
    </a>

    <a href="/pinjam" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
            <polyline points="12 6 12 12 16 14"/>
        </svg>
        Pinjam Barang
    </a>

    <div class="divider"></div>
    <div class="sidebar-section">Master Data</div>

    {{-- Collapsible Master Data --}}
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
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
        </svg>
        Kelola Profile
    </a>

    {{-- Admin-only section --}}
    @if(Auth::user()->isAdmin())
    <div class="divider"></div>
    <div class="sidebar-section">Admin</div>

    <a href="/barang/create" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Input Barang
        <span class="nav-badge">Admin</span>
    </a>

    <a href="/admin/opname" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
        </svg>
        Opname Barang
        <span class="nav-badge">Admin</span>
    </a>

    <a href="/admin/users" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
        Kelola User
        <span class="nav-badge">Admin</span>
    </a>
    @endif

</aside>

{{-- ─── MAIN CONTENT ─── --}}
<main class="main" id="main">

    <div class="welcome">Selamat datang, {{ Auth::user()->name }}!</div>
    <div class="welcome-sub">Berikut ringkasan data inventaris hari ini.</div>

    {{-- Stat Cards --}}
    <div class="stat-grid">
        @if(Auth::user()->isAdmin())
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div class="stat-label">Total User</div>
            <div class="stat-value">{{ $totalUsers }}</div>
        </div>
        @endif
        <div class="stat-card">
            <div class="stat-icon amber">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                </svg>
            </div>
            <div class="stat-label">Total Barang</div>
            <div class="stat-value">{{ $totalBarang }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2">
                    <polyline points="12 6 12 12 16 14"/>
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
                </svg>
            </div>
            <div class="stat-label">Barang Dipinjam</div>
            <div class="stat-value">{{ $totalPinjam }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
            </div>
            <div class="stat-label">Stok Menipis</div>
            <div class="stat-value">{{ $stokKritis }}</div>
        </div>
        @if(Auth::user()->isAdmin())
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <div class="stat-label">Stok Habis</div>
            <div class="stat-value">{{ $stokHabis }}</div>
        </div>
        @endif
    </div>

    {{-- Alert stok menipis (admin only) --}}
    @if(Auth::user()->isAdmin() && $barangMenipis->count() > 0)
    <div class="opname-alert">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2">
            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
            <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
        </svg>
        <div>
            <div class="alert-title">{{ $stokKritis }} barang stok menipis!</div>
            <div class="alert-sub">
                @foreach($barangMenipis as $b)
                    <span style="margin-right:8px;">{{ $b->nama }} ({{ $b->stok }} {{ $b->satuan ?? 'pcs' }})</span>
                @endforeach
            </div>
        </div>
        <a href="/barang">Lihat Semua &rarr;</a>
    </div>
    @endif

    {{-- Quick Access --}}
    <div class="section-title">Akses Cepat</div>
    <div class="quick-grid">
        <a href="/barang" class="quick-card">
            <div class="qc-icon" style="background:#dbeafe;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                </svg>
            </div>
            <span class="qc-label">Data Barang</span>
        </a>
        <a href="/pinjam" class="quick-card">
            <div class="qc-icon" style="background:#d1fae5;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2">
                    <polyline points="12 6 12 12 16 14"/>
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
                </svg>
            </div>
            <span class="qc-label">Pinjam Barang</span>
        </a>
        <a href="/profile" class="quick-card">
            <div class="qc-icon" style="background:#ede9fe;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <span class="qc-label">Kelola Profile</span>
        </a>
        @if(Auth::user()->isAdmin())
        <a href="/barang/create" class="quick-card">
            <div class="qc-icon" style="background:#fef3c7;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
            </div>
            <span class="qc-label">Input Barang</span>
        </a>
        <a href="/admin/opname" class="quick-card">
            <div class="qc-icon" style="background:#fee2e2;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2">
                    <path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                </svg>
            </div>
            <span class="qc-label">Opname Barang</span>
        </a>
        <a href="/admin/users" class="quick-card">
            <div class="qc-icon" style="background:#dcfce7;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <span class="qc-label">Kelola User</span>
        </a>
        @endif
    </div>

</main>

@vite(['resources/js/app.js'])
<script>
    // Highlight active nav item based on current URL
    document.querySelectorAll('.nav-item, .sub-item').forEach(function(el) {
        if (el.href && window.location.pathname === new URL(el.href).pathname) {
            el.classList.add('active');
        }
    });
</script>

</body>
</html>
