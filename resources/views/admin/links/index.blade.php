@extends('layouts.app')

@section('content')
<h1 style="margin: 40px 0 20px;">Link Yönetimi</h1>

<div class="card">
    @if($links->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Link</th>
                    <th>Dosya</th>
                    <th>Kullanıcı</th>
                    <th>Erişim</th>
                    <th>Durum</th>
                    <th>Tarih</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach($links as $link)
                <tr>
                    <td>
                        <a href="{{ route('link.show', $link->custom_link) }}" target="_blank" style="color: #4facfe;">
                            /l/{{ $link->custom_link }}
                        </a>
                    </td>
                    <td>{{ $link->file->original_name }}</td>
                    <td>{{ $link->file->user->name }}</td>
                    <td>{{ $link->access_count }}</td>
                    <td>
                        @if($link->isAccessible())
                            <span style="color: #27ae60;">✓ Aktif</span>
                        @else
                            <span style="color: #e74c3c;">✗ Pasif</span>
                        @endif
                    </td>
                    <td>{{ $link->created_at->format('d.m.Y H:i') }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.links.destroy', $link) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Emin misiniz?')">Sil</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        {{ $links->links() }}
    @else
        <p style="text-align: center; opacity: 0.6;">Link bulunamadı.</p>
    @endif
</div>
@endsection
