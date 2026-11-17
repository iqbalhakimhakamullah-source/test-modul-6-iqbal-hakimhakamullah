@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
    <h2>Kelola Pengguna & Role</h2>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #d7ccc8; margin-top: 20px;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f3f4f6;">
                    <th style="padding: 10px; border: 1px solid #ddd;">Nama</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Email</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Role Saat Ini</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Aksi (Ubah Role)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $user->name }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $user->email }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <span style="background: #5d4037; color: white; padding: 3px 8px; border-radius: 4px; font-size: 12px;">
                            {{ $user->getRoleNames()->first() ?? 'Tanpa Role' }}
                        </span>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <form action="{{ route('users.updateRole', $user->id) }}" method="POST" style="display: flex; gap: 10px;">
                            @csrf
                            @method('PUT')
                            <select name="role" style="padding: 5px; border: 1px solid #ccc; border-radius: 4px;">
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn" style="padding: 5px 15px;">Simpan</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection