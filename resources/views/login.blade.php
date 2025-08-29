@extends('layouts.auth') @section('content')
<div class="login-container">
    <div class="login-header">
        <div class="logo">
            <i class="fas fa-clock"></i>
        </div>
        <h1 class="brand-title">AttendPro</h1>
        <p class="brand-subtitle">Sistem Absensi Karyawan Premium</p>
    </div>

    <div class="login-content">
        <div class="success-message" id="successMessage">
            <i class="fas fa-check-circle"></i> Login berhasil! Mengalihkan...
        </div>
        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session("success") }}
        </div>
        @endif @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-times-circle"></i> {{ session("error") }}
        </div>
        @endif @if($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form
            id="loginForm"
            method="POST"
            action="{{ route('login.process') }}"
        >
            @csrf
            <div class="form-group">
                <label class="form-label" for="email"
                    >Email atau ID Karyawan</label
                >
                <div class="input-wrapper">
                    <input
                        type="text"
                        id="email"
                        name="email"
                        class="form-input"
                        placeholder="contoh: john.doe@company.com"
                        required
                        autocomplete="username"
                    />
                    <i class="fas fa-user input-icon"></i>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Kata Sandi</label>
                <div class="input-wrapper">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input"
                        placeholder="Masukkan kata sandi"
                        required
                        autocomplete="current-password"
                    />
                    <i class="fas fa-lock input-icon"></i>
                </div>
            </div>

            <button type="submit" class="login-button" id="loginBtn">
                <div class="loading" id="loadingSpinner"></div>
                <span id="loginText">Masuk ke Sistem</span>
            </button>
        </form>

        <div class="divider">
            <span>atau masuk dengan</span>
        </div>

        <div class="biometric-login">
            <div
                class="biometric-btn"
                id="fingerprintBtn"
                title="Login dengan sidik jari"
                role="button"
                tabindex="0"
            >
                <i class="fas fa-fingerprint"></i>
            </div>
            <div
                class="biometric-btn"
                id="faceIdBtn"
                title="Login dengan Face ID"
                role="button"
                tabindex="0"
            >
                <i class="fas fa-user-circle"></i>
            </div>
            <div
                class="biometric-btn"
                id="qrCodeBtn"
                title="Login dengan QR Code"
                role="button"
                tabindex="0"
            >
                <i class="fas fa-qrcode"></i>
            </div>
        </div>
    </div>

    <div class="footer-info">
        <p><i class="fas fa-shield-alt"></i> Koneksi aman dan terenkripsi</p>
        <p style="margin-top: 0.5rem">
            © 2025 AttendPro - Semua hak dilindungi
        </p>
    </div>
</div>
@endsection
