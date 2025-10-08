@extends('layouts.app')

@section('content')
<h1 style="margin: 40px 0 20px;">Admin Panel</h1>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin: 40px 0;">
    <div class="card" style="text-align: center;">
        <h3 style="color: #4facfe; font-size: 36px;">{{ $stats['total_users'] }}</h3>
        <p>Toplam Kullanıcı</p>
    </div>
    <div class="card" style="text-align: center;">
        <h3 style="color: #4facfe; font-size: 36px;">{{ $stats['total_files'] }}</h3>
        <p>Toplam Dosya</p>
    </div>
    <div class="card" style="text-align: center;">
        <h3 style="color: #4facfe; font-size: 36px;">{{ $stats['total_links'] }}</h3>
        <p>Toplam Link</p>
    </div>
    <div class="card" style="text-align: center;">
        <h3 style="color: #4facfe; font-size: 36px;">
            {{ number_format($stats['total_storage'] / 1024 / 1024 / 1024, 2) }} GB
        </h3>
        <p>Toplam Depolama</p>
    </div>
</div>

<div class="card">
    <h3 style="margin-bottom: 20px;">En Çok İndirilen Dosyalar</h3>
    @if($stats['most_downloaded']->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Dosya</th>
                    <th>Kullanıcı</th>
                    <th>İndirme</th>
                    <th>Boyut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stats['most_downloaded'] as $file)
                <tr>
                    <td>{{ $file->original_name }}</td>
                    <td>{{ $file->user->name }}</td>
                    <td>{{ $file->download_count }}</td>
                    <td>{{ $file->formatted_size }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center; opacity: 0.6;">Henüz dosya yok.</p>
    @endif
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 40px 0;">
    <a href="{{ route('admin.users.index') }}" class="card" style="text-decoration: none; color: inherit;">
        <h3 style="color: #4facfe;">👥 Kullanıcılar</h3>
    </a>
    <a href="{{ route('admin.files.index') }}" class="card" style="text-decoration: none; color: inherit;">
        <h3 style="color: #4facfe;">📁 Dosyalar</h3>
    </a>
    <a href="{{ route('admin.links.index') }}" class="card" style="text-decoration: none; color: inherit;">
        <h3 style="color: #4facfe;">🔗 Linkler</h3>
    </a>
    <a href="{{ route('admin.ads.index') }}" class="card" style="text-decoration: none; color: inherit;">
        <h3 style="color: #4facfe;">💰 Reklamlar</h3>
    </a>
</div>
@endsection
