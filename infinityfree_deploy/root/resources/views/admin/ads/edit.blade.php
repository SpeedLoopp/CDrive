@extends('layouts.app')

@section('content')
<h1 style="margin: 40px 0 20px;">Reklam Düzenle</h1>

<div class="card">
    <form method="POST" action="{{ route('admin.ads.update', $ad) }}">
        @csrf
        @method('PUT')
        
        <label>Başlık</label>
        <input type="text" name="title" value="{{ old('title', $ad->title) }}">
        
        <label>Tip</label>
        <select name="type" required>
            <option value="header" {{ $ad->type == 'header' ? 'selected' : '' }}>Üst Banner</option>
            <option value="footer" {{ $ad->type == 'footer' ? 'selected' : '' }}>Alt Banner</option>
            <option value="popup" {{ $ad->type == 'popup' ? 'selected' : '' }}>Popup</option>
            <option value="sidebar" {{ $ad->type == 'sidebar' ? 'selected' : '' }}>Yan Panel</option>
        </select>
        
        <label>İçerik (HTML)</label>
        <textarea name="content" rows="10" required>{{ old('content', $ad->content) }}</textarea>
        
        <label>Görüntüleme Sırası</label>
        <input type="number" name="display_order" value="{{ old('display_order', $ad->display_order) }}">

        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">Güncelle</button>
            <a href="{{ route('admin.ads.index') }}" class="btn">İptal</a>
        </div>
    </form>
</div>
@endsection
