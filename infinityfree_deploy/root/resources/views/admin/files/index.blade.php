@extends('layouts.app')

@section('content')
<h1 style="margin: 40px 0 20px;">Dosya Yönetimi</h1>

<div class="card">
    @if($files->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Dosya</th>
                    <th>Kullanıcı</th>
                    <th>Boyut</th>
                    <th>İndirme</th>
                    <th>Tarih</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach($files as $file)
                <tr>
                    <td>{{ $file->original_name }}</td>
                    <td>{{ $file->user->name }}</td>
                    <td>{{ $file->formatted_size }}</td>
                    <td>{{ $file->download_count }}</td>
                    <td>{{ $file->created_at->format('d.m.Y H:i') }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.files.destroy', $file) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Emin misiniz?')">Sil</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        {{ $files->links() }}
    @else
        <p style="text-align: center; opacity: 0.6;">Dosya bulunamadı.</p>
    @endif
</div>
@endsection
