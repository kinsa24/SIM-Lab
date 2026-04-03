<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang - Sistem Informasi Manajemen Laboratorium</title>
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
        body { font-family: 'Segoe UI', Tahoma, Geneva, sans-serif; background: #f0f2f5; color: #222; }

        /* TOPBAR */
        .topbar {
            position: fixed; top: 0; left: 0; right: 0;
            height: var(--topbar-height); background: var(--navy); color: white;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 24px 0 16px; z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .hamburger {
            background: none; border: none; color: white; cursor: pointer;
            padding: 6px; border-radius: 6px; display: flex; flex-direction: column;
            gap: 4px; transition: background 0.2s;
        }
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
        .btn-logout {
            background: var(--accent); color: white; border: none;
            padding: 7px 14px; border-radius: 6px; cursor: pointer; font-size: 13px;
        }
        .btn-logout:hover { background: var(--accent-hover); }

        /* SIDEBAR */
        .sidebar {
            position: fixed; top: var(--topbar-height); left: 0; bottom: 0;
            width: var(--sidebar-width); background: white;
            border-right: 1px solid #dde3ec; overflow-y: auto;
            z-index: 90; transition: transform 0.25s ease; padding: 12px 0 24px;
        }
        .sidebar.collapsed { transform: translateX(calc(-1 * var(--sidebar-width))); }
        .sidebar-section { padding: 16px 14px 4px; font-size: 10px; font-weight: 700; letter-spacing: 1px; color: #aab; text-transform: uppercase; }
        .nav-item {
            display: flex; align-items: center; gap: 10px; padding: 10px 14px;
            color: #4a5568; text-decoration: none; font-size: 13.5px;
            transition: background 0.15s, color 0.15s; border: none; background: none; width: 100%; text-align: left; cursor: pointer;
        }
        .nav-item:hover { background: var(--navy-light); color: var(--navy); }
        .nav-item.active { background: var(--navy-light); color: var(--navy); font-weight: 600; border-left: 3px solid var(--navy); }
        .nav-icon { width: 18px; height: 18px; flex-shrink: 0; opacity: 0.75; }
        .nav-item.active .nav-icon, .nav-item:hover .nav-icon { opacity: 1; }
        .nav-badge { margin-left: auto; font-size: 10px; padding: 1px 6px; border-radius: 8px; background: #fff3cd; color: #7a4c00; font-weight: 600; }
        .divider { height: 1px; background: #eef0f4; margin: 8px 14px; }

        /* MAIN */
        .main {
            margin-top: var(--topbar-height); margin-left: var(--sidebar-width);
            padding: 32px 28px; min-height: calc(100vh - var(--topbar-height));
            transition: margin-left 0.25s ease;
        }
        .main.expanded { margin-left: 0; }

        /* PAGE HEADER */
        .page-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 24px; flex-wrap: wrap; gap: 12px;
        }
        .page-title { font-size: 20px; font-weight: 600; color: var(--navy); }
        .page-sub { font-size: 13px; color: #718096; margin-top: 2px; }
        .btn-primary {
            background: var(--navy); color: white; text-decoration: none;
            padding: 9px 18px; border-radius: 8px; font-size: 13px; font-weight: 600;
            display: flex; align-items: center; gap: 6px; transition: background 0.2s;
        }
        .btn-primary:hover { background: var(--navy-hover); }

        /* FILTER BAR */
        .filter-bar {
            background: white; border-radius: 10px; padding: 14px 18px;
            margin-bottom: 20px; display: flex; gap: 12px; flex-wrap: wrap; align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06); border: 1px solid #eef0f4;
        }
        .search-input {
            flex: 1; min-width: 200px; padding: 8px 12px;
            border: 1px solid #ddd; border-radius: 8px; font-size: 13px; outline: none;
        }
        .search-input:focus { border-color: var(--navy); }
        .filter-select {
            padding: 8px 12px; border: 1px solid #ddd; border-radius: 8px;
            font-size: 13px; outline: none; background: white; cursor: pointer;
        }
        .filter-select:focus { border-color: var(--navy); }

        /* ALERT */
        .alert-success { background: #d4edda; color: #155724; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
        .alert-error   { background: #f8d7da; color: #721c24; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }

        /* TABLE CARD */
        .table-card {
            background: white; border-radius: 12px; overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,0.07); border: 1px solid #eef0f4;
        }
        .table-card-header {
            padding: 16px 20px; border-bottom: 1px solid #f0f0f0;
            display: flex; align-items: center; justify-content: space-between;
        }
        .table-card-header span { font-size: 13px; font-weight: 600; color: #4a5568; }
        .badge-count { background: var(--navy-light); color: var(--navy); font-size: 12px; padding: 2px 8px; border-radius: 8px; font-weight: 600; }
        table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
        th { text-align: left; padding: 11px 16px; background: #f8f9fa; color: #6b7280; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 0.4px; }
        td { padding: 12px 16px; border-top: 1px solid #f3f4f6; color: #374151; vertical-align: middle; }
        tr:hover td { background: #fafbfc; }

        /* BADGES */
        .badge {
            display: inline-block; padding: 3px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 600;
        }
        .badge-good    { background: #d1fae5; color: #065f46; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger  { background: #fee2e2; color: #991b1b; }

        /* ACTION BUTTONS */
        .btn-edit {
            background: #dbeafe; color: #1d4ed8; border: none;
            padding: 5px 12px; border-radius: 6px; cursor: pointer;
            font-size: 12px; font-weight: 600; text-decoration: none;
            transition: background 0.2s;
        }
        .btn-edit:hover { background: #bfdbfe; }
        .btn-delete {
            background: #fee2e2; color: #dc2626; border: none;
            padding: 5px 12px; border-radius: 6px; cursor: pointer;
            font-size: 12px; font-weight: 600; transition: background 0.2s;
        }
        .btn-delete:hover { background: #fecaca; }
        .action-group { display: flex; gap: 6px; align-items: center; }

        /* COLLAPSIBLE GROUP */
        .group-header {
            display: flex; align-items: center; gap: 10px; padding: 10px 14px;
            color: #4a5568; font-size: 13.5px; cursor: pointer;
            transition: background 0.15s; user-select: none;
        }
        .group-header:hover { background: var(--navy-light); color: var(--navy); }
        .chevron { margin-left: auto; width: 14px; height: 14px; transition: transform 0.2s; opacity: 0.5; }
        .group-header.open .chevron { transform: rotate(90deg); }
        .sub-menu { display: none; background: #f8f9fb; }
        .sub-menu.open { display: block; }
        .sub-item {
            display: flex; align-items: center; gap: 8px;
            padding: 8px 14px 8px 40px; color: #4a5568;
            text-decoration: none; font-size: 13px; transition: background 0.15s, color 0.15s;
        }
        .sub-item:hover { background: var(--navy-light); color: var(--navy); }
        .sub-item::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: #cbd5e0; flex-shrink: 0; }

        /* EMPTY STATE */
        .empty-state { text-align: center; padding: 60px 20px; color: #a0aec0; }
        .empty-state svg { margin-bottom: 12px; opacity: 0.4; }
        .empty-state p { font-size: 14px; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(calc(-1 * var(--sidebar-width))); }
            .main { margin-left: 0; }
        }
    </style>
</head>
<body>

{{-- TOPBAR --}}
<nav class="topbar">
    <div class="topbar-left">
        <button class="hamburger" onclick="toggleSidebar()">
            <span></span><span></span><span></span>
        </button>
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
        </svg>
        Dashboard
    </a>

    <a href="/barang" class="nav-item active">
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
        </svg>
        Kelola Profile
    </a>

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

{{-- MAIN --}}
<main class="main" id="main">

    <div class="page-header">
        <div>
            <div class="page-title">Data Barang</div>
            <div class="page-sub">Daftar seluruh barang dalam inventaris</div>
        </div>
        @if(Auth::user()->isAdmin())
        <a href="/barang/create" class="btn-primary">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Tambah Barang
        </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    {{-- Filter Bar --}}
    <div class="filter-bar">
        <input type="text" class="search-input" id="searchInput" placeholder="Cari nama barang..." oninput="filterTable()">
        <select class="filter-select" id="filterStok" onchange="filterTable()">
            <option value="">Semua Stok</option>
            <option value="aman">Stok Aman</option>
            <option value="menipis">Stok Menipis</option>
            <option value="habis">Stok Habis</option>
        </select>
    </div>

    {{-- Tabel --}}
    <div class="table-card">
        <div class="table-card-header">
            <span>Daftar Barang</span>
            <span class="badge-count">{{ $barangs->count() }} barang</span>
        </div>
        <table id="barangTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Satuan</th>
                    <th>Stok</th>
                    <th>Stok Min</th>
                    <th>Status</th>
                    @if(Auth::user()->isAdmin())
                    <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($barangs as $barang)
                <tr data-stok="{{ $barang->stok <= 0 ? 'habis' : ($barang->stok <= $barang->stok_min ? 'menipis' : 'aman') }}">
                    <td>{{ $loop->iteration }}</td>
                    <td style="font-family:monospace;color:#6b7280;">{{ $barang->kode }}</td>
                    <td style="font-weight:500;">{{ $barang->nama }}</td>
                    <td>{{ $barang->kategori ?? '-' }}</td>
                    <td>{{ $barang->satuan ?? '-' }}</td>
                    <td style="font-weight:600;">{{ $barang->stok }}</td>
                    <td style="color:#6b7280;">{{ $barang->stok_min }}</td>
                    <td>
                        @if($barang->stok <= 0)
                            <span class="badge badge-danger">Habis</span>
                        @elseif($barang->stok <= $barang->stok_min)
                            <span class="badge badge-warning">Menipis</span>
                        @else
                            <span class="badge badge-good">Aman</span>
                        @endif
                    </td>
                    @if(Auth::user()->isAdmin())
                    <td>
                        <div class="action-group">
                            <a href="/barang/{{ $barang->id }}/edit" class="btn-edit">Edit</a>
                            <form method="POST" action="/barang/{{ $barang->id }}" onsubmit="return confirm('Hapus barang {{ $barang->nama }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#a0aec0" stroke-width="1.5">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                            </svg>
                            <p>Belum ada data barang.</p>
                            @if(Auth::user()->isAdmin())
                            <p style="margin-top:8px;"><a href="/barang/create" style="color:var(--navy);">Tambah barang sekarang</a></p>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</main>

@vite(['resources/js/app.js'])
<script>
    function filterTable() {
        const search = document.getElementById('searchInput').value.toLowerCase();
        const filterStok = document.getElementById('filterStok').value;
        const rows = document.querySelectorAll('#barangTable tbody tr');
        rows.forEach(row => {
            const nama = row.cells[2] ? row.cells[2].textContent.toLowerCase() : '';
            const stokStatus = row.getAttribute('data-stok') || '';
            const matchSearch = nama.includes(search);
            const matchStok = !filterStok || stokStatus === filterStok;
            row.style.display = matchSearch && matchStok ? '' : 'none';
        });
    }
</script>

</body>
</html>
