<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIM Lab</title>
    @vite(['resources/css/login.css', 'resources/js/login.js'])
</head>
<body>

<div class="login-container">

    <div class="login-header">
        <div class="logo">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/>
            </svg>
        </div>
        <h1>Selamat Datang</h1>
        <p>Masuk ke akun Data Penjualan Anda</p>
    </div>

    <div id="alertBox" class="alert alert-error"></div>

    <form id="loginForm" method="POST" action="/login">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <div class="input-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                </svg>
                <input type="email" id="email" name="email" placeholder="contoh@email.com" autocomplete="email">
            </div>
            <span class="error-message"></span>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                <input type="password" id="password" name="password" placeholder="Masukkan password" autocomplete="current-password">
                <button type="button" id="togglePassword" class="toggle-password">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            <span class="error-message"></span>
        </div>

        <div class="form-options">
            <label class="remember-me">
                <input type="checkbox" name="remember">
                <span>Ingat saya</span>
            </label>
            <a href="#" class="forgot-password">Lupa password?</a>
        </div>

        <button type="submit" id="btnLogin" class="btn-login">
            <span class="btn-text">Masuk</span>
            <div class="spinner"></div>
        </button>

    </form>

    <div class="login-footer">
        Belum punya akun? <a href="#">Daftar sekarang</a>
    </div>

</div>

</body>
</html>
