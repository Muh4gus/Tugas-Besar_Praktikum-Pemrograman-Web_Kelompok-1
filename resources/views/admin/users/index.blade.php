@extends('layouts.admin')
@section('title', 'Pengguna')
@section('content')
    <div class="page-header">
        <h1 class="page-title">Pengguna</h1>
    </div>
    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Total Bid</th>
                    <th>Menang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td style="display: flex; align-items: center; gap: 1rem;">
                            <img src="{{ $user->avatar_url }}" style="width: 40px; height: 40px; border-radius: 50%;">
                            <span>{{ $user->name }}</span>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>@if($user->role == 'admin')<span class="badge badge-primary">Admin</span>@else<span
                        class="badge badge-success">User</span>@endif</td>
                        <td>{{ $user->bids_count }}</td>
                        <td>{{ $user->won_auctions_count }}</td>
                        <td>
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.update-role', $user->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf @method('PUT')
                                    <select name="role" onchange="this.form.submit()" class="form-control"
                                        style="display: inline; width: auto; padding: 0.25rem 0.5rem;">
                                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </form>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;"
                                    onsubmit="return confirm('Yakin hapus?')">@csrf @method('DELETE')<button
                                        class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
                            @else<span class="text-muted">-</span>@endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center" style="padding: 2rem; color: var(--gray-400);">Belum ada pengguna
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top: 1rem;">{{ $users->links() }}</div>
@endsection