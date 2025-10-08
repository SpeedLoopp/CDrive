@extends('layouts.app')

@section('content')
<div style="max-width: 400px; margin: 80px auto;">
    <div class="card">
        <h2 style="margin-bottom: 20px; text-align: center;">Giriş Yap</h2>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <label>E-posta</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <span style="color: #e74c3c; font-size: 12px;">{{ $message }}</span>
            @enderror

            <label>Şifre</label>
            <input type="password" name="password" required>
            @error('password')
                <span style="color: #e74c3c; font-size: 12px;">{{ $message }}</span>
            @enderror

            <label style="display: flex; align-items: center; margin: 15px 0;">
                <input type="checkbox" name="remember" style="width: auto; margin-right: 10px;">
                Beni Hatırla
            </label>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">
                Giriş Yap
            </button>
        </form>

        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ route('password.request') }}" style="color: #4facfe;">Şifremi Unuttum</a>
            <br><br>
            <a href="{{ route('register') }}" style="color: #4facfe;">Hesabın yok mu? Kayıt Ol</a>
        </div>
    </div>
</div>
@endsection
