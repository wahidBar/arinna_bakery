@extends('layouts.admin')

@section('title', 'Kelola Menu Navbar')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="materio-card p-6">
        <div>
            <h1 class="text-[18px] font-bold text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2">
                <i class="ri-menu-2-line text-[#8C57FF] text-2xl"></i> Menu Navigasi Website
            </h1>
            <p class="text-[12px] text-[#6B6678] dark:text-[#A5A3AE] mt-0.5">Atur tautan menu navbar publik toko dan seret (drag & drop) untuk mengatur urutan</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- Left 8-cols: Sortable Menu List --}}
        <div class="lg:col-span-8 materio-card p-6">
            <h2 class="text-[16px] font-bold text-[#2E263D] dark:text-[#EAEAFF] mb-4 flex items-center gap-2">
                <i class="ri-drag-drop-line text-[#8C57FF]"></i> Susunan Menu (Tarik untuk mengurutkan)
            </h2>

            <ul id="menu-list" class="space-y-3">
                @forelse ($menus as $menu)
                    <li data-id="{{ $menu->id }}"
                        class="flex items-center justify-between p-4 rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] hover:border-[#8C57FF] cursor-move transition shadow-sm group">
                        <div class="flex items-center gap-3.5">
                            <i class="ri-draggable text-stone-400 group-hover:text-[#8C57FF] text-xl"></i>
                            <div>
                                <p class="text-[14px] font-bold text-[#2E263D] dark:text-[#EAEAFF]">{{ $menu->label }}</p>
                                <p class="text-[12px] font-mono text-stone-400 mt-0.5">{{ $menu->url }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="text-[11px] font-bold px-3 py-1 rounded-full {{ $menu->is_active ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'bg-stone-500/10 text-stone-500' }}">
                                {{ $menu->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                            <form method="POST" action="{{ route('admin.settings.menus.destroy', $menu) }}" onsubmit="return confirm('Hapus menu {{ addslashes($menu->label) }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-8 h-8 rounded-lg flex items-center justify-center text-rose-500 hover:bg-rose-500/10 transition"
                                        title="Hapus Menu">
                                    <i class="ri-delete-bin-line text-base"></i>
                                </button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="py-12 text-center text-stone-400 text-[14px]">
                        Belum ada item menu navigasi yang ditambahkan.
                    </li>
                @endforelse
            </ul>
        </div>

        {{-- Right 4-cols: Add Menu Form Card --}}
        <div class="lg:col-span-4 materio-card p-6 h-fit space-y-4">
            <h2 class="text-[16px] font-bold text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2 pb-3 border-b border-black/5 dark:border-white/5">
                <i class="ri-add-line text-[#8C57FF]"></i> Tambah Menu Baru
            </h2>

            <form method="POST" action="{{ route('admin.settings.menus.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                        Label Menu <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="label" placeholder="contoh: Produk Promo, Paket Hampers"
                           class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]"
                           required>
                </div>

                <div>
                    <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                        Tautan / URL <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="url" placeholder="/products atau https://..."
                           class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-4 py-2.5 text-[14px] font-mono text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]"
                           required>
                </div>

                <div class="space-y-2 pt-1">
                    <label class="flex items-center gap-2.5 cursor-pointer text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF]">
                        <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 rounded accent-[#8C57FF]">
                        Status Aktif
                    </label>
                    <label class="flex items-center gap-2.5 cursor-pointer text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF]">
                        <input type="checkbox" name="open_new_tab" value="1" class="w-4 h-4 rounded accent-[#8C57FF]">
                        Buka di Tab Baru
                    </label>
                </div>

                <button type="submit"
                        class="w-full py-3 rounded-xl bg-gradient-to-r from-[#8C57FF] to-[#9E77FF] text-white text-[14px] font-bold shadow-md shadow-[#8C57FF]/35 hover:opacity-95 transition flex items-center justify-center gap-2">
                    <i class="ri-add-circle-line text-lg"></i> Tambahkan ke Menu
                </button>
            </form>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const list = document.getElementById('menu-list');
    if (!list) return;

    new Sortable(list, {
        animation: 200,
        handle: '.cursor-move',
        onEnd: function () {
            const order = Array.from(document.querySelectorAll('#menu-list li')).map(li => li.dataset.id);

            fetch("{{ route('admin.settings.menus.reorder') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ order }),
            });
        },
    });
});
</script>
@endpush
