<x-frontend-layout>
    <x-slot name="title">Simulasi Pembiayaan - {{ ($company ?? \App\Models\CompanyInfo::getInfo())?->name ?? 'BPRS Bangka Belitung' }}</x-slot>

    {{-- Hero Section --}}
    <section class="relative pt-24 sm:pt-28 md:pt-32 lg:pt-36 pb-16 sm:pb-20 md:pb-24 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-700 via-emerald-600 to-emerald-500">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\\'60\\' height=\\'60\\' viewBox=\\'0 0 60 60\\' xmlns=\\'http://www.w3.org/2000/svg\\'%3E%3Cg fill=\\'none\\' fill-rule=\\'evenodd\\'%3E%3Cg fill=\\'%23ffffff\\' fill-opacity=\\'0.05\\'%3E%3Cpath d=\\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-40"></div>
            <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-400/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 sm:w-24 sm:h-24 bg-white/20 backdrop-blur-sm rounded-lg mb-6">
                <svg class="w-10 h-10 sm:w-12 sm:h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-white mb-4 sm:mb-6 tracking-tight leading-tight">
                Simulasi Pembiayaan
            </h1>
            <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-emerald-50 max-w-5xl mx-auto px-4 sm:px-6 leading-relaxed font-medium">
                Hitung estimasi angsuran pembiayaan Anda dengan mudah dan cepat.
                <span class="block mt-2 text-emerald-100">Rencanakan keuangan Anda sebelum mengajukan pembiayaan.</span>
            </p>

            {{-- Quick Stats --}}
            <div class="mt-10 flex flex-wrap justify-center gap-4 sm:gap-6">
                <div class="bg-white/10 backdrop-blur-md rounded-lg px-6 py-3 border border-white/20">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-emerald-200 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span class="text-white font-bold text-sm">Proses Cepat</span>
                    </div>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-lg px-6 py-3 border border-white/20">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-emerald-200 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span class="text-white font-bold text-sm">Sesuai Syariah</span>
                    </div>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-lg px-6 py-3 border border-white/20">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-emerald-200 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-white font-bold text-sm">Margin Kompetitif</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Main Content --}}
    <section class="py-12 sm:py-16 md:py-20 lg:py-24 bg-gradient-to-b from-muted to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 lg:gap-10">
                {{-- Calculator --}}
                <div class="lg:col-span-2 order-2 lg:order-1">
                    <livewire:frontend.financing-simulation.calculator />
                </div>

                {{-- Sidebar --}}
                <div class="space-y-4 sm:space-y-6 order-1 lg:order-2">
                    {{-- How It Works --}}
                    <div class="bg-white rounded-lg sm:rounded-lg p-5 sm:p-6 lg:p-7 shadow-sm border-2 border-border hover:shadow-sm hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center mb-4 sm:mb-5">
                            <div class="w-12 h-12 bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-lg flex items-center justify-center mr-3 shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="font-black text-foreground text-xl">Cara Menggunakan</h3>
                        </div>
                        <ol class="space-y-3 sm:space-y-4">
                            <li class="flex items-start group">
                                <span class="w-8 h-8 bg-gradient-to-br from-emerald-600 to-emerald-700 text-white rounded-lg flex items-center justify-center text-sm font-black mr-3 shrink-0 group-hover:scale-110 transition-transform duration-300">1</span>
                                <span class="text-sm sm:text-base text-secondary leading-relaxed pt-1">Pilih jenis pembiayaan yang Anda inginkan</span>
                            </li>
                            <li class="flex items-start group">
                                <span class="w-8 h-8 bg-gradient-to-br from-blue-500 to-cyan-500 text-white rounded-lg flex items-center justify-center text-sm font-black mr-3 shrink-0 group-hover:scale-110 transition-transform duration-300">2</span>
                                <span class="text-sm sm:text-base text-secondary leading-relaxed pt-1">Masukkan jumlah pembiayaan yang dibutuhkan</span>
                            </li>
                            <li class="flex items-start group">
                                <span class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 text-white rounded-lg flex items-center justify-center text-sm font-black mr-3 shrink-0 group-hover:scale-110 transition-transform duration-300">3</span>
                                <span class="text-sm sm:text-base text-secondary leading-relaxed pt-1">Pilih jangka waktu pembiayaan (tenor)</span>
                            </li>
                            <li class="flex items-start group">
                                <span class="w-8 h-8 bg-gradient-to-br from-amber-500 to-orange-500 text-white rounded-lg flex items-center justify-center text-sm font-black mr-3 shrink-0 group-hover:scale-110 transition-transform duration-300">4</span>
                                <span class="text-sm sm:text-base text-secondary leading-relaxed pt-1">Klik "Hitung Simulasi" untuk melihat hasil</span>
                            </li>
                        </ol>
                    </div>

                    {{-- Benefits --}}
                    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-lg sm:rounded-lg p-5 sm:p-6 lg:p-7 shadow-blue-200/50 border-2 border-blue-200 hover:shadow-sm hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center mb-4 sm:mb-5">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center mr-3 shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="font-black text-foreground text-xl">Keunggulan Kami</h3>
                        </div>
                        <ul class="space-y-3 sm:space-y-4">
                            @foreach([
                                ['icon' => 'M5 13l4 4L19 7', 'bg' => 'from-emerald-600 to-emerald-700', 'text' => 'Proses cepat dan mudah'],
                                ['icon' => 'M5 13l4 4L19 7', 'bg' => 'from-blue-500 to-cyan-500', 'text' => 'Margin kompetitif'],
                                ['icon' => 'M5 13l4 4L19 7', 'bg' => 'from-purple-500 to-pink-500', 'text' => 'Sesuai prinsip syariah'],
                                ['icon' => 'M5 13l4 4L19 7', 'bg' => 'from-amber-500 to-orange-500', 'text' => 'Angsuran tetap'],
                                ['icon' => 'M5 13l4 4L19 7', 'bg' => 'from-green-500 to-emerald-600', 'text' => 'Tenor fleksibel'],
                            ] as $benefit)
                            <li class="flex items-center group">
                                <div class="w-8 h-8 bg-gradient-to-br {{ $benefit['bg'] }} rounded-lg flex items-center justify-center mr-3 shrink-0 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $benefit['icon'] }}"/>
                                    </svg>
                                </div>
                                <span class="text-sm sm:text-base text-secondary font-medium">{{ $benefit['text'] }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Contact CTA --}}
                    <div class="bg-gradient-to-br from-emerald-600 via-emerald-700 to-emerald-800 rounded-lg sm:rounded-lg p-6 sm:p-7 lg:p-8 text-white shadow-emerald-500/30 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12"></div>
                        <div class="relative">
                            <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h3 class="font-black text-2xl mb-3">Tertarik dengan Pembiayaan?</h3>
                            <p class="text-emerald-50 text-sm sm:text-base mb-6 leading-relaxed">
                                Hubungi kami untuk informasi lebih lanjut atau kunjungi kantor terdekat untuk konsultasi gratis.
                            </p>
                            <a href="{{ route('contact') }}"
                               class="group inline-flex items-center justify-center w-full px-6 py-4 bg-white text-emerald-600 rounded-lg font-bold text-sm sm:text-base hover:bg-emerald-50 transition-all duration-300 active:scale-95 min-h-[56px]">
                                <svg class="w-5 h-5 mr-2 shrink-0 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Hubungi Kami Sekarang
                                <svg class="w-5 h-5 ml-2 shrink-0 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-frontend-layout>
