@extends('layouts.app')

@section('content')
<h1 style="margin: 40px 0 20px;">Hoş Geldin, {{ auth()->user()->name }}!</h1>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin: 40px 0;">
    <div class="card" style="text-align: center;">
        <h3 style="color: #4facfe; font-size: 36px;">{{ auth()->user()->files()->count() }}</h3>
        <p>Toplam Dosya</p>
    </div>
    <div class="card" style="text-align: center;">
        <h3 style="color: #4facfe; font-size: 36px;">{{ auth()->user()->files()->sum('download_count') }}</h3>
        <p>Toplam İndirme</p>
    </div>
    <div class="card" style="text-align: center;">
        <h3 style="color: #4facfe; font-size: 36px;">
            {{ number_format(auth()->user()->files()->sum('file_size') / 1024 / 1024, 2) }} MB
        </h3>
        <p>Kullanılan Alan</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
    <a href="{{ route('files.index') }}" class="card" style="text-decoration: none; color: inherit;">
        <h3 style="color: #4facfe; margin-bottom: 10px;">📁 Dosyalarım</h3>
        <p>Dosyalarını yükle, yönet ve indir</p>
    </a>
    
    <a href="{{ route('links.index') }}" class="card" style="text-decoration: none; color: inherit;">
        <h3 style="color: #4facfe; margin-bottom: 10px;">🔗 Linklerim</h3>
        <p>Özel paylaşım linkleri oluştur</p>
    </a>
</div>
@endsection
