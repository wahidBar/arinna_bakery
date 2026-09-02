@extends('layouts.admin')

@section('title', 'Tim Kami')

@section('content')
<div class="space-y-6">

    {{-- Header Card --}}
    <div class="materio-card p-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2">
                    <i class="ri-team-line text-[#8C57FF] text-xl"></i> Profil Tim & Baker
                </h2>
                <p class="text-xs text-[#6B6678] dark:text-[#A5A3AE] mt-0.5">Kelola data profil anggota tim bakery yang tampil pada halaman About Us</p>
            </div>

            <a href="{{ route('admin.settings.team-members.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-[#8C57FF] to-[#9E77FF] text-white text-xs font-bold shadow-md shadow-[#8C57FF]/30 hover:opacity-95 transition self-start sm:self-auto">
                <i class="ri-user-add-line text-base"></i> Tambah Anggota Tim
            </a>
        </div>
    </div>

    {{-- Team Cards Grid --}}
    <form id="bulk-delete-members" method="POST" action="{{ route('admin.settings.team-members.bulk-destroy') }}" onsubmit="return confirm('Hapus semua anggota tim yang dipilih?')">
        @csrf @method('DELETE')
    </form>
    <div class="flex items-center justify-between gap-4">
        <button type="submit" form="bulk-delete-members" disabled class="bulk-delete-button inline-flex items-center gap-2 px-4 py-2 rounded-xl text-[13px] font-semibold text-rose-500 bg-rose-500/10 disabled:cursor-not-allowed disabled:opacity-40 transition">Hapus Terpilih (<span id="selected-members-count">0</span>)</button>
        <label class="text-[12px] text-stone-400"><input type="checkbox" id="select-all-members" class="mr-2 w-4 h-4 rounded border-stone-300 text-[#8C57FF] focus:ring-[#8C57FF]"> Pilih semua anggota</label>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse ($members as $member)
            <div class="materio-card p-5 flex items-center justify-between gap-4 group hover:border-[#8C57FF]/40 transition">
                <input type="checkbox" name="member_ids[]" value="{{ $member->id }}" form="bulk-delete-members" class="member-selection mr-2 w-4 h-4 rounded border-stone-300 text-[#8C57FF] focus:ring-[#8C57FF]" aria-label="Pilih {{ $member->name }}">
                <div class="flex items-center gap-3.5 min-w-0">
                    @if($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}"
                             class="w-14 h-14 rounded-2xl object-cover border border-[#8C57FF]/20 shrink-0">
                    @else
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-[#8C57FF] to-[#9E77FF] text-white font-bold text-xl flex items-center justify-center shrink-0 shadow-sm">
                            {{ strtoupper(substr($member->name, 0, 1)) }}
                        </div>
                    @endif

                    <div class="min-w-0">
                        <p class="font-bold text-xs text-[#2E263D] dark:text-[#EAEAFF] truncate">{{ $member->name }}</p>
                        <p class="text-[11px] text-[#8C57FF] font-semibold truncate">{{ $member->role }}</p>
                        <div class="flex items-center gap-2 mt-1.5">
                            <span class="inline-flex items-center gap-1 px-2 py-0.2 rounded-full text-[10px] font-semibold {{ $member->is_active ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'bg-stone-500/10 text-stone-500' }}">
                                {{ $member->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                            <span class="text-[10px] text-stone-400">#{{ $member->sort_order }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-1.5 shrink-0">
                    <a href="{{ route('admin.settings.team-members.edit', $member) }}"
                       class="w-8 h-8 rounded-lg flex items-center justify-center text-[#8C57FF] hover:bg-[#8C57FF]/10 transition"
                       title="Edit Anggota">
                        <i class="ri-edit-box-line text-base"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.settings.team-members.destroy', $member) }}"
                          onsubmit="return confirm('Hapus anggota {{ addslashes($member->name) }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-8 h-8 rounded-lg flex items-center justify-center text-rose-500 hover:bg-rose-500/10 transition"
                                title="Hapus Anggota">
                            <i class="ri-delete-bin-line text-base"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full materio-card p-12 text-center text-stone-400 text-xs">
                <i class="ri-team-line text-4xl block mb-2 text-stone-300"></i>
                Belum ada anggota tim terdaftar.
            </div>
        @endforelse
    </div>

</div>
<script>
    (() => { const all = document.getElementById('select-all-members'); const items = [...document.querySelectorAll('.member-selection')]; const button = document.querySelector('#bulk-delete-members + div .bulk-delete-button'); const count = document.getElementById('selected-members-count'); const update = () => { const selected = items.filter((item) => item.checked).length; count.textContent = selected; button.disabled = selected === 0; all.checked = items.length > 0 && selected === items.length; }; all.addEventListener('change', () => { items.forEach((item) => { item.checked = all.checked; }); update(); }); items.forEach((item) => item.addEventListener('change', update)); })();
</script>
@endsection
