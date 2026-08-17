@extends('layouts.admin')

@section('title', 'Kelola Ulasan')

@section('content')
<div class="flex gap-2 mb-6">
    <a href="{{ route('admin.reviews.index') }}" class="text-xs font-medium px-4 py-2 rounded-full {{ !request('status') ? 'bg-amber-700 text-white' : 'bg-white text-stone-600' }}">Semua</a>
    <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}" class="text-xs font-medium px-4 py-2 rounded-full {{ request('status') === 'pending' ? 'bg-amber-700 text-white' : 'bg-white text-stone-600' }}">Menunggu Persetujuan</a>
    <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}" class="text-xs font-medium px-4 py-2 rounded-full {{ request('status') === 'approved' ? 'bg-amber-700 text-white' : 'bg-white text-stone-600' }}">Disetujui</a>
</div>

<div class="space-y-4">
    @forelse ($reviews as $review)
        <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="font-medium text-sm">{{ $review->product->name }}</p>
                    <p class="text-xs text-stone-400 mb-2">oleh {{ $review->user->name }} &middot; {{ $review->created_at->format('d M Y') }}</p>
                    <p class="text-yellow-500 text-sm mb-1">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</p>
                    @if ($review->comment)
                        <p class="text-sm text-stone-600">{{ $review->comment }}</p>
                    @endif
                </div>

                <div class="flex gap-2 shrink-0">
                    @if (!$review->is_approved)
                        <form method="POST" action="{{ route('admin.reviews.approve', $review) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-xs font-semibold bg-emerald-600 text-white px-3.5 py-1.5 rounded-full hover:bg-emerald-700 transition">Setujui</button>
                        </form>
                    @endif
                    <form method="POST" action="{{ route('admin.reviews.reject', $review) }}" onsubmit="return confirm('Tolak dan hapus ulasan ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs font-semibold bg-rose-100 text-rose-700 px-3.5 py-1.5 rounded-full hover:bg-rose-200 transition">Tolak</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p class="text-stone-400 text-center py-16">Tidak ada ulasan.</p>
    @endforelse
</div>

<div class="mt-6">{{ $reviews->links() }}</div>
@endsection
