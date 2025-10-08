@extends('layouts.app')

@section('content')
<h1 style="margin: 40px 0 20px;">Kullanıcı Yönetimi</h1>

<div class="card">
    @if($users->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ad</th>
                    <th>E-posta</th>
                    <th>Rol</th>
                    <th>Durum</th>
                    <th>Kayıt</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        @if($user->is_active)
                            <span style="color: #27ae60;">✓ Aktif</span>
                        @else
                            <span style="color: #e74c3c;">✗ Pasif</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d.m.Y') }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.users.toggle', $user) }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                {{ $user->is_active ? 'Pasifleştir' : 'Aktifleştir' }}
                            </button>
                        </form>
                        
                        @if(!$user->isAdmin())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Emin misiniz?')">Sil</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        {{ $users->links() }}
    @else
        <p style="text-align: center; opacity: 0.6;">Kullanıcı bulunamadı.</p>
    @endif
</div>
@endsection
