@extends('layouts.app')

@section('content')
<h1 style="margin: 40px 0 20px;">Reklam Yönetimi</h1>

<div style="margin-bottom: 20px;">
    <a href="{{ route('admin.ads.create') }}" class="btn btn-primary">Yeni Reklam Ekle</a>
</div>

<div class="card">
    @if($ads->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Başlık</th>
                    <th>Tip</th>
                    <th>Sıra</th>
                    <th>Durum</th>
                    <th>Tarih</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ads as $ad)
                <tr>
                    <td>{{ $ad->title ?? 'Başlıksız' }}</td>
                    <td>{{ $ad->type }}</td>
                    <td>{{ $ad->display_order }}</td>
                    <td>
                        @if($ad->active)
                            <span style="color: #27ae60;">✓ Aktif</span>
                        @else
                            <span style="color: #e74c3c;">✗ Pasif</span>
                        @endif
                    </td>
                    <td>{{ $ad->created_at->format('d.m.Y') }}</td>
                    <td>
                        <a href="{{ route('admin.ads.edit', $ad) }}" class="btn btn-primary">Düzenle</a>
                        
                        <form method="POST" action="{{ route('admin.ads.toggle', $ad) }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                {{ $ad->active ? 'Pasifleştir' : 'Aktifleştir' }}
                            </button>
                        </form>
                        
                        <form method="POST" action="{{ route('admin.ads.destroy', $ad) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Emin misiniz?')">Sil</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        {{ $ads->links() }}
    @else
        <p style="text-align: center; opacity: 0.6;">Reklam bulunamadı.</p>
    @endif
</div>
@endsection
