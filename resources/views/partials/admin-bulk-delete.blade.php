@php
    $bulkDeleteId = $bulkDeleteId ?? 'bulk-delete-items';
    $bulkDeleteInputName = $bulkDeleteInputName ?? 'ids[]';
    $bulkDeleteItemClass = $bulkDeleteItemClass ?? 'bulk-selection';
    $bulkDeleteSelectAllId = $bulkDeleteSelectAllId ?? $bulkDeleteId.'-select-all';
    $bulkDeleteCountId = $bulkDeleteCountId ?? $bulkDeleteId.'-count';
@endphp

<div class="flex items-center justify-between gap-4 px-6 py-4 border-b border-black/5 dark:border-white/5">
    <form id="{{ $bulkDeleteId }}" method="POST" action="{{ $bulkDeleteAction }}" onsubmit="return confirm('{{ $bulkDeleteConfirmation ?? 'Hapus semua item yang dipilih?' }}')">
        @csrf
        @method('DELETE')
        <button type="submit" disabled
                class="bulk-delete-button inline-flex items-center gap-2 px-4 py-2 rounded-xl text-[13px] font-semibold text-rose-500 bg-rose-500/10 hover:bg-rose-500/20 disabled:cursor-not-allowed disabled:opacity-40 transition">
            <i class="ri-delete-bin-line text-lg"></i>
            Hapus Terpilih (<span id="{{ $bulkDeleteCountId }}">0</span>)
        </button>
    </form>
    <span class="text-[12px] text-stone-400">Pilih item untuk menghapus beberapa sekaligus</span>
</div>

<script>
    (() => {
        const bulkForm = document.getElementById('{{ $bulkDeleteId }}');
        const selectAll = document.getElementById('{{ $bulkDeleteSelectAllId }}');
        const selections = [...document.querySelectorAll('.{{ $bulkDeleteItemClass }}')];
        const deleteButton = bulkForm.querySelector('.bulk-delete-button');
        const count = document.getElementById('{{ $bulkDeleteCountId }}');

        const updateState = () => {
            const selectedCount = selections.filter((checkbox) => checkbox.checked).length;
            count.textContent = selectedCount;
            deleteButton.disabled = selectedCount === 0;
            selectAll.checked = selections.length > 0 && selectedCount === selections.length;
            selectAll.indeterminate = selectedCount > 0 && selectedCount < selections.length;
        };

        selectAll.addEventListener('change', () => {
            selections.forEach((checkbox) => {
                checkbox.checked = selectAll.checked;
            });
            updateState();
        });

        selections.forEach((checkbox) => checkbox.addEventListener('change', updateState));
    })();
</script>
