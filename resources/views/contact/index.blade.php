@extends('layouts.app')

@section('title', 'Kontak Kami')

@section('content')
@include('partials.breadcrumb', ['items' => [['label' => 'Kontak Kami']]])
<div class="max-w-6xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-2 gap-10">

    <div>
        <h1 class="font-display text-3xl font-bold text-stone-900 mb-6">Hubungi Kami</h1>

        <form method="POST" action="{{ route('contact.store') }}" class="bg-white rounded-2xl border border-amber-100 shadow-sm p-6 space-y-4">
            @csrf

            @if (session('success'))
                <div class="bg-emerald-50 text-emerald-700 text-sm rounded-xl px-4 py-3 border border-emerald-200">{{ session('success') }}</div>
            @endif

            <div>
                <label class="text-sm font-medium block mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-amber-100 rounded-lg px-3 py-2 text-sm" required>
                @error('name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-sm font-medium block mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-amber-100 rounded-lg px-3 py-2 text-sm" required>
                @error('email') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-sm font-medium block mb-1">Pesan</label>
                <textarea name="message" rows="5" class="w-full border border-amber-100 rounded-lg px-3 py-2 text-sm" required>{{ old('message') }}</textarea>
                @error('message') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="bg-amber-700 text-white text-sm font-medium rounded-full px-6 py-2.5 hover:bg-amber-800">
                Kirim Pesan
            </button>
        </form>
    </div>

    <div>
        <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-6 mb-6">
            <h3 class="font-semibold mb-4">Informasi Kontak</h3>
            <ul class="space-y-2 text-sm text-stone-600">
                <li><span class="font-medium">Email:</span> {{ $settings['email'] }}</li>
                <li><span class="font-medium">Telepon/WA:</span> {{ $settings['phone'] }}</li>
                <li><span class="font-medium">Alamat:</span> {{ $settings['address'] }}</li>
            </ul>
        </div>

        <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-6 mb-6">
            <h3 class="font-semibold mb-4">Jam Operasional</h3>
            <ul class="text-sm text-stone-600 space-y-1">
                @foreach ($settings['hours'] as $day => $hour)
                    <li class="flex justify-between"><span>{{ $day }}</span><span>{{ $hour ?: '-' }}</span></li>
                @endforeach
            </ul>
        </div>

        @if (!empty($settings['maps_embed']))
            <div class="rounded-xl overflow-hidden shadow-sm">
                {!! $settings['maps_embed'] !!}
            </div>
        @endif
    </div>
</div>
@endsection
