@extends('layouts.admin')

@section('title', 'Informasi Umum & Pengaturan')

@php
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
<div class="space-y-5">

    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-[18px] font-bold text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2">
                <i class="ri-settings-4-line text-[#8C57FF] text-2xl"></i> Informasi Umum & Pengaturan Website
            </h1>
            <p class="text-[12px] text-[#6B6678] dark:text-[#A5A3AE] mt-0.5">Konfigurasi identitas toko, kontak, jam operasional, dan tautan media sosial</p>
        </div>
    </div>

    <form action="{{ route('admin.settings.general.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- SECTION 1: Identitas Situs & Logo --}}
        <div class="materio-card p-5 sm:p-6 space-y-5">
            <div class="pb-3.5 border-b border-black/5 dark:border-white/5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-[#8C57FF]/10 text-[#8C57FF] flex items-center justify-center text-xl">
                    <i class="ri-store-2-line"></i>
                </div>
                <div>
                    <h2 class="text-[15px] font-bold text-[#2E263D] dark:text-[#EAEAFF]">Identitas Toko</h2>
                    <p class="text-[12px] text-stone-400">Nama toko dan logo resmi yang tampil pada navbar & footer</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                        Nama Toko / Brand <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="site_name" value="{{ $val('site_name', 'Arinna Hidayah Bakery') }}"
                           class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]"
                           required>
                    @error('site_name') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                        Logo Toko <span class="text-stone-400 font-normal">(opsional)</span>
                    </label>
                    <div class="flex items-center gap-3">
                        @if ($settings['logo'] ?? null)
                            <img src="{{ Storage::url($settings['logo']) }}" alt="Logo"
                                 class="w-9 h-9 rounded-lg object-contain bg-black/[0.03] dark:bg-white/[0.04] p-1 border border-[#8C57FF]/20 shrink-0">
                        @endif
                        <input type="file" name="logo" accept="image/*"
                               class="w-full text-[13px] text-stone-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-[#8C57FF]/10 file:text-[#8C57FF] file:font-semibold hover:file:bg-[#8C57FF]/20 cursor-pointer">
                    </div>
                    @error('logo') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- SECTION 2: Kontak & Lokasi --}}
        <div class="materio-card p-5 sm:p-6 space-y-5">
            <div class="pb-4 border-b border-black/5 dark:border-white/5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center text-xl">
                    <i class="ri-contacts-line"></i>
                </div>
                <div>
                    <h2 class="text-[16px] font-bold text-[#2E263D] dark:text-[#EAEAFF]">Kontak & Alamat Toko</h2>
                    <p class="text-[13px] text-stone-400">Informasi kontak dan alamat yang ditampilkan kepada pelanggan</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ $val('email') }}"
                           class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]"
                           required>
                    @error('email') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                        Nomor Telepon <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="phone" value="{{ $val('phone') }}"
                           class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]"
                           required>
                    @error('phone') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                        Nomor WhatsApp
                    </label>
                    <input type="text" name="whatsapp" value="{{ $val('whatsapp') }}" placeholder="628221234567"
                           class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
                    @error('whatsapp') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-3">
                    <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                        Alamat Lengkap Toko <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="address" rows="2"
                              class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]"
                              required>{{ $val('address') }}</textarea>
                    @error('address') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-3">
                    <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                        Embed Google Maps (URL iframe)
                    </label>
                    <input type="text" name="maps_embed" value="{{ $val('maps_embed') }}"
                           placeholder="https://www.google.com/maps/embed?pb=..."
                           class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] font-mono text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
                </div>
            </div>
        </div>

        {{-- SECTION 3: Jam Operasional --}}
        <div class="materio-card p-5 sm:p-6 space-y-5">
            <div class="pb-4 border-b border-black/5 dark:border-white/5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-500/10 text-amber-500 flex items-center justify-center text-xl">
                    <i class="ri-time-line"></i>
                </div>
                <div>
                    <h2 class="text-[16px] font-bold text-[#2E263D] dark:text-[#EAEAFF]">Jam Operasional Toko</h2>
                    <p class="text-[13px] text-stone-400">Jadwal buka dan tutup harian (isi "Tutup" jika hari libur)</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ($days as $key => $label)
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-black/[0.02] dark:bg-white/[0.02] border border-black/5 dark:border-white/5">
                        <span class="w-24 text-[13px] font-bold text-[#2E263D] dark:text-[#EAEAFF] shrink-0">{{ $label }}</span>
                        <input type="text" name="{{ $key }}" value="{{ $val($key) }}" placeholder="08:00 - 21:00"
                               class="flex-1 rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
                    </div>
                @endforeach
            </div>
        </div>

        {{-- SECTION 4: Media Sosial --}}
        <div class="materio-card p-5 sm:p-6 space-y-5">
            <div class="pb-4 border-b border-black/5 dark:border-white/5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-[#16B1FF]/10 text-[#16B1FF] flex items-center justify-center text-xl">
                    <i class="ri-share-line"></i>
                </div>
                <div>
                    <h2 class="text-[16px] font-bold text-[#2E263D] dark:text-[#EAEAFF]">Media Sosial</h2>
                    <p class="text-[13px] text-stone-400">Username atau tautan profil akun resmi toko</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5 flex items-center gap-1.5">
                        <i class="ri-instagram-line text-pink-500 text-base"></i> Instagram
                    </label>
                    <input type="text" name="instagram" value="{{ $val('instagram') }}" placeholder="arinnahidayah_bakery"
                           class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
                </div>

                <div>
                    <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5 flex items-center gap-1.5">
                        <i class="ri-facebook-circle-line text-blue-600 text-base"></i> Facebook
                    </label>
                    <input type="text" name="facebook" value="{{ $val('facebook') }}"
                           class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
                </div>

                <div>
                    <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5 flex items-center gap-1.5">
                        <i class="ri-tiktok-line text-stone-800 dark:text-white text-base"></i> TikTok
                    </label>
                    <input type="text" name="tiktok" value="{{ $val('tiktok') }}" placeholder="arinnahidayahbakery"
                           class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
                </div>
            </div>
        </div>

        {{-- Save Button --}}
        <div class="flex items-center gap-3">
            <button type="submit"
                    class="px-5 py-2 rounded-lg bg-gradient-to-r from-[#8C57FF] to-[#9E77FF] text-white text-[13px] font-semibold shadow-md shadow-[#8C57FF]/35 hover:opacity-95 transition flex items-center gap-2">
                <i class="ri-check-line text-base"></i> Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection
