@extends('layouts.admin')

@section('title', 'Pengaturan Pengaduan Nasabah')

@section('content')
<x-admin.page-header title="Pengaturan Pengaduan Nasabah" subtitle="Konfigurasi sistem laporan pengaduan nasabah"/>

<div class="max-w-4xl">
    <form action="{{ route('admin.settings.complaint.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-6">

            {{-- Notifikasi Email --}}
            <x-admin.card title="Notifikasi Email">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">
                                Email Penerima Notifikasi
                            </label>
                            <input type="email" name="admin_email"
                                value="{{ old('admin_email', $settings->admin_email) }}"
                                placeholder="admin@example.com"
                                class="w-full rounded-xl border border-zinc-300 dark:border-zinc-600 px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('admin_email') border-red-500 @enderror">
                            @error('admin_email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Email yang menerima notifikasi pengaduan baru</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">
                                CC Email
                            </label>
                            <input type="text" name="cc_emails"
                                value="{{ old('cc_emails', $settings->cc_emails) }}"
                                placeholder="cc1@example.com, cc2@example.com"
                                class="w-full rounded-xl border border-zinc-300 dark:border-zinc-600 px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('cc_emails') border-red-500 @enderror">
                            @error('cc_emails')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Pisahkan beberapa email dengan koma</p>
                        </div>
                    </div>

                    <div class="space-y-3 pt-2">
                        <div x-data="{ on: {{ old('notify_on_new', $settings->notify_on_new) ? 'true' : 'false' }} }"
                             class="flex items-center justify-between p-3.5 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <div>
                                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Notifikasi Pengaduan Baru</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">Kirim email ke admin saat ada pengaduan baru masuk</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" @click="on = !on"
                                    :class="on ? 'bg-emerald-500' : 'bg-zinc-200 dark:bg-zinc-700'"
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none">
                                    <span :class="on ? 'translate-x-6' : 'translate-x-1'"
                                        class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform"></span>
                                </button>
                                <input type="hidden" name="notify_on_new" :value="on ? '1' : '0'">
                            </div>
                        </div>

                        <div x-data="{ on: {{ old('notify_on_status_change', $settings->notify_on_status_change) ? 'true' : 'false' }} }"
                             class="flex items-center justify-between p-3.5 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <div>
                                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Notifikasi Perubahan Status</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">Kirim email ke admin saat status pengaduan berubah</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" @click="on = !on"
                                    :class="on ? 'bg-emerald-500' : 'bg-zinc-200 dark:bg-zinc-700'"
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none">
                                    <span :class="on ? 'translate-x-6' : 'translate-x-1'"
                                        class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform"></span>
                                </button>
                                <input type="hidden" name="notify_on_status_change" :value="on ? '1' : '0'">
                            </div>
                        </div>

                        <div x-data="{ on: {{ old('send_confirmation_to_customer', $settings->send_confirmation_to_customer) ? 'true' : 'false' }} }"
                             class="flex items-center justify-between p-3.5 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <div>
                                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Konfirmasi ke Nasabah</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">Kirim email konfirmasi ke nasabah setelah pengaduan diterima</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" @click="on = !on"
                                    :class="on ? 'bg-emerald-500' : 'bg-zinc-200 dark:bg-zinc-700'"
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none">
                                    <span :class="on ? 'translate-x-6' : 'translate-x-1'"
                                        class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform"></span>
                                </button>
                                <input type="hidden" name="send_confirmation_to_customer" :value="on ? '1' : '0'">
                            </div>
                        </div>
                    </div>
                </div>
            </x-admin.card>

            {{-- SLA & Batas Waktu --}}
            <x-admin.card title="SLA & Batas Waktu Penanganan">
                <div class="space-y-4">
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Tentukan batas waktu penanganan (hari kerja) berdasarkan prioritas pengaduan.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">
                                Prioritas Rendah
                                <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-sky-100 text-sky-700">Rendah</span>
                            </label>
                            <div class="flex items-center gap-2">
                                <input type="number" name="sla_days_low" min="1" max="365"
                                    value="{{ old('sla_days_low', $settings->sla_days_low) }}"
                                    class="w-full rounded-xl border border-zinc-300 dark:border-zinc-600 px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('sla_days_low') border-red-500 @enderror">
                                <span class="text-xs text-zinc-500 dark:text-zinc-400">hari</span>
                            </div>
                            @error('sla_days_low')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">
                                Prioritas Sedang
                                <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-700">Sedang</span>
                            </label>
                            <div class="flex items-center gap-2">
                                <input type="number" name="sla_days_medium" min="1" max="365"
                                    value="{{ old('sla_days_medium', $settings->sla_days_medium) }}"
                                    class="w-full rounded-xl border border-zinc-300 dark:border-zinc-600 px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('sla_days_medium') border-red-500 @enderror">
                                <span class="text-xs text-zinc-500 dark:text-zinc-400">hari</span>
                            </div>
                            @error('sla_days_medium')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">
                                Prioritas Tinggi
                                <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-600">Tinggi</span>
                            </label>
                            <div class="flex items-center gap-2">
                                <input type="number" name="sla_days_high" min="1" max="365"
                                    value="{{ old('sla_days_high', $settings->sla_days_high) }}"
                                    class="w-full rounded-xl border border-zinc-300 dark:border-zinc-600 px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('sla_days_high') border-red-500 @enderror">
                                <span class="text-xs text-zinc-500 dark:text-zinc-400">hari</span>
                            </div>
                            @error('sla_days_high')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </x-admin.card>

            {{-- Pengaturan Form --}}
            <x-admin.card title="Pengaturan Form Pengaduan">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">Prefix Nomor Tiket</label>
                            <input type="text" name="ticket_prefix" maxlength="10"
                                value="{{ old('ticket_prefix', $settings->ticket_prefix) }}"
                                placeholder="ADU"
                                class="w-full rounded-xl border border-zinc-300 dark:border-zinc-600 px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('ticket_prefix') border-red-500 @enderror">
                            @error('ticket_prefix')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Contoh: ADU → ADU-20260418-XXXXXX</p>
                        </div>
                    </div>

                    <div class="space-y-3 pt-1">
                        <div x-data="{ on: {{ old('require_account_number', $settings->require_account_number) ? 'true' : 'false' }} }"
                             class="flex items-center justify-between p-3.5 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <div>
                                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Wajibkan Nomor Rekening</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">Nasabah harus mengisi nomor rekening saat mengadu</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" @click="on = !on"
                                    :class="on ? 'bg-emerald-500' : 'bg-zinc-200 dark:bg-zinc-700'"
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none">
                                    <span :class="on ? 'translate-x-6' : 'translate-x-1'"
                                        class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform"></span>
                                </button>
                                <input type="hidden" name="require_account_number" :value="on ? '1' : '0'">
                            </div>
                        </div>

                        <div x-data="{ on: {{ old('require_phone', $settings->require_phone) ? 'true' : 'false' }} }"
                             class="flex items-center justify-between p-3.5 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <div>
                                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Wajibkan Nomor Telepon</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">Nasabah harus mengisi nomor telepon</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" @click="on = !on"
                                    :class="on ? 'bg-emerald-500' : 'bg-zinc-200 dark:bg-zinc-700'"
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none">
                                    <span :class="on ? 'translate-x-6' : 'translate-x-1'"
                                        class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform"></span>
                                </button>
                                <input type="hidden" name="require_phone" :value="on ? '1' : '0'">
                            </div>
                        </div>

                        <div x-data="{ on: {{ old('allow_attachments', $settings->allow_attachments) ? 'true' : 'false' }} }"
                             x-effect="document.getElementById('attachment_settings').style.opacity = on ? '1' : '0.4'; document.getElementById('attachment_settings').querySelectorAll('input').forEach(el => el.disabled = !on)"
                             class="flex items-center justify-between p-3.5 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <div>
                                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Izinkan Lampiran File</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">Nasabah dapat melampirkan dokumen pendukung</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" @click="on = !on"
                                    :class="on ? 'bg-emerald-500' : 'bg-zinc-200 dark:bg-zinc-700'"
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none">
                                    <span :class="on ? 'translate-x-6' : 'translate-x-1'"
                                        class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform"></span>
                                </button>
                                <input type="hidden" name="allow_attachments" :value="on ? '1' : '0'">
                            </div>
                        </div>

                        <div x-data="{ on: {{ old('auto_assign_priority', $settings->auto_assign_priority) ? 'true' : 'false' }} }"
                             class="flex items-center justify-between p-3.5 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <div>
                                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Prioritas Otomatis</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">Sistem otomatis menentukan prioritas berdasarkan kategori</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" @click="on = !on"
                                    :class="on ? 'bg-emerald-500' : 'bg-zinc-200 dark:bg-zinc-700'"
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none">
                                    <span :class="on ? 'translate-x-6' : 'translate-x-1'"
                                        class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform"></span>
                                </button>
                                <input type="hidden" name="auto_assign_priority" :value="on ? '1' : '0'">
                            </div>
                        </div>
                    </div>

                    {{-- Pengaturan Lampiran --}}
                    <div id="attachment_settings" class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2 border-t border-zinc-200 dark:border-zinc-700">
                        <div>
                            <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">Maks. Jumlah Lampiran</label>
                            <input type="number" name="max_attachments" min="1" max="20"
                                value="{{ old('max_attachments', $settings->max_attachments) }}"
                                class="w-full rounded-xl border border-zinc-300 dark:border-zinc-600 px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('max_attachments') border-red-500 @enderror">
                            @error('max_attachments')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">Ukuran Maks. per File (MB)</label>
                            <input type="number" name="max_file_size_mb" min="1" max="50"
                                value="{{ old('max_file_size_mb', $settings->max_file_size_mb) }}"
                                class="w-full rounded-xl border border-zinc-300 dark:border-zinc-600 px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('max_file_size_mb') border-red-500 @enderror">
                            @error('max_file_size_mb')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">Tipe File Diizinkan</label>
                            <input type="text" name="allowed_file_types"
                                value="{{ old('allowed_file_types', $settings->allowed_file_types) }}"
                                placeholder="pdf,doc,docx,jpg,jpeg,png"
                                class="w-full rounded-xl border border-zinc-300 dark:border-zinc-600 px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('allowed_file_types') border-red-500 @enderror">
                            @error('allowed_file_types')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Pisahkan dengan koma, tanpa titik</p>
                        </div>
                    </div>
                </div>
            </x-admin.card>

            {{-- Kategori Aktif --}}
            <x-admin.card title="Kategori Pengaduan Aktif">
                <div class="space-y-3">
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Pilih kategori yang tersedia untuk nasabah saat mengajukan pengaduan.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($categories as $key => $label)
                        <label class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl border border-zinc-200 dark:border-zinc-700 cursor-pointer">
                            <input type="checkbox" name="active_categories[]" value="{{ $key }}"
                                {{ in_array($key, old('active_categories', $settings->active_categories ?? array_keys($categories))) ? 'checked' : '' }}
                                class="rounded border-zinc-300 text-sky-600">
                            <span class="text-xs text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </x-admin.card>

            {{-- Teks & Konten --}}
            <x-admin.card title="Teks & Konten Form">
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">Teks Pengantar Form</label>
                        <textarea name="form_intro_text" rows="3"
                            placeholder="Tuliskan pengantar atau instruksi untuk nasabah sebelum mengisi form..."
                            class="w-full rounded-xl border border-zinc-300 dark:border-zinc-600 px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('form_intro_text') border-red-500 @enderror">{{ old('form_intro_text', $settings->form_intro_text) }}</textarea>
                        @error('form_intro_text')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Ditampilkan di bagian atas form pengaduan nasabah</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">Pesan Sukses</label>
                        <textarea name="success_message" rows="3"
                            placeholder="Pesan yang ditampilkan setelah nasabah berhasil mengirim pengaduan..."
                            class="w-full rounded-xl border border-zinc-300 dark:border-zinc-600 px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('success_message') border-red-500 @enderror">{{ old('success_message', $settings->success_message) }}</textarea>
                        @error('success_message')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">Syarat & Ketentuan</label>
                        <textarea name="terms_text" rows="5"
                            placeholder="Tuliskan syarat dan ketentuan pengajuan pengaduan..."
                            class="w-full rounded-xl border border-zinc-300 dark:border-zinc-600 px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('terms_text') border-red-500 @enderror">{{ old('terms_text', $settings->terms_text) }}</textarea>
                        @error('terms_text')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Ditampilkan sebagai checkbox persetujuan di form pengaduan</p>
                    </div>
                </div>
            </x-admin.card>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.customer-complaints.index') }}"
                    class="inline-flex items-center px-4 py-2 text-xs font-medium text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 rounded-xl hover:bg-zinc-50">
                    Lihat Pengaduan
                </a>
                <x-admin.button type="submit">Simpan Pengaturan</x-admin.button>
            </div>

        </div>
    </form>
</div>

@push('scripts')
<script nonce="{{ $nonce }}">
    // Auto uppercase ticket prefix
    document.querySelector('[name="ticket_prefix"]').addEventListener('input', function () {
        this.value = this.value.toUpperCase();
    });
</script>
@endpush
@endsection
