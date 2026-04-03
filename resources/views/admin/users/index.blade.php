<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User - Data Penjualan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; }
        .navbar {
            background: #1e3a5f;
            color: white;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar h1 { font-size: 20px; }
        .navbar a { color: white; text-decoration: none; font-size: 14px; }
        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; }
        h2 { font-size: 20px; color: #1e3a5f; margin-bottom: 24px; }

        /* Alert */
        .alert-success {
            background: #d4edda; color: #155724;
            padding: 12px 16px; border-radius: 8px;
            margin-bottom: 20px; font-size: 14px;
        }

        /* Form tambah user */
        .form-card {
            background: white; border-radius: 12px;
            padding: 24px; margin-bottom: 32px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .form-card h3 { font-size: 16px; color: #1e3a5f; margin-bottom: 16px; }
        .form-row { display: flex; gap: 16px; flex-wrap: wrap; }
        .form-group { flex: 1; min-width: 180px; }
        .form-group label { display: block; font-size: 13px; color: #555; margin-bottom: 6px; }
        .form-group input {
            width: 100%; padding: 10px 12px;
            border: 1px solid #ddd; border-radius: 8px;
            font-size: 14px; outline: none;
        }
        .form-group input:focus { border-color: #1e3a5f; }
        .form-group .error { color: #e74c3c; font-size: 12px; margin-top: 4px; }
        .btn-add {
            margin-top: 16px;
            background: #1e3a5f; color: white;
            border: none; padding: 10px 24px;
            border-radius: 8px; cursor: pointer; font-size: 14px;
        }
        .btn-add:hover { background: #2c4f7c; }

        /* Tabel user */
        .table-card {
            background: white; border-radius: 12px;
            padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .table-card h3 { font-size: 16px; color: #1e3a5f; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th { text-align: left; padding: 10px 12px; background: #f8f9fa; color: #555; font-weight: 600; }
        td { padding: 10px 12px; border-top: 1px solid #f0f0f0; color: #333; }
        tr:hover td { background: #fafafa; }
        .btn-delete {
            background: #e74c3c; color: white;
            border: none; padding: 6px 12px;
            border-radius: 6px; cursor: pointer; font-size: 13px;
        }
        .btn-delete:hover { background: #c0392b; }
        .back-link { display: inline-block; margin-bottom: 20px; color: #1e3a5f; text-decoration: none; font-size: 14px; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

<nav class="navbar">
    <h1>Data Penjualan</h1>
    <div style="display:flex;align-items:center;gap:16px;">
        @if(Auth::user()->foto)
            <img src="{{ asset('storage/foto/' . Auth::user()->foto) }}" style="width:34px;height:34px;border-radius:50%;object-fit:cover;border:2px solid rgba(255,255,255,0.4);flex-shrink:0;" alt="Foto">
        @else
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=2c4f7c&color=fff&size=34" style="width:34px;height:34px;border-radius:50%;object-fit:cover;border:2px solid rgba(255,255,255,0.4);flex-shrink:0;" alt="Foto">
        @endif
        <div style="text-align:right;">
            <div style="font-weight:600;font-size:15px;">{{ Auth::user()->name }}</div>
            <div style="font-size:12px;background:{{ Auth::user()->isAdmin() ? '#f39c12' : '#27ae60' }};padding:2px 8px;border-radius:10px;margin-top:2px;">
                {{ Auth::user()->isAdmin() ? 'Admin' : 'User' }}
            </div>
        </div>
        <a href="/dashboard">← Dashboard</a>
    </div>
</nav>

<div class="container">
    <h2>Kelola User</h2>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form Tambah User --}}
    <div class="form-card">
        <h3>Tambah User Baru</h3>
        <form method="POST" action="/admin/users">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap">
                    @error('name') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com">
                    @error('email') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Min. 6 karakter">
                    @error('password') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
            <button type="submit" class="btn-add">Tambah User</button>
        </form>
    </div>

    {{-- Daftar User --}}
    <div class="table-card">
        <h3>Daftar User ({{ $users->count() }})</h3>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($user->id !== Auth::id())
                        <form method="POST" action="/admin/users/{{ $user->id }}" onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">Hapus</button>
                        </form>
                        @else
                        <span style="color:#aaa;font-size:13px;">Anda</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;color:#aaa;padding:20px;">Belum ada user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
