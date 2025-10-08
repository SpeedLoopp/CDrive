@extends('layouts.app')

@section('content')
<h1 style="margin: 40px 0 20px;">Dosyalarım</h1>

<div class="card">
    <h3 style="margin-bottom: 20px;">Dosya Yükle</h3>
    <form method="POST" action="{{ route('files.upload') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <input type="text" name="folder" placeholder="Klasör adı (opsiyonel)">
        <button type="submit" class="btn btn-primary">Yükle</button>
    </form>
</div>

<div class="card">
    <h3 style="margin-bottom: 20px;">Dosya Listesi</h3>
    
    @if($files->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Dosya Adı</th>
                    <th>Boyut</th>
                    <th>Klasör</th>
                    <th>İndirme</th>
                    <th>Tarih</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach($files as $file)
                <tr>
                    <td>{{ $file->original_name }}</td>
                    <td>{{ $file->formatted_size }}</td>
                    <td>{{ $file->folder ?? '-' }}</td>
                    <td>{{ $file->download_count }}</td>
                    <td>{{ $file->created_at->format('d.m.Y H:i') }}</td>
                    <td>
                        <a href="{{ route('files.download', $file) }}" class="btn btn-success">İndir</a>
                        <a href="{{ route('links.create', $file) }}" class="btn btn-primary">Link Oluştur</a>
                        <form method="POST" action="{{ route('files.destroy', $file) }}" style="display: inline;">
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
        <p style="text-align: center; opacity: 0.6;">Henüz dosya yüklemediniz.</p>
    @endif
</div>
@endsection
