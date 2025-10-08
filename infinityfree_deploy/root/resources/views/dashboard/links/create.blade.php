@extends('layouts.app')

@section('content')
<h1 style="margin: 40px 0 20px;">Paylaşım Linki Oluştur</h1>

<div class="card">
    <h3 style="margin-bottom: 20px;">Dosya: {{ $file->original_name }}</h3>
    
    <form method="POST" action="{{ route('links.store', $file) }}">
        @csrf
        
        <label>Özel Link Adı</label>
        <input type="text" name="custom_link" placeholder="ornek-dosya" required>
        <small style="opacity: 0.7;">Link: {{ url('/l/') }}/özel-link-adınız</small>
        @error('custom_link')
            <span style="color: #e74c3c; font-size: 12px;">{{ $message }}</span>
        @enderror

        <label>Son Kullanma Tarihi (Opsiyonel)</label>
        <input type="datetime-local" name="expiration_date">
        @error('expiration_date')
            <span style="color: #e74c3c; font-size: 12px;">{{ $message }}</span>
        @enderror

        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">Link Oluştur</button>
            <a href="{{ route('files.index') }}" class="btn">İptal</a>
        </div>
    </form>
</div>
@endsection
