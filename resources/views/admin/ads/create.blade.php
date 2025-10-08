@extends('layouts.app')

@section('content')
<h1 style="margin: 40px 0 20px;">Yeni Reklam Ekle</h1>

<div class="card">
    <form method="POST" action="{{ route('admin.ads.store') }}">
        @csrf
        
        <label>Başlık</label>
        <input type="text" name="title" value="{{ old('title') }}">
        
        <label>Tip</label>
        <select name="type" required>
            <option value="header">Üst Banner</option>
            <option value="footer">Alt Banner</option>
            <option value="popup">Popup</option>
            <option value="sidebar">Yan Panel</option>
        </select>
        
        <label>İçerik (HTML)</label>
        <textarea name="content" rows="10" required>{{ old('content') }}</textarea>
        
        <label>Görüntüleme Sırası</label>
        <input type="number" name="display_order" value="{{ old('display_order', 0) }}">

        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">Kaydet</button>
            <a href="{{ route('admin.ads.index') }}" class="btn">İptal</a>
        </div>
    </form>
</div>
@endsection
