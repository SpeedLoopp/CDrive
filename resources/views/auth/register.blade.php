@extends('layouts.app')

@section('content')
<div style="max-width: 400px; margin: 80px auto;">
    <div class="card">
        <h2 style="margin-bottom: 20px; text-align: center;">Kayıt Ol</h2>
        
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <label>Ad Soyad</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
                <span style="color: #e74c3c; font-size: 12px;">{{ $message }}</span>
            @enderror

            <label>E-posta</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <span style="color: #e74c3c; font-size: 12px;">{{ $message }}</span>
            @enderror

            <label>Şifre</label>
            <input type="password" name="password" required>
            @error('password')
                <span style="color: #e74c3c; font-size: 12px;">{{ $message }}</span>
            @enderror

            <label>Şifre Tekrar</label>
            <input type="password" name="password_confirmation" required>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 20px;">
                Kayıt Ol
            </button>
        </form>

        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ route('login') }}" style="color: #4facfe;">Zaten hesabın var mı? Giriş Yap</a>
        </div>
    </div>
</div>
@endsection
