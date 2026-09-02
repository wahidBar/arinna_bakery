@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="space-y-6">

    {{-- Page Header & Toolbar Card --}}
    <div class="materio-card p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-[18px] font-bold text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2">
                    <i class="ri-user-3-line text-[#8C57FF] text-2xl"></i> Manajemen Pengguna
                </h1>
                <p class="text-[12px] text-[#6B6678] dark:text-[#A5A3AE] mt-0.5">Daftar seluruh akun customer dan administrator toko</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <form method="GET" class="flex flex-wrap items-center gap-2.5 flex-1 sm:flex-initial">
                    {{-- Search --}}
                    <div class="relative flex-1 sm:w-64">
                        <i class="ri-search-line absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 text-lg"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, hp..."
                               class="w-full pl-10 pr-4 py-2.5 text-[14px] rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] focus:outline-none focus:ring-2 focus:ring-[#8C57FF] text-[#2E263D] dark:text-[#EAEAFF]">
                    </div>

                    {{-- Role Filter --}}
                    <select name="role" class="px-4 py-2.5 text-[14px] rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] focus:outline-none focus:ring-2 focus:ring-[#8C57FF] text-[#2E263D] dark:text-[#EAEAFF]">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                    </select>

                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-black/5 dark:bg-white/10 hover:bg-[#8C57FF] hover:text-white text-[14px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] transition">
                        Filter
                    </button>
                    @if(request('search') || request('role'))
                        <a href="{{ route('admin.users.index') }}" class="p-2.5 rounded-xl text-[14px] text-rose-500 hover:bg-rose-500/10" title="Reset Filter">
                            <i class="ri-refresh-line text-lg"></i>
                        </a>
                    @endif
                </form>

                <a href="{{ route('admin.users.create') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#8C57FF] to-[#9E77FF] text-white text-[14px] font-semibold shadow-md shadow-[#8C57FF]/30 hover:opacity-95 transition">
                    <i class="ri-user-add-line text-lg"></i> Tambah User
                </a>
            </div>
        </div>
    </div>

    {{-- Users Data Table Card --}}
    <div class="materio-card overflow-hidden">
        @include('partials.admin-bulk-delete', ['bulkDeleteId' => 'bulk-delete-users', 'bulkDeleteAction' => route('admin.users.bulk-destroy'), 'bulkDeleteInputName' => 'user_ids[]', 'bulkDeleteItemClass' => 'user-selection', 'bulkDeleteSelectAllId' => 'select-all-users', 'bulkDeleteCountId' => 'selected-users-count', 'bulkDeleteConfirmation' => 'Hapus semua pengguna yang dipilih?'])
        <div class="overflow-x-auto">
            <table class="w-full text-[14px]">
                <thead>
                    <tr class="text-left text-[12px] font-bold uppercase tracking-wider text-stone-400 bg-black/[0.02] dark:bg-white/[0.02] border-b border-black/5 dark:border-white/5">
                        <th class="py-4 pl-6 pr-2 w-12"><input type="checkbox" id="select-all-users" form="bulk-delete-users" class="w-4 h-4 rounded border-stone-300 text-[#8C57FF] focus:ring-[#8C57FF]" aria-label="Pilih semua pengguna"></th>
                        <th class="py-4 px-6">Pengguna</th>
                        <th class="py-4 px-4">Role</th>
                        <th class="py-4 px-4">Kontak HP</th>
                        <th class="py-4 px-4 text-center">Total Pesanan</th>
                        <th class="py-4 px-4">Status</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5 dark:divide-white/5">
                    @forelse ($users as $user)
                        <tr class="hover:bg-[#8C57FF]/[0.03] transition">
                            <td class="py-4 pl-6 pr-2"><input type="checkbox" name="user_ids[]" value="{{ $user->id }}" form="bulk-delete-users" class="user-selection w-4 h-4 rounded border-stone-300 text-[#8C57FF] focus:ring-[#8C57FF]" aria-label="Pilih {{ $user->name }}"></td>
                            {{-- User Avatar + Name + Email --}}
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-10 h-10 rounded-full {{ $user->role === 'admin' ? 'bg-[#8C57FF]/15 text-[#8C57FF]' : 'bg-emerald-500/15 text-emerald-600' }} font-bold text-[14px] flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <a href="{{ route('admin.users.show', $user) }}" class="font-bold text-[15px] text-[#2E263D] dark:text-[#EAEAFF] hover:text-[#8C57FF] transition block truncate max-w-xs">
                                            {{ $user->name }}
                                        </a>
                                        <span class="text-[12px] text-stone-400 block truncate max-w-xs">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>

                            {{-- Role Badge --}}
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[12px] font-bold {{ $user->role === 'admin' ? 'bg-[#8C57FF]/10 text-[#8C57FF]' : 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' }}">
                                    <i class="{{ $user->role === 'admin' ? 'ri-shield-star-line' : 'ri-user-line' }} text-[13px]"></i>
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>

                            {{-- Phone --}}
                            <td class="py-4 px-4 font-mono text-[13px] text-stone-500">
                                {{ $user->phone ?? '—' }}
                            </td>

                            {{-- Orders Count --}}
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center justify-center min-w-[28px] px-2.5 py-1 rounded-full text-[13px] font-bold bg-black/[0.04] dark:bg-white/[0.05] text-[#2E263D] dark:text-[#EAEAFF]">
                                    {{ $user->orders_count ?? $user->orders()->count() }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[12px] font-semibold {{ $user->is_active ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'bg-stone-500/10 text-stone-500' }}">
                                    <span class="w-2 h-2 rounded-full {{ $user->is_active ? 'bg-emerald-500' : 'bg-stone-400' }}"></span>
                                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.users.show', $user) }}"
                                       class="w-9 h-9 rounded-xl flex items-center justify-center text-stone-500 hover:text-[#8C57FF] hover:bg-[#8C57FF]/10 transition"
                                       title="Lihat Detail Profil">
                                        <i class="ri-eye-line text-lg"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                       class="w-9 h-9 rounded-xl flex items-center justify-center text-[#8C57FF] hover:bg-[#8C57FF]/10 transition"
                                       title="Edit User">
                                        <i class="ri-edit-box-line text-lg"></i>
                                    </a>
                                    @if(auth()->id() !== $user->id)
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus pengguna {{ addslashes($user->name) }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="w-9 h-9 rounded-xl flex items-center justify-center text-rose-500 hover:bg-rose-500/10 transition"
                                                    title="Hapus User">
                                                <i class="ri-delete-bin-line text-lg"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center text-stone-400 text-[14px]">
                                <i class="ri-user-unfollow-line text-5xl block mb-2 text-stone-300"></i>
                                Tidak ada data pengguna yang cocok.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-black/5 dark:border-white/5">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
