<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opname Barang - Data Penjualan</title>
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

        /* ALERT */
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; padding: 12px 16px; border-radius: 8px; font-size: 14px; margin-bottom: 20px; }

        /* GRID */
        .page-grid { display: grid; grid-template-columns: 1fr 1.5fr; gap: 24px; align-items: start; }
        @media (max-width: 900px) { .page-grid { grid-template-columns: 1fr; } }

        /* FORM CARD */
        .card { background: white; border-radius: 12px; padding: 24px 28px; box-shadow: 0 1px 4px rgba(0,0,0,0.07); border: 1px solid #eef0f4; }
        .card-title { font-size: 15px; font-weight: 600; color: var(--navy); margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1px solid #f0f0f0; }
        .form-group { margin-bottom: 14px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 5px; }
        .form-group select, .form-group input, .form-group textarea {
            width: 100%; padding: 9px 12px; border: 1px solid #d1d5db; border-radius: 8px;
            font-size: 13.5px; outline: none; font-family: inherit; color: #222;
            transition: border-color 0.15s;
        }
        .form-group select:focus, .form-group input:focus, .form-group textarea:focus { border-color: var(--navy); }
        .form-group textarea { resize: vertical; min-height: 70px; }
        .error-msg { font-size: 12px; color: #dc2626; margin-top: 3px; }
        .stok-info { background: #f8f9fb; border-radius: 8px; padding: 12px 14px; margin-bottom: 14px; font-size: 13px; color: #374151; display: none; }
        .stok-info span { font-weight: 700; color: var(--navy); }
        .btn-submit { background: var(--navy); color: white; border: none; padding: 10px 24px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; width: 100%; }
        .btn-submit:hover { background: var(--navy-hover); }

        /* RIWAYAT TABLE */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        thead th { background: #f8f9fb; padding: 10px 12px; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb; white-space: nowrap; }
        tbody td { padding: 10px 12px; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: #fafbfc; }
        .badge { display: inline-block; font-size: 11px; padding: 2px 8px; border-radius: 10px; font-weight: 600; }
        .badge-plus  { background: #d1fae5; color: #065f46; }
        .badge-minus { background: #fee2e2; color: #991b1b; }
        .badge-zero  { background: #f3f4f6; color: #6b7280; }
        .empty-state { text-align: center; padding: 32px; color: #9ca3af; font-size: 14px; }
    </style>
</head>
<body>

<nav class="topbar">
    <div class="topbar-left">
        <button class="hamburger" onclick="toggleSidebar()"><span></span><span></span><span></span></button>
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
    <a href="/barang/create" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>Input Barang <span class="nav-badge">Admin</span>
    </a>
    <a href="/admin/opname" class="nav-item active">
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
        <span>Opname Barang</span>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="page-grid">

        {{-- FORM OPNAME --}}
        <div class="card">
            <div class="card-title">Input Opname</div>
            <form method="POST" action="/admin/opname">
                @csrf

                <div class="form-group">
                    <label>Pilih Barang <span style="color:#dc2626">*</span></label>
                    <select name="barang_id" id="barangSelect" onchange="tampilStok(this)" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barangs as $b)
                            <option value="{{ $b->id }}" data-stok="{{ $b->stok }}" {{ old('barang_id') == $b->id ? 'selected' : '' }}>
                                {{ $b->nama }} ({{ $b->kode }})
                            </option>
                        @endforeach
                    </select>
                    @error('barang_id') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="stok-info" id="stokInfo">
                    Stok sistem saat ini: <span id="stokSistem">-</span>
                </div>

                <div class="form-group">
                    <label>Stok Fisik (Hasil Hitung) <span style="color:#dc2626">*</span></label>
                    <input type="number" name="stok_fisik" id="stokFisik" value="{{ old('stok_fisik') }}" min="0" placeholder="Masukkan jumlah stok fisik" required>
                    @error('stok_fisik') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" placeholder="Catatan opname (opsional)">{{ old('keterangan') }}</textarea>
                </div>

                <button type="submit" class="btn-submit">Simpan Opname</button>
            </form>
        </div>

        {{-- RIWAYAT OPNAME --}}
        <div class="card">
            <div class="card-title">Riwayat Opname (20 Terakhir)</div>
            <div class="table-wrap">
                @if($riwayat->isEmpty())
                    <div class="empty-state">Belum ada data opname.</div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th>Sistem</th>
                                <th>Fisik</th>
                                <th>Selisih</th>
                                <th>Oleh</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayat as $op)
                            <tr>
                                <td>{{ $op->barang->nama ?? '-' }}</td>
                                <td>{{ $op->stok_sistem }}</td>
                                <td>{{ $op->stok_fisik }}</td>
                                <td>
                                    @if($op->selisih > 0)
                                        <span class="badge badge-plus">+{{ $op->selisih }}</span>
                                    @elseif($op->selisih < 0)
                                        <span class="badge badge-minus">{{ $op->selisih }}</span>
                                    @else
                                        <span class="badge badge-zero">0</span>
                                    @endif
                                </td>
                                <td>{{ $op->user->name ?? '-' }}</td>
                                <td style="white-space:nowrap">{{ $op->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

    </div>
</main>

@vite(['resources/js/app.js'])
<script>
    function tampilStok(select) {
        const opt = select.options[select.selectedIndex];
        const stok = opt.getAttribute('data-stok');
        const info = document.getElementById('stokInfo');
        if (stok !== null && select.value !== '') {
            document.getElementById('stokSistem').textContent = stok;
            info.style.display = 'block';
        } else {
            info.style.display = 'none';
        }
    }

    // Tampil stok saat halaman reload (jika ada old value)
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('barangSelect');
        if (select.value) tampilStok(select);
    });
</script>
</body>
</html>
