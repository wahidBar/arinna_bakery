@extends('layouts.admin')

@section('title', 'Tambah Pengguna')

@section('content')
<form method="POST" action="{{ route('admin.users.store') }}" class="max-w-lg bg-white rounded-2xl border border-amber-100 shadow-sm p-6 space-y-4">
    @csrf

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Nama</label>
        <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400" required>
        @error('name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400" required>
        @error('email') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Password</label>
        <input type="password" name="password" class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400" required>
        @error('password') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Role</label>
        <select name="role" class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400" required>
            <option value="customer" {{ old('role') === 'customer' ? 'selected' : '' }}>Customer</option>
            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Nomor Telepon</label>
        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
    </div>

    <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" checked> Aktif</label>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="bg-amber-700 text-white text-sm font-semibold rounded-full px-6 py-2.5 hover:bg-amber-800 shadow-sm transition">Simpan</button>
        <a href="{{ route('admin.users.index') }}" class="text-sm text-stone-500 self-center">Batal</a>
    </div>
</form>
@endsection
