@extends('layouts.admin')

@section('title', 'Kelola Menu Navbar')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="lg:col-span-2 bg-white rounded-2xl border border-amber-100 shadow-sm p-6">
        <h3 class="font-display font-semibold text-stone-900 mb-4">Daftar Menu (drag untuk urutkan)</h3>
        <ul id="menu-list" class="space-y-2">
            @foreach ($menus as $menu)
                <li data-id="{{ $menu->id }}" class="flex items-center justify-between border border-amber-100 rounded-lg px-4 py-3 cursor-move bg-stone-50">
                    <div>
                        <p class="text-sm font-medium">{{ $menu->label }}</p>
                        <p class="text-xs text-stone-400">{{ $menu->url }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-xs px-2 py-1 rounded-full {{ $menu->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-stone-200 text-stone-500' }}">
                            {{ $menu->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                        <form method="POST" action="{{ route('admin.settings.menus.destroy', $menu) }}" onsubmit="return confirm('Hapus menu ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-rose-600 text-xs hover:underline">Hapus</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-6 h-fit">
        <h3 class="font-display font-semibold text-stone-900 mb-4">Tambah Menu</h3>
        <form method="POST" action="{{ route('admin.settings.menus.store') }}" class="space-y-3">
            @csrf
            <div>
                <label class="text-sm font-semibold text-stone-700 block mb-1.5">Label</label>
                <input type="text" name="label" class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400" required>
            </div>
            <div>
                <label class="text-sm font-semibold text-stone-700 block mb-1.5">URL</label>
                <input type="text" name="url" placeholder="/products" class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400" required>
            </div>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" checked> Aktif</label>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="open_new_tab" value="1"> Buka tab baru</label>
            <button type="submit" class="w-full bg-amber-700 text-white text-sm font-medium rounded-lg py-2.5 hover:bg-amber-800">Tambah</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
new Sortable(document.getElementById('menu-list'), {
    animation: 150,
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
</script>
@endpush
