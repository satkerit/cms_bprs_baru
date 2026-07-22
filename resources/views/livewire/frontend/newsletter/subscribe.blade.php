<div>
    <form wire:submit="subscribe" class="space-y-3">
        <div class="flex">
            <div class="flex-1 relative">
                <input
                    type="email"
                    wire:model.live="email"
                    placeholder="Masukkan email Anda"
                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-600 @error('email') border-red-500 focus:ring-red-500 @enderror"
                >
            </div>
            <div class="relative ml-2">
                <button
                    type="submit"
                    class="px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-colors"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove>Berlangganan</span>
                    <span wire:loading>
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </div>
        </div>

        @error('email')
            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </form>

    @if (session()->has('success'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 5000)"
            class="mt-3 p-3 bg-emerald-50 text-emerald-600 text-xs flex items-start rounded-lg border border-emerald-100"
        >
            <svg class="w-5 h-5 shrink-0 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif
</div>
