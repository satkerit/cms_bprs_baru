<div>
    {{-- ═══ SUCCESS ═══ --}}
    @if($submitted)
    <div class="text-center py-8" x-data x-init="$el.classList.add('animate-scale-in')">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl border-2 border-emerald-500/40 bg-emerald-50 dark:bg-emerald-900/30 mb-5">
            <svg class="w-10 h-10 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
        </div>
        <h3 class="text-2xl font-bold text-foreground dark:text-white mb-2">Laporan Berhasil Dikirim</h3>
        <p class="text-sm text-secondary mb-8 max-w-md mx-auto">Terima kasih atas laporan Anda. Tim kami akan segera menindaklanjuti sesuai prosedur.</p>

        <div class="inline-block border border-emerald-200 dark:border-emerald-700/50 bg-emerald-50/60 dark:bg-emerald-900/20 px-8 py-6 mb-8">
            <p class="font-mono text-[10px] uppercase tracking-[0.25em] text-emerald-700 dark:text-emerald-400 mb-2">Nomor Tiket</p>
            <p class="font-mono text-2xl sm:text-3xl font-bold text-emerald-800 dark:text-emerald-300 tracking-wider">{{ $ticketNumber }}</p>
            <p class="mt-2 text-xs text-emerald-700/80 dark:text-emerald-500">Simpan nomor ini untuk melacak status laporan Anda.</p>
        </div>

        <button wire:click="$set('submitted', false)"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold border border-border dark:border-slate-600 bg-white dark:bg-slate-800 text-foreground dark:text-slate-200 hover:border-emerald-500 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Buat Laporan Baru
        </button>
    </div>

    @else
    @php
        $inputBase = 'w-full rounded-lg border px-3.5 py-2.5 text-sm bg-white text-foreground dark:bg-slate-900 dark:text-white placeholder:text-slate-400 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500/25 focus:border-emerald-600';
        $inputOk   = 'border-slate-300 dark:border-slate-600';
        $inputErr  = 'border-red-400 dark:border-red-500 focus:ring-red-500/25 focus:border-red-500';
    @endphp
    <form wire:submit="submit" class="space-y-8" novalidate>

        {{-- ─── Opsi Anonim ─── --}}
        <div class="flex items-start gap-4 p-4 sm:p-5 border {{ $errors->has('is_anonymous') ? 'border-red-300 dark:border-red-700' : 'border-amber-200 dark:border-amber-700/40' }} bg-amber-50/70 dark:bg-amber-900/10">
            <input type="checkbox" wire:model.live="is_anonymous" id="is_anonymous"
                   class="mt-1 w-5 h-5 rounded border-amber-300 text-amber-600 focus:ring-amber-500 cursor-pointer shrink-0">
            <label for="is_anonymous" class="cursor-pointer">
                <span class="block text-sm font-bold text-amber-900 dark:text-amber-300">Laporkan Secara Anonim</span>
                <span class="block text-xs text-amber-800/80 dark:text-amber-500 mt-1 leading-relaxed">Identitas Anda dirahasiakan sepenuhnya dan tidak akan diungkapkan tanpa persetujuan. Catatan: kami tidak dapat menghubungi Anda untuk klarifikasi lanjutan.</span>
            </label>
        </div>

        {{-- ─── 1 · Identitas Pelapor ─── --}}
        @if(!$is_anonymous)
        <section class="space-y-5">
            <div class="flex items-center gap-3">
                <span class="font-mono text-emerald-700 dark:text-emerald-400 text-sm font-bold">1</span>
                <h3 class="text-sm font-bold text-foreground dark:text-white tracking-wide">Identitas Pelapor</h3>
                <span class="flex-1 h-px bg-border dark:bg-slate-700"></span>
                <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Diperlukan</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-foreground dark:text-slate-200 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" wire:model.live="name" placeholder="Nama sesuai KTP"
                           class="{{ $inputBase }} {{ $errors->has('name') ? $inputErr : $inputOk }}">
                    @error('name')<p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-foreground dark:text-slate-200 mb-1.5">Email <span class="text-red-500">*</span></label>
                    <input type="email" wire:model.live="email" placeholder="email@contoh.com"
                           class="{{ $inputBase }} {{ $errors->has('email') ? $inputErr : $inputOk }}">
                    @error('email')<p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-foreground dark:text-slate-200 mb-1.5">Nomor Telepon <span class="text-secondary font-normal text-xs">(opsional)</span></label>
                    <input type="text" wire:model.live="phone" placeholder="08xxxxxxxxxx"
                           class="{{ $inputBase }} {{ $inputOk }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-foreground dark:text-slate-200 mb-1.5">Nomor Identitas (KTP/SIM) <span class="text-secondary font-normal text-xs">(opsional)</span></label>
                    <input type="text" wire:model.live="identity_number" placeholder="16 digit nomor KTP/SIM"
                           class="{{ $inputBase }} {{ $inputOk }}">
                </div>
            </div>
        </section>
        @endif

        {{-- ─── 2 · Detail Pelanggaran ─── --}}
        <section class="space-y-5">
            <div class="flex items-center gap-3">
                <span class="font-mono text-emerald-700 dark:text-emerald-400 text-sm font-bold">{{ $is_anonymous ? '1' : '2' }}</span>
                <h3 class="text-sm font-bold text-foreground dark:text-white tracking-wide">Detail Pelanggaran</h3>
                <span class="flex-1 h-px bg-border dark:bg-slate-700"></span>
                <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Wajib</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-foreground dark:text-slate-200 mb-1.5">Jenis Pelanggaran <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select wire:model.live="type"
                                class="w-full appearance-none pr-10 {{ $inputBase }} {{ $errors->has('type') ? $inputErr : $inputOk }}">
                            <option value="">Pilih Jenis</option>
                            <option value="fraud">Kecurangan (Fraud)</option>
                            <option value="violation">Pelanggaran Peraturan</option>
                            <option value="ethics">Pelanggaran Kode Etik</option>
                            <option value="abuse">Penyalahgunaan Wewenang</option>
                            <option value="safety">Keselamatan Kerja</option>
                            <option value="other">Lainnya</option>
                        </select>
                        <svg class="w-4 h-4 text-slate-400 absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                    @error('type')<p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-foreground dark:text-slate-200 mb-1.5">Subjek Laporan <span class="text-red-500">*</span></label>
                    <input type="text" wire:model.live="subject" placeholder="Ringkasan singkat laporan"
                           class="{{ $inputBase }} {{ $errors->has('subject') ? $inputErr : $inputOk }}">
                    @error('subject')<p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-foreground dark:text-slate-200 mb-1.5">Deskripsi Lengkap <span class="text-red-500">*</span></label>
                <textarea wire:model.live="description" rows="6" maxlength="5000"
                          placeholder="Jelaskan kronologi kejadian secara detail — apa, kapan, di mana, dan siapa saja yang terlibat..."
                          class="w-full rounded-lg border px-3.5 py-3 text-sm bg-white text-foreground dark:bg-slate-900 dark:text-white placeholder:text-slate-400 transition-colors resize-none focus:outline-none focus:ring-2 focus:ring-emerald-500/25 focus:border-emerald-600 {{ $errors->has('description') ? $inputErr : $inputOk }}"></textarea>
                <div class="mt-2 flex items-center justify-between gap-4">
                    <div class="flex-1 h-1 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-300 {{ strlen($description) > 4700 ? 'bg-amber-500' : 'bg-emerald-500' }}"
                             style="width: {{ min(100, strlen($description) / 5000 * 100) }}%"></div>
                    </div>
                    @error('description')
                        <p class="text-xs text-red-600 dark:text-red-400 shrink-0">{{ $message }}</p>
                    @else
                        <p class="text-xs text-secondary shrink-0">Min. 50 karakter</p>
                    @enderror
                    <p class="font-mono text-xs {{ strlen($description) > 4700 ? 'text-amber-600 dark:text-amber-400' : 'text-secondary' }} shrink-0">{{ strlen($description) }}/5000</p>
                </div>
            </div>
        </section>

        {{-- ─── 3 · Pihak yang Dilaporkan ─── --}}
        <section class="space-y-5">
            <div class="flex items-center gap-3">
                <span class="font-mono text-emerald-700 dark:text-emerald-400 text-sm font-bold">{{ $is_anonymous ? '2' : '3' }}</span>
                <h3 class="text-sm font-bold text-foreground dark:text-white tracking-wide">Pihak yang Dilaporkan</h3>
                <span class="flex-1 h-px bg-border dark:bg-slate-700"></span>
                <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Opsional</span>
            </div>

            <div class="p-4 sm:p-5 border border-slate-200 dark:border-slate-700 bg-slate-50/60 dark:bg-slate-800/40 space-y-5">
                <p class="text-xs text-secondary leading-relaxed">Isi jika Anda mengetahui pihak yang terlibat. Kolom ini membantu mempercepat investigasi — <strong class="font-semibold text-foreground dark:text-slate-200">identitas pihak terlapor tidak memengaruhi kerahasiaan Anda.</strong></p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-foreground dark:text-slate-200 mb-1.5">Nama Pihak Terlapor</label>
                        <input type="text" wire:model.live="reported_person" placeholder="Nama yang dilaporkan"
                               class="{{ $inputBase }} {{ $inputOk }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-foreground dark:text-slate-200 mb-1.5">Departemen / Unit</label>
                        <input type="text" wire:model.live="reported_department" placeholder="Contoh: Divisi Operasional"
                               class="{{ $inputBase }} {{ $inputOk }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-foreground dark:text-slate-200 mb-1.5">Tanggal Kejadian</label>
                        <input type="date" wire:model.live="incident_date"
                               class="{{ $inputBase }} {{ $inputOk }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-foreground dark:text-slate-200 mb-1.5">Lokasi Kejadian</label>
                        <input type="text" wire:model.live="incident_location" placeholder="Lokasi, cabang, atau unit"
                               class="{{ $inputBase }} {{ $inputOk }}">
                    </div>
                </div>
            </div>
        </section>

        {{-- ─── 4 · Bukti Pendukung ─── --}}
        <section class="space-y-4">
            <div class="flex items-center gap-3">
                <span class="font-mono text-emerald-700 dark:text-emerald-400 text-sm font-bold">{{ $is_anonymous ? '3' : '4' }}</span>
                <h3 class="text-sm font-bold text-foreground dark:text-white tracking-wide">Bukti Pendukung</h3>
                <span class="flex-1 h-px bg-border dark:bg-slate-700"></span>
                <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Opsional</span>
            </div>

            <label for="attachments"
                   class="flex items-start gap-4 p-5 border border-dashed border-slate-300 dark:border-slate-600 rounded-lg cursor-pointer hover:border-emerald-500 hover:bg-emerald-50/40 dark:hover:bg-emerald-950/20 transition-colors">
                <span class="w-10 h-10 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                </span>
                <span class="min-w-0">
                    <span class="block text-sm font-medium text-foreground dark:text-slate-200">Unggah bukti (dokumen, tangkapan layar, rekaman)</span>
                    <span class="block text-xs text-secondary mt-1 leading-relaxed">PDF, DOC, JPG, PNG — maksimal 5MB per file. Beberapa file diperbolehkan sekaligus.</span>
                </span>
                <input type="file" wire:model.live="attachments" multiple class="hidden" id="attachments">
            </label>

            @if($attachments)
            <ul class="space-y-2">
                @foreach($attachments as $index => $file)
                <li class="flex items-center justify-between gap-3 px-4 py-3 rounded-lg border border-border dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span class="text-xs font-medium text-foreground dark:text-slate-300 truncate">{{ $file->getClientOriginalName() }}</span>
                    </div>
                    <button type="button" wire:click="$set('attachments.{{ $index }}', null)"
                            class="p-1.5 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors bg-transparent border-0 cursor-pointer shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </li>
                @endforeach
            </ul>
            @endif
            @error('attachments.*')<p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>@enderror
        </section>

        {{-- ─── 5 · Pernyataan ─── --}}
        <section class="space-y-5">
            <div class="flex items-center gap-3">
                <span class="font-mono text-emerald-700 dark:text-emerald-400 text-sm font-bold">{{ $is_anonymous ? '4' : '5' }}</span>
                <h3 class="text-sm font-bold text-foreground dark:text-white tracking-wide">Pernyataan</h3>
                <span class="flex-1 h-px bg-border dark:bg-slate-700"></span>
            </div>

            <div class="p-4 sm:p-5 border {{ $errors->has('agree_terms') ? 'border-red-300 dark:border-red-700 bg-red-50 dark:bg-red-900/20' : 'border-border dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50' }}">
                <label class="flex items-start gap-3 cursor-pointer">
                    <input type="checkbox" wire:model.live="agree_terms"
                           class="mt-0.5 w-5 h-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer shrink-0">
                    <span class="text-sm text-foreground dark:text-slate-300 leading-relaxed">
                        Saya menyatakan laporan ini dibuat dengan <strong class="font-semibold">itikad baik</strong> dan informasi yang diberikan adalah <strong class="font-semibold">benar</strong>. Saya memahami bahwa laporan palsu dapat dikenakan sanksi hukum.
                    </span>
                </label>
                @error('agree_terms')<p class="text-xs text-red-600 dark:text-red-400 mt-2">{{ $message }}</p>@enderror
            </div>

            <button type="submit"
                    wire:loading.attr="disabled"
                    class="w-full flex items-center justify-center gap-2.5 py-4 px-6 rounded-lg text-sm font-bold text-white bg-emerald-700 dark:bg-emerald-600 hover:bg-emerald-800 dark:hover:bg-emerald-500 shadow-sm transition-colors disabled:opacity-60 disabled:cursor-not-allowed border-0 cursor-pointer">
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
        </section>

    </form>
    @endif
</div>
