@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="flex items-center justify-between mb-6">
    <form method="GET" class="flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email..."
            class="border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 w-64">
        <select name="role" class="border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
            <option value="">Semua Role</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
        </select>
        <button type="submit" class="bg-stone-900 text-white text-sm font-semibold rounded-full px-4 py-2">Cari</button>
    </form>

    <a href="{{ route('admin.users.create') }}" class="bg-amber-700 text-white text-sm font-semibold rounded-full px-5 py-2.5 hover:bg-amber-800 shadow-sm transition">
        + Tambah User
    </a>
</div>

<div class="bg-white rounded-2xl border border-amber-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-amber-50/60 text-stone-500">
            <tr class="text-left">
                <th class="px-4 py-3">Nama</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3">Role</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr class="border-t border-amber-50">
                <td class="px-4 py-3 font-medium">
                    <a href="{{ route('admin.users.show', $user) }}" class="hover:text-[#6c7fd8]">{{ $user->name }}</a>
                </td>
                <td class="px-4 py-3">{{ $user->email }}</td>
                <td class="px-4 py-3 capitalize">{{ $user->role }}</td>
                <td class="px-4 py-3">
                    <span class="text-xs px-2 py-1 rounded-full {{ $user->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-stone-100 text-stone-500' }}">
                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-amber-700 font-medium hover:underline">Edit</a>
                        @if ($user->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus user ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-rose-600 font-medium hover:underline">Hapus</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $users->links() }}</div>
@endsection