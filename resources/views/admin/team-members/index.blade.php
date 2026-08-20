@extends('layouts.admin')

@section('page-title', 'Tim Kami')
@section('page-subtitle', 'Website Settings')

@section('content')
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="font-display text-xl font-semibold text-stone-900">Anggota Tim</h2>
            <p class="text-sm text-stone-400">{{ $members->count() }} anggota terdaftar</p>
        </div>
        <a href="{{ route('admin.settings.team-members.create') }}"
           class="inline-flex items-center gap-2 bg-[#b45309] hover:bg-[#92400e] text-white text-sm font-medium px-4 py-2.5 rounded-lg transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Anggota
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse ($members as $member)
            <div class="bg-white rounded-xl border border-amber-100 shadow-sm p-5 flex gap-4 items-center">
                @if($member->photo)
                    <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}"
                         class="w-14 h-14 rounded-full object-cover shrink-0 border-2 border-amber-100">
                @else
                    <div class="w-14 h-14 rounded-full bg-amber-100 flex items-center justify-center shrink-0">
                        <span class="font-bold text-xl text-amber-700">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                    </div>
                @endif
                <div class="min-w-0 flex-1">
                    <p class="font-semibold text-stone-800 truncate">{{ $member->name }}</p>
                    <p class="text-sm text-stone-500">{{ $member->role }}</p>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="text-xs px-2 py-0.5 rounded-full {{ $member->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-stone-100 text-stone-500' }}">
                            {{ $member->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                        <span class="text-xs text-stone-400">Urutan: {{ $member->sort_order }}</span>
                    </div>
                </div>
                <div class="flex flex-col gap-2 shrink-0">
                    <a href="{{ route('admin.settings.team-members.edit', $member) }}"
                       class="text-xs font-medium text-amber-700 hover:underline">Edit</a>
                    <form method="POST" action="{{ route('admin.settings.team-members.destroy', $member) }}"
                          onsubmit="return confirm('Hapus anggota {{ $member->name }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs font-medium text-rose-500 hover:underline">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-3 py-16 text-center text-stone-400">
                Belum ada anggota tim. Klik "Tambah Anggota" untuk menambahkan yang pertama.
            </div>
        @endforelse
    </div>
@endsection
