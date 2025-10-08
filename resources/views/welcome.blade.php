@extends('layouts.app')

@section('content')
<div style="text-align: center; padding: 100px 20px;">
    <h1 style="font-size: 48px; margin-bottom: 20px;">CDrive'a Hoş Geldiniz</h1>
    <p style="font-size: 20px; margin-bottom: 40px; opacity: 0.8;">
        Dosyalarınızı güvenle saklayın, kolayca paylaşın
    </p>
    
    <div style="display: flex; gap: 20px; justify-content: center;">
        <a href="{{ route('register') }}" class="btn btn-primary" style="font-size: 18px; padding: 15px 40px;">
            Hemen Başla
        </a>
        <a href="{{ route('login') }}" class="btn" style="font-size: 18px; padding: 15px 40px; background: rgba(255,255,255,0.1);">
            Giriş Yap
        </a>
    </div>

    <div style="margin-top: 80px; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
        <div class="card">
            <h3 style="color: #4facfe; margin-bottom: 10px;">🚀 Hızlı Yükleme</h3>
            <p>Dosyalarınızı saniyeler içinde yükleyin</p>
        </div>
        <div class="card">
            <h3 style="color: #4facfe; margin-bottom: 10px;">🔗 Özel Linkler</h3>
            <p>Kendi özel link adınızı oluşturun</p>
        </div>
        <div class="card">
            <h3 style="color: #4facfe; margin-bottom: 10px;">🔒 Güvenli</h3>
            <p>Dosyalarınız güvende</p>
        </div>
    </div>
</div>
@endsection
