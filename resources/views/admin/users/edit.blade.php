@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')
<form method="POST" action="{{ route('admin.users.update', $user) }}" class="max-w-lg bg-white rounded-2xl border border-amber-100 shadow-sm p-6 space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Nama</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400" required>
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400" required>
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Password (kosongkan jika tidak ingin ganti)</label>
        <input type="password" name="password" class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Role</label>
        <select name="role" class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400" required>
            <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Nomor Telepon</label>
        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
    </div>

    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }}> Aktif
    </label>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="bg-amber-700 text-white text-sm font-semibold rounded-full px-6 py-2.5 hover:bg-amber-800 shadow-sm transition">Simpan Perubahan</button>
        <a href="{{ route('admin.users.index') }}" class="text-sm text-stone-500 self-center">Batal</a>
    </div>
</form>
@endsection
