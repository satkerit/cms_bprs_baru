<div>
    @if (session()->has('success'))
    <div class="mb-6 p-4 sm:p-5 bg-emerald-50 flex items-start rounded-xl border border-emerald-200" x-data="{ show: true }" x-show="show" x-transition>
        <div class="w-10 h-10 bg-emerald-100 flex items-center justify-center mr-4 rounded-xl shrink-0">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div class="flex-1">
            <h4 class="font-semibold text-emerald-800">Pesan Terkirim!</h4>
            <p class="text-emerald-700 text-sm">{{ session('success') }}</p>
        </div>
        <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 bg-transparent border-0 cursor-pointer p-1 rounded-lg hover:bg-emerald-100 transition-all shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="mb-6 p-4 sm:p-5 bg-red-50 flex items-start rounded-xl border border-red-200" x-data="{ show: true }" x-show="show" x-transition>
        <div class="w-10 h-10 bg-red-100 flex items-center justify-center mr-4 rounded-xl shrink-0">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="flex-1">
            <h4 class="font-semibold text-red-800">Gagal Mengirim!</h4>
            <p class="text-red-700 text-sm">{{ session('error') }}</p>
        </div>
        <button @click="show = false" class="text-red-400 hover:text-red-600 bg-transparent border-0 cursor-pointer p-1 rounded-lg hover:bg-red-100 transition-all shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    @endif

    <form wire:submit="submit" class="space-y-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-zinc-700">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" wire:model.live="name"
                       class="block w-full rounded-xl border px-4 py-2.5 text-sm shadow-sm transition-all duration-200 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:shadow-lg focus:shadow-emerald-500/10 hover:border-zinc-300 @error('name') border-red-300 text-red-900 bg-red-50/50 @enderror border-zinc-200 text-zinc-900 bg-white"
                       placeholder="Masukkan nama lengkap">
                @error('name') <p class="mt-1.5 text-[13px] text-red-600 flex items-center gap-1"><svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg> {{ $message }}</p> @enderror
            </div>
            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-zinc-700">Email <span class="text-red-500">*</span></label>
                <input type="email" wire:model.live="email"
                       class="block w-full rounded-xl border px-4 py-2.5 text-sm shadow-sm transition-all duration-200 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:shadow-lg focus:shadow-emerald-500/10 hover:border-zinc-300 @error('email') border-red-300 text-red-900 bg-red-50/50 @enderror border-zinc-200 text-zinc-900 bg-white"
                       placeholder="nama@email.com">
                @error('email') <p class="mt-1.5 text-[13px] text-red-600 flex items-center gap-1"><svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg> {{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-zinc-700">Nomor Telepon</label>
                <input type="text" wire:model.live="phone"
                       class="block w-full rounded-xl border px-4 py-2.5 text-sm shadow-sm transition-all duration-200 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:shadow-lg focus:shadow-emerald-500/10 hover:border-zinc-300 @error('phone') border-red-300 text-red-900 bg-red-50/50 @enderror border-zinc-200 text-zinc-900 bg-white"
                       placeholder="08xxxxxxxxxx">
                @error('phone') <p class="mt-1.5 text-[13px] text-red-600 flex items-center gap-1"><svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg> {{ $message }}</p> @enderror
            </div>
            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-zinc-700">Subjek <span class="text-red-500">*</span></label>
                <div class="relative">
                    <select wire:model.live="subject"
                            class="block w-full rounded-xl border px-4 py-2.5 text-sm shadow-sm transition-all duration-200 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:shadow-lg focus:shadow-emerald-500/10 hover:border-zinc-300 appearance-none pr-10 @error('subject') border-red-300 text-red-900 bg-red-50/50 @enderror border-zinc-200 text-zinc-900">
                        <option value="">Pilih Subjek</option>
                        <option value="informasi_produk">Informasi Produk</option>
                        <option value="pengaduan">Pengaduan</option>
                        <option value="saran">Saran</option>
                        <option value="kerjasama">Kerjasama</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-zinc-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
                @error('subject') <p class="mt-1.5 text-[13px] text-red-600 flex items-center gap-1"><svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg> {{ $message }}</p> @enderror
            </div>
        </div>

        <div class="space-y-1.5">
            <label class="block text-sm font-semibold text-zinc-700">Pesan <span class="text-red-500">*</span></label>
            <textarea wire:model.live="message" rows="5"
                      class="block w-full rounded-xl border px-4 py-2.5 text-sm shadow-sm transition-all duration-200 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:shadow-lg focus:shadow-emerald-500/10 resize-y min-h-[120px] hover:border-zinc-300 @error('message') border-red-300 text-red-900 bg-red-50/50 @enderror border-zinc-200 text-zinc-900 bg-white"
                      placeholder="Tulis pesan Anda di sini..."></textarea>
            @error('message') <p class="mt-1.5 text-[13px] text-red-600 flex items-center gap-1"><svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg> {{ $message }}</p> @enderror
        </div>

        <div>
            <button type="submit"
                    class="w-full min-h-[52px] px-8 py-4 text-sm font-semibold text-white flex items-center justify-center rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-700 hover:to-emerald-600 transition-all duration-200 shadow-lg shadow-emerald-600/25 hover:shadow-emerald-600/35 btn-shine btn-press focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-emerald-500 disabled:opacity-60 disabled:cursor-not-allowed"
                    wire:loading.attr="disabled">
                <span wire:loading.remove class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Kirim Pesan
                </span>
                <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Mengirim...
                </span>
            </button>
        </div>
    </form>
</div>
