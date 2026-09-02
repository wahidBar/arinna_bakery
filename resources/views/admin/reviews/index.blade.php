@extends('layouts.admin')

@section('title', 'Kelola Ulasan Produk')

@section('content')
<div class="space-y-6">

    {{-- Page Header & Status Tabs --}}
    <div class="materio-card p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-[18px] font-bold text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2">
                    <i class="ri-star-smile-line text-[#8C57FF] text-2xl"></i> Ulasan & Testimoni Produk
                </h1>
                <p class="text-[12px] text-[#6B6678] dark:text-[#A5A3AE] mt-0.5">Moderasi rating bintang dan testimoni yang diberikan oleh pelanggan</p>
            </div>

            {{-- Tabs --}}
            <div class="flex items-center gap-2 bg-black/[0.04] dark:bg-white/[0.05] p-1.5 rounded-xl self-start sm:self-auto">
                <a href="{{ route('admin.reviews.index') }}"
                   class="px-4 py-2 rounded-lg text-[13px] font-semibold transition {{ !request('status') ? 'bg-[#8C57FF] text-white shadow-sm' : 'text-[#2E263D]/70 dark:text-[#EAEAFF]/70 hover:text-[#8C57FF]' }}">
                    Semua
                </a>
                <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}"
                   class="px-4 py-2 rounded-lg text-[13px] font-semibold transition {{ request('status') === 'pending' ? 'bg-[#8C57FF] text-white shadow-sm' : 'text-[#2E263D]/70 dark:text-[#EAEAFF]/70 hover:text-[#8C57FF]' }}">
                    Menunggu Persetujuan
                </a>
                <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}"
                   class="px-4 py-2 rounded-lg text-[13px] font-semibold transition {{ request('status') === 'approved' ? 'bg-[#8C57FF] text-white shadow-sm' : 'text-[#2E263D]/70 dark:text-[#EAEAFF]/70 hover:text-[#8C57FF]' }}">
                    Disetujui
                </a>
            </div>
        </div>
    </div>

    {{-- Reviews List --}}
    <form id="bulk-delete-reviews" method="POST" action="{{ route('admin.reviews.bulk-destroy') }}" onsubmit="return confirm('Hapus semua ulasan yang dipilih?')">
        @csrf @method('DELETE')
    </form>
    <div class="flex items-center justify-between gap-4">
        <button type="submit" form="bulk-delete-reviews" disabled class="bulk-delete-button inline-flex items-center gap-2 px-4 py-2 rounded-xl text-[13px] font-semibold text-rose-500 bg-rose-500/10 disabled:cursor-not-allowed disabled:opacity-40 transition">Hapus Terpilih (<span id="selected-reviews-count">0</span>)</button>
        <label class="text-[12px] text-stone-400"><input type="checkbox" id="select-all-reviews" class="mr-2 w-4 h-4 rounded border-stone-300 text-[#8C57FF] focus:ring-[#8C57FF]"> Pilih semua ulasan</label>
    </div>
    <div class="space-y-4">
        @forelse ($reviews as $review)
            <div class="materio-card p-6">
                <input type="checkbox" name="review_ids[]" value="{{ $review->id }}" form="bulk-delete-reviews" class="review-selection float-right w-4 h-4 rounded border-stone-300 text-[#8C57FF] focus:ring-[#8C57FF]" aria-label="Pilih ulasan">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-5">
                    <div class="space-y-3 flex-1 min-w-0">
                        {{-- Product & Reviewer Header --}}
                        <div class="flex items-center gap-3.5">
                            <div class="w-11 h-11 rounded-xl bg-amber-500/10 text-amber-500 flex items-center justify-center text-2xl shrink-0">
                                <i class="ri-cake-3-line"></i>
                            </div>
                            <div>
                                <h2 class="font-bold text-[15px] text-[#2E263D] dark:text-[#EAEAFF]">
                                    {{ $review->product->name ?? 'Produk Dihapus' }}
                                </h2>
                                <p class="text-[12px] text-stone-400">
                                    oleh <span class="font-semibold text-stone-600 dark:text-stone-300">{{ $review->user->name ?? 'Pengguna' }}</span> &middot; {{ $review->created_at->format('d M Y, H:i') }} WIB
                                </p>
                            </div>
                        </div>

                        {{-- Stars Rating --}}
                        <div class="flex items-center gap-1.5 text-amber-400 text-base">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $review->rating ? 'ri-star-fill' : 'ri-star-line text-stone-300 dark:text-stone-600' }}"></i>
                            @endfor
                            <span class="text-[13px] font-bold text-[#2E263D] dark:text-[#EAEAFF] ml-1.5">({{ $review->rating }}/5)</span>
                        </div>

                        {{-- Review Comment --}}
                        @if ($review->comment)
                            <p class="text-[14px] text-stone-600 dark:text-stone-300 bg-black/[0.02] dark:bg-white/[0.02] p-4 rounded-xl border border-black/5 dark:border-white/5 leading-relaxed">
                                "{{ $review->comment }}"
                            </p>
                        @endif
                    </div>

                    {{-- Moderation Action Buttons --}}
                    <div class="flex items-center gap-2.5 self-end sm:self-center shrink-0">
                        @if (!$review->is_approved)
                            <form method="POST" action="{{ route('admin.reviews.approve', $review) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-500 hover:text-white text-[13px] font-semibold transition">
                                    <i class="ri-check-line text-base"></i> Setujui
                                </button>
                            </form>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-[12px] font-bold">
                                <i class="ri-checkbox-circle-fill"></i> Disetujui
                            </span>
                        @endif

                        <form method="POST" action="{{ route('admin.reviews.reject', $review) }}" onsubmit="return confirm('Hapus ulasan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-rose-500/10 text-rose-600 dark:text-rose-400 hover:bg-rose-500 hover:text-white text-[13px] font-semibold transition">
                                <i class="ri-delete-bin-line text-base"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="materio-card p-16 text-center text-stone-400 text-[14px]">
                <i class="ri-star-line text-5xl block mb-2 text-stone-300"></i>
                Tidak ada ulasan produk yang ditemukan.
            </div>
        @endforelse
    </div>

    @if($reviews->hasPages())
        <div class="mt-6">
            {{ $reviews->links() }}
        </div>
    @endif

</div>
<script>
    (() => { const all = document.getElementById('select-all-reviews'); const items = [...document.querySelectorAll('.review-selection')]; const button = document.querySelector('#bulk-delete-reviews + div .bulk-delete-button'); const count = document.getElementById('selected-reviews-count'); const update = () => { const selected = items.filter((item) => item.checked).length; count.textContent = selected; button.disabled = selected === 0; all.checked = items.length > 0 && selected === items.length; }; all.addEventListener('change', () => { items.forEach((item) => { item.checked = all.checked; }); update(); }); items.forEach((item) => item.addEventListener('change', update)); })();
</script>
@endsection
