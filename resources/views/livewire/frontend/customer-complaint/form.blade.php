<div>
    {{-- ═══ SUCCESS STATE ═══ --}}
    @if($submitted)
    <div class="text-center py-10 px-4" x-data x-init="$el.classList.add('animate-scale-in')">
        <div class="w-20 h-20 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-full flex items-center justify-center mx-auto mb-5 shadow-xl shadow-emerald-500/30">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
        </div>
        <h3 class="text-2xl font-bold text-foreground dark:text-white mb-2">Laporan Berhasil Dikirim!</h3>
        <p class="text-secondary text-sm mb-8 w-full">Terima kasih. Tim kami akan menindaklanjuti laporan Anda sesuai prosedur yang berlaku.</p>

        <div class="bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-700/50 rounded-2xl p-6 max-w-xs mx-auto mb-8">
            <p class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold uppercase tracking-wider mb-2">Nomor Tiket Anda</p>
            <p class="text-2xl font-black text-emerald-700 dark:text-emerald-300 font-mono tracking-wider">{{ $ticketNumber }}</p>
            <p class="text-xs text-emerald-600 dark:text-emerald-500 mt-2">Simpan nomor ini untuk memantau status laporan</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <button wire:click="$set('submitted', false)"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold bg-slate-100 dark:bg-slate-800 text-foreground dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors border-0 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Buat Laporan Baru
            </button>
        </div>
    </div>

    @else
    {{-- ═══ FORM ═══ --}}
    <form wire:submit="submit" class="space-y-6">

        {{-- ─── Anonymous Toggle ─── --}}
        <div class="relative overflow-hidden rounded-2xl border border-amber-200 dark:border-amber-700/50 bg-amber-50 dark:bg-amber-900/20 p-5">
            <div class="absolute top-0 right-0 w-24 h-24 bg-amber-200/30 dark:bg-amber-700/20 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <label class="flex items-start gap-4 cursor-pointer relative">
                <div class="relative mt-0.5">
                    <input type="checkbox" wire:model.live="is_anonymous"
                           class="w-5 h-5 rounded border-amber-300 text-amber-600 focus:ring-amber-500 cursor-pointer">
                </div>
                <div>
                    <span class="font-bold text-sm text-amber-800 dark:text-amber-400 block">Laporkan Secara Anonim</span>
                    <p class="text-xs text-amber-700 dark:text-amber-500 mt-0.5 leading-relaxed">Identitas Anda akan dirahasiakan. Namun kami tidak dapat menghubungi Anda untuk klarifikasi lebih lanjut.</p>
                </div>
            </label>
        </div>

        {{-- ─── Informasi Pelapor ─── --}}
        @if(!$is_anonymous)
        <div class="space-y-4">
            {{-- Section header --}}
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-foreground dark:text-white uppercase tracking-wide">Informasi Pelapor</h3>
                <div class="flex-1 h-px bg-border dark:bg-slate-700"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Nama Lengkap --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-foreground dark:text-slate-300 uppercase tracking-wide">
                        Nama Lengkap <span class="text-red-500 normal-case">*</span>
                    </label>
                    <input type="text" wire:model.live="name" placeholder="Nama sesuai KTP"
                           class="w-full rounded-xl border px-4 py-2.5 text-sm bg-white dark:bg-slate-800 text-foreground dark:text-white placeholder:text-slate-400 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500
                                  {{ $errors->has('name') ? 'border-red-400 dark:border-red-500 focus:ring-red-400' : 'border-border dark:border-slate-600' }}">
                    @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Email --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-foreground dark:text-slate-300 uppercase tracking-wide">
                        Email <span class="text-red-500 normal-case">*</span>
                    </label>
                    <input type="email" wire:model.live="email" placeholder="email@contoh.com"
                           class="w-full rounded-xl border px-4 py-2.5 text-sm bg-white dark:bg-slate-800 text-foreground dark:text-white placeholder:text-slate-400 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500
                                  {{ $errors->has('email') ? 'border-red-400 dark:border-red-500 focus:ring-red-400' : 'border-border dark:border-slate-600' }}">
                    @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Nomor Telepon --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-foreground dark:text-slate-300 uppercase tracking-wide">
                        Nomor Telepon <span class="text-red-500 normal-case">*</span>
                    </label>
                    <input type="text" wire:model.live="phone" placeholder="08xxxxxxxxxx"
                           class="w-full rounded-xl border px-4 py-2.5 text-sm bg-white dark:bg-slate-800 text-foreground dark:text-white placeholder:text-slate-400 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500
                                  {{ $errors->has('phone') ? 'border-red-400 dark:border-red-500 focus:ring-red-400' : 'border-border dark:border-slate-600' }}">
                    @error('phone')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- No Rekening --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-foreground dark:text-slate-300 uppercase tracking-wide">
                        No. Rekening / Nasabah
                        <span class="normal-case font-normal text-secondary ml-1">(Opsional)</span>
                    </label>
                    <input type="text" wire:model.live="account_number" placeholder="Nomor rekening Anda"
                           class="w-full rounded-xl border border-border dark:border-slate-600 px-4 py-2.5 text-sm bg-white dark:bg-slate-800 text-foreground dark:text-white placeholder:text-slate-400 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                {{-- No Identitas --}}
                <div class="space-y-1.5 sm:col-span-2">
                    <label class="block text-xs font-semibold text-foreground dark:text-slate-300 uppercase tracking-wide">
                        Nomor Identitas (KTP/SIM)
                        <span class="normal-case font-normal text-secondary ml-1">(Opsional)</span>
                    </label>
                    <input type="text" wire:model.live="identity_number" placeholder="16 digit nomor KTP/SIM"
                           class="w-full rounded-xl border border-border dark:border-slate-600 px-4 py-2.5 text-sm bg-white dark:bg-slate-800 text-foreground dark:text-white placeholder:text-slate-400 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
            </div>
        </div>
        @endif

        {{-- ─── Detail Laporan ─── --}}
        <div class="space-y-4">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-foreground dark:text-white uppercase tracking-wide">Detail Laporan</h3>
                <div class="flex-1 h-px bg-border dark:bg-slate-700"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Kategori --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-foreground dark:text-slate-300 uppercase tracking-wide">
                        Kategori <span class="text-red-500 normal-case">*</span>
                    </label>
                    <select wire:model.live="type"
                            class="w-full rounded-xl border px-4 py-2.5 text-sm bg-white dark:bg-slate-800 text-foreground dark:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500
                                   {{ $errors->has('type') ? 'border-red-400 dark:border-red-500' : 'border-border dark:border-slate-600' }}">
                        <option value="">Pilih Kategori</option>
                        <option value="product">Produk & Layanan</option>
                        <option value="service">Kualitas Pelayanan</option>
                        <option value="billing">Tagihan & Pembayaran</option>
                        <option value="technical">Kendala Teknis</option>
                        <option value="suggestion">Saran & Masukan</option>
                        <option value="other">Lainnya</option>
                    </select>
                    @error('type')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Subjek --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-foreground dark:text-slate-300 uppercase tracking-wide">
                        Subjek <span class="text-red-500 normal-case">*</span>
                    </label>
                    <input type="text" wire:model.live="subject" placeholder="Ringkasan singkat pengaduan"
                           class="w-full rounded-xl border px-4 py-2.5 text-sm bg-white dark:bg-slate-800 text-foreground dark:text-white placeholder:text-slate-400 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500
                                  {{ $errors->has('subject') ? 'border-red-400 dark:border-red-500' : 'border-border dark:border-slate-600' }}">
                    @error('subject')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-foreground dark:text-slate-300 uppercase tracking-wide">
                    Deskripsi Lengkap <span class="text-red-500 normal-case">*</span>
                </label>
                <textarea wire:model.live="description" rows="5" maxlength="3000"
                          placeholder="Jelaskan kronologi dan detail pengaduan Anda secara lengkap..."
                          class="w-full rounded-xl border px-4 py-3 text-sm bg-white dark:bg-slate-800 text-foreground dark:text-white placeholder:text-slate-400 transition-colors resize-none focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500
                                 {{ $errors->has('description') ? 'border-red-400 dark:border-red-500' : 'border-border dark:border-slate-600' }}"></textarea>
                <div class="flex justify-between items-center">
                    @error('description')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @else
                        <p class="text-xs text-secondary">Minimal 20 karakter</p>
                    @enderror
                    <p class="text-xs {{ strlen($description) > 2800 ? 'text-amber-500' : 'text-secondary' }}">{{ strlen($description) }}/3000</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Kantor Cabang --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-foreground dark:text-slate-300 uppercase tracking-wide">
                        Kantor Cabang <span class="text-red-500 normal-case">*</span>
                    </label>
                    <select wire:model.live="branch_office"
                            class="w-full rounded-xl border border-border dark:border-slate-600 px-4 py-2.5 text-sm bg-white dark:bg-slate-800 text-foreground dark:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Pilih Cabang</option>
                        @foreach($branchOffices as $office)
                            <option value="{{ $office }}">{{ $office }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tanggal Kejadian --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-foreground dark:text-slate-300 uppercase tracking-wide">
                        Tanggal Kejadian
                        <span class="normal-case font-normal text-secondary ml-1">(Opsional)</span>
                    </label>
                    <input type="date" wire:model.live="incident_date"
                           class="w-full rounded-xl border border-border dark:border-slate-600 px-4 py-2.5 text-sm bg-white dark:bg-slate-800 text-foreground dark:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
            </div>
        </div>

        {{-- ─── Lampiran ─── --}}
        <div class="space-y-4">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-violet-100 dark:bg-violet-900/50 flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                </div>
                <h3 class="text-sm font-bold text-foreground dark:text-white uppercase tracking-wide">Lampiran</h3>
                <span class="text-xs text-secondary font-normal">(Opsional)</span>
                <div class="flex-1 h-px bg-border dark:bg-slate-700"></div>
            </div>

            <label for="attachments"
                   class="flex flex-col items-center justify-center gap-3 p-8 border-2 border-dashed rounded-2xl cursor-pointer transition-all duration-200
                          border-border dark:border-slate-600 bg-slate-50/50 dark:bg-slate-800/50
                          hover:border-emerald-400 dark:hover:border-emerald-600 hover:bg-emerald-50/30 dark:hover:bg-emerald-900/10">
                <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center">
                    <svg class="w-6 h-6 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                </div>
                <div class="text-center">
                    <p class="text-sm font-medium text-foreground dark:text-slate-200">Klik untuk upload</p>
                    <p class="text-xs text-secondary mt-0.5">PDF, DOC, JPG, PNG — Maks. 5MB per file</p>
                </div>
                <input type="file" wire:model.live="attachments" multiple class="hidden" id="attachments">
            </label>

            @if($attachments)
            <div class="space-y-2">
                @foreach($attachments as $index => $file)
                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-border dark:border-slate-700">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <span class="text-xs text-foreground dark:text-slate-300 font-medium truncate">{{ $file->getClientOriginalName() }}</span>
                    </div>
                    <button type="button" wire:click="$set('attachments.{{ $index }}', null)"
                            class="ml-2 p-1.5 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors bg-transparent border-0 cursor-pointer shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                @endforeach
            </div>
            @endif
            @error('attachments.*')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- ─── Persetujuan ─── --}}
        <div class="rounded-2xl border p-5 {{ $errors->has('agree_terms') ? 'border-red-300 dark:border-red-700 bg-red-50 dark:bg-red-900/20' : 'border-border dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50' }}">
            <label class="flex items-start gap-3.5 cursor-pointer">
                <input type="checkbox" wire:model.live="agree_terms"
                       class="mt-0.5 w-5 h-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer shrink-0">
                <p class="text-sm text-foreground dark:text-slate-300 leading-relaxed">
                    Saya menyatakan bahwa laporan ini dibuat dengan <strong class="font-semibold">itikad baik</strong> dan informasi yang saya berikan adalah <strong class="font-semibold">benar</strong>. Saya memahami bahwa laporan palsu dapat dikenakan sanksi hukum.
                </p>
            </label>
            @error('agree_terms')<p class="text-xs text-red-500 mt-2 ml-8">{{ $message }}</p>@enderror
        </div>

        {{-- ─── Submit ─── --}}
        <button type="submit"
                wire:loading.attr="disabled"
                class="w-full flex items-center justify-center gap-2.5 py-4 px-6 rounded-2xl text-sm font-bold text-white
                       bg-gradient-to-r from-emerald-600 to-emerald-700
                       hover:from-emerald-500 hover:to-emerald-600
                       shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/35
                       transition-all duration-300 active:scale-[0.98]
                       disabled:opacity-60 disabled:cursor-not-allowed border-0 cursor-pointer">
            <span wire:loading.remove class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                Kirim Laporan
            </span>
            <span wire:loading class="flex items-center gap-2">
                <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Mengirim Laporan...
            </span>
        </button>

    </form>
    @endif
</div>
