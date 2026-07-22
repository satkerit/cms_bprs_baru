@props([
    'id' => 'deleteModal',
    'title' => 'Konfirmasi Hapus',
    'message' => 'Apakah Anda yakin ingin menghapus item ini? Tindakan ini tidak dapat dibatalkan.',
    'confirmText' => 'Hapus',
    'cancelText' => 'Batal',
    'action' => null,
])

{{--
    DELETE MODAL — Menggunakan SweetAlert2 (bukan Alpine modal)
    =============================================================
    Cara pakai:
    <x-admin.delete-modal id="deleteX" title="Hapus Data" :message="'...' . json_encode($item->name) . '...'" />

    <button type="button"
        data-open-modal="deleteX"
        data-title="Hapus {{ $item->name }}"
        data-text="Apakah Anda yakin ingin menghapus {{ $item->name }}?"
        data-action="{{ route('admin.items.destroy', $item) }}"
        data-confirm="Ya, hapus!">
        Hapus
    </button>
--}}

{{-- Hidden form — disubmit setelah SweetAlert2 dikonfirmasi --}}
@if($action)
    <form method="POST" action="{{ $action }}" id="{{ $id }}-form" style="display:none">
        @csrf
        @method('DELETE')
    </form>
@else
    <form method="POST" id="{{ $id }}-form" style="display:none">
        @csrf
        @method('DELETE')
    </form>
@endif

@once
@push('scripts')
<script nonce="{{ $nonce }}">
    document.addEventListener('click', async function(e) {
        var btn = e.target.closest('[data-open-modal]');
        if (!btn) return;

        e.preventDefault();

        var id = btn.getAttribute('data-open-modal');
        var form = document.getElementById(id + '-form');
        if (!form) return;

        // Set action from button data attribute
        var action = btn.getAttribute('data-action');
        if (action) form.action = action;

        // Load SweetAlert2
        var Swal = window.Swal;
        if (!Swal || !Swal.fire) {
            var module = await import('sweetalert2');
            Swal = module.default;
        }

        var result = await Swal.fire({
            title: btn.getAttribute('data-title') || '{{ $title }}',
            text: btn.getAttribute('data-text') || '{{ $message }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: btn.getAttribute('data-confirm') || '{{ $confirmText }}',
            cancelButtonText: '{{ $cancelText }}',
            reverseButtons: true,
            showCloseButton: true,
            customClass: {
                confirmButton: 'swal-delete-btn',
            },
        });

        if (result.isConfirmed) {
            form.submit();
        }
    });
</script>
@endpush
@endonce
