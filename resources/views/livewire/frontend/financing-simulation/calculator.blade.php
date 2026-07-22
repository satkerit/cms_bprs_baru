<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ showResult: false }">
    <!-- Header with Modern Gradient -->
    <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 via-emerald-600 px-8 py-6">
        <div class="flex items-center mb-2">
            <div class="w-12 h-12 flex items-center justify-center mr-4 bg-white/20 rounded-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl text-white font-bold">Kalkulator Simulasi</h2>
                <p class="text-white text-xs mt-1 opacity-90">Hitung estimasi angsuran pembiayaan Anda dengan mudah</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form wire:submit="calculate" class="px-8 py-6">
        <!-- Financing Type -->
        <div class="space-y-1">
            <label class="block text-sm font-semibold text-gray-700 mb-1 flex items-center">
                <span class="w-6 h-6 bg-emerald-50 flex items-center justify-center mr-2 rounded-lg">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </span>
                Pilih Jenis Pembiayaan
            </label>
            <div class="relative">
                <div class="w-full rounded-xl border border-gray-300 overflow-hidden focus-within:ring-2 focus-within:ring-emerald-500 focus-within:border-emerald-600 @error('financingType') border-red-500 focus-within:ring-red-500 @enderror">
                    <select wire:model.live="financingType" class="w-full px-4 py-3 text-sm bg-transparent border-0 focus:outline-none">
                        <option value="">-- Pilih Jenis Pembiayaan --</option>
                        @foreach($configs as $config)
                            <option value="{{ $config->id }}">{{ $config->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @if($selectedConfig)
                <div class="mt-3 p-3 bg-emerald-50 rounded-lg border border-emerald-100">
                    <p class="text-xs text-emerald-600 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-semibold">{{ $selectedConfig->getRateLabel() }}: {{ number_format($selectedConfig->margin_rate * 100, 2) }}%</span>
                        <span class="mx-1">&bull;</span>
                        <span>per tahun</span>
                    </p>
                </div>
            @endif
            @error('financingType')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Principal Amount -->
        <div class="space-y-1 mt-6">
            <label class="block text-sm font-semibold text-gray-700 mb-1 flex items-center">
                <span class="w-6 h-6 bg-blue-50 flex items-center justify-center mr-2 rounded-lg">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
                Jumlah Pembiayaan
            </label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 font-bold text-gray-500 z-10">Rp</span>
                <input
                    type="text"
                    x-init="window.formatRupiah.init($el, 'principal'); $wire.$watch('principal', v => { if (document.activeElement !== $el) $el.value = window.formatRupiah.fmt(v); })"
                    @input="window.formatRupiah.input($event.target, 'principal')"
                    @blur="window.formatRupiah.blur($el, 'principal')"
                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-600 pl-10 @error('principal') border-red-500 focus:ring-red-500 @enderror"
                    placeholder="50.000.000"
                >
            </div>
            @if($selectedConfig)
                <div class="mt-3 flex items-center justify-between text-xs">
                    <span class="text-gray-500 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                        </svg>
                        Min: Rp {{ number_format($selectedConfig->min_principal, 0, ',', '.') }}
                    </span>
                    <span class="text-gray-500 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        Max: Rp {{ number_format($selectedConfig->max_principal, 0, ',', '.') }}
                    </span>
                </div>
            @endif
            @error('principal')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tenor Selection -->
        <div class="space-y-1 mt-6">
            <label class="block text-sm font-semibold text-gray-700 mb-1 flex items-center">
                <span class="w-6 h-6 bg-purple-50 flex items-center justify-center mr-2 rounded-lg">
                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </span>
                Jangka Waktu
            </label>
            <div class="relative">
                <input
                    type="number"
                    wire:model.live="tenor"
                    min="1"
                    max="60"
                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-600 @error('tenor') border-red-500 focus:ring-red-500 @enderror"
                    placeholder="12"
                >
            </div>
            <p class="text-xs text-gray-500 flex items-center mt-1">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Jangka waktu pembiayaan: 1 - 60 bulan
            </p>
            @error('tenor')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Projected Revenue (for profit sharing only) -->
        @if($selectedConfig && $selectedConfig->isProfitSharing())
        <div class="space-y-1 mt-6">
            <label class="block text-sm font-semibold text-gray-700 mb-1 flex items-center">
                <span class="w-6 h-6 bg-blue-50 flex items-center justify-center mr-2 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </span>
                Proyeksi Pendapatan Usaha/Proyek
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 ml-2">Per Tahun</span>
            </label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 font-bold text-gray-500 z-10">Rp</span>
                <input
                    type="text"
                    x-init="window.formatRupiah.init($el, 'projectedRevenue'); $wire.$watch('projectedRevenue', v => { if (document.activeElement !== $el) $el.value = window.formatRupiah.fmt(v); })"
                    @input="window.formatRupiah.input($event.target, 'projectedRevenue')"
                    @blur="window.formatRupiah.blur($el, 'projectedRevenue')"
                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-600 pl-10 @error('projectedRevenue') border-red-500 focus:ring-red-500 @enderror"
                    placeholder="100.000.000"
                >
            </div>
            <div class="mt-3 p-3 bg-blue-50 rounded-lg border border-blue-200">
                <p class="text-xs text-blue-700 flex items-start">
                    <svg class="w-4 h-4 mr-2 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="leading-relaxed">
                        <strong>Proyeksi keuntungan tahunan</strong> dari usaha/proyek yang akan dibiayai. Bagi hasil dihitung berdasarkan proyeksi keuntungan ini, bukan dari plafond pembiayaan.
                    </span>
                </p>
            </div>
            @error('projectedRevenue')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        @endif

        <!-- Down Payment (if enabled) -->
        @if($selectedConfig && $selectedConfig->dp_enabled)
        <div class="space-y-1 mt-6">
            <label class="block text-sm font-semibold text-gray-700 mb-1 flex items-center">
                <span class="w-6 h-6 bg-amber-50 flex items-center justify-center mr-2 rounded-lg">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </span>
                Uang Muka (DP)
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 ml-2">Opsional</span>
            </label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 font-bold text-gray-500 z-10">Rp</span>
                <input
                    type="text"
                    x-init="window.formatRupiah.init($el, 'downPayment'); $wire.$watch('downPayment', v => { if (document.activeElement !== $el) $el.value = window.formatRupiah.fmt(v); })"
                    @input="window.formatRupiah.input($event.target, 'downPayment')"
                    @blur="window.formatRupiah.blur($el, 'downPayment')"
                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-600 pl-10 @error('downPayment') border-red-500 focus:ring-red-500 @enderror"
                    placeholder="10.000.000"
                >
            </div>
            @if($selectedConfig->dp_min_percentage || $selectedConfig->dp_max_percentage)
                <div class="mt-3 p-3 bg-amber-50 rounded-lg border border-amber-200">
                    <p class="text-xs text-amber-700 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>DP: {{ $selectedConfig->dp_min_percentage ?? 0 }}% - {{ $selectedConfig->dp_max_percentage ?? 100 }}% dari jumlah pembiayaan</span>
                    </p>
                </div>
            @else
                <p class="text-xs text-gray-500 flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Masukkan jumlah uang muka jika ada
                </p>
            @endif
            @error('downPayment')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-4">
            <div>
                <button
                    type="submit"
                    class="w-full px-5 py-2.5 text-sm font-bold text-white rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-700 via-emerald-600 hover:from-emerald-700 hover:to-emerald-600 transition-colors border-0"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove wire:target="calculate" class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        Hitung Simulasi
                    </span>
                    <span wire:loading wire:target="calculate" class="flex items-center justify-center">
                        <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menghitung...
                    </span>
                </button>
            </div>
            <div>
                <button
                    type="button"
                    wire:click="resetCalculator"
                    class="w-full px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors border-0 flex items-center justify-center"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Reset
                </button>
            </div>
        </div>
    </form>

    <!-- Result Section -->
    @if($result)
        <div class="p-6 border-t-4 border-emerald-100 bg-gradient-to-br from-emerald-50 via-emerald-50/30 to-emerald-50/30"
             x-data="{ show: false }"
             x-init="setTimeout(() => { show = true; showResult = true; }, 100)"
             x-show="show"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 transform translate-y-8 scale-95"
             x-transition:enter-end="opacity-100 transform translate-y-0 scale-100">

            <!-- Success Header -->
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 flex items-center justify-center mr-4 bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-2xl">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg text-gray-900 font-bold">Hasil Simulasi</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Perhitungan berhasil dilakukan</p>
                </div>
            </div>

            <!-- Financing Name Badge -->
            <div class="mb-6 flex flex-wrap items-center gap-3">
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold text-emerald-600 bg-white border-2 border-emerald-100">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                    {{ $result['config_name'] ?? 'Pembiayaan' }}
                </span>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold text-blue-700 bg-white border border-blue-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    {{ $result['rate_label'] ?? 'Margin' }} {{ number_format($result['margin_percentage'] ?? 0, 2) }}% / tahun
                </span>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold text-purple-700 bg-white border border-purple-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ number_format($result['monthly_margin_percentage'] ?? 0, 4) }}% / bulan
                </span>
            </div>

            <!-- Main Installment Card -->
            <div class="bg-gradient-to-br from-white to-emerald-50 border-2 border-emerald-100 rounded-xl mb-6 p-6 relative overflow-hidden text-center">
                <p class="text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wider">Angsuran Per Bulan</p>
                <div class="mb-2">
                    <p class="text-5xl font-black bg-gradient-to-r from-emerald-600 to-emerald-700 bg-clip-text text-transparent">
                        {{ $this->formatRupiah($result['monthly_installment']) }}
                    </p>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold text-emerald-600 bg-emerald-50">
                    <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-xs font-bold text-emerald-600">Selama {{ $result['tenor'] }} bulan</span>
                </span>
            </div>

            <!-- Detail Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                @if(isset($result['projected_revenue']) && $result['projected_revenue'] > 0)
                <div class="bg-gradient-to-br from-indigo-50 to-purple-50 border-2 border-indigo-200 rounded-xl p-4">
                    <div class="flex items-start justify-between mb-2">
                        <p class="text-xs font-semibold text-blue-700 uppercase tracking-wider">Proyeksi Pendapatan</p>
                        <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <p class="text-xs text-blue-700 mb-1">Per Tahun</p>
                    <p class="text-lg font-black text-blue-700">
                        {{ $this->formatRupiah($result['projected_revenue']) }}
                    </p>
                </div>
                @endif
                @if(isset($result['down_payment']) && $result['down_payment'] > 0)
                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 border-2 border-blue-200 rounded-xl p-4">
                    <div class="flex items-start justify-between mb-2">
                        <p class="text-xs font-semibold text-blue-700 uppercase tracking-wider">Uang Muka (DP {{ $result['dp_percentage'] }}%)</p>
                        <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <p class="text-lg font-black text-blue-700">
                        {{ $this->formatRupiah($result['down_payment']) }}
                    </p>
                </div>
                @endif
                <div class="bg-white border border-gray-200 rounded-xl p-4">
                    <div class="flex items-start justify-between mb-2">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga / Nilai Pembiayaan</p>
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <p class="text-lg font-black text-gray-900">
                        {{ $this->formatRupiah($result['original_principal']) }}
                    </p>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl p-4">
                    <div class="flex items-start justify-between mb-2">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Pokok Pembiayaan</p>
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-lg font-black text-gray-900">
                        {{ $this->formatRupiah($result['principal']) }}
                    </p>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl p-4">
                    <div class="flex items-start justify-between mb-2">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total {{ $result['rate_label'] ?? 'Margin' }}</p>
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    <p class="text-lg font-black text-gray-900">
                        {{ $this->formatRupiah($result['total_margin']) }}
                    </p>
                </div>
            </div>

            <!-- Total Payment Card -->
            <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-xl mb-6 p-6 relative overflow-hidden text-white">
                <div class="flex items-start justify-between mb-2">
                    <p class="text-xs font-bold uppercase tracking-wider opacity-90">Total Pembayaran</p>
                    <svg class="w-6 h-6 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-xs mb-1 opacity-80">Pokok + {{ $result['rate_label'] ?? 'Margin' }}</p>
                <p class="text-5xl font-black text-white">
                    {{ $this->formatRupiah($result['total_payment']) }}
                </p>
            </div>

            <!-- Disclaimer Section -->
            <div class="flex flex-col gap-4 mb-6">
                <!-- Main Disclaimer -->
                <div class="bg-amber-50 border-2 border-amber-300 rounded-xl p-4">
                    <div class="flex items-start">
                        <div class="shrink-0">
                            <div class="w-10 h-10 flex items-center justify-center bg-amber-400 rounded-xl">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-xs font-bold text-amber-700 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                Catatan Penting - Hasil Simulasi Bersifat Estimasi
                            </h4>
                            <p class="text-xs text-amber-700 mb-3">
                                Hasil simulasi ini <strong>bersifat estimasi</strong> dan <strong>tidak mengikat</strong>. Angsuran dan perhitungan sebenarnya dapat berbeda berdasarkan hasil analisis kelayakan, verifikasi dokumen, dan persetujuan pembiayaan dari pihak kami.
                            </p>
                            @if(isset($result['calculation_type']) && $result['calculation_type'] === 'profit_sharing')
                            <div class="p-3 bg-amber-100 border border-amber-200 rounded-lg">
                                <p class="text-xs font-semibold text-amber-700 mb-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                    </svg>
                                    Khusus Pembiayaan Modal Kerja:
                                </p>
                                <p class="text-xs text-amber-700">
                                    Perhitungan menggunakan <strong>proyeksi bagi hasil</strong> yang dihitung dari <strong>proyeksi keuntungan proyek</strong>, bukan dari plafond pembiayaan. Bagi hasil aktual akan ditentukan berdasarkan realisasi keuntungan usaha/proyek yang dibiayai.
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <p class="text-xs text-blue-700 flex items-start">
                        <svg class="w-4 h-4 mr-2 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="leading-relaxed">
                            Untuk informasi lebih detail dan pengajuan pembiayaan yang sebenarnya, silakan hubungi kantor kami atau kunjungi cabang terdekat untuk konsultasi dengan tim kami.
                        </span>
                    </p>
                </div>
            </div>

        </div>
    @endif
</div>
