@extends('layouts.admin')

@section('page-title', 'Edit Anggota Tim')
@section('page-subtitle', 'Website Settings')

@section('content')
<form method="POST" action="{{ route('admin.settings.team-members.update', $teamMember) }}" enctype="multipart/form-data"
      class="max-w-lg bg-white rounded-2xl border border-amber-100 shadow-sm p-6 space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Nama Lengkap</label>
        <input type="text" name="name" value="{{ old('name', $teamMember->name) }}"
               class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400" required>
        @error('name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Jabatan / Peran</label>
        <input type="text" name="role" value="{{ old('role', $teamMember->role) }}"
               class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400" required>
        @error('role') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Foto (kosongkan jika tidak diganti)</label>
        @if($teamMember->photo)
            <img src="{{ asset('storage/' . $teamMember->photo) }}" alt="{{ $teamMember->name }}"
                 class="w-20 h-20 rounded-full object-cover mb-2 border-2 border-amber-100">
        @endif
        <input type="file" name="photo" accept="image/*"
               class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
        @error('photo') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Link Facebook (opsional)</label>
        <input type="url" name="facebook" value="{{ old('facebook', $teamMember->facebook) }}"
               class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
        @error('facebook') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Link Instagram (opsional)</label>
        <input type="url" name="instagram" value="{{ old('instagram', $teamMember->instagram) }}"
               class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
        @error('instagram') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Link LinkedIn (opsional)</label>
        <input type="url" name="linkedin" value="{{ old('linkedin', $teamMember->linkedin) }}"
               class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
        @error('linkedin') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Urutan Tampil</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $teamMember->sort_order) }}"
               class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
    </div>

    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $teamMember->is_active))> Tampilkan di halaman web
    </label>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="bg-amber-700 text-white text-sm font-semibold rounded-full px-6 py-2.5 hover:bg-amber-800 shadow-sm transition">
            Perbarui
        </button>
        <a href="{{ route('admin.settings.team-members.index') }}" class="text-sm text-stone-500 self-center">Batal</a>
    </div>
</form>
@endsection
