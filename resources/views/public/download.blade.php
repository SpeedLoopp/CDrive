@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 80px auto; text-align: center;">
    <div class="card">
        <h1 style="margin-bottom: 20px;">📥 Dosya İndirme</h1>
        
        <div style="background: rgba(79, 172, 254, 0.1); padding: 20px; border-radius: 10px; margin: 20px 0;">
            <h2 style="color: #4facfe; margin-bottom: 10px;">{{ $link->file->original_name }}</h2>
            <p style="opacity: 0.8;">Boyut: {{ $link->file->formatted_size }}</p>
            <p style="opacity: 0.8;">İndirme: {{ $link->file->download_count }} kez</p>
        </div>

        <a href="{{ route('link.download', $link->custom_link) }}" class="btn btn-primary" style="font-size: 18px; padding: 15px 40px;">
            İndir
        </a>

        <p style="margin-top: 30px; opacity: 0.6; font-size: 14px;">
            Bu dosya {{ $link->file->user->name }} tarafından paylaşıldı
        </p>
    </div>
</div>
@endsection
