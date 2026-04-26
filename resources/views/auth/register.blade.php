<x-guest-layout>
<style>
    body { background: #F2F3F4 !important; }
    .login-wrapper {
        min-height: 100vh;
        display: flex; align-items: center; justify-content: center;
        padding: 24px;
        font-family: 'Sora', sans-serif;
        background:
            radial-gradient(ellipse 60% 50% at 50% -10%, #EBEAED 0%, transparent 70%),
            #F2F3F4;
    }
    .login-card {
        background: white;
        border-radius: 24px;
        border: 1.5px solid #EBEAED;
        padding: 44px 40px;
        width: 100%; max-width: 420px;
        box-shadow: 0 8px 40px rgba(2,0,53,.08);
    }
    .login-brand { text-align: center; margin-bottom: 32px; }
    .login-brand-name {
        font-size: 1.75rem; font-weight: 800;
        color: #02066F; letter-spacing: -.5px;
        display: block; text-decoration: none;
    }
    .login-brand-sub { font-size: .8rem; color: #2000B1; font-weight: 500; margin-top: 2px; }
    .login-heading { font-size: 1.15rem; font-weight: 700; color: #020035; margin-bottom: 6px; }
    .login-subheading { font-size: .875rem; color: #2000B1; margin-bottom: 28px; }
    .form-group { margin-bottom: 18px; }
    .form-label {
        display: block; font-size: .8rem; font-weight: 700;
        color: #020035; margin-bottom: 6px; letter-spacing: .01em;
    }
    .form-input {
        width: 100%; padding: 11px 14px;
        border: 1.5px solid #EBEAED; border-radius: 10px;
        font-family: inherit; font-size: .9rem; color: #020035;
        background: #F2F3F4; transition: all .15s; outline: none;
        box-sizing: border-box;
    }
    .form-input:focus { border-color: #02066F; background: white; box-shadow: 0 0 0 3px #EBEAED; }
    .form-input::placeholder { color: #B0AEBD; }
    .form-error { font-size: .78rem; color: #ED4B00; margin-top: 5px; font-weight: 500; }
    .btn-submit {
        width: 100%; padding: 13px;
        background: #02066F; color: white;
        font-family: inherit; font-size: .95rem; font-weight: 700;
        border: none; border-radius: 11px;
        cursor: pointer; transition: background .15s, transform .1s;
    }
    .btn-submit:hover { background: #020035; }
    .btn-submit:active { transform: scale(.98); }
    .login-footer { text-align: center; margin-top: 20px; font-size: .83rem; color: #2000B1; }
    .login-footer a { color: #02066F; font-weight: 600; text-decoration: none; }
    .login-footer a:hover { text-decoration: underline; }
    .divider { height: 1px; background: #EBEAED; margin: 20px 0; }
</style>

<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<div class="login-wrapper">
    <div class="login-card">
        <div class="login-brand">
            <a href="/" class="login-brand-name">Shopind</a>
            <p class="login-brand-sub">Belanja Mudah & Cepat</p>
        </div>

        <h2 class="login-heading">Buat akun baru</h2>
        <p class="login-subheading">Daftar dan mulai belanja di Shopind</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="name">Nama</label>
                <input id="name" class="form-input" type="text" name="name"
                    value="{{ old('name') }}" required autofocus autocomplete="name"
                    placeholder="Nama lengkap kamu">
                @error('name')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input id="email" class="form-input" type="email" name="email"
                    value="{{ old('email') }}" required autocomplete="username"
                    placeholder="contoh@email.com">
                @error('email')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input id="password" class="form-input" type="password" name="password"
                    required autocomplete="new-password" placeholder="••••••••">
                @error('password')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                <input id="password_confirmation" class="form-input" type="password"
                    name="password_confirmation" required autocomplete="new-password"
                    placeholder="••••••••">
                @error('password_confirmation')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn-submit">Daftar</button>
        </form>

        <div class="divider"></div>
        <div class="login-footer">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk sekarang</a>
        </div>
    </div>
</div>
</x-guest-layout>