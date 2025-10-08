@extends('layouts.app')

@section('content')
<div style="max-width: 400px; margin: 80px auto;">
    <div class="card">
        <h2 style="margin-bottom: 20px; text-align: center;">Şifremi Unuttum</h2>
        
        <p style="margin-bottom: 20px; opacity: 0.8;">
            E-posta adresinizi girin, size şifre sıfırlama linki gönderelim.
        </p>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            
            <label>E-posta</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <span style="color: #e74c3c; font-size: 12px;">{{ $message }}</span>
            @enderror

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 20px;">
                Link Gönder
            </button>
        </form>

        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ route('login') }}" style="color: #4facfe;">Giriş sayfasına dön</a>
        </div>
    </div>
</div>
@endsection
