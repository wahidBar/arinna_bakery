@extends('layouts.admin')

@section('title', 'Tambah Anggota Tim')

@section('content')
<div class="space-y-5">

    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-[18px] font-bold text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2">
                <i class="ri-user-add-line text-[#8C57FF] text-2xl"></i> Tambah Anggota Tim
            </h1>
            <p class="text-[12px] text-[#6B6678] dark:text-[#A5A3AE] mt-0.5">Daftarkan profil tim, baker, atau staf toko</p>
        </div>
        <a href="{{ route('admin.settings.team-members.index') }}"
           class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-[13px] font-medium border border-black/10 dark:border-white/10 hover:bg-black/5 dark:hover:bg-white/5 text-[#2E263D] dark:text-[#EAEAFF] transition">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
    </div>

    <div class="materio-card p-5 sm:p-6">
        <form method="POST" action="{{ route('admin.settings.team-members.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="contoh: Arinna Hidayah"
                           class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF] @error('name') border-rose-400 @enderror"
                           required>
                    @error('name') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                        Jabatan / Posisi <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="role" value="{{ old('role') }}" placeholder="contoh: Head Baker & Founder"
                           class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF] @error('role') border-rose-400 @enderror"
                           required>
                    @error('role') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                    Foto Profil <span class="text-stone-400 font-normal">(opsional)</span>
                </label>
                <input type="file" name="photo" accept="image/*"
                       class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-4 py-2 text-[13px] text-stone-500 focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
                <p class="text-[11px] text-stone-400 mt-1">Format foto rasio 1:1 persegi, maks 2MB</p>
                @error('photo') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">Facebook</label>
                    <input type="url" name="facebook" value="{{ old('facebook') }}" placeholder="https://facebook.com/..."
                           class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
                </div>

                <div>
                    <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">Instagram</label>
                    <input type="url" name="instagram" value="{{ old('instagram') }}" placeholder="https://instagram.com/..."
                           class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
                </div>

                <div>
                    <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">LinkedIn</label>
                    <input type="url" name="linkedin" value="{{ old('linkedin') }}" placeholder="https://linkedin.com/in/..."
                           class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
                </div>
            </div>

            <div>
                <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">Urutan Tampil</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                       class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-3 cursor-pointer text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF]">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true)) class="w-4 h-4 rounded accent-[#8C57FF]">
                    Tampilkan di Halaman Web
                </label>
            </div>

            <div class="pt-4 border-t border-black/5 dark:border-white/5 flex items-center gap-3">
                <button type="submit"
                        class="px-5 py-2 rounded-lg bg-gradient-to-r from-[#8C57FF] to-[#9E77FF] text-white text-[13px] font-semibold shadow-md shadow-[#8C57FF]/35 hover:opacity-95 transition flex items-center gap-2">
                    <i class="ri-check-line text-base"></i> Simpan Anggota
                </button>
                <a href="{{ route('admin.settings.team-members.index') }}"
                   class="px-4 py-2 rounded-lg text-[13px] font-medium text-stone-500 hover:text-stone-700 dark:hover:text-stone-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
