@extends('layouts.admin')

@section('page-title', 'Informasi Umum')
@section('page-subtitle', 'Website Settings')

@php
    // $settings adalah Collection hasil pluck('value', 'key') dari SiteSetting.
    $val = fn (string $key, $default = '') => old($key, $settings[$key] ?? $default);
    $days = [
        'hour_monday' => 'Senin',
        'hour_tuesday' => 'Selasa',
        'hour_wednesday' => 'Rabu',
        'hour_thursday' => 'Kamis',
        'hour_friday' => 'Jumat',
        'hour_saturday' => 'Sabtu',
        'hour_sunday' => 'Minggu',
    ];
@endphp

@section('content')
    <div class="max-w-4xl">
        <form action="{{ route('admin.settings.general.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Identitas Situs --}}
            <div class="bg-white rounded-xl border border-amber-100 shadow-sm p-6">
                <h2 class="font-display text-base font-semibold text-stone-900 mb-1">Identitas Situs</h2>
                <p class="text-sm text-stone-400 mb-5">Nama & logo yang tampil di navbar dan footer.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Nama Situs / Toko</label>
                        <input type="text" name="site_name" value="{{ $val('site_name', 'Arinna Hidayah Bakery') }}"
                               class="w-full rounded-lg border-amber-200 focus:border-[#b45309] focus:ring-[#b45309] text-sm" required>
                        @error('site_name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Logo</label>
                        <div class="flex items-center gap-3">
                            @if ($settings['logo'] ?? null)
                                <img src="{{ Storage::url($settings['logo']) }}" alt="Logo saat ini"
                                     class="w-12 h-12 rounded-lg object-cover border border-amber-100 shrink-0">
                            @endif
                            <input type="file" name="logo" accept="image/*"
                                   class="block w-full text-sm text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#b45309] file:text-white file:text-sm hover:file:bg-[#92400e]">
                        </div>
                        @error('logo') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Kontak --}}
            <div class="bg-white rounded-xl border border-amber-100 shadow-sm p-6">
                <h2 class="font-display text-base font-semibold text-stone-900 mb-1">Kontak</h2>
                <p class="text-sm text-stone-400 mb-5">Ditampilkan di halaman Contact dan footer.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ $val('email') }}"
                               class="w-full rounded-lg border-amber-200 focus:border-[#b45309] focus:ring-[#b45309] text-sm" required>
                        @error('email') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">No. Telepon</label>
                        <input type="text" name="phone" value="{{ $val('phone') }}"
                               class="w-full rounded-lg border-amber-200 focus:border-[#b45309] focus:ring-[#b45309] text-sm" required>
                        @error('phone') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">No. WhatsApp</label>
                        <input type="text" name="whatsapp" value="{{ $val('whatsapp') }}" placeholder="628221234567"
                               class="w-full rounded-lg border-amber-200 focus:border-[#b45309] focus:ring-[#b45309] text-sm">
                        @error('whatsapp') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Alamat</label>
                        <textarea name="address" rows="2"
                                  class="w-full rounded-lg border-amber-200 focus:border-[#b45309] focus:ring-[#b45309] text-sm" required>{{ $val('address') }}</textarea>
                        @error('address') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Embed Google Maps (iframe URL)</label>
                        <input type="text" name="maps_embed" value="{{ $val('maps_embed') }}"
                               placeholder="https://www.google.com/maps/embed?pb=..."
                               class="w-full rounded-lg border-amber-200 focus:border-[#b45309] focus:ring-[#b45309] text-sm font-mono">
                        <p class="mt-1 text-xs text-stone-400">Ambil dari tombol "Bagikan → Sematkan peta" di Google Maps, salin bagian src="...".</p>
                        @error('maps_embed') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Jam Operasional --}}
            <div class="bg-white rounded-xl border border-amber-100 shadow-sm p-6">
                <h2 class="font-display text-base font-semibold text-stone-900 mb-1">Jam Operasional</h2>
                <p class="text-sm text-stone-400 mb-5">Kosongkan / isi "Tutup" untuk hari libur.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach ($days as $key => $label)
                        <div class="flex items-center gap-3">
                            <span class="w-16 text-sm text-stone-600 shrink-0">{{ $label }}</span>
                            <input type="text" name="{{ $key }}" value="{{ $val($key) }}" placeholder="08:00 - 21:00"
                                   class="flex-1 rounded-lg border-amber-200 focus:border-[#b45309] focus:ring-[#b45309] text-sm">
                        </div>
                        @error($key) <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    @endforeach
                </div>
            </div>

            {{-- Sosial Media --}}
            <div class="bg-white rounded-xl border border-amber-100 shadow-sm p-6">
                <h2 class="font-display text-base font-semibold text-stone-900 mb-1">Sosial Media</h2>
                <p class="text-sm text-stone-400 mb-5">Tautan yang tampil di footer.</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Instagram</label>
                        <input type="text" name="instagram" value="{{ $val('instagram') }}" placeholder="arinnahidayah_bakery"
                               class="w-full rounded-lg border-amber-200 focus:border-[#b45309] focus:ring-[#b45309] text-sm">
                        @error('instagram') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Facebook</label>
                        <input type="text" name="facebook" value="{{ $val('facebook') }}"
                               class="w-full rounded-lg border-amber-200 focus:border-[#b45309] focus:ring-[#b45309] text-sm">
                        @error('facebook') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">TikTok</label>
                        <input type="text" name="tiktok" value="{{ $val('tiktok') }}" placeholder="arinnahidayahbakery"
                               class="w-full rounded-lg border-amber-200 focus:border-[#b45309] focus:ring-[#b45309] text-sm">
                        @error('tiktok') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit"
                        class="bg-[#b45309] hover:bg-[#92400e] text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
@endsection
