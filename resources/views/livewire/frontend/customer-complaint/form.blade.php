<div>
    @if($submitted)
    <!-- Success State -->
    <div class="text-center py-12" x-data x-init="$el.classList.add('animate-scale-in')">
        <div class="w-24 h-24 bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <h3 class="text-2xl text-gray-900 font-bold mb-2">Laporan Berhasil Dikirim!</h3>
        <p class="text-gray-500 mb-6">Terima kasih atas laporan Anda. Kami akan segera menindaklanjuti.</p>

        <div class="bg-emerald-50 p-6 max-w-md mx-auto mb-8 rounded-lg">
            <p class="text-xs text-emerald-600 mb-2">Nomor Tiket Anda:</p>
            <p class="text-2xl font-bold text-emerald-600 font-mono">{{ $ticketNumber }}</p>
            <p class="text-xs text-emerald-700 mt-2">Simpan nomor ini untuk melacak status laporan Anda</p>
        </div>

        <button wire:click="$set('submitted', false)" class="text-gray-500 bg-gray-100 border-0 px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-200 transition-colors">
            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Buat Laporan Baru
        </button>
    </div>
    @else
    <!-- Form -->
    <form wire:submit="submit" class="space-y-8">
        <!-- Anonymous Toggle -->
        <div class="p-6 bg-amber-50 border border-amber-200 rounded-lg">
            <label class="flex items-start cursor-pointer">
                <input type="checkbox" wire:model.live="is_anonymous" class="mt-1">
                <div class="ml-4">
                    <span class="font-semibold text-amber-700">Laporkan Secara Anonim</span>
                    <p class="text-xs text-amber-600 mt-1">Identitas Anda akan dirahasiakan. Namun, kami tidak dapat menghubungi Anda untuk informasi tambahan.</p>
                </div>
            </label>
        </div>

        <!-- Personal Info (if not anonymous) -->
        @if(!$is_anonymous)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg text-gray-900 font-bold mb-4 flex items-center">
                <span class="w-8 h-8 bg-emerald-50 flex items-center justify-center mr-3 rounded-lg">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </span>
                Informasi Pelapor
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap <span class="text-red-600">*</span></label>
                    <div class="relative">
                        <input type="text" wire:model.live="name" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-600 @error('name') border-red-500 focus:ring-red-500 @enderror">
                    </div>
                    @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email <span class="text-red-600">*</span></label>
                    <div class="relative">
                        <input type="email" wire:model.live="email" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-600 @error('email') border-red-500 focus:ring-red-500 @enderror">
                    </div>
                    @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon <span class="text-red-600">*</span></label>
                    <div class="relative">
                        <input type="text" wire:model.live="phone" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-600 @error('phone') border-red-500 focus:ring-red-500 @enderror" placeholder="08xxxxxxxxxx">
                    </div>
                    @error('phone') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Rekening/Nasabah</label>
                    <div class="relative">
                        <input type="text" wire:model.live="account_number" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-600" placeholder="Opsional">
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Identitas (KTP/SIM)</label>
                    <div class="relative">
                        <input type="text" wire:model.live="identity_number" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-600" placeholder="Opsional">
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Complaint Details -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg text-gray-900 font-bold mb-4 flex items-center">
                <span class="w-8 h-8 bg-blue-50 flex items-center justify-center mr-3 rounded-lg">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </span>
                Detail Laporan
            </h3>
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori Laporan <span class="text-red-600">*</span></label>
                        <div class="relative">
                            <div class="w-full rounded-xl border border-gray-300 overflow-hidden focus-within:ring-2 focus-within:ring-emerald-500 focus-within:border-emerald-600 @error('type') border-red-500 focus-within:ring-red-500 @enderror">
                                <select wire:model.live="type" class="w-full px-4 py-3 text-sm bg-transparent border-0 focus:outline-none">
                                    <option value="">Pilih Kategori</option>
                                    <option value="product">Produk & Layanan</option>
                                    <option value="service">Kualitas Pelayanan</option>
                                    <option value="billing">Tagihan & Pembayaran</option>
                                    <option value="technical">Kendala Teknis</option>
                                    <option value="suggestion">Saran & Masukan</option>
                                    <option value="other">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        @error('type') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Subjek <span class="text-red-600">*</span></label>
                        <div class="relative">
                            <input type="text" wire:model.live="subject" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-600 @error('subject') border-red-500 focus:ring-red-500 @enderror" placeholder="Ringkasan singkat pengaduan">
                        </div>
                        @error('subject') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi <span class="text-red-600">*</span></label>
                    <div class="relative">
                        <textarea wire:model.live="description" rows="5" maxlength="3000" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-600 @error('description') border-red-500 focus:ring-red-500 @enderror" placeholder="Jelaskan pengaduan Anda secara detail..."></textarea>
                    </div>
                    <div class="flex justify-between items-center mt-1">
                        @error('description') <p class="text-xs text-red-600">{{ $message }}</p> @else <p class="text-xs text-gray-500">Minimal 20 karakter</p> @enderror
                        <p class="text-xs {{ strlen($description) > 3000 ? 'text-red-600' : 'text-gray-500' }}">{{ strlen($description) }}/3000</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kantor Cabang <span class="text-red-600">*</span></label>
                        <div class="relative">
                            <div class="w-full rounded-xl border border-gray-300 overflow-hidden focus-within:ring-2 focus-within:ring-emerald-500 focus-within:border-emerald-600">
                                <select wire:model.live="branch_office" class="w-full px-4 py-3 text-sm bg-transparent border-0 focus:outline-none">
                                    <option value="">Pilih Cabang</option>
                                    @foreach($branchOffices as $office)
                                        <option value="{{ $office }}">{{ $office }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Kejadian</label>
                        <div class="relative">
                            <input type="date" wire:model.live="incident_date" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-600">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attachments -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg text-gray-900 font-bold mb-4 flex items-center">
                <span class="w-8 h-8 bg-purple-50 flex items-center justify-center mr-3 rounded-lg">
                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                </span>
                Lampiran Pendukung (Opsional)
            </h3>
            <div class="p-8 text-center border-2 border-dashed border-gray-300 rounded-lg">
                <input type="file" wire:model.live="attachments" multiple class="hidden" id="attachments">
                <label for="attachments" class="cursor-pointer">
                    <svg class="w-12 h-12 text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    <p class="text-gray-500 mb-1">Klik untuk upload atau drag & drop</p>
                    <p class="text-xs text-gray-500">PDF, DOC, JPG, PNG (Maks. 5MB per file)</p>
                </label>
            </div>
            @if($attachments)
            <div class="mt-4 space-y-2">
                @foreach($attachments as $index => $file)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <span class="text-xs text-gray-500">{{ $file->getClientOriginalName() }}</span>
                    <button type="button" wire:click="$set('attachments.{{ $index }}', null)" class="text-red-600 hover:text-red-700 bg-transparent border-0 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                @endforeach
            </div>
            @endif
            @error('attachments.*') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Terms -->
        <div class="p-6 bg-gray-50 rounded-lg">
            <label class="flex items-start cursor-pointer">
                <input type="checkbox" wire:model.live="agree_terms" class="mt-1 @error('agree_terms') border-red-500 @enderror">
                <div class="ml-4">
                    <span class="text-gray-500">Saya menyatakan bahwa laporan ini dibuat dengan itikad baik dan informasi yang saya berikan adalah benar.</span>
                </div>
            </label>
            @error('agree_terms') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Submit -->
        <div class="space-y-1">
            <div class="relative">
                <button type="submit" class="w-full py-4 text-sm font-semibold text-white flex items-center justify-center rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-600 hover:to-emerald-700 transition-colors" wire:loading.attr="disabled">
                    <span wire:loading.remove class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Kirim Laporan
                    </span>
                    <span wire:loading class="flex items-center">
                        <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Mengirim...
                    </span>
                </button>
            </div>
        </div>
    </form>
    @endif
</div>
